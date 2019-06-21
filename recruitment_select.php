<?php
include_once('src/Recruitment.dao.php');
$output = '';


$statusActive = 'Active';
if ($_POST["status"] != 'Active') {
	$statusActive = 'Inactive';
}

if (isset($_POST["action"])) {
	$userid = trim($_POST['user_id']);
	$rows = RecruitmentDAO::getUserRecruitments($userid);

	if (count($rows) > 0) {
		foreach ($rows as $row) {
			?>
			<div class="col-md-12 ">
				<div class="panel panel-success">
					<div class="panel-heading">



						<span>
							<h4 style="display:inline;">Recruited Details</h4>
						</span>

						<span class="pull-right">
							<?php
							if ($statusActive == 'Active') {


								echo "<button class='btn btn-xs btn-primary EDIT_COMPANY'  id='{$row['id']}' ><i class='fa fa-edit'   aria-hidden='true'></i></button>";
								echo "&nbsp";
								echo "<button class='btn btn-xs btn-primary delete_company'  id='{$row['id']}' ><i class='fa fa-trash'   aria-hidden='true'></i></button>";
							} else {

								echo "<button class='btn btn-xs btn-primary EDIT_COMPANY' style='padding:0px;width:200%;' id='{$row['id']}' disabled><i class='fa fa-edit'   aria-hidden='true'></i></button>";
								echo "&nbsp";
								echo "<button class='btn btn-xs btn-primary delete_company' style='padding:0px;width:200%;' id='{$row['id']}' disabled><i class='fa fa-trash'   aria-hidden='true'></i></button>";
							}
							?>
						</span>
					</div>
					<div class="panel-body">

						<div class="col-md-6">
							<div class="thumbnail">
								<table class="table">
									<tr>
										<th align="right">Recruited at</th>
										<th><?php echo $row['company_name']; ?></th>
									</tr>
									<tr>
										<th align="right">Recruited as :</th>
										<th><?php echo $row['work_role']; ?></th>
									</tr>

									<tr>
										<th align="right">Work Title :</th>
										<th><?php echo $row['work_role']; ?></th>
									</tr>

								</table>
							</div>


						</div>

						<div class="col-md-6">
							<div class="thumbnail">
								<table class="table">

									<tr>
										<th align="right">Recruited on</th>
										<th><?php echo $row['recruited_date']; ?></th>
									</tr>
									<tr>
										<th align="right">Contract Period</th>
										<th><?php echo $row['contract_period']; ?> (months)</th>
									</tr>
									<tr>
										<th align="right">Working Staus</th>
										<?php
										if ($row['working_status'] == 'Working') {
											echo "<th>
                                   <span style='color:green'>Working</span>
                                   <button class='btn btn-xs btn-danger pull-right TERMINATE' id='{$row['id']}'>Terminate</button></th>";
										} else {
											echo "<td>Left on : {$row['date_of_termination']}</td>";
										}

										?>
									</tr>
								</table>
							</div>
						</div>





					</div>
				</div>
			</div>
		<?php
	}
} else {
	$output .= '  
                          <tr>  
                               <td colspan="4">Data not Found</td>  
                          </tr>  
                     ';
}
$output .= '</table>';
echo $output;
}
?>