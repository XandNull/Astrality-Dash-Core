<?

include "../../serversdata/incl/lib/connection.php";


$query = $db->prepare("SELECT userName FROM accounts ORDER BY accountID DESC LIMIT 1");
$query->execute();
$lastuser = $query->fetchColumn();

$query = $db->prepare("SELECT levelName FROM levels ORDER BY levelID DESC LIMIT 1");
$query->execute();
$lastlevel = $query->fetchColumn();

$query = $db->prepare("SELECT comment FROM comments ORDER BY commentID DESC LIMIT 1");
$query->execute();
$lastcomment = $query->fetchColumn();
$decodedcomment = base64_decode($lastcomment);

$query = $db->prepare("SELECT comment FROM acccomments ORDER BY commentID LIMIT 1");
$query->execute();
$lastpost = $query->fetchColumn();
$decodedpost = base64_decode($lastpost);


$query = $db->prepare("SELECT userName FROM accounts ORDER BY accountID LIMIT 1");
$query->execute();
$firstuser = $query->fetchColumn();

$query = $db->prepare("SELECT levelName FROM levels ORDER BY levelID LIMIT 1");
$query->execute();
$firstlevel = $query->fetchColumn();

$query = $db->prepare("SELECT comment FROM comments ORDER BY commentID LIMIT 1");
$query->execute();
$firstcomment = $query->fetchColumn();
$decodedfirstcomment = base64_decode($firstcomment);

$query = $db->prepare("SELECT comment FROM acccomments ORDER BY commentID LIMIT 1");
$query->execute();
$firstpost = $query->fetchColumn();
$decodedfirstpost = base64_decode($firstpost);


$json = json_encode(array(
"lastpost" => $decodedpost,
"lastuser" => $lastuser,
"lastcomment" => $decodedcomment,
"lastlevel" => $lastlevel,
"fisrtpost" => $decodedfirstpost,
"firstuser" => $firstuser,
"firstcomment" => $decodedfirstcomment,
"firstlevel" => $firstlevel));

echo $json;

?>