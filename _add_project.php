<?php
include 'connection.php';
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: index.php');
    exit; // Make sure to exit to prevent further script execution
}

$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];


$category = $_POST['category'];
$name = $_POST['project_name'];

    $name = trim($name);
            // Converting to lowercase
    $name = strtolower($name);

$status = $_POST['status'];
$status = strtolower($status);
$project_assign = $_POST['project_assign'];
$client_name = $_POST['client_name'];
$client_amount = $_POST['client_amount'];
$client_tax = isset($_POST['client_tax']) ? $_POST['client_tax'] : 0;
$govt_tax = isset($_POST['govt_tax']) ? $_POST['govt_tax'] : 0;
$project_service = $_POST['project_service'];
$chart_head_code = $_POST['chart_head_code'];
$chart_detail_code = $_POST['chart_detail_code'];
// $held=$_POST['held'] !== '' ? $_POST['held']:null;
$held= 0;
$engineer=$_POST['engineer'] !== '' ? $_POST['engineer']:null;
$net_amount=( (int)$client_amount + (float)$client_tax ) - (float)$govt_tax;


  $sql = "INSERT INTO `a_project`(`category_id`,`service_id`, `name`,`engineer_id` ,`project_stage_id` ,`client_name`,`client_amount`, `client_tax`, `govt_tax`,`client_tax_held`, `net_amount`, `status`,`head_code`,`chart_acc_code`)
        VALUES ('$category','$project_service','$name',$engineer,'1','$client_name','$client_amount','$client_tax','$govt_tax',$held,'$net_amount','$status','$chart_head_code','$chart_detail_code')";
$res = mysqli_query($con,$sql);

if($res){
    $sql = "SELECT * FROM a_project order by id desc";
    $res = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($res);
    $id = $row['id'];

   // admin_log  
   $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Add New Project $id')
   ";
   $res = mysqli_query($con, $admin_log);


    $sql = "INSERT INTO `a_project_assign`(`group_id`, `project_id`)  VALUES('$project_assign','$id')";
    $res = mysqli_query($con,$sql);

    
    if($res){
        echo 1;
    }else{
        echo 0;
    }

}else{
    echo 0;
}