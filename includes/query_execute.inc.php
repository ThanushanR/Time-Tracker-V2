<?php

	require_once 'message.inc.php';

    function execute_query($success_msg,$err_msg,$connect,$query,$array_param){
		$msg=null;
	try{
		
	$statement = $connect->prepare($query);
		if($statement->execute($array_param))
		{
			
			if($statement->rowCount()>0){
				
				$msg=printJsonMsg($success_msg,'success');
			}else if($statement->rowCount()==0){
				
				$msg=printJsonMsg($err_msg,'err');
			}else{
				
				$msg=printJsonMsg('error occured please check','err');
			}
			
		}
	}catch(PDOException $e)
	{
	

	$msg=printJsonMsg( $e->getMessage(),'err');
	}
	echo json_encode($msg);
    }
		
		function getResult($connect,$query){
			$statement = $connect->prepare($query);
		$statement->execute();
		return $result = $statement->fetch(PDO::FETCH_ASSOC);
		}

		function getResultwihParam($connect,$query,$param){
			$statement = $connect->prepare($query);
		$statement->execute($param);
		return $result = $statement->fetch(PDO::FETCH_ASSOC);
		}

		function getAll($connect,$query){
		
			return $connect->query($query);
		
		}
    ?>