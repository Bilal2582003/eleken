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

<div class="page-content">

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Total Banks</h6>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"> Add Bank</button><br><br><br>
                    <div class="table-responsive table-rendered">
                        <!-- <table id="dataTableExample" class="table">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>$320,800</td>
                        <td><div class="dropdown">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Action
	</button>
	<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
		<a class="dropdown-item" href="#">Action</a>
		<a class="dropdown-item" href="#">Another action</a>
		<a class="dropdown-item" href="#">Something else here</a>
	</div>
</div>


</td>
                      </tr>
                     
                    </tbody>
                  </table> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</div>
<?php
include "footer.php";
?>


<!--edit group modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Bank</h5>
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
                <button type="button" class="btn btn-primary" id="updateBank" onclick="updateBank()">Edit</button>
            </div>
        </div>
    </div>
</div>
<!--end group modal-->




<!--add new group -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="houseName" class="col-form-label">Name :</label>
                            <input type="text" name="name" class="form-control" id="name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="houseName" class="col-form-label">Branch :</label>
                            <input type="text" name="branch" class="form-control" id="branch">
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="houseName" class="col-form-label">Head Code :</label>
                            <select class="form-control" id="head_code">
                                <option value="" selected>SELECT</option>
                                <?php
                                $query = "SELECT * from chart_head where acc_type = '10000' and acc_detail_type = '10002' and deleted_at IS NULL";
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="houseName" class="col-form-label">Payment Mode :</label>
                            <select class="form-control" id="payment_mode">
                                <option value="" selected>SELECT</option>
                                <?php
                                $query = "SELECT * from payment_mode where deleted_at IS NULL";
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
                <!-- <div class="col-md-6">
            <div class="form-group">
              <label for="houseBlock" class="col-form-label">Amount :</label>
              <input type="text" name="amount" class="form-control" id="amount">
            </div>
          </div> -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary addNew">Add</button>
            </div>
        </div>
    </div>
</div>
</div>
<!--end group-->




<script>
    function showTable() {
        $(document).ready(function() {
            $.ajax({
                url: "_bank.php",
                type: "POST",
                data: {
                    bankAction: "showTable"
                },
                success: function(data) {
                    //  console.log(data)
                    $(".table-rendered").html(data)
                }
            })
        })
    }
    showTable();


    function editBank(id) {
        // console.log(1)
        var dId = id;
        $(document).ready(function() {
            $.ajax({
                url: "_bank.php",
                type: "POST",
                data: {
                    id: id,
                    bankAction: "fetchModal"
                },
                success: function(data) {
                    // console.log(data)
                    $("#EditModalForm").html(data)
                }
            });
        });

    };


    function updateBank() {
        var editId = document.getElementById("editId").value
        var editname = document.getElementById("editname").value
        var branch = document.getElementById("editBranch").value
        var head_code = document.getElementById("editHeadCode").value
        var payment_mode = document.getElementById("editPaymentMode").value
        // var editproperty = document.getElementById("editproperty").value


        $(document).ready(function() {
            $.ajax({
                url: "_bank.php",
                type: "POST",
                data: {
                    id: editId,
                    name: editname,
                    branch: branch,
                    head_code: head_code,
                    payment_mode: payment_mode,
                    bankAction: "updateBank"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        alert("Updated Bank successfully");
                        showTable();
                        $('#editModal').modal('hide');
                    } else {
                        console.log(data)
                    }
                }
            });
        });
    }



    // delete group
    function deleteBank(id) {
        if (confirm("Do you want to delete!") == true) {
            window.location.assign("_bank.php?id=" + id);
        }
    }





    $(document).ready(function() {
        $(".addNew").on("click", function() {

            var name = $("#name").val();
            var branch = $("#branch").val();
            var head_code = $("#head_code").val();
            var payment_mode = $("#payment_mode").val();

            if (name != '') {
                $.ajax({
                    url: "_bank.php",
                    type: "POST",
                    data: {
                        name: name,
                        branch: branch,
                        head_code: head_code,
                        payment_mode: payment_mode,
                        bankAction: "add"
                    },
                    success: function(data) {
                        console.log(data)
                        if (data == 1) {
                            alert("Added Bank");
                            showTable();
                            $('#addModal').modal('hide');

                            $("#name").val('');
                            $("#branch").val('');
                            $("#property").val('');
                        }
                    }
                });
            } else {
                alert("Some Fields are empty!")
            }

        });
        //   end add new depart

    });
</script>