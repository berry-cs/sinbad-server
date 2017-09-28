<?php

/*
service
type: milestone 

parameters:
 version : ...
 token   : <md5 hash of version>
 os      : ...
 lang    : ...
 run_count
 first_use_ts
 last_use_ts
*/


function handle_milestone() {
  global $db_conn;
  
  list($version, $os, $lang) 
    = array_map( get_request, array('version', 'os', 'lang') );
  $env_id = find_or_add_env($os, $lang, $version);
      
  list($run_count, $first_use_ts, $last_use_ts)
    = array_map(get_request, array('run_count', 'first_use_ts', 'last_use_ts'));
  
  $sql = "INSERT INTO milestones (env, run_count, first_use_ts, last_use_ts) VALUES ('$env_id', '$run_count', '$first_use_ts', '$last_use_ts')";
  $db_conn->exec($sql);
  
  $resp = array('type' => 'milestone', 'status' => 'ok');
  
  if ($run_count == 500) {
    $resp['launch_url'] = FEEDBACK_REQUEST_URL;
  }
  
  
  header('Content-Type: application/json');
  echo json_encode($resp);
  die();
}


$sinbad_service_handlers['milestone'] = handle_milestone;

?>