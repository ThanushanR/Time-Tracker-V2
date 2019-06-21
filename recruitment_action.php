<?php  
include_once('includes/message.inc.php');
include_once('src/dbrepo.php');
include_once('src/Recruitment.dao.php');
include_once('src/message.php');

 if(isset($_POST["action"]))  
 {  
       
    
      if($_POST["action"] =="ADD")  
      {  
          $user_id= trim($_POST["user_id"]);  
          $company_name = trim($_POST["company_name"]);
          $recruited_date = trim($_POST["recruited_date"]);
          $work_role = trim($_POST["work_role"]);
          $contract_Period = trim($_POST["contract_Period"]); 
           
          RecruitmentDAO::insertRecruitment($user_id,$company_name,$recruited_date,$work_role,$contract_Period);
            
           
      }  
      if($_POST["action"] == "EDIT")  
      {  
        
          $id = trim($_POST["recruitId"]);
          $company_id = trim($_POST["company_name"]);
          $recruited_date =trim($_POST["recruited_date"]);
          $work_role =trim($_POST["work_role"]);
          $contract_Period =trim($_POST["contract_Period"]);
           
          RecruitmentDAO::updateRecruitment($id,$company_id,$recruited_date,$work_role,$contract_Period);
           
      }  
      
      if($_POST["action"] == "DELETE")  
      {  
        $recruitId=$_POST['recruit_id'];
        if(RecruitmentDAO::deleteRecruitment($recruitId)){
            writeJsonMsg('The Recruitment Details has Deleted','success');
        }else{
            writeJsonMsg('Error in deleting details','err'); 
        }
      }  

      if($_POST["action"] == "FETCH_SINGLE")  {
        $recruitid=$_POST['recruit_id'];
       echo json_encode(RecruitmentDAO::getUserRecruitmentById($recruitid));
    }

     if($_POST["action"] == "ADD_TERMINATE")  {
      
     }
 }  
 ?>  