<?php
chdir(__DIR__);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../lib/mainLib.php";
$gs = new mainLib();
$gjp = $ep->remove($_POST["gjp"]);
$stars = $ep->remove($_POST["stars"]);
$feature = $ep->remove($_POST["feature"]);
$levelID = $ep->remove($_POST["levelID"]);
$accountID = $ep->remove($_POST["accountID"]);
class send {
	public function discord($message, $levelID, $accountID){
		include("../lib/connection.php");
		
		$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $levelID]);
		$levelAll = $query->fetchAll();
		
		$query = $db->prepare("SELECT * FROM users WHERE extID = :accountID");
		$query->execute([':accountID' => $accountID]);
		$userAll = $query->fetchAll();
		
		$userNames = $userAll[0]["userName"];
		$starStars = $levelAll[0]["starStars"];
		$starAuto = $levelAll[0]["auto"];
		$levelName = $levelAll[0]["levelName"];
		$levelDesc = $levelAll[0]["levelDesc"];
		$downloads = $levelAll[0]["downloads"];
		$levelLength = $levelAll[0]["levelLength"];
		$likes = $levelAll[0]["likes"];
		$userName = $levelAll[0]["userName"];
		$starDifficulty = $levelAll[0]["starDifficulty"];
		$starDemonDiff = $levelAll[0]["starDemonDiff"];
		
		if(empty($levelDesc)){
			$levelDesc = 'bm8gZGVzY3JpcHRpb24=';
		}
		
		if($starDifficulty == "10"){
			$difficulty = "<:easy:878984619716935731>";
			$diffname = "easy";
			$hex = '3366ff';
		}elseif($starDifficulty == "20"){
			$difficulty = "<:normal:878984620195074079>";
			$diffname = "normal";
			$hex = '33ff47';
		}elseif($starDifficulty == "30"){
			$difficulty = "<:hard:878984620270559302>";
			$diffname = "hard";
			$hex = 'fcff33';
		}elseif($starDifficulty == "40"){
			$difficulty = "<:harder:878984620421558272>";
			$diffname = "harder";
			$hex = 'ff7033';
		}elseif($starDifficulty == "50"){
			$difficulty = "<:insane:878984620513832970>";
			$diffname = "insane";
			$hex = 'a733ff';
		}else{
			$difficulty = "?";
			$diffname = "na";
			$hex = '878787';
		}
		
		if($starDemonDiff == "1"){
			$difficulty = "<:dhard:879009560390680576>";
			$diffname = "hard";
			$hex = 'ff4b33';
		}elseif($starDemonDiff == "2"){
			$difficulty = "<:dhard:879009560390680576>";
			$diffname = "hard";
			$hex = 'ff4b33';
		}elseif($starDemonDiff == "3"){
			$difficulty = "<:deasy:878995410386047006>";
			$diffname = "easy";
			$hex = '3366ff';
		}elseif($starDemonDiff == "4"){
			$difficulty = "<:dmedium:878995410608332820>";
			$diffname = "medium";
			$hex = 'dc52ff';
		}elseif($starDemonDiff == "5"){
			$difficulty = "<:dinsane:879009560776572949>";
			$diffname = "insane";
			$hex = '993123';
		}elseif($starDemonDiff == "6"){
			$difficulty = "<:dextreme:879009560201949207>";
			$diffname = "extreme";
			$hex = '000';
		}
		
		if($starStars == "1"){
			$difficulty = "<:auto:880511020383223870>";
			$diffname = "auto";
			$hex = 'fcff33';
		}
		
		$description = base64_decode($levelDesc);
		
		$webhookurl = "https://discord.com/api/webhooks/956219046540484649/INMP3aML4v-GpNsPgiRAJ4n9fvSsKFsWqtHb76xwx0ueypjWEmscqCMEobjaZWOIE4b3";

		$timestamp = date("c", strtotime("now"));

		$json_data = json_encode([
		  
			"embeds" => [
				[
					"title" => $message,
					
					"description" => 'Action by '.$userNames,
					
					"timestamp" => $timestamp,

					"color" => hexdec( $hex ),
					
					"fields" => [
						[
							"name" => $levelName.' [ID: '.$levelID.'] by '.$userName,
							"value" => 'Stars: '.$starStars.' | Difficulty: '.$diffname.' | Likes: '.$likes.' | Downloads: '.$downloads,
							"inline" => false
						],
						[
							"name" => "Description",
							"value" => $description,
							"inline" => true
						]
					]
				]
			]

		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


		$ch = curl_init( $webhookurl );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		curl_setopt( $ch, CURLOPT_POST, 1);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt( $ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec( $ch );
		curl_close( $ch );
	}
}
if($accountID != "" AND $gjp != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$accountID);
	if($gjpresult == 1){
		$query = $db->prepare("SELECT unlisted FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $levelID]);
		$unlisted = $query->fetchColumn();
		if($unlisted == "1"){
			exit("-2");
		}
		$difficulty = $gs->getDiffFromStars($stars);
		if($gs->checkPermission($accountID, "actionRateStars")){
			$gs->rateLevel($accountID, $levelID, $stars, $difficulty["diff"], $difficulty["auto"], $difficulty["demon"]);
			$gs->featureLevel($accountID, $levelID, $feature);
			$gs->verifyCoinsLevel($accountID, $levelID, 1);
			if($feature == "1"){
				$send = new send();
				$send->discord('New featured level! ', $levelID, $accountID);
			}else{
				$send = new send();
				$send->discord('New rated level! ', $levelID, $accountID);
			}
			echo 1;
		}else if($gs->checkPermission($accountID, "actionSuggestRating")){
			$gs->suggestLevel($accountID, $levelID, $difficulty["diff"], $stars, $feature, $difficulty["auto"], $difficulty["demon"]);
			echo 1;
		}else{
			echo -2;
		}
	}else{
		echo -2;
	}
}else{
	echo -2;
}
include "cp.php";
?>
