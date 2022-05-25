<?php
include "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
$generatePass = new generatePass();
require_once "../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../incl/lib/mainLib.php";
$gs = new mainLib();

# вк бот уведомлений
require_once "../../vkbot/connect.php";
$vk_title = '📙 Вход в аккаунт';
# пример $vk->sendMessage(1, $vk_notifiers, "$vk_title <br>текст");

// Данные
$ip = $gs->getIP();
$udid = $ep->remove($_POST["udid"]);
$userName = $ep->remove($_POST["userName"]);
$password = $ep->remove($_POST["password"]);
$time = time();

// Проверка
if(!isset($userName) OR !isset($password) OR !isset($udid)){
	exit("-1");
}

$query = $db->prepare("SELECT accountID FROM accounts WHERE userName LIKE :userName");
$query->execute([':userName' => $userName]);
if($query->rowCount() == 0){
	exit("-1");
}
$id = $query->fetchColumn();
$pass = $generatePass->isValidUsrname($userName, $password);
if ($pass == 1) {
	#newtime = time() - 30;
	#$query6 = $db->prepare("SELECT count(*) FROM actions WHERE type = '1' AND timestamp > :time AND value2 = :ip");
	#$query6->execute([':time' => $newtime, ':ip' => $ip]);
	#if($query6->fetchColumn() > 5){
		#exit("-12");
	#}
	
	//Проверка на кол-во символов
	if (strlen($userName) < 3 OR strlen($userName) > 15) {
		exit("-9");
	} elseif (strlen($password) < 6 OR strlen($password) > 20) {
		exit("-8");
	}
	
	//проверка на бан
	$query = $db->prepare("SELECT isBanned FROM users WHERE userName = :userName");
	$query->execute([':userName' => $userName]);
	$isBanned = $query->fetchColumn();
	if($isBanned == "1"){
		exit("-12");
	}
	
	$query = $db->prepare("SELECT userID FROM users WHERE extID = :id");
	$query->execute([':id' => $id]);
	if ($query->rowCount() > 0) {
		$userID = $query->fetchColumn();
	} else {
		$query = $db->prepare("INSERT INTO users (isRegistered, extID, userName, IP, lastPlayed)
		                                  VALUES (1, :id, :userName, :ip, :lastPlayed)");
		$query->execute([':id' => $id, ':userName' => $userName, ':ip' => $ip, 'lastPlayed' => $time]);
		$userID = $db->lastInsertId();
	}
	
	//type 2 - вход в аккаунт
	$query = $db->prepare("INSERT INTO actions (type, value, timestamp, value2, comment) VALUES 
												('2',:username,:time,:ip, 'log in')");
	$query->execute([':username' => $userName, ':time' => time(), ':ip' => $ip]);
	$vk->sendMessage(1, $vk_notifiers, "$vk_title <br>✔ Выполнен вход $userName ($ip)!");
	echo $id.",".$userID;
}elseif ($pass == -1){
	$vk->sendMessage(1, $vk_notifiers, "$vk_title <br>⚠️ Аккаунт $userName ($ip) был заблокирован!");
	echo -12;
}else{
	$vk->sendMessage(1, $vk_notifiers, "$vk_title <br>❌ Неудачная попытка $userName ($ip)!");
	echo -1;
}
?>