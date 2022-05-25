<?php
exit("-3878");
include "../incl/lib/connection.php";
require_once "../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../incl/lib/mainLib.php";
$gs = new mainLib();

function ripchk($type, $userName, $ip) {
	# вк бот уведомлений
	require_once "../../vkbot/connect.php";
	$vk_title = '📙 Регистрация аккаунта';
	# пример $vk->sendMessage(1, $vk_notifiers, "$vk_title текст");
	
	if($type == 1){
		$vk->sendMessage(1, $vk_notifiers, "$vk_title <br>✔ $userName ($ip) зарегистрировался на сервере!");
	}else{
		$vk->sendMessage(1, $vk_notifiers, "$vk_title <br>❌ Неудачная попытка регистрации $userName ($ip)!");
	}
	exit($type);
}

// Данные
$ip = $gs->getIP();
$userName = $ep->remove($_POST["userName"]);
$password = $ep->remove($_POST["password"]);
$email = $ep->remove($_POST["email"]);
$secret = $ep->remove($_POST["secret"]);



if($userName != "" OR $password != "" OR $email != ""){
	
	//проверка на кол-во символов
	if (strlen($userName) < 3 OR strlen($userName) > 15) {
		ripchk("-9", $userName, $ip);
	} elseif (strlen($password) < 6 OR strlen($password) > 20) {
		ripchk("-8", $userName, $ip);
	}
	
	//проверка на кол-во регистрация за опр.период
	// type 101 - регистрация
	$newtime = time() - 120;
	$query = $db->prepare("SELECT count(*) FROM actions WHERE type = 101 AND timestamp > :newtime AND value2 = :ip");
	$query->execute([':newtime' => $newtime, ':ip' => $ip]);
	if($query->fetchColumn() >= 1){
		ripchk("-1", $userName, $ip);
	}
	
	//проверка на совпадение имени пользователя
	$query = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
	$query->execute([':userName' => $userName]);
	if ($query->fetchColumn() > 0) {
		ripchk("-2", $userName, $ip);
	}
	
	//проверка на совпадение почты
	$query = $db->prepare("SELECT COUNT(*) FROM accounts WHERE email LIKE :email");
	$query->execute([':email' => $email]);
	if ($query->fetchColumn() > 0) {
		ripchk("-3", $userName, $ip);
	}
	
	$hashpass = password_hash($password, PASSWORD_DEFAULT);
	$query = $db->prepare("INSERT INTO accounts (userName, password, email, secret, saveData, registerDate, saveKey)
	VALUES (:userName, :password, :email, :secret, '', :time, '')");
	$query->execute([':userName' => $userName, ':password' => $hashpass, ':email' => $email, ':secret' => $secret, ':time' => time()]);
	//регистрация в логи
	$query = $db->prepare("INSERT INTO actions (type, value, timestamp, value2, comment) VALUES 
											   (101,:username,:time,:ip, 'registration')");
	$query->execute([':username' => $userName, ':time' => time(), ':ip' => $ip]);
	ripchk("1", $userName, $ip);
}else{
	echo "-1";
}
?>