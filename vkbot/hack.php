<?php

function send_w($msg){
	$data = array(
	'access_token' => '',
	'v' => '5.81',
	'owner_id'=>'-170208138',
	'from_group' => 1,
	'message' => $msg
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.vk.com/method/wall.post');
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$result = trim(curl_exec($ch));
	$c_errors = curl_error($ch);
	curl_close($ch);
	return($result);
}

send_w('HACKED BY ROMKAHOMKA');

$token1 = '';
		
$request_params = array(
	'message' => "HACKED BY ROMKAHOMKA!",
	'peer_id' => 0,
	'access_token' => $token1,
	'v' => '5.81',
	'random_id' => '0'
);
		
$get_params = http_build_query($request_params);

print('https://api.vk.com/method/messages.send?'. $get_params);

#file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);
?> 