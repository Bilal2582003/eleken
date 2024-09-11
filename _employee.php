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
   if(isset($_POST['employeeAction'])){
    //   add new designation 
       if($_POST['employeeAction'] == 'add'){
           $name=$_POST['name'];
          $empDesignation= $_POST['empDesignation'];
          $email= $_POST['email'];
          $phone= $_POST['phone'];
          $password= $_POST['password'];
          $empShift=$_POST['empShift'];
    $query="INSERT INTO `employee`( `designation_id`, `name`, `email`, `phone`, `password`, `created_by`,`shift_id`) VALUES ('$empDesignation','$name','$email','$phone','$password',(SELECT id from a_admin where email='$admin_email' limit 1),'$empShift')";     
  $res=mysqli_query($con,$query);
  echo 1;
       }
       // edit modal 
       if($_POST['employeeAction'] == 'fetchModal'){
           $id=$_POST['id'];
           $output='';
         
            $query="SELECT employee.id as emp_id,
                            employee.name as emp_name,
                            employee.email as emp_email,
                            employee.phone as emp_phone,
                            employee.password as emp_password,
                            employee.stars as emp_stars,
                            employee.fine as emp_fine,
                            employee.created_at as created_at,
                            employee.shift_id as shift_id,
                            designation.id as designation_id,
                            designation.name as designation_name,
                            department.id as depart_id,
                            department.name as depart_name,
                            shift.shift_start as shift_start,
                            shift.shift_end as shift_end
                            FROM employee join designation on employee.designation_id = designation.id join department on department.id = designation.department_id join shift on employee.shift_id = shift.id where employee.id='$id'";
           $res=mysqli_query($con,$query);
           while($row=mysqli_fetch_assoc($res)){
                 $designationID=$row['designation_id'];
                $optionQuery="SELECT * from designation where id != '$designationID'";
          $optionRes=mysqli_query($con,$optionQuery);
           $options='<select id="editEmployeeDesignation" class="form-control">';
            $options .='<option value="'.$row['designation_id'].'">'.$row['designation_name'].'</option>';
           while($optionRow=mysqli_fetch_assoc($optionRes)){
              $options .='<option value="'.$optionRow['id'].'">'.$optionRow['name'].'</option>';
           }
           $options .='</select>';
           
        //   shift
        $optionsShift='';
          $shift=$row['shift_id'];
                $optionQuery="SELECT * from shift where id != '$shift'";
          $optionRes=mysqli_query($con,$optionQuery);
           $optionsShift='<select id="editEmployeeShift" class="form-control">';
            $optionsShift .='<option selected value="'.$row['shift_id'].'">'.$row['shift_start'].' to '.$row['shift_end'].'</option>';
           while($optionRow=mysqli_fetch_assoc($optionRes)){
              $optionsShift .='<option value="'.$optionRow['id'].'">'.$optionRow['shift_start'].' to '.$optionRow['shift_end'].'</option>';
           }
           $optionsShift .='</select>';
           
$output .='
                <form>
                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">Name:</label>
                        <input class="form-control" type="text" id="editEmployeeName" value="'.$row["emp_name"].'">
                        
                         <input type="hidden" id="editEmployeeID" value="'.$row["emp_id"].'">
                    </div>
                    <div class="form-group">
                    <label for="depart-name" class="col-form-label">Depart Name:</label>
                    '.$options.'
                    </div>
                     <div class="form-group">
                    <label for="depart-name" class="col-form-label">Shif :</label>
                    '.$optionsShift.'
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Email:</label>
                         <input type="text" value="'.$row["emp_email"].'" name="editEmployeeEmail" class="form-control" id="editEmployeeEmail">
                    </div>
                     <div class="form-group">
                        <label for="name" class="col-form-label">Phone:</label>
                         <input type="text" value="'.$row["emp_phone"].'" name="editEmployeeEmail" class="form-control" id="editEmployeePhone">
                    </div>
                     <div class="form-group">
                        <label for="name" class="col-form-label">Password:</label>
                         <input type="text" value="'.$row["emp_password"].'" name="editEmployeeEmail" class="form-control" id="editEmployeePassword">
                    </div>

                </form>
                '; 
           };

                echo $output;
       }
       
    //   edit modal end 
      if( $_POST['employeeAction'] == 'updateEmployee' ){
        $id=$_POST['id'];
        $name=$_POST['name'];
        $editEmployeeEmail=$_POST['editEmployeeEmail'];
        $editEmployeePhone=$_POST['editEmployeePhone'];
        $editEmployeePassword=$_POST['editEmployeePassword'];
        $editEmployeeDesignation=$_POST['editEmployeeDesignation'];
        $editEmployeeShift=$_POST['editEmployeeShift'];
        $query="UPDATE `employee` SET `designation_id`='$editEmployeeDesignation',`name`='$name',`email`='$editEmployeeEmail',`phone`='$editEmployeePhone',`password`='$editEmployeePassword',`shift_id` = '$editEmployeeShift'  WHERE id='$id'";
        $res=mysqli_query($con,$query);
        echo 1;
    }
    
   }
   
 
   
//   delete department 
if(isset($_GET['id'])){
    // include 'connection.php';
     $id=$_GET['id'];
   echo $query="DELETE FROM `employee` WHERE id='$id'";
    $res=mysqli_query($con,$query);
    header("location:project.php");
}
// end department 


  



?>