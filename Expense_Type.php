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
            <h4 class="mb-3 mb-md-0">Welcome to Expense Type</h4>
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
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-toggle="modal" data-target="#expenseTypeModal" data-whatever="@mdo">
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
                                <th >Id
                                </th>
                                <th >Name
                                </th>
                                <th >Created At
                                </th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            include 'connection.php';
                            $query = "SELECT  * from expense_type where deleted_at is null";
                            $result = mysqli_query($con,$query);
                            while($row = mysqli_fetch_assoc($result)){?>
                                <tr>
                                    <td><?php echo $row['id']?></td>
                                    <td class="text-capitalize"><?php echo $row['name']?></td>
                                    <td><?php  $dateString =  $row['created_at'];
                                            $formattedDate = date("d F, Y", strtotime($dateString));
                                            echo $formattedDate; // Output: 25 July, 2023?></td>
                                            <td>
                                                 <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item"  data-toggle="modal" data-target="#editModal" onclick="editExpenseType(<?php echo $row['id'] ?>)">Edit</a>
                  <a class="dropdown-item"  onclick="deleteExpenseType(<?php echo $row['id'] ?>)">Delete</a>
                 
                </div>
              </div>
                                            </td>
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
    

<!--Add new Expense Modal Form-->
<div class="modal fade" id="expenseTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Expense Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>

                    <div class="form-group">
                        <label for="e_event" class="col-form-label">Name</label>
                        <input type="text" name="e_event" class="form-control" id="name">
                    </div>

                    <!--<div class="form-group">-->
                    <!--    <label for="e_amount" class="col-form-label">Amount</label>-->
                    <!--    <input type="number" name="e_amount" class="form-control" id="e_amount">-->
                    <!--</div>-->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary addNewExpenseType">Add</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Expense Type</h5>
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
        <button type="button" class="btn btn-primary" id="updateExpenseType" onclick="updateExpenseType()">Edit</button>
      </div>
    </div>
  </div>
</div>
<!--end group modal-->



</div>
<?php
include "footer.php";
?>

<script>
$(document).ready(function(){
    $(".addNewExpenseType").click(function(event) {
            var name = document.getElementById("name").value
            if(name != '' ){
                console.log(name);

                $.ajax({
                    url : "_expense_type.php",
                    type : "POST",
                    data:{name:name,expenseTypeAction:'add'},
                    success : function(data){
                        if(data == 1){
                            alert("Expense Type Added!")
                            window.location.assign('Expense_Type.php')
                        }
                    }
                });

            }else{
                alert('Some Fields are empty!')
            }
        });
})

function editExpenseType(id) {
    // console.log(1)
    var dId = id;
    $(document).ready(function() {
      $.ajax({
        url: "_expense_type.php",
        type: "POST",
        data: {
          id: id,
          expenseTypeAction: "fetchModal"
        },
        success: function(data) {
          // console.log(data)
          $("#EditModalForm").html(data)
        }
      });
    });

  };


  function updateExpenseType() {
    var editId = document.getElementById("editId").value
    var editname = document.getElementById("editname").value


    $(document).ready(function() {
      $.ajax({
        url: "_expense_type.php",
        type: "POST",
        data: {
          id: editId,
          name: editname,
          expenseTypeAction: "updateExpenseType"
        },
        success: function(data) {
          // console.log(data)
          if (data == 1) {
            alert("Updated Expense Type successfully");
            window.location.assign('Expense_Type.php')
            // $('#editModal').modal('hide');
          } else {
            console.log(data)
          }
        }
      });
    });
  }



  // delete group
  function deleteExpenseType(id) {
    if (confirm("Do you want to delete!") == true) {
      window.location.assign("_expense_type.php?id=" + id);
    }
  }

</script>