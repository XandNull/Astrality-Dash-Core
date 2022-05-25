<font face="Consolas">
<table border="1">
	<tr>
		<th>№</th>
		<th>Level Name</th>
		<th>Creator</th>
    <th>Action</th>
		<th>Time</th>
    <th>Date</th>
		<th>Type</th>
	</tr>

<?php
include("../../lib/connection.php");
require_once("funcLib.php");
error_reporting(0);
$funcLib = new funcLib();
$i = 0;

$query = $db->prepare("SELECT feaID, levelID, timestamp, name, type FROM dailyfeatures ORDER BY timestamp");
$query->execute();
$res = $query->fetchAll();

$last1 = $funcLib->getTimeLevelsForTime(0);
$last2 = $funcLib->getTimeLevelsForTime(1);
foreach ($res as $level) {
	$i++;
  $levelData = $funcLib->getAllDataFromLevel($level[1])[0];
  if($level[4] == 0){
    $time = $funcLib->getTimeFromStars($levelData["starStars"], 0);
		if($last1[0][0] == $level[0]){
			$action = '<font color="#ff3d41">ожидание</font>';
		}elseif($last1[1][0] == $level[0]) {
			$action = '<font color="#6cff3d">активен</font>';
		}else{
			$action = '<font color="#3d5bff">неактивен</font>';
		}
	}
  if($level[4] == 1){
    $time = $funcLib->getTimeFromStars($levelData["starDemonDiff"], 1);
		if($last2[0][0] == $level[0]){
			$action = '<font color="#ff3d41">ожидание</font>';
		}elseif($last2[1][0] == $level[0]) {
			$action = '<font color="#6cff3d">активен</font>';
		}else{
			$action = '<font color="#3d5bff">неактивен</font>';
		}
  }
  echo "<tr><td>&nbsp;".$i."&nbsp;</td><td>&nbsp;".$levelData['levelName']." (".$levelData['levelID'].")&nbsp;</td><td>&nbsp;".$levelData['userName']."&nbsp;</td><td>&nbsp;".$action."&nbsp;</td><td>&nbsp;".$time[1]."&nbsp;</td><td>&nbsp;".date("j F, g:i a", $level[2])."&nbsp;</td><td>&nbsp;".$level[3]."&nbsp;</td></tr>";
}
echo "</font>";
include('getGJTimeLevels.php');
?>
