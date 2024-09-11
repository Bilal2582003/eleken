0<?php
if(isset($_GET['id'])){
    include 'connection.php';
    session_start();
    if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
        header('Location: index.php');
        exit; // Make sure to exit to prevent further script execution
    }
    
    $admin_email = $_SESSION['email'];
    $admin_id = $_SESSION['id'];
    
    $id=$_GET['id'];
    $query="DELETE FROM `a_project` WHERE id='$id'";
    $res=mysqli_query($con,$query);
    $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Delect Project $id')
    ";
    $res = mysqli_query($con, $admin_log);
    header("Location:project.php");
}

?>