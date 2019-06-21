<?php

include('./fragments/header.php');
require_once 'src/User.dao.php';
require_once 'src/Recruitment.dao.php';
include('function.php');

$userid=$_GET["userid"];
$dbStatus=UserDAO::getUserStatusById($userid);


$statusActive='Active';
if($dbStatus!='Active'){
	$statusActive='Inactive';
}
?>

<!-- Company Modal Goes here -->
<div id="companyModal" class="modal fade">
	<div class="modal-dialog">

		<form id="company_form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Manage Recruitment</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="company_name">Select Company</label>
						<select name="company_name" id="company_name" class="form-control" required>
							<option value="">Select Company</option>
							<?php echo fill_company_list($connect); ?>
							<!-- <option value="Other">Other</option> -->
						</select>
					</div>

					<div class="form-group">
						<label>Work Role</label>
						<select name="work_role" id="work_role" class="form-control" required />
						<option>Associate Software Engineer</option>
						<option>Associate Q-A Engineer</option>
						<option> Software Engineer</option>
						<option> Q-A Engineer</option>
						<option> Tech Lead</option>
						<option> Architect</option>
						<select>
					</div>

					<div class="form-group">
						<label for="recruited_date">Recruited Date</label>
						<input type="date" name="recruited_date" id="recruited_date" class="form-control" required />
					</div>

					<div class="form-group">
						<label>Contract Period (In months)</label>
						<input type="number" name="contract_Period" id="contract_Period" class="form-control" required
							min="0" />
					</div>

					

				</div>
				<div class="modal-footer">
					<input type="hidden" name="user_id" id="user_id"
						value="<?php echo $_GET['userid'];?>" />
					<input type="hidden" name="recruitId" id="recruitId" />
					<input type="hidden" name="action" id="action" value="ADD" />
					<input type="submit" name="btn_action" id="btn_action" class="btn btn-info" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Termination modal goes here -->
<div id="terminationModal" class="modal fade">
	<div class="modal-dialog">

		<form id="termination_form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Make Termination</h4>
				</div>
				<div class="modal-body">
					

					<div class="form-group">
						<label>Termination Choices:</label>
						<select name="termination_choice" id="termination_choice" class="form-control" required />
						<option>Contract Period Finished</option>
						<option>With Employee willingness</option>
						<option>Misbehaviour</option>
						<option>Performance Problem</option>
						<select>
					</div>

					<div class="form-group">
						<label for="recruited_date">Termination Date</label>
						<input type="date" name="termination_date" id="recruited_date" class="form-control" required />
					</div>

					<div class="form-group">
						<label>Termination Memo :</label>
						<textarea name="termination_memo" id="termination_memo" class="form-control" rows="3" cols="3" style="resize:none;" required></textarea>
					</div>

					

				</div>
				<div class="modal-footer">
				
					<input type="hidden" name="recruitId" id="recruitId" />
					<input type="hidden" name="action" id="action" value="ADD" />
					<input type="submit" name="btn_action" id="btn_action" class="btn btn-info" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="user.php">User List</a></li>
			<li class="active">recruitments</li>
		</ol>
	</div>
</div>

<?php

if($statusActive!='Active'){
	echo "<div class='alert alert-danger' role='alert'>The Account is in Deactive , So you can only view the Details </div>";
}
?>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-8 col-xs-6">
						<h3 class="panel-title">Company Assignment</h3>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-4 col-xs-6 pull-right">
						<?php
					if($statusActive=='Active'){
						if(RecruitmentDAO::checkWorkingStatus($userid)){
						echo "<span class='alert-danger '>Can not Assign Company Since the User is Alredy Working</span>";
						echo "<button type='button' name='add' id='add_button' class='btn btn-primary btn-small pull-right' disabled>Add Recruitment</button>";
						}else{
							echo "<button type='button' name='add' id='add_button' class='btn btn-primary btn-small pull-right'>Add Recruitment</button>";
						}
					}else{
						echo "<button type='button' name='add' id='add_button' class='btn btn-primary btn-small pull-right' disabled>Add Recruitment</button>";
					}
					?>

					</div>
				</div>

				<div class="clear:both"></div>
			</div>
			<div class="panel-body">
				<div id="alert_company_action"></div>
				<!-- Fetch results goes here -->
				<div id="result"></div>
			</div>
		</div>

	</div>
</div>


<?php include('./fragments/script.html')?>



<script>

	function fetchCompany(userid) {
		
		var action = "SELECT";
		var status="<?php echo $statusActive;?>";
		$.ajax({
			url: "recruitment_select.php",
			method: "POST",
			data: { action: action, user_id: userid,status:status },
			success: function (data) {
				$('#result').html(data);
			},
			error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
			}
		});
	}

	

	$(document).ready(function () {
		var userId="<?php echo $userid;?>";
		fetchCompany(userId);

		$('#add_button').on('click', function () {
			$('#companyModal #action').val('ADD');
			$('#companyModal').modal('show');
		});

		$(document).on('click', '.TERMINATE', function (event) {
			var id=$(this).attr('id');
			$('#terminationModal #action').val('ADD_TERMINATE');
			$('#terminationModal').modal('show');
			
		});

		$(document).on('submit', '#termination_form', function (event) {
			event.preventDefault();
			var form_data = $(this).serialize();
			console.log(form_data);
			$.ajax({
				url: "recruitment_action.php",
				method: "POST",
				data: form_data,
				success: function (data) {
					$('#company_form')[0].reset();
					$('#companyModal').modal('hide');
					$('#alert_company_action').html(data);
					$('#btn_action_company').attr('disabled', false);
					fetchCompany(userId);
					$('#alert_company_action').html(data);
					// setTimeout(() => {
					// 	window.location.reload();
					// }, 1500);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		});


		$(document).on('submit', '#company_form', function (event) {
			event.preventDefault();
			$('#btn_action_company').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			console.log(form_data);
			$.ajax({
				url: "recruitment_action.php",
				method: "POST",
				data: form_data,
				success: function (data) {
					$('#company_form')[0].reset();
					$('#companyModal').modal('hide');
					$('#alert_company_action').html(data);
					$('#btn_action_company').attr('disabled', false);
					fetchCompany(userId);
					$('#alert_company_action').html(data);
					// setTimeout(() => {
					// 	window.location.reload();
					// }, 1500);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		});


		

		$(document).on('click', '.EDIT_COMPANY', function(){
		
		var id = $(this).attr("id");

		var action = 'FETCH_SINGLE';
		$.ajax({
			url:"recruitment_action.php",
			method:"POST",
			data:{recruit_id: id, action: action},
			dataType:"json",
			success:function(data)
			{
				console.log(data);
				$('#action').val('EDIT');
				$('#btn_action').val("Update");
				$('#companyModal').modal('show');
				
				$('companyModal .modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Recruitment Details");
				
				$('#recruitId').val(id);
				$('#company_name').val(data.company_id);
				$('#work_role').val(data.work_role);
				$('#recruited_date').val(data.recruited_date);
				$('#contract_Period').val(data.contract_period);

			}
		})
		});



		$(document).on('click', '.delete_company', function () {
			var id = $(this).attr("id");

			if (confirm("Are you sure you want to remove this data?")) {
				var action = "DELETE";
				$.ajax({
					url: "recruitment_action.php",
					method: "POST",
					data: {recruit_id: id, action: action },
					dataType:"json",
					success: function (data) {
						console.log(data);
						fetchCompany(userId);
						$('#alert_company_action').html(data.msg);
						setTimeout(() => {
							window.location.reload();
						}, 1500);
					}
				})
			}
			else {
				return false;
			}
		});

	});
</script>

<?php
include('./fragments/footer.html');
?>