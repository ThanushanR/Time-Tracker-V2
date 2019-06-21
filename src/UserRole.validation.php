<?php

class UserRoleValidation{

    public static function existRoleName($role_name){
        $repo=new DBrepo();
        return $repo->ifexists("user_role","role_name",$role_name);
    }		
}

//echo UserRoleValidation::existRoleName("xyz");
?>