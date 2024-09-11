<?php
include 'connection.php';
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: index.php');
    exit; // Make sure to exit to prevent further script execution
}

$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];


$ep_name = $_POST['ep_name'];
$eg_name = $_POST['eg_name'];
$e_event = $_POST['e_event'];
$e_amount = $_POST['e_amount'];

$sql = "INSERT INTO `a_expenses`(`project_id`, `group_id`, `event`, `amount`) VALUES ('$ep_name','$eg_name','$e_event','$e_amount')";
$res = mysqli_query($con,$sql);
$id = mysqli_insert_id($con);

     // admin_log  
     $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Add New Category $id')
     ";
          $res = mysqli_query($con, $admin_log);


if($res){
        echo 1;
}else{
    echo 0;
}