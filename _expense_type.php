<?php
include "connection.php";
if (isset($_POST['expenseTypeAction'])) {
    //   add new designation 
    if ($_POST['expenseTypeAction'] == 'add') {
        $name = $_POST['name'];
      
        $query = "INSERT INTO `expense_type`(`name`) VALUES ('$name')";

        $res = mysqli_query($con, $query);
        echo 1;
    }


    if ($_POST['expenseTypeAction'] == 'fetchModal') {
        $id = $_POST['id'];
        $output = '';

        $query = "SELECT * from expense_type where id = $id";
        $res = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($res)) {

            $output .= '
            <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="houseName" class="col-form-label">Name :</label>
                <input type="text" name="editName" class="form-control" id="editname" value="'.$row['name'].'">
                <input type="hidden" name="" class="form-control" id="editId" value="'.$row['id'].'">
              </div>
            </div>
           
            </div>
          ';
        };

        echo $output;
    }

    if ($_POST['expenseTypeAction'] == 'updateExpenseType') {
        $id = $_POST['id'];
        $name = $_POST['name'];

        $query = "UPDATE `expense_type` SET `name`='$name' WHERE id='$id'";
        $res = mysqli_query($con, $query);
        echo 1;
    }

}
if (isset($_GET['id'])) {
    // include 'connection.php';
    $id = $_GET['id'];
    $date=date("Y-m-d H:i:s");
     $query = "UPDATE `expense_type` SET deleted_at ='$date' WHERE id='$id'";
    $res = mysqli_query($con, $query);
    header("location:Expense_Type.php");
}
?>