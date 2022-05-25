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

$query = $db->prepare("SELECT count(*) FROM pktop WHERE username LIKE :username");
$query->execute([':username' => $username]);
if ($query->fetchColumn() > 0) {
	$error = array('1' => 'Register Failed...');
	echo json_encode($error);
	exit();
}
	
$hashpass = md5($password);
$query = $db->prepare("INSERT INTO pktop (username, password, secret, registerDate, ip) VALUES (:username, :password, :secret, :registerDate, :ip)");
$query->execute([':username' => $username, ':password' => $hashpass, ':secret' => $secret, ':registerDate' => time(), ':ip' => $ip]);
$success = array('1' => 'Register Successfuly!');
echo json_encode($success);