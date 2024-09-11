<?php
include 'connection.php';
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
  header('Location: index.php');
  exit; // Make sure to exit to prevent further script execution
}
$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];
if (isset($_GET['search'])) {
    $html = ' <table id="dataTableExample" class="table">
        <thead>
            <tr>
                <th>Id
                </th>
                <th>Expense Type
                </th>
                <th>
                    Amount
                </th>
                <th>
                    Office
                </th>
                <th>
                    Note
                </th>
                <th>Created At
                </th>
               
            </tr>
        </thead>
        <tbody>';
  
    $sum = 0;
  
  
  
    if ($_GET['search'] == 'searchExpenseType') {
      $id = $_GET['id'];
      if ($id == 'all') {
        $query = "SELECT * from general_expense where deleted_at is null";
      } else {
        $query = "SELECT * from general_expense where expense_type_id = '$id' and deleted_at is null";
      }
    } else if ($_GET['search'] == 'monthWise') {
      $month = $_GET['monthWise'];
      $query = "SELECT * from general_expense where created_at like '$month%' and deleted_at is null";
    } else if ($_GET['search'] == 'fromToWise') {
      $from = $_GET['from'];
      $to = $_GET['to'];
      $query = "SELECT * FROM general_expense WHERE created_at BETWEEN '$from' AND '$to' AND deleted_at IS NULL;";
    } else if ($_GET['search'] == 'officeWise') {
      $id = $_GET['officeId'];
      if ($id == 'all') {
        $query = "SELECT * from general_expense where deleted_at is null";
      } else {
        $query = "SELECT * from general_expense where office_id = '$id' and deleted_at is null";
      }
    } else if($_GET['search'] == 'mixSearch'){
      $office=$_GET['officeId'];
      $month=$_GET['month'];
      $exp=$_GET['exp'];
  
      // all 
      if(!empty($office) && !empty($month) && !empty($exp)){
        $query="SELECT * from general_expense where office_id = '$office' and created_at like '$month%' and expense_type_id = '$exp' and deleted_at is null";
      }
      // only office 
      else if(!empty($office) && empty($month) && empty($exp)){
        $query="SELECT * from general_expense where office_id = '$office' and deleted_at is null";
      }
      // office month 
      else if(!empty($office) && !empty($month) && empty($exp)){
        $query="SELECT * from general_expense where office_id = '$office' and created_at like '$month%' and deleted_at is null";
      }
      // office expense 
      else if(!empty($office) && empty($month) && !empty($exp)){
        $query="SELECT * from general_expense where office_id = '$office' and expense_type_id = '$exp' and deleted_at is null";
      }
      // month 
      else if(empty($office) && !empty($month) && empty($exp)){
        $query="SELECT * from general_expense where created_at like '$month%' and deleted_at is null";
      }
      // month expense 
      else if(empty($office) && !empty($month) && !empty($exp)){
        $query="SELECT * from general_expense where created_at like '$month%' and expense_type_id = '$exp' and deleted_at is null";
      }
      // expense 
      else if(empty($office) && empty($month) && !empty($exp)){
        $query="SELECT * from general_expense where expense_type_id = '$exp' and deleted_at is null";
      }
      // all are empty 
     else if(empty($office) && empty($month) && empty($exp)){
      $query="SELECT * from general_expense where deleted_at is null";
     }
  
  
    }
  
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
  
      while ($row = mysqli_fetch_assoc($result)) {
        $expenseTypeId = $row['expense_type_id'];
        $query1 = "SELECT * from expense_type where id =$expenseTypeId and deleted_at is null";
        $res1 = mysqli_query($con, $query1);
        $expense_name = '';
        if (mysqli_num_rows($res1) > 0) {
          $row1 = mysqli_fetch_assoc($res1);
          $expense_name = $row1['name'];
        }
        $sum += (int)$row['amount'];
  
        $officeId = $row['office_id'];
        $query2 = "SELECT * from office where id = '$officeId'";
        $res2 = mysqli_query($con, $query2);
        $Office = '';
        if (mysqli_num_rows($res2) > 0) {
          $row2 = mysqli_fetch_assoc($res2);
          $Office = $row2['location'];
        }
        $dateString =  $row['created_at'];
        $formattedDate = date("d F, Y", strtotime($dateString));
  
        $html .= '
      <tr>
        <td>' . $row["id"] . ' </td>
        <td class="text-capitalize">' . $expense_name . ' </td>
        <td class="text-capitalize">' . number_format($row["amount"]) . '</td>
        <td class="text-capitalize">' . $Office . '</td>
        <td class="text-capitalize" style="white-space: wrap;">' . $row['note'] . '</td>
        <td>' . $formattedDate . '</td>
        
      </tr>
      ';
      }
    } else {
      // $html .='No Record Found!';
    }
    $html .= ' </tbody> </table>';
    $date = date("Y-M-d");
    // $html;
    $file = "General Expense (" . $date . ").xls";
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=' . $file);
    echo $html;
    // echo $html . '!' . number_format($sum);
  }