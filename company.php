<?php
//category.php
include './fragments/header.php';
include 'database_config_dashboard.php';
if (!isset($_SESSION["type"])) {
	header("location:login.php");
}

?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
					<div class="row">
						<h3 class="panel-title">Company Details</h3>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
					<div class="pull-right">
						<button type="button" name="add" id="add_button" class="btn btn-primary btn-small">Add Company</button>
					</div>
				</div>
				<div style="clear:both"></div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12 table-responsive">
						<!-- Alert Actions goes here -->
						<span id="alert_action"></span>
						<table id="company_data" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Company Name</th>
									<th>Contact Number</th>
									<th>Email</th>
									<th>Address</th>
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
include './fragments/footer.html';
?>

<!-- Modal goes here -->
<div id="companyModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="company_form" autocomplete="off">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add User role</h4>
				</div>
				<div class="modal-body">

					<!-- Alert action goes here -->
					<span id="alert_msg_modal"></span>

					<div class="form-group">
						<label>Company Name</label>
						<input type="text" name="company_name" id="company_name" class="form-control" placeholder="Enter Company Name" required maxlength="20" />
					</div>

					<div class="form-group">
						<label>Contact Number</label>
						<input type="text" name="contact_number" id="contact_number" class="form-control" placeholder="Enter Contact Number" required maxlength="13" />
					</div>

					<div class="form-group">
						<label>Email</label>
						<input type="email" name="company_email" id="company_email" class="form-control" placeholder="Enter Email" required maxlength="25" />
					</div>

					<div class="form-group">
						<label>Address</label>
						<textarea name="address" id="address" class="form-control" placeholder="Enter Address" required maxlength="30" style="resize:none;"></textarea>
					</div>

					<div class="modal-footer">
						<input type="hidden" name="company_id" id="company_id" />
						<input type="hidden" name="action" id="action" />
						<input type="submit" name="btn_action" id="btn_action" class="btn btn-info" value="Add" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
		</form>
	</div>
</div>

<?php include './fragments/script.html'; ?>

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




		var validatorCompany = $('#company_form').validate({

			rules: {
				company_name: {
					required: true,
					regex: "^[a-zA-Z'.\\s]{1,40}$",
					remote: {
						url: "validate.php",
						type: "post",
						data: {
							param: 'company_name',
							action: function() {
								return $('#action').val();
							},
							actionvalue: function() {
								return $('#company_id').val();
							},
							value: function() {
								return $('#company_name').val();
							}
						}
					}
				},
				contact_number: {
					required: true,
					digits: true,
					minlength: 10,
					maxlength: 10
				},
				company_email: {
					required: true,
					email: true,
					remote: {
						url: "validate.php",
						type: "post",
						data: {
							param: 'company_email',
							action: function() {
								return $('#action').val();
							},
							actionvalue: function() {
								return $('#company_id').val();
							},
							value: function() {
								return $('#company_email').val();
							}
						}
					}
				},
				address: {
					required: true,
					minlength: 10,
					maxlength: 40
				}
			},
			messages: {
				company_name: {
					required: "please Enter Company Name",
					regex: "Only character allowed",
					remote: "Already exist"
				},
				contact_number: {
					required: "please Enter Contact Number",
					minlength: "phone number must be of 10 numbers",
					maxlength: "phone number must be of 10 numbers"

				},
				company_email: {
					required: "please Enter Email Address",
					email: "please provide valid email address",
					remote: "Already exist"
				},
				address: {
					required: "please enter Address",
					minlength: "Address should be atleast 10 characters",
					maxlength: "Address should not exceed 40 characters"
				}
			}
		});

		$('#add_button').click(function() {
			$('#company_form')[0].reset();
			validatorCompany.resetForm();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Company");
			$('#action').val('ADD');
			$('#btn_action').val('Add');
			$('#btn_action').attr('disabled', false);
			$('#companyModal').modal('show');
		});

		$(document).on('submit', '#company_form', function(event) {
			event.preventDefault();
			$('#btn_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			//console.log(form_data);
			$.ajax({
				url: "company_action.php",
				method: "POST",
				data: form_data,
				dataType: "json",
				success: function(data) {
					console.log(data);
					$('#btn_action').attr('disabled', false);
					if (data.type == 'success') {
						$('#company_form')[0].reset();
						$('#companyModal').modal('hide');
						$('#alert_action').fadeIn().html('<div class="alert alert-success">' + data.successMessage + '</div>');

						companydataTable.ajax.reload();
						setTimeout(() => {
							$('#alert_action').html('');
						}, 1500);
					} else if (data.type == 'err') {
						$('#alert_msg_modal').fadeIn().html('<div class="alert alert-danger">' + data.errorMessage + '</div>');
						$('#action').attr('disabled', false);
						setTimeout(() => {
							$('#alert_msg_modal').html('');
						}, 2000);
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
			validatorCompany.resetForm();
			var company_id = $(this).attr("id");
			var action = 'FETCH_SINGLE';
			$.ajax({
				url: "company_action.php",
				method: "POST",
				data: {
					company_id: company_id,
					action: action
				},
				dataType: "json",
				success: function(data) {
					//console.log(data);
					$('#companyModal').modal('show');
					$('#company_name').val(data.company_name);
					$('#contact_number').val(data.contact_number);
					$('#company_email').val(data.email);
					$('#address').val(data.address);
					$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Company details");
					$('#company_id').val(company_id);
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

		var companydataTable = $('#company_data').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				url: "company_fetch.php",
				type: "POST",

			},
			"language": {
				"search": "Search by Company Name or Status:",
				"searchPlaceholder": "Search Records"
			},
			"columnDefs": [{
				"targets": [0, 2, 3, 4, 5, 6],
				"orderable": false,
			}, ],
			"fnDrawCallback": function() {
				jQuery('#company_data .delete').bootstrapToggle({
					on: 'Active',
					off: 'Inactive',
					size: 'mini'
				});
			},
			"pageLength": 25
		});
		$(document).on('change', '.delete', function() {
			var company_id = $(this).attr('id');
			var status = $(this).data("status");
			var action = 'TOGGLE';
			if (confirm("Are you sure you want to change status?")) {
				$.ajax({
					url: "company_action.php",
					method: "POST",
					data: {
						company_id: company_id,
						status: status,
						action: action
					},
					dataType: "json",
					success: function(data) {
						//console.log(data);
						if (data.type == 'success') {
							$('#alert_action').fadeIn().html('<div class="alert alert-success">' + data.msg + '</div>');
							companydataTable.ajax.reload();
							setTimeout(() => {
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
				companydataTable.ajax.reload();
				return false;
			}
		});
	});
</script>