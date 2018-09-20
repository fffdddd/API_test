<?php  
	error_reporting('E_ALL &  ~E_NOTICE');

	//定义秘钥
	define('Token','test');

	//检测加密签名
	include './checksing.php';

	//业务逻辑异常
	try{
		if(empty($_POST['username'])){
			throw new Exception('缺失username必填参数');
		}

		if(empty($_POST['password'])){
			throw new Exception('缺失password必填参数');
		}
	}catch(Exception $e){
		echo resp([],401,$e->getMessage());
		exit;
	}

	//服务器异常
	try{
		$pdo = new PDO('mysql:host=localhost;dbname=api;chraset=utf8','root','111');

		$stmt = $pdo->query('select * from user ');

		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}catch(Exception $e){
		echo resp($data,401,$e->getMessage());
		exit;
	};

	

	function resp($data,$status,$message){
		$res = [
			'status'=>$status,
			'message'=>$message,
			'data'=>$data
		];

		return json_encode($res,JSON_UNESCAPED_UNICODE);
	}

	echo resp($data,200,'ok');
?>