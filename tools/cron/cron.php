<?php
chdir(dirname(__FILE__));
set_time_limit(0);
if (file_exists("../logs/cronlastrun.txt")) {
	$cptime = file_get_contents("../logs/cronlastrun.txt");
	$newtime = time() - 30;
	if ($cptime > $newtime) {
		$remaintime = time() - $cptime;
		$remaintime = 30 - $remaintime;
		$remainmins = floor($remaintime / 60);
		$remainsecs = $remainmins * 60;
		$remainsecs = $remaintime - $remainsecs;
		exit("Please wait $remainmins minutes and $remainsecs seconds before running " . basename($_SERVER['SCRIPT_NAME']) . " again");
	}
}
include "fixcps.php";
ob_flush();
flush();
file_put_contents("../logs/cronlastrun.txt",time());
?>
