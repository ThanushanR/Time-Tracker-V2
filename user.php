<?php

include('./fragments/header.php');
if (!isset($_SESSION["type"])) {
	header("location:index.php");
}

include('function.php');


?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
						<h3 class="panel-title">User List</h3>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
						<button type="button" name="add" id="add_button" class="btn btn-primary btn-small">Add User</button>
					</div>
				</div>

				<div class="clear:both"></div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12 table-responsive">
						<!-- Alert action goes here -->
						<span id="alert_action"></span>
						<?php
						?>
						<table id="user_data" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Email</th>
									<th>Name</th>
									<th>Role</th>
									<th>Edit</th>
									<th>Status</th>
									<th>Profile</th>
									<th>Recruitments</th>
									<th>Timesheet</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>



<div id="userModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form" autocomplete="off">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add User</h4>
				</div>
				<div class="modal-body">
					<span id="alert_msg_modal"></span>
					<div class="form-group">
						<label>User Name</label>
						<input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter User Name" required maxlength="30" />
						<input type="hidden" name="hidden_user_name" id="hidden_user_name" class="form-control" required />
					</div>
					<div class="form-group">
						<label>User Email</label>
						<input type="email" name="user_email" id="user_email" placeholder="Enter User Email" class="form-control" required maxlength="30" />
						<input type="hidden" name="hidden_user_email" id="hidden_user_email" class="form-control" required />
					</div>

					<div class="form-group">
						<label>User Role</label>
						<select name="user_type" id="user_type" class="form-control" required>
							<option value="">Select User Role</option>
							<?php echo fill_user_role_list($connect); ?>
							<!-- <option value="Other">Other</option> -->
						</select>
						<input type="hidden" name="hidden_user_type" id="hidden_user_type" class="form-control" required />
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="user_id" id="user_id" />
					<input type="hidden" name="action" id="action" />
					<span id="pleasewait"></span>
					<input type="submit" name="btn_action" id="btn_action" class="btn btn-info" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>

	</div>
</div>

<?php include('./fragments/script.html') ?>
<script>
	//assign company  data table
	$(document).ready(function() {
		$.validator.setDefaults({
			errorClass: 'help-block',
			focusCleanup: true,
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
		// getting user id
		var userid = null;


		$('#add_button').click(function() {
			$('#user_form')[0].reset();
			validatoruser.resetForm();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add User");
			$('#action').val("ADD");
			$('#btn_action').val("Add");
			$('#btn_action').attr('disabled', false);
			$('#userModal').modal('show');

		});

		// $(document).on('click', '#add_button', function () {
		// 		
		// 	})
		var userdataTable = $('#user_data').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"language": {
				"search": "Search by Name or Role or Status:",
				"searchPlaceholder": "Search Records"
			},
			"ajax": {
				url: "user_fetch.php",
				type: "POST",

			},
			"columnDefs": [{
				"targets": [0, 1, 4, 5, 6, 7, 8],
				"orderable": false
			}],
			"fnDrawCallback": function() {
				jQuery('#user_data .delete').bootstrapToggle({
					on: 'Active',
					off: 'Inactive',
					size: 'mini'
				});
			},
			"pageLength": 25
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




		var validatoruser = $('#user_form').validate({

			rules: {
				user_name: {
					required: true,
					noSpace: true,
					regex: "^[a-zA-Z'.\\s]{1,40}$",
					// remote: {
					// 	url: "validate.php",
					// 	type: "post",
					// 	data: {
					// 		param:'user_name',
					// 		action:function(){
					// 			return $('#action').val();
					// 		},
					// 		actionvalue:function(){
					// 			return $('#user_id').val();
					// 		},
					// 		value: function(){
					// 			return $('#user_name').val();
					// 		}
					// 	}
					// } 
				},
				user_email: {
					required: true,
					email: true,
					// remote: {
					// 	url: "validate.php",
					// 	type: "post",
					// 	data: {
					// 		param:'user_email',
					// 		action:function(){
					// 			return $('#action').val();
					// 		},
					// 		actionvalue:function(){
					// 			return $('#user_id').val();
					// 		},
					// 		value: function(){
					// 			return $('#user_email').val();
					// 		}
					// 	}
					// } 
				}
			},
			messages: {
				user_name: {
					required: "please Enter User name",
					noSpace: "Spaces Not Allowed",
					regex: "Only character allowed",
					//remote:"Already exist"
				},
				user_email: {
					required: "please Enter Email",
					noSpace: "Spaces Not Allowed",
					email: "please provide valid email",
					//remote:"Already exist"
				}
			}
		});


		$(document).on('submit', '#user_form', function(event) {
			event.preventDefault();
			$('#btn_action').attr('disabled', 'disabled');
			$('#pleasewait').html('<i class="fa fa-lg fa-spinner fa-spin"></i> pleasewait');

			var form_data = $(this).serialize();
			//console.log(form_data);
			$.ajax({
				url: "user_action.php",
				method: "POST",
				data: form_data,
				dataType: "json",
				success: function(data) {
					$('#btn_action').attr('disabled', false);
					$('#pleasewait').html('');
					console.log(data);
					if (data.type == 'success') {
						var suceessmsg = '';
						for (i = 0; i < data.successMessage.length; i++) {
							suceessmsg += data.successMessage[i] + '<br/>';
						}
						$('#user_form')[0].reset();
						$('#userModal').modal('hide');

						$('#alert_action').fadeIn().html('<div class="alert alert-success">' + suceessmsg + '</div>');

						userdataTable.ajax.reload();
						setTimeout(() => {
							$('#alert_action').html('');
						}, 3000);
					} else if (data.type == 'err' || data.type == 'no-changes') {
						var errmsg = '';
						if (data.type == 'no-changes') {
							errmsg = 'No changes done';
						}
						for (i = 0; i < data.errorMessage.length; i++) {
							errmsg += data.errorMessage[i] + '<br/>';
						}
						$('#alert_msg_modal').fadeIn().html('<div class="alert alert-danger">' + errmsg + '</div>');

						setTimeout(() => {
							$('#alert_msg_modal').html('');
						}, 3000);

					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		})



		$(document).on('click', '.update', function() {
			//validatoruser.resetForm();
			$('#btn_action').attr('disabled', false);
			var user_id = $(this).attr("id");
			var action = 'FETCH_SINGLE';
			$.ajax({
				url: "user_action.php",
				method: "POST",
				data: {
					user_id: user_id,
					action: action
				},
				dataType: "json",
				success: function(data) {
					$('#userModal').modal('show');
					$('#user_name').val(data.user_name);
					$('#user_email').val(data.user_email);
					$('#hidden_user_email').val(data.user_email);

					$('#user_form .modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit User");
					$('#user_id').val(user_id);
					$("#user_type").val(data.user_type);
					$('#btn_action').val('Update');
					$('#action').val('EDIT');
					$('#user_password').attr('required', false);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			})
		});

		$(document).on('change', '.delete', function() {
			var user_id = $(this).attr("id");
			var status = $(this).data('status');
			var action = "TOGGLE";
			if (confirm("Are you sure you want to change status?")) {
				$.ajax({
					url: "user_action.php",
					method: "POST",
					data: {
						user_id: user_id,
						status: status,
						action: action
					},
					dataType: "json",
					success: function(data) {
						console.log(data);
						if (data.type == 'success') {
							$('#alert_action').fadeIn().html('<div class="alert alert-success">' + data.successMessage + '</div>');
						} else if (data.type ==
							'err') {
							$('#alert_action').fadeIn().html('<div class="alert alert-danger">' + data.errorMessage + '</div>');
						}

						userdataTable.ajax.reload();
						setTimeout(() => {
							$('#alert_action').html('');
						}, 1500);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						console.log(xhr.status);
						console.log(xhr.responseText);
						console.log(thrownError);
					}
				})
			} else {
				userdataTable.ajax.reload();
				return false;
			}
		});

	});
</script>

<?php
include('./fragments/footer.html');
?>