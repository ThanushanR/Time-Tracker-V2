<?php
 

class Uservalidation{

    public static function existUsername($username){
        $repo=new DBrepo();
        return $repo->ifexists("user","user_name",$username);
    }

    public static function existUsernameLock($username,$id){
        $repo=new DBrepo();
        return $repo->ifexistsLock("user","user_name",$username,"user_id",$id);
    }

    public static function existEmail($email){
        $repo=new DBrepo();
        return $repo->ifexists("user","user_email",$email);
    }

    public static function existEmailLock($email,$id){
        $repo=new DBrepo();
        return $repo->ifexistsLock("user","user_email",$email,"user_id",$id);
    }
}


?>