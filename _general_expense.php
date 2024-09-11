<?php
include 'connection.php';
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
  header('Location: index.php');
  exit; // Make sure to exit to prevent further script execution
}
$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];
if (isset($_POST['generalExpenseAction'])) {
  //   add new designation 
  if ($_POST['generalExpenseAction'] == 'add') {
    $expenseType = $_POST['expenseType'];
    $amount = $_POST['amount'];
    $note = $_POST['note'];
    $office = $_POST['office'];
    $date = $_POST['date'];
    $expType = $_POST['expType'] ? $_POST['expType'] : null ;
    $expCheque = $_POST['expCheque'] ? $_POST['expCheque'] : null;

    $query = "INSERT INTO `general_expense`(`expense_type_id`,`office_id`,`amount`,`note`,`expense_date`,`created_by`,`type`,`cheque_no`) 
    VALUES ('$expenseType','$office','$amount','$note','$date','$admin_id','$expType','$expCheque')";

    $res = mysqli_query($con, $query);
    echo 1;
  }


  if ($_POST['generalExpenseAction'] == 'fetchModal') {
    $id = $_POST['id'];
    $output = '';

    $query = "SELECT general_expense.* , expense_type.name as expenseName , office.location as officeLocation from general_expense join expense_type on general_expense.expense_type_id = expense_type.id join office on office.id= general_expense.office_id where general_expense.id = $id";
    $res = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($res)) {
      if($row['type'] == 'cash'){
        $cash = "selected";
        $chqueStyle = "display:none";
      }else{
        $cash = '';
      }
      if($row['type']=='cheque'){
        $cheque = 'selected';
        $chqueStyle = "display:block";
      }else{
        $cheque = '';
      }

      $expenseTypeOption = $row['expense_type_id'];
      $optionQuery = "SELECT * from expense_type where id != '$expenseTypeOption'";
      $optionRes = mysqli_query($con, $optionQuery);
      $options = '<select id="editExpenseType" class="form-control">';
      $options .= '<option value="' . $row['expense_type_id'] . '">' . $row['expenseName'] . '</option>';
      while ($optionRow = mysqli_fetch_assoc($optionRes)) {
        $options .= '<option value="' . $optionRow['id'] . '">' . $optionRow['name'] . '</option>';
      }
      $options .= '</select>';

      $officeOption = $row['office_id'];
      $officeQuery = "SELECT * from office where id != '$officeOption' and deleted_at is null";
      $officeRes = mysqli_query($con, $officeQuery);
      $office = '<select id="editOffice" class="form-control">';
      $office .= '<option value="' . $row['office_id'] . '">' . $row['officeLocation'] . '</option>';
      while ($officeRow = mysqli_fetch_assoc($officeRes)) {
        $office .= '<option value="' . $officeRow['id'] . '">' . $officeRow['location'] . '</option>';
      }
      $office .= '</select>';

      $output .= '
            <div class="row">
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="houseName" class="col-form-label">Office :</label>
                ' . $office . '
             </div>
            </div>

            <div class="col-md-6">
            <div class="form-group">
              <label for="houseName" class="col-form-label">Expense Type :</label>
              ' . $options . '
              <input type="hidden" name="" class="form-control" id="editId" value="' . $row['id'] . '">
            </div>
          </div>
            
            </div>
            
             <div class="row">

             <div class="col-md-6">
             <div class="form-group">
               <label for="houseName" class="col-form-label">Amount :</label>
               <input type="text" name="" class="form-control" id="editAmount" value="' . $row['amount'] . '">
            </div>
           </div>

             <div class="col-md-6">
              <div class="form-group">
                <label for="houseName" class="col-form-label">Note :</label>
                <input type="text" name="" class="form-control" id="editNote" value="' . $row['note'] . '">
             </div>
            </div>
            </div>
            
            <div class="row">

             <div class="col-md-6">
             <div class="form-group">
               <label for="houseName" class="col-form-label">Date :</label>
               <input type="date" name="" class="form-control" id="editDate" value="' . $row['expense_date'] . '">
            </div>
           </div>
           <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Type :</label>
                                    <select class="form-control" id="editexpType">
                                        <option value="cash" '.$cash.' >Cash</option>
                                        <option value="cheque" '.$cheque.'>Cheque</option>
                                    </select>  
                                </div>
                            </div>
                            </div>

           <div class="row" id="editexpChequeDiv" style="'.$chqueStyle.'">
           <div class="col-md-12">
               <div class="form-group">
                   <label for="houseName" class="col-form-label">Cheque No :</label>
                   <input type="text" class="form-control" value="'.$row['cheque_no'].'" id="editexpCheque">
               </div>
           </div>
       </div>
            
          ';
    };

    echo $output;
  }

  if ($_POST['generalExpenseAction'] == 'updateGeneralExpense') {
    $id = $_POST['id'];
    $expenseType = $_POST['editExpenseType'];
    $amount = $_POST['editAmount'];
    $note = $_POST['editNote'];
    $office = $_POST['editOffice'];
    $date = $_POST['editDate'];
    $expType = $_POST['expType'];
    $expCheque = $_POST['expCheque'];

    $query = "UPDATE `general_expense` SET `expense_type_id`='$expenseType', `office_id`='$office', `amount`='$amount',`note`='$note',`expense_date`='$date', `type` = '$expType', `cheque_no` = '$expCheque'  WHERE id='$id'";
    $res = mysqli_query($con, $query);
    echo 1;
  }
}

if (isset($_POST['search'])) {
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
              <th>
                  Expense Date
              </th>
              <th>Created At
              </th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>';

  $sum = 0;



  if ($_POST['search'] == 'searchExpenseType') {
    $id = $_POST['id'];
    if ($id == 'all') {
      $query = "SELECT * from general_expense where deleted_at is null";
    } else {
      $query = "SELECT * from general_expense where expense_type_id = '$id' and deleted_at is null";
    }
  } else if ($_POST['search'] == 'monthWise') {
    $month = $_POST['monthWise'];
    $query = "SELECT * from general_expense where expense_date like '$month%' and deleted_at is null";
  } else if ($_POST['search'] == 'fromToWise') {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $query = "SELECT * FROM general_expense WHERE expense_date BETWEEN '$from' AND '$to' AND deleted_at IS NULL;";
  } else if ($_POST['search'] == 'officeWise') {
    $id = $_POST['officeId'];
    if ($id == 'all') {
      $query = "SELECT * from general_expense where deleted_at is null";
    } else {
      $query = "SELECT * from general_expense where office_id = '$id' and deleted_at is null";
    }
  } else if($_POST['search'] == 'mixSearch'){
    $office=$_POST['officeId'];
    $month=$_POST['month'];
    $exp=$_POST['exp'];

    // all 
    if(!empty($office) && !empty($month) && !empty($exp)){
      $query="SELECT * from general_expense where office_id = '$office' and expense_date like '$month%' and expense_type_id = '$exp' and deleted_at is null";
    }
    // only office 
    else if(!empty($office) && empty($month) && empty($exp)){
      $query="SELECT * from general_expense where office_id = '$office' and deleted_at is null";
    }
    // office month 
    else if(!empty($office) && !empty($month) && empty($exp)){
      $query="SELECT * from general_expense where office_id = '$office' and expense_date like '$month%' and deleted_at is null";
    }
    // office expense 
    else if(!empty($office) && empty($month) && !empty($exp)){
      $query="SELECT * from general_expense where office_id = '$office' and expense_type_id = '$exp' and deleted_at is null";
    }
    // month 
    else if(empty($office) && !empty($month) && empty($exp)){
      $query="SELECT * from general_expense where expense_date like '$month%' and deleted_at is null";
    }
    // month expense 
    else if(empty($office) && !empty($month) && !empty($exp)){
      $query="SELECT * from general_expense where expense_date like '$month%' and expense_type_id = '$exp' and deleted_at is null";
    }
    // expense 
    else if(empty($office) && empty($month) && !empty($exp)){
      $query="SELECT * from general_expense where expense_type_id = '$exp' and deleted_at is null";
    }
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

        $dateString =  $row['expense_date'] ? $row['expense_date'] : 0 ;
        if($dateString > 0 && $dateString != '0000-00-00'){
      $expenseDateformattedDate = date("d F, Y", strtotime($dateString));      
        }else{
            $expenseDateformattedDate = '-';
        }
      
        
      $html .= '
    <tr>
      <td>' . $row["id"] . ' </td>
      <td class="text-capitalize">' . $expense_name . ' </td>
      <td class="text-capitalize">' . number_format($row["amount"]) . '</td>
      <td class="text-capitalize">' . $Office . '</td>
      <td class="text-capitalize" style="white-space: wrap;">' . $row['note'] . '</td>
      <td class="text-capitalize">'.$expenseDateformattedDate.'</td>
      <td>' . $formattedDate . '</td>
      <td>
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Action
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" data-toggle="modal" data-target="#editModal" onclick="editGeneralExpense(' . $row['id'] . ')">Edit</a>
              <a class="dropdown-item" onclick="deleteGeneralExpense(' . $row["id"] . ')">Delete</a>

          </div>
        </div>
      </td>
    </tr>
    ';
    }
  } else {
    // $html .='No Record Found!';
  }
  $html .= ' </tbody> </table>';
  echo $html . '!' . number_format($sum);
}


if (isset($_GET['id'])) {
  // include 'connection.php';
  $id = $_GET['id'];
  $date = date("Y-m-d H:i:s");
  $query = "UPDATE `general_expense` SET deleted_at ='$date' WHERE id='$id'";
  $res = mysqli_query($con, $query);
  header("location:General_Type.php");
}
