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
            <h4 class="mb-3 mb-md-0">Welcome to General Expense</h4>
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
            <button type="button" id="excelImport" class="btn btn-outline-info btn-icon-text mr-2 d-none d-md-block" data-toggle="modal" data-target="#importModal" data-whatever="@mdo">
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
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-toggle="modal" data-target="#generalExpenseModal" data-whatever="@mdo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus" width="16" height="16">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add New
            </button>
        </div>
    </div>
    Searches Tabs
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">

            <div class="card">
                <div class="card-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="sp_project">Expense Type:</label>
                                <div class="form-group">

                                    <?php
                                    include 'connection.php';

                                    $query1 = "SELECT * from expense_type where deleted_at is null";
                                    $res1 = mysqli_query($con, $query1);

                                    if (mysqli_num_rows($res1) > 0) {
                                        echo '<select class="form-control" id="expenseTypeDropdown"">';
                                        echo '<option selected disabled>Select Expense Type</option>';
                                        echo '<option value="all" >All</option>';
                                        while ($row1 = mysqli_fetch_assoc($res1)) {
                                            echo '<option value="' . $row1['id'] . '">' . $row1['name'] . '</option>';
                                        }
                                        echo '</select>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="sp_project">Month:</label>
                                <div class="form-group">
                                    <input class="form-control" type="month" id="monthWise">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="sp_project">Office:</label>
                                <div class="form-group">
                                    <?php
                                    include 'connection.php';

                                    $query1 = "SELECT * from office where deleted_at is null";
                                    $res1 = mysqli_query($con, $query1);

                                    if (mysqli_num_rows($res1) > 0) {
                                        echo '<select class="form-control" id="officeWise" >';
                                        echo '<option selected disabled>Select Office</option>';
                                        echo '<option value="all" >All</option>';
                                        while ($row1 = mysqli_fetch_assoc($res1)) {
                                            echo '<option value="' . $row1['id'] . '">' . $row1['location'] . '</option>';
                                        }
                                        echo '</select>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-primary" style="margin:30px" id="mixSearch">Search</button>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="sp_project">From:</label>
                                <div class="form-group">
                                    <input class="form-control" type="date" id="fromDate">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="sp_project">To:</label>
                                <div class="form-group">
                                    <input class="form-control" type="date" id="toDate">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-primary" style="margin:30px" id="fromToyearWiseBtn">Search</button>
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
                                <div class="offset-4 col-md-4 grid-margin stretch-card">
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
                            </div>
                        </div>
                    </div>

                    <h6 class="card-title ">Data Table

                        <!-- <button class="btn btn-primary" type="button" >Add new</button> -->

                        <!-- <button class="btn btn-primary" type="button">Import</button> -->
                    </h6>
                    <div class="table-responsive" id="tableBody">
                        <table id="dataTableExample" class="table">
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
                                    <th>Created At
                                    </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sum = 0;
                                include 'connection.php';
                                // $query = "";
                                // if (isset($_GET['type'])) {
                                //     $type = $_GET['type'];
                                //     $query = "SELECT * from general_expense where expense_type_id = $type and deleted_at is null";
                                // } else {
                                //     $query = "SELECT * from general_expense where deleted_at is null";
                                // }

                                // $result = mysqli_query($con, $query);
                                // while ($row = mysqli_fetch_assoc($result)) {
                                //     $expenseTypeId = $row['expense_type_id'];
                                //     $query1 = "SELECT * from expense_type where id =$expenseTypeId and deleted_at is null";
                                //     $res1 = mysqli_query($con, $query1);
                                //     $expense_name = '';
                                //     if (mysqli_num_rows($res1) > 0) {
                                //         $row1 = mysqli_fetch_assoc($res1);
                                //         $expense_name = $row1['name'];
                                //     }
                                //     $sum += (int)$row['amount'];
                                ?>


                                <!-- 
                                    <tr>
                                        <td><?php //echo $row['id'] 
                                            ?></td>
                                        <td class="text-capitalize"><?php //echo $expense_name 
                                                                    ?></td>
                                        <td class="text-capitalize"><?php //echo number_format($row['amount']) 
                                                                    ?></td>
                                        <td class="text-capitalize">

                                            <?php
                                            // $office_id = $row['office_id'];
                                            // $query3 = "SELECT * from office where id = $office_id";
                                            // $res3 = mysqli_query($con, $query3);

                                            // if (mysqli_num_rows($res3) > 0) {
                                            //     $row3 = mysqli_fetch_assoc($res3);
                                            //     echo $row3['location'];
                                            // }
                                            ?>

                                        </td>
                                        <td class="text-capitalize" style="white-space: wrap;"><?php //echo $row['note'] 
                                                                                                ?></td>
                                        <td><?php
                                            // if ($row['expense_date'] && $row['expense_date'] != '') {

                                            //    echo $dateString =  $row['expense_date'];
                                            //     $formattedDate = date("d F, Y", strtotime($dateString));
                                            //     echo $formattedDate; // Output: 25 July, 2023
                                            // }else{
                                            //     echo "-";
                                            // }
                                            ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#editModal" onclick="editGeneralExpense(<?php //echo $row['id'] 
                                                                                                                                                        ?>)">Edit</a>
                                                    <a class="dropdown-item" onclick="deleteGeneralExpense(<?php //echo $row['id'] 
                                                                                                            ?>)">Delete</a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr> -->
                                <?php
                                // }
                                ?>
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <td></td>
                                    <td class="text-success">Total</td>
                                    <td style="border-top: 2px solid green;border-bottom: 2px solid green;"><?php // echo $sum 
                                                                                                            ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot> -->
                        </table>
                    </div>




                </div>
            </div>
        </div>
    </div>


    <!--Add new Expense Modal Form-->
    <div class="modal fade" id="generalExpenseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New General Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="houseName" class="col-form-label">Office :</label>
                                    <select class="js-example-basic-single w-100" id="office">
                                        <option value="" selected>SELECT</option>

                                        <?php
                                        $query3 = "SELECT * from office where deleted_at is null";
                                        $res3 = mysqli_query($con, $query3);

                                        if (mysqli_num_rows($res3) > 0) {
                                            while ($row3 = mysqli_fetch_assoc($res3)) {
                                        ?>

                                                <option value="<?php echo $row3['id']; ?>"><?php echo $row3['location']; ?></option>
                                        <?php

                                            }
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="houseName" class="col-form-label">Expense Type :</label>
                                    <select class="js-example-basic-single w-100" id="expenseType">
                                        <option value="" selected>SELECT</option>
                                        <?php
                                        $query = "SELECT * from expense_type where deleted_at is null ";
                                        $res = mysqli_query($con, $query);
                                        if (mysqli_num_rows($res) > 0) {
                                            while ($row = mysqli_fetch_assoc($res)) {
                                        ?>
                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="houseName" class="col-form-label">Amount :</label>
                                    <input type="text" name="amount" class="form-control" id="amount">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="houseName" class="col-form-label">Note :</label>
                                    <input type="text" name="e_amount" class="form-control" id="note">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="houseName" class="col-form-label">Expense Date :</label>
                                    <input type="date" class="form-control" id="date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Type :</label>
                                    <select class="form-control" id="expType">
                                        <option value="cash" selected>Cash</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row" id="expChequeDiv" style="display:none">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="houseName" class="col-form-label">Cheque No :</label>
                                    <input type="text" class="form-control" id="expCheque">
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary addNewGeneralExpense">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!--add new employee modal start-->


    <!--edit group modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit General Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="EditModalForm">
                    <!--<form>-->
                    <!--    <div class="form-group">-->
                    <!--        <label for="depart-name" class="col-form-label">Name:</label>-->
                    <!--         <input type="text" name="departName" class="form-control" id="departName">-->
                    <!--    </div>-->
                    <!--</form>-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateGeneralExpense" onclick="updateGeneralExpense()">Edit</button>
                </div>
            </div>
        </div>
    </div>
    <!--end group modal-->



</div>
<div style="display: none;" id="importHelper">all</div>
<?php
include "footer.php";
?>
<script>
    function updateURL(selectedValue) {
        // Get the current URL
        var currentURL = window.location.href;

        // Check if the URL already contains a type parameter
        var hasTypeParam = currentURL.indexOf('type=') !== -1;

        if (selectedValue === 'all') {
            // If "All" is selected, remove the type parameter from the URL
            if (hasTypeParam) {
                var newURL = currentURL.replace(/([?&])type=[^&]*(&|$)/, '$1');
                window.location.href = newURL;
            }
        } else {
            // Create the new URL with the selected value as the type parameter
            var newURL;
            if (hasTypeParam) {
                // If the type parameter already exists, replace its value with the selected value
                newURL = currentURL.replace(/type=([^&]*)/, 'type=' + selectedValue);
            } else {
                // If the type parameter doesn't exist, add it to the URL
                newURL = currentURL + (currentURL.indexOf('?') !== -1 ? '&' : '?') + 'type=' + selectedValue;
            }

            // Reload the page with the updated URL
            window.location.href = newURL;
        }
    }
</script>


<script>
    $(document).ready(function() {
        $("#expType").on("click", function() {
            var val = $(this).val();
            if (val == 'cheque') {
                $("#expChequeDiv").show("slow")
            } else {
                $("#expChequeDiv").hide("slow")
            }
        })
        $(document).on("click", "#editexpType", function() {
            var val = $(this).val();
            if (val == 'cheque') {
                $("#editexpChequeDiv").show("slow")
            } else {
                $("#editexpChequeDiv").hide("slow")
                $("#editexpCheque").val("")
            }
        })
        $(".addNewGeneralExpense").click(function(event) {
            var expenseType = document.getElementById("expenseType").value
            var amount = document.getElementById("amount").value
            var note = document.getElementById("note").value
            var office = document.getElementById("office").value
            var date = document.getElementById("date").value
            var expType = document.getElementById("expType").value
            var expCheque = document.getElementById("expCheque").value
            // alert("yes")
            if (office === "") {
                office = 1;
            }

            if (expenseType != '' && amount != '' && note != '') {
                // console.log(name);

                $.ajax({
                    url: "_general_expense.php",
                    type: "POST",
                    data: {
                        expenseType: expenseType,
                        amount: amount,
                        note: note,
                        office: office,
                        date: date,
                        expCheque: expCheque,
                        expType: expType,
                        generalExpenseAction: 'add'
                    },
                    success: function(data) {
                        if (data == 1) {
                            alert("General Expense Added!")
                            window.location.assign('General_Expense.php')
                        }
                    }
                });

            } else {
                alert('Some Fields are empty!')
            }
        });


        function defaultData() {
            var expenseId = 'all';
            $("#importHelper").html('searchExpenseType')
            $.ajax({
                url: "_general_expense.php",
                type: "POST",
                data: {
                    id: expenseId,
                    search: "searchExpenseType"
                },
                success: function(data) {
                    // console.log(data)
                    var html = data.split('!');
                    $("#tableBody").html(html[0]);
                    $("#TotalAmountCount").html(html[1])
                    <?php include "assets/js/data-table.js"; ?>
                    setTimeout(() => {
                        $("#tableBody").find("th").eq(0).trigger("click"); // Corrected from 'triger' to 'trigger'
                    }, 2000);

                }
            });
        }
        defaultData();
        $("#expenseTypeDropdown").on("change", function() {
            var expenseId = $(this).val();
            $("#importHelper").html('searchExpenseType')
            $.ajax({
                url: "_general_expense.php",
                type: "POST",
                data: {
                    id: expenseId,
                    search: "searchExpenseType"
                },
                success: function(data) {
                    // console.log(data)
                    var html = data.split('!');
                    $("#tableBody").html(html[0]);
                    $("#TotalAmountCount").html(html[1])
                    <?php include "assets/js/data-table.js" ?>
                }
            });
        })
        $("#monthWise").on("change", function() {
            var monthWise = $(this).val();
            $("#importHelper").html('monthWise')
            $.ajax({
                url: "_general_expense.php",
                type: "POST",
                data: {
                    monthWise: monthWise,
                    search: "monthWise"
                },
                success: function(data) {
                    // console.log(data)
                    var html = data.split('!');
                    $("#tableBody").html(html[0]);
                    $("#TotalAmountCount").html(html[1])
                    <?php include "assets/js/data-table.js" ?>
                }
            });
        })
        $("#fromToyearWiseBtn").on("click", function() {
            var from = $("#fromDate").val();
            var to = $("#toDate").val();
            $("#importHelper").html('fromToWise')
            $.ajax({
                url: "_general_expense.php",
                type: "POST",
                data: {
                    from: from,
                    to: to,
                    search: "fromToWise"
                },
                success: function(data) {
                    // console.log(data)
                    var html = data.split('!');
                    $("#tableBody").html(html[0]);
                    $("#TotalAmountCount").html(html[1])
                    <?php include "assets/js/data-table.js" ?>
                }
            });
        })
        $("#officeWise").on("change", function() {
            var officeId = $(this).val();
            $("#importHelper").html('officeWise')
            $.ajax({
                url: "_general_expense.php",
                type: "POST",
                data: {
                    officeId: officeId,
                    search: "officeWise"
                },
                success: function(data) {
                    // console.log(data)
                    var html = data.split('!');
                    $("#tableBody").html(html[0]);
                    $("#TotalAmountCount").html(html[1])
                    <?php include "assets/js/data-table.js" ?>
                }
            });
        })



        $("#mixSearch").on("click", function() {
            var officeId = ($("#officeWise").val() == 'all' || $("#officeWise").val() == null) ? '' : $("#officeWise").val();
            var month = $("#monthWise").val() == null ? '' : $("#monthWise").val();
            var expenseTypeDropdown = ($("#expenseTypeDropdown").val() == 'all' || $("#expenseTypeDropdown").val() == null) ? '' : $("#expenseTypeDropdown").val();
            // alert(officeId+' '+month+' '+expenseTypeDropdown )
            $.ajax({
                url: "_general_expense.php",
                type: "POST",
                data: {
                    officeId: officeId,
                    month: month,
                    exp: expenseTypeDropdown,
                    search: "mixSearch"
                },
                success: function(data) {
                    // console.log(data)
                    var html = data.split('!');
                    $("#tableBody").html(html[0]);
                    $("#TotalAmountCount").html(html[1])
                    <?php include "assets/js/data-table.js" ?>
                }
            });
        })

        $("#excelImport").on("click", function() {
            var importHelper = $("#importHelper").html();
            if (importHelper == 'searchExpenseType') {
                var expenseId = $("#expenseTypeDropdown").val();
                expenseId = expenseId == null ? 'all' : expenseId
                window.location.assign("_general_expense_import.php?search=" + importHelper + "&id=" + expenseId)
            } else if (importHelper == 'monthWise') {
                var monthWise = $("#monthWise").val();
                monthWise = monthWise == null ? '' : monthWise
                window.location.assign("_general_expense_import.php?search=" + importHelper + "&monthWise=" + monthWise)
            } else if (importHelper == 'fromToWise') {
                var from = $("#fromDate").val();
                var to = $("#toDate").val();
                from = from == null ? '' : from
                to = to == null ? '' : to
                window.location.assign("_general_expense_import.php?search=" + importHelper + "&from=" + from + "&to=" + to)
            } else if (importHelper == 'officeWise') {
                var officeId = $("#officeWise").val();
                officeId = officeId == null ? 'all' : officeId
                window.location.assign("_general_expense_import.php?search=" + importHelper + "&officeId=" + officeId)
            } else if (importHelper == 'mixSearch') {
                var officeId = ($("#officeWise").val() == 'all' || $("#officeWise").val() == null) ? '' : $("#officeWise").val();
                var month = $("#monthWise").val() == null ? '' : $("#monthWise").val();
                var expenseTypeDropdown = ($("#expenseTypeDropdown").val() == 'all' || $("#expenseTypeDropdown").val() == null) ? '' : $("#expenseTypeDropdown").val();
                window.location.assign("_general_expense_import.php?search=" + importHelper + "&officeId=" + officeId + "&month=" + month + "&exp=" + expenseTypeDropdown)

            }

        })

    })

    function editGeneralExpense(id) {
        // console.log(1)
        var dId = id;
        $(document).ready(function() {
            $.ajax({
                url: "_general_expense.php",
                type: "POST",
                data: {
                    id: id,
                    generalExpenseAction: "fetchModal"
                },
                success: function(data) {
                    // console.log(data)
                    $("#EditModalForm").html(data)
                }
            });
        });

    };


    function updateGeneralExpense() {
        var editId = document.getElementById("editId").value
        var editExpenseType = document.getElementById("editExpenseType").value
        var editAmount = document.getElementById("editAmount").value
        var editNote = document.getElementById("editNote").value
        var editOffice = document.getElementById("editOffice").value
        var editDate = document.getElementById("editDate").value
        var expType = document.getElementById("editexpType").value
        var expCheque = document.getElementById("editexpCheque").value
        $(document).ready(function() {
            $.ajax({
                url: "_general_expense.php",
                type: "POST",
                data: {
                    id: editId,
                    editExpenseType: editExpenseType,
                    editAmount: editAmount,
                    editNote: editNote,
                    editOffice: editOffice,
                    editDate: editDate,
                    expCheque: expCheque,
                    expType: expType,
                    generalExpenseAction: "updateGeneralExpense"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        alert("Updated General Expense successfully");
                        window.location.assign('General_Expense.php')
                        // $('#editModal').modal('hide');
                    } else {
                        console.log(data)
                    }
                }
            });
        });
    }



    // delete group
    function deleteGeneralExpense(id) {
        if (confirm("Do you want to delete!") == true) {
            window.location.assign("_general_expense.php?id=" + id);
        }
    }
</script>