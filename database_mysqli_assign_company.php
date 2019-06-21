<?php
$connect = mysqli_connect("localhost","root", "manager", "sgic-user");
if(!$connect){
    die("connection failed:". mysqli_connect_error());
}
?>