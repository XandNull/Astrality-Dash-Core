<?php

include "../../serversdata/incl/lib/connection.php";

$username = $_GET['username'];
$password = $_GET['password'];
$secret = $_GET['secret'];

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}

if($secret != "pTKc8E8ZEa"){
	exit();
}

$query = $db->prepare("SELECT id FROM pktop WHERE username LIKE :username");
$query->execute([':username' => $username]);
if($query->rowCount() == 1){
	$query = $db->prepare("SELECT id FROM pktop WHERE password = :password AND username = :username");
	$query->execute([':password' => $password, ':username' => $username]);
	if($query->rowCount() == 1){
		$success = array('1' => 'checked', '2' => $username);
		echo json_encode($success);
	}else{
		$error = array('1' => 'password', '2' => "sory");
		echo json_encode($error);
		exit();
	}
}else{
	$error = array('1' => 'username', '2' => "sory");
	echo json_encode($error);
	exit();
}