<?php
//include_once('dbrepo.php');
//include_once('../includes/message.inc.php');
 
class UserRoleDAO{
	

    public static function insertUserRole($role_name){

			$repo=new DBrepo();
        $query = "
				INSERT INTO user_role (role_name,role_status) 
				SELECT * FROM (SELECT TRIM(:role_name), :role_status)
				AS tmp
				WHERE NOT EXISTS (
					SELECT role_name FROM user_role WHERE role_name = TRIM(:role_name2)
				) LIMIT 1";
		
		$repo->executeWithMsg("User Role Added Sucssfully","unable to insert User Role",$query,array(
			':role_name2'	=>	$role_name,
			':role_name'	=>	$role_name,
			':role_status'	=>	'Active'
		));
		
    }

	public static function editUserRole($role_id,$role_name){
		$repo=new DBrepo();
        $query = "
		UPDATE user_role set role_name = :role_name
		WHERE role_id = :role_id";

		$repo->executeWithMsg("User Role Edited Sucssfully","Unable to edit user role",$query,array(
			':role_name'	=>	$role_name,
			':role_id'		=>	$role_id
		));
    }


    public static function findUserRoleById($role_id){
		$repo=new DBrepo();
		$query = "SELECT * FROM user_role WHERE role_id = :role_id";
		$row=$repo->getSingleResult($query,array(':role_id'	=>	$role_id));
		return $row['role_name'];
	}

   

    public static function toggleUserRole($prmstatus,$roleId){
		$repo=new DBrepo();
        $status = 'Active';
		if( $prmstatus== 'Active')
		{
			$query="SELECT count(user.user_id) as usercount FROM user 
					INNER JOIN user_role ON user_role.role_id=user.user_type 
					WHERE user_role.role_id=:role_id AND user.user_status='Active'";
			$row=$repo->getSingleResult($query,array(':role_id'	=>	$roleId));
			
			if($row["usercount"]<=0){
				$status = 'Inactive';	
			}
		}
		
		$query = "
		UPDATE user_role 
		SET role_status = :role_status 
		WHERE role_id = :role_id
		";

		$repo->executeWithMsg("User Role Status Changed","Unable to Change user role",$query,array(
			':role_status'	=>	$status,
			':role_id'		=>	$roleId
		));	
    }
}

 
 //UserRoleDAO::insertUserRole('test');
