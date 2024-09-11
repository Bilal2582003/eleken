<?php
include 'connection.php';
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: index.php');
    exit; // Make sure to exit to prevent further script execution
}

$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];


if (isset($_GET['searchMonthWise'])) {

    // if month wise searching 
    if ($_GET['searchMonthWise'] == 'monthWise') {
        $month = $_GET['monthWise'];
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '%$month%'";
    }
    // if year wise searching 
    if ($_GET['searchMonthWise'] == 'yearWise') {
        $from_date = $_GET['from_date'];
        $to_date = $_GET['to_date'];
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at Between '$from_date' and '$to_date'";
    }
    if ($_GET['searchMonthWise'] == 'cashCheque') {
                $cashCheque=$_POST['cashCheque'];
        
        if($cashCheque == 'cash'){
            $ExtraQuery ="a_receivings.mode = 'cash' and (a_receivings.bank_name is null || a_receivings.bank_name = '')  and (a_receivings.deposited_bank_name = 0 || a_receivings.deposited_bank_name is null)  ";
        }
        if($cashCheque == 'cashinbank'){
            $ExtraQuery = "a_receivings.mode = 'cash' and (a_receivings.bank_name is null || a_receivings.bank_name = '')  and (a_receivings.deposited_bank_name > 0 )";
        }
        if($cashCheque == 'cheque'){
            $ExtraQuery="a_receivings.mode = 'cheque'";
        }
        $query="SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where ".$ExtraQuery;
        
    }
    $res = mysqli_query($con, $query);
    $sum = 0;
    $chartNetAmount = 0;
    $dublicateProjectArray = [];
    $dateChart = '';
    $receivingChart = '';
    $html = '<table id="dataTableExample" class="table">
<thead>
<tr>
<th class="th-sm">Id
</th>
<th class="th-sm">Project
</th>
<th class="th-sm">Client Name
</th>
<th class="th-sm">Total Fees
</th>
<th class="th-sm">Balance
</th>
<th class="th-sm">Received Amount
</th>
<th class="th-sm">SST
</th>
<th class="th-sm">IT
</th>
<th class="th-sm">Group
</th>
<th class="th-sm">Mode
</th>
<th class="th-sm">Bank
</th>
<th class="th-sm">Cheque #
</th>
<th class="th-sm">Received At
</th>
<th class="th-sm">Created
</th>
</tr>
</thead>
<tbody id="tableBody">';
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $sum += $row['cash_amount'] + $row['amount'] + $row['client_tax'] + $row['govt_tax'];
            $bank = $row['deposited_bank_name'];
            $project_id = $row['project_id'];
            if (!in_array($project_id, $dublicateProjectArray)) {
                array_push($dublicateProjectArray, $project_id);
                $chartNetAmount += $row['client_amount'];
            }


            $dateExp = explode(' ', $row['created_at']);
            $dateChart .= $dateExp[0];
            $dateChart .= ',';
            // $receivingChart .= round(((($row['mode'] == 'cash') ? (int)$row['cash_amount'] : (int)$row['amount']) / $chartNetAmount) * 100, 1);
            $receivingChart .= round(($sum / $chartNetAmount) * 100, 1);

            $receivingChart .= ',';


            $dateString = $row['created_at'];
            // Remove the time portion and convert to Unix timestamp
            $unixTimestamp = strtotime(substr($dateString, 0, 10));

            // Format the Unix timestamp as desired
            $formattedDate = date("d F, Y", $unixTimestamp);

            $formattedDate; // Output: 25 July, 2023
            
            $dateString = $row['receive_at'];
            // Remove the time portion and convert to Unix timestamp
            $unixTimestamp = strtotime(substr($dateString, 0, 10));

            // Format the Unix timestamp as desired
            $ReceiveformattedDate = date("d F, Y", $unixTimestamp);
            
            $type = ($row['mode'] == 'cash') ? number_format($row['cash_amount']) : number_format($row['amount']);

            $projectId = $row['project_id'];
            $query1 = "SELECT  SUM(amount) as amount , SUM(cash_amount) as cash_amount , SUM(client_tax) as client_tax , Sum(govt_tax) as govt_tax FROM a_receivings where project_id = '$projectId'";
            $result2 = mysqli_query($con, $query1);
            $totalSum = 0;
            // $row2 = mysqli_fetch_assoc($result2);
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $totalSum += $row2['amount'] + $row2['cash_amount'] + $row2['client_tax'] + $row2['govt_tax'];
            }

            $clientAmount = number_format($row['client_amount'] - $totalSum);

            $bank_name = '';
            if ($bank > 0) {
                $bankQuery = "SELECT * from bank where id = '$bank'";
                $resBank = mysqli_query($con, $bankQuery);

                $rowBank = mysqli_fetch_assoc($resBank);
                $bank_name = $rowBank['name'];
            }


            $html .= "<tr>
            <td>" . $row['id'] . "</td>
            <td class='text-capitalize' style='white-space: normal;'>" . $row['project_name'] . "</td>
            <td class='text-capitalize'>" . $row['client_name'] . "</td>
            <td class='text-capitalize'>" . $row['client_amount'] . "</td>
            <td class='text-capitalize'>" . $clientAmount . "</td>
            <td>" . $type . "</td>
            <td>" . number_format($row['client_tax']) . "</td>
            <td>" . number_format($row['govt_tax']) . "</td>
            <td class='text-capitalize'>" . $row['group_name'] . "</td>
            <td class='text-capitalize'>" . $row['mode'] . "</td>
            <td class='text-capitalize'>" . $bank_name . "</td>
            <td>" . $row['cheque_no'] . "</td>
            <td>" . $ReceiveformattedDate . "</td>
            <td>" . $formattedDate . "</td> 
            </tr>";
        }
        // echo 1;
    }
    $html .= '</tbody></table>';
    $balanceCount = $chartNetAmount - $sum;
    // echo $html.'!'.number_format($sum).'!'.$dateChart.'!'.$receivingChart.'!'.number_format($chartNetAmount).'!'.number_format($balanceCount);
    $date = date("Y-M-d");
    $html;
    $file = "SummaryExport (" . $date . ").xls";
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=' . $file);
    echo $html;
} else {

    $project = $_GET['project'];
    $category = $_GET['category'];
    $group = $_GET['group'];
    $status = $_GET['status'];
    $date = $_GET['date'];
    $client = $_GET['client'];

    // all search 
    if (!empty($project) && !empty($category) && !empty($group) && !empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_project.status = '$status' and a_group.id = '$group' and a_project_category.id='$category' and a_project.id = '$project' and a_project.client_name like '%$client%' ";
    }
    // only project 
    if (!empty($project) && empty($category) && empty($group) && empty($status) && empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id   where a_project.id = '$project' ";
    }
    // only category 
    if (empty($project) && !empty($category) && empty($group) && empty($status) && empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project_category.id='$category'  ";
    }
    //  only group 
    if (empty($project) && empty($category) && !empty($group) && empty($status) && empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_group.id = '$group' ";
    }
    // only status 
    if (empty($project) && empty($category) && empty($group) && !empty($status) && empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where  a_project.status = '$status' ";
    }
    // only date 
    if (empty($project) && empty($category) && empty($group) && empty($status) && !empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' ";
    }
    // only client 
    if (empty($project) && empty($category) && empty($group) && empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' ";
    }



    // project more conditions 

    // project and category 
    if (!empty($project) && !empty($category) && empty($group) && empty($status) && empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project_category.id='$category' and a_project.id = '$project' ";
    }
    // project and category and group
    if (!empty($project) && !empty($category) && !empty($group) && empty($status) && empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_group.id = '$group' and a_project_category.id='$category' and a_project.id = '$project' ";
    }
    // project and category and group and status 
    if (!empty($project) && !empty($category) && !empty($group) && !empty($status) && empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.status = '$status' and a_group.id = '$group' and a_project_category.id='$category' and a_project.id = '$project' ";
    }




    // category conditions 

    // category and group
    if (empty($project) && !empty($category) && !empty($group) && empty($status) && empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_group.id = '$group' and a_project_category.id='$category' ";
    }
    // category and group and status 
    if (empty($project) && !empty($category) && !empty($group) && !empty($status) && empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.status = '$status' and a_group.id = '$group' and a_project_category.id='$category' ";
    }
    // category and group and status and date 
    if (empty($project) && !empty($category) && !empty($group) && !empty($status) && !empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_project.status = '$status' and a_group.id = '$group' and a_project_category.id='$category' ";
    }
    // category and group and status and date and client
    if (empty($project) && !empty($category) && !empty($group) && !empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_project.status = '$status' and a_group.id = '$group' and a_project_category.id='$category' and a_project.client_name like '%$client%' ";
    }
    if (empty($project) && !empty($category) && empty($group) && !empty($status) && empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where  a_project.status = '$status' and a_project_category.id='$category' ";
    }




    // group condition 

    // group and status
    if (empty($project) && empty($category) && !empty($group) && !empty($status) && empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.status = '$status' and a_group.id = '$group' ";
    }
    // group and status and date 
    if (empty($project) && empty($category) && !empty($group) && !empty($status) && !empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_project.status = '$status' and a_group.id = '$group' ";
    }
    // group and status and date and client
    if (empty($project) && empty($category) && !empty($group) && !empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_project.status = '$status' and a_group.id = '$group' and a_project.client_name like '$client'";
    }
    // group and status and date and project 
    if (!empty($project) && empty($category) && !empty($group) && !empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_project.status = '$status' and a_group.id = '$group' and a_project.id = '$project' and a_project.client_name like '%$client%'";
    }
    // group and status and date and project 
    if (!empty($project) && empty($category) && !empty($group) && empty($status) && empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where  a_group.id = '$group' and a_project.id = '$project' ";
    }




    // status condition 

    // status and date 
    if (empty($project) && empty($category) && empty($group) && !empty($status) && !empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_project.status = '$status' ";
    }
    // status and date 
    if (empty($project) && empty($category) && empty($group) && !empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_project.status = '$status' and a_project.client_name like '%$client%' ";
    }
    // status and date and project 
    if (!empty($project) && empty($category) && empty($group) && !empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_project.status = '$status' and a_project.id = '$project' and a_project.client_name like '%$client%'";
    }
    // status and date and project and category 
    if (!empty($project) && !empty($category) && empty($group) && !empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_project.status = '$status' and a_project_category.id='$category' and a_project.id = '$project' and a_project.client_name like '%$client%'";
    }
    if (!empty($project) && empty($category) && empty($group) && !empty($status) && empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where  a_project.status = '$status' and a_project.id = '$project' ";
    }






    // date condition 

    // date and project 
    if (!empty($project) && empty($category) && empty($group) && empty($status) && !empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_project.id = '$project' ";
    }
    // date and project and category 
    if (!empty($project) && !empty($category) && empty($group) && empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_project_category.id='$category' and a_project.id = '$project' and a_project.client_name like '%$client%' ";
    }
    // date and project and category and group 
    if (!empty($project) && !empty($category) && !empty($group) && empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_group.id = '$group' and a_project_category.id='$category' and a_project.id = '$project' and a_project.client_name like '%$client%'";
    }
    if (empty($project) && empty($category) && !empty($group) && empty($status) && !empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_group.id = '$group' ";
    }
    if (empty($project) && !empty($category) && empty($group) && empty($status) && !empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_project_category.id='$category' ";
    }





    if (!empty($project) && empty($category) && empty($group) && empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.id='$project' and a_project.client_name like '%$client%'";
    }
    if (!empty($project) && !empty($category) && empty($group) && empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.id = '$project' and a_project_category.id='$category' and a_project.client_name like '%$client%'";
    }
    if (!empty($project) && !empty($category) && !empty($group) && empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.id = '$project' and a_project_category.id='$category' and a_group.id = '$group' and a_project.client_name like '%$client%'";
    }
    if (!empty($project) && !empty($category) && !empty($group) && !empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.id = '$project' and a_project_category.id='$category' and a_group.id = '$group' and a_project.client_name like '%$client%' and a_project.status = '$status'";
    }
    if (!empty($project) && empty($category) && !empty($group) && empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.id = '$project' and a_group.id = '$group' and a_project.client_name like '%$client%' ";
    }
    if (empty($project) && empty($category) && empty($group) && empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_receivings.receive_at like '$date%' and a_project.client_name like '%$client%' ";
    }
    if (empty($project) && empty($category) && empty($group) && !empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' and a_project.status = '$status' ";
    }
    if (empty($project) && empty($category) && !empty($group) && empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' and a_group.id = '$group' ";
    }
    if (empty($project) && !empty($category) && empty($group) && empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' and a_project_category.id='$category' ";
    }
    if (empty($project) && empty($category) && !empty($group) && empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' and a_receivings.receive_at like '$date%' and a_group.id = '$group' ";
    }
    if (empty($project) && !empty($category) && !empty($group) && empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' and a_receivings.receive_at like '$date%' and a_group.id = '$group' and a_project_category.id='$category' ";
    }
    if (empty($project) && !empty($category) && empty($group) && empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' and a_receivings.receive_at like '$date%' and a_project_category.id='$category' ";
    }
    if (!empty($project) && empty($category) && empty($group) && empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' and a_project.id='$project' ";
    }
    if (empty($project) && empty($category) && !empty($group) && !empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' and a_group.id = '$group' and a_project.status = '$status' ";
    }
    if (empty($project) && !empty($category) && !empty($group) && !empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' and a_group.id = '$group' and a_project.status = '$status' and a_project_category.id='$category' ";
    }
    if (empty($project) && !empty($category) && empty($group) && !empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' and a_project.status = '$status' and a_project_category.id='$category' ";
    }
    if (empty($project) && !empty($category) && empty($group) && !empty($status) && !empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' and a_project.status = '$status' and a_project_category.id='$category' and a_receivings.receive_at like '$date%' ";
    }
    if (!empty($project) && empty($category) && empty($group) && !empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' and a_project.status = '$status' and a_project.id='$project' ";
    }
    if (!empty($project) && empty($category) && !empty($group) && !empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' and a_project.status = '$status' and a_project.id='$project' and a_group.id = '$group' ";
    }
    if (!empty($project) && !empty($category) && empty($group) && !empty($status) && empty($date) && !empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id where a_project.client_name like '%$client%' and a_project.status = '$status' and a_project.id='$project' and a_project_category.id='$category' ";
    }





    // all are empty 
    if (empty($project) && empty($category) && empty($group) && empty($status) && empty($date) && empty($client)) {
        $query = "SELECT a_receivings.*,a_group.name as group_name , a_project.name as project_name , a_project.client_name as client_name , a_project.client_amount as client_amount , a_project.id as project_id , a_project.net_amount as net_amount from a_receivings join a_project on a_receivings.project_id = a_project.id join a_project_category on a_project_category.id = a_project.category_id join a_project_assign on a_project.id = a_project_assign.project_id join a_group on a_project_assign.group_id = a_group.id ";
    }
    $result1 = mysqli_query($con, $query);
    $countOfRow = mysqli_num_rows($result1);
    $html = '<table id="dataTableExample" class="table">
<thead>
<tr>
<th class="th-sm">Id
</th>
<th class="th-sm">Project
</th>
<th class="th-sm">Client Name
</th>
<th class="th-sm">Total Fees
</th>
<th class="th-sm">Balance
</th>
<th class="th-sm">Received Amount
</th>
<th class="th-sm">SST
</th>
<th class="th-sm">IT
</th>
<th class="th-sm">Group
</th>
<th class="th-sm">Mode
</th>
<th class="th-sm">Bank
</th>
<th class="th-sm">Cheque #
</th>
<th class="th-sm">Receive At
</th>
<th class="th-sm">Created
</th>
</tr>
</thead>
<tbody id="tableBody">';
    $dateChart = '';
    $receivingChart = '';
    $sum = 0;
    $chartNetAmount = 0;
    $dublicateProjectArray = [];

    while ($row = mysqli_fetch_assoc($result1)) {

        $sum += $row['cash_amount'] + $row['amount'] + $row['client_tax'] + $row['govt_tax'];
        $bank = $row['deposited_bank_name'];
        $project_id = $row['project_id'];
        if (!in_array($project_id, $dublicateProjectArray)) {
            array_push($dublicateProjectArray, $project_id);
            $chartNetAmount += $row['client_amount'];
        }


        $dateExp = explode(' ', $row['created_at']);
        $dateChart .= $dateExp[0];
        $dateChart .= ',';
        // $receivingChart .= round(((($row['mode'] == 'cash') ? (int)$row['cash_amount'] : (int)$row['amount']) / $chartNetAmount) * 100, 1);
        $receivingChart .= round(($sum / $chartNetAmount) * 100, 1);

        $receivingChart .= ',';


        $dateString = $row['created_at'];
        // Remove the time portion and convert to Unix timestamp
        $unixTimestamp = strtotime(substr($dateString, 0, 10));

        // Format the Unix timestamp as desired
        $formattedDate = date("d F, Y", $unixTimestamp);

        $formattedDate; // Output: 25 July, 2023
        
        $dateString = $row['receive_at'];
        // Remove the time portion and convert to Unix timestamp
        $unixTimestamp = strtotime(substr($dateString, 0, 10));

        // Format the Unix timestamp as desired
        $ReceivedformattedDate = date("d F, Y", $unixTimestamp);
        
        $type = ($row['mode'] == 'cash') ? number_format($row['cash_amount']) : number_format($row['amount']);

        $projectId = $row['project_id'];
        $query1 = "SELECT  SUM(amount) as amount , SUM(cash_amount) as cash_amount , SUM(client_tax) as client_tax , Sum(govt_tax) as govt_tax FROM a_receivings where project_id = '$projectId'";
        $result2 = mysqli_query($con, $query1);
        $totalSum=0;
        // $row2 = mysqli_fetch_assoc($result2);
    while($row2 = mysqli_fetch_assoc($result2)){
        $totalSum += $row2['amount'] + $row2['cash_amount'] + $row2['client_tax'] + $row2['govt_tax'];
    }

        $clientAmount= number_format($row['client_amount'] - $totalSum ) ;

        $bank_name = '';
        if ($bank > 0) {
            $bankQuery = "SELECT * from bank where id = '$bank'";
            $resBank = mysqli_query($con, $bankQuery);

            $rowBank = mysqli_fetch_assoc($resBank);
            $bank_name = $rowBank['name'];
        }


        $html .= "<tr>
        <td>" . $row['id'] . "</td>
        <td class='text-capitalize' style='white-space: normal;'>" . $row['project_name'] . "</td>
        <td class='text-capitalize'>" . $row['client_name'] . "</td>
        <td class='text-capitalize'>" . $row['client_amount'] . "</td>
        <td class='text-capitalize'>" . $clientAmount . "</td>
        <td>" . $type . "</td>
        <td>" . number_format($row['client_tax']) . "</td>
        <td>" . number_format($row['govt_tax']) . "</td>
        <td class='text-capitalize'>" . $row['group_name'] . "</td>
        <td class='text-capitalize'>" . $row['mode'] . "</td>
        <td class='text-capitalize'>" . $bank_name . "</td>
        <td>" . $row['cheque_no'] . "</td>
        <td>" . $ReceivedformattedDate . "</td>
        <td>" . $formattedDate . "</td>
        </tr>";
    }
    $html .= '</tbody></table>';

    // $balanceCount= $chartNetAmount - $sum;
    // echo $html.'!'.number_format($sum).'!'.$dateChart.'!'.$receivingChart.'!'.number_format($chartNetAmount).'!'.number_format($balanceCount);

    $date = date("Y-M-d");
    $html;
    $file = "SummaryExport (" . $date . ").xls";
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=' . $file);
    echo $html;
}
