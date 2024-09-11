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
   if(isset($_POST['taskAction'])){
    //   add new designation 
       if($_POST['taskAction'] == 'add'){
          $titleTask= $_POST['titleTask'];
          $deadlineTask= $_POST['deadlineTask'];
           $taskEmployeeOption= $_POST['taskEmployeeOption'];
           
           $date=explode("T",$deadlineTask);
           $date=$date[0].' '.$date[1];
           
   $query="INSERT INTO `task`( `title`, `created_by`, `assign_to_employee`, `deadline`) VALUES ('$titleTask',(SELECT id from a_admin where email='$admin_email' limit 1),'$taskEmployeeOption','$date')";     
  $res=mysqli_query($con,$query);
  echo 1;
       }
       // edit modal 
       if($_POST['taskAction'] == 'fetchModal'){
           $id=$_POST['id'];
           $output='';
           $query="SELECT employee.id as emp_id , employee.name as emp_name,
           task.* from task join employee on task.assign_to_employee = employee.id where task.id='$id'";
           $res=mysqli_query($con,$query);
           while($row=mysqli_fetch_assoc($res)){
             $id=$row['emp_id'];
                $optionQuery="SELECT * from employee where id != '$id'";
          $optionRes=mysqli_query($con,$optionQuery);
           $options='<select id="editEmployeeTask" class="form-control">';
            $options .='<option value="'.$row['emp_id'].'">'.$row['emp_name'].'</option>';
           while($optionRow=mysqli_fetch_assoc($optionRes)){
              $options .='<option value="'.$optionRow['id'].'">'.$optionRow['name'].'</option>';
           }
           $options .='</select>';
            $date=$row["deadline"];
           $date=explode(" ",$date);
            $date=$date[0].'T'.$date[1];
            $button='';
            if($row['is_active']==0 && $row['is_completed'] == 0){
                $button='<button type="button" id="editTaskbtn" class="btn btn-secondary">Active</button>';
            }else{
                 $button='<button type="button" id="editTaskbtn" class="btn btn-secondary" data-dismiss="modal">Completed</button>';
            }
            
$output .='
                <form>
                
                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">Name:</label>
                        <input type="hidden" id="editTaskId" value="'.$row["id"].'">
                        
                         '.$options.'
                    </div>
                    
                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">Title:</label>
                        <input type="text" class="form-control" id="editTitleTask" value="'.$row["title"].'">
                    </div>
                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">DeadLine:</label>
                        <input type="datetime-local" class="form-control" id="editDeadLineTask" value="'.$date.'">
                    </div>
                    
                </form>
                '.$button.'
                '; 
           };

                echo $output;
       }
       
    //   edit modal end 
      if( $_POST['taskAction'] == 'updateTask' ){
        $id=$_POST['id'];
        $editTitleTask=$_POST['editTitleTask'];
        $editEmployeeTask=$_POST['editEmployeeTask'];
        $editDeadLineTask=$_POST['editDeadLineTask'];
       
         $query="UPDATE `task` SET `title`='$editTitleTask', `assign_to_employee`='$editEmployeeTask',`deadline`='$editDeadLineTask' WHERE id='$id'";
        $res=mysqli_query($con,$query);
        echo 1;
    }
    
    if( $_POST['taskAction'] == 'Active' ){
        $id=$_POST['id'];
         $query="UPDATE `task` SET `is_active`='1' WHERE id='$id'";
        $res=mysqli_query($con,$query);
        echo 1;
    }
     if( $_POST['taskAction'] == 'Completed' ){
        $id=$_POST['id'];
         $query="UPDATE `task` SET `is_completed`='1' WHERE id='$id'";
        $res=mysqli_query($con,$query);
        echo 1;
    }
    
   }
   
 
   
//   delete department 
if(isset($_GET['id'])){
    // include 'connection.php';
     $id=$_GET['id'];
    $query="DELETE FROM `task` WHERE id='$id'";
    $res=mysqli_query($con,$query);
    header("location:project.php");
}
// end department 


  



?>