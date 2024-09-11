<?php
include 'connection.php';
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: index.php');
    exit; // Make sure to exit to prevent further script execution
}

$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];


$status = $_POST['status'];
$status = strtolower($status);
$id = $_POST['id'];
$remarks = $_POST['remarks'];




$history = "SELECT * from project_history where project_id = '$id' order by id desc limit 1";
$resHistory = mysqli_query($con, $history);
if (mysqli_num_rows($resHistory) > 0) {
    $row=mysqli_fetch_assoc($resHistory);
    $statuschk=$row['new_status'];
    $remarkchk=$row['new_remarks'];
    
    // history maintain 
    $history_id=$row['id'];
    $query="UPDATE project_history 
    SET new_status = '$status', new_remarks = '$remarks' 
    WHERE id = '$history_id'";
    $res = mysqli_query($con, $query);
    
    // admin_log  
    $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Update Status and remarks of Project $id')
    ";
    $res = mysqli_query($con, $admin_log);
    if($res){
        $sql = "UPDATE a_project SET `status` = '$status', `remarks`='$remarks' where `id` = '$id'";
        $res = mysqli_query($con, $sql);
    }

}


if ($res) {
    echo 1;
} else {
    echo 0;
}
