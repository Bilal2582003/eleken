<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: index.php');
    exit; // Make sure to exit to prevent further script execution
}

$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];
include "navbar.php";
include "connection.php";

?>
<style>
    .setmodal {
        left: auto !important;
        padding: 0px !important;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<style>
    .border {
        border: 1px solid gray;
        /* padding:2px; */
    }

    .disable {
        background-color: lightgray;
        border-radius: 4px;
        padding: 3px;
    }

    table {
        text-align: center;
    }

    .desTd {
        text-align: left !important;
    }

    tr:nth-child(even) {
        background-color: lightgray;
    }

    tr th {
        background-color: black;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }

    .tabs {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        background-color: #333;
    }

    .tab {
        flex: 1;
        padding: 15px;
        text-align: center;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s;
        border-left: 1px solid gray;
    }

    .tab:hover {
        background-color: #555;
    }

    .tab-content {
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .tab-pane {
        display: none;
    }

    .tabs .tab.active-tab {
        background-color: #555;
        color: #fff;
    }

    .activerow {
        background-color: #333 !important;
        color: #fff;
    }

    .activerow1 {
        background-color: #333 !important;
        color: #fff;
    }

    #RevenuefirstAddform,
    #RevenueSecondAddform,
    #AssetfirstAddform,
    #AssetSecondAddform,
    #LibfirstAddform,
    #LibSecondAddform,
    #CapfirstAddform,
    #CapSecondAddform,
    #ExpfirstAddform,
    #ExpSecondAddform {
        display: none;
    }

    .display-block {
        display: flex !important;
    }

    .red {
        color: red
    }

    .success {
        color: green
    }
</style>

<div class="page-content">

    <ul class="tabs">
        <!-- <li class="tab" data-tab="assets">Assets</li>
        <li class="tab" data-tab="liabilities">Liabilities</li>
        <li class="tab" data-tab="capital">Capital</li>
        <li class="tab" data-tab="revenue">Revenue</li>
        <li class="tab" data-tab="expenses">Expenses</li> -->
        <?php
        $query = "SELECT * from account_types where deleted_at is null";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<li class='tab' data-tab='" . $row['DESCRIPTION'] . "'>" . $row['DESCRIPTION'] . "<span class='TopTab' style='display:none'>" . $row['ACCOUNT_TYPE'] . "</span></li>";
            }
        }
        ?>
    </ul>

    <div class="tab-content">
        <div class="tab-pane" id="Assets">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div style="height: 200px;overflow-y: scroll;overflow-x:hidden">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h4>Nature</h4>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="offset-1 card col-sm-5 mr-1" style="border:1px solid black;">
                                        <div class="card-body row">
                                            <div class="col-sm-2 text-center p-0" style="margin: auto 10px;">
                                                <h6>Head:</h6>
                                            </div>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="AssetFirstTbody">

                                                </select>
                                            </div>
                                            <div class="col-sm-1 p-0" style="margin: auto;">
                                                <img src="assets/images/menu.png" width="50%" height="50%" data-toggle="modal" data-target="#AssetFirstModal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card col-sm-5" style="border:1px solid black">
                                        <div class="card-body row">
                                            <div class="col-sm-3 text-center p-0" style="margin: auto 10px;">
                                                <h6>Asset:</h6>
                                            </div>
                                            <div class="col-sm-7">
                                                <select class="form-control" id="AssetSecondTbody">

                                                </select>
                                            </div>
                                            <div class="col-sm-1 p-0" style="margin: auto;">
                                                <img src="assets/images/menu.png" width="50%" height="50%" data-toggle="modal" data-target="#AssetSecondModal" id="assetSecondDotImage">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row table-responsive " style="height: 200px;overflow-y: scroll;">
                                <h4>Account Codes</h4>
                                <br>
                                <table width="100%" border="1" id="dataTableExample5" class="table">
                                    <thead>
                                        <tr>
                                            <th style="color:white">Sno</th>
                                            <th style="color:white">Chart Acc Code</th>
                                            <th style="color:white">Chart Acc Desc</th>
                                            <th style="color:white">Status</th>
                                            <th style="color:white">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="assetThirdTbody">

                                    </tbody>
                                </table>
                            </div>
                            <div style="display:flex;justify-content:flex-end; align-items:flex-end; margin:10px">
                                <button class="btn btn-success" id="assetThirdAddOpenModal" data-toggle="modal" data-target="#AssetThirdModal" disabled>Add New</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="tab-pane" id="Liabilities">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div style="height: 200px;overflow-y: scroll;overflow-x:hidden">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h4>Nature</h4>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="offset-1 card col-sm-5 mr-1" style="border:1px solid black;">
                                        <div class="card-body row">
                                            <div class="col-sm-2 text-center p-0" style="margin: auto 10px;">
                                                <h6>Head:</h6>
                                            </div>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="LibFirstTbody">

                                                </select>
                                            </div>
                                            <div class="col-sm-1 p-0" style="margin: auto;">
                                                <img src="assets/images/menu.png" width="50%" height="50%" data-toggle="modal" data-target="#LibFirstModal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card col-sm-5" style="border:1px solid black">
                                        <div class="card-body row">
                                            <div class="col-sm-3 text-center p-0" style="margin: auto 10px;">
                                                <h6>Liability:</h6>
                                            </div>
                                            <div class="col-sm-7">
                                                <select class="form-control" id="LibSecondTbody">

                                                </select>
                                            </div>
                                            <div class="col-sm-1 p-0" style="margin: auto;">
                                                <img src="assets/images/menu.png" width="50%" height="50%" data-toggle="modal" data-target="#LibSecondModal" id="libSecondDotImage">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row table-responsive " style="height: 200px;overflow-y: scroll;">
                                <h4>Account Codes</h4>
                                <br>
                                <table width="100%" border="1" id="dataTableExample5" class="table">
                                    <thead>
                                        <tr>
                                            <th style="color:white">Sno</th>
                                            <th style="color:white">Chart Acc Code</th>
                                            <th style="color:white">Chart Acc Desc</th>
                                            <th style="color:white">Status</th>
                                            <th style="color:white">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="libThirdTbody">

                                    </tbody>
                                </table>
                            </div>
                            <div style="display:flex;justify-content:flex-end; align-items:flex-end; margin:10px">
                                <button class="btn btn-success" id="libThirdAddOpenModal" data-toggle="modal" data-target="#LibThirdModal" disabled>Add New</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="tab-pane" id="Capital">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div style="height: 200px;overflow-y: scroll;overflow-x:hidden">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h4>Nature</h4>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="offset-1 card col-sm-5 mr-1" style="border:1px solid black;">
                                        <div class="card-body row">
                                            <div class="col-sm-2 text-center p-0" style="margin: auto 10px;">
                                                <h6>Head:</h6>
                                            </div>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="CapFirstTbody">

                                                </select>
                                            </div>
                                            <div class="col-sm-1 p-0" style="margin: auto;">
                                                <img src="assets/images/menu.png" width="50%" height="50%" data-toggle="modal" data-target="#CapFirstModal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card col-sm-5" style="border:1px solid black">
                                        <div class="card-body row">
                                            <div class="col-sm-3 text-center p-0" style="margin: auto 10px;">
                                                <h6>Capital:</h6>
                                            </div>
                                            <div class="col-sm-7">
                                                <select class="form-control" id="CapSecondTbody">

                                                </select>
                                            </div>
                                            <div class="col-sm-1 p-0" style="margin: auto;">
                                                <img src="assets/images/menu.png" width="50%" height="50%" data-toggle="modal" data-target="#CapSecondModal" id="capSecondDotImage">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row table-responsive " style="height: 200px;overflow-y: scroll;">
                                <h4>Account Codes</h4>
                                <br>
                                <table width="100%" border="1" id="dataTableExample5" class="table">
                                    <thead>
                                        <tr>
                                            <th style="color:white">Sno</th>
                                            <th style="color:white">Chart Acc Code</th>
                                            <th style="color:white">Chart Acc Desc</th>
                                            <th style="color:white">Status</th>
                                            <th style="color:white">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="capThirdTbody">

                                    </tbody>
                                </table>
                            </div>
                            <div style="display:flex;justify-content:flex-end; align-items:flex-end; margin:10px">
                                <button class="btn btn-success" id="capThirdAddOpenModal" data-toggle="modal" data-target="#CapThirdModal" disabled>Add New</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="tab-pane" id="Revenue">
            <div class="row ">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div style="height: 200px;overflow-y: scroll;overflow-x:hidden">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h4>Nature</h4>
                                    </div>
                                    <!-- <div class="col-sm-5">
                                        <button style="margin:2px 94%;width:max-content" class="col-sm-4 btn btn-primary" id="libFirstAdd" data-toggle="modal" data-target="#libFirstModal">Add New</button>
                                    </div> -->
                                </div>
                                <br>
                                <div class="row">
                                    <div class="offset-1 card col-sm-5 mr-1" style="border:1px solid black;">
                                        <div class="card-body row">
                                            <div class="col-sm-2 text-center p-0" style="margin: auto 10px;">
                                                <h6>Head:</h6>
                                            </div>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="RevenueFirstTbody">

                                                </select>
                                            </div>
                                            <div class="col-sm-1 p-0" style="margin: auto;">
                                                <img src="assets/images/menu.png" width="50%" height="50%" data-toggle="modal" data-target="#RevenueFirstModal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card col-sm-5" style="border:1px solid black">
                                        <div class="card-body row">
                                            <div class="col-sm-3 text-center p-0" style="margin: auto 10px;">
                                                <h6>Revenue:</h6>
                                            </div>
                                            <div class="col-sm-7">
                                                <select class="form-control" id="RevenueSecondTbody">

                                                </select>
                                            </div>
                                            <div class="col-sm-1 p-0" style="margin: auto;">
                                                <img src="assets/images/menu.png" width="50%" height="50%" data-toggle="modal" data-target="#RevenueSecondModal" id="revenueSecondDotImage">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <!-- <div class="row ">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row table-responsive" id="towerSection" style="height: 200px;overflow-y: scroll;display:none;">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h4>Revenue</h4>
                                    </div>
                                    <div class="col-sm-5">
                                        <button style="margin:2px 94%;width:max-content" class="col-sm-4 btn btn-primary" id="libSecondTableAdd">Add New</button>
                                    </div>
                                </div>
                                <br>
                                <table width="100%" border="1" id="dataTableExample4" class="table">
                                    <thead>
                                        <tr>
                                            <th style="color:white">Sno</th>
                                            <th style="color:white">Head Code</th>
                                            <th style="color:white">Head Desc</th>
                                        </tr>
                                    </thead>
                                    <tbody id="revenueTower">
                                      

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="row ">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row table-responsive " style="height: 200px;overflow-y: scroll;">
                                <h4>Account Codes</h4>
                                <br>
                                <table width="100%" border="1" id="dataTableExample5" class="table">
                                    <thead>
                                        <tr>
                                            <th style="color:white">Sno</th>
                                            <th style="color:white">Chart Acc Code</th>
                                            <th style="color:white">Chart Acc Desc</th>
                                            <th style="color:white">Asset Code</th>
                                            <th style="color:white">Status</th>
                                            <th style="color:white">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="revenueThirdTbody">

                                    </tbody>
                                </table>
                            </div>
                            <div style="display:flex;justify-content:flex-end; align-items:flex-end; margin:10px">
                                <button class="btn btn-success" id="revenueThirdAddOpenModal" data-toggle="modal" data-target="#RevenueThirdModal" disabled>Add New</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="tab-pane" id="Expenses">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div style="height: 200px;overflow-y: scroll;overflow-x:hidden">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h4>Nature</h4>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="offset-1 card col-sm-5 mr-1" style="border:1px solid black;">
                                        <div class="card-body row">
                                            <div class="col-sm-2 text-center p-0" style="margin: auto 10px;">
                                                <h6>Head:</h6>
                                            </div>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="ExpFirstTbody">

                                                </select>
                                            </div>
                                            <div class="col-sm-1 p-0" style="margin: auto;">
                                                <img src="assets/images/menu.png" width="50%" height="50%" data-toggle="modal" data-target="#ExpFirstModal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card col-sm-5" style="border:1px solid black">
                                        <div class="card-body row">
                                            <div class="col-sm-3 text-center p-0" style="margin: auto 10px;">
                                                <h6>Expense:</h6>
                                            </div>
                                            <div class="col-sm-7">
                                                <select class="form-control" id="ExpSecondTbody">

                                                </select>
                                            </div>
                                            <div class="col-sm-1 p-0" style="margin: auto;">
                                                <img src="assets/images/menu.png" width="50%" height="50%" data-toggle="modal" data-target="#ExpSecondModal" id="expSecondDotImage">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row table-responsive " style="height: 200px;overflow-y: scroll;">
                                <h4>Account Codes</h4>
                                <br>
                                <table width="100%" border="1" id="dataTableExample5" class="table">
                                    <thead>
                                        <tr>
                                            <th style="color:white">Sno</th>
                                            <th style="color:white">Chart Acc Code</th>
                                            <th style="color:white">Chart Acc Desc</th>
                                            <th style="color:white">Status</th>
                                            <th style="color:white">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="expThirdTbody">

                                    </tbody>
                                </table>
                            </div>
                            <div style="display:flex;justify-content:flex-end; align-items:flex-end; margin:10px">
                                <button class="btn btn-success" id="expThirdAddOpenModal" data-toggle="modal" data-target="#ExpThirdModal" disabled>Add New</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div style="display: none;" id="revenueFirstSelectId"></div>
<div style="display: none;" id="assetFirstSelectId"></div>
<div style="display: none;" id="libFirstSelectId"></div>
<div style="display: none;" id="capFirstSelectId"></div>
<div style="display: none;" id="expFirstSelectId"></div>

<?php include "footer.php"; ?>

<?php include("cofAssetForms.php"); ?>
<?php include("cofRevenueForms.php"); ?>
<?php include("cofLibForms.php"); ?>
<?php include("cofCapForms.php"); ?>
<?php include("cofExpForms.php"); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
$(document).ready(function() { 
    $(".e1").select2(); 
});
</script>
<script>
    // Function to initialize DataTables on a specific table
    $(document).ready(function(){
        function initializeDataTable(tableId) {
            // $(`#${tableId}`).DataTable();
            // alert("yes")
        }
        
        
        
        // Switch tabs and initialize DataTables accordingly
        $('.tab').on('click', function() {
        // Remove the 'active-tab' class from all tabs
        $('.tab').removeClass('active-tab');

        var tabId = $(this).data('tab');

        // Hide all tab content
        $('.tab-pane').hide();

        // Show the selected tab content
        $(`#${tabId}`).show();

        // Initialize DataTables for the selected tab
        switch (tabId) {
            case 'Assets':
                initializeDataTable('assetsTable');
                break;
            case 'Liabilities':
                initializeDataTable('liabilitiesTable');
                break;
            case 'Expenses':
                initializeDataTable('expensesTable');
                break;
            case 'Capital':
                initializeDataTable('capitalTable');
                break;
            case 'Revenue':
                initializeDataTable('revenueTable');
                break;
        }

        $(this).addClass('active-tab');

        if (tabId == 'Assets') {
            assetFirstTbodyShow();
            AssetFirstModalTable();
        } else if (tabId == 'Liabilities') {
            libFirstTbodyShow();
            LibFirstModalTable();
        } else if (tabId == 'Expenses') {
            expFirstTbodyShow();
            ExpFirstModalTable();
        } else if (tabId == 'Capital') {
            capFirstTbodyShow();
            CapFirstModalTable();
        } else if (tabId == 'Revenue') {
            revenueFirstTbodyShow();
            RevenueFirstModalTable();
        }
    });

    // Initial setup: show the default tab and initialize DataTables
    $('.tab:first').trigger('click');
})
</script>