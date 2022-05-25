<?

include "../serversdata/incl/lib/connection.php";
include "../serversdata/incl/lib/exploitPatch.php";
$ep = new exploitPatch();

$id = $ep->remove($_GET["id"]);

$query = $db->prepare("SELECT * FROM gauntlets WHERE ID = :id ORDER BY ID DESC LIMIT 15");
$query->execute([":id" => $id]);
$result = $query->fetchAll();
foreach($result as &$users);

if($query->rowCount() == 0){
	$json = json_encode(array("data" => "not found"));
	exit($json);
}

$json = json_encode(array(
"id" => $id,
"level1" => $users["level1"],
"level2" => $users["level2"],
"level3" => $users["level3"],
"level4" => $users["level4"],
"level5" => $users["level5"]));

echo $json;

?>