<?php
session_start();
include "../../serversdata/incl/lib/connection.php";
require "../src/dashboardLib.php";
$dl = new dashboardLib();
require "../../serversdata/incl/lib/generatePass.php";
$gp = new generatePass();
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
	$dl->printLoginBox("<p class='mt-3 card w-50 p-2 mx-auto text-center'>You are already logged in. <a href='..'>Click here to continue</a></p>");
	exit();
}
if(isset($_POST["userName"]) AND isset($_POST["password"])){
	require_once "../../serversdata/incl/lib/mainLib.php";
	$gs = new mainLib();
	$userName = $_POST["userName"];
	$password = $_POST["password"];
	$valid = $gp->isValidUsrname($userName, $password);
	if($valid != 1){
		$dl->printLoginBoxInvalid();
		exit();
	}
	$accountID = $gs->getAccountIDFromName($userName);
	if($accountID == 0){
		$dl->printLoginBoxError("Invalid accountID");
		exit();
	}
	$_SESSION["accountID"] = $accountID;
	if(isset($_POST["ref"])){
		header('Location: ' . $_POST["ref"]);
	}elseif(isset($_SERVER["HTTP_REFERER"])){
		header('Location: ' . $_SERVER["HTTP_REFERER"]);
	}
	
	$ip = $gs->getIP();
	$time = time();
	$query = $db->prepare("SELECT userID FROM users WHERE extID = :id");
	$query->execute([':id' => $accountID]);
	if ($query->rowCount() > 0) {
		$userID = $query->fetchColumn();
	} else {
		$query = $db->prepare("INSERT INTO users (isRegistered, extID, userName, IP, lastPlayed)
		                                  VALUES (1, :id, :userName, :ip, :lastPlayed)");
		$query->execute([':id' => $accountID, ':userName' => $userName, ':ip' => $ip, 'lastPlayed' => $time]);
		$userID = $db->lastInsertId();
	}
	
	$dl->printLoginBox("<p class='mt-3 card w-50 mx-auto p-2 text-center'>You are now logged in. <a href='..'>Please click here to continue.</a></p>");
}else{
	$loginbox = '<form action="" method="post" class="text-center card w-50 mx-auto"><br>
							<br><div class="form-group">
								<input type="text" class="form-control text-center mx-auto w-75" id="usernameField" name="userName" placeholder="Enter username">
							</div><br>
							<div class="form-group">
								<input type="password" class="form-control text-center mx-auto w-75" id="passwordField" name="password" placeholder="Password">
							</div><br>';
	if(isset($_SERVER["HTTP_REFERER"])){
		$loginbox .= '<input type="hidden" name="ref" value="'.$_SERVER["HTTP_REFERER"].'">';
	}
	$loginbox .= '<button type="submit" class="btn text-white w-75 mx-auto" style="background-color: #b598f5;">Log In</button><br><br></form>';
	$dl->printLoginBox($loginbox);
}
?>