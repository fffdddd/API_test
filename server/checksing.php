<?php 
	include './aes.php';

	// 使用redis 存储$sing
	$red = new Redis();

	$red->connect('127.0.0.1',6379);

	try{
		if(empty($_GET['sing'])){
			throw new Exception('加密签名不存在');
		}

		check($_GET['sing'],$red);

	}catch(Exception $e){
		echo resp([],401,$e->getMessage());
	}

	//校验签名
	function check($sing,$red){
		$aes = new AESMcrypt($bit = 128, $key = 'abcdef1234567890', $iv = '0987654321fedcba', $mode = 'cbc');

		$sing = str_replace(' ','+',$sing);

		$sing_tmp = $aes->decrypt($sing);

		$sing_arr = explode('/',$sing_tmp);

		//用户身份识别
		if($sing_arr[0]!=Token){
			throw new Exception("加密签名不正确");
		}

		//防止api暴露
		if((time()-$sing_arr[1] > 5)){
			throw new Exception("sing 失效");
		}

		//多次请求
		if($red->get($sing)){
			throw new Exception("sing 已经被使用");
		}

		$red->set($sing,'123');
	}
?>