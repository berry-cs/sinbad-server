<?php

/*
service
type: ping 

parameters:
 version : ...
 token   : <md5 hash of version>
 os      : ...
 lang    : ...
*/


function handle_ping() {
  
  list($version, $os, $lang) 
    = array_map( get_request, array('version', 'os', 'lang') );
      
  header('Content-Type: application/json');
  echo json_encode(array('type' => 'ping', 'status' => 'ok'));
  die();
}


$sinbad_service_handlers['ping'] = handle_ping;

?>