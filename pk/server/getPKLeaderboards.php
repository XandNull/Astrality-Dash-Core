<?php

include "../../serversdata/incl/lib/connection.php";

$query = $db->prepare("SELECT * FROM pktop ORDER BY points DESC LIMIT 5");
$query->execute();
$result = $query->fetchAll();

$array = array('1', '2', '3', '4', '5');
$temp = array(
    'collect' => array()
);

$collect = array();
foreach($result as &$user){
	$usernamik[] = $user["username"];
	$points[] = $user["points"];
	$skin[] = $user["icon"];
}

foreach ($array as $key => $value){
	$collect[$value] = array(
		'username' => $usernamik[$key],
		'points' => $points[$key],
		'skin' => $skin[$key],
		'key' => $key
	);
}
$temp["collect"]=$collect;

echo json_encode($temp);
//как же я сука заебался идите все нахуй
?>