<?php
error_reporting(E_ALL);
chdir(dirname(__FILE__));
echo "Please wait...<br>";
ob_flush();
flush();
if(file_exists("../logs/fixcpslog.txt")){
	$cptime = file_get_contents("../logs/fixcpslog.txt");
	$newtime = time() - 30;
	if($cptime > $newtime){
		$remaintime = time() - $cptime;
		$remaintime = 30 - $remaintime;
		$remainmins = floor($remaintime / 60);
		$remainsecs = $remainmins * 60;
		$remainsecs = $remaintime - $remainsecs;
		exit("Please wait $remainmins minutes and $remainsecs seconds before running ". basename($_SERVER['SCRIPT_NAME'])." again");
	}
}
file_put_contents("../logs/fixcpslog.txt",time());
set_time_limit(0);
$cplog = "";
$people = array();
include "../../serversdata/incl/lib/connection.php";
//getting users
$query = $db->prepare("UPDATE users
	LEFT JOIN
	(
	    SELECT usersTable.userID, (IFNULL(starredTable.starred, 0) + IFNULL(featuredTable.featured, 0) + (IFNULL(epicTable.epic,0)*2)) as CP FROM (
            SELECT userID FROM users
        ) AS usersTable
        LEFT JOIN
        (
	        SELECT count(*) as starred, userID FROM levels WHERE starStars != 0 AND isCPShared = 0 GROUP BY(userID) 
	    ) AS starredTable ON usersTable.userID = starredTable.userID
	    LEFT JOIN
	    (
	        SELECT count(*) as featured, userID FROM levels WHERE starFeatured != 0 AND isCPShared = 0 GROUP BY(userID) 
	    ) AS featuredTable ON usersTable.userID = featuredTable.userID
	    LEFT JOIN
	    (
	        SELECT count(*) as epic, userID FROM levels WHERE starEpic != 0 AND isCPShared = 0 GROUP BY(userID) 
	    ) AS epicTable ON usersTable.userID = epicTable.userID
	) calculated
	ON users.userID = calculated.userID
	SET users.creatorPoints = IFNULL(calculated.CP, 0)");
$query->execute();
/*
	NOW to update GAUNTLETS CP
*/
$query = $db->prepare("SELECT level1,level2,level3,level4,level5 FROM gauntlets");
$query->execute();
$result = $query->fetchAll();
//getting gauntlets
foreach($result as $gauntlet){
	//getting lvls
	for($x = 1; $x < 6; $x++){
		$query = $db->prepare("SELECT userID, levelID FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $gauntlet["level".$x]]);
		$result = $query->fetch();
		//getting users
		if($result["userID"] != ""){
			$cplog .= $result["userID"] . " - +1\r\n";
			$people[$result["userID"]] += 1;
		}
	}
}
/*
	DONE
*/
foreach($people as $user => $cp){
	echo "$user now has $cp creator points... <br>";
	$query4 = $db->prepare("UPDATE users SET creatorPoints = (creatorpoints + :creatorpoints) WHERE userID=:userID");
	$query4->execute([':userID' => $user, ':creatorpoints' => $cp]);
}
echo "<hr>done";
file_put_contents("../logs/cplog.txt",$cplog);
?>
