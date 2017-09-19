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


function add_colon($s) {
  return ":$s";
}


# field_names is list of strings
# assumes hash_order is *all* the field_names as given
function prep_select_or_insert($table_name, $field_names, $sql_vals) {
  $field_names_commas = implode(",", $field_names);
  $field_names_colons = implode(",", array_map(add_colon, $field_names));

  $sth = prep_and_execute("SELECT id FROM $table_name WHERE hash=md5(concat($field_names_colons))", $sql_vals);
  $row = $sth->fetch();
  $sth->closeCursor();
  
  if ($row) { return intval($row['id']); }
  
  return prep_and_execute("INSERT INTO $table_name ($field_names_commas, hash) VALUES ($field_names_colons,md5(concat($field_names_colons)))", $sql_vals, true);
}



function find_or_add_src($full_url, $format, $file_entry) {
  $sql_vals = array(':full_url' => $full_url,
                    ':data_format' => $format,
                    ':file_entry' => $file_entry);
  
  # first check if there
  $sth = prep_and_execute("SELECT id FROM usage_sources WHERE hash=md5(concat(:full_url,:data_format,:file_entry))", $sql_vals);
  $row = $sth->fetch();
  $sth->closeCursor();
  
  if ($row) { return intval($row['id']); }
  
  return 
    prep_and_execute("INSERT INTO usage_sources (full_url, data_format, file_entry, hash) VALUES (:full_url,:data_format,:file_entry,md5(concat(:full_url,:data_format,:file_entry)))",
                   $sql_vals, true);
}



function find_or_add_load($env_id, $src_id, $data_options, $status) {
  $sql_vals = array(':env_id' => $env_id,
                      ':source_id' => $src_id,
                      ':data_options' => $data_options,
                      ':status' => $status);
  
  # first check if there
  $sth = prep_and_execute("SELECT id FROM usage_loads WHERE hash=md5(concat(:env_id,:source_id,:data_options,:status))",
                   $sql_vals);
  $row = $sth->fetch();
  $sth->closeCursor();
  
  if ($row) { return intval($row['id']); }
  
  return 
    prep_and_execute("INSERT INTO usage_loads (env_id, source_id, data_options, status, hash) VALUES (:env_id,:source_id,:data_options,:status,md5(concat(:env_id,:source_id,:data_options,:status)))",
                   $sql_vals, true);
}


function find_or_add_sample($env_id, $src_id, $sample_amt, $sample_seed) {
  return prep_select_or_insert("usage_samples",
                               array("env_id", "source_id", "sample_amt", "sample_seed"),
                               array(':env_id' => $env_id,
                                      ':source_id' => $src_id,
                                      ':sample_amt' => $sample_amt,
                                      ':sample_seed' => $sample_seed));
}


function find_or_add_fetch($env_id, $src_id, $field_paths, $base_path, $select_option, $got_data) {
  if ($got_data) { $got_data = 1; } else { $got_data = 0; }
  
  return prep_select_or_insert("usage_fetches",
                               array("env_id","source_id","field_paths","base_path","select_option","got_data"),
                               array(':env_id' => $env_id,
                                     ':source_id' => $src_id,
                                     ':field_paths' => $field_paths,
                                     ':base_path' => $base_path,
                                     ':select_option' => $select_option,
                                     ':got_data' => $got_data));  
}



function add_timestamp($type, $foreign_id) {
  $sql_vals = array(':type' => $type,
                    ':usage_id' => $foreign_id,
                    ':timestamp' => time());
  return prep_and_execute("INSERT INTO usage_timestamps (type, usage_id, timestamp) VALUES (:type, :usage_id, :timestamp)", $sql_vals, true);
}


function handle_usage() {  
  $success = false;
  $msg = '';
  
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
        $sample_id = find_or_add_sample($env_id, $src_id, $sample_amt, $sample_seed);
        $success = is_int(add_timestamp("sample", $sample_id));        
      }
  } elseif ($usage_type == 'fetch') {
      list($field_paths, $base_path, $select, $got_data)
        = array_map(get_request, array('field_paths', 'base_path', 'select', 'got_data'));
      if ($full_url && $format && $got_data) {
        $fetch_id = find_or_add_fetch($env_id, $src_id, $field_paths, $base_path, $select, $got_data);
        $success = is_int(add_timestamp("fetch", $fetch_id));        
      }
  } 
  
  if ($success) {
    header('Content-Type: application/json');
    echo json_encode(array('type' => 'usage', 'status' => 'ok', 'message' => $msg));
    die();
  } else {
    header("HTTP/1.0 404 Not Found");
    die("Failure");         
  }
}


$sinbad_service_handlers['usage'] = handle_usage;

?>