<?php
include 'connection.php';
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: index.php');
    exit; // Make sure to exit to prevent further script execution
}

$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];

$p_id = $_POST['p_id'];
$group = $_POST['group'];

$sql = "INSERT INTO a_project_assign(`group_id`,`project_id`) VALUES('$group','$p_id')";
$res = mysqli_query($con,$sql);

if($res){
        echo 1;
}else{
    echo 0;
}