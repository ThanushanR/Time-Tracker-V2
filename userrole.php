<?php
include './fragments/header.php';

if (!isset($_SESSION['type'])) {
	header("location:login.php");
}
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
					<div class="row">
						<h3 class="panel-title">User Role</h3>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
					<div class="pull-right">
						<button type="button" name="add" id="add_button" class="btn btn-primary btn-small">Add Role</button>
					</div>
				</div>
				<div style="clear:both"></div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12 table-responsive">
						<!-- Alert action goes here -->
						<span id="alert_action"></span>

						<table id="role_data" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>User Role</th>
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

<!-- User role Modal goes here -->
<div id="userroleModal" class="modal fade">
	<div class="modal-dialog">

		<form method="post" id="userrole_form" autocomplete="off">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add User role</h4>
				</div>
				<div class="modal-body">

					<!-- Alert Msg goes here -->
					<span id="alert_msg_modal"></span>
					<div class="form-group">
						<label>User Role</label>
						<input type="text" name="role_name" id="role_name" class="form-control" placeholder="Enter User Role" required />
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="role_id" id="role_id" />
					<input type="hidden" name="action" id="action" />
					<input type="submit" name="btn_action" id="btn_action" class="btn btn-info" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
include './fragments/script.html';
?>
<script>
	$(document).ready(function() {

		$.validator.setDefaults({
			errorClass: 'help-block',
			highlight: function(element) {
				$(element)
					.closest('.form-group')
					.addClass('has-error');
			},
			unhighlight: function(element) {
				$(element)
					.closest('.form-group')
					.removeClass('has-error');
			}
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


		// validation rules for User Role
		var validatorUserRole = $('#userrole_form').validate({
			rules: {
				role_name: {
					required: true,
					regex: "^[a-zA-Z'.\\s]{1,40}$",
					remote: {
						url: "validate.php",
						type: "post",
						data: {
							param: 'rolename',
							value: function() {
								return $('#role_name').val();
							}
						}
					}


				}
			},
			messages: {
				role_name: {
					required: "please Enter Role name",
					regex: "Only character allowed",
					remote: "Already exist"
				}
			}
		});

		// Action for Add Button
		$('#add_button').click(function() {
			$('#userrole_form')[0].reset();
			validatorUserRole.resetForm();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Role");
			$('#action').val('ADD');
			$('#btn_action').val('Add');
			$('#userroleModal').modal('show');

		});

		$(document).on('submit', '#userrole_form', function(event) {
			event.preventDefault();
			$('#btn_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			//console.log(form_data);
			$.ajax({
				url: "userrole_action.php",
				method: "POST",
				data: form_data,
				dataType: "json",
				success: function(data) {
					//console.log(data);
					$('#btn_action').attr('disabled', false);
					if (data.type == 'success') {
						$('#userrole_form')[0].reset();
						$('#userroleModal').modal('hide');
						$('#alert_action').fadeIn().html('<div class="alert alert-success">' + data.msg + '</div>');

						roledataTable.ajax.reload();
						setTimeout(() => {
							$('#alert_action').html('');
						}, 1500);
					} else if (data.type == 'err') {
						$('#alert_msg_modal').fadeIn().html('<div class="alert alert-danger">' + data.msg + '</div>');

						setTimeout(() => {
							$('#alert_msg_modal').html('');
						}, 1500);
					}

				}
			})
		});

		$(document).on('click', '.update', function() {
			validatorUserRole.resetForm();
			var role_id = $(this).attr("id");

			var action = 'FETCH_SINGLE';
			$.ajax({
				url: "userrole_action.php",
				method: "POST",
				data: {
					role_id: role_id,
					action: action
				},
				dataType: "json",
				success: function(data) {
					console.log(data);
					$('#userroleModal').modal('show');
					$('#role_name').val(data);
					$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Role");
					$('#role_id').val(role_id);
					$('#action').val('EDIT');
					$('#btn_action').val("Update");
				}
			})
		});

		var roledataTable = $('#role_data').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				url: "userrole_fetch.php",
				type: "POST"
			},
			"language": {
				"searchPlaceholder": "Search Records",
				"search": "Search by Role or Status:"
			},
			"columnDefs": [{
				"targets": [0, 2, 3],
				"orderable": false,
			}, ],
			"fnDrawCallback": function() {
				jQuery('#role_data .delete').bootstrapToggle({
					on: 'Active',
					off: 'Inactive',
					size: 'mini'
				});
			},
			"pageLength": 25
		});

		$(document).on('change', '.delete', function() {
			var role_id = $(this).attr('id');
			var status = $(this).data("status");
			var action = 'TOGGLE';
			if (confirm("Are you sure you want to change status?")) {
				$.ajax({
					url: "userrole_action.php",
					method: "POST",
					data: {
						role_id: role_id,
						status: status,
						action: action
					},
					dataType: "json",
					success: function(data) {
						console.log(data);
						if (data.type == 'success') {
							$('#alert_action').fadeIn().html('<div class="alert alert-success">' + data.msg + '</div>');
							roledataTable.ajax.reload();
							setTimeout(() => {
								$('#alert_action').html('');
							}, 1500);
						}
						if (data.type == 'err') {
							$('#alert_action').fadeIn().html('<div class="alert alert-danger">' + data.msg + '</div>');
							roledataTable.ajax.reload();
							setTimeout(() => {
								$('#alert_action').html('');
							}, 1500);
						}
					}
				})
			} else {
				roledataTable.ajax.reload();
				return false;
			}
		});


	});
</script>

<?php
include './fragments/footer.html';
?>