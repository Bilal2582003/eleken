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
if (isset($_POST['officeAction'])) {
    //   add new designation 
    if ($_POST['officeAction'] == 'add') {
        $location = $_POST['location'];
        $query = "INSERT INTO `office`( `location`) VALUES ('$location')";
        $res = mysqli_query($con, $query);

        $id = mysqli_insert_id($con);
            // admin_log  
    $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Add New Office $id')
    ";
    $res = mysqli_query($con, $admin_log);

        echo 1;
    }
    // edit modal 
    if ($_POST['officeAction'] == 'fetchModal') {
        $id = $_POST['id'];
        $output = '';
        $query = "SELECT * from office where id='$id'";
        $res = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($res)) {

            $output .= '
                <form>
                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">Name:</label>
                        <input type="hidden" id="editOfficeId" value="' . $row["id"] . '">
                        
                         <input class="form-control text-capitalize"  type="text" id="editOfficeLocation" value="' . $row["location"] . '">
                    </div>
                    
                </form>
                ';
        };

        echo $output;
    }

    //   edit modal end 
    if ($_POST['officeAction'] == 'updateOffice') {
        $id = $_POST['id'];
        $location = $_POST['location'];
        $query = "UPDATE `office` SET `location`='$location' WHERE id='$id'";
        $res = mysqli_query($con, $query);

    // admin_log  
    $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Edit Office $id')
    ";
    $res = mysqli_query($con, $admin_log);

        echo 1;
    }
}



//   delete department 
if (isset($_GET['id'])) {
    // include 'connection.php';
    $id = $_GET['id'];
    $date=date("Y-m-d H:i:s");
     $query = "UPDATE `office` SET `deleted_at`='$date' WHERE id='$id'";
    $res = mysqli_query($con, $query);
    // admin_log  
    $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Delete Office $id')
    ";
    $res = mysqli_query($con, $admin_log);
    header("location:Office.php");
}
// end department 
