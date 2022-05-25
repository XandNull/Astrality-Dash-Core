<?php
//подключаем подтверждение бота
include "connect.php";

//получаем статистику страницы
$userAcc = $vk->getUser(150264783, '');

print_r($userAcc[0]['first_name']);
?>