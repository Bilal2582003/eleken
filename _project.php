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
if (isset($_POST['projectAction'])) {

    // edit modal 
    if ($_POST['projectAction'] == 'fetchModal') {
        $id = $_POST['id'];
        $output = '';

        $query = "SELECT a_project.category_id as category_id,
            a_project.id as id,
            a_project.name as project_name,
            a_project.client_name as client_name,
            a_project.client_amount as client_amount,
            a_project.client_tax as client_tax,
            a_project.govt_tax as govt_tax ,
            a_project.client_tax_held as client_held,
            a_project.created_at as created_at,
            a_project.engineer_id as engineer_id,
            a_project.project_stage_id as stage_id,
            a_project.service_id as service_id,
            a_project_service.name as service_name,
            a_project.head_code as HEAD_CODE,
            a_project.chart_acc_code as CHART_ACC_CODE,
            a_project_category.name as category_name from a_project join a_project_category on a_project.category_id = a_project_category.id join a_project_service on a_project.service_id = a_project_service.id where a_project.id='$id'";
        $res = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($res)) {
            $categoryID = $row['category_id'];
            $optionQuery = "SELECT * from a_project_category where id != '$categoryID'";
            $optionRes = mysqli_query($con, $optionQuery);
            $options = '<select id="editProjectCategory" class="form-control">';
            $options .= '<option style="text-transform: capitalize;" value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
            while ($optionRow = mysqli_fetch_assoc($optionRes)) {
                $options .= '<option style="text-transform: capitalize;" value="' . $optionRow['id'] . '">' . $optionRow['name'] . '</option>';
            }
            $options .= '</select>';


            $serviceId = $row['service_id'];
            $optionQuery = "SELECT * from a_project_service where id != '$serviceId'";
            $optionRes = mysqli_query($con, $optionQuery);
            $service = '<select id="editProjectService" class="form-control">';
            $service .= '<option style="text-transform: capitalize;" value="' . $row['service_id'] . '">' . $row['service_name'] . '</option>';
            while ($optionRow = mysqli_fetch_assoc($optionRes)) {
                $service .= '<option style="text-transform: capitalize;" value="' . $optionRow['id'] . '">' . $optionRow['name'] . '</option>';
            }
            $service .= '</select>';



            $projectID = $row['id'];
            $groupQuery = "SELECT a_project_assign.id as id , 
           a_group.id as groupId,
           a_group.name as group_name
           from a_project_assign join a_group on a_project_assign.group_id = a_group.id where a_project_assign.project_id='$projectID'";
            $groupQueryRes = mysqli_query($con, $groupQuery);
            $rowGroup = mysqli_fetch_assoc($groupQueryRes);

            $groupOption = '<select class="form-control" id="editProjectGroup"> <option selected value="' . $rowGroup["groupId"] . '">' . $rowGroup["group_name"] . '</option>';
            $groupID = $rowGroup['groupId'];
            $groupQuery = "Select * from a_group where id != '$groupID'";
            $resGroup = mysqli_query($con, $groupQuery);
            while ($rowGroup = mysqli_fetch_assoc($resGroup)) {
                $groupOption .= '<option style="text-transform: capitalize;" value="' . $rowGroup["id"] . '">' . $rowGroup["name"] . '</option>';
            }
            $groupOption .= "</select>";

            //    engineer 
            $engineer_id = $row['engineer_id'];
            $engineer_query = "Select * from engineer where id = '$engineer_id'";
            $resEng = mysqli_query($con, $engineer_query);
            if (mysqli_num_rows($resEng) > 0) {

                $rowEng = mysqli_fetch_assoc($resEng);
                $engineer_name = $rowEng['name'];

                $engineerSelect = '<select class="form-control" id="editProjectEngineer"> <option style="text-transform: capitalize;" selected value="' . $row["engineer_id"] . '">' . $engineer_name . '</option>';

                $engineerQuery = "Select * from engineer where id != '$engineer_id'";
                $resengineer = mysqli_query($con, $engineerQuery);
                while ($rowengineer = mysqli_fetch_assoc($resengineer)) {
                    $engineerSelect .= '<option style="text-transform: capitalize;" value="' . $rowengineer["id"] . '">' . $rowengineer["name"] . '</option>';
                }
                $engineerSelect .= "</select>";
            } else {

                $engineerSelect = '<select class="form-control" id="editProjectEngineer"> <option selected value="">Select</option>';
                $engineerQuery = "Select * from engineer";
                $resengineer = mysqli_query($con, $engineerQuery);
                while ($rowengineer = mysqli_fetch_assoc($resengineer)) {
                    $engineerSelect .= '<option style="text-transform: capitalize;" value="' . $rowengineer["id"] . '">' . $rowengineer["name"] . '</option>';
                }
                $engineerSelect .= "</select>";
            }

            // stage 
            $stage_id = $row['stage_id'];
            $engineer_query = "Select * from project_stages where id = '$stage_id'";
            $resStage = mysqli_query($con, $engineer_query);
            if (mysqli_num_rows($resStage) > 0) {

                $rowStage = mysqli_fetch_assoc($resStage);
                $stage_title = $rowStage['title'] . " (" . $rowStage['percentage'] . ")";

                $StageSelect = '<select class="form-control" id="editProjectStage"> <option style="text-transform: capitalize;" selected value="' . $row["stage_id"] . '">' . $stage_title . '</option>';

                $StageQuery = "Select * from project_stages where id != '$stage_id'";
                $resStage = mysqli_query($con, $StageQuery);
                while ($rowStage = mysqli_fetch_assoc($resStage)) {
                    $StageSelect .= '<option style="text-transform: capitalize;" value="' . $rowStage["id"] . '">' . $rowStage["title"] . '(' . $rowStage["percentage"] . ')</option>';
                }
                $StageSelect .= "</select>";
            } else {

                $StageSelect = '<select class="form-control" id="editProjectStage"> <option selected value="">Select</option>';
                $StageQuery = "Select * from engineer";
                $resStage = mysqli_query($con, $StageQuery);
                while ($rowStage = mysqli_fetch_assoc($resStage)) {
                    $StageSelect .= '<option style="text-transform: capitalize;" value="' . $rowStage["id"] . '">' . $rowStage["title"] . '(' . $rowStage["percentage"] . ')</option>';
                }
                $StageSelect .= "</select>";
            }

            $HEAD_CODE = $row['HEAD_CODE'];

            $query2 = "SELECT * from chart_head where ACC_DETAIL_TYPE = '40004' and deleted_at IS NULL ";
            $res2 = mysqli_query($con, $query2);
            $optionsHead = '<option value="">SELECT</option>';
            if (mysqli_num_rows($res2) > 0) {
                while ($HEADRow = mysqli_fetch_assoc($res2)) {
                    if (trim($HEADRow['HEAD_CODE']) == trim($HEAD_CODE)) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    $optionsHead .= '<option ' . $selected . ' value="' . $HEADRow['HEAD_CODE'] . '">' . $HEADRow['HEAD_DESC'] . '</option>';
                }
            }
            $HEAD_CODE = $row['CHART_ACC_CODE'];

            $query2 = "SELECT * from chart_detail where ACC_DETAIL_TYPE = '40004' and deleted_at IS NULL ";
            $res2 = mysqli_query($con, $query2);
            $optionsHeadDetail = '<option value="">SELECT</option>';
            if (mysqli_num_rows($res2) > 0) {
                while ($HEADRow = mysqli_fetch_assoc($res2)) {
                    if (trim($HEADRow['CHART_ACC_CODE']) == trim($HEAD_CODE)) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    $optionsHeadDetail .= '<option ' . $selected . ' value="' . $HEADRow['CHART_ACC_CODE'] . '">' . $HEADRow['CHART_ACC_DESC'] . '</option>';
                }
            }



            $output .= '
<form>
<div class="form-row">
    <div class="col-md-6 form-group">
        <label for="depart-name" class="col-form-label">Project Name:</label>
        <input style="text-transform: capitalize;" class="form-control" type="text" id="editProjectName" value="' . $row["project_name"] . '">
        <input  type="hidden" id="editProjectID" value="' . $row["id"] . '">
    </div>
    <div class="col-md-6 form-group">
        <label for="depart-name" class="col-form-label">Category Name:</label>
        ' . $options . '
    </div>
</div>
<div class="form-row">
    <div class="col-md-6 form-group">
        <label for="name" class="col-form-label">Client Name:</label>
        <input type="text" style="text-transform: capitalize;" value="' . $row["client_name"] . '" name="edit_client_name" class="form-control" id="edit_client_name">
    </div>
    <div class="col-md-6 form-group">
        <label for="name" class="col-form-label">Client Amount:</label>
        <input type="text" value="' . $row["client_amount"] . '" name="edit_client_amount" class="form-control" id="edit_client_amount">
    </div>
</div>
<div class="form-row">
    <div class="col-md-3 form-group">
        <label for="client-tax" class="col-form-label">Client Tax:</label>
        <select class="form-control" name="status" id="edit_client_tax">
            <option selected disabled>Select</option>
            <option value="13">13%</option>
            <option value="7">7%</option>
            <option value="3">3%</option>
        </select>
    </div>
    <div class="col-md-3 form-group" id="edit_client_tax_amount_div">
    <label for="client-tax" class="col-form-label">Amount:</label>
        <input class="form-control" disabled type="text" value="' . $row["client_tax"] . '" id="edit_client_tax_amount">
    </div>

    <div class="col-md-3 form-group">
    <label for="client-tax-held" class="col-form-label">Client Tax Held:</label>
    <select class="form-control" name="status" id="edit_client_tax_held">
        <option selected disabled>Select</option>
        <option value="10">10%</option>
        <option value="20">20%</option>
        <option value="30">30%</option>
    </select>
    </div>
    <div class="col-md-3 form-group" id="edit_client_tax_held_amount_div">
    <label for="client-tax" class="col-form-label">Amount:</label>
    <input class="form-control" disabled type="text" value="' . $row["client_held"] . '" id="edit_client_tax_held_amount">
    </div>
</div>

<div class="form-row">
    <div class="col-md-3 form-group" id="edit_govt_tax_main_div">
        <label for="govt-tax" class="col-form-label">Govt Tax:</label>
        <select class="form-control" name="status" id="edit_govt_tax">
            <option selected disabled>Select</option>
            <option value="10">10%</option>
            <option value="7">7%</option>
            <option value="3">3%</option>
        </select>
    </div>
    <div class="col-md-3 form-group" id="edit_govt_tax_amount_div">
    <label for="client-tax" class="col-form-label">Amount:</label>
        <input class="form-control" disabled type="text"  value="' . $row["govt_tax"] . '" id="edit_govt_tax_amount">
    </div>

    <div class="col-md-6 form-group">
    <label for="client-tax" class="col-form-label">Group:</label>
    ' . $groupOption . '
    </div>
</div>
<div class="form-row">
    <div class="col-md-6 form-group">
        <label for="name" class="col-form-label">Engineer Name:</label>
        ' . $engineerSelect . '
    </div>
    <div class="col-md-6 form-group">
        <label for="name" class="col-form-label">Stage</label>
       ' . $StageSelect . '
    </div>
</div>
<div class="form-row">
    <div class="col-md-6 form-group">
        <label for="name" class="col-form-label">Service Name:</label>
        ' . $service . '
    </div>

    
    <div class="col-md-6 form-group">
    <label for="houseName" class="col-form-label">HEAD CODE:</label>
    <select id="editchart_head_code" class="form-control chart_head_codeClass">
      ' . $optionsHead . '
      </select>
      </div>
</div>

<div class="form-row">
      <div class="col-md-6 form-group">
      <label for="houseName" class="col-form-label">Chart DETAIL :</label>
      <select id="editchart_detail_code" class="form-control chart_detail_codeClass">
        ' . $optionsHeadDetail . '
        </select>
        </div>
        </div>
    
</div>

</form>

                ';
        };

        echo $output;
    }

    if ($_POST['projectAction'] == 'getChartHead') {
        $head_code = mysqli_real_escape_string($con, $_POST['chart_head_code']);
        $query = "SELECT * FROM chart_detail WHERE chart_head_code = '$head_code'";
        $res = mysqli_query($con, $query);
        $output = '';
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '<option value="' . $row['CHART_ACC_CODE'] . '">' . $row['CHART_ACC_DESC'] . '</option>';
            }
        } else {
            $output .= '<option value="">No details found</option>';
        }
        echo $output;
    }
    //   edit modal end 
    if ($_POST['projectAction'] == 'updateProject') {
        $id = $_POST['editProjectID'];
        $name = $_POST['editProjectName'];
        $cat = $_POST['editProjectCategory'];
        $project_groupAssign = $_POST['editProjectGroup'];
        $client_name = $_POST['edit_client_name'];
        $client_amount = $_POST['edit_client_amount'];
        $client_tax = $_POST['client_tax'];
        $govt_tax = $_POST['govt_tax'];
        $editProjectService = $_POST['editProjectService'];
        $editProjectStage = $_POST['editProjectStage'] != '' ? $_POST['editProjectStage'] : '';
        $held = $_POST['held'] !== '' ? $_POST['held'] : 'null';
        $engineer = $_POST['engineer'] !== '' ? $_POST['engineer'] : null;
        $net_amount = ((int)$client_amount + (float)$client_tax) - (float)$govt_tax;
        $chart_head_code = $_POST['chart_head_code'];
        $chart_detail_code = $_POST['chart_detail_code'];

        $group_id = '';
        $getGroup = "SELECT * from a_projecT_assign where project_id='$id'";
        $res = mysqli_query($con, $getGroup);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $group_id = $row['group_id'];
        }


        $maintainHistory = "INSERT INTO `project_history` (
            `project_id`, `category_id`,`service_id`, `project_name`, `status`, `remarks`, 
            `engineer_id`, `project_stage`, `client_amount`, `client_name`, `client_tax`, 
            `govt_tax`, `client_tax_held`, `net_amount`, `is_periodic`, `group_id`, 
            `new_category_id`,`new_service_id`, `new_project_name`, `new_engineer_id`,`new_project_stage_id`, `new_client_amount`, 
            `new_client_name`, `new_client_tax`, `new_govt_tax`, `new_client_tax_held`, 
            `new_net_amount`, `new_group_id`
        )
        SELECT `id`, `category_id`,`service_id`, `name`, `status`, `remarks`, 
            `engineer_id`, `project_stage_id`, `client_amount`, `client_name`, `client_tax`, 
            `govt_tax`, `client_tax_held`, `net_amount`, `is_periodic`, '$group_id', 
            '$cat','$editProjectService', '$name', '$engineer','$editProjectStage' ,'$client_amount', '$client_name', '$client_tax', 
            '$govt_tax', '$held', '$net_amount', '$project_groupAssign'
        FROM `a_project`
        WHERE `id` = '$id'";
        $res = mysqli_query($con, $maintainHistory);

        $getadmin = "SELECT id from a_admin where email='$admin_email'";
        $res = mysqli_query($con, $getadmin);
        $row = mysqli_fetch_assoc($res);
        $admin_id = $row['id'];

        // adminlog/
        $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Admin Edit Project $id')
          ";
        $res = mysqli_query($con, $admin_log);

        if ($engineer != '' and $editProjectStage != '') {
            $query = "UPDATE `a_project` SET `category_id`='$cat',`service_id`='$editProjectService',`name`='$name',`engineer_id`=$engineer,`project_stage_id`='$editProjectStage',`client_amount`='$client_amount',`client_name`='$client_name',`client_tax`='$client_tax',`govt_tax`='$govt_tax',`client_tax_held`='$held',`net_amount`='$net_amount', head_code = '$chart_head_code', chart_acc_code = '$chart_detail_code' WHERE id='$id'";
            $res = mysqli_query($con, $query);
        } else if ($engineer != '' and $editProjectStage == '') {
            $query = "UPDATE `a_project` SET `category_id`='$cat',`service_id`='$editProjectService',`name`='$name',`engineer_id`=$engineer ,`client_amount`='$client_amount',`client_name`='$client_name',`client_tax`='$client_tax',`govt_tax`='$govt_tax',`client_tax_held`='$held',`net_amount`='$net_amount', head_code = '$chart_head_code', chart_acc_code = '$chart_detail_code' WHERE id='$id'";
            $res = mysqli_query($con, $query);
        } else if ($engineer == '' and $editProjectStage != '') {
            $query = "UPDATE `a_project` SET `category_id`='$cat',`service_id`='$editProjectService',`name`='$name',`project_stage_id`='$editProjectStage',`client_amount`='$client_amount',`client_name`='$client_name',`client_tax`='$client_tax',`govt_tax`='$govt_tax',`client_tax_held`='$held',`net_amount`='$net_amount', head_code = '$chart_head_code', chart_acc_code = '$chart_detail_code' WHERE id='$id'";
            $res = mysqli_query($con, $query);
        }
        $query = "UPDATE `a_project_assign` SET `group_id`='$project_groupAssign' WHERE project_id='$id'";
        $res = mysqli_query($con, $query);

        echo 1;
    }

    // Receving modal
    if ($_POST['projectAction'] == 'fetchModalReceiviving') {
        $id = $_POST['id'];
        $output = '';
        // table start headings
        $output .= '<div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Project Name</th>
                        <th>Cash Amount</th>
                        <th>Amount</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody_admin_action">
        ';

        $query = "SELECT a_receivings.id as id,
            a_receivings.amount as amount,
            a_receivings.cash_amount as cash_amount,
            a_receivings.created_at as created_at,
            a_project.name as project_name,
            a_project.id as project_id
            FROM a_receivings
            JOIN a_project ON a_receivings.project_id = a_project.id
            WHERE a_receivings.project_id = '$id'";

        $res = mysqli_query($con, $query);

        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $projectId = $row['project_id'];
                $queryProject = "SELECT * FROM a_project WHERE id != '$projectId'";
                $resProject = mysqli_query($con, $queryProject);
                $option = '<select class="adminEditableFields" disabled><option value="' . $row["project_id"] . '">' . $row["project_name"] . '</option>';
                while ($rowProject = mysqli_fetch_assoc($resProject)) {
                    $option .= '<option value="' . $rowProject["id"] . '">' . $rowProject["name"] . '</option>';
                }
                $option .= "</select>";
                $row["cash_amount"] = number_format($row["cash_amount"]);
                $row["amount"] = number_format($row["amount"]);
                $output .= '<tr>
                    <td><input type="text" class="adminEditableFields" disabled value="' . $row["id"] . '" /></td>
                    <td>' . $option . '</td>
                    <td><input type="text" class="adminEditableFields" disabled value="' . $row["cash_amount"] . '" /></td>
                    <td><input type="text" class="adminEditableFields" disabled value="' . $row["amount"] . '" /></td>
                    <td><input type="text" class="adminEditableFields" disabled value="' . $row["created_at"] . '" /></td>
                    <td><button class="adminModalEditBtn" onclick="adminModalEditBtnToggler(this)" style="font-size:16px;color:blue;">EDIT</button></td>
                </tr>';
            }
            $output .= '</tbody></table></div>';
        } else {
            $output .= '<tr><td colspan="6">No Record Found!</td></tr></tbody></table></div>';
        }

        echo $output;
    }

    // update project Receiving
    if ($_POST['projectAction'] == 'updateProjectReceiving') {
        $id = $_POST['id'];
        $ProjectId = $_POST['ProjectName'];
        $cashAmount = $_POST['cashAmount'];
        $amount = $_POST['amount'];
        $client_tax = strtolower($_POST['client']);
        $govt_tax = strtolower($_POST['govt']);
        $client_tax_afterDeductTaxAmount = 0;
        $govt_tax_afterDeductTaxAmount = 0;

        $cash = !empty($cashAmount) ? $cashAmount : $amount;

        $getData = "SELECT * from a_project where id= '$ProjectId'";
        $resData = mysqli_query($con, $getData);
        $rowdata = mysqli_fetch_assoc($resData);
        if ($client_tax == 'yes') {
            // $client_tax = $_POST['client_tax'];
            if (!empty($rowdata['client_tax']) && $rowdata['client_tax'] > 0) {
                $client_tax_in_percentage = round(($rowdata['client_tax'] / $rowdata['client_amount']) * 100, 1);

                $client_tax_afterDeductTaxAmount =    round(($cash * $client_tax_in_percentage) / 100, 1);
            }
            $cash = $cash - $client_tax_afterDeductTaxAmount;
        }
        if ($govt_tax == 'yes') {
            if (!empty($rowdata['govt_tax']) && $rowdata['govt_tax'] > 0) {
                $govt_tax_in_percentage = round(($rowdata['govt_tax'] / $rowdata['client_amount']) * 100, 1);

                $govt_tax_afterDeductTaxAmount =    round(($cash * $govt_tax_in_percentage) / 100, 1);
            }
            $cash = $cash - $govt_tax_afterDeductTaxAmount;
        }

        if (!empty($_POST['cashAmount'])) {
            $query = "UPDATE `a_receivings` SET `project_id`='$ProjectId',`cash_amount`='$cash',`client_tax`='$govt_tax_afterDeductTaxAmount', `govt_tax`='$govt_tax_afterDeductTaxAmount' WHERE id = '$id'";
        } else {
            $query = "UPDATE `a_receivings` SET `project_id`='$ProjectId',`amount`='$cash',`client_tax`='$govt_tax_afterDeductTaxAmount', `govt_tax`='$govt_tax_afterDeductTaxAmount' WHERE id = '$id'";
        }

        $res = mysqli_query($con, $query);
        if ($res) {

            // adminlog/
            $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Edit Receivings $id of Project $ProjectId')
        ";
            $res = mysqli_query($con, $admin_log);

            echo 1;
        } else {
            echo 0;
        }
    }
}



//   delete department 
if (isset($_GET['id'])) {
    // include 'connection.php';
    $id = $_GET['id'];
    $query = "DELETE FROM `a_project` WHERE id='$id'";
    $res = mysqli_query($con, $query);
    header("location:Project.php");
}
// end department 
// make Periodic
if (isset($_POST['makePeriodic'])) {
    $id = $_POST['id'];
    $query = "UPDATE a_project set `is_periodic`='1' where id = $id";
    $res = mysqli_query($con, $query);
    if ($res) {

        $history = "SELECT * from project_history where project_id = '$id' order by id desc limit 1";
        $resHistory = mysqli_query($con, $history);
        if (mysqli_num_rows($resHistory) > 0) {
            $row = mysqli_fetch_assoc($resHistory);
            $is_periodic = $row['new_is_periodic'];
            $history_id = $row['id'];
            $query = "UPDATE project_history 
            SET is_periodic=0, new_is_periodic = '1' 
            WHERE id = '$history_id'";
            $res = mysqli_query($con, $query);
        }

        $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Make Periodic Project  $id')
        ";
        $res = mysqli_query($con, $admin_log);
        echo 1;
    } else {
        echo 0;
    }
}
// cancel Periodic 
if (isset($_POST['cancelPeriodic'])) {
    $id = $_POST['id'];
    $query = "UPDATE a_project set `is_periodic`='0' where id = $id";
    $res = mysqli_query($con, $query);
    if ($res) {

        $history = "SELECT * from project_history where project_id = '$id' order by id desc limit 1";
        $resHistory = mysqli_query($con, $history);
        if (mysqli_num_rows($resHistory) > 0) {
            $row = mysqli_fetch_assoc($resHistory);
            $is_periodic = $row['new_is_periodic'];
            $history_id = $row['id'];
            $query = "UPDATE is_periodic=1, project_history 
            SET new_is_periodic = '0' 
            WHERE id = '$history_id'";
            $res = mysqli_query($con, $query);
        }



        $admin_log = "INSERT INTO `admin_logs`(`admin_id`, `action`) VALUES ('$admin_id','Cancel Periodic Project $id')
        ";
        $res = mysqli_query($con, $admin_log);
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['from']) && isset($_POST['to'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $query = "SELECT a_receivings.*, a_project.name as project_name from a_receivings join a_project on a_project.id = a_receivings.project_id where a_receivings.created_at between '$from' and '$to' order by a_receivings.created_at desc";
    $res = mysqli_query($con, $query);
    $output = 'No Record Found';
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $amount = ($row['mode'] == 'cash') ? $row['cash_amount'] : $row['amount'];
            $amount += $row['client_tax'] + $row['govt_tax'];
            $amount = number_format($amount);
            $dateString =  $row['receive_at'];
            $receiveDate = date("d F, Y", strtotime($dateString));
            $receiveDate; // Output: 25 July, 2023


            $dateString =  $row['created_at'];
            // Remove the time portion and convert to Unix timestamp
            $unixTimestamp = strtotime(substr($dateString, 0, 10));

            // Format the Unix timestamp as desired
            $created_at = date("d F, Y", $unixTimestamp);
            $created_at; // Output: 25 July, 2023

            $output .= '<tr>
            <td>' . $row['id'] . '</td>
            <td style="text-transform: capitalize;">' . $row['project_name'] . '</td>
            <td style="text-transform: capitalize;">' . $row['mode'] . '</td>
            <td style="text-transform: capitalize;">' . $row['bank_name'] . '</td>
            <td>' . $row['cheque_no'] . '</td>
            <td>' . $row['deposited_bank_name'] . '</td>
            <td>' . $row['deposited_bank_branch'] . '</td>
            <td>' . $amount . '</td>
            <td>' . $receiveDate . '</td>
            <td>' . $created_at . '</td>
            
            ';
        }
    }
    echo $output;
}

if (isset($_POST['chart'])) {
    $receivingId = $_POST['receivingId'];

    $query = "SELECT a_project.id as project_id, a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id where a_receivings.id = '$receivingId'";
    $res = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($res);
    $net_amount = (int)$row['net_amount'];
    $project_id = $row['project_id'];

    $query = "SELECT * from a_receivings where project_id = '$project_id'";
    $res = mysqli_query($con, $query);
    $date = '';
    $receiving = '';
    if (mysqli_num_rows($res) > 0) {

        while ($row = mysqli_fetch_assoc($res)) {
            $dateExp = explode(' ', $row['created_at']);
            $date .= $dateExp[0];
            $date .= ',';
            $receiving .= ((($row['mode'] == 'cash') ? (int)$row['cash_amount'] : (int)$row['amount']) / $net_amount) * 100;
            $receiving .= ',';
        }
    }
    echo $date . '!' . $receiving;
}
