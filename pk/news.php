<?
date_default_timezone_get();
$date = date('m/d/Y h:i:s a', time());
$arr = array('1' => "PARKURCHIK 1.0.20! Yes!\n1. Polygon shapes\n2. Account system\n3. More new play funcs!\n4. TOP of players\n5. Lava and batut fix!", '2' => "07.08.2021");
echo json_encode($arr);
?>