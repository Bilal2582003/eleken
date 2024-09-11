<!-- first cap  -->
<div class="modal fade" id="CapFirstModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:80% !important ">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Capital Nature</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="offset-1 col-sm-10 table-responsive" style="height: 500px;">
                        <div class="row">
                            <div class="col-sm-6">
                                <button class="col-sm-4 btn btn-primary" onclick="CapFirsttoggleAddForm()">Add New</button>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row" style="margin:auto;" id="CapfirstAddform">
                            <div class="col-md-8" style="margin:10px auto">
                                <div class="form-group d-flex">
                                    <label for="CapNatureName" class="mr-2">Name:</label>
                                    <input type="text" style="width: 80%;" name="name" class="form-control" id="CapFirstNatureName">
                                </div>
                            </div>
                            <div class="col-md-3" style="margin:10px auto">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" id="CapFirstAddNew">Add</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div style="height:300px;overflow-y: scroll;">
                            <table width="100%" border="1" class="table">
                                <thead>
                                    <tr>
                                        <th style="color:white">Sno</th>
                                        <th style="color:white">Head Code</th>
                                        <th style="color:white">Head Desc</th>
                                        <th style="color:white">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="capFirstModalTableBody">
                                    <?php
                                    // $query = "SELECT * from capital where deleted_at is null";
                                    // $res = mysqli_query($con, $query);
                                    // if ($row = mysqli_num_rows($res) > 0) {
                                    //     $sno = 0;
                                    //     while ($row = mysqli_fetch_assoc($res)) {
                                    //         $sno++;
                                    //         echo "<tr>
                                    //         <td>" . $sno . "</td>
                                    //         <td class='firstCapId'>" . $row['id'] . "</td>
                                    //         <td><input type='text' value='" . $row['name'] . "' disabled class='firstCapName form-control'></td>
                                    //         <td><button class='firstCapEdit btn btn-success'>Edit</button>
                                    //         <button class='btn btn-danger firstCapDelete'>Delete</button></td>
                                    //         </tr>";
                                    //     }
                                    // }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-sm-5">
                    <button style="margin:2px 94%;width:max-content" class="col-sm-4 btn btn-primary" id="CapFirstAdd" data-toggle="modal" data-target="#CapFirstModal">Add New</button>
                </div> -->

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary " id="CapFirstAddNew">Add</button> -->
            </div>
        </div>
    </div>
</div>
<!--end first group-->


<!-- Second cap  -->
<div class="modal fade" id="CapSecondModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:80% !important ">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Capital Tower</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="offset-1 col-sm-10 table-responsive" style="height: 500px;">
                        <div class="row">
                            <div class="col-sm-6">
                                <button class="col-sm-4 btn btn-primary" onclick="CapSecondtoggleAddForm()">Add New</button>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row" style="margin:auto;" id="CapSecondAddform">
                            <div class="col-md-8" style="margin:10px auto">
                                <div class="form-group d-flex">
                                    <label for="CapNatureName" class="mr-2">Name:</label>
                                    <input type="text" style="width: 80%;" name="name" class="form-control" id="CapSecondNatureName">
                                </div>
                            </div>
                            <div class="col-md-3" style="margin:10px auto">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" id="CapSecondAddNew">Add</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div style="height:300px;overflow-y: scroll;">
                            <table width="100%" border="1" id="dataTableExample4" class="table">
                                <thead>
                                    <tr>
                                        <th style="color:white">Sno</th>
                                        <th style="color:white">Head Code</th>
                                        <th style="color:white">Head Desc</th>
                                        <th style="color:white">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="capSecondModalTableBody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-sm-5">
                    <button style="margin:2px 94%;width:max-content" class="col-sm-4 btn btn-primary" id="CapFirstAdd" data-toggle="modal" data-target="#CapFirstModal">Add New</button>
                </div> -->

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary " id="CapFirstAddNew">Add</button> -->
            </div>
        </div>
    </div>
</div>
<!--end first group-->


<!-- reveue Third section add Modal -->
<div class="modal fade" id="CapThirdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:700px !important ">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Account Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="houseName" class="col-form-label">Name :</label>
                            <input type="text" style="width: 100%;" name="name" class="form-control" id="CapThirdNatureName">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="houseName" class="col-form-label">Status :</label>
                            <select style="width: 100%;" name="name" class="form-control" id="CapThirdNatureStatusName">
                                <option value="1" class="success">Active</option>
                                <option value="0" class="red">Block</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="CapThirdAddNew">Add</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/Capital.js"></script>