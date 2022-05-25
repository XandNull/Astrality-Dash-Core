<?

include "../serversdata/incl/lib/connection.php";
require_once "../serversdata/incl/lib/exploitPatch.php";
$ep = new exploitPatch();

$levelName = $ep->remove($_GET["levelName"]);
$levelID = $ep->remove($_GET["levelID"]);

if(!empty($levelName) OR !empty($levelID)){
	$query = $db->prepare("SELECT * FROM levels WHERE levelName = :usr OR levelID = :usr2");
	$query->execute([':usr' => $levelName, ':usr2' => $levelID]);
	$result = $query->fetchAll();
	if($query->rowCount() == 0){
		$json = json_encode(array("data" => "not found"));
		exit($json);
	}
	foreach($result as &$users);
}else{
	$json = json_encode(array("data" => "not found"));
	exit($json);
}

$json = json_encode(array(
"userName" => $users["userName"], 
"levelid" => $users["levelID"], 
"levelname" => $users["levelName"], 
"desc" => $users["levelDesc"], 
"levelversion" => $users["levelVersion"], 
"levellength" => $users["levelLength"], 
"auto" => $users["auto"], 
"password" => $users["password"], 
"original" => $users["original"], 
"twoplayer" => $users["twoPlayer"], 
"songid" => $users["songID"], 
"objects" => $users["objects"], 
"coins" => $users["coins"], 
"reqstar" => $users["requestedStars"], 
"stardiff" => $users["starDifficulty"], 
"downloads" => $users["downloads"], 
"likes" => $users["likes"], 
"stardemon" => $users["starDemon"], 
"starauto" => $users["starAuto"], 
"starstars" => $users["starStars"], 
"uploaddate" => $users["uploadDate"], 
"updatedate" => $users["updateDate"], 
"ratedate" => $users["rateDate"], 
"starcoins" => $users["starCoins"], 
"starfeatured" => $users["starFeatured"], 
"starepic" => $users["starEpic"], 
"stardemondiff" => $users["starDemonDiff"], 
"isdeleted" => $users["isDeleted"], 
"isldm" => $users["isLDM"]));

echo $json;

?>