<?php
class vk_api{
    /**
     * Токен
     * @var string
     */
    private $token = '';
    private $v = '';
    /**
     * @param string $token Токен
     */
    public function __construct($token, $v){
        $this->token = $token;
        $this->v = $v;
    }

    public function sendMessage($type, $sendToID, $message, $attachment = ''){
		# ТИП 1 # просто текстовое сообщение одному/нескольким пользователям
		if ($type == 1) {
			return $this->request('messages.send',array(
				'random_id' => 0,
				'peer_ids' => $sendToID,
				'message' => $message,
			));
		}elseif ($type == 2) {
			return $this->request('messages.send',array(
				'random_id' => 0,
				'peer_ids' => $sendToID,
				'message' => $message,
				'attachment' => $attachment,
			));
		}else{
			return true;
		}
    }
	
    public function getUser($user_ids,$name_case){

		return $this->request('users.get',array('user_ids'=>$user_ids,'name_case'=>$name_case));

    }

    public function sendOK(){
        echo 'ok';
        $response_length = ob_get_length();
        // check if fastcgi_finish_request is callable
        if (is_callable('fastcgi_finish_request')) {
            /*
             * This works in Nginx but the next approach not
             */
            session_write_close();
            fastcgi_finish_request();

            return;
        }

        ignore_user_abort(true);

        ob_start();
        $serverProtocole = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL', FILTER_SANITIZE_STRING);
        header($serverProtocole.' 200 OK');
        header('Content-Encoding: none');
        header('Content-Length: '. $response_length);
        header('Connection: close');

        ob_end_flush();
        ob_flush();
        flush();
    }
	
    public function request($method,$params=array()){
        $url = 'https://api.vk.com/method/'.$method;
        $params['access_token']=$this->token;
        $params['v']=$this->v;
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type:multipart/form-data"
            ));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            $result = json_decode(curl_exec($ch), True);
            curl_close($ch);
        } else {
            $result = json_decode(file_get_contents($url, true, stream_context_create(array(
                'http' => array(
                    'method'  => 'POST',
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'content' => http_build_query($params)
                )
            ))), true);
        }
        if (isset($result['response']))
            return $result['response'];
        else
            return $result;
    }
}
