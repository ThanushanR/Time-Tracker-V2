<?php
  try
  {
    $connect=new PDO('mysql:host=localhost;dbname=sgic-user;charset=utf8', 'root', 'manager');
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
  }
  catch(Exception $e)
  {
          die('Error : '.$e->getMessage());
  }

?>
