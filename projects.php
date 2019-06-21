<?php
//category.php
include('./fragments/header.php');
include('database_config_dashboard.php');
if (!isset($_SESSION['type'])) {
	header("location:login.php");
}
?>
<span id="alert_action"></span>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
					<div class="row">
						<h3 class="panel-title">Projects Details</h3>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
					<div class="pull-right">
						<button type="button" name="add" id="add_button" data-toggle="modal" class="btn btn-primary btn-small">Add Project</button>
					</div>
				</div>
				<div style="clear:both"></div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12 table-responsive">
						<!-- Alert Actions goes here -->
						<span id="alert_action"></span>
						<table id="project_data" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Project Name</th>
									<th>Start date</th>
									<th>Description</th>
									<th>Remarks</th>
									<th>Edit</th>
									<th>Status</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include('./fragments/footer.html');
?>

<div id="projectModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="project_form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add Project Details</h4>
				</div>
				<div class="modal-body">
					<!-- Alert action goes here -->
					<span id="alert_msg_modal"></span>
					<div class="form-group">
						<label>Project Name</label>
						<input type="text" name="project_name" id="project_name" class="form-control" required placeholder="Enter Project Name" maxlength="25" />
					</div>

					<div class="form-group">
						<label>Start Date</label>
						<input type="date" name="start_date" id="start_date" class="form-control" required placeholder="Enter Start Date" maxlength="15" />
					</div>



					<div class="form-group">
						<label>Description</label>
						<textarea name="description" id="description" class="form-control" style="resize:none;" required placeholder="Enter Description" maxlength="30"></textarea>
					</div>

					<div class="form-group">
						<label>Remarks</label>
						<textarea name="remarks" id="remarks" class="form-control" style="resize:none;" required placeholder="Enter Remarks" maxlength="30"></textarea>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="project_id" id="project_id" />
						<input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION["user_id"]; ?>" />
						<input type="hidden" name="action" id="action" />
						<input type="submit" name="btn_action" id="btn_action" class="btn btn-info" value="Add" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
		</form>
	</div>
</div>
<?php include('./fragments/script.html'); ?>
<script>
	$(document).ready(function() {
		$.validator.setDefaults({
			errorClass: 'help-block',
			highlight: function(element) {
				$(element)
					.parent()
					.closest('.form-group')
					.addClass('has-error');

			},
			unhighlight: function(element) {
				$(element)
					.parent()
					.closest('.form-group')
					.removeClass('has-error');

			}
		});

		$('#add_button').click(function() {
			$('#project_form')[0].reset();
			validatorProject.resetForm();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Project Details");
			$('#action').val('ADD');
			$('#btn_action').val('Add');
			$('#btn_action').attr('disabled', false);
			$('#projectModal').modal('show');

		});

		$.validator.addMethod("noSpace", function(value, element) {
			return value.indexOf(" ") < 0 && value != "";
		}, "No space please and don't leave it empty");

		$.validator.addMethod(
			"regex",
			function(value, element, regexp) {
				var re = new RegExp(regexp);
				return this.optional(element) || re.test(value);
			},
			"Please check your input."
		);
		var validatorProject = $('#project_form').validate({

			rules: {
				project_name: {
					required: true,
					regex: "^[a-zA-Z'.\\s]{1,40}$",
					remote: {
						url: "validate.php",
						type: "post",
						data: {
							param: 'project_name',
							action: function() {
								return $('#action').val();
							},
							actionvalue: function() {
								return $('#project_id').val();
							},
							value: function() {
								return $('#project_name').val();
							}
						}
					}
				},
				start_date: {
					required: true
				},
				description: {
					required: true,
					minlength: 10,
					maxlength: 40
				},
				remarks: {
					required: true,
					minlength: 10,
					maxlength: 40
				}
			},
			messages: {
				project_name: {
					required: "please Enter Project Name",
					noSpace: "Spaces Not Allowed",
					regex: "Only character allowed",
					remote: "Already exist"
				},
				start_date: {
					required: "please Enter Start Date"

				},
				description: {
					required: "please enter Description",
					minlength: "Description should be atleast 10 characters",
					maxlength: "Description should not exceed 40 characters"
				},
				remarks: {
					required: "please enter Remarks",
					minlength: "Remarks should be atleast 10 characters",
					maxlength: "Remarks should not exceed 40 characters"
				}
			}
		});

		$(document).on('submit', '#project_form', function(event) {
			event.preventDefault();
			$('#btn_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			console.log(form_data);
			$.ajax({
				url: "projects_action.php",
				method: "POST",
				data: form_data,
				dataType: "json",
				success: function(data) {
					console.log(data);
					$('#btn_action').attr('disabled', false);
					if (data.type == 'success') {
						$('#project_form')[0].reset();
						$('#projectModal').modal('hide');
						$('#alert_action').fadeIn().html('<div class="alert alert-success">' + data.successMessage + '</div>');
						$('#action').attr('disabled', false);
						projectsdataTable.ajax.reload();
						setTimeout(function() {
							$('#alert_action').html('');
						}, 1500);
					} else if (data.type == 'err') {
						$('#alert_msg_modal').fadeIn().html('<div class="alert alert-danger">' + data.errorMessage + '</div>');
						$('#action').attr('disabled', false);
						setTimeout(() => {
							$('#alert_msg_modal').html('');
						}, 1500);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			})
		});

		$(document).on('click', '.update', function() {
			validatorProject.resetForm();
			var project_id = $(this).attr("id");
			var action = 'FETCH_SINGLE';
			$.ajax({
				url: "projects_action.php",
				method: "POST",
				data: {
					project_id: project_id,
					action: action
				},
				dataType: "json",
				success: function(data) {
					//console.log(data);
					$('#projectModal').modal('show');
					$('#project_name').val(data.project_name);
					$('#start_date').val(data.start_date);
					$('#description').val(data.description);
					$('#remarks').val(data.remarks);
					$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Project Details");
					$('#project_id').val(project_id);
					$('#action').val('EDIT');
					$('#btn_action').val("Update");
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			})
		});

		var projectsdataTable = $('#project_data').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				url: "projects_fetch.php",
				type: "POST",

			},
			"language": {
				"search": "Search by Project Name:",
				"searchPlaceholder": "Search Records"
			},
			"columnDefs": [{
				"targets": [0, 2, 3, 4, 5, 6],
				"orderable": false,
			}, ],
			"fnDrawCallback": function() {
				jQuery('#project_data .delete').bootstrapToggle({
					on: 'Inprogress',
					off: 'Finished',
					size: 'mini'
				});
			},
			"pageLength": 25
		});
		$(document).on('change', '.delete', function() {
			var project_id = $(this).attr('id');
			var status = $(this).data("status");
			var action = 'TOGGLE';
			if (confirm("Are you sure you want to change status?")) {
				$.ajax({
					url: "projects_action.php",
					method: "POST",
					data: {
						project_id: project_id,
						status: status,
						action: action
					},
					dataType: "json",
					success: function(data) {
						if (data.type == 'success') {
							$('#alert_action').fadeIn().html('<div class="alert alert-success">' + data.msg + '</div>');
							projectsdataTable.ajax.reload();
							setTimeout(function() {
								$('#alert_action').html('');
							}, 1500);
						}
						if (data.type == 'err') {
							$('#alert_action').fadeIn().html('<div class="alert alert-danger">' + data.msg + '</div>');
							companydataTable.ajax.reload();
							setTimeout(() => {
								$('#alert_action').html('');
							}, 1500);

						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						console.log(xhr.status);
						console.log(xhr.responseText);
						console.log(thrownError);
					}
				})
			} else {
				projectsdataTable.ajax.reload();
				return false;
			}
		});
	});
</script>