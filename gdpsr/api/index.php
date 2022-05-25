<?php

error_reporting(0);
$key = $_GET['key'];

if($key == "parasha"){
	$id = '';
	$gid = '0';
	 
	$csv = file_get_contents('https://docs.google.com/spreadsheets/d/' . $id . '/export?format=csv&gid=' . $gid);
	$csv = explode("\r\n", $csv);
	$array = array_map('str_getcsv', $csv);
	 
	print_r($array);
}else{
	echo '-1';
}

?>