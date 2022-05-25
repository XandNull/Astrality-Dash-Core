<?php

include "../../serversdata/incl/lib/connection.php";

$username = $_GET['username'];
$password = $_GET['password'];
$secret = $_GET['secret'];
$hashpass = md5($password);

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

$newtime = time() - 30;
$query6 = $db->prepare("SELECT count(*) FROM actions WHERE type = '1' AND timestamp > :time AND value2 = :ip");
$query6->execute([':time' => $newtime, ':ip' => $ip]);
if($query6->fetchColumn() > 5){
	$error = array('1' => 'Login Failed...');
	echo json_encode($error);
	exit();
}

$query = $db->prepare("SELECT id FROM pktop WHERE username LIKE :username");
$query->execute([':username' => $username]);
if($query->rowCount() == 1){
	$query = $db->prepare("SELECT id FROM pktop WHERE password = :password AND username = :username");
	$query->execute([':password' => $hashpass, ':username' => $username]);
	if($query->rowCount() == 1){
		$success = array('1' => 'Successfuly', '2' => $hashpass);
		echo json_encode($success);
	}else{
		$error = array('1' => 'Error: Invalid Password', '2' => '');
		echo json_encode($error);
		exit();
	}
}else{
	$error = array('1' => 'Error: Username not found', '2' => '');
	echo json_encode($error);
	exit();
}