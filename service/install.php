<?php

/*
service
type: install 

parameters:
 version : ...
 token   : <md5 hash of version>
 os      : ...
 lang    : ...
 first_use_ts : <###>
*/


function handle_install() {
  global $sinbad_setup, $db_conn;
  
  list($version, $os, $lang, $first_use_ts) 
    = array_map( get_request, array('version', 'os', 'lang', 'first_use_ts') );
  $env_id = find_or_add_env($os, $lang, $version);
  
  $sql = "INSERT INTO installs (env, first_use_ts) VALUES ('$env_id', '$first_use_ts')";
  $db_conn->exec($sql);
    
  die("OK");
}


$sinbad_service_handlers['install'] = handle_install;

?>