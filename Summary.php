<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: index.php');
    exit; // Make sure to exit to prevent further script execution
}

$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];
include 'connection.php';
include "navbar.php";
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to Summary</h4>
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
            <button id="excelImport" type="button" class="btn btn-outline-info btn-icon-text mr-2 d-none d-md-block" data-toggle="modal" data-target="#importModal" data-whatever="@mdo">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download btn-icon-prepend">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                Import
            </button>
            <button type="button" id="printTableData" class="btn btn-outline-primary btn-icon-text mr-2 mb-2 mb-md-0">
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
            <a href="Summary.php" class="btn btn-danger btn-icon-text mb-2 mb-md-0 ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x" width="16" height="16">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
                Clear Filter</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">


                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sp_project">Project:</label>
                                    <select class="form-control" id="sg_project">
                                        <option selected disabled value="">Project</option>
                                        <?php
                                        $query = "SELECT * FROM a_project";
                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <option class="text-capitalize" value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sg_group">Group:</label>
                                    <select class="form-control" id="sg_group">
                                        <option selected disabled value="">Group</option>
                                        <?php
                                        $query = "SELECT * FROM a_group";
                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <option class="text-capitalize" value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sg_category">Category:</label>
                                    <select class="form-control" id="sg_category">
                                        <option selected disabled value="">Category</option>
                                        <?php
                                        $query = "SELECT * FROM a_project_category";
                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <option class="text-capitalize" value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sg_status">Status:</label>
                                    <select class="form-control" id="sg_status">
                                        <option selected disabled value="">Select Status</option>
                                        <option value="Running">Running</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Failed">Failed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sg_date">Date:</label>
                                    <input type="date" id="sg_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sp_client">Client Wise:</label>
                                    <select class="form-control" id="sg_client">
                                        <option selected disabled value="">Client</option>
                                        <?php
                                        $query = "SELECT * FROM a_project group by client_name";
                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <option class="text-capitalize" value="<?php echo $row['client_name']; ?>"><?php echo $row['client_name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">

                                    <button type="button" id="SearchBtn" class="btn btn-primary" style="margin:30px">Search</button>

                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sg_status">Month:</label>
                                    <input type="month" id="monthWise" class="form-control">
                                    <!-- <div class="col-sm-3"> -->
                                    <!-- <div class="form-group"> -->
                                    <!-- <label for="to_date">Search:</label><br> -->
                                    <label style="margin-top:10px">Select Mode</label>
                                    <select class="form-control" id="sg_cashBank">
                                        <option value="">SELECT</option>
                                        <option value="cash">Cash</option>
                                         <option value="cashinbank">Cash Cross / Cheque Cross</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                    <!-- </div> -->
                                    <!-- </div> -->
                                </div>
                            </div>

                            <div class="col-sm-9">
                                <div class="row">

                                    <div style="border-left:2px solid gray ;margin-left:5px;" class="col-sm-4">
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
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <!-- <label for="to_date">Search:</label><br> -->
                                            <button type="button" class="btn btn-primary" style="margin: 30px;" id="searchByFromToDate" width="40px" value="Search">Search</button>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">



                    <div class="row">
                        <div class="col-12 col-xl-12 stretch-card">
                            <div class="row flex-grow">
                                <div class="col-md-4 grid-margin stretch-card">
                                    <div class="card" style="  box-shadow: 0 0 4px rgba(87, 199, 212, 0.5); word-wrap:normal;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h6 class="card-title mb-0">Total Amount</h6>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 col-md-12 col-xl-5 mt-2">
                                                    <h3 style="color:#57c7d4;font-size: 1.40rem;" id="TotalAmountCount">
                                                        2 </h3>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 grid-margin stretch-card">
                                    <div class="card" style="box-shadow: 0 0 4px #10b759;word-wrap:normal;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h6 class="card-title mb-0">Total Received</h6>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 col-md-12 col-xl-5 mt-2">
                                                    <h3 style="color:#10b759;font-size: 1.40rem;" id="TotalReceivedAmountCount">
                                                        2 </h3>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 grid-margin stretch-card">
                                    <div class="card" style="box-shadow: 0 0 4px #ff9999;word-wrap:normal;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h6 class="card-title mb-0">Balance</h6>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 col-md-12 col-xl-5 mt-2">
                                                    <h3 id="BalanceAmountCount" style="color:#e74c3c;font-size: 1.40rem;">
                                                        2 </h3>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <!-- this is for chart  -->
                    <div id="chartDate" style="display:none"></div>
                    <div id="chartPercentage" style="display:none"></div>

                    <div class="row" style="margin-top:50px;">
                        <div class="col-sm-12">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>


                    <h6 class="card-title mt-5">Data Table
                    </h6>
                    <!-- <br> -->
                    <h6 class="card-title mt-5" id="listOfTabel">All
                    </h6>
                    <div class="table-responsive" id="tableBody">
                        <!-- <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th class="th-sm">Id
                                    </th>
                                    <th class="th-sm">Project
                                    </th>
                                    <th class="th-sm">Client Name
                                    </th>
                                    <th class="th-sm">Balance
                                    </th>
                                    <th class="th-sm">Group
                                    </th>
                                    <th class="th-sm">Mode
                                    </th>
                                    <th class="th-sm">Bank
                                    </th>
                                    <th class="th-sm">Amount
                                    </th>
                                    <th class="th-sm">SST
                                    </th>
                                    <th class="th-sm">IT
                                    </th>
                                    <th class="th-sm">Cheque #
                                    </th>
                                    <th class="th-sm">Created
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tableBody"> -->

                        <!-- </tbody> -->
                        <!-- <tfoot id="onChangeFooter">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Total: </b></td>
                                <td><b style="color: Green"></b></td>
                            </tfoot> -->
                        <!-- </table> -->
                    </div>



                    <?php

                    // $dataPoints = array(
                    // array("label"=> "Jan", "y"=> 60.0),
                    // array("label"=> "Feb", "y"=> 6.5),
                    // array("label"=> "Mar", "y"=> 4.6),
                    // array("label"=> "Apr", "y"=> 2.4),
                    // array("label"=> "May", "y"=> 1.9),
                    // array("label"=> "Jun", "y"=> 1.8),
                    // array("label"=> "Jul", "y"=> 1.5),
                    // array("label"=> "Aug", "y"=> 1.5),
                    // array("label"=> "Sep", "y"=> 1.3),
                    // array("label"=> "Aug", "y"=> 0.9),
                    // array("label"=> "Nov", "y"=> 0.8),
                    // array("label"=> "Dec", "y"=> 0.8)
                    // );

                    ?>

                    <!-- <div id="chartContainer" style="height: 370px; width: 100%;"></div> -->
                </div>
            </div>
        </div>
    </div>
    <!--end edit midal category-->

</div>
<div id="importHelper">All</div>
<?php
include "footlink.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<script>
    function generateChart(dates, receivingsDataset) {
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


    $(document).ready(function() {

        function chart() {
            // generateChart()

            var chartDate = $("#chartDate").html()
            var chartDate = chartDate.split(',');
            console.log(chartDate)
            chartDate.pop();

            var chartPercentage = $("#chartPercentage").html()
            var chartPercentage = chartPercentage.split(',');
            chartPercentage.pop();
            var receivingsDataset = {
                label: 'Receivings',
                data: chartPercentage,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
            };
            generateChart(chartDate, receivingsDataset);
        }
        // chart();


        // var receivingId = $("#receivingId").html();
        // $.ajax({
        //     url: "_project.php", // Replace with the actual URL for your search script
        //     type: "POST",
        //     data: {
        //         chart: "chart",
        //         receivingId: receivingId
        //     },
        //     success: function(data) {
        //         var dataArray = data.split('!'); // Split data into an array
        //         var dates = dataArray[0].split(','); // Split data[0] (dates) into an array
        //         dates.pop(); // Removing the last element from the dates array
        //         var percentage = dataArray[1].split(','); // Split data[1] (percentages) into an array
        //         percentage.pop(); // Removing the last element from the percentages array
        //         // Example data for Receivings dataset
        //         var receivingsDataset = {
        //             label: 'Receivings',
        //             data: percentage,
        //             borderColor: 'rgb(75, 192, 192)',
        //             backgroundColor: 'rgba(75, 192, 192, 0.2)',
        //             fill: true,
        //         };

        //         generateChart(dates, receivingsDataset);
        //     }
        // });


        // function for run default 
        function defaultValue() {

            // Get the values from the search fields
            var project = $("#sg_project").val();
            var group = $("#sg_group").val();
            var category = $("#sg_category").val();
            var status = $("#sg_status").val();
            var date = $("#sg_date").val();
            var client = $("#sg_client").val();
            $("#importHelper").val('All');

            // Perform AJAX request
            $.ajax({
                url: "_searchSummary.php", // Replace with the actual URL for your search script
                type: "POST",
                data: {
                    project: project,
                    group: group,
                    category: category,
                    status: status,
                    date: date,
                    client: client
                },
                success: function(data) {
                    // Process the search results returned in 'data' variable
                    // Update the UI with the search results as needed
                    var html = data.split('!');
                    $("#tableBody").html(html[0]);
                    <?php include "assets/js/data-table.js" ?>
                    document.getElementById('TotalReceivedAmountCount').innerHTML = html[1]
                    document.getElementById('TotalAmountCount').innerHTML = html[4]

                    document.getElementById('BalanceAmountCount').innerHTML = html[5]

                    console.log(html[2])
                    console.log(html[3])
                    // console.log(html[4])
                    $("#chartDate").html(html[2])
                    $("#chartPercentage").html(html[3])
                    chart();

                },
                error: function() {
                    alert("Error occurred during the search.");
                }
            });
        }
        defaultValue();

        // Assuming you have a button with the ID 'SearchBtn' that triggers the search

        $("#SearchBtn").click(function() {
            // Get the values from the search fields
            var project = $("#sg_project").val();
            var group = $("#sg_group").val();
            var category = $("#sg_category").val();
            var status = $("#sg_status").val();
            var date = $("#sg_date").val();
            var client = $("#sg_client").val();
            $("#importHelper").val('SearchBtn');

            // Perform AJAX request
            $.ajax({
                url: "_searchSummary.php", // Replace with the actual URL for your search script
                type: "POST",
                data: {
                    project: project,
                    group: group,
                    category: category,
                    status: status,
                    date: date,
                    client: client
                },
                success: function(data) {
                    // Process the search results returned in 'data' variable
                    // Update the UI with the search results as needed
                    var html = data.split('!');
                    $("#tableBody").html(html[0]);
                    <?php include "assets/js/data-table.js" ?>
                    document.getElementById('TotalReceivedAmountCount').innerHTML = html[1]
                    document.getElementById('TotalAmountCount').innerHTML = html[4]

                    document.getElementById('BalanceAmountCount').innerHTML = html[5]

                    console.log(html[2])
                    console.log(html[3])
                    // console.log(html[4])
                    $("#chartDate").html(html[2])
                    $("#chartPercentage").html(html[3])

                    chart();

                },
                error: function() {
                    alert("Error occurred during the search.");
                }
            });
        });




        $("#monthWise").on("change", function() {
            var monthWise = $(this).val();
            $("#importHelper").val('monthWise');
            $.ajax({
                url: "_searchSummary.php", // Replace with the actual URL for your search script
                type: "POST",
                data: {
                    monthWise: monthWise,
                    searchMonthWise: "monthWise"
                },
                success: function(data) {
                    // console.log(1)
                    var html = data.split('!');
                    $("#tableBody").html(html[0]);
                    <?php include "assets/js/data-table.js" ?>
                    document.getElementById('TotalReceivedAmountCount').innerHTML = html[1]
                    document.getElementById('TotalAmountCount').innerHTML = html[4]

                    document.getElementById('BalanceAmountCount').innerHTML = html[5]

                    console.log(html[2])
                    console.log(html[3])
                    // console.log(html[4])
                    $("#chartDate").html(html[2])
                    $("#chartPercentage").html(html[3])
                    chart();
                }
            })
        })
        // Year wise searching 
        $("#searchByFromToDate").on("click", function() {
            // alert("Yes")
            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();
            $("#importHelper").val('searchByFromToDate');
            $.ajax({
                url: "_searchSummary.php", // Replace with the actual URL for your search script
                type: "POST",
                data: {
                    from_date: from_date,
                    to_date: to_date,
                    searchMonthWise: "yearWise"
                },
                success: function(data) {
                    // console.log(1)
                    var html = data.split('!');
                    $("#tableBody").html(html[0]);
                    <?php include "assets/js/data-table.js" ?>
                    document.getElementById('TotalReceivedAmountCount').innerHTML = html[1]
                    document.getElementById('TotalAmountCount').innerHTML = html[4]

                    document.getElementById('BalanceAmountCount').innerHTML = html[5]

                    console.log(html[2])
                    console.log(html[3])
                    // console.log(html[4])
                    $("#chartDate").html(html[2])
                    $("#chartPercentage").html(html[3])
                    chart();
                }
            })
        })
        $("#sg_cashBank").on("change", function() {
            var cashCheque = $(this).val();
            $("#importHelper").val('sg_cashBank');
            $.ajax({
                url: "_searchSummary.php", // Replace with the actual URL for your search script
                type: "POST",
                data: {
                    cashCheque: cashCheque,
                    searchMonthWise: "cashCheque"
                },
                success: function(data) {
                    // console.log(1)
                    var html = data.split('!');
                    $("#tableBody").html(html[0]);
                    <?php include "assets/js/data-table.js" ?>
                    document.getElementById('TotalReceivedAmountCount').innerHTML = html[1]
                    document.getElementById('TotalAmountCount').innerHTML = html[4]

                    document.getElementById('BalanceAmountCount').innerHTML = html[5]

                    console.log(html[2])
                    console.log(html[3])
                    // console.log(html[4])
                    $("#chartDate").html(html[2])
                    $("#chartPercentage").html(html[3])
                    chart();
                }
            })
        })

        $("#excelImport").on("click",function(){
        
            var importHelper = $("#importHelper").val();
            
            if (importHelper == 'All') {
                var project = $("#sg_project").val();
                var group = $("#sg_group").val();
                var category = $("#sg_category").val();
                var status = $("#sg_status").val();
                var date = $("#sg_date").val();
                var client = $("#sg_client").val();
                project = project == null ? '':project
                group = group == null ? '':group
                category = category == null ? '':category
                status = status == null ? '':status
                date = date == null ? '':date
                client = client == null ? '':client

                window.location.assign("_searchSummaryImport.php?project=" + project + "&group=" + group + "&category=" + category + "&status=" + status + "&date=" + date + "&client=" + client)
            } else if (importHelper == 'SearchBtn') {
                var project = $("#sg_project").val();
                var group = $("#sg_group").val();
                var category = $("#sg_category").val();
                var status = $("#sg_status").val();
                var date = $("#sg_date").val();
                var client = $("#sg_client").val();
                project = project == null ? '':project
                group = group == null ? '':group
                category = category == null ? '':category
                status = status == null ? '':status
                date = date == null ? '':date
                client = client == null ? '':client
                window.location.assign("_searchSummaryImport.php?project=" + project + "&group=" + group + "&category=" + category + "&status=" + status + "&date=" + date + "&client=" + client)
            } else if (importHelper == 'monthWise') {
                var monthWise = $(this).val();
                monthWise = monthWise == null ? '':monthWise
                window.location.assign("_searchSummaryImport.php?monthWise=" + monthWise+"&searchMonthWise=monthWise")
            } else if (importHelper == 'searchByFromToDate') {
                var from_date = $("#from_date").val();
                var to_date = $("#to_date").val();

                from_date = from_date == null ? '':from_date
                to_date = to_date == null ? '':to_date

                window.location.assign("_searchSummaryImport.php?from_date=" + from_date + "&to_date=" + to_date+"&searchMonthWise=yearWise")
            } else if (importHelper == 'sg_cashBank') {
                var cashCheque = $(this).val();
                cashCheque = cashCheque == null ? '':cashCheque
                window.location.assign("_searchSummaryImport.php?cashCheque=" + cashCheque+"&searchMonthWise=cashCheque")
            }
        })

    });



    // it is for print 
    document.getElementById('printTableData').addEventListener('click', function() {
        window.print();
    });
</script>