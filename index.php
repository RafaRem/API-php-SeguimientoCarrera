<?php
define ('SITE_ROOT', realpath(dirname(__FILE__)));
chdir( dirname(__DIR__) );

define("SYS_PATH", "core/");
define("APP_PATH", "app/");

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');


require SYS_PATH."Router.php";
require SYS_PATH."MysqliDb.php";
require SYS_PATH."functions.php";
require APP_PATH."routes.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['u'])) {
	$_GET['u'] = 'index';
}

$url = $_GET['u'];

try {
	$action = Router::getAction($url);

	$controllerName = $action["controller"];
	$method = $action["method"];

	require APP_PATH."controllers/".$controllerName.".php";

	$controller = new $controllerName();
	$controller->$method();

} catch (Exception $e) {
	echo $e->getMessage();
}