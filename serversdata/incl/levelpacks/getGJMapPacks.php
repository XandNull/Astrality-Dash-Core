<?php
chdir(__DIR__);
require "../lib/connection.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../lib/generateHash.php";
$gh = new generateHash();
if (isset($_POST["page"]) AND is_numeric($_POST["page"])) {
	$page = $ep->remove($_POST["page"]);
	$packpage = $page * 10;
} else {
	$page = 1;
	$packpage = 10;
}
// Originally discovered by kyurime, thanks. This solves the coins duplication bug with map packs after loading data.
if (isset($_POST["isVerify"]) AND is_numeric($_POST["isVerify"])) {
	$isVerify = $_POST["isVerify"];
} else {
	$isVerify = 0;
}
$mappackstring = "";
$lvlsmultistring = "";
if ($isVerify == 1) {
	$query = $db->prepare("SELECT ID, levels, stars, coins FROM mappacks ORDER BY stars");
} else {
	$query = $db->prepare("SELECT ID, name, levels, stars, coins, difficulty, rgbcolors, colors2 FROM mappacks ORDER BY ID LIMIT 10 OFFSET $packpage");
}
$query->execute();
$result = $query->fetchAll();
if (count($result) == 0) {
	exit("-1");
}
foreach ($result as &$mappack) {
	$lvlsmultistring .= $mappack["ID"] . ",";
	if ($isVerify == 1) {
		$mappackstring .= "1:" . $mappack["ID"] . ":3:" . $mappack["levels"] . ":4:" . $mappack["stars"] . ":5:" . $mappack["coins"] . "|";
	} else {
		$colors2 = $mappack["colors2"];
		if ($colors2 == "none" OR $colors2 == "") {
			$colors2 = $mappack["rgbcolors"];
		}
		$mappackstring .= "1:" . $mappack["ID"] . ":2:" . $mappack["name"] . ":3:" . $mappack["levels"] . ":4:" . $mappack["stars"] . ":5:" . $mappack["coins"] . ":6:" . $mappack["difficulty"] . ":7:" . $mappack["rgbcolors"] . ":8:" . $colors2 . "|";
	}
}
$query = $db->prepare("SELECT COUNT(*) FROM mappacks");
$query->execute();
$totalpackcount = $query->fetchColumn();
$mappackstring = substr($mappackstring, 0, -1);
$lvlsmultistring = substr($lvlsmultistring, 0, -1);
echo $mappackstring . "#" . $totalpackcount . ":" . $packpage . ":";
if ($isVerify == 1) {
	echo $totalpackcount;
} else {
	echo "10"; 
}
echo "#" . $gh->genPack($lvlsmultistring);
?>