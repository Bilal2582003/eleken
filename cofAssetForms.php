<!-- first asset  -->
<div class="modal fade" id="AssetFirstModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:80% !important ">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asset Nature</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="offset-1 col-sm-10 table-responsive" style="height: 500px;">
                        <div class="row">
                            <div class="col-sm-6">
                                <button class="col-sm-4 btn btn-primary" onclick="AssetFirsttoggleAddForm()">Add New</button>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row" style="margin:auto;" id="AssetfirstAddform">
                            <div class="col-md-8" style="margin:10px auto">
                                <div class="form-group d-flex">
                                    <label for="AssetNatureName" class="mr-2">Name:</label>
                                    <input type="text" style="width: 80%;" name="name" class="form-control" id="AssetFirstNatureName">
                                </div>
                            </div>
                            <div class="col-md-3" style="margin:10px auto">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" id="AssetFirstAddNew">Add</button>
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
                                <tbody id="assetFirstModalTableBody">
                                    <?php
                                    // $query = "SELECT * from asset where deleted_at is null";
                                    // $res = mysqli_query($con, $query);
                                    // if ($row = mysqli_num_rows($res) > 0) {
                                    //     $sno = 0;
                                    //     while ($row = mysqli_fetch_assoc($res)) {
                                    //         $sno++;
                                    //         echo "<tr>
                                    //         <td>" . $sno . "</td>
                                    //         <td class='firstAssetId'>" . $row['id'] . "</td>
                                    //         <td><input type='text' value='" . $row['name'] . "' disabled class='firstAssetName form-control'></td>
                                    //         <td><button class='firstAssetEdit btn btn-success'>Edit</button>
                                    //         <button class='btn btn-danger firstAssetDelete'>Delete</button></td>
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
                    <button style="margin:2px 94%;width:max-content" class="col-sm-4 btn btn-primary" id="AssetFirstAdd" data-toggle="modal" data-target="#AssetFirstModal">Add New</button>
                </div> -->

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary " id="AssetFirstAddNew">Add</button> -->
            </div>
        </div>
    </div>
</div>
<!--end first group-->


<!-- Second asset  -->
<div class="modal fade" id="AssetSecondModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:80% !important ">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asset Tower</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="offset-1 col-sm-10 table-responsive" style="height: 500px;">
                        <div class="row">
                            <div class="col-sm-6">
                                <button class="col-sm-4 btn btn-primary" onclick="AssetSecondtoggleAddForm()">Add New</button>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row" style="margin:auto;" id="AssetSecondAddform">
                            <div class="col-md-8" style="margin:10px auto">
                                <div class="form-group d-flex">
                                    <label for="AssetNatureName" class="mr-2">Name:</label>
                                    <input type="text" style="width: 80%;" name="name" class="form-control" id="AssetSecondNatureName">
                                </div>
                            </div>
                            <div class="col-md-3" style="margin:10px auto">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" id="AssetSecondAddNew">Add</button>
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
                                <tbody id="assetSecondModalTableBody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-sm-5">
                    <button style="margin:2px 94%;width:max-content" class="col-sm-4 btn btn-primary" id="AssetFirstAdd" data-toggle="modal" data-target="#AssetFirstModal">Add New</button>
                </div> -->

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary " id="AssetFirstAddNew">Add</button> -->
            </div>
        </div>
    </div>
</div>
<!--end first group-->


<!-- reveue Third section add Modal -->
<div class="modal fade" id="AssetThirdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input type="text" style="width: 100%;" name="name" class="form-control" id="AssetThirdNatureName">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="houseName" class="col-form-label">Status :</label>
                            <select style="width: 100%;" name="name" class="form-control" id="AssetThirdNatureStatusName">
                                <option value="1" class="success">Active</option>
                                <option value="0" class="red">Block</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="AssetThirdAddNew">Add</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/Asset.js"></script>