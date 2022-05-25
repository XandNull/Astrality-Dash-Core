<?php
// =============================================================================
chdir(dirname(__FILE__));
include("../../lib/connection.php");
require_once("funcLib.php");

$time = time();
$funcLib = new funcLib();

// =============================================================================
if(empty($_POST["weekly"]) OR $_POST["weekly"] == 0){
	$timeType = 0; // Тайм Уровень
	$query=$db->prepare("SELECT COUNT(*) FROM dailyfeatures WHERE type = 0");
	$query->execute();
	if($query->fetchColumn() == 0){
		// =========================================================================
		$levelID = $funcLib->getRandomTimeLevelID(0);
		$midnight = floor($time/1800)*1800;
		// =========================================================================
		$levelAll = $funcLib->getAllDataFromLevel($levelID);
		$starStars = $levelAll[0]["starStars"];
		// =========================================================================
		$midnight2 = $midnight + $funcLib->getTimeFromStars($starStars, 0)[0];
		$levelID2 = $funcLib->getRandomTimeLevelID(0);
		// =========================================================================
		$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type, name) VALUES (:levelID, :uploadDate, 0, 'TimeLevel')");
		$query->execute([':levelID' => $levelID, ':uploadDate' => $midnight]);

		$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type, name) VALUES (:levelID, :uploadDate, 0, 'TimeLevel')");
		$query->execute([':levelID' => $levelID2, ':uploadDate' => $midnight2]);
		
		$funcLib->discord("New Daily Level!", $levelID);

// =============================================================================
	}else{
// =============================================================================
		$last = $funcLib->getTimeLevelsForTime(0);
		$f_timestamp = $last[0][2];
		// =========================================================================
		if ($time >= $f_timestamp) {
			$levelID = $funcLib->getRandomTimeLevelID(0);
			$levelAll = $funcLib->getAllDataFromLevel($levelID);

			$starStars = $levelAll[0]["starStars"];
			$timestamp = $f_timestamp + $funcLib->getTimeFromStars($starStars, 0)[0];
			// =======================================================================
			if ($time >= $timestamp) {
				$midnight = floor($time/1800)*1800;
				$midnight2 = $midnight + $funcLib->getTimeFromStars($starStars, 0)[0];
				$levelID2 = $funcLib->getRandomTimeLevelID(0);
				// =====================================================================
				$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type, name) VALUES (:levelID, :uploadDate, 0, 'TimeLevel')");
				$query->execute([':levelID' => $levelID, ':uploadDate' => $midnight]);

				$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type, name) VALUES (:levelID, :uploadDate, 0, 'TimeLevel')");
				$query->execute([':levelID' => $levelID2, ':uploadDate' => $midnight2]);
				
				$funcLib->discord("New Daily Level!", $levelID);
// =============================================================================
			}else{
// =============================================================================
				$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type, name) VALUES (:levelID, :uploadDate, 0, 'TimeLevel')");
				$query->execute([':levelID' => $levelID, ':uploadDate' => $timestamp]);
				
				$funcLib->discord("New Daily Level!", $levelID);
			}
		}
	}
// =============================================================================
}else{
// =============================================================================
	$timeType = 1; // Тайм Демон
	$query=$db->prepare("SELECT COUNT(*) FROM dailyfeatures WHERE type = 1");
	$query->execute();
	// ===========================================================================
	if($query->fetchColumn() == 0){
		$levelID = $funcLib->getRandomTimeLevelID(1);
		$midnight = floor($time/1800)*1800;
		// =========================================================================
		$levelAll = $funcLib->getAllDataFromLevel($levelID);
		$starDemonDiff = $levelAll[0]["starDemonDiff"];
		// =========================================================================
		$midnight2 = $midnight + $funcLib->getTimeFromStars($starDemonDiff, 1)[0];
		$levelID2 = $funcLib->getRandomTimeLevelID(1);
		// =========================================================================
		$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type, name) VALUES (:levelID, :uploadDate, 1, 'TimeDemon')");
		$query->execute([':levelID' => $levelID, ':uploadDate' => $midnight]);

		$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type, name) VALUES (:levelID, :uploadDate, 1, 'TimeDemon')");
		$query->execute([':levelID' => $levelID2, ':uploadDate' => $midnight2]);
		
		$funcLib->discord("New Daily Demon!", $levelID);
// =============================================================================
	}else{
// =============================================================================
		$last = $funcLib->getTimeLevelsForTime(1);
		$f_timestamp = $last[0][2];
		// =========================================================================
		if ($time >= $f_timestamp) {
			$levelID = $funcLib->getRandomTimeLevelID(1);
			$levelAll = $funcLib->getAllDataFromLevel($levelID);

			$starDemonDiff = $levelAll[0]["starDemonDiff"];
			$timestamp = $f_timestamp + $funcLib->getTimeFromStars($starDemonDiff, 1)[0];
			// =======================================================================
			if ($time >= $timestamp) {
				$midnight = floor($time/1800)*1800;
				$midnight2 = $midnight + $funcLib->getTimeFromStars($starDemonDiff, 1)[0];
				$levelID2 = $funcLib->getRandomTimeLevelID(1);
				// =====================================================================
				$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type, name) VALUES (:levelID, :uploadDate, 1, 'TimeDemon')");
				$query->execute([':levelID' => $levelID, ':uploadDate' => $midnight]);

				$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type, name) VALUES (:levelID, :uploadDate, 1, 'TimeDemon')");
				$query->execute([':levelID' => $levelID2, ':uploadDate' => $midnight2]);
				
				$funcLib->discord("New Daily Demon!", $levelID);
// =============================================================================
			}else{
// =============================================================================
				$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type, name) VALUES (:levelID, :uploadDate, 1, 'TimeDemon')");
				$query->execute([':levelID' => $levelID, ':uploadDate' => $timestamp]);
				
				$funcLib->discord("New Daily Demon!", $levelID);
			}
		}
	}
}
// =============================================================================
if($_POST["weekly"] != '') {
	$last = $funcLib->getTimeLevelsForTime($timeType);
	if ($timeType == 1) {
		echo $last[1][0]+100001 ."|". ($last[0][2]-time());
	}else{
		echo $last[1][0] ."|". ($last[0][2]-time());
	}
}
// =============================================================================
?>
