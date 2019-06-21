<?php
//category.php
include('fragments/header.php');

if(!isset($_SESSION['type']))
{
	header("location:login.php");
}
?>

<style>
	.notice {
		padding: 15px;
		padding-right: 5px;
		background-color: #fafafa;
		border-left: 6px solid #7f7f84;
		margin-bottom: 10px;
		-webkit-box-shadow: 0 5px 8px -6px rgba(0, 0, 0, .2);
		-moz-box-shadow: 0 5px 8px -6px rgba(0, 0, 0, .2);
		box-shadow: 0 5px 8px -6px rgba(0, 0, 0, .2);
	}

	.notice-sm {
		padding: 10px;
		font-size: 80%;
	}

	.notice-lg {
		padding: 35px;
		font-size: large;
	}

	.notice-success {
		border-color: #80D651;
	}

	.notice-success>strong {
		color: #80D651;
	}

	.notice-info {
		border-color: #45ABCD;
	}

	.notice-info>strong {
		color: #45ABCD;
	}

	.notice-warning {
		border-color: #FEAF20;
	}

	.notice-warning>strong {
		color: #FEAF20;
	}

	.notice-danger {
		border-color: #d73814;
	}

	.notice-danger>strong {
		color: #d73814;
	}

	.media-photo {
		width: 35px;
	}

	.approve-card {
		padding: 5px;
	}

	.approve-card h6 {
		padding: 0;
		margin: 0px;
	}
</style>

<div class="row">

	<div class="col-md-8">
		<div>

			<div class="card border-danger mx-sm-1 p-3">
				<div class="card border-danger shadow text-danger p-3 my-card"><span class="fa fa-heart"
						aria-hidden="true"></span></div>
				<div class="text-danger text-center mt-3">
					<h4>Hearts</h4>
				</div>
				<div class="text-danger text-center mt-2">
					<h1>346</h1>
				</div>
			</div>

			<div class="card border-danger mx-sm-1 p-3">
				<div class="card border-danger shadow text-danger p-3 my-card"><span class="fa fa-heart"
						aria-hidden="true"></span></div>
				<div class="text-danger text-center mt-3">
					<h4>Hearts</h4>
				</div>
				<div class="text-danger text-center mt-2">
					<h1>346</h1>
				</div>
			</div>

		</div>

		<div id="calendar" class="col-centered" style="width:85%;"></div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Leave Status</h3>
			</div>
			<div class="panel-body">

				<div class="notice notice-success">




					<table>
						<tr>


							<td>
								<div class="text-center approve-card">
									<a href="#">
										<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg"
											class="media-photo img-circle">
									</a>
									<div>

										<h6>Project Manager</h6>
										<span class="label label-default">Approved</span>
									</div>
								</div>


							</td>

							<td>
								<div class="text-center approve-card">
									<a href="#">
										<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg"
											class="media-photo img-circle">
									</a>
									<div>

										<h6>HR Manager</h6>
										<span class="label label-default">Approved</span>
									</div>
								</div>


							</td>

							<td>
								<div class="text-center approve-card">
									<a href="#">
										<img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg"
											class="media-photo img-circle">
									</a>
									<div>

										<h6>Director</h6>
										<span class="label label-default">Approved</span>
									</div>
								</div>


							</td>




						</tr>
					</table>

					<div class="notice notice-info notice-sm">
						<br />Type : <strong>Casual</strong>
						<br />From <strong>2019 -06 - 07</strong> to <strong>2019 -06 - 09</strong>
						<br />Applied on : <strong>2019 - 08 - 09</strong>
						<br />Reason : Going to trip

						<div>
							<button class="btn btn-xs btn-primary pull-right">Cancel </button>
						</div>
					</div>


				</div>
				<!-- <div class="notice notice-danger">
					<strong>Notice</strong> notice-danger
				</div>

				<div class="notice notice-warning">
					<strong>Notice</strong> notice-warning
				</div> -->


			</div>
		</div>
	</div>
</div>
<!-- /.row -->

<!-- Modal -->
<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form class="form-horizontal" method="POST" action="addEvent.php">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Event</h4>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Title</label>
						<div class="col-sm-10">
							<input type="text" name="title" class="form-control" id="title" placeholder="Title">
						</div>
					</div>
					<div class="form-group">
						<label for="color" class="col-sm-2 control-label">Color</label>
						<div class="col-sm-10">
							<select name="color" class="form-control" id="color">
								<option value="">Choose</option>
								<option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
								<option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
								<option style="color:#008000;" value="#008000">&#9724; Green</option>
								<option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
								<option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
								<option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
								<option style="color:#000;" value="#000">&#9724; Black</option>

							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="start" class="col-sm-2 control-label">Start date</label>
						<div class="col-sm-10">
							<input type="text" name="start" class="form-control" id="start" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="end" class="col-sm-2 control-label">End date</label>
						<div class="col-sm-10">
							<input type="text" name="end" class="form-control" id="end" readonly>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>



<!-- Modal -->
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form class="form-horizontal" method="POST" action="editEventTitle.php">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Edit Event</h4>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Title</label>
						<div class="col-sm-10">
							<input type="text" name="title" class="form-control" id="title" placeholder="Title">
						</div>
					</div>
					<div class="form-group">
						<label for="color" class="col-sm-2 control-label">Color</label>
						<div class="col-sm-10">
							<select name="color" class="form-control" id="color">
								<option value="">Choose</option>
								<option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
								<option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
								<option style="color:#008000;" value="#008000">&#9724; Green</option>
								<option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
								<option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
								<option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
								<option style="color:#000;" value="#000">&#9724; Black</option>

							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
								<label class="text-danger"><input type="checkbox" name="delete"> Delete event</label>
							</div>
						</div>
					</div>

					<input type="hidden" name="id" class="form-control" id="id">


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>

</div>
<!-- /.container -->

<!-- jQuery Version 1.11.1 -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- FullCalendar -->
<script src='js/moment.min.js'></script>
<script src='js/fullcalendar.min.js'></script>

<script>

	$(document).ready(function () {
		console.log(new Date("yyyy-mm-dd"))
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek'
			},
			//	defaultDate: '2016-01-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,

			dayClick: function (date, allDay, jsEvent, view) {

				var date = moment(date).format('YYYY-MM-DD');
				window.location.href = encodeURI(`task.php?date=${date}`);


			},
			eventRender: function (event, element) {
				element.bind('dblclick', function () {
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #title').val(event.title);
					$('#ModalEdit #color').val(event.color);
					$('#ModalEdit').modal('show');
				});
			},
			eventDrop: function (event, delta, revertFunc) { // si changement de position
				if (delta._days <= -1) {
					alert("Can't drag to previous days");
					revertFunc();
				} else if (delta._days > 1) {
					alert("Can't drag to more than one day");
					revertFunc();
				} else {
					edit(event);
				}
			},
			eventResize: function (event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur

				edit(event);

			},
			events: [


			]
		});

		function edit(event) {
			start = event.start.format('YYYY-MM-DD HH:mm:ss');
			if (event.end) {
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			} else {
				end = start;
			}

			id = event.id;

			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;

			$.ajax({
				url: 'editEventDate.php',
				type: "POST",
				data: { Event: Event },
				success: function (rep) {
					if (rep == 'OK') {
						alert('Saved');
					} else {
						alert('Could not be saved. try again.');

					}
				}
			});
		}

	});

</script>

</body>

</html>