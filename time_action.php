<?php  
include_once('includes/message.inc.php');
include_once('src/dbrepo.php');
include_once('src/Time.dao.php');



if(isset($_POST["action"])){
if($_POST["action"]=='TIME_IN'){


    $timein=$_POST["timein"];
    $userid=$_POST["userid"];
    $date=$_POST["date"];
    

    TimeDAO::insertTimeIn($timein,$userid,$date);

}else if($_POST["action"]=='TIME_OUT'){
    $timeout=$_POST["timeout"];
    $userid=$_POST["userid"];
    $date=$_POST["date"];

    $timeoutstr=strtotime($_POST["timeout"]);
    $timeinstr=strtotime(TimeDAO::getTimeIn($userid,$date));
    $timediff=$timeoutstr-$timeinstr;

    if($timediff>0){
      
            
            TimeDAO::updateTimeOut($timeout,$userid,$date);
    }else{
       
        echo json_encode(printJsonMsg('Time out is Less than Time in ','err'));
        
    }
    
}
}


?> 

