<?php  
	include './vendor/autoload.php';

	$url = 'http://localhost/Api/api_one/API_test/server/server.php';

	$curl = new Curl\Curl();
	$curl->get($url);

	if($curl->error){
		echo $curl->error_code;
	}else{
		echo $curl->response;
	}

?>