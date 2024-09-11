<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['id'])) {
    header('Location: index.php');
    exit; // Make sure to exit to prevent further script execution
}

$admin_email = $_SESSION['email'];
$admin_id = $_SESSION['id'];

include "navbar.php";
include 'connection.php';

$admin_email = $_SESSION['email'];
$id = $_GET['id'];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div class="page-content">

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Table</h6>
                    <div class="table-responsive">
                  <table id="dataTableExample" class="table">
                   <thead>
                            <tr>
                            <th>Id</th>
                        <th>Project Name</th>
                        <th>Cash Amount</th>
                        <th>Amount</th>
                        <th>SST</th>
                        <th>IT</th>
                        <th>Created At</th>
                        <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="orderTableBody_admin_action">

                    <?php
                  
                    $query = "SELECT a_receivings.id as id,
            a_receivings.amount as amount,
            a_receivings.cash_amount as cash_amount,
            a_receivings.created_at as created_at,
            a_receivings.client_tax as client_tax,
            a_receivings.govt_tax as govt_tax,
            a_project.name as project_name,
            a_project.id as project_id
            FROM a_receivings
            JOIN a_project ON a_receivings.project_id = a_project.id
            WHERE a_receivings.project_id = '$id'";

                    $res = mysqli_query($con, $query);
$output='';
                    if (mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $amount=0;
                            $cash_amount=0;
                            $projectId = $row['project_id'];

                            $queryProject = "SELECT * FROM a_project WHERE id != '$projectId'";
                            $resProject = mysqli_query($con, $queryProject);
                            $option = '<select class="adminEditableFields" disabled><option value="' . $row["project_id"] . '">' . $row["project_name"] . '</option>';
                            while ($rowProject = mysqli_fetch_assoc($resProject)) {
                                $option .= '<option value="' . $rowProject["id"] . '">' . $rowProject["name"] . '</option>';
                            }
                            $option .= "</select>";

                            if(!empty($row['cash_amount'] ) && $row['cash_amount'] > 0){
                                $cash_amount=$row['cash_amount'] +$row['client_tax'] + $row['govt_tax']; 
                            }
                             if(!empty($row['amount'] ) && $row['amount'] > 0){
                                $amount = $row['amount']+ $row['client_tax'] + $row['govt_tax']; 
                            }
                            
                            $output .= '<tr>
                    <td><input type="text" disabled value="' . $row["id"] . '" /></td>
                    <td>' . $option . '</td>
                    <td><input type="text" class="adminEditableFields" disabled value="' . $cash_amount . '" /></td>
                    <td><input type="text" class="adminEditableFields" disabled value="' . $amount . '" /></td>
                    
                    <td>
                    <select id="editclient"  class="adminEditableFields" disabled>
                    <option>Yes</option>
                    <option selected>No</option>
                    </select>
                    </td>
                    
                    <td>
                    <select id="editgovt" class="adminEditableFields" disabled>
                    <option >Yes</option>
                    <option selected>No</option>
                    </select>
                    </td>

                    <td><input type="text"  disabled value="' . $row["created_at"] . '" /></td>
                    <td><button class="adminModalEditBtn" onclick="adminModalEditBtnToggler(this)" style="font-size:16px;color:blue;">EDIT</button></td>
                </tr>';
                        }
                        $output .= '</tbody></table></div>';
                    } else {
                        $output .= '<tr><td colspan="6">No Record Found!</td></tr></tbody></table></div>';
                    }

                    echo $output;

                    ?>

                </div>




            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
<script>

function adminModalEditBtnToggler(btn) {
  let adminEditableFields = document.getElementsByClassName(
    "adminEditableFields"
  );
  if (btn.innerHTML == "EDIT") {
    for (let i = 0; i < adminEditableFields.length; i++) {
      adminEditableFields[i].disabled = false;
      adminEditableFields[i].style.borderBottom = "2px solid #ddd";
    }
    btn.innerHTML = "SAVE";
    btn.className = "adminModalEditBtn";
  } else {
    for (let i = 0; i < adminEditableFields.length; i++) {
      adminEditableFields[i].disabled = true;
      adminEditableFields[i].style.borderBottom = "none";
    }
    btn.innerHTML = "EDIT";
    btn.className += " updateProjectReceiving";
  }
}

$(document).ready(function(){
    // edit receiving 
$(document).on("click",".updateProjectReceiving",function(){
    var id=$(this).parent().parent().children("td").eq(0).find("input").val();
    var ProjectName=$(this).parent().parent().children("td").eq(1).find("select").val();
    var cashAmount=$(this).parent().parent().children("td").eq(2).find("input").val();
    var amount=$(this).parent().parent().children("td").eq(3).find("input").val();
    var client=$("#editclient").val();
    var govt=$("#editgovt").val();

    console.log(ProjectName);
    if(ProjectName !== '' && cashAmount !== '' && amount !== ''){
          $.ajax({
                  url:"_project.php",
                  type:"POST",
                  data:{id:id,ProjectName:ProjectName,cashAmount:cashAmount,amount:amount,client:client,govt:govt,projectAction:"updateProjectReceiving"},
                  success:function(data){
                      console.log(data)
                      if(data == 1){
                          alert("Added Project Receiving");
                          window.location.href = 'project.php'
                      }
                      else{
                          alert("Something went wrong!");
                      }
                  }
                
    });
    }
    else{
        alert("Some fields are Empty!")
    }
 
});
})

</script>