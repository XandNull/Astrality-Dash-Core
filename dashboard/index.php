<?php
session_start();
if(empty($_SESSION["accountID"])){
	header("Location: accounts/login.php");
	exit();
}
require "src/dashboardLib.php";
$dl = new dashboardLib();
require "../serversdata/incl/lib/connection.php";

$all = $moderators + $admins;

$chartdata = array();
for($x = 7; $x >= 0;){
	$timeBefore = time() - (86400 * $x);
	$timeAfter = time() - (86400 * ($x + 1));
	$query = $db->prepare("SELECT count(*) FROM levels WHERE uploadDate < :timeBefore AND uploadDate > :timeAfter");
	$query->execute([':timeBefore' => $timeBefore, ':timeAfter' => $timeAfter]);
	switch($x){
		case 1:
			$identifier = $x . " day ago";
			break;
		case 0:
			$identifier = "Last 24 hours";
			break;
		default:
			$identifier = $x . " days ago";
			break;
	}
	$chartdata[$identifier] = $query->fetchColumn();
	$x--;
}

$levelsChart3 = array();
for($x = 7; $x >= 0;){
	$timeBefore = time() - (86400 * $x);
	$timeAfter = time() - (86400 * ($x + 1));
	$query = $db->prepare("SELECT count(*) FROM users WHERE lastPlayed < :timeBefore AND lastPlayed > :timeAfter");
	$query->execute([':timeBefore' => $timeBefore, ':timeAfter' => $timeAfter]);
	switch($x){
		case 1:
			$identifier = $x . " day ago";
			break;
		case 0:
			$identifier = "Last 24 hours";
			break;
		default:
			$identifier = $x . " days ago";
			break;
	}
	$levelsChart3[$identifier] = $query->fetchColumn();
	$x--;
}

$levelsChart2 = array();
$x = 0;
for($x = 7; $x >= 0;){
	$timeBefore = time() - (86400 * $x);
	$timeAfter = time() - (86400 * ($x + 1));
	$query = $db->prepare("SELECT count(*) FROM accounts WHERE registerDate < :timeBefore AND registerDate > :timeAfter");
	$query->execute([':timeBefore' => $timeBefore, ':timeAfter' => $timeAfter]);
	switch($x){
		case 1:
			$identifier = $x . " day ago";
			break;
		case 0:
			$identifier = "Last 24 hours";
			break;
		default:
			$identifier = $x . " days ago";
			break;
	}
	$levelsChart2[$identifier] = $query->fetchColumn();
	$x--;
}

$query = $db->prepare("SELECT count(*) FROM users");
$query->execute();
$countusers = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM acccomments");
$query->execute();
$countposts = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM comments");
$query->execute();
$countcomments = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM levels");
$query->execute();
$countlevels = $query->fetchColumn();

$compost = $countposts+$countcomments;

$query1 = $db->prepare("SELECT * FROM accounts WHERE isAdmin = 1");
$query1->execute();
$result = $query1->fetchAll();
if($query1->rowCount() == 0){
	echo 'error';
}else{
	foreach ($result as $row2) {
		$usernamelb = $row2["userName"];
		
		$query1 = $db->prepare("SELECT avatar FROM users WHERE extID = :usr");
		$query1->execute([':usr' => $row2["accountID"]]);
		$avatarik = $query1->fetchColumn();
		if($avatarik == "0"){
			$avatarik = 'avatars/1.png';
		}
		$moderatorslb .= '<div class="col mt-2 pt-2"><img src="https://hentaidash.tk/dashboard/accounts/'.$avatarik.'" style="width: 100px; border-radius: 100%;"> <br> <a class="text-dark" href="https://hentaidash.tk/dashboard/accounts/'.$usernamelb.'">'.$usernamelb.'</a></div>';
	}
}

$query = $db->prepare("SELECT * FROM accounts ORDER BY registerDate DESC LIMIT 5");
$query->execute();
$result = $query->fetchAll();

foreach($result as &$govn){
	#$times2 = date("d/m/Y ", $govn["registerDate"]);
	$lastaccounts .= "<div class='mt-2'>".$govn["userName"]."</div>";
}

$query = $db->prepare("SELECT * FROM levels WHERE unlisted != '1' ORDER BY levelID DESC LIMIT 5");
$query->execute();
$result = $query->fetchAll();

foreach($result as &$mod){

	$lastlevels .= "<div class='mt-2'>".$mod["levelName"]."</div>";
}

$dl = new dashboardLib();
$dl->print('<br><div class="container-md mt-2 text-center text-white w-100 mx-auto shadow-sm p-2" style="background-color: #b598f5; border-radius: 10px;">

	<button type="button" class="btn text-white hvr-grow ml-2" style="background-color: #b598f5;" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-cloud-download"></i> Download</button>
	<button type="button" class="btn text-white hvr-grow" style="background-color: #b598f5;" data-bs-toggle="modal" data-bs-target="#exampleModal5"><i class="bi bi-star"></i> Updates</button>
	<button type="button" class="btn text-white hvr-grow" style="background-color: #b598f5;" data-bs-toggle="modal" data-bs-target="#exampleModal1"><i class="bi bi-graph-up"></i> Graphics</button>
	<button type="button" class="btn text-white hvr-grow" style="background-color: #b598f5;" data-bs-toggle="modal" data-bs-target="#exampleModal9"><i class="bi bi-trophy"></i> Leaderboards</button>
	<button type="button" class="btn text-white hvr-grow" style="background-color: #b598f5;" data-bs-toggle="modal" data-bs-target="#exampleModal10"><i class="bi bi-check2-circle"></i> Moderators</button>
	<button type="button" class="btn text-white hvr-grow" style="background-color: #b598f5;" data-bs-toggle="modal" data-bs-target="#exampleModal11"><i class="bi bi-volume-up"></i> Songs</button>
	<button type="button" class="btn text-white hvr-grow" style="background-color: #b598f5;" data-bs-toggle="modal" data-bs-target="#exampleModal12"><i class="bi bi-hourglass"></i> Last activity</button>
	
	
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header text-dark">
					<h5 class="modal-title text-center" id="exampleModalLabel">Astrality v1.0</h5>
				</div>
				<div class="modal-body text-center">
					<div class="row text-center">
						<div class="col-md-8 mx-auto">
							<div class="row row-cols-1 row-cols-md-4 mx-auto">

							<div class="col w-50 p-3 text-white" style="border-radius: 10px 0px 0px 10px;">
								<a type="button" class="btn text-white w-50" style="background-color: #b598f5;" href="https://disk.yandex.ru/d/lgO4eP6GxKC3Fg">Android</a>
							</div>
							
							<div class="col w-50 p-3 text-white" style="border-radius: 10px 0px 0px 10px;">
								<a type="button" class="btn text-white w-50" style="background-color: #b598f5;" href="https://disk.yandex.ru/d/0E5oxHIjr-Zg0w">PC</a>
							</div>
						</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="exampleModal12" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header text-dark">
					<h5 class="modal-title text-center" id="exampleModalLabel">Last Activity</h5>
				</div>
				<div class="modal-body text-center">
					<div class="row text-center">
						<div class="col-md-8 mx-auto">
							<div class="row row-cols-1 row-cols-md-1 mx-auto text-dark">
								<div>Last accounts:</div>

								'.$lastaccounts.'
								
								<br><br><div>Last levels:</div>
								
								'.$lastlevels.'
						
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="exampleModal10" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header text-dark">
					<h5 class="modal-title text-center" id="exampleModalLabel">Astrality Team</h5>
				</div>
				<div class="modal-body text-center">
					<div class="row text-center">
						<div class="col-md-8 mx-auto">
							<div class="row row-cols-4 row-cols-md-4 mx-auto">

								'.$moderatorslb.'
						
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header text-dark">
					<h5 class="modal-title text-center" id="exampleModalLabel">Astrality API</h5>
				</div>
				<div class="modal-body text-center">
					<div class="row text-center">
						<div class="mx-auto">
							<h2>Accounts: [userName/accountID]<br>
							<a href="../api/account.php?userName=id">accounts.php?userName=GreenTea12</a><br><br>
							<div><hr class="dropdown-divider"></div>
							<h2>Levels: [levelName/levelID<br>
							<a href="../api/level.php?levelName=name">level.php?levelName=Unnamed 0</a><br><br>
							<div><hr class="dropdown-divider"></div>
							<h2>first-last/counts: <br>
							<a href="../api/first-last/index.php">last or first.php</a> | <a href="../api/count/index.php">count.php</a></h2><br>
							<h2>not work</h2><br>
							<h2>Daily: [type(1 - daily | 2 - weekly)]<br>
							<a href="../api/dailyweekly.php?type=1">dailyweekly.php?type=1</a><br><br>
							<div><hr class="dropdown-divider"></div>
							<h2>Map-Packs/Gauntlets: <br>
							<a href="../api/map-packs.php">map-packs.php</a> | <a href="../api/gauntlets.php">gauntlets.php</a></h2><br>
							<div><hr class="dropdown-divider"></div>
							<h2>Leaderboards: [global/creator/page]<br>
							<a href="../api/leaderboards.php?top=global&page=0">leaderboards.php?top=global&page=0</a><br><br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header text-dark">
					<h5 class="modal-title text-center" id="exampleModalLabel">Last Updates</h5>
				</div>
				<div class="modal-body text-center">
				
					<div class="row text-center">
						<div class="col-md-8 mx-auto text-dark">
							<div class="row row-cols-1 row-cols-md-4 mx-auto">

							<div class="col w-50 p-3 text-white" style="border-radius: 10px 0px 0px 10px;">
								<img src="https://sun9-2.userapi.com/impf/CcELajlEn7uLdXwknihMm2JjmzU_Xoyc-cX_Tg/p46xczP0cRM.jpg?size=500x500&quality=95&sign=b778794b93f5a8957abbb582b1b7d20b&type=album" class="w-75">
							</div>
							<div class="col w-50 p-3 text-dark" style="border-radius: 0px 10px 10px 0px;">
								<p class="mt-5">PP System Rebalance</p><p style="font-size: 12px;">Сделана сбалансированная система pp (Prefomance Point)</p>
							</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header text-dark">
					<h5 class="modal-title text-center" id="exampleModalLabel">Astrality Statistics</h5>
				</div>
				<div class="modal-body text-center">
					<div class="row text-center">
							<div class="chart-container" style="position: relative; height:30vh; width:80vw">
								<canvas id="levelsChart"></canvas>
							</div>
							<div class="chart-container" style="position: relative; height:30vh; width:80vw">
								<canvas id="levelsChart2"></canvas>
							</div>
							<div class="chart-container" style="position: relative; height:30vh; width:80vw">
								<canvas id="levelsChart3"></canvas>
							</div>
							</p>' . $dl->generateLineChart("levelsChart","Levels Uploaded",$chartdata) . $dl->generateLineChart("levelsChart2","Accounts Created",$levelsChart2) . $dl->generateLineChart("levelsChart3","Online",$levelsChart3) . '
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container-md text-center text-dark p-3 mt-3">
		<div class="row row-cols-1 row-cols-md-4 mx-auto">

			<div class="col w-75 p-3 mt-2 text-white" style="background-color: #b598f5; border-radius: 10px 0px 0px 10px;">
				Accounts 
			</div>
			<div class="col w-25 p-3 mt-2 text-white" style="background-color: #9e80e1; border-radius: 0px 10px 10px 0px;">
				'.$countusers.'
			</div>
			
			<div class="col w-75 p-3 text-white mt-2" style="background-color: #b598f5; border-radius: 10px 0px 0px 10px;">
				Levels
			</div>
			<div class="col w-25 p-3 text-white mt-2" style="background-color: #9e80e1; border-radius: 0px 10px 10px 0px;">
				'.$countlevels.'
			</div>
			
			<div class="col w-75 p-3 text-white mt-2" style="background-color: #b598f5; border-radius: 10px 0px 0px 10px;">
				Comments & Posts
			</div>
			<div class="col w-25 p-3 text-white mt-2" style="background-color: #9e80e1; border-radius: 0px 10px 10px 0px;">
				'.$compost.'
			</div>
		</div>
	</div>
');
?>