<?php

class CompanyValidation{

    public static function existCompanyname($companyname){
        $repo=new DBrepo();
        return $repo->ifexists("out_source_company","company_name",$companyname);
    }
    public static function existCompanynameLock($companyname,$company_id){
        $repo=new DBrepo();
        return $repo->ifexistsLock("out_source_company","company_name",$companyname,"company_id",$company_id);
    }

    public static function existEmail($email){
        $repo=new DBrepo();
        return $repo->ifexists("out_source_company","email",$email);
    }
    public static function existCompanyEmailLock($email,$company_id){
        $repo=new DBrepo();
        return $repo->ifexistsLock("out_source_company","email",$email,"company_id",$company_id);
    }
}


?>