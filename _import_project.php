<?php
include 'connection.php';

if(isset($_POST["Import"])){

   $filename=$_FILES["file"]["tmp_name"];
$orignalFileName= $_FILES["file"]['name'];
 $fileExtention =pathinfo($orignalFileName, PATHINFO_EXTENSION);
 if($fileExtention == 'csv'){
     if($_FILES["file"]["size"] > 0){

        $file = fopen($filename, "r");

        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
            $category_id = 0;
            $group_id = 0;
            
            $getData[1] = trim($getData[1]);
            // Converting to lowercase
            $getData[1] = strtolower($getData[1]);
            
            // check if category exists in category table, if not insert it
             $category_id_query = "SELECT `id` FROM `a_project_category` WHERE `name` = '".$getData[1]."'";
            $category_id_result = mysqli_query($con, $category_id_query);

            if(mysqli_num_rows($category_id_result) > 0){
                $category_id_row = mysqli_fetch_assoc($category_id_result);
                $category_id = $category_id_row['id'];
            }else{
                 $category_insert_query = "INSERT INTO `a_project_category`(`name`) VALUES ('".$getData[1]."')";
                mysqli_query($con, $category_insert_query);
                $category_id = mysqli_insert_id($con);
            }

            $getData[2] = trim($getData[2]);
            // Converting to lowercase
            $getData[2] = strtolower($getData[2]);
            // check if group exists in group table, if not insert it
             $group_id_query = "SELECT `id` FROM `a_group` WHERE `name` = '".$getData[2]."'";
            $group_id_result = mysqli_query($con, $group_id_query);

            if(mysqli_num_rows($group_id_result) > 0){
                $group_id_row = mysqli_fetch_assoc($group_id_result);
                $group_id = $group_id_row['id'];
            }else{
                 $group_insert_query = "INSERT INTO `a_group`(`name`) VALUES ('".$getData[2]."')";
                mysqli_query($con, $group_insert_query);
                $group_id = mysqli_insert_id($con);
            }
           
           
            $getData[3] = trim($getData[3]);
            // Converting to lowercase
            $getData[3] = strtolower($getData[3]);
            // check if group exists in group table, if not insert it
             $service_id_query = "SELECT `id` FROM `a_project_service` WHERE `name` = '".$getData[3]."'";
            $service_id_result = mysqli_query($con, $service_id_query);

            if(mysqli_num_rows($service_id_result) > 0){
                $service_id_row = mysqli_fetch_assoc($service_id_result);
                $service_id = $service_id_row['id'];
            }else{
                 $group_insert_query = "INSERT INTO `a_project_service`(`name`) VALUES ('".$getData[3]."')";
                mysqli_query($con, $group_insert_query);
                $service_id = mysqli_insert_id($con);
            }

            $date=date("Y-m-d H:i:s");
            $month=date("m");
            $year=date("Y");
            $getData[6]=(int)$getData[6];
            $getData[7]=(double)$getData[7];
            $getData[8]=(double)$getData[8];
            $getData[9]=(double)$getData[9];
            $getData[10]=$getData[10] !== '' ? (double)$getData[10] : null ;
            $getData[11]=$getData[11] !== '' ? $getData[11] : null;
            // insert project into main table
             $getData[0] = trim($getData[0]);
            // Converting to lowercase
            $getData[0] = strtolower($getData[0]);
            
            $alreadyProject="SELECT * from a_project where category_id = '".$category_id."' and name ='".$getData[0]."' and service_id='".$service_id."'";
            $alreadyProjectRes=mysqli_query($con,$alreadyProject);
            
            if(mysqli_num_rows($alreadyProjectRes) <= 0){
                
                  $sql = "INSERT INTO `a_project`(`category_id`,`service_id`, `name`, `status`, `client_amount`, `client_name`, `client_tax`, `govt_tax`, `net_amount`)
                    VALUES  ('".$category_id."','".$service_id."','".$getData[0]."','".$getData[4]."','".$getData[6]."','".$getData[5]."','".$getData[7]."','".$getData[8]."','".$getData[9]."')";
            $result = mysqli_query($con, $sql);
            
            $project_id = mysqli_insert_id($con);
            if($getData[9] !== null){
                $sql="INSERT INTO `a_receivings`(`project_id`, `mode`, `cash_amount`, `receive_at`, `month`, `year`)
                    VALUES ('".$project_id."','cash','".$getData[10]."','".$date."','".$month."','".$year."')";
             $res=mysqli_query($con,$sql);
            }
             
             
             $query="INSERT into a_project_assign(`group_id`,`Project_id`)VALUES('$group_id','$project_id')";
              $res=mysqli_query($con,$query);
              
            }
            
           

        }

        header('Location: project.php');
        exit();

        fclose($file);
    }
 }
 else{
     echo "<script>alert('Only csv file is allowed!')
     window.location.assign('project.php');
     </script>";
    
 }
    
}
?>