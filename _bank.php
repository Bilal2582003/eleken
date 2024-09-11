<?php
include "connection.php";
session_start();
// $session_data = $_SESSION['usersData'];
$user_name = $_SESSION['name'];
$user_id = $_SESSION['id'];
if (isset($_POST['bankAction'])) {
  //   add new designation 
  if ($_POST['bankAction'] == 'add') {
    $name = $_POST['name'];
    $branch = $_POST['branch'];
    $payment_mode = $_POST['payment_mode'];
    $head_code = $_POST['head_code'];

   
    // $property = $_POST['property'];

    $query = "INSERT INTO `bank`(`name`,`branch`,`payment_mode`,`ACC_HEAD_CODE`) VALUES ('$name','$branch','$payment_mode','$head_code')";

    $res = mysqli_query($con, $query);
    $last_id = $con->insert_id;
if($head_code > 0 && $head_code){

  $query1 = "SELECT * from chart_detail where ACC_TYPE= 10000 and ACC_DETAIL_TYPE = 10002 and CHART_HEAD_CODE = '$head_code' order by Chart_ACC_CODE desc limit 1";
  $res1 = mysqli_query($con, $query1);
  if (mysqli_num_rows($res1) > 0) {
    $row1 = mysqli_fetch_assoc($res1);
    $chart_acc_code = $row1['CHART_ACC_CODE'] + 1;
  } else {
    $chart_acc_code = 1;
  }
  $insert = "INSERT into chart_detail (CHART_HEAD_CODE, CHART_ACC_CODE, CHART_ACC_DESC, SYS_DATE, USER_ID, ACC_TYPE, ACC_DETAIL_TYPE, is_active, is_block)

                VALUES('$head_code', '$chart_acc_code', '$name', NOW(), '$user_id', '10000', '10002',  '1','0' )";

$insertRes = mysqli_query($con, $insert);

$query3 = "UPDATE bank set CHART_ACC_CODE = '$chart_acc_code' where id = $last_id ";
$res3 = mysqli_query($con, $query3);
}


    echo 1;
  }

  if ($_POST['bankAction'] == 'showTable') {
    $query = "SELECT * from bank where deleted_at IS NULL";
    $res = mysqli_query($con, $query);
    $output = '<table id="dataTableExample" class="table">
        <thead>
          <tr>
            <th class="border">Name</th>
            <th class="border">Branch</th>
            <th class="border">Created At</th>
            <th class="border">Action</th>
          </tr>
        </thead>
        <tbody id="tableBody">';
    while ($row = mysqli_fetch_assoc($res)) {
      $dateString = $row['created_at'];
      // Remove the time portion and convert to Unix timestamp
      $unixTimestamp = strtotime(substr($dateString, 0, 10));

      // Format the Unix timestamp as desired
      $formattedDate = date("d F, Y", $unixTimestamp);





      $output .= '
            <tr>
            <td class="border">' . $row['name'] . ' </td>
            <td class="border">' . $row['branch'] . ' </td>
            <td class="border">' . $formattedDate . ' </td>
            <td class="border">
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item"  data-toggle="modal" data-target="#editModal" onclick="editBank(' . $row['id'] . ')">Edit</a>
                  <a class="dropdown-item"  onclick="deleteBank(' . $row['id'] . ')">Delete</a>
                 
                </div>
              </div>
            </td>
          </tr>
            ';
    }

    $output .= '</tbody></table>';

    echo $output;
  }


  if ($_POST['bankAction'] == 'fetchModal') {
    $id = $_POST['id'];
    $output = '';

    $query = "SELECT bank.* from bank where bank.id='$id' and bank.deleted_at IS NULL";
    $res = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($res)) {


      $option = '<option value="">SELECT</option>';
      $query1 = "SELECT * from chart_head where acc_type = '10000' and acc_detail_type = '10002' and deleted_at IS NULL";
      $res1 = mysqli_query($con, $query1);
      if (mysqli_num_rows($res1) > 0) {
        while ($row1 = mysqli_fetch_assoc($res1)) {
          if ($row1['HEAD_CODE'] == $row['ACC_HEAD_CODE']) {
            $selected = 'selected';
          } else {
            $selected = '';
          }
          $option .= '<option ' . $selected . ' value="' . $row1['HEAD_CODE'] . '">' . $row1['HEAD_DESC'] . '</option>';
        }
      }

      $optionMode = '<option value="">SELECT</option>';
      $query2 = "SELECT * from payment_mode where deleted_at IS NULL";
      $res2 = mysqli_query($con, $query2);
      if (mysqli_num_rows($res2) > 0) {
        while ($row2 = mysqli_fetch_assoc($res2)) {
          if ($row2['id'] == $row['payment_mode']) {
            $selected = 'selected';
          } else {
            $selected = '';
          }
          $optionMode .= '<option ' . $selected . ' value="' . $row2['id'] . '">' . $row2['name'] . '</option>';
        }
      }

      $output .= '
            <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="houseName" class="col-form-label">Name :</label>
                <input type="text" name="editName" class="form-control" id="editname" value="' . $row['name'] . '">
                <input type="hidden" name="" class="form-control" id="editId" value="' . $row['id'] . '">
              </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="houseName" class="col-form-label">Branch :</label>
                <input type="text" name="editBranch" class="form-control" id="editBranch" value="' . $row['branch'] . '">
              </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="form-group">
            <labe class="col-form-label"l>Head Code :</label>
            <select class="form-control" id="editHeadCode">
            ' . $option . '
            </select>
            </div>
            </div>

            <div class="col-md-6">
            <div class="form-group">
            <labe class="col-form-label"l>Payment Mode :</label>
            <select class="form-control" id="editPaymentMode">
            ' . $optionMode . '
            </select>
            </div>
            </div>
            </div>
          ';
    };

    echo $output;
  }

  if ($_POST['bankAction'] == 'updateBank') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $branch = $_POST['branch'];
    $head_code = $_POST['head_code'];
    $payment_mode = $_POST['payment_mode'];
    
    // Step 1: Retrieve the existing head_code from the database
    $query_existing = "SELECT ACC_HEAD_CODE FROM `bank` WHERE id='$id'";
    $res_existing = mysqli_query($con, $query_existing);
    
    if ($res_existing && mysqli_num_rows($res_existing) > 0) {
        $row = mysqli_fetch_assoc($res_existing);
        $existing_head_code = $row['ACC_HEAD_CODE'];
    
        // Step 2: Update the bank record
        $query = "UPDATE `bank` SET `name`='$name', `branch`='$branch', payment_mode='$payment_mode', ACC_HEAD_CODE='$head_code' WHERE id='$id'";
        $res = mysqli_query($con, $query);
    
        // Step 3: Compare the existing head_code with the new head_code
        if (trim($existing_head_code) != trim($head_code)) {
            // Step 4: Check if an entry with the new head_code and bank name already exists
            $query1 = "SELECT * FROM chart_detail WHERE CHART_HEAD_CODE = '$head_code' AND CHART_ACC_DESC = '$name'";
            $res1 = mysqli_query($con, $query1);
    
            if (mysqli_num_rows($res1) > 0) {
                // If it exists, update that entry
                $row1 = mysqli_fetch_assoc($res1);
                $chart_acc_code = $row1['CHART_ACC_CODE'];
    
                $update_query = "UPDATE chart_detail SET SYS_DATE = NOW(), USER_ID = '$user_id', ACC_TYPE = '10000', ACC_DETAIL_TYPE = '10002', is_active = '1', is_block = '0' WHERE CHART_HEAD_CODE = '$head_code' AND CHART_ACC_DESC = '$name'";
                $updateRes = mysqli_query($con, $update_query);
            } else {
                // If it doesn't exist, create a new entry
                $query2 = "SELECT CHART_ACC_CODE FROM chart_detail WHERE ACC_TYPE = 10000 AND ACC_DETAIL_TYPE = 10002 AND CHART_HEAD_CODE = '$head_code' ORDER BY CHART_ACC_CODE DESC LIMIT 1";
                $res2 = mysqli_query($con, $query2);
    
                if (mysqli_num_rows($res2) > 0) {
                    $row2 = mysqli_fetch_assoc($res2);
                    $chart_acc_code = $row2['CHART_ACC_CODE'] + 1;
                } else {
                    $chart_acc_code = 1;
                }
    
                $insert = "INSERT INTO chart_detail (CHART_HEAD_CODE, CHART_ACC_CODE, CHART_ACC_DESC, SYS_DATE, USER_ID, ACC_TYPE, ACC_DETAIL_TYPE, is_active, is_block)
                           VALUES('$head_code', '$chart_acc_code', '$name', NOW(), '$user_id', '10000', '10002', '1', '0')";
                $insertRes = mysqli_query($con, $insert);
            }
    
            // Step 5: Update the bank record with the new chart_acc_code
            $query3 = "UPDATE bank SET CHART_ACC_CODE = '$chart_acc_code' WHERE id = '$id'";
            $res3 = mysqli_query($con, $query3);
        }
    }
  
    echo 1;
  }
}
if (isset($_GET['id'])) {
  // include 'connection.php';
  $id = $_GET['id'];
  $date = date("Y-m-d H:i:s");
  $query = "UPDATE `bank` SET deleted_at ='$date' WHERE id='$id'";
  $res = mysqli_query($con, $query);
  header("location:.bank.php");
}
