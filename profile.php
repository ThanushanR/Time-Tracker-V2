<?php
//profile.php
include('./fragments/header.php');
// include_once('includes/message.inc.php');
// include_once('src/dbrepo.php');
// include_once('src/UserProfile.dao.php');
$user_id = null;
if (isset($_GET['userid'])) {
	$user_id = $_GET['userid'];
} else {
	$user_id = $_SESSION['user_id'];
}
?>

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<div class="row">

	<!-- profile panel starts here -->
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-default margin-2">
			<div class="panel-heading">Profile</div>
			<div class="panel-body">
				<span id="profile_message"></span>
				<span id="errorprofile_message"></span>
				<form method="post" id="edit_profile_form" autocomplete="off">
					<!-- enctype="multipart/form-data" -->



					<div class="form-group">
						<label>User Name</label>
						<input type="text" name="user_name" id="user_name" class="form-control" required readonly />
					</div>
					<div class="form-group">
						<label>First Name</label>
						<input type="text" name="first_name" id="first_name" class="form-control" required />
					</div>

					<div class="form-group">
						<label>Last Name</label>
						<input type="text" name="last_name" id="last_name" class="form-control" required />
					</div>

					<div class="form-group">
						<label>Contact Number</label>
						<input type="text" name="contact_number" id="contact_number" class="form-control" required maxlength="13" />
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="user_email" id="user_email" class="form-control" required readonly />
					</div>

					<div class="form-group">
						<label>Address</label>
						<textarea name="address" id="address" class="form-control" rows="3" cols="3" style="resize:none;" required>
							</textarea>
					</div>

					<div class="form-group">
						<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
						<input type="hidden" name="action" id="action" />
						<input type="submit" name="btn_action" id="btn_action" class="btn btn-info" />
					</div>


				</form>
			</div>
		</div>
	</div>
	<!-- profile panel ends here -->


	<div class="col-md-6 col-sm-12 col-xs-12">

		<!-- Profile photo management -->
		<div class="panel panel-default margin-2">
			<div class="panel-heading">Change Profile Photo</div>
			<div class="panel-body">
				<span id="photo_upload"></span>
				<form method="post" id="edit_photo_form" action="upload.php">


					<div class="form-group">
						<label>Choose the file to change Profile Photo</label>
						<input type="file" name="photo" id="photo" accept=".jpg,.png" class="form-control" />
						<span id="empty_file"></span>
					</div>

					<div class="form-group">
						<input type="submit" name="edit_profile_photo" id="edit_profile_photo" value="Edit Profile Photo" class="btn btn-info" />
					</div>
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<div id="targetLayer" style="display:none;"></div>
				</form>

				<div id="loader-icon" style="display:none;"><img src="loader.gif" /></div>
			</div>
		</div>
		<!-- Profile photo management ends here-->


		<!-- change password  -->
		<div class="panel panel-default margin-2">
			<div class="panel-heading">Change Password</div>
			<div class="panel-body">
				<span id="pwd_message"></span>
				<span id="errorpwd_message"></span>
				<form method="post" id="edit_password_form">
					<label>Leave Password blank if you do not want to change</label>
					<div class="form-group">
						<label>Current Password <span>*</span></label>
						<input type="password" name="user_current_password" id="user_current_password" class="form-control" required />
					</div>


					<div class="form-group">
						<label>New Password</label>
						<input type="password" name="user_new_password" id="user_new_password" class="form-control" onKeyUp="checkPasswordStrength();" required />
						<div id="password-strength-status"></div>
					</div>
					<div class="form-group">
						<label>Re-enter Password</label>
						<input type="password" name="user_re_enter_password" id="user_re_enter_password" class="form-control" required />
						<span id="error_password"></span>
					</div>
					<div class="form-group">
						<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
						<input type="hidden" name="action" value="change_password" />
						<input type="hidden" name="password_strength" id="password_strength" />
						<input type="submit" name="change_password" id="change_password" value="Change Password" class="btn btn-info" />
					</div>
				</form>
			</div>
		</div>

		<!-- change password ends here -->

	</div>

</div>

<?php include('./fragments/script.html'); ?>
<script>
	//change password jquary
	function checkPasswordStrength() {
		var number = /([0-9])/;
		var alphabets = /([a-zA-Z])/;
		var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
		if ($('#user_new_password').val().length < 6) {
			$('#password-strength-status').removeClass();
			$('#password-strength-status').css({
				"background-color": "#E4DB11",
				"border": "#BBB418 1px solid"
			});
			$('#password-strength-status').html("Weak (should be atleast 6 characters.)");
			$('#password_strength').val('weak');
		} else {
			if ($('#user_new_password').val().match(number) && $('#user_new_password').val().match(alphabets) && $('#user_new_password').val().match(special_characters)) {
				$('#password-strength-status').removeClass();
				$('#password-strength-status').css({
					"background-color": "#12CC1A",
					"border": "#0FA015 1px solid"
				});

				$('#password-strength-status').html("Strong");
				$('#password_strength').val('strong');
			} else {
				$('#password-strength-status').removeClass();
				$('#password-strength-status').css({
					"background-color": "#FF6600",
					"border": "#AA4502 1px solid"
				});
				$('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
				$('#password_strength').val('medium');
			}
		}
	}
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

		$.validator.addMethod(
			"regex",
			function(value, element, regexp) {
				var re = new RegExp(regexp);
				return this.optional(element) || re.test(value);
			},
			"Please check your input."
		);

		var validatorUserProfile = $('#edit_profile_form').validate({

			rules: {
				first_name: {
					required: true,
					regex: "^[a-zA-Z'.\\s]{1,40}$"
				},
				last_name: {
					required: true,
					regex: "^[a-zA-Z'.\\s]{1,40}$"
				},
				contact_number: {
					required: true,
					digits: true,
					minlength: 10,
					maxlength: 10
				},
				address: {
					required: true,
					minlength: 10,
					maxlength: 40
				}
			},
			messages: {
				first_name: {
					required: "please Enter First Name",
					regex: "Only character allowed"
				},
				last_name: {
					required: "please Enter Last Name",
					regex: "Only character allowed"
				},
				contact_number: {
					required: "please Enter Contact Number",
					minlength: "phone number must be of 10 numbers",
					maxlength: "phone number must be of 10 numbers"

				},
				address: {
					required: "Please Enter Address",
					minlength: "Address should be atleast 10 characters",
					maxlength: "Address should not exceed 40 characters"
				}
			}
		});

		getProfileDetails();

		function getProfileDetails() {
			var user_id = "<?php echo $user_id; ?>";
			var action = 'FETCH_SINGLE';
			$.ajax({
				url: "userprofile_action.php",
				method: "POST",
				data: {
					user_id: user_id,
					action: action
				},
				dataType: "json",
				success: function(data) {
					//console.log(data.first_name);
					if (data.first_name == null) {
						$('#action').val('ADD_PROFILE');
						$('#btn_action').val('Add');
					} else {
						$('#action').val('EDIT_PROFILE');
						$('#btn_action').val('Edit');
					}
					$('#first_name').val(data.first_name);
					$('#last_name').val(data.last_name);
					$('#contact_number').val(data.contact_number);
					$('#address').val(data.address);
					$('#user_name').val(data.user_name);
					$('#user_email').val(data.user_email);

				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			})
		}


		$('#edit_password_form').on('submit', function(event) {
			event.preventDefault();
			if ($('#user_new_password').val() != '') {
				if ($('#user_new_password').val() != $('#user_re_enter_password').val()) {
					$('#error_password').html('<label class="text-danger">Password Not Match</label>');
					return false;
				} else {
					$('#error_password').html('');
				}
			}

			if ($('#password_strength').val() == 'strong') {
				var form_data = $(this).serialize();
				$('#change_password').attr('disabled', 'disabled');
				$('#user_re_enter_password').attr('required', false);
				$.ajax({
					url: "userprofile_action.php",
					method: "POST",
					data: form_data,
					dataType: "json",
					success: function(data) {
						if (data.type == 'success') {
							$('#change_password').attr('disabled', false);
							$('#user_current_password').val('');
							$('#user_new_password').val('');
							$('#user_re_enter_password').val('');
							$('#pwd_message').fadeIn().html('<div class="alert alert-success">' + data.successMessage + '</div>');
							$('#error_password').html('');
							$('#password-strength-status').remove();
							setTimeout(function() {
								$('#pwd_message').html('');
							}, 1500);
						} else if (data.type == 'err') {
							$('#change_password').attr('disabled', false);
							$('#errorpwd_message').fadeIn().html('<div class="alert alert-danger">' + data.errorMessage + '</div>');
							setTimeout(function() {
								$('#errorpwd_message').html('');
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
				$('#error_password').html('<label class="text-danger">Your password need to be strong In order to change password</label>');
			}


		});

		$('#edit_profile_form').on('submit', function(event) {
			event.preventDefault();
			//validatorUserProfile.resetForm();
			if (validatorUserProfile.errorList.length == 0) {
				var form_data = $(this).serialize();
				console.log(form_data);
				$('#edit_profile').attr('disabled', 'disabled');
				$('#user_re_enter_password').attr('required', false);
				$.ajax({
					url: "userprofile_action.php",
					method: "POST",
					data: form_data,
					dataType: "json",
					success: function(data) {
						getProfileDetails();
						if (data.type == 'success') {
							$('#edit_prfile').attr('disabled', false);
							$('#first_name').val('');
							$('#last_name').val('');
							$('#contact_number').val('');
							$('#address').val('');
							$('#user_name').val('');
							$('#user_email').val('');
							$('#photo').val('');
							$('#profile_message').fadeIn().html('<div class="alert alert-success">' + data.msg + '</div>');
							setTimeout(function() {
								$('#profile_message').html('');
							}, 1500);
						} else if (data.type == 'err') {
							$('#errorprofile_message').fadeIn().html('<div class="alert alert-danger">' + data.msg + '</div>');
							$('#edit_prfile').attr('disabled', false);
							setTimeout(function() {
								$('#errorprofile_message').html('');
							}, 1500);
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						console.log(xhr.status);
						console.log(xhr.responseText);
						console.log(thrownError);
					}
				})
			}
		});


		$('#edit_photo_form').submit(function(event) {
			if ($('#photo').val() == '') {
				$('#empty_file').html('<label class="text-danger">Please Choose file </label>');
				return false;
			} else {
				if ($('#photo').val()) {
					event.preventDefault();
					$('#loader-icon').show();
					$('#targetLayer').hide();
					var form_data = $(this).serialize();
					console.log(form_data);
					$(this).ajaxSubmit({
						data: form_data,
						target: '#targetLayer',
						beforeSubmit: function() {
							$('.progress-bar').width('50%');
						},
						uploadProgress: function(event, position, total, percentageComplete) {
							$('.progress-bar').animate({
								width: percentageComplete + '%'
							}, {
								duration: 1000
							});
						},
						success: function(data) {
							$('#loader-icon').hide();
							//$('#targetLayer').show();
							$('#photo_upload').html(data);

							setTimeout(function() {
								window.location.reload();
							}, 1500);
						},

						resetForm: true
					});
				}
			}
			return false;
		});
	});
</script>

<?php
include('./fragments/footer.html');
?>