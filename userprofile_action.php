<?php
include_once('includes/message.inc.php');
include_once('src/dbrepo.php');
include_once('src/UserProfile.dao.php');
include_once('src/message.php');
		// $first_name='kumar';
		// $last_name='jems';
		// $address='kuppilan';
		// $contact_number='07712345625';
		// $user_id=3;
// UserProfileDAO::editProfile($user_id,$first_name,$last_name,$address,$contact_number);
//UserProfileDAO::insertUserProfile($user_id,$first_name,$last_name,$address,$contact_number);
	// $user_id=1;
	// 	echo json_encode(UserProfileDAO::findProfilleById($user_id));
	    // $currentPass="thiru123";
		// $newPass ="thiru123";
		// $confirmPass = "thiru123";
		// $user_id=1;
		// UserProfileDAO::changePassword($currentPass,$newPass,$confirmPass,$user_id);
if (isset($_POST['action'])) {
	if($_POST['action']=='EDIT_PROFILE')
	{
		$first_name=trim($_POST["first_name"]);
		$last_name=trim($_POST["last_name"]);
		$address=trim($_POST["address"]);
		$contact_number=trim($_POST["contact_number"]);
		$user_id=trim($_POST["user_id"]);

		UserProfileDAO::editProfile($user_id,$first_name,$last_name,$address,$contact_number);
		
	}
	if($_POST['action']=='ADD_PROFILE'){
		$first_name=trim($_POST["first_name"]);
		$last_name=trim($_POST["last_name"]);
		$address=trim($_POST["address"]);
		$contact_number=trim($_POST["contact_number"]);
		$user_id=trim($_POST["user_id"]);

		UserProfileDAO::insertUserProfile($user_id,$first_name,$last_name,$address,$contact_number);

	}
	if ($_POST['action'] == 'FETCH_SINGLE')
	{
		$user_id=trim($_POST["user_id"]);
		echo json_encode(UserProfileDAO::findProfilleById($user_id)); 
	}

	if($_POST['action']=='change_password')
	{
		$currentPass=$_POST["user_current_password"];
		$newPass =$_POST["user_new_password"];
		$confirmPass = $_POST["user_re_enter_password"];
		$user_id=$_POST["user_id"];
		UserProfileDAO::changePassword($currentPass,$newPass,$confirmPass,$user_id);
	}

}


?>