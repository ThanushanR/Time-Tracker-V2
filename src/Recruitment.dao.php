<?php

require_once 'dbrepo.php';
class RecruitmentDAO{

    public static function insertRecruitment($userid,$company_name,$recruited_date,$work_role,$contract_Period){

        $repo=new DBrepo();
        $query="INSERT INTO user_company
                (user_id, company_id,recruited_date,working_status,work_role,Contract_Period) 
                VALUES
                 (:user_id, :company_name,:recruited_date,:working_status,:work_role,:contract_Period) ";

        $param=array(
            ':user_id'  => $userid,
            ':company_name'  => $company_name,
            ':recruited_date'    => $recruited_date,
            ':working_status'    => 'Working',
            ':work_role'    => $work_role,
            ':contract_Period'    => $contract_Period
        );

        return $repo->executeInsertGetLastId($query,$param);

    }

    public static function updateRecruitment($id,$company_id,$recruited_date,$work_role,$contract_Period){
        $repo=new DBrepo();
        $query="UPDATE user_company SET 
                company_id = :company_id, 
                recruited_date = :recruited_date,
                work_role = :work_role,
                Contract_Period = :contract_Period
        WHERE id = :id";

        $param=array(
            ':id'  => $id,
            ':company_id'  => $company_id,
            ':recruited_date'    => $recruited_date,
            ':work_role'    => $work_role,
            ':contract_Period'    => $contract_Period
        ); 

        return $repo->executeWitAffectedrows($query,$param);
    }

    public static function deleteRecruitment($recruitId){
        $repo=new DBrepo();
        $query="DELETE FROM user_company WHERE id = :recruitId";  
        $param=array(
            ':recruitId'  => $recruitId,
            
        );
        return $repo->executeWitAffectedrows($query,$param);
    }


    public static function getUserRecruitments($userid){
        $repo=new DBrepo();
        $query="SELECT 
		oc.company_name,uc.recruited_date,uc.working_status,uc.id,uc.work_role,uc.contract_period,ter.date_of_termination
		FROM USER_COMPANY uc JOIN out_source_company oc 
		ON uc.company_id = oc.company_id
		LEFT JOIN termination ter
		ON ter.user_company_id=uc.id
        WHERE user_id=:userid ORDER BY user_company_id DESC";
        
        $param=array(':userid'=>$userid);
        return $repo->fetchAllResults($query,$param);
    }

    public static function getUserRecruitmentById($recruitid){
        $repo=new DBrepo();
        $query="SELECT * FROM `user_company` WHERE `id`=:id";
        $row=$repo->getSingleResult($query,array(':id'	=>	$recruitid));
		return $row;
    }

    public static function checkWorkingStatus($userid){
        $repo=new DBrepo();
        $query="SELECT count(`working_status`) as countnum FROM `user_company` WHERE `user_id`=:userid";
        $param=array(':userid'=>$userid);
        return $repo->existQueryWithParam($query,$param);
    }

    public static function makeTermination(){
        $repo=new DBrepo();
        $status=0;
        $repo->getConnection()->beginTransaction();


        $query1="UPDATE `user_company` SET `working_status` = 'Not_working' WHERE `user_company`.`id` = :recruitId ";
        // $param1=array(':recruitId'=>$recruitId);
        $param1=array(':recruitId'=>3);
        $updateAffected=$repo->executeWitAffectedrows($query1,$param1);
        echo "\nupdated rows : ".$updateAffected;
        if($updateAffected>0){
            echo "\nupdated : ";
            $status++;
        }


        $query2="INSERT INTO `termination` (`user_company_id`, `date_of_termination`) VALUES (:recId, :dot)";
        // $param2=array(':recruitId'=>$recruitId,':dot'=>$dot);
        $param2=array(':recId'=>3,':dot'=>'2018-09-23');
        $InsertAffected=$repo->executeWitAffectedrows($query2,$param2);
        echo "\nInserted rows : ".$InsertAffected;
        if($InsertAffected>0){
            echo "\nInserted";
            $status++;
        }
       
      echo "\nstatus count :".$status;
        if($status==2){
            $repo->getConnection()->commit();
        }else{
            $repo->getConnection()->rollBack();
        }
       
       
    }
}

//RecruitmentDAO::insertRecruitment("1","1","2019-12-9","se","6");
//echo RecruitmentDAO::updateRecruitment("1","3","2019-6-19","qa","9");
//echo RecruitmentDAO::deleteRecruitment(1);
//echo RecruitmentDAO::makeTermination();
// echo "<pre>";
// print_r( );
// echo "</pre>";

//RecruitmentDAO::makeTermination()
?>