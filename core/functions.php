<?php

function JSON($obj=[]) {	
	header("Content-type: application/json;charset=utf8");
	if ($obj === null)
		$obj = [];
	echo json_encode($obj);
}

function ERRORdb($error){
	$data = Array();
	$data['status'] = 500;
	$data['error'] = $error; 
	JSON($data);
}

// conexio a la base de datos
function DB() {
	$db = new MysqliDb (Array (
		'host' => 'localhost',
		'username' => 'root', 
		'password' => '',
		'db'=> 'prueba',
		'charset' => 'utf8'));
	return $db;
}

function setTimeZone() {
	date_default_timezone_set('America/Mazatlan');
}

function der2pem($der_data, $type='CERTIFICATE') {
   $pem = chunk_split(base64_encode($der_data), 64, "\n");
   $pem = "-----BEGIN ".$type."-----\n".$pem."-----END ".$type."-----\n";
   return $pem;
}


// metodo get normal
function get($pos) {
	if (isset($_GET[$pos])) {
		$g = $_GET[$pos];
		$g = str_replace('"', "''", $g);
		$g = str_replace(';', "", $g);
		return $g;
	}else{
		return null;
	}

	
}


// se utiliza para obtenner respuesta mediante un id
function getReq($pos) {
	if (!isset($_GET[$pos])) {
		$data = [];
		$data['status'] = 500;
		$data['mensaje'] = '('.$pos.') not found';
		JSON($data);
		exit;
	}

	$g = $_GET[$pos];
	if (empty($g)) {
		$data = [];
		$data['status'] = 500;
		$data['mensaje'] = '('.$pos.') is required.';
		JSON($data);
		exit;
	}


	$g = str_replace('"', "''", $g);
	$g = str_replace(';', "", $g);
	// $g = mb_convert_encoding($g, 'UTF-8', 'UTF-8');
	// $g = htmlentities($g, ENT_QUOTES, 'UTF-8');
	// $g = addslashes($g);

	return $g;
}

function postReq($pos) {
	if (!isset($_POST[$pos])) {
		$data = [];
		$data['status'] = 500;
		$data['mensaje'] = '('.$pos.') not found';
		JSON($data);
		exit;
	}

	$g = $_POST[$pos];
	if (empty($g)) {
		$data = [];
		$data['status'] = 500;
		$data['mensaje'] = '('.$pos.') is required.';
		JSON($data);
		exit;
	}

	$g = str_replace('"', "''", $g);
	$g = str_replace(';', "", $g);
	// $g = mb_convert_encoding($g, 'UTF-8', 'UTF-8');
	// $g = htmlentities($g, ENT_QUOTES, 'UTF-8');
	// $g = addslashes($g);

	return $g;
}


// function mysql_real_escape_string($str)
// {
//     return "'".str_replace("'", "''", $str)."'";
// }


function post($pos) {
	if (isset($_POST[$pos])) {
		$g = $_POST[$pos];
		return $g;
	}else{
		return NULL;
	}
}

class Err {
	public $message;
	public $status;

	function __construct($message){
		$this->status = 500;
		$this->message = $message;
	}
}

class Success {
	public $message;
	public $status;
	public $data;

	function __construct($message,$data){
		$this->status = 200;
		$this->message = $message;
		if(!empty($data))
			$this->data = $data;
	}
}