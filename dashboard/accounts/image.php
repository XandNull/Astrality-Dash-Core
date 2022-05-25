<?php
session_start();
require "../src/dashboardLib.php";
$dl = new dashboardLib();
require "../../serversdata/incl/lib/connection.php";
if(!isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
	$dl->printBox('</br><p>Login in account!<br><p>');
	exit();
}
if(!empty($_FILES['avatar'])){
	$type = $_FILES['avatar']['type'];
	$size = $_FILES['avatar']['size'];
	#blecklist
	$accountID = $_SESSION["accountID"];
	$blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm");
	foreach ($blacklist as $item)
		if(preg_match("/$item\$/i", $_FILES['avatar']['name'])){
			exit("<div style='margin-top: 20%; background-color: white; padding: 20px; border-radius: 5px;' align='center'>WT...WTF?! <a href='settings.php'>Try Again.</a>");
		} 
	#allowed type
	if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/gif") && ($type != "image/png")){
		exit("<div style='margin-top: 20%; background-color: white; padding: 20px; border-radius: 5px;' align='center'>Invalid type. <a href='settings.php'>Try Again.</a>");
	}
	#size
	if ($size > 10240000){
		exit("<div style='margin-top: 20%; background-color: white; padding: 20px; border-radius: 5px;' align='center'>The file is too large. <a href='settings.php'>Try Again.</a>");
	}
	#wtf system
    $path = 'avatars/' . $accountID;
    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $path)) {
		exit("<div style='margin-top: 20%; background-color: white; padding: 20px; border-radius: 5px;' align='center'>Something is wrong. <a href='settings.php'>Try Again.</a>");
    }
	$query = $db->prepare("UPDATE users SET avatar=:avatar WHERE extID=:id");	
	$query->execute([':avatar' => $path, ':id' => $accountID]);
	exit("<div style='margin-top: 20%; background-color: white; padding: 20px; border-radius: 5px;' align='center'>Avatar Changed. <a href='settings.php'>Back.</a>");
}
if(!empty($_FILES['banner'])){
	$type = $_FILES['banner']['type'];
	$size = $_FILES['banner']['size'];
	$accountID = $_SESSION["accountID"];
	#blecklist
	$blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm");
	foreach ($blacklist as $item)
		if(preg_match("/$item\$/i", $_FILES['banner']['name'])){
			exit("<div style='margin-top: 20%; background-color: white; padding: 20px; border-radius: 5px;' align='center'>No! <a href='settings.php'>Try Again.</a>");
		} 
	#allowed type
	if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/gif") && ($type != "image/png")){
		exit("<div style='margin-top: 20%; background-color: white; padding: 20px; border-radius: 5px;' align='center'>Invalid type. <a href='settings.php'>Try Again.</a>");
	}
	#size
	if ($size > 10240000){
		exit("<div style='margin-top: 20%; background-color: white; padding: 20px; border-radius: 5px;' align='center'>The file is too large. <a href='settings.php'>Try Again.</a>");
	}
	#wtf system
    $path = 'banners/' . $accountID;
    if (!move_uploaded_file($_FILES['banner']['tmp_name'], $path)) {
		exit("<div style='margin-top: 20%; background-color: white; padding: 20px; border-radius: 5px;' align='center'>Something is wrong. <a href='settings.php'>Try Again.</a>");
    }
	$query = $db->prepare("UPDATE users SET banner=:banner WHERE extID=:id");	
	$query->execute([':banner' => $path, ':id' => $accountID]);
	exit("<div style='margin-top: 20%; background-color: white; padding: 20px; border-radius: 5px;' align='center'>Banner Changed. <a href='settings.php'>Back.</a>");
}
?>