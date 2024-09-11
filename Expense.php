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
            <h4 class="mb-3 mb-md-0">Welcome to Expense</h4>
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
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-toggle="modal" data-target="#expenseModal" data-whatever="@mdo">
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
                                <th >Project
                                </th>
                                <th >Group
                                </th>
                                <th >Event
                                </th>
                                <th >Amount
                                </th>
                                <th >Created
                                </th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            include 'connection.php';
                            $query = "SELECT  a_project.*,a_project.name as p_name,a_group.*,a_group.name as g_name,a_expenses.* FROM a_expenses JOIN a_project ON a_project.id = a_expenses.project_id JOIN a_group ON a_group.id = a_expenses.group_id";
                            $result = mysqli_query($con,$query);
                            while($row = mysqli_fetch_assoc($result)){?>
                                <tr>
                                    <td><?php echo $row['id']?></td>
                                    <td class="text-capitalize" style='white-space: normal;' ><?php echo $row['p_name']?></td>
                                    <td class="text-capitalize"><?php echo $row['g_name']?></td>
                                    <td class="text-capitalize"><?php echo $row['event']?></td>
                                    <td><?php echo $row['amount']?></td>
                                    <td><?php  $dateString =  $row['created_at'];
                                            $formattedDate = date("d F, Y", strtotime($dateString));
                                            echo $formattedDate; // Output: 25 July, 2023?></td>
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
<div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ep_name" class="col-form-label">Project:</label>
                                <select class="form-control" name="project_category" id="ep_name">
                                    <?php
                                    $query = "SELECT * FROM a_project";
                                    $result = mysqli_query($con,$query);
                                    while($row = mysqli_fetch_assoc($result)){?>
                                        ?>
                                        <option class="text-capitalize" value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="eg_name" class="col-form-label">Category:</label>
                                <select class="form-control" name="project_category" id="eg_name">
                                    <?php
                                    $query = "SELECT * FROM a_group";
                                    $result = mysqli_query($con,$query);
                                    while($row = mysqli_fetch_assoc($result)){?>
                                        ?>
                                        <option class="text-capitalize" value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="e_event" class="col-form-label">Event</label>
                        <input type="text" name="e_event" class="form-control" id="e_event">
                    </div>

                    <div class="form-group">
                        <label for="e_amount" class="col-form-label">Amount</label>
                        <input type="number" name="e_amount" class="form-control" id="e_amount">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary addNewExpense">Add</button>
            </div>
        </div>
    </div>
</div>
 <!--add new employee modal start-->




</div>
<?php
include "footer.php";
?>

<script>
$(document).ready(function(){
    $(".addNewExpense").click(function(event) {
            var ep_name = document.getElementById("ep_name").value
            var eg_name = document.getElementById("eg_name").value
            var e_event = document.getElementById("e_event").value
            var e_amount = document.getElementById("e_amount").value



            if(ep_name != '' && eg_name != '' && e_event != '' && e_amount != ''){
                console.log(ep_name,eg_name,e_event,e_amount);

                $.ajax({
                    url : "_add_expense.php",
                    type : "POST",
                    data:{ep_name:ep_name,eg_name:eg_name,e_event:e_event,e_amount:e_amount},
                    success : function(data){
                        if(data == 1){
                            alert("Expense Added!")
                            window.location.href = 'Expense.php'
                        }
                    }
                });

            }else{
                alert('Some Fields are empty!')
            }
        });
})

</script>