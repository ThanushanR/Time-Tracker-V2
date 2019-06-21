<?php 
require_once 'includes/message.inc.php';
require_once 'src/dbrepo.php';
require_once 'src/UserRole.validation.php';
require_once 'src/Company.validation.php';
require_once 'src/User.validation.php';
require_once 'src/Projects.validation.php';

if (isset($_POST['param'])) {
 if ($_POST['param'] == 'rolename') {
  echo (json_encode(!UserRoleValidation::existRoleName($_POST['value'])));
  //echo false;
 }

if ($_POST['param'] == 'company_name') {
  if ($_POST['action'] == 'ADD') {
   echo (json_encode(!CompanyValidation::existCompanyname($_POST['value'])));
  }elseif ($_POST['action'] == 'EDIT') {
    echo (json_encode(!CompanyValidation::existCompanynameLock($_POST['value'],$_POST['actionvalue'])) );
  }  
}

if ($_POST['param'] == 'company_email') {
    if ($_POST['action'] == 'ADD') {
     echo (json_encode(!CompanyValidation::existEmail($_POST['value'])));
    }elseif ($_POST['action'] == 'EDIT') {
      echo (json_encode(!CompanyValidation::existCompanyEmailLock($_POST['value'],$_POST['actionvalue'])) );
    } 
  }

if($_POST['param'] == 'user_name'){
    if ($_POST['action'] == 'ADD') {
        echo (json_encode(!Uservalidation::existUsername($_POST['value']) ));
    }elseif ($_POST['action'] == 'EDIT') {
      echo (json_encode(!Uservalidation::existUsernameLock($_POST['value'],$_POST['actionvalue'])) );
    }
} 
if($_POST['param'] == 'user_email'){
    if ($_POST['action'] == 'ADD') {
      echo (json_encode(!Uservalidation::existEmail($_POST['value']) ));
     }elseif ($_POST['action'] == 'EDIT') {
      echo (json_encode(!Uservalidation::existEmailLock($_POST['value'],$_POST['actionvalue'])) );
    }
}
if($_POST['param'] == 'project_name'){
  if ($_POST['action'] == 'ADD') {
  echo (json_encode(!ProjectsValidation::existProjectname($_POST['value']) ));
  }elseif ($_POST['action'] == 'EDIT') {
    echo (json_encode(!ProjectsValidation::existProjectnameLock($_POST['value'],$_POST['actionvalue'])) );
  }
} 

}
