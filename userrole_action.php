<?php
include_once('includes/message.inc.php');
include_once('src/dbrepo.php');
include_once('src/UserRole.validation.php');
include_once( 'src/UserRole.dao.php');

if(isset($_POST['action']))
{
	
	if($_POST['action'] == 'ADD')
	{
	
		$role_name=trim($_POST["role_name"]);
		
		if(UserRoleValidation::existRoleName($role_name)){
			writeJsonMsg('The role name is already available','err');
			
		}else{
		UserRoleDAO::insertUserRole($role_name);
		}
	}
	
	if($_POST['action'] == 'FETCH_SINGLE')
	{
		$role_id=$_POST["role_id"];
		echo json_encode(UserRoleDAO::findUserRoleById($role_id));
	}

	if($_POST['action'] == 'EDIT')
	{
		$role_name=trim($_POST["role_name"]);
		$role_id=trim($_POST["role_id"]);
		if(UserRoleValidation::existRoleName($role_name)){
			writeJsonMsg('The role name is already available','err');
			return false;
		}
		UserRoleDAO::editUserRole($role_id,$role_name);
		
	}

	if($_POST['action'] == 'TOGGLE')
	{
		UserRoleDAO::toggleUserRole($_POST['status'],$_POST["role_id"]);
	}
}


?>