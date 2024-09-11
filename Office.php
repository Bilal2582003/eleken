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
            <h4 class="mb-3 mb-md-0">Welcome to Office</h4>
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
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-toggle="modal" data-target="#officeModal" data-whatever="@mdo">
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
                                    <th>Location</th>
                                    <!-- <th>Category</th> -->
                                    <!-- <th>Group</th> -->
                                   
                                    <th>
                                        Created At
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                 include 'connection.php';
                                $query="SELECT * from office where deleted_at is null order by id desc";
                                $res=mysqli_query($con,$query);
                                while ($row = mysqli_fetch_assoc($res)) { ?>
                                    <tr>
                                        <td><?php echo $row['id'] ?></td>
                                        <td class="text-capitalize"><?php echo $row['location'] ?></td>
                                        <td><?php   
                                        $dateString = $row['created_at'];
                                        // Remove the time portion and convert to Unix timestamp
                                        $unixTimestamp = strtotime(substr($dateString, 0, 10));
                                        
                                        // Format the Unix timestamp as desired
                                        $formattedDate = date("d F, Y", $unixTimestamp);
                                        
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
                                                        <div class="dropdown-item" data-toggle="modal" data-target="#officeEditModal" onclick="editOffice(<?php echo $row['id'] ?>)">Edit</div>

                                                        <div class="dropdown-item" onclick="deleteOffice(<?php echo $row['id'] ?>)">Delete</div>

                                                        <!-- <div class="dropdown-item"><a href="EditReceivingProject.php?id=<?php echo $row['id'] ?>" style="color:black">Edit Receiving</a>
                                                        </div> -->
<!-- 
                                                        <div class="dropdown-item" onclick="makePeriodic(<?php echo $row['id'] ?>)" style="color:black">Make Periodic
                                                        </div> -->

                                                        <!-- <div class="dropdown-divider"></div>
                                                        <div class="dropdown-item" onclick="DetailReciving(<?php echo $row['id'] ?>)"data-toggle="modal" data-target="#invoiceModal"View Details>Invoice</div> -->
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

<!--edit group modal -->
<div class="modal fade" id="officeEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Office</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="officeEditModalForm">
                <!--<form>-->
                <!--    <div class="form-group">-->
                <!--        <label for="depart-name" class="col-form-label">Name:</label>-->
                <!--         <input type="text" name="departName" class="form-control" id="departName">-->
                <!--    </div>-->

                <!--</form>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateOffice" onclick="updateOffice()">Edit</button>
            </div>
        </div>
    </div>
</div>
<!--end group modal-->

<!--add new group -->
<div class="modal fade" id="officeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Office</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="depart-name" class="col-form-label">Location:</label>
                         <input type="text" name="groupName" class="form-control" id="officeLocation">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary addNew">Add</button>
            </div>
        </div>
    </div>
</div>
<!--end group-->


</div>
<?php
include "footer.php";
?>

<script>
 // group data detail fetch in modal
 function editOffice(id){
        // console.log(1)
        var dId=id;
         $(document).ready(function () {
             $.ajax({
        url:"_office.php",
        type:"POST",
        data:{id:id,officeAction:"fetchModal"},
        success:function(data){
            // console.log(data)
            $("#officeEditModalForm").html(data)
        }
        });
        });
        
    };

    function  updateOffice(){
    var editId=document.getElementById("editOfficeId").value;
    var editLocation=document.getElementById("editOfficeLocation").value;

     $(document).ready(function () {
             $.ajax({
        url:"_office.php",
        type:"POST",
        data:{id:editId,location:editLocation,officeAction:"updateOffice"},
        success:function(data){
            // console.log(data)
            if(data == 1){
                window.location.assign("Office.php");
            }else {
                console.log(data)
            }
        }
        });
        });
    
}


   // delete group
   function deleteOffice(id){
         if(confirm("Do you want to delete!") == true){
       window.location.assign("_office.php?id="+id);
        }
    }

    $(document).ready(function(){
           // adding new groups by add new button
      $(".addNew").on("click",function(){
          
          var officeLocation=$("#officeLocation").val(); 
          if(officeLocation != ''){
                 $.ajax({
             url:"_office.php",
             type:"POST",
             data:{location:officeLocation,officeAction:"add"},
             success:function(data){
                 console.log(data)
                 if(data == 1){
                     alert("Added Office");
                     window.location.assign('Office.php')
                 }
             }
          });
          }else{
              alert("Some Fields are empty!")
          }
       
       });
     //   end add new depart
    })
    

</script>