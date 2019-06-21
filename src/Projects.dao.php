<?php
// include_once('dbrepo.php');
// include_once('../includes/message.inc.php');
class ProjectsDAO{
public static function insertsProjects($user_id,$project_name,$startdate,$description,$remarks){
    $repo=new DBRepo();
    $query = "
		INSERT INTO project (user_id,project_name,start_date,description,remarks,project_status) 
		VALUES (:user_id,:project_name,:start_date,:description,:remarks,:project_status)
        ";
        return $repo->executeInsertGetLastId($query, array(
                ':user_id'	    =>	$user_id,
				':project_name'	=>	$project_name,
				':start_date'	=>	$startdate,
				':description'	=>	$description,
				':remarks'	    =>	$remarks,
				':project_status'	=>	'In_progress'
           ));
}
public static function editProjects($project_id,$project_name,$start_date,$description,$remarks){
	$repo = new DBRepo();
	$query ="
		UPDATE project set project_name = :project_name,start_date =:start_date,description =:description,remarks=:remarks
		WHERE project_id = :project_id
		";
		return $repo->executeWitAffectedrows($query, array(
				':project_id'	=>	$project_id,
				':project_name'	=>	$project_name,
				':start_date'	=>	$start_date,
				':description'	=>	$description,
				':remarks'		=>	$remarks
	   ));
}
public static function findProjectById($project_id){
    $repo=new DBrepo();
    $query = "SELECT * FROM project WHERE project_id = :project_id";
    $row=$repo->getSingleResult($query,array(':project_id'	=>	$project_id));
    return $row;
}
public static function toggleProject($prmstatus,$project_id){
	$repo = new DBRepo();
	$status = 'In_progress';
    if($prmstatus == 'In_progress')
    {
		$status = 'Finished';	
	}
	$query = "
	UPDATE project 
		SET project_status = :project_status 
		WHERE project_id = :project_id	
    ";

    $repo->executeWithMsg("Project Status Changed to". $status,"Unable to Change Project Status",$query,array(
        ':project_status'	=>	$status,
        ':project_id'		=>	$project_id
	));
}
}

//ProjectsDAO::insertsProjects("project","2019-05-16","jhggg","jhj","gfghfd");
//print_r(ProjectsDAO::findProjectById(1));
//ProjectsDAO::toggleProject("Finished",3);
?>