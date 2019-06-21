<?php

class TimeDAO{

    public static function getTimeinAndTimeOut($userid,$date){
        $repo=new DBrepo();
        $query="SELECT `time_in`,`time_out` FROM `attendance` WHERE `user_id`=:user_id AND `date`=:date";
		$row=$repo->getSingleResult($query,array(':user_id'	=>	$userid,':date'=>$date));
		return $row;
    
    }


    public static function insertTimeIn($timeIn,$userid,$date){
        $repo=new DBrepo();
        if(self::existTimeIn($userid,$date)){
            $sql="UPDATE `attendance` SET `time_in` = :timein WHERE `user_id`=:userid AND `date`=:date";

            $repo->executeWithMsg("Successfully Updated Time In","Cannot Allowed to change ",$sql,array(
                ':timein'=>$timeIn,
                ':userid'=>$userid,
                ':date'=>$date
            ));
        }else{
            $sql="INSERT INTO attendance (time_in,user_id,date)
            VALUES(:timein,:userid,:date)";

            $repo->executeWithMsg("Successfully Inserted Time In","Cannot Allowed to change ",$sql,array(
                ':timein'=>$timeIn,
                ':userid'=>$userid,
                ':date'=>$date
            ));
        }
        
    }

    public static function existTimeIn($userId,$date){
        $repo=new DBrepo();
        $query="SELECT count(`time_in`) as countnum FROM `attendance` WHERE `user_id`=:userid AND `date`=:date";
        $param=array(':userid'=>$userId,':date'=>$date);
        return $repo->existQueryWithParam($query,$param);
    }

    public static function getTimeIn($userId,$date){
        $repo=new DBrepo();
        $query="SELECT `time_in` FROM `attendance` WHERE `user_id`=:userid AND `date`=:date";
        $param=array(':userid'=>$userId,':date'=>$date);
        $row=$repo->getSingleResult($query,$param);
        return $row['time_in'];
    }

    public static function updateTimeOut($timeout,$userid,$date){
        $repo=new DBrepo();
        $sql="UPDATE attendance SET time_out = :timeout WHERE attendance.user_id=:userid AND attendance.date = :date";
       

        $repo->executeWithMsg("Successfully Updated Time Out","Cannot Allowed to change ",$sql,array(
            ':timeout'=>$timeout,
            ':userid'=>$userid,
            ':date'=>$date
            
        ));
    }

}

//TimeDAO::insertTimeIn("10:00","1","2019-05-29");
//echo TimeDAO::existTimeIn("1","2019-05-2");

?>