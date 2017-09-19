<?php

/*
service
type: usage 

parameters:
 version : ...
 token   : <md5 hash of version>
 os      : ...
 lang    : ...
*/



function bind_values($sth, $arr) {
  foreach ($arr as $k => $v) {
    if (is_int($v))
      $sth->bindValue($k, $v, PDO::PARAM_INT); 
    elseif (is_bool($v))
      $sth->bindValue($k, $v, PDO::PARAM_BOOL);
    elseif (is_null($v))
      $sth->bindValue($k, "");
    else
      $sth->bindValue($k, $v);
  }
}

# returns the PDOStatement having executed it -- should call closeCursor() when done with it, unless 
#  is_insert = true, in which case the id of that last insert operation is produced
function prep_and_execute($sql, $sql_vals, $is_insert = false) {
  global $db_conn;
  $sth = $db_conn->prepare($sql);
  bind_values($sth, $sql_vals);
  $sth->execute();
  if ($is_insert) { 
    $sth->closeCursor();
    return intval($db_conn->lastInsertId());
  } else {
    return $sth;
  }
}




function find_or_add_src($full_url, $format, $file_entry) {
/*
  global $db_conn;
  
  # first check if there
  $sql = "SELECT id FROM usage_sources WHERE hash=md5(concat('$full_url','$format', '$file_entry'))";
  foreach ($db_conn->query($sql) as $row) {
    return intval($row[0]);
  }  
  
  # otherwise add a row
  $sql = "INSERT INTO usage_sources (full_url, data_format, file_entry, hash) VALUES ('$full_url','$format', '$file_entry',md5(concat('$full_url','$format', '$file_entry')))";
  $db_conn->exec($sql);
  $last_id = $db_conn->lastInsertId();
  return intval($last_id);
  */
  $sql_vals = array(':full_url' => $full_url,
                    ':format' => $format,
                    ':file_entry' => $file_entry);
  
  # first check if there
  $sth = prep_and_execute("SELECT id FROM usage_sources WHERE hash=md5(concat(:full_url,:format, :file_entry))", $sql_vals);
  $row = $sth->fetch();
  $sth->closeCursor();
  
  if ($row) { return intval($row['id']); }
  
  return 
    prep_and_execute("INSERT INTO usage_sources (full_url, data_format, file_entry, hash) VALUES (:full_url,:format,:file_entry,md5(concat(:full_url,:format,:file_entry)))",
                   $sql_vals, true);
}



function find_or_add_load($env_id, $src_id, $data_options, $status) {
  $sql_vals = array(':env_id' => $env_id,
                      ':src_id' => $src_id,
                      ':data_options' => $data_options,
                      ':status' => $status);
  
  # first check if there
  $sth = prep_and_execute("SELECT id FROM usage_loads WHERE hash=md5(concat(:env_id,:src_id,:data_options,:status))",
                   $sql_vals);
  $row = $sth->fetch();
  $sth->closeCursor();
  
  if ($row) { return intval($row['id']); }
  
  return 
    prep_and_execute("INSERT INTO usage_loads (env_id, src_id, data_options, status, hash) VALUES (:env_id,:src_id,:data_options,:status,md5(concat(:env_id,:src_id,:data_options,:status)))",
                   $sql_vals, true);
}


function find_or_add_sample($src_id, $sample_amt, $sample_seed) {
  $sql_vals = array(':source_id' => $src_id,
                    ':sample_amt' => $sample_amt,
                    ':sample_seed' => $sample_seed);
  
  $sth = prep_and_execute("SELECT id FROM usage_samples WHERE hash=md5(concat(:source_id,:sample_amt,:sample_seed))", $sql_vals);
  $row = $sth->fetch();
  $sth->closeCursor();
  
  if ($row) { return intval($row['id']); }
  
  return prep_and_execute("INSERT INTO usage_samples (source_id, sample_amt, sample_seed, hash) VALUES (:source_id,:sample_amt,:sample_seed,md5(concat(:source_id,:sample_amt,:sample_seed)))", $sql_vals, true);
}



function add_timestamp($type, $foreign_id) {
  $sql_vals = array(':type' => $type,
                    ':usage_id' => $foreign_id,
                    ':timestamp' => time());
  return prep_and_execute("INSERT INTO usage_timestamps (type, usage_id, timestamp) VALUES (:type, :usage_id, :timestamp)", $sql_vals, true);
}


function handle_usage() {  
  $success = false;
  
  list($version, $os, $lang) 
    = array_map( get_request, array('version', 'os', 'lang') );
  $env_id = find_or_add_env($os, $lang, $version);

  list($usage_type,
       $full_url, 
       $format,      // 'csv', ... 
       $file_entry)  // maybe empty/null string
    = array_map(get_request, array('usage_type', 'full_url', 'format', 'file_entry'));
  
  if ($usage_type)
    $src_id = find_or_add_src($full_url, $format, $file_entry);
  
  if ($usage_type == 'load') {
      list($status,      // 'success' / 'failure'
           $data_options)     // data factory options (JSON object)
        = array_map(get_request, array('status', 'data_options') );

      if ($full_url && $format && $status) {  // these required    
        $load_id = find_or_add_load($env_id, $src_id, $data_options, $status);
        $success = is_int(add_timestamp("load", $load_id));
      }
  } elseif ($usage_type == 'sample') {
      list($sample_amt, $sample_seed) = array_map( get_request, array('sample_amt', 'sample_seed') );

      if ($full_url && $format && $sample_amt) {  // these required    
        $sample_id = find_or_add_sample($src_id, $sample_amt, $sample_seed);
        $success = is_int(add_timestamp("sample", $sample_id));        
      }
  } elseif ($usage_type == 'fetch') {
    
  } 
  
  if ($success) {
    header('Content-Type: application/json');
    echo json_encode(array('type' => 'usage', 'status' => 'ok'));
    die();
  } else {
    header("HTTP/1.0 404 Not Found");
    die("Failure");         
  }
}


$sinbad_service_handlers['usage'] = handle_usage;

?>