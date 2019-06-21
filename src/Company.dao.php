<?php
//include_once('dbrepo.php');
//include_once('../includes/message.inc.php');
class ComapanyDAO{
    public static function insertCompany($companyname,$contactnumber,$email,$address){

    $repo=new DBrepo();
   
    $query = "
		INSERT INTO out_source_company (company_name,contact_number,email,address,company_status)
		VALUES (TRIM(:company_name),TRIM(:contact_number),TRIM(:email),TRIM(:address),:company_status)
		";
    return $repo->executeInsertGetLastId($query, array(
     ':company_name'   => $companyname,
     ':contact_number' => $contactnumber,
     ':email'          => $email,
     ':address'        => $address,
     ':company_status' => 'Active',
    ));
    
}

public static function editCompanyDetails($company_id,$companyname,$contactnumber,$email,$address){
    $repo=new DBrepo();
    $query = "
    UPDATE out_source_company set
    company_name = TRIM(:company_name),
    contact_number =TRIM(:contact_number),
    email =TRIM(:email),
    address=TRIM(:address)
    WHERE company_id = :company_id";

    return $repo->executeWitAffectedrows($query,array(
    ':company_id'       => $company_id,
     ':company_name'   =>  $companyname,
     ':contact_number' =>  $contactnumber,
     ':email'          =>  $email,
     ':address'        =>  $address,
    ));
}


public static function findCompanyById($company_id){
    $repo=new DBrepo();
    $query = "SELECT * FROM out_source_company WHERE company_id = :company_id";
    $row=$repo->getSingleResult($query,array(':company_id'	=>	$company_id));
    return $row;
}



public static function toggleCompany($prmstatus,$company_id){
    $repo=new DBrepo();
    $status = 'Active';
    if( $prmstatus== 'Active')
    {
        $query="SELECT count(user_company.id) as userCompanyCount FROM out_source_company
        INNER JOIN user_company ON user_company.company_id=out_source_company.company_id
        WHERE out_source_company.company_id=:company_id AND out_source_company.company_status='Active'";
        $row=$repo->getSingleResult($query,array(':company_id'	=>	$company_id));
        
        if($row["userCompanyCount"]<=0){
            $status = 'Inactive';	
        }
    }
    
    $query = "
    UPDATE out_source_company
	SET company_status = :company_status
	WHERE company_id = :company_id
    ";

    $repo->executeWithMsg("Company Status Changed to ".$status,"Unable to Change Company Status",$query,array(
        ':company_status'	=>	$status,
        ':company_id'		=>	$company_id
    ));	
}
}
//ComapanyDAO::insertCompany("thiruTech","07783368806","thirutech@gmail.com","jaffna");
//ComapanyDAO::editCompanyDetails(1,"SGIC1","0778568506","thiru@gmail.com","kuppilan south jaffna");
//ComapanyDAO::findCompanyById(1);
//ComapanyDAO::toggleCompany("Inactive",27);
?>