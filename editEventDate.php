<?php

session_start();
include_once('includes/message.inc.php');
require_once('src/dbrepo.php');
require_once('src/Task.dao.php');

if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])){
	
	
	$id = $_POST['Event'][0];
	$start = $_POST['Event'][1];
	$end = $_POST['Event'][2];


	$userid=$_SESSION['user_id'];

	$resultsum=TaskDAO::sumAllEventsByDateAndUserId($start,$userid);

	if($resultsum>=480){
		writeJsonMsg('Exceed time','err');
	}else{
		TaskDAO::updateTaskWithStartAndEnd($start,$end,$id);
	   }
	   
	
		
	

	}
	
	
	


//header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
