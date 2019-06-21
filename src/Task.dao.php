<?php

class TaskDAO{

    public static function insertTask($projectId,$taskname,$duration,$description,$date){
        $repo=new DBrepo();
        $query = "INSERT INTO events (project_id,title, duration,description,start,end) 
            VALUES(:project_id,:title, :duration,:description,:start,:end)";
        $param=array(
            ":project_id"=>$projectId,
            ":title"=>$taskname, 
            ":duration"=> $duration,
            ":description"=>$description,
            ":start"=>$date,
            ":end"=>$date);
            return $repo->executeInsertGetLastId($query,$param);
    }

    public static function editTask($id,$column_name,$value){
        $repo=new DBrepo();
        $query = "UPDATE events SET {$column_name}=:value WHERE id=:id";  
        $param=array(":value"=>$value,
                    ":id"=>$id);
        return $repo->executeWitAffectedrows($query,$param);
    }

    public static function updateTaskWithStartAndEnd($start,$end,$id){
        $repo=new DBrepo();
        $query = "UPDATE events SET  start = :startdate, end = :enddate WHERE id = :id ";
        $param=array(':startdate'=>$start,':enddate'=>$end,':id'=>$id);
        $repo->executeWithMsg("Task Updated","Cannot Update",$query,$param);
    }
    public static function deleteTask($id){
        $repo=new DBrepo();
        $query = "DELETE FROM events WHERE id = :id"; 
        $param=array(":id"=>$id);
        return $repo->executeWitAffectedrows($query,$param);
    }

    public static function getAllTaskByUserId($userid){
        $repo=new DBrepo();
        $query = "SELECT * FROM events INNER JOIN project ON project.project_id=events.project_id WHERE project.user_id=:user_id  ORDER BY id DESC";
        $param=array(':user_id'=>$userid);
        return $repo->fetchAllResults($query,$param);
    }
  
    public static function getAllEventsByDateAndUserId($date,$userid){
        $repo=new DBrepo();
        $query = "SELECT project.project_id,project.project_name,events.id,events.title,events.duration,events.description 
                FROM events 
                INNER JOIN project 
                ON project.project_id=events.project_id 
                WHERE (events.start<=:startdate AND events.end>=:enddate AND project.user_id=:userid ) ORDER BY id DESC"; 
        $param=array(':startdate'=>$date,':enddate'=>$date,':userid'=>$userid);
        return $repo->fetchAllResults($query,$param);
    }
   
    public static function sumAllEventsByDateAndUserId($date,$userid){
        $repo=new DBrepo();
        $query="SELECT SUM(duration) as total 
                    FROM events INNER JOIN project 
                    ON project.project_id=events.project_id 
                    WHERE (events.start<=:startdate AND events.end>=:enddate AND project.user_id=:userid ) ORDER BY id DESC"; 
        $param=array(':startdate'=>$date,':enddate'=>$date,':userid'=>$userid);
        $result =$repo->getSingleResult($query,$param);
        return $result['total'];
    }
    
}
?>






