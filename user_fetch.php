<?php

//user_fetch.php

include('database_config_dashboard.php');

$query = '';

$output = array();

$query .= "
SELECT * FROM user u JOIN user_role ur  ON u.user_type = ur.role_id WHERE ";

if(isset($_POST["search"]["value"]))
{
	
	$query .= '(user_name LIKE "'.$_POST["search"]["value"].'%" ';
	$query .= 'OR user_status LIKE "'.$_POST["search"]["value"].'%" ';
	$query .= 'OR role_name LIKE "'.$_POST["search"]["value"].'%") ';
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY user_id DESC ';
}


if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}


$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
	$status = '';
	$statusCheck='';
	if($row["user_status"] == 'Active')
	{
	
		$statusCheck='<input type="checkbox" name="delete" checked id="'.$row["user_id"].'" class="delete"  data-status="'.$row["user_status"].'">';
		$updatebutton='<button type="button" name="update" id="'.$row["user_id"].'" class="btn btn-warning btn-xs update">Edit</button>';
	}
	else
	{
	
		$statusCheck='<input type="checkbox" name="delete" id="'.$row["user_id"].'" class="delete"  data-status="'.$row["user_status"].'">';
		$updatebutton='<button type="button" disabled  name="update" id="'.$row["user_id"].'" class="btn btn-warning btn-xs update">Edit</button>';
	}
	$sub_array = array();
	$sub_array[] = $row['user_id'];
	$sub_array[] = $row['user_email'];
	$sub_array[] = $row['user_name'];
	$sub_array[] = $row['role_name'];
	$sub_array[] = $updatebutton;
	$sub_array[] = $statusCheck;
	$sub_array[] = "<a href='profile.php?userid={$row["user_id"]}'  class='btn btn-primary btn-xs'>View</a>";
	$sub_array[] = "<a href='recruitment-admin.php?userid={$row["user_id"]}'  class='btn btn-primary btn-xs'>Manage</a>";
	$sub_array[] = "<a href='timesheet.php?userid={$row["user_id"]}'  class='btn btn-primary btn-xs'>View</a>";
	$data[] = $sub_array;
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($connect),
	"data"    			=> 	$data
);


echo json_encode($output);

function get_total_all_records($connect)
{
	$statement = $connect->prepare("SELECT * FROM user");
	$statement->execute();
	return $statement->rowCount();
}

?>