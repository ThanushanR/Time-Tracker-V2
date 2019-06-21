<?php
class ProjectsValidation{
    public static function existProjectname($project_name){
        $repo=new DBrepo();
        return $repo->ifexists("project","project_name",$project_name);
    } 
    public static function existProjectnameLock($project_name,$project_id){
        $repo=new DBrepo();
        return $repo->ifexistsLock("project","project_name",$project_name,"project_id",$project_id);
    }
}

?>