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
   if(isset($_POST['designationAction'])){
    //   add new designation 
       if($_POST['designationAction'] == 'add'){
          $designationDepartment= $_POST['designationDepartment'];
          $designationName= $_POST['designationName'];
   $query="INSERT INTO `designation`( `department_id`, `name`) VALUES ('$designationDepartment','$designationName')";     
   $res=mysqli_query($con,$query);
   echo 1;
       }
       // edit modal 
       if($_POST['designationAction'] == 'fetchModal'){
           $id=$_POST['id'];
           $output='';
         
           
           $query="SELECT designation.id as designationID,
           designation.name as designationName,
           designation.created_at as created_at,
           department.id as departmentId,
           department.name as departmentName
           from designation join department on designation.department_id = department.id where designation.id='$id'";
           $res=mysqli_query($con,$query);
           while($row=mysqli_fetch_assoc($res)){
               $departmentID=$row['departmentId'];
                $optionQuery="SELECT * from department where id != '$departmentID'";
          $optionRes=mysqli_query($con,$optionQuery);
           $options='<select id="editDesignationDepartment" class="form-control">';
            $options .='<option value="'.$row['departmentId'].'">'.$row['departmentName'].'</option>';
           while($optionRow=mysqli_fetch_assoc($optionRes)){
              $options .='<option value="'.$optionRow['id'].'">'.$optionRow['name'].'</option>';
           }
           $options .='</select>';
$output .='
                <form>
                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">Name:</label>
                        <input class="form-control" type="text" id="editDesignationName" value="'.$row["designationName"].'">
                        
                         <input type="hidden" id="editDesignationID" value="'.$row["designationID"].'">
                    </div>
                    <div class="form-group">
                    <label for="depart-name" class="col-form-label">Depart Name:</label>
                    '.$options.'
                    </div>

                </form>
                '; 
           };

                echo $output;
       }
       
    //   edit modal end 
      if( $_POST['designationAction'] == 'updateDesignation' ){
        $id=$_POST['id'];
        $name=$_POST['name'];
        $editDesignationDepart=$_POST['editDesignationDepart'];
        $query="UPDATE `designation` SET `name`='$name' , `department_id` = '$editDesignationDepart' WHERE id='$id'";
        $res=mysqli_query($con,$query);
        echo 1;
    }
    
   }
   
 
   
//   delete department 
if(isset($_GET['id'])){
    // include 'connection.php';
     $id=$_GET['id'];
   echo $query="DELETE FROM `designation` WHERE id='$id'";
    $res=mysqli_query($con,$query);
    header("location:project.php");
}
// end department 


  



?>