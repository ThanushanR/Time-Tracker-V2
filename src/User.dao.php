<?php

require_once 'dbrepo.php';
class UserDAO
{



    public static function insertUser($email, $username, $userpass, $usertype)
    {
        $repo = new DBrepo();
        $query = "
		INSERT INTO user (user_email, user_password, user_name, user_type, user_status)
		VALUES (TRIM(:user_email), TRIM(:user_password), TRIM(:user_name), TRIM(:user_type), :user_status)
		";

        $param = array(
            ':user_email'    => $email,
            ':user_password' => password_hash($userpass, PASSWORD_DEFAULT),
            ':user_name'     => $username,
            ':user_type'     => $usertype,
            ':user_status'   => 'Active',
        );

        return $repo->executeInsertGetLastId($query, $param);
    }

    public static function findUserById($userid)
    {
        $repo = new DBrepo();
        $query = "SELECT * FROM user WHERE user_id = :user_id";
        $row = $repo->getSingleResult($query, array(':user_id'    =>    $userid));
        return $row;
    }

    public static function getUserStatusById($userid)
    {
        $repo = new DBrepo();
        $query = "SELECT `user_status` FROM `user` WHERE `user_id`=:user_id";
        $row = $repo->getSingleResult($query, array(':user_id'    =>    $userid));
        return $row['user_status'];
    }

    public static function editUser($userid, $username, $usertype)
    {
        $repo = new DBrepo();
        $query = "
        UPDATE user SET
        user_name =TRIM(:user_name),
        user_type =:user_type
        WHERE user_id =:user_id
        ";

        $param = array(
            ':user_name'  => $username,
            ':user_type'  => $usertype,
            ':user_id'    => $userid,
        );

        return $repo->executeWitAffectedrows($query, $param);
    }

    public static function editUserEmail($userid, $useremail, $userpassrnd)
    {
        $repo = new DBrepo();
        $query = "
        UPDATE user SET
        user_email =TRIM(:user_email),
        user_password =:user_pass
        WHERE user_id =:user_id
        ";

        $param = array(
            ':user_email'  => $useremail,
            ':user_pass'  => password_hash($userpassrnd, PASSWORD_DEFAULT),
            ':user_id'    => $userid,
        );

        return $repo->executeWitAffectedrows($query, $param);
    }

    public static function toggleUser($prmstatus, $userId)
    {
        $repo = new DBrepo();
        $status = 'Active';
        if ($prmstatus == 'Active') {
            $status = 'Inactive';
        }

        $query = "SELECT user_role.role_status as rolestatus FROM 
        user JOIN user_role ON user.user_type =user_role.role_id 
        WHERE user.user_id =:user_id";

        $row = $repo->getSingleResult($query, array(':user_id'    =>    $userId));
        if ($row["rolestatus"] == 'Active') {
            $query = "
            UPDATE user
            SET user_status = :user_status
            WHERE user_id = :user_id
            ";

            $param = array(
                ':user_status' => $status,
                ':user_id'     => $userId,
            );

            if ($repo->executeWitAffectedrows($query, $param) > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
