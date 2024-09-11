<?php
include 'connection.php';
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: index.php');
    exit; // Make sure to exit to prevent further script execution
}

$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $rp_name = $_POST['rp_name'];
        $mode = $_POST['mode'];
        $bank = $_POST['bank'] == '' ? '' : $_POST['bank'];
        $cash = (string)$_POST['cash'];
        $cash = str_replace(',', '', $cash);
        $cash = (int)$cash;
        // $client_tax = $_POST['client_tax'];
        // $govt_tax = $_POST['govt_tax'];
        $client_tax_afterDeductTaxAmount = $_POST['client_tax'];
        $govt_tax_afterDeductTaxAmount = $_POST['govt_tax'];
        $held_tax_afterDeductTaxAmount = $_POST['held_tax'] !== '' ? $_POST['held_tax'] : 0 ;

        $getData = "SELECT * from a_project where id= '$rp_name'";
        $resData = mysqli_query($con, $getData);
        $rowdata = mysqli_fetch_assoc($resData);
        $client_amountget= $rowdata['client_amount'];
        $net_amount=( ((int)$cash + (float)$client_tax_afterDeductTaxAmount ) - (float)$govt_tax_afterDeductTaxAmount) - $held_tax_afterDeductTaxAmount;
        //   if ($govt_tax == 'yes') {
        //         if (!empty($rowdata['govt_tax']) && $rowdata['govt_tax'] > 0) {
        //             $govt_tax_in_percentage = round(($rowdata['govt_tax'] / $rowdata['client_amount']) * 100, 1);

        //             $govt_tax_afterDeductTaxAmount =    round(($cash * $govt_tax_in_percentage) / 100, 1);
        //         }
        //         $cash = $cash - $govt_tax_afterDeductTaxAmount;
        //     }
            
        // if ($client_tax == 'yes') {
        //     // $client_tax = $_POST['client_tax'];
        //     if (!empty($rowdata['client_tax']) && $rowdata['client_tax'] > 0) {
        //         $client_tax_in_percentage = round(($rowdata['client_tax'] / $rowdata['client_amount']) * 100, 1);

        //         $client_tax_afterDeductTaxAmount =    round(($cash * $client_tax_in_percentage) / 100, 1);
        //     }
        //     $cash = $cash - $client_tax_afterDeductTaxAmount;
        // }
          



        $cheque = $_POST['cheque'] == '' ? '' : $_POST['cheque'];
        $deposit_branch = $_POST['deposit_branch'] == '' ? '' : $_POST['deposit_branch'];
        $deposit_bank = $_POST['deposit_bank'] == '' ? '' : $_POST['deposit_bank'];
        $column = ($_POST['mode'] == 'cash' ? 'cash_amount' : 'amount');
        $receiving_at = $_POST['receiving_at'] == '' ? '' : $_POST['receiving_at'];

        $month = date("m");
        $year = date("Y");


$testingAmountQuery="SELECT sum(cash_amount) as cash_amount,sum(amount) as amount,sum(client_tax) as client_tax, sum(govt_tax) as govt_tax from a_receivings where project_id = '$rp_name'";
$restestingAmount=mysqli_query($con,$testingAmountQuery);
$totalReceivedAmount = 0;
while($rowtestingAmount = mysqli_fetch_assoc($restestingAmount)){
    $totalReceivedAmount +=$rowtestingAmount['cash_amount'] + $rowtestingAmount['amount'] + $rowtestingAmount['client_tax'] + $rowtestingAmount['govt_tax'];
}

// calculation of all amount for testing total amount 
$totalReceivedAmount +=$cash +$client_tax_afterDeductTaxAmount + $govt_tax_afterDeductTaxAmount;

if($client_amountget >= $totalReceivedAmount ){    

           $sql = "INSERT INTO `a_receivings`(`project_id`, `mode`, `bank_name`, `cheque_no`,`deposited_bank_name`,`deposited_bank_branch`,`$column`,`client_tax`,`govt_tax`,`client_tax_held`,`net_amount`,`receive_at`,`month`,`year`) 
    VALUES('$rp_name','$mode','$bank','$cheque','$deposit_bank','$deposit_branch','$cash','$client_tax_afterDeductTaxAmount','$govt_tax_afterDeductTaxAmount','$held_tax_afterDeductTaxAmount','$net_amount','$receiving_at','$month','$year')";
        $res = mysqli_query($con, $sql);
        $id = mysqli_insert_id($con);
        if ($res) {
            $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Add Receving Project $rp_name')
            ";
            $res = mysqli_query($con, $admin_log);
            echo 1;
        } else {
            echo 0;
        }
    }else{
        echo 2;
    }
    }


    if ($_POST['action'] == 'fetchModal') {

        $id = $_POST['id'];
        $query = "SELECT * from a_receivings where id='$id'";
        $res = mysqli_query($con, $query);
        $output = '';
        while ($row = mysqli_fetch_assoc($res)) {
            $project_id = $row['project_id'];
            $queryPro = "SELECT * from a_project where id = $project_id";
            $resPro = mysqli_query($con, $queryPro);
            $rowPro = mysqli_fetch_assoc($resPro);
            $selectProject = '<select id="editProject" class="form-control">
           <option  class="text-capitalize" value="' . $rowPro['id'] . '">' . $rowPro['name'] . '</option>
           ';

            $queryPro = "SELECT * from a_project where id != $project_id";
            $resPro = mysqli_query($con, $queryPro);
            if (mysqli_num_rows($resPro) > 0) {
                while ($rowPro = mysqli_fetch_assoc($resPro)) {
                    $selectProject .= '
                <option  class="text-capitalize" value="' . $rowPro['id'] . '">' . $rowPro['name'] . '</option>
                ';
                }
            }
            $selectProject .= '</select>';

            $amount = ($row['mode'] == 'cash') ? $row['cash_amount'] : $row['amount'];
            $amount += $row['client_tax'] + $row['govt_tax'];

            $dateString = $row['created_at'];
            // Remove the time portion and convert to Unix timestamp
            $unixTimestamp = strtotime(substr($dateString, 0, 10));

            // Format the Unix timestamp as desired
            $formattedDate = date("d F, Y", $unixTimestamp);



            $output .= '
            <div class="form-row">
    <div class="col-md-6 form-group">
        <label for="depart-name" class="col-form-label">Receiving ID:</label>
        <input class="form-control" type="text" disabled id="editReceivingId" value="' . $row["id"] . '">
    </div>
    <div class="col-md-6 form-group">
        <label for="depart-name" class="col-form-label">Project:</label>
        ' . $selectProject . '
    </div>
    </div>
            <div class="form-row">
    <div class="col-md-6 form-group">
        <label for="depart-name" class="col-form-label">Amount:</label>
        <input class="form-control" type="text" id="editReceivingAmount" value="' . $amount . '">
    </div>
    <div class="col-md-6 form-group">
        <label for="depart-name" class="col-form-label">Created At:</label>
        <input class="form-control" type="text"  value="' . $formattedDate . '" disabled>
    </div>
    </div>

    <div class="form-row">
    
    <div class="form-group" id="tax" >
    <label>SST/PRA/ICT</label><br>
        <label>
            <input type="radio" class="editclient" name="client" value="yes">
            Yes
        </label>
        
        <label>
            <input type="radio" class="editclient" name="client" value="no">
            No
        </label>

        <br><br>
        <label>IT</label><br>
        <label>
            <input type="radio" class="editgovt" name="govt" value="yes">
            Yes
        </label>
        
        <label>
            <input type="radio" class="editgovt" name="govt" value="no">
            No
        </label>
    </div>
    </div>


            ';
        }

        echo $output;
    }

    if ($_POST['action'] == 'updatedReceiving') {

        $id = $_POST['id'];
        $project_id = $_POST['project'];
        $cash = $_POST['amount'];
        $client_tax = $_POST['client_tax'];
        $govt_tax = $_POST['govt_tax'];

        $receivingQuery = "SELECT * from a_receivings where id = '$id'";
        $resReceiving = mysqli_query($con, $receivingQuery);

        $row = mysqli_fetch_assoc($resReceiving);
        $mode = $row['mode'];

        $client_tax_afterDeductTaxAmount = 0;
        $govt_tax_afterDeductTaxAmount = 0;

        $getData = "SELECT * from a_project where id= '$project_id'";
        $resData = mysqli_query($con, $getData);
        $rowdata = mysqli_fetch_assoc($resData);
        $client_amountget= $rowdata['client_amount'];
         if ($govt_tax == 'yes') {
                if (!empty($rowdata['govt_tax']) && $rowdata['govt_tax'] > 0) {
                    $govt_tax_in_percentage = round(($rowdata['govt_tax'] / $rowdata['client_amount']) * 100, 1);

                    $govt_tax_afterDeductTaxAmount =    round(($cash * $govt_tax_in_percentage) / 100, 1);
                }
                $cash = $cash - $govt_tax_afterDeductTaxAmount;
            }
        if ($client_tax == 'yes') {
            // $client_tax = $_POST['client_tax'];
            if (!empty($rowdata['client_tax']) && $rowdata['client_tax'] > 0) {
                $client_tax_in_percentage = round(($rowdata['client_tax'] / $rowdata['client_amount']) * 100, 1);

                $client_tax_afterDeductTaxAmount =    round(($cash * $client_tax_in_percentage) / 100, 1);
            }
            $cash = $cash - $client_tax_afterDeductTaxAmount;
        }
           
        $testingAmountQuery="SELECT sum(cash_amount) as cash_amount,sum(amount) as amount,sum(client_tax) as client_tax, sum(govt_tax) as govt_tax from a_receivings where project_id = '$project_id' and a_receivings.id != '$id'";
        $restestingAmount=mysqli_query($con,$testingAmountQuery);
        $totalReceivedAmount = 0;
        while($rowtestingAmount = mysqli_fetch_assoc($restestingAmount)){
            $totalReceivedAmount +=$rowtestingAmount['cash_amount'] + $rowtestingAmount['amount'] + $rowtestingAmount['client_tax'] + $rowtestingAmount['govt_tax'];
        }
        
        // calculation of all amount for testing total amount 
        $totalReceivedAmount +=$cash +$client_tax_afterDeductTaxAmount + $govt_tax_afterDeductTaxAmount;
        
        if($client_amountget > $totalReceivedAmount ){   
        if ($mode == 'cash') {
            $query = "UPDATE `a_receivings` SET `project_id`='$project_id',`cash_amount`='$cash',`client_tax`='$client_tax_afterDeductTaxAmount',`govt_tax`='$govt_tax_afterDeductTaxAmount' where id = '$id'";
        } else {
            $query = "UPDATE `a_receivings` SET `project_id`='$project_id',`amount`='$cash',`client_tax`='$client_tax_afterDeductTaxAmount',`govt_tax`='$govt_tax_afterDeductTaxAmount'  where id = '$id'";
        }
        $res = mysqli_query($con, $query);
        if ($res) {
            $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Edit Receving $id Project $project_id')
            ";
            $res = mysqli_query($con, $admin_log);
            echo 1;
        } else {
            echo 0;
        }
    }
    else{
        echo 2;
    }
    }
}

if (isset($_GET['id'])) {
    // include 'connection.php';
    $id = $_GET['id'];
    $query = "DELETE FROM `a_receivings` WHERE id='$id'";
    $res = mysqli_query($con, $query);
    header("location:Receiving.php");
}
?>
