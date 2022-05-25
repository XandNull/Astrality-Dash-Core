<?php

include("vk_api.php");
include("parameters.php");

const VK_KEY2 = "";  // Токен сообщества
const ACCESS_KEY = "";  // Тот самый ключ из сообщества 
const VERSION2 = "5.131"; // Версия API VK

$vk = new vk_api(VK_KEY2, VERSION2);
$data = json_decode(file_get_contents('php://input'));

?>
