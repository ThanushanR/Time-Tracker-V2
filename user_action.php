<?php


include_once('includes/message.inc.php');
include_once('src/dbrepo.php');
include_once('src/User.dao.php');
include_once('src/User.service.php');
include_once('src/User.validation.php');
include_once('src/message.php');



if (isset($_POST['action'])) {
    if ($_POST['action'] == 'ADD') {

        $user_name = trim($_POST["user_name"]);
        $user_email = trim($_POST["user_email"]);
        $user_type = trim($_POST['user_type']);
        $userpassrnd = UserService::randomPassword();

        //validation goes here
        $msg = new Message();

        if (Uservalidation::existUsername($user_name)) {
            $msg->pushErrorMsg('User Name Already exist');
        }

        if (!UserService::mxrecordValidate($user_email)) {
            $msg->pushErrorMsg('please check the validity and domain name of Email');
        }

        if (Uservalidation::existEmail($user_email)) {
            $msg->pushErrorMsg('User Email Address Already exist');
        }

        if ($msg->getErrMsgCount() > 0) {
            $msg->printJsonMsg();
        } else {

            $lastid = UserDAO::insertUser($user_email, $user_name, $userpassrnd, $user_type);
            if ($lastid > 0) {

                $msg->pushSuccessMsg("New user created with id :" . $lastid);
                if (UserService::sendMailNotification($user_name, $user_email, $userpassrnd, "somurl.html")) {
                    $msg->pushSuccessMsg("Email send please check");
                } else {
                    $msg->pushErrorMsg("Unable to send email");
                }
                $msg->printJsonMsg();
            } else {
                $msg->pushErrorMsg('Some thing went wrong :Unable to Add user');
                $msg->printJsonMsg();
            }
        }
    }

    if ($_POST['action'] == 'EDIT') {
        $username  = trim($_POST["user_name"]);
        $useremail = trim($_POST["user_email"]);
        $usertype  = trim($_POST["user_type"]);
        $userid    = trim($_POST["user_id"]);
        $hiduseremail = trim($_POST["hidden_user_email"]);
        $hiddenUserName = trim($_POST["hidden_user_name"]);
        $hiddenUserType = trim($_POST["hidden_user_type"]);

        $msg = new Message();
        if (Uservalidation::existUsernameLock($username, $userid)) {
            $msg->pushErrorMsg('User Name Already exist');
        }
        if ($useremail != $hiduseremail) {

            if (Uservalidation::existEmail($useremail)) {
                $msg->pushErrorMsg('User Email Address Already exist');
            }

            if (!UserService::mxrecordValidate($useremail)) {
                $msg->pushErrorMsg('please check the validity and domain name of Email');
            }

            if ($msg->getErrMsgCount() == 0) {
                $userpassrnd = UserService::randomPassword();
                if (UserDAO::editUserEmail($userid, $useremail, $userpassrnd) > 0) {

                    $msg->pushSuccessMsg("Email is Updated :");
                    if (UserService::sendMailNotification($username, $useremail, $userpassrnd, "somurl.html")) {
                        $msg->pushSuccessMsg("Email send please check");
                    } else {
                        $msg->pushErrorMsg("Unable to send email");
                    }
                }
            }
        }

        if ($msg->getErrMsgCount() == 0) {
            if ($hiddenUserName != $username || $hiddenUserType != $usertype) {
                if (UserDAO::editUser($userid, $username, $usertype) > 0) {
                    $msg->pushSuccessMsg("User Details Edited Successfully");
                }
            }
        }



        $msg->printJsonMsg();
    }

    if ($_POST['action'] == 'FETCH_SINGLE') {
        $userid = trim($_POST["user_id"]);
        echo json_encode(UserDAO::findUserById($userid));
    }

    if ($_POST['action'] == 'TOGGLE') {
        $msg = new Message();
        if (UserDAO::toggleUser($_POST['status'], $_POST["user_id"])) {
            $msg->pushSuccessMsg('User Status had changed');
        } else {
            $msg->pushErrorMsg('Cannot change User Status');
        }
        $msg->printJsonMsg();
    }
}
