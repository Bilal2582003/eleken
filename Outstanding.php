<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: index.php');
    exit; // Make sure to exit to prevent further script execution
}

$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];

include "navbar.php";
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to Outstanding</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group date datepicker dashboard-date mr-2 mb-2 mb-md-0 d-md-none d-xl-flex" id="dashboardDate">
                <span class="input-group-addon bg-transparent"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar  text-primary">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg></span>
                <input type="text" class="form-control">
            </div>
            <button type="button" class="btn btn-outline-info btn-icon-text mr-2 d-none d-md-block" data-toggle="modal" data-target="#importModal" data-whatever="@mdo">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download btn-icon-prepend">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                Import
            </button>
            <button type="button" class="btn btn-outline-primary btn-icon-text mr-2 mb-2 mb-md-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer btn-icon-prepend">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                Print
            </button>
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-toggle="modal" data-target="#receiveModal" data-whatever="@mdo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus" width="16" height="16">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add New
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h6 class="card-title ">Data Table

                        <!-- <button class="btn btn-primary" type="button" >Add new</button> -->

                        <!-- <button class="btn btn-primary" type="button">Import</button> -->
                    </h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Project</th>
                                    <th>Client Name</th>
                                    <!-- <th>Category</th> -->
                                    <!-- <th>Group</th> -->
                                    <th>Category</th>
                                    <!-- <th>Client Name</th> -->
                                    <!-- <th>Total Amount</th> -->
                                    <!-- <th>Client Tax</th>
                                <th>Govt Tax</th> -->
                                    <!-- <th>Net Amount</th> -->
                                    <!-- <th>Balance</th> -->
                                    <!-- <th>Total Amount Received</th> -->
                                    <!-- <th>Created</th> -->
                                    <th>
                                        Net Amount
                                    </th>
                                    <th>
                                        Balance
                                    </th>
                                    <th>
                                        Unpaid Month Count
                                    </th>
                                    <th>
                                       Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'connection.php';
                                $today_date=date("Y-m-d");
                                $query = "SELECT a_project.* from a_project where is_periodic = 1   order by id desc";
                                $res = mysqli_query($con, $query);
                                while ($row = mysqli_fetch_assoc($res)) { 
                                    $project_id=$row['id'];
                                    $receivingQuery="SELECT * from a_receivings where project_id = '$project_id' order by id desc limit 1";
                                    $receivingRes=mysqli_query($con,$receivingQuery);
                                    if(mysqli_num_rows($receivingRes) > 0){
                                        $receivingRow=mysqli_fetch_assoc($receivingRes);
                                       $lastPaidDate = $receivingRow['receive_at'];
                                    }
                                    else{
                                        $lastPaidDate = $row['created_at'];
                                        $lastPaidDate = explode(' ',$lastPaidDate);
                                        $lastPaidDate=$lastPaidDate[0];
                                    }
                                  

                                    $date1 = $today_date;
                                    $date2 =  $lastPaidDate;
                            
                                    $ts1 = strtotime($date1);
                                    $ts2 = strtotime($date2);
                            
                                    $year1 = date('Y', $ts1);
                                    $year2 = date('Y', $ts2);
                            
                                    $month1 = date('m', $ts1);
                                    $month2 = date('m', $ts2);
                            
                                    $diff = (($year1 - $year2 ) * 12) - ($month2 - $month1) ;
                                    ?>
                                    <tr>
                                        <td><?php echo $row['id'] ?></td>
                                        <td class="text-capitalize"><?php echo $row['name'] ?></td>
                                        <td class="text-capitalize"><?php echo $row['client_name'] ?></td>
                                        <td class="text-capitalize"><?php 
                                        $cat_id=$row['category_id'];
                                        $queryCat="SELECT * from a_project_category where id='$cat_id'";
                                        $resCat=mysqli_query($con,$queryCat);
                                        $rowCat=mysqli_fetch_assoc($resCat);
                                        echo $rowCat['name'] ?>
                                        </td>
                                        <td><?php echo number_format($row['net_amount']) ?></td>
                                        <td><?php  $get_project_id = $row['id'];
                                                                                        $myquery = "SELECT ((SELECT net_amount FROM a_project where id = '$get_project_id') -SUM(cash_amount)+SUM(amount) ) as total FROM `a_receivings` WHERE project_id = '$get_project_id'";
                                                                                        $myRes = mysqli_query($con, $myquery);
                                                                                        if (mysqli_num_rows($myRes) > 0) {
                                                                                            $row1 = mysqli_fetch_assoc($myRes);
                                                                                            echo number_format($row1['total']);
                                                                                        } else {
                                                                                            echo "Not yet received";
                                                                                        } ?></td>
                                        <td><?php echo $diff ?></td>
                                      <td>
                                      <div class="container mt-4">
                                                <div class="dropdown">
                                                    <!-- Action button -->
                                                    <button class="btn btn-primary dropdown-toggle" type="button" id="actionDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <!-- Dropdown menu -->
                                                    <div class="dropdown-menu" aria-labelledby="actionDropdown">
                                                        <!-- Dropdown items -->
                                                        <div class="dropdown-item" onclick="cancelPeriodic(<?php echo $row['id'] ?>)">Cancel Periodic</div>
                                                    </div>
                                                </div>
                                            </div>
                                      </td>

                                        <?php
                                }
                                ?>
                                    </tr>
                            </tbody>
                        </table>
                    </div>




                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>

<script>
 function cancelPeriodic(id) {
        if (confirm("Do you want to make Periodic this project?")) {
            $(document).ready(function() {
                $.ajax({
                    url: "_project.php",
                    type: "POST",
                    data: {
                        id: id,
                        cancelPeriodic: "cancelPeriodic"
                    },
                    success: function(data) {
                        if (data === '1') {
                            alert("Successfully Cancelled");
                            window.location.assign('Outstanding.php')
                        } else {
                            alert("Error");
                        }
                    }
                });
            });
        } else {
            return false; // Return false to prevent form submission (if used in a form)
        }
    }

</script>