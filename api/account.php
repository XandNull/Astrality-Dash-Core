<?

include "../serversdata/incl/lib/connection.php";

$userName = $_GET['userName'];
$accountID = $_GET['accountID'];

if(!empty($userName) OR !empty($accountID)){
	#users table
	$query = $db->prepare("SELECT * FROM users WHERE userName = :usr OR extID = :usr2");
	$query->execute([':usr' => $userName, ':usr2' => $accountID]);
	$result = $query->fetchAll();
	if($query->rowCount() == 0){
		$json = json_encode(array("data" => "not found"));
		exit($json);
	}
	foreach($result as &$users);
	#accounts table
	$query = $db->prepare("SELECT * FROM accounts WHERE userName = :usr OR accountID = :usr2");
	$query->execute([':usr' => $userName, ':usr2' => $accountID]);
	$result = $query->fetchAll();
	foreach($result as &$accounts);
	#role check
	$query1 = $db->prepare("SELECT roleID FROM roleassign WHERE accountID = :usr");
	$query1->execute([':usr' => $users["extID"]]);
	if($query1->rowCount() == 0){
		$roleName = "Player";
	}else{
		$roleID = $query1->fetchColumn();
		$query1 = $db->prepare("SELECT roleName FROM roles WHERE roleID = :usr");
		$query1->execute([':usr' => $roleID]);
		$roleName = $query1->fetchColumn();
	}
}else{
	$json = json_encode(array("data" => "not found"));
	exit($json);
}

if(empty($accounts["youtubeurl"])){
	$youtube = "undefined";
}
if(empty($accounts["twitter"])){
	$twitter = "undefined";
}
if(empty($accounts["twitch"])){
	$twitch = "undefined";
}
if($accounts["isAdmin"] == "1"){
	$roleName = "Admin";
}

$json = json_encode(array(
"userName" => $users["userName"], 
"accountID" => $users["extID"], 
"coins" => $users["coins"], 
"userCoins" => $users["userCoins"], 
"stars" => $users["stars"], 
"creatorpoitns" => $users["creatorPoints"], 
"demons" => $users["demons"], 
"diamonds" => $users["diamonds"],
"orbs" => $users["orbs"],  
"timestamp" => $users["lastPlayed"], 
"isBanned" => $users["isBanned"], 
"isCreatorbanned" => $users["isCreatorBanned"], 
"isRegistered" => $users["isRegistered"], 
"chest1" => $users["chest1count"], 
"chest2" => $users["chest2count"], 
"completedlvls" => $users["completedLvls"],  
"color1" => $users["color1"],
"color2" => $users["color2"],
"accIcon" => $users["accIcon"],
"accShip" => $users["accShip"],
"accBall" => $users["accBall"],
"accBird" => $users["accBird"],
"accDart" => $users["accDart"],
"accRobot" => $users["accRobot"],
"accSpider" => $users["accSpider"],
"accGlow" => $users["accGlow"],
"registerDate" => $accounts["registerDate"],
"isAdmin" => $accounts["isAdmin"],
"youtube" => $youtube,
"twitter" => $twitter,
"twitch" => $twitch,
"role" => $roleName,
"aboutme" => $users["aboutme"],
"vk" => $users["vk"],
"discord" => $users["discord"],
"developer" => $users["developer"],
"bugfinder" => $users["bugfinder"],
"verify" => $users["verify"]));

echo $json;

?>