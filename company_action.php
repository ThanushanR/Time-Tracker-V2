<?php

include_once('includes/message.inc.php');
include_once('src/dbrepo.php');
include_once('src/Company.validation.php');
include_once('src/User.service.php');
include_once('src/Company.dao.php');
include_once('src/message.php');

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'ADD') {

        $companyname      = trim($_POST["company_name"]);
        $contactnumber    = trim($_POST["contact_number"]);
        $email            = trim($_POST["company_email"]);
        $address          = trim($_POST["address"]);

        $msg = new Message();
        if (CompanyValidation::existCompanyname($companyname)) {
            $msg->pushErrorMsg('Company Name Already exist');
        }
        if (CompanyValidation::existEmail($email)) {
            $msg->pushErrorMsg('Company Email Address Already exist');
        }

        if (!UserService::mxrecordValidate($email)) {
            $msg->pushErrorMsg('please check the validity and domain name of Email');
        }

        if ($msg->getErrMsgCount() == 0) {
            $rowaffect = ComapanyDAO::insertCompany($companyname, $contactnumber, $email, $address);
            if ($rowaffect > 0) {
                $msg->pushSuccessMsg("Comapany Details Added successfully");
            }
        }
        $msg->printJsonMsg();
    }

    if ($_POST['action'] == 'EDIT') {
        $company_id    = trim($_POST["company_id"]);
        $companyname   = trim($_POST["company_name"]);
        $contactnumber = trim($_POST["contact_number"]);
        $email         = trim($_POST["company_email"]);
        $address       = trim($_POST["address"]);

        $msg = new Message();
        if (CompanyValidation::existCompanynameLock($companyname, $company_id)) {
            $errmsg->pushErrorMsg('Company Name Already exist');
        }
        if (CompanyValidation::existCompanyEmailLock($email, $company_id)) {
            $msg->pushErrorMsg('Company Email Address Already exist');
        }

        if ($msg->getErrMsgCount() == 0) {
            $rowaffect = ComapanyDAO::editCompanyDetails($company_id, $companyname, $contactnumber, $email, $address);
            if ($rowaffect == 0) {
                $msg->pushErrorMsg("No Changes Done");
            } else if ($rowaffect > 0) {
                $msg->pushSuccessMsg("Comapany edited successfully");
            }
        }
        $msg->printJsonMsg();
    }

    if ($_POST['action'] == 'FETCH_SINGLE') {
        $company_id = trim($_POST["company_id"]);
        echo json_encode(ComapanyDAO::findCompanyById($company_id));
    }

    if ($_POST['action'] == 'TOGGLE') {
        ComapanyDAO::toggleCompany($_POST['status'], $_POST["company_id"]);
    }
}
