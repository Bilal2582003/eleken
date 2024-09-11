<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: index.php');
    exit; // Make sure to exit to prevent further script execution
}

$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];

include "navbar.php";
$id = $_GET['id'];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h2>Project Details</h2>

                    <?php
                    include 'connection.php';
                    $query = "SELECT * FROM a_project where id='$id'";
                    $result = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Id:</label>
                                        <input type="text" class="form-control" value="<?php echo $row['id'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Project:</label>
                                        <input type="text" class="form-control" style="text-transform: capitalize;" value="<?php echo $row['name'] ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category:</label>
                                        <input style="text-transform: capitalize;" type="text" class="form-control" value="<?php
                                                                                        $id = $row['category_id'];
                                                                                        $query1 = "SELECT * FROM a_project_category where id = $id";
                                                                                        $result1 = mysqli_query($con, $query1);
                                                                                        $row1 = mysqli_fetch_assoc($result1);
                                                                                        echo $row1['name'];
                                                                                        ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Group:</label>
                                        <input style="text-transform: capitalize;" type="text" class="form-control" value="<?php
                                                                                        $id = $row['id'];
                                                                                        $query1 = "SELECT * FROM a_project_assign where project_id = $id";
                                                                                        $result1 = mysqli_query($con, $query1);
                                                                                        if (mysqli_num_rows($result1) > 0) {
                                                                                            $row1 = mysqli_fetch_assoc($result1);
                                                                                            $id1 = $row1['group_id'];
                                                                                            $query1 = "SELECT * FROM a_group where id = $id1";
                                                                                            $result1 = mysqli_query($con, $query1);

                                                                                            $row1 = mysqli_fetch_assoc($result1);
                                                                                            echo $row1['name'];
                                                                                        } else {
                                                                                            echo "Not Assigned";
                                                                                        }
                                                                                        ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Current Status:</label>
                                        <input type="text" class="form-control" value="<?php echo $row['status'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Client Name:</label>
                                        <input style="text-transform: capitalize;" type="text" class="form-control" value="<?php echo $row['client_name'] ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Total Amount:</label>
                                        <input type="text" class="form-control" value="<?php echo number_format($row['client_amount']) ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Client Tax:</label>
                                        <input type="text" class="form-control" value="<?php echo $row['client_tax'] ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Govt. Tax:</label>
                                        <input type="text" class="form-control" value="<?php echo $row['govt_tax'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Net Amount:</label>
                                        <input type="text" class="form-control" value="<?php echo number_format($row['net_amount']) ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Balance:</label>
                                        <input type="text" class="form-control" value="<?php
                                                                                        $totalAmountReceivedOfProject=0;
                                                                                        $get_project_id = $row['id'] ;
                                                                                        // $myquery = "SELECT ((SELECT net_amount FROM a_project where id = '$get_project_id') -SUM(cash_amount)+SUM(amount)+SUM(client_tax)+SUM(govt_tax) ) as total FROM `a_receivings` WHERE project_id = '$get_project_id'";
                                                                                       $myquery = "SELECT SUM(cash_amount) as cash_amount, SUM(amount) as amount, SUM(client_tax) as client_tax, SUM(govt_tax) as govt_tax FROM `a_receivings` WHERE project_id = '$get_project_id'";
                                                                                        $myRes = mysqli_query($con, $myquery);
                                                                                        if (mysqli_num_rows($myRes) > 0) {
                                                                                            
                                                                                            $row1 = mysqli_fetch_assoc($myRes);
                                                                                            $totalAmountReceivedOfProject += $row1['cash_amount'] + $row1['amount'] + $row1['client_tax'] + $row1['govt_tax'];
                                                                                            $balanceAmount = $row['client_amount'] - $totalAmountReceivedOfProject; 
                                                                                            echo number_format($balanceAmount);
                                                                                        } else {
                                                                                            echo "Not yet received";
                                                                                        }
                                                                                        ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Total Amount Received:</label>
                                        <input type="text" class="form-control" value="<?php
                                                                                        $id = $row['id'];
                                                                                        // $query1 = "SELECT SUM(cash_amount)+SUM(amount)+SUM(client_tax)+SUM(govt_tax) as total FROM a_receivings where project_id = $id";
                                                                                        // $result1 = mysqli_query($con, $query1);
                                                                                        // if (mysqli_num_rows($result1) > 0) {
                                                                                        //     $row1 = mysqli_fetch_assoc($result1);
                                                                                        //     $perc = ((int)$row1['total'] / (int)$row['net_amount']) * 100;
                                                                                        //     echo number_format($row1['total']) . " (" . (int)$perc . "%)";
                                                                                        // } else {
                                                                                        //     echo "Not yet received";
                                                                                        // }
                                                                                        if($totalAmountReceivedOfProject > 0){
                                                                                            $perc = ((int)$totalAmountReceivedOfProject / (int)$row['client_amount']) * 100;
                                                                                            echo number_format($totalAmountReceivedOfProject) . " (" . (int)$perc . "%)";
                                                                                        }else{
                                                                                            echo "Not yet received";
                                                                                        }
                                                                                        ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Engineer:</label>
                                        <input style="text-transform: capitalize;" type="text" class="form-control" value="<?php
                                                                                        $engineer_id = $row['engineer_id'];
                                                                                        $engineer_query = "Select * from engineer where id = $engineer_id";
                                                                                        $res_engineer = mysqli_query($con, $engineer_query);
                                                                                        if (mysqli_num_rows($res_engineer) > 0) {
                                                                                            $rowEng = mysqli_fetch_assoc($res_engineer);
                                                                                            echo $rowEng['name'];
                                                                                        }

                                                                                        ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Project Stage:</label>

                                        <?php
                                        $stage_id = $row['project_stage_id'];
                                        $getStage = "SELECT * from project_stages where id = '$stage_id'";
                                        $res_getStage = mysqli_query($con, $getStage);
                                        if (mysqli_num_rows($res_engineer) > 0) {
                                            $rowStg = mysqli_fetch_assoc($res_getStage);
                                            $rowStg = $rowStg['title'];
                                        } else {
                                            $rowStg = '';
                                        }
                                        ?>
                                        <input style="text-transform: capitalize;" type="text" class="form-control" value="<?php echo $rowStg ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Created At:</label>
                                        <input type="text" class="form-control" value="<?php
                                                                                        $dateString = $row['created_at'];
                                                                                        // Remove the time portion and convert to Unix timestamp
                                                                                        $unixTimestamp = strtotime(substr($dateString, 0, 10));

                                                                                        // Format the Unix timestamp as desired
                                                                                        $formattedDate = date("d F, Y", $unixTimestamp);

                                                                                        echo $formattedDate; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label>Service:</label>
                                        <input style="text-transform: capitalize;" type="text" class="form-control" value="<?php
                                                                                        $serviceid = $row['service_id'];
                                                                                        $query1 = "SELECT * FROM a_project_service where id = $serviceid";
                                                                                        $result1 = mysqli_query($con, $query1);
                                                                                        $row1 = mysqli_fetch_assoc($result1);
                                                                                        echo $row1['name'];
                                                                                        ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="row">
                        <div class="col-sm-12">
                        <canvas id="lineChart"></canvas>
                        </div>
                    </div>



                    <hr>
                    <br><br>
                    <h2>Receiving Data</h2>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="from_date">From Date:</label>
                                <input type="date" class="form-control" id="from_date" name="from_date">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="to_date">To Date:</label>
                                <input type="date" class="form-control" id="to_date" name="to_date">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="to_date">Search:</label><br>
                                <button type="button" class="btn btn-primary" id="search" width="40px" value="Search">Search</button>
                            </div>
                        </div>
                    </div>



                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th class="th-sm">Id
                                    </th>
                                    <th class="th-sm">Project
                                    </th>
                                    <th class="th-sm">Mode
                                    </th>
                                    <th class="th-sm">Bank Name
                                    </th>
                                    <th class="th-sm">Cheque No
                                    </th>
                                    <th class="th-sm">Deposit Bank
                                    </th>
                                     <th class="th-sm">Deposit Branch
                                    </th>
                                    <th class="th-sm">Amount
                                    </th>
                                    <th class="th-sm">SST
                                    </th>
                                    <th class="th-sm">IT
                                    </th>
                                    <th class="th-sm">Recivie Date
                                    </th>
                                    <th class="th-sm">Created Date
                                    </th>

                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php
                                include 'connection.php';
                                $query = "SELECT * FROM a_receivings where project_id ='$id'  order by id desc";
                                $result = mysqli_query($con, $query);
                                while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td id="receivingId"><?php echo $row['id'] ?></td>
                                        <td style="text-transform: capitalize;"><?php $projectQuery = "select * from a_project where id = '$id'";
                                            $resPRoject = mysqli_query($con, $projectQuery);
                                            $rowProject = mysqli_fetch_assoc($resPRoject);
                                            echo $rowProject['name'];
                                            ?></td>
                                        <td style="text-transform: capitalize;"><?php echo $row['mode'] ?></td>
                                        <td style="text-transform: capitalize;"><?php echo $row['bank_name'] ?></td>
                                        <td><?php echo $row['cheque_no'] ?></td>
                                        <td><?php echo $row['deposited_bank_name'] ?></td>
                                        <td><?php echo $row['deposited_bank_branch'] ?></td>
                                        <td style="text-transform: capitalize;"><?php echo ($row['mode'] == 'cash') ? number_format($row['cash_amount']) : number_format($row['amount']); ?></td>
                                        <td><?php echo $row['client_tax'] ?></td>
                                        <td><?php echo $row['govt_tax'] ?></td>
                                        <td><?php
                                            $dateString =  $row['receive_at'];
                                            $formattedDate = date("d F, Y", strtotime($dateString));
                                            echo $formattedDate; // Output: 25 July, 2023
                                            ?></td>
                                        <td><?php
                                            $dateString =  $row['created_at'];
                                            // Remove the time portion and convert to Unix timestamp
                                            $unixTimestamp = strtotime(substr($dateString, 0, 10));

                                            // Format the Unix timestamp as desired
                                            $formattedDate = date("d F, Y", $unixTimestamp);
                                            echo $formattedDate; // Output: 25 July, 2023
                                            ?></td>
                                    <?php
                                }
                                    ?>
                            </tbody>


                    </div>
                </div>
            </div>
        </div>






    </div>
</div>
<?php
include "footlink.php";
?>
<script>
    $(document).ready(function() {
        $("#search").on("click", function() {
            var from = $("#from_date").val() + ' ' + '00:00:00';
            var to = $("#to_date").val() + ' ' + '00:00:00';
            console.log(from + ' ' + to)
            var fromChk = from.trim();
            var toChk = to.trim();
            if(fromChk != '00:00:00' && toChk != '00:00:00'){
                $.ajax({
                    url: "_project.php", // Replace with the actual URL for your search script
                    type: "POST",
                    data: {
                        from: from,
                        to: to
                    },
                    success: function(data) {
                        console.log(data)
                        $("#tbody").html(data)
                    }
    
                })
            }
            else{
                alert("Empty Fields!")
            }
        })


        var receivingId = $("#receivingId").html();
        $.ajax({
            url: "_project.php", // Replace with the actual URL for your search script
            type: "POST",
            data: {
                chart: "chart",
                receivingId: receivingId
            },
            success: function(data) {
                var dataArray = data.split('!'); // Split data into an array
                var dates = dataArray[0].split(','); // Split data[0] (dates) into an array
                dates.pop(); // Removing the last element from the dates array
                var percentage = dataArray[1].split(','); // Split data[1] (percentages) into an array
                percentage.pop(); // Removing the last element from the percentages array
                // Example data for Receivings dataset
                var receivingsDataset = {
                    label: 'Receivings',
                    data: percentage,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                };

                generateChart(dates, receivingsDataset);
            }
        });

    });

    function generateChart(dates, receivingsDataset){
   // Sample data
   var labels = dates;
    var data = {
        labels: labels,
        datasets: [receivingsDataset]
    };

    // Configuration options
    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            scales: {
                x: {
                    display: true,
                },
                y: {
                    beginAtZero: true,
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Line Chart Example'
                }
            }
        },
    };

    // Create the chart
    var lineChart = new Chart(
        document.getElementById('lineChart'),
        config
    );
    }
    generateChart()
  
</script>