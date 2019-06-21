<?php  
 //fetch.php  
 include('database_mysqli_assign_company.php');
 if(isset($_POST["user_company_id"]))  
 {  
      $output = array();  
      $procedure = "  
      CREATE PROCEDURE whereUser(IN u_company_id int(11))  
      BEGIN   
      SELECT * FROM USER_COMPANY WHERE user_company_id = u_company_id;  
      END;   
      ";  
      if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS whereUser"))  
      {  
           if(mysqli_query($connect, $procedure))  
           {  
                $query = "CALL whereUser(".$_POST["user_company_id"].")";  
                $result = mysqli_query($connect, $query);
                if(mysqli_num_rows($result)>0){  
                while($row = mysqli_fetch_array($result))  
                {  
                     $output['user_company_id'] = $row["user_company_id"];
                     $output['company_id'] =$row["company_id"];  
                     $output['recruited_date'] = $row["recruited_date"]; 
                     $output['work_role'] = $row["work_role"];
                     $output['contract_period'] = $row["contract_period"];
                     
                     //$output['working_status'] = $row["working_status"];  
                }  
                echo json_encode($output);  
               }else{
                    echo json_encode(array('No data available'));
               }
               
           }  
      }  
 }  
 ?>