<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);


$sinbad_service_handlers = array();
# an associative array mapping  type codes to a handler function

require('service/common.php');
require('service/install.php');
require('service/usage.php');
require('service/ping.php');
require('service/milestone.php');

$db_conn = connect_to_db();
  
function main() {
  global $sinbad_service_handlers;
  
  $service_type = get_request('type');

  if ($service_type 
        && valid_version_token(get_request('version'), 
                               get_request('token'))
        && db_is_operational()
        && isset($sinbad_service_handlers[$service_type])) {
    $sinbad_service_handlers[$service_type]();
  } else {
    header("HTTP/1.0 404 Not Found");
    die("Failure");    
  }
  
}


function valid_version_token($version, $token) {
  if (! ($version && $token)) { return false; }
  
  return $token == hash( "md5", $version );
}


function connect_to_db() {
  global $sinbad_setup;
  $servername = $sinbad_setup['db_server'];
  $dbname   = $sinbad_setup['db_name'];
  $username = $sinbad_setup['db_user'];
  $password = $sinbad_setup['db_password'];
  
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  } catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
  }
}



main();

?>