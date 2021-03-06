<?php
chdir(__DIR__);
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../lib/mainLib.php";
$gs = new mainLib();
$binaryVersion = $ep->remove($_POST["binaryVersion"]);
$gameVersion = $ep->remove($_POST["gameVersion"]);
$commentstring = "";
$userstring = "";
$users = array();
if(isset($_POST["mode"])){
	$mode = $ep->remove($_POST["mode"]);
}else{
	$mode = 0;
}
if(isset($_POST["count"]) AND is_numeric($_POST["count"])){
	$count = $ep->remove($_POST["count"]);
}else{
	$count = 10;
}
$page = $ep->remove($_POST["page"]);
$commentpage = $page*$count;
if($mode==0){
	$modeColumn = "commentID";
}else{
	$modeColumn = "likes";
}
if(empty($_POST["levelID"]) OR !$_POST["levelID"]){
	$displayLevelID = true;
	$levelID = $ep->remove($_POST["userID"]);
	$query = "SELECT levelID, commentID, timestamp, comment, userID, likes, isSpam, percent FROM comments WHERE userID = :levelID ORDER BY $modeColumn DESC LIMIT $count OFFSET $commentpage";
	$countquery = "SELECT count(*) FROM comments WHERE userID = :levelID";
}else{
	$displayLevelID = false;
	$levelID = $ep->remove($_POST["levelID"]);
	$query = "SELECT levelID, commentID, timestamp, comment, userID, likes, isSpam, percent FROM comments WHERE levelID = :levelID ORDER BY $modeColumn DESC LIMIT $count OFFSET $commentpage";
	$countquery = "SELECT count(*) FROM comments WHERE levelID = :levelID";
}
$countquery = $db->prepare($countquery);
$countquery->execute([':levelID' => $levelID]);
$commentcount = $countquery->fetchColumn();
if($commentcount == 0){
	exit("-2");
}
$query = $db->prepare($query);
$query->execute([':levelID' => $levelID]);
$result = $query->fetchAll();
foreach($result as &$comment1) {
	if($comment1["commentID"]!=""){
		$uploadDate = $gs->timeDelay($comment1["timestamp"]);
		$actualcomment = $comment1["comment"];
		if($gameVersion < 20){
			$actualcomment = base64_decode($actualcomment);
		}
		if($displayLevelID){
			$commentstring .= "1~".$comment1["levelID"]."~";
		}
		$commentstring .= "2~".$actualcomment."~3~".$comment1["userID"]."~4~".$comment1["likes"]."~5~0~7~".$comment1["isSpam"]."~9~".$uploadDate."~6~".$comment1["commentID"]."~10~".$comment1["percent"];
		$query12 = $db->prepare("SELECT userID, userName, icon, color1, color2, iconType, special, extID FROM users WHERE userID = :userID");
		$query12->execute([':userID' => $comment1["userID"]]);
		if ($query12->rowCount() > 0) {
			$user = $query12->fetchAll()[0];
			if(is_numeric($user["extID"])){
				$extID = $user["extID"];
			}else{
				$extID = 0;
			}
			if(!in_array($user["userID"], $users)){
				$users[] = $user["userID"];
				$userstring .=  $user["userID"] . ":" . $user["userName"] . ":" . $extID . "|";
			}
			if($binaryVersion > 31){
				if($gs->checkPermission($extID, "isAdmin")){
					$badge = "2";
					$color = rand(0,255).", ".rand(0,255).", ".rand(0,255);
					$icon = rand(1,150);
					$color1 = rand(1,50);
					$color2 = rand(1,50);
				}else{
					$badge = $gs->getMaxValuePermission($extID, "modBadgeLevel");
					$color = $gs->getAccountCommentColor($extID);
					$icon = $user["icon"];
					$color1 = $user["color1"];
					$color2 = $user["color2"];
				}
				$commentstring .= "~11~".$badge."~12~".$color.":1~".$user["userName"]."~7~1~9~".$icon."~10~".$color1."~11~".$color2."~14~".$user["iconType"]."~15~".$user["special"]."~16~".$user["extID"];
			}
			$commentstring .= "|";
		}
	}
}
$commentstring = substr($commentstring, 0, -1);
$userstring = substr($userstring, 0, -1);
echo $commentstring;
if($binaryVersion < 32){
	echo "#$userstring";
}
echo "#".$commentcount.":".$commentpage.":10";
?>