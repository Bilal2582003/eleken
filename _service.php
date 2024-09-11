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
if (isset($_POST['serviceAction'])) {
    //   add new designation 
    if ($_POST['serviceAction'] == 'add') {
        $serviceName = $_POST['serviceName'];
        
           $serviceName = trim($serviceName);
            // Converting to lowercase
            $serviceName = strtolower($serviceName);
        
        $query = "INSERT INTO `a_project_service`( `name`) VALUES ('$serviceName')";
        $res = mysqli_query($con, $query);

        $id = mysqli_insert_id($con);
            // admin_log  
    $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Add New Service $id')
    ";
    $res = mysqli_query($con, $admin_log);

        echo 1;
    }
    // edit modal 
    if ($_POST['serviceAction'] == 'fetchModal') {
        $id = $_POST['id'];
        $output = '';
        $query = "SELECT * from a_project_service where id='$id'";
        $res = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($res)) {

            $output .= '
                <form>
                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">Name:</label>
                        <input type="hidden" id="editServiceId" value="' . $row["id"] . '">
                        
                         <input class="form-control text-capitalize" type="text" id="editServiceName" value="' . $row["name"] . '">
                    </div>
                    
                </form>
                ';
        };

        echo $output;
    }

    //   edit modal end 
    if ($_POST['serviceAction'] == 'updateService') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        
        $name = trim($name);
            // Converting to lowercase
            $name = strtolower($name);
        
        $query = "UPDATE `a_project_service` SET `name`='$name' WHERE id='$id'";
        $res = mysqli_query($con, $query);

    // admin_log  
    $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Edit Service $id')
    ";
    $res = mysqli_query($con, $admin_log);

        echo 1;
    }
}



//   delete department 
if (isset($_GET['id'])) {
    // include 'connection.php';
    $id = $_GET['id'];
    echo $query = "DELETE FROM `a_project_service` WHERE id='$id'";
    $res = mysqli_query($con, $query);
    // admin_log  
    $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Delete Service $id')
    ";
    $res = mysqli_query($con, $admin_log);
    header("location:Service.php");
}
// end department 
