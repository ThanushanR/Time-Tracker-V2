<?php
include('./fragments/header.php');
if (!isset($_SESSION['type'])) {
     header("location:login.php");
}



$userid = $_SESSION['user_id'];

$currentdate = strtotime(date("Y-m-d"));
$gotDate = strtotime($_GET['date']);

$disabledstatus = "enabled";
if ($currentdate > $gotDate) {
     $disabledstatus = "disabled";
}



//echo $disabledstatus;
?>

<!-- Content Section Starts here -->
<link rel="stylesheet" href="css/bootstrap-clockpicker.min.css">

<div id="content">

     <header>
          <h2 class="page_title">Attendance </h2>
     </header>


     <div class="row">

          <div class="col-md-4">
               <div>
                    <form id="formTimeIn">
                         <div class="form-group text-center">
                              <label class="sr-only">Time In</label>
                              <label for=>Time In</label>

                              <div class="input-group clockpicker " style="width: 60%;margin:auto">
                                   <input type="text" class="form-control" id="timein" name="timein" readonly>
                                   <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                              </div>

                              <input type="hidden" name="action" value="TIME_IN" />
                              <br />
                              <input type="submit" id="btntimeIn" class="btn btn-primary" value="I'm in">
                         </div>
                    </form>
               </div>
          </div>

          <div class="col-md-4 text-center">
               <h4><?php echo $_GET['date']; ?></h4>
               <h3>Working Hours</h3>
               <h4>-hrs --mins</h4>
          </div>


          <div class="col-md-4">
               <form id="formTimeOut">
                    <div class="form-group text-center">
                         <label class="sr-only">Time Out</label>
                         <label>Time out</label>
                         <div class="input-group clockpicker" style="width: 60%;margin:auto">
                              <input type="text" class="form-control" id="timeout" value="" name="timeout" <?php echo $disabledstatus; ?> readonly>
                              <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-time"></span>
                              </span>
                         </div>

                         <input type="hidden" name="action" value="TIME_OUT" />
                         <br />
                         <input type="submit" id="btntimeOut" class="btn btn-primary" value="I'm out">
                    </div>
               </form>
          </div>



     </div>


</div>



<!-- Content Section Starts here -->
<div id="content">
     <form>
          <input type="hidden" id="hiddendate" value="<?php echo $_GET['date']; ?>" />
     </form>
     <!-- Alert action goes here -->
     <span id="alert_action"></span>
     <div id="live_data"></div>
</div>



<?php include('./fragments/script.html') ?>
<script src="js/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
     $('.clockpicker').clockpicker({
          placement: 'bottom',
          align: 'left',
          donetext: 'Done'
     });
</script>

<script>
     $(document).ready(function() {
          var hdate = $('#hiddendate').val();
          var userid = "<?php echo $userid; ?>";

          var currentdate = "<?php echo $currentdate; ?>";
          var gotdate = "<?php echo $gotDate ?>";

          if (currentdate - gotdate != 0) {
               $('#btntimeIn').attr('disabled', 'disabled');
               $('#btntimeOut').attr('disabled', 'disabled');
          }

          function fetchTimeData() {
               $.ajax({
                    url: `task_action.php`,
                    method: "POST",
                    data: {
                         date: hdate,
                         userid: userid,
                         action: 'LOAD'
                    },
                    dataType: "json",

                    success: function(data) {
                         console.log(data);
                         //$('#result').html(data);
                         $('#timein').val(data.time_in);
                         $('#timeout').val(data.time_out);
                    }
               });

          }

          fetchTimeData();




          function fetch_data() {
               $.ajax({
                    url: "task-select.php?uistate=<?php echo $disabledstatus; ?>&date=" + hdate,
                    method: "POST",
                    data: {
                         date: hdate
                    },
                    success: function(data) {
                         $('#live_data').html(data);
                    }
               });
          }
          fetch_data();

          $('#formTimeIn').submit(function(event) {

               event.preventDefault();
               var formdata = $(this).serialize();
               var serializedata = formdata + "&date=" + hdate + "&userid=" + userid;
               console.log(serializedata);
               $.ajax({
                    url: "time_action.php",
                    method: "POST",
                    data: serializedata,
                    dataType: "json",
                    success: function(data) {
                         alert(data.msg);

                    }
               });
          });

          $('#formTimeOut').submit(function(event) {
               event.preventDefault();
               var formdata = $(this).serialize();
               var serializedata = formdata + "&date=" + hdate + "&userid=" + userid;
               console.log(serializedata);


               $.ajax({
                    url: "time_action.php",
                    method: "POST",
                    data: serializedata,
                    dataType: "json",
                    success: function(data) {
                         alert(data.msg);
                         window.location.reload();
                    }
               });

          });


          $(document).on('click', '#btn_add', function() {
               var project = $('#project').val();
               var taskname = $('#taskname').text();
               var duration = $('#duration').val();
               var description = $('#description').text();
               var totaltime = $('#label-time').text();

               if (project == '') {
                    alert("Please choose project");
                    return false;
               }
               if (taskname == '') {
                    alert("Enter task name");
                    return false;
               }
               if (duration == '') {
                    alert("Enter duration");
                    return false;
               }
               if (description == '') {
                    alert("Enter description");
                    return false;
               }


               if (Number(totaltime) + Number(duration) > 480) {
                    alert("Cant' allow , exceed 8 hrs");
                    return false;
               }

               $.ajax({
                    url: "task_action.php",
                    method: "POST",
                    data: {
                         action: 'ADD',
                         project: project,
                         taskname: taskname,
                         duration: duration,
                         description: description,
                         date: hdate
                    },
                    dataType: "json",
                    success: function(data) {

                         $('#alert_action').fadeIn().html('<div class="alert alert-success">' + data.msg + '</div>');
                         fetch_data();

                         setTimeout(() => {
                              $('#alert_action').html('');
                         }, 3000);


                    }
               })

          });

          function edit_data(id, text, column_name) {


               $.ajax({
                    url: "task_action.php",
                    method: "POST",
                    data: {
                         action: 'EDIT',
                         id: id,
                         text: text,
                         column_name: column_name
                    },
                    dataType: "json",
                    success: function(data) {
                         $('#alert_action').fadeIn().html('<div class="alert alert-success">' + data.msg + '</div>');
                         fetch_data();

                         setTimeout(() => {
                              $('#alert_action').html('');
                         }, 3000);
                    }
               });
          }

          $(document).on('change', '.projects', function() {
               var id = $(this).data("id0");
               var project_id = $(this).val();
               edit_data(id, project_id, "project_id");
               //alert("id :"+id +"duration:"+duration);
          });
          $(document).on('blur', '.taskname', function() {
               var id = $(this).data("id1");
               var taskname = $(this).text();
               edit_data(id, taskname, "title");
          });
          $(document).on('change', '.duration', function() {
               var id = $(this).data("id2");
               var duration = $(this).val();
               var totaltime = $('#label-time').text();
               if (Number(totaltime) + Number(duration) > 480) {
                    alert("Cant' allow , exceed 8 hrs");
                    fetch_data();
                    return false;
               }
               edit_data(id, duration, "duration");
               //alert("id :"+id +"duration:"+duration);
          });
          $(document).on('blur', '.description', function() {
               var id = $(this).data("id3");
               var description = $(this).text();
               edit_data(id, description, "description");
          });

          $(document).on('click', '.btn_delete', function() {
               var id = $(this).data("id3");
               if (confirm("Are you sure you want to delete this?")) {
                    $.ajax({
                         url: "task_action.php",
                         method: "POST",
                         data: {
                              action: 'DELETE',
                              id: id
                         },
                         dataType: "json",
                         success: function(data) {
                              $('#alert_action').fadeIn().html('<div class="alert alert-success">' + data.msg + '</div>');
                              fetch_data();

                              setTimeout(() => {
                                   $('#alert_action').html('');
                              }, 3000);
                         }
                    });
               }
          });
     });
</script>


<?php
include('./fragments/footer.html');
?>