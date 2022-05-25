<?php
session_start();
$_SESSION["accountID"] = 0;
require "../src/dashboardLib.php";
$dl = new dashboardLib();
if(isset($_SERVER["HTTP_REFERER"])){
	header('Location: ' . $_SERVER["HTTP_REFERER"]);
}
$dl->printLoginBox("<p class='mt-3 card w-50 p-3 mx-auto text-center'>You are now logged out. <a href='..'>Click here to continue</a></p>");
?>