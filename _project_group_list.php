<?php
include 'connection.php';
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: index.php');
    exit; // Make sure to exit to prevent further script execution
}

$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];

$p_id = $_POST['p_id'];
$query = "SELECT * FROM a_receivings where project_id IN (SELECT group_id FROM a_project_assign WHERE group_id = $p_id)";
$result = mysqli_query($con,$query);
$html = '';
$sum = 0;
while($row = mysqli_fetch_assoc($result)) {

    $sum += $row['cash_amount'] + $row['amount'];

    $id = $row['project_id'];
    $query1 = "SELECT * FROM a_project where id = $id";
    $result1 = mysqli_query($con, $query1);
    $row1 = mysqli_fetch_assoc($result1);
    $name = $row1['name'];

    $id = $row['project_id'];
    $query1 = "SELECT * FROM a_group where id = (SELECT group_id FROM a_project_assign where project_id = $id)";
    $result1 = mysqli_query($con, $query1);
    $row1 = mysqli_fetch_assoc($result1);
    $name2 = $row1['name'];

    $type = ($row['mode'] == 'cash') ? $row['cash_amount'] : $row['amount'];
    $html .= "<tr>
        <td>" . $row['id'] . "</td>
        <td>" . $name . "</td>
        <td>" . $name2 . "</td>
        <td>" . $row['mode'] . "</td>
        <td>" . $row['bank_name'] . "</td>
        <td>" . $type . "</td>
        <td>" . $row['cheque_no'] . "</td>
        <td>" . $row['created_at'] . "</td>
    </tr>";
}

$p_id = $_POST['p_id'];
$year = date("Y");
$query = "SELECT month,Count(month) as count,SUM(cash_amount)+SUM(amount) as total FROM `a_receivings` WHERE project_id = $p_id and year = $year GROUP BY month ORDER BY month asc ";
$result = mysqli_query($con,$query);
while($row = mysqli_fetch_assoc($result)) {
    $monthNum  = $row['month'];
    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
    $monthName = $dateObj->format('F'); // March
    $d['label'] = $monthName;
    $d['y'] = (int)$row['total'];
    $data[] = $d;
}

echo $html."!".json_encode($data)."!".$sum;

?>