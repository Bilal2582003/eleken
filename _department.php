<?php
   include 'connection.php';
   session_start();
   if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
       header('Location: index.php');
       exit; // Make sure to exit to prevent further script execution
   }
   
   $admin_email = $_SESSION['email'];
   $admin_id = $_SESSION['id'];
   
//   for department
   if(isset($_POST['departmentAction'])){
    //   add new depart 
       if($_POST['departmentAction'] == 'add'){
          $departName= $_POST['departName'];
   $query="INSERT INTO `department`( `name`, `created_by`) VALUES ('$departName',(SELECT id from a_admin where email='$admin_email' limit 1))";     
   $res=mysqli_query($con,$query);
   echo 1;
       }
       // edit modal 
       if($_POST['departmentAction'] == 'fetchModal'){
           $id=$_POST['id'];
           $output='';
           $query="SELECT * from department where id='$id'";
           $res=mysqli_query($con,$query);
           while($row=mysqli_fetch_assoc($res)){
              
$output .='
                <form>
                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">Name:</label>
                         <input type="text" name="departName" class="form-control" id="editDepartName" value="'.$row["name"].'">
                         <input type="hidden" id="editDepartID" value="'.$row["id"].'">
                    </div>

                </form>
                '; 
           };

                echo $output;
       }
       
    //   edit modal end 
      if( $_POST['departmentAction'] == 'updateDepart' ){
        $id=$_POST['id'];
        $name=$_POST['name'];
        $query="UPDATE `department` SET `name`='$name' WHERE id='$id'";
        $res=mysqli_query($con,$query);
        header("location:project.php");
    }
    
   }
   
 
   
//   delete department 
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $query="DELETE FROM `department` WHERE id='$id'";
    $res=mysqli_query($con,$query);
    header("location:project.php");
}
// end department 


  



?>