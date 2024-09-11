<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: index.php');
    exit; // Make sure to exit to prevent further script execution
}

$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];
?>
<?php
include "navbar.php";
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to Admin Dashboard</h4>
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
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-toggle="modal" data-target="#projectModal" data-whatever="@mdo">
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
                                    <th>Project Fees</th>
                                    <th>Received Amount</th>
                                    <th>Balance Amount</th>
                                    <!-- <th>Category</th> -->
                                    <!-- <th>Group</th> -->
                                    <th>Current Status</th>
                                    <!-- <th>Client Name</th> -->
                                    <!-- <th>Total Amount</th> -->
                                    <!-- <th>Client Tax</th>
                                <th>Govt Tax</th> -->
                                    <!-- <th>Net Amount</th> -->
                                    <!-- <th>Balance</th> -->
                                    <!-- <th>Total Amount Received</th> -->
                                    <!-- <th>Created</th> -->
                                    <th>Status Action</th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                include 'connection.php';
                                $query = "SELECT * FROM a_project order by created_at desc";
                                $result = mysqli_query($con, $query);
                                while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td>
                                            <a href="detailProject.php?id=<?php echo $row['id'] ?>" style="color:black;text-transform: capitalize;">
                                                <?php echo $row['id'] ?>
                                            </a>
                                        </td>
                                        <td style='white-space: normal;'>
                                            <a href="detailProject.php?id=<?php echo $row['id'] ?>" style="color:black;text-transform: capitalize;">
                                                <?php echo $row['name'] ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="detailProject.php?id=<?php echo $row['id'] ?>" style="color:black;text-transform: capitalize;">
                                                <?php echo number_format($row['client_amount']) ?>
                                            </a>
                                        </td>

                                        <td><?php
                                            $id = $row['id'];
                                            $query1 = "SELECT SUM(amount) as amount , SUM(cash_amount) as cash_amount , SUM(client_tax) as client_tax , Sum(govt_tax) as govt_tax FROM a_receivings where project_id = $id";
                                            $result1 = mysqli_query($con, $query1);
                                            if (mysqli_num_rows($result1) > 0) {
                                                $totalAmountReceived = 0;
                                                while ($row1 = mysqli_fetch_assoc($result1)) {
                                                    $totalAmountReceived += $row1['amount'] + $row1['cash_amount'] + $row1['client_tax'] + $row1['govt_tax'];
                                                }
                                                if ($row['client_amount'] > 0) {
                                                    $perc = ((int)$totalAmountReceived / (int)$row['client_amount']) * 100;
                                                    echo number_format($totalAmountReceived) . " (" . (int)$perc . "%)";
                                                } else {
                                                    echo number_format($totalAmountReceived) . " (" . 0 . "%)";
                                                }
                                            } else {
                                                echo "Not yet received";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $get_project_id = $row['id'];
                                            $myquery = "SELECT (SELECT client_amount FROM a_project where id = '$get_project_id') as client_amount, SUM(amount) as amount , SUM(cash_amount) as cash_amount , SUM(client_tax) as client_tax , Sum(govt_tax) as govt_tax FROM `a_receivings` WHERE project_id = '$get_project_id'";
                                            $myRes = mysqli_query($con, $myquery);
                                            $balanceAmount = 0;
                                            if (mysqli_num_rows($myRes) > 0) {
                                                while ($row1 = mysqli_fetch_assoc($myRes)) {
                                                    $balanceAmount = $row1['client_amount'] - $row1['amount'] - $row1['cash_amount'] - $row1['client_tax'] - $row1['govt_tax'];
                                                }

                                                if ($balanceAmount > 0) {
                                                    echo number_format($balanceAmount);
                                                } else {
                                                    echo number_format($row['net_amount']);
                                                }
                                            } else {
                                                echo "Not yet received";
                                            }
                                            ?>
                                        </td>

                                        <td><?php echo $row['status'] ?></td>


                                        <!-- balance  -->
                                        <!-- <td><?php
                                                    // $get_project_id=$row['id'];
                                                    // $myquery="SELECT ((SELECT net_amount FROM a_project where id = '$get_project_id') -SUM(cash_amount)+SUM(amount) ) as total    FROM `a_receivings` WHERE project_id = '$get_project_id'";
                                                    // $myRes=mysqli_query($con,$myquery);
                                                    // if(mysqli_num_rows($myRes) > 0){
                                                    //         $row1 = mysqli_fetch_assoc($myRes);

                                                    //         echo $row1['total'];
                                                    //     }else{
                                                    //         echo "Not yet received";
                                                    //     }
                                                    ?>
        </td> -->

                                        <!-- Total amount Received  -->
                                        <!-- <td> -->
                                        <?php
                                        // $id = $row['id'];
                                        // $query1 = "SELECT SUM(cash_amount)+SUM(amount) as total FROM a_receivings where project_id = $id";
                                        // $result1 = mysqli_query($con,$query1);
                                        // if(mysqli_num_rows($result1) > 0){
                                        //     $row1 = mysqli_fetch_assoc($result1);
                                        //     $perc = ((int)$row1['total'] / (int)$row['net_amount'])*100;
                                        //     echo $row1['total']." (".(int)$perc."%)";
                                        // }else{
                                        //     echo "Not yet received";
                                        // }
                                        ?>
                                        <!-- </td> -->
                                        <td>
                                            <select id="status" class="form-control changeStatusModalShow">
                                                <option selected disabled>Change Status</option>
                                                <option value="Running<?php echo "," . $row['id'] ?>">Running</option>
                                                <option value="Completed<?php echo "," . $row['id'] ?>">Completed</option>
                                                <option value="Failed<?php echo "," . $row['id'] ?>">Failed</option>
                                            </select>
                                        </td>
                                        <td style="padding:auto">
                                            <div class="container mt-4">
                                                <div class="dropdown">
                                                    <!-- Action button -->
                                                    <button class="btn btn-primary dropdown-toggle" type="button" id="actionDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <!-- Dropdown menu -->
                                                    <div class="dropdown-menu" aria-labelledby="actionDropdown">
                                                        <!-- Dropdown items -->
                                                        <div class="dropdown-item" data-toggle="modal" data-target="#projectEditModal" onclick="editProject(<?php echo $row['id'] ?>)">Edit</div>

                                                        <div class="dropdown-item" onclick="deleteProject(<?php echo $row['id'] ?>)">Delete</div>

                                                        <div class="dropdown-item"><a href="EditReceivingProject.php?id=<?php echo $row['id'] ?>" style="color:black">Edit Receiving</a>
                                                        </div>

                                                        <div class="dropdown-item" onclick="makePeriodic(<?php echo $row['id'] ?>)" style="color:black">Make Periodic
                                                        </div>

                                                        <div class="dropdown-divider"></div>
                                                        <div class="dropdown-item" onclick="DetailProject(<?php echo $row['id'] ?>)"><a href="detailProject.php?id=<?php echo $row['id'] ?>" style="color:black">View Details</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- <td>
                                            <i class="fas fa-trash" style="font-size:20px;color:red ;margin:5px" onclick="deleteProject(<?php echo $row['id'] ?>)"></i>
                                            <i class="fas fa-pencil-alt" style="font-size:20px;color:navy;margin:5px" data-toggle="modal" data-target="#projectEditModal" onclick="editProject(<?php echo $row['id'] ?>)"></i>
                                            <a href="EditReceivingProject.php?id=<?php echo $row['id'] ?>"> <i class="fas fa-money-bill" style="font-size:20px;color:navy;margin:5px;color:green" onclick="editProjectReceiving()"></i></a>
                                        </td> -->
                                    </tr>
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
    <div class="modal fade show" id="projectEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="projectEditModalForm">
                    <!--<form>-->
                    <!--    <div class="form-group">-->
                    <!--        <label for="depart-name" class="col-form-label">Name:</label>-->
                    <!--         <input type="text" name="departName" class="form-control" id="departName">-->
                    <!--    </div>-->

                    <!--</form>-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateProject" onclick="updateProject()">Edit</button>
                </div>
            </div>
        </div>
    </div>
    <!--end edit Project modal-->


    <!--start Status Change Project modal-->
    <div class="modal fade show" id="projectStatusChangeRemark" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Status Remarks</h5>
                    <button type="button" class="close" onclick="close_modal()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="projectStatusChangeRemarkForm">

                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">Remarks:</label>
                        <textarea class="form-control" id="StatusRemarks"></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="close_modal()" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary " onclick="updateStatus()">Edit</button>
                </div>
            </div>
        </div>
    </div>
    <!--end edit Project modal-->





    <!--Add new Project Modal Form-->
    <div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Category:</label>
                                    <select class="form-control" name="project_category" id="project_category">
                                        <!-- Options for project category -->
                                        <?php
                                        $query = "SELECT * FROM a_project_category";
                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Project Name:</label>
                                    <input type="text" name="name" class="form-control" id="project_name">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Status:</label>
                                    <select class="form-control" name="status" id="project_status">
                                        <!-- Options for project status -->
                                        <option selected disabled>Select</option>
                                        <option value="Running">Running</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Failed">Failed</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="client-name" class="col-form-label">Client Name:</label>
                                    <input type="text" name="client_amount" class="form-control" id="client_name">
                                </div>
                                <div class="form-group">
                                    <label for="engineer" class="col-form-label">Engineer:</label>
                                    <select class="form-control" name="engineer" id="project_engineer">
                                        <?php
                                        $query = "SELECT * FROM engineer";
                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client-amount" class="col-form-label">Project Fees:</label>
                                    <input type="number" name="client_amount" class="form-control" id="client_amount">
                                </div>
                                <!--<div class="form-group">-->
                                <!--    <label for="client-tax" class="col-form-label">S.S.T.:</label>-->
                                <!--    <select disabled class="form-control" name="status" id="client_tax">-->
                                <!-- Options for client tax -->
                                <!--        <option selected disabled>Select</option>-->
                                <!--        <option value="13">13%</option>-->
                                <!--        <option value="7">7%</option>-->
                                <!--        <option value="3">3%</option>-->
                                <!--    </select>-->
                                <!--</div>-->
                                <!--<div style="display:none" class="form-group" id="client_tax_amount_div">-->
                                <!--    <input class="form-control" disabled type="text" id="client_tax_amount">-->
                                <!--</div>-->
                                <!--<div class="form-group">-->
                                <!--    <label for="client-tax-held" class="col-form-label">Client Tax Held:</label>-->
                                <!--    <select disabled class="form-control" name="status" id="client_tax_held">-->
                                <!-- Options for client tax held -->
                                <!--        <option selected disabled>Select</option>-->
                                <!--        <option value="10">10%</option>-->
                                <!--        <option value="20">20%</option>-->
                                <!--        <option value="30">30%</option>-->
                                <!--    </select>-->
                                <!--</div>-->
                                <!--<div style="display:none" class="form-group" id="client_tax_held_amount_div">-->
                                <!--    <input class="form-control" disabled type="text" id="client_tax_held_amount">-->
                                <!--</div>-->
                                <!--<div style="display:none" class="form-group" id="govt_tax_main_div">-->
                                <!--    <label for="govt-tax" class="col-form-label">Income Tax:</label>-->
                                <!--    <select class="form-control" name="status" id="govt_tax">-->
                                <!--        <option selected disabled>Select</option>-->
                                <!--        <option value="10">10%</option>-->
                                <!--        <option value="7">7%</option>-->
                                <!--        <option value="3">3%</option>-->
                                <!-- Options for govt tax -->
                                <!--    </select>-->
                                <!--</div>-->
                                <!--<div style="display:none" class="form-group" id="govt_tax_amount_div">-->
                                <!--    <input class="form-control" disabled type="text" id="govt_tax_amount">-->
                                <!--</div>-->
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Assign to:</label>
                                    <select class="form-control" id="project_assign">
                                        <!-- Options for project assignment -->
                                        <?php
                                        $query = "SELECT * FROM a_group";
                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                            ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Service:</label>
                                    <select class="form-control" id="project_service">
                                        <!-- Options for project assignment -->
                                        <?php
                                        $query = "SELECT * FROM a_project_service";
                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                            ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="houseName" class="col-form-label">Chart Head Code :</label>
                                    <select class="js-example-basic-single w-100 chart_head_codeClass" id="chart_head_code">
                                        <option value="" selected>SELECT</option>
                                        <?php
                                        $query = "SELECT * from chart_head where deleted_at IS NULL and ACC_DETAIL_TYPE = 40004";
                                        $res = mysqli_query($con, $query);
                                        if (mysqli_num_rows($res) > 0) {
                                            while ($row = mysqli_fetch_assoc($res)) {
                                        ?>
                                                <option value="<?php echo $row['HEAD_CODE'] ?>"><?php echo $row['HEAD_DESC'] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="houseName" class="col-form-label">Chart Detail :</label>
                                    <select class="js-example-basic-single w-100 chart_detail_codeClass" id="chart_detail_code">
                                        <option value="" selected>SELECT</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary addNewProject">Create</button>
                </div>
            </div>
        </div>
    </div>


    <!--Import Project Modal Form-->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="_import_project.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="projectImportfile">Choose File:</label>
                            <input type="file" name="file" id="projectImportfile" class="form-control">
                        </div>
                        <div class="form-group">
                            <a class="btn btn-primary" href="hXZGGf.xls" download>Download Sample</a>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Add" name="Import" />
                </div>
                </form>

            </div>
        </div>
    </div>





</div>
<?php
include "footer.php";
?>
<script>
    //fetch edit depart modal
    function editProject(id) {
        console.log(1)
        var dId = id;
        $(document).ready(function() {
            $.ajax({
                url: "_project.php",
                type: "POST",
                data: {
                    id: id,
                    projectAction: "fetchModal"
                },
                success: function(data) {
                    // console.log(data)
                    $("#projectEditModalForm").html(data)
                }
            });
        });

    };

    function makePeriodic(id) {
        if (confirm("Do you want to make Periodic this project?")) {
            $(document).ready(function() {
                $.ajax({
                    url: "_project.php",
                    type: "POST",
                    data: {
                        id: id,
                        makePeriodic: "makePeriodic"
                    },
                    success: function(data) {
                        // console.log(data)
                        if (data === '1') {
                            alert("Successfully Made Periodic");
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

    // delete project
    function deleteProject(id) {
        if (confirm("Do you want to delete!") == true) {
            window.location.assign("_delete_project.php?id=" + id);
        }
    }

    $(document).ready(function() {


        $(document).on("change",".chart_head_codeClass", function() {
            var head_code = $(this).val();
            $.ajax({
                url: '_project.php',
                type: 'POST',
                data: {
                    chart_head_code: head_code,
                    projectAction: 'getChartHead'
                },
                success: function(response) {
                    console.log(response)
                    $(".chart_detail_codeClass").html(response);
                },
                error: function() {
                    alert("There was an error processing your request.");
                }
            });
        });




        $(".addNewProject").click(function(event) {
            var project_category = document.getElementById("project_category").value
            var name = document.getElementById("project_name").value
            var status = document.getElementById("project_status").value
            var project_assign = document.getElementById("project_assign").value
            var client_name = document.getElementById("client_name").value
            var client_amount = document.getElementById("client_amount").value
            // var client_tax = document.getElementById("client_tax_amount").value
            // var govt_tax = document.getElementById("govt_tax_amount").value
            var project_service = document.getElementById("project_service").value
            // var held = document.getElementById("client_tax_held_amount").value !== '' ? document.getElementById("client_tax_held_amount").value : 'null';
            var engineer = document.getElementById("project_engineer").value !== '' ? document.getElementById("project_engineer").value : 'null';
            var chart_head_code = document.getElementById('chart_head_code').value;
            var chart_detail_code = document.getElementById('chart_detail_code').value;
            // if (held !== 'null') {
            //     var held = held.split("(");
            //     var held = parseInt(held[0]);
            // }
            // var final_client_tax = client_tax.split(" ");
            // var final_govt_tax = govt_tax.split(" ");

            // console.log(project_category, name, status, project_assign, client_name, client_amount, final_client_tax, final_govt_tax)

            if (project_category != null && name !== '' && status != null && project_assign != null &&
                client_name !== '' && client_amount !== '' && project_service != null) {


                $.ajax({
                    url: "_add_project.php",
                    type: "POST",
                    data: {
                        project_name: name,
                        category: project_category,
                        status: status,
                        project_assign: project_assign,
                        client_name: client_name,
                        client_amount: client_amount,
                        // client_tax: final_client_tax[0],
                        // govt_tax: final_govt_tax[0],
                        // held: held,
                        engineer: engineer,
                        project_service: project_service,
                        chart_head_code: chart_head_code,
                        chart_detail_code: chart_detail_code
                    },
                    success: function(data) {
                        console.log(data)
                        if (data == 1) {
                            alert("Successfully Added!")
                            window.location.assign('project.php')
                        }
                    }
                });
            } else {
                alert("Invalid Input!")
            }
        });


        // $("#client_amount").on("keyup", function() {
        //     $("#client_tax").prop('disabled', false);
        // })

        $("#client_tax").on("change", function() {
            var tax = $(this).val();
            var amount = $("#client_amount").val();
            var percentAmount = (+tax * +amount) / 100;
            var taxValueInPercentage = percentAmount;
            $("#client_tax_amount").val(percentAmount + ' (' + tax + '%)');
            $("#client_tax_amount_div").show("slow");

            $("#client_tax_held").prop('disabled', false);


            $("#govt_tax_main_div").show("slow");
            if ($("#govt_tax").val() != null) {
                // $("#govt_tax").on("change",function(){
                var tax = $("#govt_tax").val();
                var taxclient = parseInt($("#client_tax").val());
                var amount = parseInt($("#client_amount").val());
                var totalamount = ((taxclient * amount) / 100) + amount;

                var percentAmount = (+totalamount * +tax) / 100;
                $("#govt_tax_amount").val(percentAmount + ' (' + tax + '%)');
                $("#govt_tax_amount_div").show("slow");
                // });
            }
        });

        $("#client_tax_held").on("change", function() {
            var tax = $(this).val();
            var taxclient = $("#client_tax_amount").val();
            // var amount=$("#client_tax").val();
            var split = taxclient.split("(");
            // console.log()
            var splitTaxValue = parseInt(split[0]);
            var totalamount = ((splitTaxValue * tax) / 100);
            //   $("#client_tax_held_amount_div").show("slow");

            $("#client_tax_held_amount").val(totalamount + ' (' + tax + '%)');
            $("#client_tax_held_amount_div").show("slow");
        })

        $("#govt_tax").on("change", function() {
            var tax = $(this).val();
            var taxclient = parseInt($("#client_tax").val());
            var amount = parseInt($("#client_amount").val());
            var totalamount = ((taxclient * amount) / 100) + amount;

            var percentAmount = (+totalamount * +tax) / 100;
            $("#govt_tax_amount").val(percentAmount + ' (' + tax + '%)');
            $("#govt_tax_amount_div").show("slow");
        });


        // for edit purpose 
        $(document).on("change", "#edit_client_tax", function() {
            var tax = $(this).val();
            var amount = $("#edit_client_amount").val();
            var percentAmount = (+tax * +amount) / 100;
            var taxValueInPercentage = percentAmount;
            $("#edit_client_tax_amount").val(percentAmount + ' (' + tax + '%)');
            $("#edit_client_tax_amount_div").show("slow");

            $("#edit_client_tax_held").prop('disabled', false);


            $("#edit_govt_tax_main_div").show("slow");
            if ($("#edit_govt_tax").val() != null) {
                // $("#govt_tax").on("change",function(){
                var tax = $("#edit_govt_tax").val();
                var taxclient = parseInt($("#edit_client_tax").val());
                var amount = parseInt($("#edit_client_amount").val());
                var totalamount = ((taxclient * amount) / 100) + amount;

                var percentAmount = (+totalamount * +tax) / 100;
                $("#edit_govt_tax_amount").val(percentAmount + ' (' + tax + '%)');
                $("#edit_govt_tax_amount_div").show("slow");
                // });
            }
        });

        $(document).on("change", "#edit_client_tax_held", function() {
            var tax = $(this).val();
            var taxclient = $("#edit_client_tax_amount").val();
            // var amount=$("#client_tax").val();
            var split = taxclient.split("(");
            // console.log()
            var splitTaxValue = parseInt(split[0]);
            var totalamount = ((splitTaxValue * tax) / 100);
            //   $("#client_tax_held_amount_div").show("slow");

            $("#edit_client_tax_held_amount").val(totalamount + ' (' + tax + '%)');
            $("#edit_client_tax_held_amount_div").show("slow");
        })

        $(document).on("change", "#edit_govt_tax", function() {
            var tax = $(this).val();
            var taxclient = parseInt($("#edit_client_tax").val());
            var amount = parseInt($("#edit_client_amount").val());
            var totalamount = ((taxclient * amount) / 100) + amount;

            var percentAmount = (+totalamount * +tax) / 100;
            $("#edit_govt_tax_amount").val(percentAmount + ' (' + tax + '%)');
            $("#edit_govt_tax_amount_div").show("slow");
        });
        // edit purpose end


        $(".changeStatusModalShow").on('change', function() {
            $("#projectStatusChangeRemark").show();
        })

        // $(".changeStatus").on('change', function(event) {

        //     var status = $(this).val()
        //     status = status.split(",")
        //     console.log("Change Status", status[0], status[1])

        //     $.ajax({
        //         url: "_update_status.php",
        //         type: "POST",
        //         data: {
        //             id: status[1],
        //             status: status[0]
        //         },
        //         success: function(data) {
        //             if (data == 1) {
        //                 alert("Successfully Updated!")
        //                 window.location.assign('project.php')
        //             }
        //         }
        //     });
        // })





    })

    function close_modal() {
        $("#projectStatusChangeRemark").hide();
    }

    function updateStatus() {
        $(document).ready(function() {
            var remarks = $("#StatusRemarks").val();
            console.log(remarks)
            var status = $('#status').val()
            status = status.split(",")
            // console.log("Change Status", status[0], status[1])
            if (remarks != '') {

                $.ajax({
                    url: "_update_status.php",
                    type: "POST",
                    data: {
                        id: status[1],
                        status: status[0],
                        remarks: remarks
                    },
                    success: function(data) {
                        console.log(data)
                        if (data == 1) {
                            alert("Successfully Updated!")
                            window.location.assign('project.php')
                        }
                    }
                });
            } else {
                alert("Enter Remarks Plese")
            }
        })
    }

    // edit Project Details
    function updateProject() {
        $(document).ready(function() {


            //  console.log(id)
            var editProjectCategory = document.getElementById("editProjectCategory").value
            var editProjectName = document.getElementById("editProjectName").value
            var editProjectID = document.getElementById("editProjectID").value
            var editProjectGroup = document.getElementById("editProjectGroup").value
            var edit_client_name = document.getElementById("edit_client_name").value
            var edit_client_amount = document.getElementById("edit_client_amount").value
            var edit_client_tax_amount = document.getElementById("edit_client_tax_amount").value
            var edit_govt_tax_amount = document.getElementById("edit_govt_tax_amount").value
            var editProjectStage = document.getElementById("editProjectStage").value
            var editProjectService = document.getElementById("editProjectService").value
            var chart_head_code = document.getElementById('editchart_head_code').value;
            var chart_detail_code = document.getElementById('editchart_detail_code').value;
            var held = document.getElementById("edit_client_tax_held_amount").value !== '' ? document.getElementById("edit_client_tax_held_amount").value : 'null';
            var engineer = document.getElementById("editProjectEngineer").value !== '' ? document.getElementById("editProjectEngineer").value : 'null';
            if (held !== 'null') {
                var held = held.split("(");
                var held = parseInt(held[0]);
            } else {
                var held = 0;
            }
            var final_client_tax = edit_client_tax_amount.split(" ");
            var final_govt_tax = edit_govt_tax_amount.split(" ");

            // console.log('cat ',editProjectCategory,' name ',editProjectName, ' ID ',editProjectID, ' Group ' ,editProjectGroup, ' Client name ' ,edit_client_name, ' client_amount ' ,edit_client_amount, 'client_tax_amount ',final_client_tax,' govt tax ',final_govt_tax)

            if (editProjectCategory != null && editProjectName !== '' && editProjectID != '' && editProjectGroup != null &&
                edit_client_name !== '' && edit_client_amount !== '' && final_govt_tax != '' && editProjectService != null) {


                $.ajax({
                    url: "_project.php",
                    type: "POST",
                    data: {
                        editProjectName: editProjectName,
                        editProjectCategory: editProjectCategory,
                        editProjectID: editProjectID,
                        editProjectGroup: editProjectGroup,
                        edit_client_name: edit_client_name,
                        edit_client_amount: edit_client_amount,
                        client_tax: final_client_tax[0],
                        govt_tax: final_govt_tax[0],
                        held: held,
                        engineer: engineer,
                        editProjectStage: editProjectStage,
                        editProjectService: editProjectService,
                        chart_head_code: chart_head_code,
                        chart_detail_code: chart_detail_code,
                        projectAction: 'updateProject'
                    },
                    success: function(data) {
                        console.log(data)
                        if (data == 1) {
                            alert("Successfully Edited!")
                            window.location.assign('project.php')
                        }
                    }
                });
            } else {
                alert("Invalid Input!")
            }
        })
    };

    // end edit project details
</script>