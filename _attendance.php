<?php
include 'connection.php';
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: index.php');
    exit; // Make sure to exit to prevent further script execution
}

$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];
//   for designation
if (isset($_POST['attendanceAction'])) {
    //   add new designation 
    if ($_POST['attendanceAction'] == 'add') {
        $startTimeAttendance = $_POST['startTimeAttendance'] !== '' ?  $_POST['startTimeAttendance'] :  '';
        $endTimeAttendance = $_POST['endTimeAttendance'] !== '' ?  $_POST['endTimeAttendance'] :  '';
        $empAttendance = $_POST['empAttendance'];
        $statusAttendance = $_POST['statusAttendance'];
        $attendanceType = $_POST['attendanceType'];
        if ($attendanceType == 'check in') {
            $query = "INSERT INTO `attendance`(`employee_id`, `type`, `start_time`,`status`) VALUES ('$empAttendance','$attendanceType','$startTimeAttendance','$statusAttendance')";
        } else if ($attendanceType == 'check out') {
            $query = "INSERT INTO `attendance`( `employee_id`, `type`, `end_time`, `status`) VALUES ('$empAttendance','$attendanceType','$endTimeAttendance','$statusAttendance')";
        }

        $res = mysqli_query($con, $query);
        echo 1;
    }
    // edit modal 
    if ($_POST['attendanceAction'] == 'fetchModal') {
        $id = $_POST['id'];
        $output = '';
        $query = "SELECT employee.id as emp_id,
           employee.name as emp_name,
           attendance.id as id,
           attendance.created_at as created_at,
           attendance.*
           from attendance join employee on attendance.employee_id = employee.id where attendance.id='$id'";
        $res = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($res)) {
            $empId = $row['emp_id'];
            $optionQuery = "SELECT * from employee where id != '$empId'";
            $optionRes = mysqli_query($con, $optionQuery);
            $option = '<select class="form-control" id="editEmpAttendance"> <option selected value="' . $row["emp_id"] . '">' . $row["emp_name"] . '</option>';
            while ($optionRow = mysqli_fetch_assoc($optionRes)) {
                $option .= '<option value="' . $optionRow["id"] . '">' . $optionRow["name"] . '</option>';
            }
            $option .= '</select>';

            if ($row['type'] == 'check in') {
                $type = "check out";
            } else {
                $type = "check in";
            }

            $output .= '
                <form>
                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">Employee:</label>
                        <input type="hidden" id="editAttendanceId" class="" value="' . $row["id"] . '">
                        
                        ' . $option . '
                    </div>
                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">Type:</label>
                        <select class=" form-control" id="editTypeAttendance">
                        <option selected value="' . $row['type'] . '">' . $row['type'] . '</option>
                        <option value="' . $type . '">' . $type . '</option>
                        </select>
                    </div>
                    <div class="form-group " id="editStartTimeAttendanceMainDiv">
                        <label for="depart-name" class="col-form-label">Start Time:</label>
                        <input type="time" id="editStartTimeAttendance" class=" form-control" value="' . $row["start_time"] . '">
                    </div>
                    <div class="form-group " id="editEndTimeAttendanceMainDiv" >
                        <label for="depart-name" class="col-form-label">End Time:</label>
                        <input type="time" id="editEndTimeAttendance" class=" form-control" value="' . $row["end_time"] . '">
                    </div>
                     <div class="form-group" id="editStatusAttendanceMainDiv">
                        <label for="depart-name" class="col-form-label">Status:</label>
                        <p  class=" form-control" id="editStatusAttendance">' . $row["status"] . '</p>
                    </div>
                </form>
                ';
        };

        echo $output;
    }

    //   edit modal end 
    if ($_POST['attendanceAction'] == 'updateAttendance') {
        $editStartTimeAttendance = $_POST['editStartTimeAttendance'] !== '' ?  $_POST['editStartTimeAttendance'] :  '';
        $editEndTimeAttendance = $_POST['editEndTimeAttendance'] !== '' ?  $_POST['editEndTimeAttendance'] :  '';
        $editEmpAttendance = $_POST['editEmpAttendance'];
        $editTypeAttendance = $_POST['editTypeAttendance'];
        $editStatusAttendance = $_POST['editStatusAttendance'];
        $editAttendanceId = $_POST['editAttendanceId'];
        //   echo $editStartTimeAttendance;
        if ($editTypeAttendance == 'check in') {
            $query = "UPDATE `attendance` SET `employee_id`='$editEmpAttendance',`type`='$editTypeAttendance',`start_time`='$editStartTimeAttendance',`end_time`=null,`status`='$editStatusAttendance' where id='$editAttendanceId'";
        } else if ($editTypeAttendance == 'check out') {
            $query = "UPDATE `attendance` SET `employee_id`='$editEmpAttendance',`type`='$editTypeAttendance',`start_time`=null,`end_time`='$editEndTimeAttendance',`status`='$editStatusAttendance' where id='$editAttendanceId'";
        }

        $res = mysqli_query($con, $query);
        echo 1;
    }
}



//   delete department 
if (isset($_GET['id'])) {
    // include 'connection.php';
    $id = $_GET['id'];
    $query = "DELETE FROM `a_project_category` WHERE id='$id'";
    $res = mysqli_query($con, $query);
    header("location:project.php");
}
// end department 
