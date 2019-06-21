<?php
session_start();
//upload.php
include('database_config_dashboard.php');
if(!empty($_FILES))
{
	$allowed_ext =array("jpg","jpeg","png","PNG","JPG","JPEG");

	// there was a problem arised when the explode function passed
	$explode_ext=explode('.', $_FILES['photo']['name']);
	$ext =end($explode_ext);
	
	if(in_array($ext,$allowed_ext)){
	if(is_uploaded_file($_FILES['photo']['tmp_name']))
	{
		sleep(1);
		
		$source_path = $_FILES['photo']['tmp_name']; // Storing source path of the file in a variable
		//$target_path = 'images/profile/' . $_FILES['photo']['name'];// Target path where file is to be stored
		$new_photo_name=md5($_SESSION["user_name"]).".".$ext;
		$target_path = 'images/profile/' .$new_photo_name ;
		if(move_uploaded_file($source_path, $target_path))// Moving Uploaded file
		{
			//echo '<img src="'.$target_path.'" class="img-thumbnail" width="300" height="250" />';
			$query = "UPDATE user_profile SET photo = '".$new_photo_name."' WHERE user_id ='".$_SESSION["user_id"]."'"; 
				
		
			$statement = $connect->prepare($query);
				

				if($statement->execute()){
					echo '<div class="alert alert-success">Profile photo changed successfully </div>';
				}
			
				
				
		}
	}

}else{
	echo '<div class="alert alert-danger">Profile photo should be .png or .jpg format</div>';
}
}

?>