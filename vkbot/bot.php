<?php

//подключаем подтверждение бота
include "connect.php";

//подтверждение группы
if($data->type == 'confirmation') {
    exit(ACCESS_KEY);
}
//отправляем 'ок'
$vk->sendOK();

//получаем айди отправителя
$vk_userID = $data->object->message->from_id;

//получаем айди отправителя
$vk_chatID = $data->object->message->peer_id;

//получаем текст сообщения
$message = $data->object->message->text;

//если тип запроса - новое сообщение
if($data->type == 'message_new') {
	
	if(substr((mb_strtolower($message)),0,4) == 'test') {
	
	}
	
	if(substr((mb_strtolower($message)),0,4) == 'send') {
		
		$message = substr($message, 5);
		
		$vk->sendMessage(1, $vk_chatID, 'Да');
		
		$token1 = '';
		
		$request_params = array(
			'message' => "Hello, {$user_name}!",
			'peer_id' => $user_id,
			'access_token' => $token,
			'v' => '5.103',
			'random_id' => '0'
		);
		
		$get_params = http_build_query($request_params);

		file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);
	
	}

}

?>
