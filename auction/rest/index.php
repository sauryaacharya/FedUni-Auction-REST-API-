<?php
require_once 'RestApi.php';
define("BASE_PATH", dirname(__DIR__));
define("DS", DIRECTORY_SEPARATOR);
require_once(BASE_PATH . DS . "lib" . DS . "Loader.php");
$load = new Loader();
$load->loadClass();
$api = new RestApi($_REQUEST["request"]);
echo $api->executeApi();