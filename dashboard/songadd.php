<?php
session_start();
if(empty($_SESSION["accountID"])){
	header("Location: accounts/login.php");
	exit();
}
require "src/dashboardLib.php";
$dl = new dashboardLib();
require "../serversdata/incl/lib/connection.php";

require_once "../serversdata/incl/lib/exploitPatch.php";
$ep = new exploitPatch();
$api_key = "bda4ada8694db06efcac9cf97b872b3e";
if(!empty($_POST["songlink"])){
$song = str_replace("www.dropbox.com","dl.dropboxusercontent.com",$_POST["songlink"]);
if (filter_var($song, FILTER_VALIDATE_URL) == TRUE) {
	$soundcloud = false;
	if(strpos($song, 'soundcloud.com') !== false){
		$soundcloud = true;
		$songinfo = file_get_contents("https://api.soundcloud.com/resolve.json?url=".$song."&client_id=".$api_key);
		$array = json_decode($songinfo);
		if($array->downloadable == true){
			$song = trim($array->download_url . "?client_id=".$api_key);
			$name = $ep->remove($array->title);
			$author = $array->user->username;
			$author = preg_replace("/[^A-Za-z0-9 ]/", '', $author);
			echo "Processing Soundcloud song ".htmlspecialchars($name,ENT_QUOTES)." by ".htmlspecialchars($author,ENT_QUOTES)." with the download link ".htmlspecialchars($song,ENT_QUOTES)." <br>";
		}else{
			$song = trim("https://api.soundcloud.com/tracks/".$array->id."/stream?client_id=".$api_key);
			$name = $ep->remove($array->title);
			$author = $array->user->username;
			$author = preg_replace("/[^A-Za-z0-9 ]/", '', $author);
		}
	}else{
		$song = str_replace("?dl=0","",$song);
		$song = str_replace("?dl=1","",$song);
		$song = trim($song);
		$name = str_replace(".mp3", "", basename($song));
		$name = str_replace(".webm", "", $name);
		$name = str_replace(".mp4", "", $name);
		$name = urldecode($name);
		$name = $ep->remove($name);
		$author = "Reupload";
	}
	$ch = curl_init($song);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_NOBODY, TRUE);
	$data = curl_exec($ch);
	$size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
	curl_close($ch);
	$size = round($size / 1024 / 1024, 2);
	$hash = "";
	$count = 0;
	$query = $db->prepare("SELECT count(*) FROM songs WHERE download = :download");
	$query->execute([':download' => $song]);	
	$count = $query->fetchColumn();
	if($count != 0){
		$dl->print('<div class="container-md text-center text-dark p-3 mt-3 w-50">
				<div class="row row-cols-1 row-cols-md-4 mx-auto">
					<div class="col w-100 p-3 mt-2 text-white" style="background-color: #b598f5; border-radius: 10px;">
						This song already exists in our database. <a class="text-white" href="songadd.php">back</a>
					</div>
				</div>
			</div>');
		exit();
	}else{
	    $query = $db->prepare("INSERT INTO songs (name, authorID, authorName, size, download, hash)
		VALUES (:name, '9', :author, :size, :download, :hash)");
		$query->execute([':name' => $name, ':download' => $song, ':author' => $author, ':size' => $size, ':hash' => $hash]);
		$dl = new dashboardLib();
		$dl->print('<div class="container-md text-center text-dark p-3 mt-3 w-50">
				<div class="row row-cols-1 row-cols-md-4 mx-auto">
					<div class="col w-100 p-3 mt-2 text-white" style="background-color: #b598f5; border-radius: 10px;">
						Song reuploaded: <b>'.$db->lastInsertId().'</b> <a class="text-white" href="songadd.php">back</a>
					</div>
				</div>
			</div>');
		exit();
	}
}
}

$dl = new dashboardLib();
$dl->print('<div class="container-md text-center text-dark p-3 mt-3 w-100">
				<div class="row row-cols-1 row-cols-md-4 mx-auto">
					<div class="col w-100 p-3 mt-2 text-white" style="background-color: #b598f5; border-radius: 10px;">
						<div class="mt-2"></div><b>Soundcloud links</b> or <b>Direct links</b> only accepted <br><form action="songadd.php" method="post">Link: <input class="mt-2 w-25" type="text" name="songlink"> <input type="submit" value="Add Song" class="btn text-dark w-25" style="background-color: #ffffff;" href="songadd.php"></input></form> 
					</div>
				</div>
			</div>');