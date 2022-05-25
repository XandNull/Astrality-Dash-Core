<?php
// =============================================================================
class funcLib {
// =============================================================================
  //получение времени на уровень
  public function getTimeFromStars($diff, $type) {
    //если это Тайм Левел
    if($type == 0) {
      $stars = $diff;
      if(($stars == 8) OR ($stars == 9)) {
        $timestamp = 7200; // 2 часа
        $timeleft = '2 часа';
      }
      if(($stars == 6) OR ($stars == 7)) {
        $timestamp = 5400; // 1 час 30 минут
        $timeleft = '1 час 30 минут';
      }
      if(($stars == 4) OR ($stars == 5)) {
        $timestamp = 3600; // 1 час
        $timeleft = '1 час';
      }
      if(($stars == 2) OR ($stars == 3)) {
        $timestamp = 1800; // 30 минут
        $timeleft = '30 минут';
      }
      return [$timestamp, $timeleft];
    }
    // =========================================================================
    //если это Тайм Демон
    if($type == 1) {
      switch ($diff) {
        case 3;
          $diff = 'Изи демон';
          $timestamp = 129600; // 1 день 12 часов
          $timeleft = '1 день 12 часов';
          break;
        case 4;
          $diff = 'Медиум демон';
          $timestamp = 259200; // 3 дня
          $timeleft = '3 дня';
          break;
        default:
          $diff = 'НЕВОЗМОЖНЫЙ ДЕМОН';
      }
      return [$timestamp, $timeleft];
    }
  }
// =============================================================================
  //получение рандомного уровня по правилу по типу
  public function getRandomTimeLevelID($type) {
    include("../../lib/connection.php");

    //если это Тайм Левел
    if($type == 0) {
      $query = $db->prepare("SELECT levelID FROM levels WHERE starFeatured = 1 AND starDemon = 0 AND starStars > 1 ORDER BY rand() LIMIT 1");
      $query->execute();
      $query = $query->fetchColumn();

      return $query;
    }
    // =========================================================================
    //если это Тайм Демон
    if($type == 1) {
      $query = $db->prepare("SELECT levelID FROM levels WHERE starDemon = 1 AND starFeatured = 1 AND (starDemonDiff = 3 OR starDemonDiff = 4) ORDER BY rand() LIMIT 1");
      $query->execute();
      $query = $query->fetchColumn();

      return $query;
    }
  }
// =============================================================================
  //получение всей информации об уровне по Айди
  public function getAllDataFromLevel($levelID) {
    include("../../lib/connection.php");

    $query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
    $query->execute([':levelID' => $levelID]);
    $query = $query->fetchAll();

    return $query;
  }
// =============================================================================
  //получение списка Таймов по типу с сортировкой по Времени добавления
  public function getTimeLevelsForTime($type) {
    include("../../lib/connection.php");

    //если это Тайм Левел
    if($type == 0) {
      $query = $db->prepare("SELECT * FROM dailyfeatures WHERE type = 0 ORDER BY timestamp DESC");
      $query->execute();
      $query = $query->fetchAll();

      return $query;
    }
    // =========================================================================
    //если это Тайм Демон
    if($type == 1) {
      $query = $db->prepare("SELECT * FROM dailyfeatures WHERE type = 1 ORDER BY timestamp DESC");
      $query->execute();
      $query = $query->fetchAll();

      return $query;
    }
  }
// =============================================================================
  public function discord($message, $levelID) {
	include("../../lib/connection.php");
	$funcLib = new funcLib();
	
	$levelAll = $funcLib->getAllDataFromLevel($levelID);
	$starStars = $levelAll[0]["starStars"];
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
	
	$description = base64_decode($levelDesc);
	
    $webhookurl = "https://discord.com/api/webhooks/958651174221926430/KQN45s8Z1tPXGRJe6hIigF6zKG_MFNfh2YDu0MvkRNxLjO7FdGe34Qksq4Zyus6rxIU4";

	$timestamp = date("c", strtotime("now"));

	$json_data = json_encode([
	  
		"embeds" => [
			[
				"title" => $message,
				
				"timestamp" => $timestamp,

				"color" => hexdec( $hex ),
				
				"fields" => [
					[
						"name" => $levelName.' [ID: '.$levelID.']',
						"value" => 'by '.$userName,
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
