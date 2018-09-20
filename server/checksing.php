<?php 
	include './aes.php';

	try{
		if(empty($_GET['sing'])){
			throw new Exception('加密签名不存在');
		}

		check($_GET['sing']);

	}catch(Exception $e){
		echo resp([],401,$e->getMessage());
	}

	function check($sing){
		$aes = new AESMcrypt($bit = 128, $key = 'abcdef1234567890', $iv = '0987654321fedcba', $mode = 'cbc');

		$sing = str_replace(' ','+',$sing);

		$sing_tmp = $aes->decrypt($sing);

		$sing_arr = explode('/',$sing_tmp);

		if($sing_arr[0]!=Token){
			throw new Exception("加密签名不正确");
		}

		if((time()-$sing_arr[1] > 5)){
			throw new Exception("sing 失效");
			
		}
	}
?>