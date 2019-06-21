<?php
//profile.php
include('./fragments/header.php');
include('database_mysqli_assign_company.php');
include('function.php');
?>


<div class="row">


	<!-- profile panel starts here -->
	

	
	<div class="col-md-12 col-sm-12 col-xs-12 text-center">					
	<?php
	
  $procedure = "  
  CREATE PROCEDURE selectUser(IN u_id int(11))  
  BEGIN  
  SELECT  oc.company_name,uc.recruited_date,uc.working_status,uc.user_company_id,uc.work_role,uc.contract_period 
  FROM USER_COMPANY uc JOIN out_source_company oc 
  ON uc.company_id = oc.company_id 
  WHERE user_id=u_id ORDER BY user_company_id DESC; 
  END;  
  ";  
  if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS selectUser"))  
  {  
	   if(mysqli_query($connect, $procedure))  
	   {  
			$query = "CALL selectUser(".$_SESSION['user_id'].")";  
			$result = mysqli_query($connect, $query);  
			if(mysqli_num_rows($result) > 0)  
			{  
				 while($row = mysqli_fetch_array($result))  
				 {  
					 ?>
		<div class="panel panel-default margin-2">
			<div class="panel-heading">
				Works at - <?php echo $row['company_name'];?>
				<span class="pull-right">Works as - <?php echo $row['work_role'];?></span>
				</div>
			<div class="panel-body">
				

				

				<table class="table">
					<tr>
						<th>Recruited on</th>
						<th>Contract Period</th>
						<th>Left On</th>
					</tr>
					<tr>
						<th><?php echo $row['recruited_date'];?></th>
						<th><?php echo $row['contract_period'];?></th>

						<?php 
						if( $row['working_status']=='Working') {
							echo '<th><button>Notify Leave</button></th>';
						}else{
							echo '<td>dd-mm-yyyy</td>';
						}
						
						?>
					</tr>
				</table>
				
			</div>
		</div>
				 <?php 
				 }
				 	}else  
					{
						echo "Sorry You are not Recruited"; 
					}
				 }
				}?>



	</div>
	<!-- profile panel ends here -->


	

</div>

<?php
include('./fragments/footer.html');
?>