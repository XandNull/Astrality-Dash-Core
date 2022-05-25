<?php
session_start();
include "../../serversdata/incl/lib/connection.php";
require_once "../../serversdata/incl/lib/exploitPatch.php";
$ep = new exploitPatch();
require "../src/dashboardLib.php";
$dl = new dashboardLib();

function ripchk($type, $userName, $ip) {
	require_once "../../vkbot/connect.php";
	$vk_title = '📙 Регистрация аккаунта';
	
	if($type == 1){
		$vk->sendMessage(1, $vk_notifiers, "$vk_title <br>✔ $userName ($ip) зарегистрировался на сервере!");
	}else{
		$vk->sendMessage(1, $vk_notifiers, "$vk_title <br>❌ Неудачная попытка регистрации $userName ($ip)!");
	}
	exit($type);
}

if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
	$dl->print("<p class='mt-5 card w-50 p-2 mx-auto text-center'>You are already logged in. <a href='..'>Click here to continue</a></p>");
	exit();
}

if(isset($_POST["userName"]) AND isset($_POST["password"]) AND isset($_POST["email"])){
	require_once "../../serversdata/incl/lib/mainLib.php";
	$gs = new mainLib();
	
	$ip = $gs->getIP();
	$userName = $ep->remove($_POST["userName"]);
	$password = $ep->remove($_POST["password"]);
	$email = $ep->remove($_POST["email"]);
	$key = $ep->remove($_POST["key"]);
	$time = time();
	$secret = '';
	
	if (isset($_POST["captcha"]) AND $_POST["captcha"] != "" AND $_SESSION["code"] == $_POST["captcha"]) {
		
		if (strlen($userName) < 3 OR strlen($userName) > 15) {
			$dl->printLoginBox("<p class='mt-5 card w-50 p-2 mx-auto text-center'>Small or long username. <a href='..'>Click here to continue</a></p>");
			ripchk("", $userName, $ip);
		} elseif (strlen($password) < 6 OR strlen($password) > 20) {
			$dl->print("<p class='mt-5 card w-50 p-2 mx-auto text-center'>Small or long password. <a href='..'>Click here to continue</a></p>");
			ripchk("", $userName, $ip);
		}
		
		$query = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
		$query->execute([':userName' => $userName]);
		if ($query->fetchColumn() > 0) {
			$dl->print("<p class='mt-5 card w-50 p-2 mx-auto text-center'>Username already exists. <a href='..'>Click here to continue</a></p>");
			ripchk("", $userName, $ip);
		}
		
		$query = $db->prepare("SELECT COUNT(*) FROM accounts WHERE email LIKE :email");
		$query->execute([':email' => $email]);
		if ($query->fetchColumn() > 0) {
			$dl->print("<p class='mt-5 card w-50 p-2 mx-auto text-center'>Email already exists. <a href='..'>Click here to continue</a></p>");
			ripchk("", $userName, $ip);
		}
		
		$hashpass = password_hash($password, PASSWORD_DEFAULT);
		$query = $db->prepare("INSERT INTO accounts (userName, password, email, secret, saveData, registerDate, saveKey) VALUES (:userName, :password, :email, :secret, '', :time, '')");
		$query->execute([':userName' => $userName, ':password' => $hashpass, ':email' => $email, ':secret' => $secret, ':time' => time()]);

		$query = $db->prepare("INSERT INTO actions (type, value, timestamp, value2, comment) VALUES (101,:username,:time,:ip, 'registration')");
		$query->execute([':username' => $userName, ':time' => time(), ':ip' => $ip]);
		
		$dl->print("<p class='mt-5 card w-50 p-2 mx-auto text-center'>Successful! <a href='..'>Please click here to continue.</a></p>");
		
		$accountID = $gs->getAccountIDFromName($userName);
		$_SESSION["accountID"] = $accountID;
		
		$query = $db->prepare("SELECT userID FROM users WHERE extID = :id");
		$query->execute([':id' => $accountID]);
		if ($query->rowCount() > 0) {
			$userID = $query->fetchColumn();
		} else {
			$query = $db->prepare("INSERT INTO users (isRegistered, extID, userName, IP, lastPlayed)
											  VALUES (1, :id, :userName, :ip, :lastPlayed)");
			$query->execute([':id' => $accountID, ':userName' => $userName, ':ip' => $ip, 'lastPlayed' => $time]);
		}
		ripchk("1", $userName, $ip);
	} else {
		$dl->print("<p class='mt-5 card w-50 p-2 mx-auto text-center'>Captcha verification failed. <a href='..'>Click here to continue</a></p>");				
	}
	
}else{
	$dl->print('
					<form action="" method="post" class="text-center card w-50 mx-auto mt-5"><br>
						
						<div class="form-group">
							<input type="text" class="form-control text-center mx-auto w-75" id="usernameField" name="userName" placeholder="Enter username">
						</div><br>
						
						<div class="form-group">
							<input type="password" class="form-control text-center mx-auto w-75" id="passwordField" name="password" placeholder="Password">
						</div><br>
						
						<div class="form-group">
							<input type="email" class="form-control text-center mx-auto w-75" id="passwordField" name="email" placeholder="email">
						</div><br>
						
						<div class="form-group">
							<label for="passwordField">Verify Captcha: <img src="https://hentaidash.tk/serversdata/incl/misc/captchaGen.php"></label>
							<input type="text" class="mt-2 form-control text-center mx-auto w-75" id="passwordField" name="captcha" placeholder="captcha">
						</div><br>
						
						<button type="submit" class="btn text-white w-75 mx-auto mt-3" style="background-color: #b598f5;">Register</button><br>
					
					</form>');
}

?>