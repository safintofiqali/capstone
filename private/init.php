<?php

define("PRIVATE_PATH",dirname(__FILE__));
define("PROJECT_PATH",dirname(PRIVATE_PATH));
define("PUBLIC_PATH",PROJECT_PATH . '/public_html');
define("SHARED_PATH", PRIVATE_PATH . '/shared');

// define("WWW_ROOT",'');

$index = strpos($_SERVER['SCRIPT_NAME'],'/public_html') + 12;
$url = substr($_SERVER['SCRIPT_NAME'],0,$index);
define("WWW_ROOT" , $url);

require_once("database.php");
require_once("query_functions.php");

$conn = db_connect();

require_once("functions.php");
// require_once("validation_functions.php");


?>