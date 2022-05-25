<?php
class Commands {
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
		$levelName = $levelAll[0]["levelName"];
		$levelDesc = $levelAll[0]["levelDesc"];
		$downloads = $levelAll[0]["downloads"];
		$levelLength = $levelAll[0]["levelLength"];
		$likes = $levelAll[0]["likes"];
		$userName = $levelAll[0]["userName"];
		$starAuto = $levelAll[0]["starAuto"];
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
	public function ownCommand($comment, $command, $accountID, $targetExtID){
		require_once "../lib/mainLib.php";
		$gs = new mainLib();
		$commandInComment = strtolower("!".$command);
		$commandInPerms = ucfirst(strtolower($command));
		$commandlength = strlen($commandInComment);
		if(substr($comment,0,$commandlength) == $commandInComment AND (($gs->checkPermission($accountID, "command".$commandInPerms."All") OR ($targetExtID == $accountID AND $gs->checkPermission($accountID, "command".$commandInPerms."Own"))))){
			return true;
		}
		return false;
	}
	public function doCommands($accountID, $comment, $levelID) {
		chdir(__DIR__);
		include "../lib/connection.php";
		require_once "../lib/exploitPatch.php";
		require_once "../lib/mainLib.php";
		$ep = new exploitPatch();
		$gs = new mainLib();
		$commentarray = explode(' ', $comment);
		$uploadDate = time();
		//LEVELINFO
		$query2 = $db->prepare("SELECT extID FROM levels WHERE levelID = :id");
		$query2->execute([':id' => $levelID]);
		$targetExtID = $query2->fetchColumn();
		//ADMIN COMMANDS
		if(substr($comment,0,5) == '!rate' AND $gs->checkPermission($accountID, "commandRate")){
			$starStars = $commentarray[2];
			if($starStars == ""){
				$starStars = 0;
			}
			$starCoins = $commentarray[3];
			$starFeatured = $commentarray[4];
			$diffArray = $gs->getDiffFromName($commentarray[1]);
			$starDemon = $diffArray[1];
			$starAuto = $diffArray[2];
			$starDifficulty = $diffArray[0];
			$query = $db->prepare("UPDATE levels SET starStars=:starStars, starDifficulty=:starDifficulty, starDemon=:starDemon, starAuto=:starAuto WHERE levelID=:levelID");
			$query->execute([':starStars' => $starStars, ':starDifficulty' => $starDifficulty, ':starDemon' => $starDemon, ':starAuto' => $starAuto, ':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
			$query->execute([':value' => $commentarray[1], ':timestamp' => $uploadDate, ':id' => $accountID, ':value2' => $starStars, ':levelID' => $levelID]);
			if($starFeatured != ""){
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => $starFeatured, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);	
				$query = $db->prepare("UPDATE levels SET starFeatured=:starFeatured WHERE levelID=:levelID");
				$query->execute([':starFeatured' => $starFeatured, ':levelID' => $levelID]);
			}
			if($starCoins != ""){
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('3', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => $starCoins, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				$query = $db->prepare("UPDATE levels SET starCoins=:starCoins WHERE levelID=:levelID");
				$query->execute([':starCoins' => $starCoins, ':levelID' => $levelID]);
			}
			exit("temp_0_Level successfully rated!.");
			return true;
		}
		if(substr($comment,0,7) == '!unrate' AND $gs->checkPermission($accountID, "commandRate")){
			if (isset($commentArray[1]) AND is_numeric($commentArray[1])) {
				$keepDiff = $commentArray[1];
				if ($keepDiff >= 1) {
					$keepDiff = 1;
				} else {
					$keepDiff = 0;
				}
			} else {
				$keepDiff = 0;
			}
			if (isset($commentArray[2]) AND is_numeric($commentArray[2])) {
				$unfeature = $commentArray[2];
			if ($unfeature >= 1) {
				$unfeature = 1;
			} else {
				$unfeature = 0;
			}
			} else {
				$unfeature = 0;
			}
			if (isset($commentArray[3]) AND is_numeric($commentArray[3])) {
				$unverifyCoins = $commentArray[3];
				if ($unverifyCoins >= 1) {
					$unverifyCoins = 1;
				} else {
					$unverifyCoins = 0;
				}
			} else {
				$unverifyCoins = 0;
			}

			$response = "unrated";
			$featureLevel = 0;
			$query = $db->prepare("SELECT starStars, starFeatured, isCPShared FROM levels WHERE levelID = :levelID");
			$query->execute([':levelID' => $levelID]);
			$result = $query->fetch();
			if ($result["starStars"] == 1) {
				if ($result["isCPShared"] == 1) {
					$query3 = $db->prepare("SELECT userID FROM cpshares WHERE levelID = :levelID");
					$query3->execute([':levelID' => $levelID]);
					$deservedcp = $starCP;
					if ($gs->checkPermission($accountID, "commandFeature") AND $result["starFeatured"] == 0 AND $unfeature == 1) {
						$deservedcp += $featureCP;
						$featureLevel = 1;
					}
					if ($CPSharedWhole == 1) {
						$addCP = $deservedcp;
					} else {
						$sharecount = $query3->rowCount() + 1;
						$addCP = round($deservedcp / $sharecount);
					}
					$shares = $query->fetchAll();
					$CPShare = round($addCP);
					foreach ($shares as &$share) {
						$query4 = $db->prepare("UPDATE users SET creatorPoints = creatorPoints + :CPShare WHERE userID = :userID");
						$query4->execute([':userID' => $share["userID"], ':CPShare' => $CPShare]);
					}
				} else {
					$query4 = $db->prepare("UPDATE users SET creatorPoints = creatorPoints + :addCP WHERE extID = :extID");
					$query4->execute([':extID' => $targetExtID, ':addCP' => $starCP]);
				}
			}

			$query = $db->prepare("UPDATE levels SET starStars = 0, starDemon = 0, starAuto = 0 WHERE levelID = :levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("SELECT starDifficulty FROM levels WHERE levelID = :levelID");
			$query->execute([':levelID' => $levelID]);
			$levelDiff = $query->fetchColumn();
			$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES (1, :value, 0, :levelID, :timestamp, :id)");
			$query->execute([':value' => $gs->getDifficulty($levelDiff, 0, 0), ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			$response .= " without changing the difficulty";

			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES (2, 0, :levelID, :timestamp, :id)");
			$query->execute([':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			$query = $db->prepare("UPDATE levels SET starFeatured=0 WHERE levelID = :levelID");
			$query->execute([':levelID' => $levelID]);
			$response .= " and unfeatured";

			$query = $db->prepare("UPDATE levels SET starCoins='0' WHERE levelID = :levelID");
			$query->execute([':levelID' => $levelID]);
			
			$query = $db->prepare("UPDATE levels SET starEpic='0' WHERE levelID = :levelID");
			$query->execute([':levelID' => $levelID]);
			
			$query = $db->prepare("UPDATE levels SET starDemonDiff='0' WHERE levelID = :levelID");
			$query->execute([':levelID' => $levelID]);
			include "cp.php";
			$commands = new commands();
			$commands->discord('Level Unrated.', $levelID, $accountID);
			exit("temp_0_Level successfully $response.");
			return true;
		}
		if(substr($comment,0,10) == '!unfeature' AND $gs->checkPermission($accountID, "commandFeature")){
			$query = $db->prepare("UPDATE levels SET starFeatured='0' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			include "cp.php";
			$commands = new commands();
			$commands->discord('Level unfeatured.. ', $levelID, $accountID);
			exit("temp_0_Level successfully unfeatured.");
			return true;
		}
		if(substr($comment,0,5) == '!epic' AND $gs->checkPermission($accountID, "commandEpic")){
			$query = $db->prepare("UPDATE levels SET starEpic='1' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('4', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			include "cp.php";
			$commands = new commands();
			$commands->discord('New epic level! ', $levelID, $accountID);
			exit("temp_0_Level successfully rated epic.");
			return true;
		}
		if(substr($comment,0,7) == '!unepic' AND $gs->checkPermission($accountID, "commandUnepic")){
			$query = $db->prepare("UPDATE levels SET starEpic='0' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('4', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "0", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			include "cp.php";
			$commands = new commands();
			$commands->discord('Level unepiced.. ', $levelID, $accountID);
			exit("temp_0_Level successfully unepic.");
			return true;
		}
		if(substr($comment,0,10) == '!legendary' AND $gs->checkPermission($accountID, "commandEpic")){
			$query = $db->prepare("UPDATE levels SET legendary='1' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("SELECT userName FROM accounts WHERE accountID = :userName LIMIT 1");
			$query->execute([':userName' => $accountID]);
			if($query->rowCount() == 0){
				return false;
			}
			$commands = new commands();
			$commands->discord('Level legend.. ', $levelID, $accountID);
			exit("temp_0_Level successfully legend.");
			return true;
		}
		if(substr($comment,0,12) == '!unlegendary' AND $gs->checkPermission($accountID, "commandUnepic")){
			$query = $db->prepare("UPDATE levels SET legendary='0' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("SELECT userName FROM accounts WHERE accountID = :userName LIMIT 1");
			$query->execute([':userName' => $accountID]);
			if($query->rowCount() == 0){
				return false;
			}
			$commands = new commands();
			$commands->discord('Level unlegend.. ', $levelID, $accountID);
			exit("temp_0_Level successfully unlegend.");
			return true;
		}
		
		if(substr($comment,0,7) == '!layout' AND $gs->checkPermission($accountID, "commandEpic")){
			$query = $db->prepare("UPDATE levels SET gp='1' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("SELECT userName FROM accounts WHERE accountID = :userName LIMIT 1");
			$query->execute([':userName' => $accountID]);
			if($query->rowCount() == 0){
				return false;
			}
			$commands = new commands();
			$commands->discord('Layout', $levelID, $accountID);
			exit("temp_0_Level successfully layouted.");
			return true;
		}
		if(substr($comment,0,9) == '!unlayout' AND $gs->checkPermission($accountID, "commandUnepic")){
			$query = $db->prepare("UPDATE levels SET gp='0' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("SELECT userName FROM accounts WHERE accountID = :userName LIMIT 1");
			$query->execute([':userName' => $accountID]);
			if($query->rowCount() == 0){
				return false;
			}
			$commands = new commands();
			$commands->discord('Unlayout', $levelID, $accountID);
			exit("temp_0_Level successfully unlayouted.");
			return true;
		}
		
		if(substr($comment,0,12) == '!verifycoins' AND $gs->checkPermission($accountID, "commandVerifycoins")){
			$query = $db->prepare("UPDATE levels SET starCoins='1' WHERE levelID = :levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			exit("temp_0_Coins successfully verified.");
			return true;
		}
		if(substr($comment,0,7) == '!setacc' AND $gs->checkPermission($accountID, "commandSetacc")){
			$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName OR accountID = :userName LIMIT 1");
			$query->execute([':userName' => $commentarray[1]]);
			if($query->rowCount() == 0){
				return false;
			}
			$targetAcc = $query->fetchColumn();
			//var_dump($result);
			$query = $db->prepare("SELECT userID FROM users WHERE extID = :extID LIMIT 1");
			$query->execute([':extID' => $targetAcc]);
			$userID = $query->fetchColumn();
			$query = $db->prepare("UPDATE levels SET extID=:extID, userID=:userID, userName=:userName WHERE levelID=:levelID");
			$query->execute([':extID' => $targetAcc, ':userID' => $userID, ':userName' => $commentarray[1], ':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('7', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => $commentarray[1], ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			exit("temp_0_Successfully set account to $commentarray[1].");
			return true;
		}
		if(substr($comment,0,12) == '!disablesong' AND $gs->checkPermission($accountID, "isAdmin")){
			if (isset($commentArray[1]) AND is_numeric($commentArray[1])) {
				$song = $commentArray[1];
				$response = "Song ID $song";
			} else {
				$query = $db->prepare("SELECT songID FROM levels WHERE levelID = :levelID");
				$query->execute([':levelID' => $levelID]);
				$song = $query->fetchColumn();
				$response = "This level's song (ID $song)";
			}
			$query = $db->prepare("SELECT count(*) FROM songs WHERE ID = :song");
			$query->execute([':song' => $song]);
			if ($query->fetchColumn() <= 0) {
				exit("temp_0_Error: Song not found.");
			}
			$query = $db->prepare("UPDATE songs SET isDisabled = 1 WHERE ID = :song");
			$query->execute([':song' => $song]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value2, timestamp, account, value3) VALUES (18, 0, :value2, :timestamp, :id, :levelID)");
			$query->execute([':value2' => $song, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			exit("temp_0_$response has been disabled for use.");
			return true;
		}
		if(substr($comment,0,11) == '!enablesong' AND $gs->checkPermission($accountID, "isAdmin")){
			if (isset($commentArray[1]) AND is_numeric($commentArray[1])) {
				$song = $commentArray[1];
				$response = "Song ID $song";
			} else {
				$query = $db->prepare("SELECT songID FROM levels WHERE levelID = :levelID");
				$query->execute([':levelID' => $levelID]);
				$song = $query->fetchColumn();
				$response = "This level's song (ID $song)";
			}
			$query = $db->prepare("SELECT count(*) FROM songs WHERE ID=:song");
			$query->execute([':song' => $song]);
			if ($query->fetch() <= 0) {
				exit("temp_0_Error: Song not found.");
			}
			$query = $db->prepare("UPDATE songs SET isDisabled = 0 WHERE ID = :song");
			$query->execute([':song' => $song]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value2, timestamp, account, value3) VALUES (18, 1, :value2, :timestamp, :id, :levelID)");
			$query->execute([':value2' => $song, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			exit("temp_0_$response has been enabled for use.");
			return true;
		}
		if(substr($comment,0,4) == '!ban' AND $gs->checkPermission($accountID, "isAdmin")){
			$name = $ep->remove(str_replace("!ban ", "", $comment));
			$query = $db->prepare("UPDATE users SET isBanned = '1' WHERE userName=:levelID");
			$query->execute([':levelID' => $name]);
			exit("temp_0_$name has been banned.");
			return true;
		}
		if(substr($comment,0,6) == '!unban' AND $gs->checkPermission($accountID, "isAdmin")){
			$name = $ep->remove(str_replace("!unban ", "", $comment));
			$query = $db->prepare("UPDATE users SET isBanned = '0' WHERE userName=:levelID");
			$query->execute([':levelID' => $name]);
			exit("temp_0_$name has been unbanned.");
			return true;
		}
		
	//NON-ADMIN COMMANDS
		if($this->ownCommand($comment, "rename", $accountID, $targetExtID)){
			$name = $ep->remove(str_replace("!rename ", "", $comment));
			$query = $db->prepare("UPDATE levels SET levelName=:levelName WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID, ':levelName' => $name]);
			$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('8', :value, :timestamp, :id, :levelID)");
			$query->execute([':value' => $name, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			exit("temp_0_Successfully renamed to $name.");
			return true;
		}
		if($this->ownCommand($comment, "pass", $accountID, $targetExtID)){
			$pass = $ep->remove(str_replace("!pass ", "", $comment));
			if(is_numeric($pass)){
				$pass = sprintf("%06d", $pass);
				if($pass == "000000"){
					$pass = "";
				}
				$pass = "1".$pass;
				$query = $db->prepare("UPDATE levels SET password=:password WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID, ':password' => $pass]);
				$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('9', :value, :timestamp, :id, :levelID)");
				$query->execute([':value' => $pass, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				exit("temp_0_Successfully set pass to $pass.");
				return true;
			}
		}
		if($this->ownCommand($comment, "song", $accountID, $targetExtID)){
			$song = $ep->remove(str_replace("!song ", "", $comment));
			if(is_numeric($song)){
				$query = $db->prepare("UPDATE levels SET songID=:song WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID, ':song' => $song]);
				$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('16', :value, :timestamp, :id, :levelID)");
				$query->execute([':value' => $song, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				exit("temp_0_Successfully set song to $song.");
				return true;
			}
		}
		if($this->ownCommand($comment, "description", $accountID, $targetExtID)){
			$desc = base64_encode($ep->remove(str_replace("!description ", "", $comment)));
			$query = $db->prepare("UPDATE levels SET levelDesc=:desc WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID, ':desc' => $desc]);
			$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('13', :value, :timestamp, :id, :levelID)");
			$query->execute([':value' => $desc, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			exit("temp_0_Successfully new description to $desc.");
			return true;
		}
		if($this->ownCommand($comment, "public", $accountID, $targetExtID)){
			$query = $db->prepare("UPDATE levels SET unlisted='0' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('12', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "0", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			exit("temp_0_Successfully.");
			return true;
		}
		if($this->ownCommand($comment, "unlist", $accountID, $targetExtID)){
			$query = $db->prepare("UPDATE levels SET unlisted='1' WHERE levelID=:levelID AND starStars = '0'");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('12', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			exit("temp_0_Successfully.");
			return true;
		}
		if($this->ownCommand($comment, "ldm", $accountID, $targetExtID)){
			$query = $db->prepare("UPDATE levels SET isLDM='1' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('14', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			exit("temp_0_Successfully.");
			return true;
		}
		if($this->ownCommand($comment, "unldm", $accountID, $targetExtID)){
			$query = $db->prepare("UPDATE levels SET isLDM='0' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('14', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "0", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			exit("temp_0_Successfully.");
			return true;
		}
		return false;
	}
	public function doProfileCommands($accountID, $command){
		include dirname(__FILE__)."/../lib/connection.php";
		require_once "../lib/exploitPatch.php";
		require_once "../lib/mainLib.php";
		$ep = new exploitPatch();
		$gs = new mainLib();
		return false;
	}
}
?>
