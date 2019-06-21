<?php
function fill_user_role_list($connect)
{
 $query = "
	SELECT role_id,role_name FROM user_role WHERE role_status ='Active' ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach ($result as $row) {
  $output .= '<option value="' . $row["role_id"] . '">' . $row["role_name"] . '</option>';
 }
 return $output;
 echo $output;
}

function fill_company_list($connect)
{
 $query = "
	SELECT company_name,company_id FROM out_source_company WHERE company_status ='Active'";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach ($result as $row) {
  $output .= '<option value="' . $row["company_id"] . '">' . $row["company_name"] . '</option>';
 }
 return $output;
 echo $output;
}



//echo randomPassword();
?>