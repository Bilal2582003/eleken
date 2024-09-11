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
<style>
    .setmodal {
        left: auto !important;
        padding: 0px !important;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to Receiving</h4>
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
                                    <!-- <th>Category</th> -->
                                    <!-- <th>Group</th> -->
                                    <th>Mode</th>
                                    <!-- <th>Client Name</th> -->
                                    <!-- <th>Total Amount</th> -->
                                    <!-- <th>Client Tax</th>
                                <th>Govt Tax</th> -->
                                    <!-- <th>Net Amount</th> -->
                                    <!-- <th>Balance</th> -->
                                    <!-- <th>Total Amount Received</th> -->
                                    <!-- <th>Created</th> -->
                                    <!-- <th>Bank</th> -->
                                    <th>Deposit Bank</th>
                                    <th>
                                        Amount
                                    </th>
                                    <th>
                                        SST/PRA/ICT
                                    </th>
                                    <th>
                                        IT
                                    </th>
                                    <th>
                                        Net Amount
                                    </th>
                                    <th>
                                        Receive At
                                    </th>
                                    <th>
                                        Create At
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'connection.php';
                                $query = "SELECT * from a_receivings order by id desc";
                                $res = mysqli_query($con, $query);
                                while ($row = mysqli_fetch_assoc($res)) { ?>
                                    <tr>
                                        <td><?php echo $row['id'] ?></td>
                                        <td class="text-capitalize" style='white-space: normal;'>
                                            <?php $id = $row['project_id'];
                                            $projectQuery = "Select * from a_project where id = '$id'";
                                            $resProject = mysqli_query($con, $projectQuery);
                                            if (mysqli_num_rows($resProject) > 0) {
                                                $rowProject = mysqli_fetch_assoc($resProject);
                                                echo $rowProject['name'];
                                            } else {
                                                echo "No Record";
                                            }

                                            ?></td>
                                        <td class="text-capitalize"><?php echo $row['mode'] ?></td>
                                        <!-- <td><?php //echo $row['bank_name'] 
                                                    ?></td> -->
                                        <td class="text-capitalize">
                                            <?php $bank = $row['deposited_bank_name'];
                                            $bankQuery = "Select * from bank where id = '$bank'";
                                            $resBank = mysqli_query($con, $bankQuery);
                                            if (mysqli_num_rows($resBank) > 0) {
                                                $rowBank = mysqli_fetch_assoc($resBank);
                                                echo $rowBank['name'];
                                            } else {
                                                echo "No Record";
                                            } ?></td>
                                        <td><?php echo ($row['mode'] == 'cash') ? number_format($row['cash_amount'] == '' ? 0 : $row['cash_amount']) : number_format($row['amount'] == '' ? 0 : $row['amount']) ?></td>
                                        <td><?php echo  number_format($row['client_tax']) ?></td>
                                        <td><?php echo  number_format($row['govt_tax']) ?></td>
                                        <td><?php echo  number_format($row['net_amount']) ?></td>
                                        <td><?php $dateString =  $row['receive_at'];
                                            $formattedDate = date("d F, Y", strtotime($dateString));
                                            echo $formattedDate; // Output: 25 July, 2023 
                                            ?></td>
                                        <td><?php $dateString =  $row['created_at'];
                                            $formattedDate = date("d F, Y", strtotime($dateString));
                                            echo $formattedDate; // Output: 25 July, 2023 
                                            ?></td>
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
                                                        <div class="dropdown-item" data-toggle="modal" data-target="#ReceivingEditModal" onclick="editReceiving(<?php echo $row['id'] ?>)">Edit</div>

                                                        <!-- <div class="dropdown-item" onclick="deleteProject(<?php echo $row['id'] ?>)">Delete</div> -->

                                                        <!-- <div class="dropdown-item"><a href="EditReceivingProject.php?id=<?php echo $row['id'] ?>" style="color:black">Edit Receiving</a>
                                                        </div> -->
                                                        <!-- 
                                                        <div class="dropdown-item" onclick="makePeriodic(<?php echo $row['id'] ?>)" style="color:black">Make Periodic
                                                        </div> -->

                                                        <!-- <div class="dropdown-divider"></div> -->
                                                        <div class="dropdown-item" onclick="DetailReciving(<?php echo $row['id'] ?>)" data-toggle="modal" data-target="#invoiceModal">Invoice</div>

                                                        <div class="dropdown-divider"></div>
                                                        <div class="dropdown-item" onclick="DeleteReciving(<?php echo $row['id'] ?>)">Delete</div>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                    <?php
                                }
                                    ?>
                            </tbody>
                        </table>
                    </div>




                </div>
            </div>
        </div>
    </div>

    <!--start edit Project modal-->
    <div class="modal fade show" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="invoiceModalForm">
                    <div class="row">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Print</button>
                        </div>
                        <div class="col-sm-8">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Send By Email</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary" id="updateProject" onclick="updateProject()">Edit</button> -->
                </div>
            </div>
        </div>
    </div>
    <!--end edit Project modal-->



    <!--Add new Receiving Modal Form-->
    <div class="setmodal modal fade " style="min-width:80%; max-width:80%;" id="receiveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="min-width:100%; max-width:100%;margin:10px auto" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">

                            <div class="form-group col-4">
                                <label for="recipient-name" class="col-form-label">Project:</label>
                                <select class="form-control" name="project_category" id="rp_name">
                                    <?php
                                    $query = "SELECT * FROM a_project";
                                    $result = mysqli_query($con, $query);
                                    while ($row = mysqli_fetch_assoc($result)) { ?>

                                        <option class="text-capitalize" value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="message-text" class="col-form-label">Mode:</label>
                                <select class="form-control" name="mode" id="mode" required>
                                    <option selected disabled> Select Mode</option>
                                    <option value="cash">Cash</option>
                                    <option value="cheque" onclick="changeApp()">Cheque</option>
                                </select>
                            </div>

                            <div id="receving_time_main_div" class="form-group col-4">
                                <label for="recipient-name" class="col-form-label">Receiving Date</label>
                                <input type="date" name="cash" class="form-control" id="receiving_at">
                            </div>

                        </div>

                        <div id="cash_mode_main_div" style="display:none" class="form-group">
                            <label for="message-text" class="col-form-label">Cash Mode:</label>
                            <select class="form-control" name="mode" id="cash_mode" required>
                                <option selected disabled> Select Cash Mode</option>
                                <option value="cash_hand">Cash in hand</option>
                                <option value="cash_bank">Cash in Bank</option>
                            </select>
                        </div>

                        <div id="bank_main_div" style="display:none" class="form-group">
                            <label for="recipient-name" class="col-form-label">Bank:</label>
                            <input type="text" name="bank" class="form-control" id="bank">
                        </div>

                        <div id="cash_main_div" style="display:none" class="form-group">
                            <label for="recipient-name" class="col-form-label">Cash</label>
                            <input type="text" name="cash" class="form-control" id="cash" oninput="formatCurrency(this)">
                        </div>

                        <div class="row">

                            <div id="deposit_bank_main_div" style="display:none" class="form-group col-6">
                                <label for="recipient-name" class="col-form-label">Deposite Bank Name</label>
                                <select class="form-control" id="deposit_bank">
                                    <option value="">Select Bank</option>
                                    <?php
                                    $query = "SELECT  * from bank";
                                    $res = mysqli_query($con, $query);
                                    while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div id="deposit_branch_main_div" style="display:none" class="form-group col-6">
                                <label for="recipient-name" class="col-form-label">Deposit Branch </label>
                                <input type="text" name="cash" class="form-control" id="deposit_branch">
                            </div>

                        </div>

                        <div id="cheque_main_div" style="display:none" class="form-group">
                            <label for="recipient-name" class="col-form-label">Cheque #</label>
                            <input type="text" name="cash" class="form-control" id="cheque">
                        </div>

                        <div class="form-group" id="tax" style="display:none">
                            <!--<label>SST</label><br>-->
                            <!--    <label>-->
                            <!--        <input type="radio" class="client" name="client" value="yes">-->
                            <!--        Yes-->
                            <!--    </label>-->

                            <!--    <label>-->
                            <!--        <input type="radio" class="client" name="client" value="no">-->
                            <!--        No-->
                            <!--    </label>-->

                            <!--    <br><br>-->
                            <!--    <label>IT</label><br>-->
                            <!--    <label>-->
                            <!--        <input type="radio" class="govt" name="govt" value="yes">-->
                            <!--        Yes-->
                            <!--    </label>-->

                            <!--    <label>-->
                            <!--        <input type="radio" class="govt" name="govt" value="no">-->
                            <!--        No-->
                            <!--    </label>-->

                            <div class="row">

                                <div class="form-group col-6">
                                    <label for="client-tax" class="col-form-label">SST/PRA/ICT:</label>
                                    <!--<select disabled class="form-control" name="status" id="client_tax">-->
                                    <!--     Options for client tax -->
                                    <!--    <option selected disabled>Select</option>-->
                                    <!--    <option value="13">13%</option>-->
                                    <!--    <option value="7">7%</option>-->
                                    <!--    <option value="3">3%</option>-->
                                    <!--    <option value="0">0%</option>-->
                                    <!--</select>-->
                                    <input disabled class="form-control" id="client_tax" oninput="formatCurrency(this)">
                                </div>
                                <div style="display:none" class="form-group col-6" id="client_tax_amount_div">
                                    <label for="client-tax" class="col-form-label">SST/PRA/ICT Amount & %:</label>
                                    <input class="form-control" disabled type="text" id="client_tax_amount" >
                                </div>

                            </div>

                            <div class="row">

                                <div class="form-group col-6">
                                    <label for="client-tax-held" class="col-form-label">Client Tax Held:</label>
                                    <input disabled class="form-control" id="client_tax_held" oninput="formatCurrency(this)">
                                    <!-- <select disabled class="form-control" name="status" id="client_tax_held">
                                       <option selected disabled>Select</option>
                                       <option value="10">10%</option>
                                       <option value="20">20%</option>
                                       <option value="30">30%</option>
                                   </select> -->
                                </div>
                                <div style="display:none" class="form-group col-6" id="client_tax_held_amount_div">
                                    <label for="client-tax" class="col-form-label">Tax Held Amount & %:</label>
                                    <input class="form-control" disabled type="text" id="client_tax_held_amount">
                                </div>
                            </div>

                            <div class="row">

                                <div style="display:none" class="form-group col-6" id="govt_tax_main_div">
                                    <label for="govt-tax" class="col-form-label">Income Tax:</label>
                                    <!--<select class="form-control" name="status" id="govt_tax">-->
                                    <!--    <option selected disabled>Select</option>-->
                                    <!--    <option value="10">10%</option>-->
                                    <!--    <option value="7">7%</option>-->
                                    <!--    <option value="3">3%</option>-->
                                    <!--    <option value="0">0%</option>-->
                                    <!--</select>-->
                                    <input disabled class="form-control" id="govt_tax" oninput="formatCurrency(this)">
                                </div>
                                <div style="display:none" class="form-group col-6" id="govt_tax_amount_div">
                                    <label for="client-tax" class="col-form-label">Income Tax Amount & %:</label>
                                    <input class="form-control" disabled type="text" id="govt_tax_amount">
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary addNewPayment">Create</button>
                </div>
            </div>
        </div>
    </div>


    <!--start edit Project modal-->
    <div class="modal fade show" id="ReceivingEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Receiving</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="ReceivingEditModalForm">
                    <!--<form>-->
                    <!--    <div class="form-group">-->
                    <!--        <label for="depart-name" class="col-form-label">Name:</label>-->
                    <!--         <input type="text" name="departName" class="form-control" id="departName">-->
                    <!--    </div>-->

                    <!--</form>-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateReceiving" onclick="updateReceiving()">Edit</button>
                </div>
            </div>
        </div>
    </div>
    <!--end edit Project modal-->



</div>
<?php
include "footer.php";
?>

<script>
    function formatCurrency(input) {
        // Remove existing commas and non-digit characters
        var value = input.value.replace(/,/g, '').replace(/\D/g, '');

        // Format the value with commas
        var formattedValue = Number(value).toLocaleString('en');

        // Update the input value
        input.value = formattedValue;
    }

    function editReceiving(id) {
        // console.log(1)
        var dId = id;
        $(document).ready(function() {
            $.ajax({
                url: "_add_payment.php",
                type: "POST",
                data: {
                    id: id,
                    action: "fetchModal",

                },
                success: function(data) {
                    console.log(data)
                    $("#ReceivingEditModalForm").html(data)
                }
            });
        });

    };

    function updateReceiving(id) {
        // console.log(1)

        $(document).ready(function() {
            var id = $("#editReceivingId").val()
            var project = $("#editProject").val()
            var amount = $("#editReceivingAmount").val()
            var client = document.getElementsByClassName("editclient");
            var govt = document.getElementsByClassName("editgovt");
            var client_tax = client[0].checked ? "yes" : "no"
            var govt_tax = govt[0].checked ? "yes" : "no"
            if (project != null && amount != '') {

                $.ajax({
                    url: "_add_payment.php",
                    type: "POST",
                    data: {
                        id: id,
                        project: project,
                        amount: amount,
                        client_tax: client_tax,
                        govt_tax: govt_tax,
                        action: "updatedReceiving",

                    },
                    success: function(data) {
                        console.log(data)
                        if (data == 1) {
                            alert("Successfully Updated")
                        } else if (data == 2) {
                            alert("Enter correct amount!")
                        } else {
                            alert("Error")
                        }
                    }
                });
            } else {
                alert("Empty Fields")
            }
        });

    };

    $(document).ready(function() {

        $("#mode").on("change", function() {
            var mode = $("#mode").val();
            if (mode == 'cheque') {
                $("#cheque_main_div").show("slow");
                $("#cash_main_div").show("slow");
                $("#govt_tax_main_div").show("slow")
                $("#bank_main_div").show("slow");
                $("#deposit_branch_main_div").show("slow");
                $("#deposit_bank_main_div").show("slow");
                $("#tax").show("slow");
                $("#cash_mode_main_div").hide("slow");
                $("#cash_mode").val('');
            } else if (mode == 'cash') {
                $("#cheque_main_div").hide();
                $("#cheque").val('');

                $("#bank_main_div").hide();
                $("#bank").val('');



                $("#cash_main_div").hide();
                $("#cash").val('');

                $("#cash_mode_main_div").show("slow");
                $("#tax").hide("");
            }
        });

        $("#cash_mode").on("change", function() {
            var mode = $("#cash_mode").val();
            if (mode == 'cash_hand') {
                $("#cash").val('');
                $("#cash_main_div").show("slow");
                $("#govt_tax_main_div").show("slow")
                $("#bank_main_div").hide();
                $("#bank").val('');
                $("#bank_main_div").hide();
                $("#bank").val('');
                $("#deposit_bank_main_div").hide();
                $("#deposit_bank_main_div").val('');
                $("#deposit_branch_main_div").hide();
                $("#deposit_branch_main_div").val('');
                $("#tax").show("slow");

            } else if (mode == 'cash_bank') {
                $("#cash").val('');
                $("#cash_main_div").show("slow");
                $("#govt_tax_main_div").show("slow")
                // $("#bank_main_div").show("slow");
                $("#deposit_bank_main_div").show();
                $("#deposit_bank_main_div").val('');

                $("#deposit_branch_main_div").show();
                $("#deposit_bracnh_main_div").val('');
                $("#tax").show("slow");
            }
        });

        // for enable taxes 
        $("#cash").on("keyup", function() {
            $("#client_tax").prop('disabled', false);
            $("#govt_tax").prop('disabled', false);
        })

        $("#client_tax").on("keyup", function() {
            var tax = $(this).val().replace(/,/g, '');
            var amount = $("#cash").val().replace(/,/g, '');
            var percentAmount = (+tax * +amount) / 100;
            var taxValueInPercentage = percentAmount;
            $("#client_tax_amount").val(percentAmount + ' (' + tax + '%)');
            $("#client_tax_amount_div").show("slow");

            $("#client_tax_held").prop('disabled', false);

            $("#govt_tax").prop('disabled', false);
            $("#govt_tax_main_div").show("slow");
            if ($("#govt_tax").val() != null) {
                // $("#govt_tax").on("change",function(){
                var tax = $("#govt_tax").val().replace(/,/g, '');
                var taxclient = parseInt($("#client_tax").val().replace(/,/g, ''));
                var amount = parseInt($("#cash").val().replace(/,/g, ''));
                var totalamount = ((taxclient * amount) / 100) + amount;

                var percentAmount = (+totalamount * +tax) / 100;
                $("#govt_tax_amount").val(percentAmount + ' (' + tax + '%)');
                $("#govt_tax_amount_div").show("slow");
                // });
            }
        });

        $("#govt_tax").on("keyup", function() {
            var tax = $(this).val().replace(/,/g, '');
            var taxclient = parseInt($("#client_tax").val().replace(/,/g, ''));
            var amount = parseInt($("#cash").val().replace(/,/g, ''));
            var totalamount = ((taxclient * amount) / 100) + amount;

            var percentAmount = (+totalamount * +tax) / 100;
            $("#govt_tax_amount").val(percentAmount + ' (' + tax + '%)');
            $("#govt_tax_amount_div").show("slow");
        });
        $("#client_tax_held").on("keyup", function() {
            var tax = $(this).val().replace(/,/g, '');
            var taxclient = parseInt($("#client_tax").val().replace(/,/g, ''));
            var amount = parseInt($("#cash").val().replace(/,/g, ''));
            var totalamount = ((taxclient * amount) / 100);

            var percentAmount = (+totalamount * +tax) / 100;
            $("#client_tax_held_amount").val(percentAmount + ' (' + tax + '%)');
            $("#client_tax_held_amount_div").show("slow");
        });



        // payment 
        $(".addNewPayment").on('click', function(event) {

            var rp_name = document.getElementById("rp_name").value
            var mode = document.getElementById("mode").value
            var cash = document.getElementById("cash").value.replace(/,/g, '')
            var bank = document.getElementById("bank").value
            var cheque = document.getElementById("cheque").value
            var deposit_branch = document.getElementById("deposit_branch").value
            var deposit_bank = document.getElementById("deposit_bank").value
            var receiving_at = document.getElementById("receiving_at").value
            // var client = document.getElementsByClassName("client");
            // var govt = document.getElementsByClassName("govt");
            var client_tax = document.getElementById("client_tax_amount").value.replace(/,/g, '')
            var govt_tax = document.getElementById("govt_tax_amount").value.replace(/,/g, '')
            var held_tax = document.getElementById("client_tax_held_amount").value.replace(/,/g, '')
            // alert(cash+' '+client_tax+' '+govt_tax+' '+held_tax)
            var confirm = 0;
            if (mode == 'cheque') {
                if (cheque !== '' && bank !== '' && cash !== '') {
                    confirm = 1;
                } else {
                    confirm = 0;
                }
            } else if (mode == 'cash') {
                var cash_mode = document.getElementById("cash_mode").value
                if (cash_mode == 'cash_hand') {
                    if (cash !== '') {
                        confirm = 1;
                    } else {
                        confirm = 0;
                    }
                } else if (cash_mode == 'cash_bank') {
                    if (cash !== '' && deposit_branch !== '' && deposit_bank !== '') {
                        confirm = 1;
                    } else {
                        confirm = 0;
                    }
                }
            } else {
                confirm = 0;
            }

            // if (confirm == 1 && rp_name !== null && mode !== null && receiving_at !== null && (client[0].checked || client[1].checked) && (govt[0].checked || govt[1].checked) ) {
            if (confirm == 1 && rp_name !== null && mode !== null && receiving_at !== null && client_tax !== '' && govt_tax !== '') {
                console.log("Yes")
                // var client_tax= client[0].checked ? "yes" : "no"
                // var govt_tax= govt[0].checked ? "yes" : "no"
                var final_client_tax = client_tax.split(" ");
                var final_govt_tax = govt_tax.split(" ");
                var held_tax = held_tax.split(" ");
                $.ajax({
                    url: "_add_payment.php",
                    type: "POST",
                    data: {
                        rp_name: rp_name,
                        mode: mode,
                        bank: bank,
                        cash: cash,
                        cheque: cheque,
                        deposit_branch: deposit_branch,
                        deposit_bank: deposit_bank,
                        receiving_at: receiving_at,
                        client_tax: final_client_tax[0],
                        govt_tax: final_govt_tax[0],
                        held_tax: held_tax[0],
                        action: 'add'
                    },
                    success: function(data) {
                        console.log(data)
                        if (data == 1) {
                            alert("Successfully Received!")
                            window.location.href = 'Receiving.php'
                        } else if (data == 2) {
                            alert("Enter correct amount!")
                        } else {
                            alert("Request Failed!")
                        }
                    }
                });
            } else {
                alert("Invalid data entered!");
            }

        });


    })

    function changeApp() {
        document.getElementById("click_div").style.display = "inline";
    }
    // delete group
    function DeleteReciving(id) {
        if (confirm("Do you want to delete!") == true) {
            window.location.assign("_add_payment.php?id=" + id);
        }
    }
</script>