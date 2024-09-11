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
if (isset($_POST['groupAction'])) {
    //   add new designation 
    if ($_POST['groupAction'] == 'add') {
        $groupName = $_POST['groupName'];
        
        $groupName = trim($groupName);
            // Converting to lowercase
            $groupName = strtolower($groupName);
            
        $query = "INSERT INTO `a_group`( `name`) VALUES ('$groupName')";
        $res = mysqli_query($con, $query);

        $id = mysqli_insert_id($con);
            // admin_log  
    $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Add New Group $id')
    ";
    $res = mysqli_query($con, $admin_log);

        echo 1;
    }
    // edit modal 
    if ($_POST['groupAction'] == 'fetchModal') {
        $id = $_POST['id'];
        $output = '';
        $query = "SELECT * from a_group where id='$id'";
        $res = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($res)) {

            $output .= '
                <form>
                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">Name:</label>
                        <input type="hidden" id="editGroupId" value="' . $row["id"] . '">
                        
                         <input class="form-control text-capitalize"  type="text" id="editGroupName" value="' . $row["name"] . '">
                    </div>
                    
                </form>
                ';
        };

        echo $output;
    }

    //   edit modal end 
    if ($_POST['groupAction'] == 'updateGroup') {
        $id = $_POST['id'];
        $name = $_POST['name'];
           $name = trim($name);
            // Converting to lowercase
            $name = strtolower($name);
        $query = "UPDATE `a_group` SET `name`='$name' WHERE id='$id'";
        $res = mysqli_query($con, $query);

    // admin_log  
    $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Edit Group $id')
    ";
    $res = mysqli_query($con, $admin_log);

        echo 1;
    }
}



//   delete department 
if (isset($_GET['id'])) {
    // include 'connection.php';
    $id = $_GET['id'];
    echo $query = "DELETE FROM `a_group` WHERE id='$id'";
    $res = mysqli_query($con, $query);
    // admin_log  
    $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Delete Group $id')
    ";
    $res = mysqli_query($con, $admin_log);
    header("location:Group.php");
}
// end department 
