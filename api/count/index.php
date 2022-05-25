<?

include "../../serversdata/incl/lib/connection.php";

$query = $db->prepare("SELECT count(*) FROM users");
$query->execute();
$users = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM accounts");
$query->execute();
$accounts = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM comments");
$query->execute();
$comments = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM levels");
$query->execute();
$levels = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM mappacks");
$query->execute();
$mappacks = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM gauntlets");
$query->execute();
$gauntlets = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM messages");
$query->execute();
$messages = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM reports");
$query->execute();
$reports = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM songs");
$query->execute();
$songs = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM suggest");
$query->execute();
$suggest = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM users");
$query->execute();
$users = $query->fetchColumn();

$query = $db->prepare("SELECT count(*) FROM acccomments");
$query->execute();
$acccomments = $query->fetchColumn();

$json = json_encode(array(
"acccomments" => $acccomments,
"accounts" => $accounts,
"comments" => $comments,
"levels" => $levels,
"mappacks" => $mappacks,
"gauntlets" => $gauntlets,
"messages" => $messages,
"reports" => $reports,
"songs" => $songs,
"suggest" => $suggest,
"users" => $users));

echo $json;

?>