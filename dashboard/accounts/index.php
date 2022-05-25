<?php
session_start();
if(empty($_SESSION["accountID"])){
	header("Location: login.php");
	exit();
}
require "../src/dashboardLib.php";
$dl = new dashboardLib();
require "../../serversdata/incl/lib/connection.php";
$userName = $_GET['userName'];
$myCurl = curl_init();
curl_setopt_array($myCurl, array(
    CURLOPT_URL => "https://hentaidash.tk/api/account.php?userName=".$userName,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query(array())
));
$response = curl_exec($myCurl);
curl_close($myCurl);
$users = json_decode($response, true);
if(empty($users["userName"])){
	$dl->print("<div class='card mt-4 p-3 mx-auto text-center border border-white text-white w-75' style='background-color: #b598f5;'>Oops.. <br>".$userName." not found!</div>");
	exit();
}
?>
<style>

#header {
  max-width: 350px;
  min-width: 200px;
  height: 150px;
  border-radius: 10px 10px 0px 0px;
}

#profile {
  width: 350px;
  height: 350px;
  background: white;
  position: relative;
  box-sizing: border-box;
  padding-top: 40px;
  padding-left: 25px;
}
#profile .image {
  position: absolute;
  top: -60px;
  left: 20px;
  height: 90px;
  width: 90px;
  border-radius: 200px;
}
#profile .image img {
  width: inherit;
  height: inherit;
  border-radius: 100px;
  box-shadow: #0000005c 0px 0px 5px 0px;
}
#profile .name {
  font-size: 20px;
  font-weight: 50px;
  color: #444;
}
#profile .nickname {
  color: #888;
  font-size: 0.9rem;
  padding-bottom: 7px;
}

.shadow {
  box-shadow: 0px 0px 10px 1px rgba(0, 0, 0, 0.5);
}

.overflow {
  overflow: hidden;
}

.bottom {
  margin-top: 10px;
}

.scroll {
  height:190px;
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
  -ms-overflow-style: -ms-autohiding-scrollbar;
}
.scroll::-webkit-scrollbar {
  width: 5px;
}
.scroll::-webkit-scrollbar-track {
  background: #fff0;
}
.scroll::-webkit-scrollbar-thumb {
  background-color: #fff0;
  border: 3px solid #1b1e2100;
}
.scroll::-webkit-scrollbar-thumb:hover {
  background-color: #ffadf76b; 
}

:root {
  --scrollbar-track-color: transparent;
  --scrollbar-color: rgba(0,0,0,.2);

  --scrollbar-width: thin; /* or `auto` or `none` */
}
.overflowing-element {
  scrollbar-width: var(--scrollbar-width); 
  scrollbar-color: var(--scrollbar-color) var(--scrollbar-track-color);
}

@keyframes hue {
    from {
        filter: hue-rotate(0deg);
    }
    to {
        filter: hue-rotate(-360deg);
    }
}
.izi{

}
.izi:hover{
	box-shadow: 0px 0px 10px 1px rgba(0, 0, 0, 0.5);
}
.demon{
	animation: hue 5s infinite linear;
}
.borders{
	border-style: solid; 
	border-radius: 5px; 
}
.legend{
	border-style: solid; 
}
.gray{
	filter: grayscale(100%);
}
.col mt-2 text-center {
	filter: drop-shadow(0px 0px 5px #00000057);
}
.btn{
	border-radius: 20px;
}
.rounded-0 {
   border-radius: 10px;
}
.display-inline {
    display: inline-block;
}
.govnishe{
	color: white;
	transition: .4s;
}
.govnishe:hover{
	color: white;
	text-shadow: white 0px 0px 5px;
}
.leps{
	text-shadow: #b598f5 0px 0px 5px;
	color: #b598f5;
}
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
	html {
		margin: 0;
		font-family: 'Poppins', sans-serif;
	}
	.postmain {
		padding: 20px 15px;
		border-radius: 10px;
		width: 800px;
	}
	.postmain img {
		width: 50px;
		height: 50px;
		border-radius: 100%;
		margin: -20 10;
	}
	.twolinetext {
		opacity: 0.6;
	}
	.b {
		font-weight: 600;
	}
	.posttext {
		padding: 10px;
		width: 600px;
	}
</style>
<?
$chests = $users["chest1"] + $users["chest2"];
$starspp = $users["stars"]*4 - $users["stars"]*2;
$cpspp = $users["creatorpoitns"]*20 - $users["creatorpoitns"]*5;
$usercoinspp = $users["userCoins"]*10;
$coinspp = $users["coins"]*10;
$diamondspp = $users["diamonds"]*0.01;
$chestspp = $chests*5;
$pp = $starspp + $cpspp + $usercoinspp + $coinspp + $diamondspp + $chestspp;

$query = $db->prepare("SELECT count(*) FROM levels WHERE userName = '".$userName."'");
$query->execute();
$countlevels = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM comments WHERE userName = '".$userName."'");
$query->execute();
$countcomments = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM acccomments WHERE userName = '".$userName."'");
$query->execute();
$countposts = $query->fetchColumn();

$query1 = $db->prepare("SELECT * FROM levels WHERE userName = :usr AND unlisted = 0");
$query1->execute([':usr' => $userName]);
$result = $query1->fetchAll();
if($query1->rowCount() == 0){
			$levelss = "<div class='mt-1 p-1 mx-auto rounded-0' style='width: 320px;'>".$userName." doesn't have levels</div>";
}else{
	foreach ($result as $row1) {
		$govno = $row1["levelName"];
		$govno = substr($govno,0,40);
		$query1 = $db->prepare("SELECT avatar FROM users WHERE extID = :usr");
		$query1->execute([':usr' => $users["accountID"]]);
		$avatarik = $query1->fetchColumn();
		if($avatarik == "0"){
			$avatarik = 'avatars/1.png';
		}
		$levelss .= '<div align="left" class="postmain">
						<p class="b"><img src="https://hentaidash.tk/dashboard/accounts/'.$avatarik.'"> '.$userName.' <font class="twolinetext">22.02.2022</font></p>
						<p class="posttext">'.$govno.'</p>
					</div>
					<hr class="dropdown-divider">';
	}
}

$query1 = $db->prepare("SELECT * FROM acccomments WHERE userName = :usr AND isSpam = 0");
$query1->execute([':usr' => $userName]);
$result = $query1->fetchAll();
if($query1->rowCount() == 0){
			$posts = "<div class='mt-1 p-1 mx-auto rounded-0' style='width: 320px;'>".$userName." doesn't have posts</div>";
}else{
	foreach ($result as $row2) {
		$govno1 = $row2["comment"];
		$enc = base64_decode($govno1);
		$newtext = wordwrap($enc, 16, "<br>", true);
		$query1 = $db->prepare("SELECT avatar FROM users WHERE extID = :usr");
		$query1->execute([':usr' => $users["accountID"]]);
		$avatarik = $query1->fetchColumn();
		if($avatarik == "0"){
			$avatarik = 'avatars/1.png';
		}
		$posts .= '<div align="left" class="postmain">
						<p class="b"><img src="https://hentaidash.tk/dashboard/accounts/'.$avatarik.'"> '.$userName.' <font class="twolinetext">22.02.2022</font></p>
						<p class="posttext">'.$enc.'</p>
					</div>
					<hr class="dropdown-divider">';
	}
}

$query1 = $db->prepare("SELECT * FROM comments WHERE userName = :usr AND isSpam = 0");
$query1->execute([':usr' => $userName]);
$result = $query1->fetchAll();
if($query1->rowCount() == 0){
			$comments = "<div class='mt-1 p-1 mx-auto rounded-0' style='width: 320px;'>".$userName." doesn't have comments</div>";
}else{
	foreach ($result as $row3) {
		$query1 = $db->prepare("SELECT levelName FROM levels WHERE levelID = :usr");
		$query1->execute([':usr' => $row3["levelID"]]);
		$levelNames = $query1->fetchColumn();
		$query1 = $db->prepare("SELECT userName FROM levels WHERE levelID = :usr");
		$query1->execute([':usr' => $row3["levelID"]]);
		$userlevels = $query1->fetchColumn();
		$query1 = $db->prepare("SELECT userName FROM levels WHERE levelID = :usr");
		$query1->execute([':usr' => $row3["levelID"]]);
		$bylevelname = $query1->fetchColumn();
		$govno2 = $row3["comment"];
		$enc2 = base64_decode($govno2);
		$query1 = $db->prepare("SELECT avatar FROM users WHERE extID = :usr");
		$query1->execute([':usr' => $users["accountID"]]);
		$avatarik = $query1->fetchColumn();
		if($avatarik == "0"){
			$avatarik = 'avatars/1.png';
		}
		$comments .= '<div align="left" class="postmain">
						<p class="b"><img src="https://hentaidash.tk/dashboard/accounts/'.$avatarik.'"> '.$userName.' <font style="opacity:50%;" class="twolinetext">'.$levelNames.' by '.$userlevels.': '.$row3["levelID"].'</font></p>
						<p class="posttext">'.$enc2.'</p>
					</div>
					<hr class="dropdown-divider">';
	}
}

if($users["stars"] > '200'){
	$s1 = "<i class='bi bi-check'></i>";
}
if($users["coins"] > '60'){
	$c1 = "<i class='bi bi-check'></i>";
}
if($users["userCoins"] > '5'){
	$uc1 = "<i class='bi bi-check'></i>";
}
if($users["demons"] > '1'){
	$dm1 = "<i class='bi bi-check'></i>";
}
if($users["diamonds"] > '5000'){
	$di1 = "<i class='bi bi-check'></i>";
}
if($chests > '50'){
	$ac1 = "<i class='bi bi-check'></i>";
}

$achievments = '';
				
require_once __DIR__."/../../serversdata/incl/lib/mainLib.php";
$gs = new mainLib();
$array = $gs->getFriends($users["accID"]);
foreach ($array as $row) {
	$query1 = $db->prepare("SELECT userName FROM accounts WHERE accountID = :usr");
	$query1->execute([':usr' => $row]);
	$usern = $query1->fetchColumn();
	$friends .= '<a href="https://hentaidash.tk/dashboard/accounts/'.$usern.'" data-bs-toggle="tooltip" data-bs-placement="top"><img src="avatars/1.png" style="width: 50px; height: 50px; border-radius: 5px;" class="mt-1 scale"></a><br>';
}

$user = $result[0];
$extid = $user["extID"];
$e = "SET @rownum := 0;";
$query = $db->prepare($e);
$query->execute();
$f = "SELECT rank, stars FROM (SELECT @rownum := @rownum + 1 AS rank, stars, extID, isBanned FROM users WHERE isBanned = '0' AND gameVersion $sign ORDER BY stars DESC) as result WHERE extID=:extid";
$query = $db->prepare($f);
$query->execute([':extid' => $users["accountID"]]);
$leaderboard = $query->fetchAll();
$leaderboard = $leaderboard[0];

if($users["isAdmin"] == "1"){
	$badgeadm = "<img src='../src/moderator_icon.png' style='width: 20px;'>";
}

if($users["developer"] == "1"){
	$badgedev = "<img src='../src/team_icon.png' style='width: 20px;'>";
}

if($users["bugfinder"] == "1"){
	$badgebug = "<img src='../src/bugfinder_icon.png' style='width: 20px;'>";
}

if($users["verify"] == "1"){
	$badgeverify = "<img src='../src/verify_icon.png' style='width: 20px;'>";
}

$query = $db->prepare("SELECT avatar FROM users WHERE userName = '".$userName."'");
$query->execute();
$avatar = $query->fetchColumn();

if($avatar == "0"){
	$avatar = "avatars/1.png";
}else{
	$avatar = $avatar;
}

$query = $db->prepare("SELECT banner FROM users WHERE userName = '".$userName."'");
$query->execute();
$banner = $query->fetchColumn();

if($banner == "0"){
	$banner = "banners/1.png";
}else{
	$banner = $banner;
}

$array = $gs->getFriends($users["accountID"]);
foreach ($array as $row) {
	$query1 = $db->prepare("SELECT userName FROM accounts WHERE accountID = :usr");
	$query1->execute([':usr' => $row]);
	$usern = $query1->fetchColumn();
	$query1 = $db->prepare("SELECT avatar FROM users WHERE extID = :usr");
	$query1->execute([':usr' => $row]);
	$avatarik = $query1->fetchColumn();
	if($avatarik == "0"){
		$avatarik = 'avatars/1.png';
	}
	$query1 = $db->prepare("SELECT count(*) FROM friendships WHERE person1 = :usr");
	$query1->execute([':usr' => $users["accountID"]]);
	$countfriends = $query1->fetchColumn();
	$friends .= '
		<div class="col-auto">
			<div><a href="https://hentaidash.tk/dashboard/accounts/index.php?userName='.$usern.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$usern.'"><img src="https://hentaidash.tk/dashboard/accounts/'.$avatarik.'" style="width: 50px; height: 50px; border-radius: 5px;" class="mt-1 scale"></a><br><p><a href="https://hentaidash.tk/dashboard/accounts/index.php?userName='.$usern.'" class="fs-6">'.$usern.'</a></p></div>
		</div>';
}

$fireG = '<div class="mx-auto border-dark p-1 text-center card gray" style="background: url(https://hentaidash.tk/dashboard/src/fire_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
$iceG = '<div class="mx-auto border-dark p-1 text-center card mt-2 gray" style="background: url(https://hentaidash.tk/dashboard/src/ice_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
$poisonG = '<div class="mx-auto border-dark p-1 text-center card mt-2 gray" style="background: url(https://hentaidash.tk/dashboard/src/acid_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
$shadowG = '<div class="mx-auto border-dark p-1 text-center card mt-2 gray" style="background: url(https://hentaidash.tk/dashboard/src/dark_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
$lavaG = '<div class="mx-auto border-dark p-1 text-center card mt-2 gray" style="background: url(https://hentaidash.tk/dashboard/src/volcano_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
$bonusG = '<div class="mx-auto border-dark p-1 text-center card mt-2 gray" style="background: url(https://hentaidash.tk/dashboard/src/prismatic_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
$chaosG = '<div class="mx-auto border-dark p-1 text-center card mt-2 gray" style="background: url(https://hentaidash.tk/dashboard/src/сhaos_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
$demonG = '<div class="mx-auto border-dark p-1 text-center card mt-2 gray" style="background: url(https://hentaidash.tk/dashboard/src/dragon_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
$timeG = '<div class="mx-auto border-dark p-1 text-center card mt-2 gray" style="background: url(https://hentaidash.tk/dashboard/src/time_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
$crystalG = '<div class="mx-auto border-dark p-1 text-center card mt-2 gray" style="background: url(https://hentaidash.tk/dashboard/src/crystal_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
$magicG = '<div class="mx-auto border-dark p-1 text-center card mt-2 gray" style="background: url(https://hentaidash.tk/dashboard/src/magic_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
$spikeG = '<div class="mx-auto border-dark p-1 text-center card mt-2 gray" style="background: url(https://hentaidash.tk/dashboard/src/desert_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
$monsterG = '<div class="mx-auto border-dark p-1 text-center card mt-2 gray" style="background: url(https://hentaidash.tk/dashboard/src/monster_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
$doomG = '<div class="mx-auto border-dark p-1 text-center card mt-2 gray" style="background: url(https://hentaidash.tk/dashboard/src/final_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
$deathG = '<div class="mx-auto border-dark p-1 text-center card mt-2 gray" style="background: url(https://hentaidash.tk/dashboard/src/death_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';

$query = $db->prepare("SELECT * FROM levels WHERE userName = :user");
$query->execute([':user'=>$userName]);
$levels = $query->fetchAll();
foreach($levels as &$levelD) {
	$level = $levelD["levelID"];
	$query = $db->prepare("SELECT * FROM gauntlets WHERE level1 = :level OR level2 = :level OR level3 = :level OR level4 = :level OR level5 = :level");
	$query->execute([':level'=>$level]);
	$g = $query->fetchAll();
	foreach($g as &$dd) {
		
		$d = $dd["ID"];
		
		if($d == 1) {
			$fireG = '<div class="mx-auto border-dark p-1 text-center card " style="background: url(https://hentaidash.tk/dashboard/src/fire_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
		
		if($d == 2) {
			$iceG = '<div class="mx-auto border-dark p-1 text-center card mt-2 " style="background: url(https://hentaidash.tk/dashboard/src/ice_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
		
		if($d == 3) {
			$poisonG = '<div class="mx-auto border-dark p-1 text-center card mt-2 " style="background: url(https://hentaidash.tk/dashboard/src/acid_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
		
		if($d == 4){
			$shadowG = '<div class="mx-auto border-dark p-1 text-center card mt-2 " style="background: url(https://hentaidash.tk/dashboard/src/dark_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
		
		if($d == 5){
			$lavaG = '<div class="mx-auto border-dark p-1 text-center card mt-2 " style="background: url(https://hentaidash.tk/dashboard/src/volcano_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
		
		if($d == 6){
			$bonusG = '<div class="mx-auto border-dark p-1 text-center card mt-2 " style="background: url(https://hentaidash.tk/dashboard/src/prismatic_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
		
		if($d == 7){
			$chaosG = '<div class="mx-auto border-dark p-1 text-center card mt-2 " style="background: url(https://hentaidash.tk/dashboard/src/сhaos_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
		
		if($d == 8){
			$demonG = '<div class="mx-auto border-dark p-1 text-center card mt-2 " style="background: url(https://hentaidash.tk/dashboard/src/dragon_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
		
		if($d == 9){
			$timeG = '<div class="mx-auto border-dark p-1 text-center card mt-2 " style="background: url(https://hentaidash.tk/dashboard/src/time_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
		
		if($d == 10){
			$crystalG = '<div class="mx-auto border-dark p-1 text-center card mt-2 " style="background: url(https://hentaidash.tk/dashboard/src/crystal_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
		
		if($d == 11){
			$magicG = '<div class="mx-auto border-dark p-1 text-center card mt-2 " style="background: url(https://hentaidash.tk/dashboard/src/magic_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
		
		if($d == 12){
			$spikeG = '<div class="mx-auto border-dark p-1 text-center card mt-2 " style="background: url(https://hentaidash.tk/dashboard/src/desert_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
		
		if($d == 13){
			$monsterG = '<div class="mx-auto border-dark p-1 text-center card mt-2 " style="background: url(https://hentaidash.tk/dashboard/src/monster_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
		
		if($d == 14){
			$doomG = '<div class="mx-auto border-dark p-1 text-center card mt-2 " style="background: url(https://hentaidash.tk/dashboard/src/final_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
		
		if($d == 15){
			$deathG = '<div class="mx-auto border-dark p-1 text-center card mt-2 " style="background: url(https://hentaidash.tk/dashboard/src/death_stage.png); border-radius: 10px; background-size: cover; background-position: center center; width: 340px; height: 75px;"></div>';
		}
	}
}

$a=mb_strstr($pp,".",true);
if($a) $pp=$a.".";

$legendary = '<div class="mx-auto p-1 text-center card mt-2 izi" style="background: url(https://hentaidash.tk/dashboard/src/blue.png); border-radius: 10px; background-size: cover; background-position: center center; width: 350px;"><h5 class="text-left text-white">'.$pp.'pp</h5>
											<h5 class="text-right mt-3 text-white"><br>Novice</h5></div>';

if($pp > 500){
	$legendary = '<div class="mx-auto p-1 text-center card mt-2 izi" style="background: url(https://hentaidash.tk/dashboard/src/green.png); border-radius: 10px; background-size: cover; background-position: center center; width: 350px;"><h5 class="text-left text-white">'.$pp.'pp</h5>
											<h5 class="text-right mt-3 text-white"><br>Advanced</h5></div>';
}
if ($pp > 1000){
	$legendary = '<div class="mx-auto p-1 text-center card mt-2 izi" style="background: url(https://hentaidash.tk/dashboard/src/orange.png); border-radius: 10px; background-size: cover; background-position: center center; width: 350px;"><h5 class="text-left text-white">'.$pp.'pp</h5>
											<h5 class="text-right mt-3 text-white"><br>Medium</h5></div>';
}
if ($pp > 2000){
	$legendary = '<div class="mx-auto p-1 text-center card mt-2 izi" style="background: url(https://hentaidash.tk/dashboard/src/red.png); border-radius: 10px; background-size: cover; background-position: center center; width: 350px;"><h5 class="text-left text-white">'.$pp.'pp</h5>
											<h5 class="text-right mt-3 text-white"><br>Expert</h5></div>';
}
if ($pp > 4000) {
	$legendary = '<div class="mx-auto p-1 text-center card mt-2 izi" style="background: url(https://hentaidash.tk/dashboard/src/pink.png); border-radius: 10px; background-size: cover; background-position: center center; width: 350px;"><h5 class="text-left text-white">'.$pp.'pp</h5>
											<h5 class="text-right mt-3 text-white"><br>Master</h5></div>';
}
if ($pp > 7500){
	$legendary = '<div class="mx-auto p-1 text-center card mt-2 izi demon" style="background: url(https://hentaidash.tk/dashboard/src/blue.png); border-radius: 10px; background-size: cover; background-position: center center; width: 350px;"><h5 class="text-left text-white">'.$pp.'pp</h5>
											<h5 class="text-right mt-3 text-white"><br>Legend</h5></div>';
}
if ($pp > 12000){
	$legendary = '<div class="mx-auto p-1 text-center card mt-2 izi" style="background: url(https://hentaidash.tk/dashboard/src/gray.png); border-radius: 10px; background-size: cover; background-position: center center; width: 350px;"><h5 class="text-left text-white">'.$pp.'pp</h5>
											<h5 class="text-right mt-3 text-white"><br>Mythical</h5></div>';
}

if($users["aboutme"] == '0'){
	$about = '';
}else{
	$about = '<div class="card w-100 borders mt-2 w-50 row text-left p-2">About me: '.$users["aboutme"].'</div>';
}

if($users["vk"] == '0'){
	$vk = '';
}else{
	$vk = '<div class="card w-100 borders mt-2 w-50 row text-left p-2"><a href="https://vk.com/'.$users["vk"].'">VK: '.$users["vk"].'</div>';
}

if($users["discord"] == '0'){
	$discord = '';
}else{
	$discord = '<div class="card w-100 borders mt-2 w-50 row text-left p-2">Discord: '.$users["discord"].'</div>';
}

$dl->print('<br>
<div class=" rounded row row-cols-1 row-cols-md-3">

<div class="col">
	<div class="mx-auto borders p-1 text-center card" style="width: 350px; border-radius: 10px;">Profile</div> 
	<div class="overflow borders mt-2 card mx-auto" style="height: 473px; width: 350px; border-radius: 10px;">
	  <div id="header" style="background: url('.$banner.'); background-size: cover; background-position: center center;"></div>
	  <div id="profile">
		<div class="image">
			<img class="izi2 card border-white" style="padding: 2px;" src="https://hentaidash.tk/dashboard/accounts/'.$avatar.'" alt="" />
		</div>
		<div class="name">
		  '.$users["userName"].'
		</div>
		<div class="nickname">
		  @'.$users["role"].' '.$badgeadm.' '.$badgedev.' '.$badgebug.' '.$badgeverify.'
		</div>
		<div>
			<div class="row row-cols-1 row-cols-md-7 card w-100 borders">
				<div class="col mt-2 text-center">
					<img src="https://gdbrowser.com/icon/colon?form=cube&icon='.$users["accIcon"].'&col1='.$users["color1"].'&col2='.$users["color2"].'&glow='.$users["accGlow"].'&noUser=1&size=35">
					<img src="https://gdbrowser.com/icon/colon?form=ship&icon='.$users["accShip"].'&col1='.$users["color1"].'&col2='.$users["color2"].'&glow='.$users["accGlow"].'&noUser=1&size=35">
					<img src="https://gdbrowser.com/icon/colon?form=ball&icon='.$users["accBall"].'&col1='.$users["color1"].'&col2='.$users["color2"].'&glow='.$users["accGlow"].'&noUser=1&size=35">
					<img src="https://gdbrowser.com/icon/colon?form=ufo&icon='.$users["accBird"].'&col1='.$users["color1"].'&col2='.$users["color2"].'&glow='.$users["accGlow"].'&noUser=1&size=35">
					<img src="https://gdbrowser.com/icon/colon?form=wave&icon='.$users["accDart"].'&col1='.$users["color1"].'&col2='.$users["color2"].'&glow='.$users["accGlow"].'&noUser=1&size=35">
					<img src="https://gdbrowser.com/icon/colon?form=robot&icon='.$users["accRobot"].'&col1='.$users["color1"].'&col2='.$users["color2"].'&glow='.$users["accGlow"].'&noUser=1&size=35">
					<img src="https://gdbrowser.com/icon/colon?form=spider&icon='.$users["accSpider"].'&col1='.$users["color1"].'&col2='.$users["color2"].'&glow='.$users["accGlow"].'&noUser=1&size=35">
				</div>	
				<div class="mt-2"></div>
			</div>
			<div class="row card w-100 borders mt-2 w-50">
				<div class="col mt-2 text-center">
					<h6 class="fs-6" style="font-width: 10px;"><i class="leps bi bi-star"></i> '.$users["stars"].'
					<i class="leps bi bi-cash"></i> '.$users["coins"].'
					<i class="leps bi bi-cash"></i> '.$users["userCoins"].'
					<i class="leps bi bi-gem"></i> '.$users["diamonds"].'
					<i class="leps bi bi-hammer"></i> '.$users["creatorpoitns"].'
					<i class="leps bi bi-emoji-angry"></i> '.$users["demons"].'</h6>
				</div>	
			</div>
			'.$discord.'
			'.$vk.'
			
			<div class="modal fade" id="info" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-center" id="exampleModalLabel">Info</h5>
						</div>
						<div class="modal-body text-left">
							<div class="row">
								<div class="col-md-9 mx-auto text-center">
									<div class="row row-cols-1 row-cols-md-4">
										<div class="mt-2 p-1"><i class="leps bi bi-clock"></i> LastPlayed: '.$dl->convertToDate($users["timestamp"]).'</div><br>
										<div class="mt-2 p-1"><i class="leps bi bi-clock-history"></i> Registered: '.$dl->convertToDate($users["registerDate"]).'</div><br>
										<div class="mt-2 p-1"><i class="leps bi bi-box"></i> Chests['.$chests.']: ('.$users["chest1"].') | ('.$users["chest2"].')</div><br>
										
										<div class="mt-2 p-1"><i class="leps bi bi-trophy"></i> Rank: ['.$leaderboard["rank"].']</div><br>
										<div class="mt-2 p-1"><i class="leps bi bi-shield"></i> Role: '.$users["role"].'</div><br>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="friends" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-center" id="exampleModalLabel">Friends ['.$countfriends.']</h5>
						</div>
						<div class="modal-body text-left">
							<div class="row">
								<div class="mx-auto text-center">
									<div class="card mt-2 borders border-white mx-auto" style="width: 650px; height: 237px;">
										<div class="row row-cols-1 mx-auto">
											'.$friends.'<br>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="comments" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-center" id="exampleModalLabel">Comments <a style="opacity: 50%;">'.$countcomments.'</a></h5>
						</div>
						<div class="modal-body text-left">
							<div class="row">
								<div class="mx-auto text-center">
									<div class="card mt-2 borders border-white mx-auto" style="width: 650px; height: 300px;">
										<div class="card scroll text-center borders border-white" style="height: 300px;">
											<br>'.$comments.'<br>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="posts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-center" id="exampleModalLabel">Posts <a style="opacity: 50%;">'.$countposts.'</a></h5>
						</div>
						<div class="modal-body text-left">
							<div class="row">
								<div class="mx-auto text-center">
									<div class="card mt-2 borders border-white mx-auto" style="width: 650px; height: 300px;">
										<div class="card scroll text-center borders border-white" style="height: 300px;">
											<br>'.$posts.'<br>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="levels" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-center" id="exampleModalLabel">Levels: <a style="opacity: 50%;">'.$countlevels.'</a></h5>
						</div>
						<div class="modal-body text-left">
							<div class="row">
								<div class="mx-auto text-center">
									<div class="card mt-2 borders border-white mx-auto" style="width: 650px; height: 300px;">
										<div class="card scroll text-center borders border-white" style="height: 300px;">
											<br>'.$levelss.'<br>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="clan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-center" id="exampleModalLabel">Clan Info:</h5>
						</div>
						<div class="modal-body text-left">
							<div class="row text-left mx-auto">
								<div class="col-md-9 mx-auto text-center">
									потом
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		
	  </div>
	</div>
	
	<div class="modal fade" id="cards" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title text-center" id="exampleModalLabel">Cards</h5>
											</div>
										<div class="modal-body text-center">
											<div class="display-inline">
												<div class="mx-auto p-1 text-center card mt-2 izi" style="background: url(https://hentaidash.tk/dashboard/src/blue.png); border-radius: 10px; background-size: cover; background-position: center center; width: 350px;"><h5 class="text-left text-white">0-499pp</h5>
												<h5 class="text-right mt-3 text-white"><br>Novice</h5></div>
												<div class="mx-auto p-1 text-center card mt-2 izi" style="background: url(https://hentaidash.tk/dashboard/src/green.png); border-radius: 10px; background-size: cover; background-position: center center; width: 350px;"><h5 class="text-left text-white">500pp</h5>
												<h5 class="text-right mt-3 text-white"><br>Advanced</h5></div>
												<div class="mx-auto p-1 text-center card mt-2 izi" style="background: url(https://hentaidash.tk/dashboard/src/orange.png); border-radius: 10px; background-size: cover; background-position: center center; width: 350px;"><h5 class="text-left text-white">1000pp</h5>
												<h5 class="text-right mt-3 text-white"><br>Medium</h5></div>
											</div>
											
											<div class="display-inline">
												<div class="mx-auto p-1 text-center card mt-2 izi" style="background: url(https://hentaidash.tk/dashboard/src/red.png); border-radius: 10px; background-size: cover; background-position: center center; width: 350px;"><h5 class="text-left text-white">2000pp</h5>
												<h5 class="text-right mt-3 text-white"><br>Expert</h5></div>
												<div class="mx-auto p-1 text-center card mt-2 izi" style="background: url(https://hentaidash.tk/dashboard/src/pink.png); border-radius: 10px; background-size: cover; background-position: center center; width: 350px;"><h5 class="text-left text-white">4000pp</h5>
												<h5 class="text-right mt-3 text-white"><br>Master</h5></div>
												<div class="mx-auto p-1 text-center card mt-2 izi demon" style="background: url(https://hentaidash.tk/dashboard/src/blue.png); border-radius: 10px; background-size: cover; background-position: center center; width: 350px;"><h5 class="text-left text-white">7500pp</h5>
												<h5 class="text-right mt-3 text-white"><br>Legend</h5></div>
												<div class="mx-auto p-1 text-center card mt-2 izi" style="background: url(https://hentaidash.tk/dashboard/src/gray.png); border-radius: 10px; background-size: cover; background-position: center center; width: 350px;"><h5 class="text-left text-white">12000pp</h5>
												<h5 class="text-right mt-3 text-white"><br>Mythical</h5></div>
											</div><br>
											
											<br>
										</div>
									</div>
								</div>
							</div>
</div>

<div class="col">

	<div class="mx-auto borders p-1 text-center card" style="width: 350px; border-radius: 10px;">Achievements [0/0]</div> 
	<div class="overflow text-center mx-auto scroll mt-2 borders p-1 card" style="width: 350px; height: 350px; border-radius: 10px;">
		<div>'.$achievments.'</div>
	</div>
	<div class="col"><a href="#" data-bs-toggle="modal" data-bs-target="#cards" style="text-decoration: none;">'.$legendary.'</a></div>
</div>

<div class="col">
	<div class="mx-auto borders p-1 text-center card" style="width: 330px; border-radius: 10px;">Sections</div> 
	<div class="mx-auto borders p-1 text-center card mt-2" style="width: 330px; height: 350px; border-radius: 10px;">
		<button type="button" class="btn govnishe w-100 mt-1" style="background-color: #b598f5;" data-bs-toggle="modal" data-bs-target="#levels" data-toggle="modal"><i class="bi bi-folder2-open"></i> Levels</button>
		<button type="button" class="btn govnishe w-100 mt-1" style="background-color: #b598f5;" data-bs-toggle="modal" data-bs-target="#posts" data-toggle="modal"><i class="bi bi-chat-right"></i> Posts</button>
		<button type="button" class="btn govnishe w-100 mt-1" style="background-color: #b598f5;" data-bs-toggle="modal" data-bs-target="#comments" data-toggle="modal"><i class="bi bi-chat-text"></i> Comments</button>
		<button type="button" class="btn govnishe w-100 mt-1" style="background-color: #b598f5;" data-bs-toggle="modal" data-bs-target="#friends" data-toggle="modal"><i class="bi bi-people"></i> Friends</button>
	</div>
	
</div>


</div><br>');
?>
<script src="../src/vanilla-tilt.min.js"></script>
    <script>
      VanillaTilt.init(document.querySelectorAll(".izi"),{
        glare: true,
        reverse: true,
        "max-glare": 0.7
      });
    </script>