<?php  
	include './vendor/autoload.php';
	include 'setkey.php';

	//定义秘钥
	$token = 'test';

	$sing = setsing($token);

	$url = 'http://localhost/Api/api_one/API_test/server/server.php?sing='.$sing;

	$curl = new Curl\Curl();
	// $curl->get($url);
	$curl->post($url,array(
		'username'=>'liuliu',
		'password'=>'123'
	));

	if($curl->error){
		echo $curl->error_code;
	}else{
		echo $curl->response;
	}

?>