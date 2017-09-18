<?php

$sinbad_setup = array();

require('config.php');


function get_request($param_name, $filter = FILTER_SANITIZE_STRING) {
  $v = filter_input(INPUT_POST, $param_name, $filter);
  if (!$v) 
    $v = filter_input(INPUT_GET, $param_name, $filter);
  return $v;
}



function db_is_operational() {
  global $db_conn;
  try {
    $sql = "SELECT operational FROM setup";
      foreach ($db_conn->query($sql) as $row) {
        return $row[0] == '1'; 
      }      
  } catch(PDOException $e) {
    return false;
  }
}


# returns the database id for the row in the 'envs' table 
# that matches given $os, $lang. If the pair is not currently 
# in the table, adds it and returns the new id.
#
# assume $os, $lang are sanitized
function find_or_add_env($os, $lang, $version) {
  global $db_conn;
  
  # first check if there
  $sql = "SELECT id FROM envs WHERE os='$os' AND lang='$lang' AND version='$version'";
  foreach ($db_conn->query($sql) as $row) {
    return $row[0]; 
  }  
  
  # otherwise add a row
  $sql = "INSERT INTO envs (os, lang, version) VALUES ('$os', '$lang', '$version')";
  $db_conn->exec($sql);
  $last_id = $db_conn->lastInsertId();
  return $last_id;
}



?>