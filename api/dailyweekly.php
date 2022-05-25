<?

include "../serversdata/incl/lib/connection.php";
include "../serversdata/incl/lib/mainLib.php";
$gs = new mainLib();

$type = $_GET['type'];

$query = $db->prepare("SELECT * FROM dailyfeatures WHERE type = :type");
$query->execute([':type' => $type]);
$result = $query->fetchAll();
if($query->rowCount() == 0){
	$json = json_encode(array("data" => "not found"));
	exit($json);
}
foreach($result as &$users2);
	
$query2 = $db->prepare("SELECT * FROM levels WHERE levelID = :id");
$query2->execute([':id' => $users2["levelID"]]);
$result2 = $query2->fetchAll();
if($query2->rowCount() == 0){
	$json = json_encode(array("data" => "not found"));
	exit($json);
}
foreach($result2 as &$users);

if($type == "0"){
	$type = "daily";
}elseif ($type == "1"){
	$type = "weekly";
}

$json = json_encode(array(
"type" => $type, 
"timedelay" => $gs->convertToDate($users2["timestamp"]),
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