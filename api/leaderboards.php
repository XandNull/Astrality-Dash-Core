<?

include "../serversdata/incl/lib/connection.php";
require_once "../serversdata/incl/lib/exploitPatch.php";
$ep = new exploitPatch();

$top = strtolower($ep->remove($_GET["top"]));

if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($ep->remove($_GET["page"]) - 1) * 10;
}else{
	$page = 0;
}

if(!empty($top)){
	$query = $db->prepare("SELECT * FROM users ORDER BY $top DESC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
	if($query->rowCount() == 0){
		$json = json_encode(array("data" => "not found"));
		exit($json);
	}
	foreach($result as &$users);
}else{
	$json = json_encode(array("data" => "not found"));
	exit($json);
}

$array = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10');

$collect = array();
foreach($result as &$user){
	$usernamik[] = $user["userName"];
	$points[] = $user[$top];
}

foreach ($array as $key => $value){
	$collect[$value] = array(
		'username' => $usernamik[$key],
		'points' => $points[$key],
		'key' => $key
	);
}

echo json_encode($collect);

?>