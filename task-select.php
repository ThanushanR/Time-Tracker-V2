<?php

session_start();
require_once('database_mysqli_assign_company.php');
require_once('src/dbrepo.php');
require_once('src/Task.dao.php');

$output = '';


function fill_project_list($connect, $id)
{
     $query = "SELECT * FROM project WHERE user_id = " . $_SESSION["user_id"] . " AND project_status='In_progress'";
     $result = mysqli_query($connect, $query);
     $project_list = '';
     if (mysqli_num_rows($result) > 0) {
          if ($id == null) {
               $project_list .= '<option value="" selected>Please select your project</option>';
          }
          while ($row = mysqli_fetch_array($result)) {
               if ($id == $row["project_id"]) {
                    $project_list .= '<option value="' . $row["project_id"] . '" selected>' . $row["project_name"] . '</option>';
               } else {
                    $project_list .= '<option value="' . $row["project_id"] . '">' . $row["project_name"] . '</option>';
               }
          }
     }

     return $project_list;
}

function print_duration($timeMins)
{
     $time_unit = "";
     for ($i = 30; $i <= 120; $i = $i + 30) {
          $hr = floor($i / 60) == 0 ? '' : floor($i / 60) . "hr";
          $min = $i % 60 == 0 ? '' : ($i % 60) . "min";
          if ($i == $timeMins) {
               $time_unit .= "<option value={$i} selected>{$hr}  {$min}</option>";
          } else {
               $time_unit .= "<option value={$i}>{$hr}  {$min}</option>";
          }
     }
     return $time_unit;
}

$date = $_POST['date'];
$userid = $_SESSION['user_id'];

$result = TaskDAO::getAllEventsByDateAndUserId($date, $userid);
$resultsum = TaskDAO::sumAllEventsByDateAndUserId($date, $userid);

//print_r($result);
$output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">  
                <tr>   
				<th width="25%">Projects/work</th>  
                     <th width="25%">Task Name</th>  
                     <th width="10%">Duration</th>
                     <th width="30%">Description</th>  
                     <th>Color</th>
                     <th width="10%"></th>  
                </tr>';
if (count($result) > 0) {
     foreach ($result as $row) {
          if ($_GET['uistate'] == "enabled") {
               $output .= '  
                <tr>  
                <td id="projects">
                <select class ="projects" data-id0="' . $row["id"] . '" >';

               $output .= fill_project_list($connect, $row["project_id"]);
               $output .= ' </select>
                </td> 
                     <td class="taskname" data-id1="' . $row["id"] . '" contenteditable=true>' . $row["title"] . '</td>  
                     <td>
                     <select class ="duration" data-id2="' . $row["id"] . '">';
               $output .= print_duration($row["duration"]);
               $output .= '</select>
                 
                     </td>

                     <td class="description" data-id3="' . $row["id"] . '" contenteditable>' . $row["description"] . '</td>  
                     <td>


                     </td>
                     <td><button type="button" name="delete_btn" data-id3="' . $row["id"] . '" class="btn btn-xs btn-danger btn_delete">x</button></td>  
                </tr>  
           ';
          } else if ($_GET['uistate'] == "disabled") {
               $output .= '  
                    <tr>  
                    <td id="projects">
                    <select class ="projects" data-id0="' . $row["id"] . '" disabled>';

               $output .= fill_project_list($connect, $row["project_id"]);
               $output .= ' </select>
                    </td> 
                         <td>' . $row["title"] . '</td>  
                         <td>
                         <select class ="duration" data-id2="' . $row["id"] . '" disabled>';
               $output .= print_duration($row["duration"]);
               $output .= '</select>
                     
                         </td>
    
                         <td>' . $row["description"] . '</td>  
                          
                    </tr>  
               ';
          }
     }

     if ($_GET['uistate'] == "enabled") {
          $output .= '  
           <tr>  
           <td>
           <select id="project">';

          $output .= fill_project_list($connect, null);
          $output .= '</select>
           </td> 
                <td id="taskname" contenteditable></td>  
                <td>
                <select id="duration">';
          $output .= print_duration(null);
          $output .= '</select>
         
                </td>  
                <td id="description" contenteditable></td>  
                <td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success">+</button></td>  
           </tr>  
      ';
     }
} else {
     if ($_GET['uistate'] == "enabled") {
          $output .= '
      
      <tr>  
      <td>
      <select id="project">';
          $output .= fill_project_list($connect, null);
          $output .= ' </select>
      </select>
      </td> 
           <td id="taskname" contenteditable></td>  
           <td>
           <select id="duration">';
          $output .= print_duration(null);
          $output .= '</select>
           </td>  
           <td id="description" contenteditable></td>  
           <td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success">+</button></td>  
      </tr>  ';
     }
}


if ($resultsum != null) {
     $totaltime = $resultsum;
     $hr = floor($totaltime / 60);
     $min = $totaltime % 60;

     $remainingtime = 480 - $totaltime;
     $rhr = floor($remainingtime / 60);
     $rmin = $remainingtime % 60;

     $output .= '<tr><td colspan=2 align="right"><label class="sr-only" id="label-time">' . $totaltime . '</label>Time Covered</td><td>' . $hr . ' hrs ' . $min . ' mins</td></tr>';
     $output .= '<tr><td colspan=2 align="right"><label class="sr-only" id="label-time-remain">' . $remainingtime . '</label>Time Remaining</td><td>' . $rhr . ' hrs ' . $rmin . ' mins</td></tr>';
}
$output .= '</table>';
$output .= '</div>';
echo $output;  
 // <th width="10%">Id</th> 
 //<td>'.$row["id"].'</td> 
 //<td class="duration" data-id2="'.$row["id"].'" contenteditable>'.$row["duration"].'</td> 
