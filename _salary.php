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
   if(isset($_POST['salaryAction'])){
    //   add new designation 
       if($_POST['salaryAction'] == 'add'){
          $salaryEmployee= $_POST['salaryEmployee'];
           $salary= $_POST['salary'];
   $query="INSERT INTO `salary`( `employee_id`,`amount`,`created_by`) VALUES ('$salaryEmployee','$salary',(SELECT id from a_admin where email='$admin_email' limit 1))";     
   $res=mysqli_query($con,$query);
   echo 1;
       }
       // edit modal 
       if($_POST['salaryAction'] == 'fetchModal'){
           $id=$_POST['id'];
           $output='';
           $query="SELECT employee.id as emp_id , employee.name as emp_name,
           salary.* from salary join employee on salary.employee_id = employee.id where salary.id='$id'";
           $res=mysqli_query($con,$query);
           while($row=mysqli_fetch_assoc($res)){
             $id=$row['emp_id'];
                $optionQuery="SELECT * from employee where id != '$id'";
          $optionRes=mysqli_query($con,$optionQuery);
           $options='<select id="editEmployeeSalary" class="form-control">';
            $options .='<option value="'.$row['emp_id'].'">'.$row['emp_name'].'</option>';
           while($optionRow=mysqli_fetch_assoc($optionRes)){
              $options .='<option value="'.$optionRow['id'].'">'.$optionRow['name'].'</option>';
           }
           $options .='</select>';
$output .='
                <form>
                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">Name:</label>
                        <input type="hidden" id="editSalaryId" value="'.$row["id"].'">
                        
                         '.$options.'
                    </div>
                    
                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">Amount:</label>
                        <input type="text" class="form-control" id="editSalary" value="'.$row["amount"].'">
                    </div>
                    
                </form>
                '; 
           };

                echo $output;
       }
       
    //   edit modal end 
      if( $_POST['salaryAction'] == 'updateSalary' ){
        $id=$_POST['id'];
        $editEmployeeSalary=$_POST['editEmployeeSalary'];
        $salary=$_POST['salary'];
         $query="UPDATE `salary` SET `employee_id`='$editEmployeeSalary', `amount`='$salary' WHERE id='$id'";
        $res=mysqli_query($con,$query);
        echo 1;
    }
    
   }
   
 
   
//   delete department 
if(isset($_GET['id'])){
    // include 'connection.php';
     $id=$_GET['id'];
    $query="DELETE FROM `salary` WHERE id='$id'";
    $res=mysqli_query($con,$query);
    header("location:project.php");
}
// end department 


  



?>