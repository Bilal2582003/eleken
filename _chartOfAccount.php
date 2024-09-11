<?php
include "connection.php";
// for Revenue 
if (isset($_POST['chartOfAccountActionRevenue'])) {
    // Revenuse first select box main page
    if ($_POST['chartOfAccountActionRevenue'] == 'RevenueFirstTbodyGet') {
        $tabId = $_POST['tabId'];
        $query = "SELECT * from account_types_detail where deleted_at is null and ACCOUNT_TYPE = '$tabId'";
        $res = mysqli_query($con, $query);
        $output = '<option value="" selected disabled>SELECT</option>';
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '
                <option value="' . $row['ACC_DETAIL_TYPE'] . '">' . $row['DESCRIPTION'] . '</option>
                ';
            }
        }
        echo $output;
    }
    // revenue first Modal Data 
    if ($_POST['chartOfAccountActionRevenue'] == 'RevenueFirstModalTbodyGet') {
        $tabId = $_POST['tabId'];
        $query = "SELECT * from account_types_detail where deleted_at is null and ACCOUNT_TYPE = '$tabId'";
        $res = mysqli_query($con, $query);
        $output = '';
        if ($row = mysqli_num_rows($res) > 0) {
            $sno = 0;
            while ($row = mysqli_fetch_assoc($res)) {
                $sno++;
                $output .= "<tr>
                <td>" . $sno . "</td>
                <td class='firstRevenueId'>" . $row['ACC_DETAIL_TYPE'] . "</td>
                <td><input type='text' value='" . $row['DESCRIPTION'] . "' disabled class='firstRevenueName form-control'></td>
                <td><button class='firstRevenueEdit btn btn-success'>Edit</button>
                <button class='btn btn-danger firstRevenueDelete'>Delete</button></td>
                </tr>";
            }
        }
        echo $output;
    }
    // Revenuse Second select box
    if ($_POST['chartOfAccountActionRevenue'] == 'RevenueSecondTbody') {
        $rid = $_POST['headID'];
        // $rid=$_GET['RevenueFirst'];
        $tabId = $_POST['tabId'];
        $output = '<option value="" selected disabled>SELECT</option>';
        $sno = 0;
        $query = "SELECT chart_head.* from chart_head join account_types_detail on chart_head.ACC_DETAIL_TYPE = account_types_detail.ACC_DETAIL_TYPE where chart_head.ACC_DETAIL_TYPE = '$rid' and chart_head.ACC_TYPE = '$tabId' and chart_head.deleted_at is null ";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {

            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '<option value="' . $row['HEAD_CODE'] . '">' . $row['HEAD_DESC'] . '</option>';
            }
        }
        echo $output;
    }
    if ($_POST['chartOfAccountActionRevenue'] == 'revenueSecondModalTableBodyDataGet') {
        $revenueData = $_POST['revenueData'];
        $tabId = $_POST['tabId'];
        $output = '';
        $sno = 0;
        $query = "SELECT * from chart_head where ACC_DETAIL_TYPE = '$revenueData' and ACC_TYPE='$tabId' and deleted_at is null";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $sno++;
                $output .= "<tr>
                    <td>" . $sno . "</td>
                    <td class='secondRevenueId'>" . $row['HEAD_CODE'] . "</td>
                    <td><input type='text' value='" . $row['HEAD_DESC'] . "' disabled class='secondRevenueName form-control'></td>
                    <td><button class='secondRevenueEdit btn btn-success'>Edit</button>
                    <button class='btn btn-danger secondRevenueDelete'>Delete</button></td>
                    </tr>";
            }
        }
        echo $output;
    }
    if ($_POST['chartOfAccountActionRevenue'] == 'RevenueThirdTbodyGet') {
        $revenueSecondData = $_POST['r1_id'];
        $revenueFirstData = $_POST['r_id'];
        $tabId = $_POST['tabId'];
        $output = '';
        $option ='';
        $sno = 0;
        $query = "SELECT * from chart_detail where ACC_TYPE = '$tabId' and ACC_DETAIL_TYPE = '$revenueFirstData' and CHART_HEAD_CODE = '$revenueSecondData' and deleted_at is null";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                if ($row['is_active'] == '1') {
                    $option = '<option value="1" class="success" selected>Active</option>
                    <option class="red" value="0" >Block</option>';
                }
                elseif ($row['is_block'] == '1') {
                    $option = '<option value="1" class="success" >Active</option>
                    <option class="red" value="0" selected>Block</option>';
                }else{
                    $option = '
                    <option value="">Select</option>
                    <option value="1" class="success" >Active</option>
                    <option class="red" value="0" >Block</option>';
                }
                $sno++;
                $output .= "<tr>
                    <td>" . $sno . "</td>
                    <td class='thirdRevenueId' style='display:none'>" . $row['id'] . "</td>
                    <td>" . $row['CHART_ACC_CODE'] . "</td>
                    <td><input type='text' value='" . $row['CHART_ACC_DESC'] . "' disabled class='thirdRevenueName form-control'></td>
                    <td>" . $row['ASSET_CODE'] . "</td>
                    <td>
                    <select disabled class='thirdRevenueStatus form-control'>$option</select>
                    </td>
                    <td><button class='thirdRevenueEdit btn btn-success'>Edit</button>
                    <button class='btn btn-danger thirdRevenueDelete'>Delete</button></td>
                    </tr>";
            }
        }
        echo $output;
    }

    // add new data in revenue
    if ($_POST['chartOfAccountActionRevenue'] == 'addRevenueFirstNature') {
        $name = $_POST['name'];
        $tabId = $_POST['tabId'];

        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(ACC_DETAIL_TYPE) AS max_acc_detail_type FROM account_types_detail WHERE ACCOUNT_TYPE = '$tabId'";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null  ) {
            $id = $row['max_acc_detail_type'];
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
        } else {
            $id = $tabId;
        }
        $id++;
        $query = "INSERT INTO account_types_detail (ACCOUNT_TYPE, ACC_DETAIL_TYPE, DESCRIPTION) VALUES ('$tabId', '$id', '$name')";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // add new data in revenue second
    if ($_POST['chartOfAccountActionRevenue'] == 'addRevenueSecondNature') {
        $acType = $_POST['r_id'];
        $name = $_POST['name'];
        $tabId = $_POST['tabId'];

        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(HEAD_CODE) AS max_acc_detail_type FROM chart_head WHERE ACC_TYPE = '$tabId' ";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null) {
            $id = $row['max_acc_detail_type'] ;
        } else {
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
            $lastQuery = "SELECT MAX(HEAD_CODE) AS max_acc_detail_type FROM chart_head ";
            $res1 = mysqli_query($con, $lastQuery);
            $row = mysqli_fetch_assoc($res1);
            $id = empty($row['max_acc_detail_type']) ? 1 : $row['max_acc_detail_type'] ;
        }
        $id++;

        $query = "INSERT INTO chart_head (ACC_TYPE,HEAD_CODE,HEAD_DESC,ACC_DETAIL_TYPE) VALUES('$tabId','$id','$name','$acType')";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // add new data in revenue Third
    if ($_POST['chartOfAccountActionRevenue'] == 'addRevenueThirdNature') {
        $revenueSecondData = $_POST['r1_id'];
        $revenueFirstData = $_POST['r_id'];
        $tabId = $_POST['tabId'];
        $name = $_POST['name'];
        $house = $_POST['house'];
        $status = $_POST['status'];
        $act = $status == 1 ? 'is_active' : 'is_block';

        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(CHART_ACC_CODE) AS max_acc_detail_type FROM chart_detail WHERE ACC_TYPE = '$tabId' and ACC_DETAIL_TYPE = '$revenueFirstData' and CHART_HEAD_CODE = '$revenueSecondData'";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null) {
            $id = $row['max_acc_detail_type'];
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
        } else {
            $lastQuery = "SELECT MAX(CHART_ACC_CODE) AS max_acc_detail_type FROM chart_detail ";
            $res1 = mysqli_query($con, $lastQuery);
            $row = mysqli_fetch_assoc($res1);
            $id = $row['max_acc_detail_type'] ? 1 : $row['max_acc_detail_type'] ;
        }
        $id++;

        $query = "INSERT INTO chart_detail(CHART_HEAD_CODE, CHART_ACC_CODE, CHART_ACC_DESC, ACC_TYPE, ACC_DETAIL_TYPE,ASSET_CODE, `$act`) VALUES('$revenueSecondData','$id','$name','$tabId','$revenueFirstData','$house',1)";
        // $query = "INSERT INTO coar2 (coar1_id,name,house_id,`$act`) VALUES('$id','$name','$house','1')";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }

    // edit first revenue data 
    if ($_POST['chartOfAccountActionRevenue'] == 'RevenueFirstEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $query = "UPDATE account_types_detail SET DESCRIPTION = '$name' where ACC_DETAIL_TYPE ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // edit Sedond revenue data 
    if ($_POST['chartOfAccountActionRevenue'] == 'RevenueSecondEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $query = "UPDATE chart_head SET HEAD_DESC = '$name' where HEAD_CODE ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // edit Third revenue data 
    if ($_POST['chartOfAccountActionRevenue'] == 'RevenueThirdEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $status = $_POST['status'];

        $act = $status == 1 ? 'is_active' : 'is_block';
        $act1 = $status == 1 ? 'is_block' : 'is_active';

        $query = "UPDATE chart_detail SET CHART_ACC_DESC = '$name', `$act` = '1' ,`$act1` = 0 where id = '$id' ";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }

    // Delete first revenue data 
    if ($_POST['chartOfAccountActionRevenue'] == 'RevenueFirstDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE account_types_detail SET deleted_at = '$date' where ACC_DETAIL_TYPE ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // Delete Second revenue data 
    if ($_POST['chartOfAccountActionRevenue'] == 'RevenueSecondDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE chart_head SET deleted_at = '$date' where head_code ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // Delete Third revenue data 
    if ($_POST['chartOfAccountActionRevenue'] == 'RevenueThirdDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE chart_detail SET deleted_at = '$date' where id = '$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
}


// For asset 
if (isset($_POST['chartOfAccountActionAsset'])) {
    // Revenuse first select box main page
    if ($_POST['chartOfAccountActionAsset'] == 'AssetFirstTbodyGet') {
        $tabId = $_POST['tabId'];
        $query = "SELECT * from account_types_detail where deleted_at is null and ACCOUNT_TYPE = '$tabId'";
        $res = mysqli_query($con, $query);
        $output = '<option value="" selected disabled>SELECT</option>';
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '
                <option value="' . $row['ACC_DETAIL_TYPE'] . '">' . $row['DESCRIPTION'] . '</option>
                ';
            }
        }
        echo $output;
    }
    // revenue first Modal Data 
    if ($_POST['chartOfAccountActionAsset'] == 'AssetFirstModalTbodyGet') {
        $tabId = $_POST['tabId'];
        $query = "SELECT * from account_types_detail where deleted_at is null and ACCOUNT_TYPE = '$tabId'";
        $res = mysqli_query($con, $query);
        $output = '';
        if ($row = mysqli_num_rows($res) > 0) {
            $sno = 0;
            while ($row = mysqli_fetch_assoc($res)) {
                $sno++;
                $output .= "<tr>
                <td>" . $sno . "</td>
                <td class='firstAssetId'>" . $row['ACC_DETAIL_TYPE'] . "</td>
                <td><input type='text' value='" . $row['DESCRIPTION'] . "' disabled class='firstAssetName form-control'></td>
                <td><button class='firstAssetEdit btn btn-success'>Edit</button>
                <button class='btn btn-danger firstAssetDelete'>Delete</button></td>
                </tr>";
            }
        }
        echo $output;
    }
    // Revenuse Second select box
    if ($_POST['chartOfAccountActionAsset'] == 'AssetSecondTbody') {
        $rid = $_POST['headID'];
        $tabId = $_POST['tabId'];
        // $rid=$_GET['AssetFirst'];
        $output = '<option value="" selected disabled>SELECT</option>';
        $sno = 0;
        $query = "SELECT chart_head.* from chart_head join account_types_detail on chart_head.ACC_DETAIL_TYPE = account_types_detail.ACC_DETAIL_TYPE where chart_head.ACC_DETAIL_TYPE = '$rid' and chart_head.ACC_TYPE = '$tabId' and chart_head.deleted_at is null ";
        // $query = "SELECT coaa1.* from coaa1 join asset on coaa1.asset_id = asset.id where asset.id = '$rid' and asset.deleted_at is null ";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {

            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '<option value="' . $row['HEAD_CODE'] . '">' . $row['HEAD_DESC'] . '</option>';
            }
        }
        echo $output;
    }
    if ($_POST['chartOfAccountActionAsset'] == 'assetSecondModalTableBodyDataGet') {
        $assetData = $_POST['assetData'];
        $tabId = $_POST['tabId'];
        $output = '';
        $sno = 0;
        $query = "SELECT * from chart_head where ACC_DETAIL_TYPE = '$assetData' and ACC_TYPE='$tabId' and deleted_at is null";
        // $query = "SELECT * from coaa1 where asset_id = '$assetData' and deleted_at is null";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $sno++;
                $output .= "<tr>
                    <td>" . $sno . "</td>
                    <td class='secondAssetId'>" . $row['HEAD_CODE'] . "</td>
                    <td><input type='text' value='" . $row['HEAD_DESC'] . "' disabled class='secondAssetName form-control'></td>
                    <td><button class='secondAssetEdit btn btn-success'>Edit</button>
                    <button class='btn btn-danger secondAssetDelete'>Delete</button></td>
                    </tr>";
            }
        }
        echo $output;
    }
    if ($_POST['chartOfAccountActionAsset'] == 'AssetThirdTbodyGet') {
        $assetSecondData = $_POST['r1_id'];
        $assetFirstData = $_POST['r_id'];
        $tabId = $_POST['tabId'];
        $output = '';
        $sno = 0;
        $query = "SELECT * from chart_detail where ACC_TYPE = '$tabId' and ACC_DETAIL_TYPE = '$assetFirstData' and CHART_HEAD_CODE = '$assetSecondData' and deleted_at is null";
        // $query = "SELECT * from coaa2 where coaa1_id = '$assetFirstData' and deleted_at is null";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                if ($row['is_active'] == '1') {
                    $option = '<option value="1" class="success" selected>Active</option>
                    <option class="red" value="0" >Block</option>';
                }
                if ($row['is_block'] == '1') {
                    $option = '<option value="1" class="success" >Active</option>
                    <option class="red" value="0" selected>Block</option>';
                }
                $sno++;
                $output .= "<tr>
                    <td>" . $sno . "</td>
                    <td class='thirdAssetId' style='display:none'>" . $row['id'] . "</td>
                    <td>" . $row['CHART_ACC_CODE'] . "</td>
                    <td><input type='text' value='" . $row['CHART_ACC_DESC'] . "' disabled class='thirdAssetName form-control'></td>
                    
                    <td>
                    <select disabled class='thirdAssetStatus form-control'>$option</select>
                    </td>
                    <td><button class='thirdAssetEdit btn btn-success'>Edit</button>
                    <button class='btn btn-danger thirdAssetDelete'>Delete</button></td>
                    </tr>";
            }
        }
        echo $output;
    }

    // add new data in asset
    if ($_POST['chartOfAccountActionAsset'] == 'addAssetFirstNature') {
        $name = $_POST['name'];
        $tabId = $_POST['tabId'];

        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(ACC_DETAIL_TYPE) AS max_acc_detail_type FROM account_types_detail WHERE ACCOUNT_TYPE = '$tabId'";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null) {
            $id = $row['max_acc_detail_type'];
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
        } else {
            $id = $tabId;
        }
        $id++;

        // Insert the new record with the incremented ACC_DETAIL_TYPE
        $query = "INSERT INTO account_types_detail (ACCOUNT_TYPE, ACC_DETAIL_TYPE, DESCRIPTION) VALUES ('$tabId', '$id', '$name')";
        $res = mysqli_query($con, $query);

        if ($res) {
            echo 1; // Success
        } else {
            echo 0; // Failure
        }
    }
    // add new data in asset second
    if ($_POST['chartOfAccountActionAsset'] == 'addAssetSecondNature') {
        $acType = $_POST['r_id'];
        $name = $_POST['name'];
        $tabId = $_POST['tabId'];

        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(HEAD_CODE) AS max_acc_detail_type FROM chart_head WHERE ACC_TYPE = '$tabId' ";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null) {
            $id = $row['max_acc_detail_type'];
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
        } else {
            $lastQuery = "SELECT MAX(HEAD_CODE) AS max_acc_detail_type FROM chart_head ";
            $res1 = mysqli_query($con, $lastQuery);
            $row = mysqli_fetch_assoc($res1);
            $id = $row['max_acc_detail_type'] ? 1 : $row['max_acc_detail_type'] ;
        }
        $id++;

        $query = "INSERT INTO chart_head (ACC_TYPE,HEAD_CODE,HEAD_DESC,ACC_DETAIL_TYPE) VALUES('$tabId','$id','$name','$acType')";
        // $query = "INSERT INTO coaa1 (asset_id,name) VALUES('$id','$name')";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // add new data in asset Third
    if ($_POST['chartOfAccountActionAsset'] == 'addAssetThirdNature') {
        $assetSecondData = $_POST['r1_id'];
        $assetFirstData = $_POST['r_id'];
        $tabId = $_POST['tabId'];
        $name = $_POST['name'];
        $status = $_POST['status'];
        $act = $status == 1 ? 'is_active' : 'is_block';

        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(CHART_ACC_CODE) AS max_acc_detail_type FROM chart_detail WHERE ACC_TYPE = '$tabId' and ACC_DETAIL_TYPE = '$assetFirstData' and CHART_HEAD_CODE = '$assetSecondData'";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null) {
            $id = $row['max_acc_detail_type'];
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
        } else {
            $lastQuery = "SELECT MAX(CHART_ACC_CODE) AS max_acc_detail_type FROM chart_detail ";
            $res1 = mysqli_query($con, $lastQuery);
            $row = mysqli_fetch_assoc($res1);
            $id = $row['max_acc_detail_type'] ? 1 : $row['max_acc_detail_type'] ;;
        }
        $id++;


        $query = "INSERT INTO chart_detail(CHART_HEAD_CODE, CHART_ACC_CODE, CHART_ACC_DESC, ACC_TYPE, ACC_DETAIL_TYPE, `$act`) VALUES('$assetSecondData','$id','$name','$tabId','$assetFirstData',1)";
        // $query = "INSERT INTO coaa2 (coaa1_id,name,`$act`) VALUES('$id','$name','1')";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }

    // edit first asset data 
    if ($_POST['chartOfAccountActionAsset'] == 'AssetFirstEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $query = "UPDATE account_types_detail SET DESCRIPTION = '$name' where ACC_DETAIL_TYPE ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // edit Sedond asset data 
    if ($_POST['chartOfAccountActionAsset'] == 'AssetSecondEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $query = "UPDATE chart_head SET HEAD_DESC = '$name' where HEAD_CODE ='$id'";
        // $query = "UPDATE coaa1 SET name = '$name' where id ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // edit Third asset data 
    if ($_POST['chartOfAccountActionAsset'] == 'AssetThirdEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $status = $_POST['status'];

        $act = $status == 1 ? 'is_active' : 'is_block';
        $act1 = $status == 1 ? 'is_block' : 'is_active';

        $query = "UPDATE chart_detail SET CHART_ACC_DESC = '$name', `$act` = '1' ,`$act1` = 0 where id = '$id' ";
        // $query = "UPDATE coaa2 SET name = '$name', `$act` = '1', `$act1` = '0' where id ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }

    // Delete first asset data 
    if ($_POST['chartOfAccountActionAsset'] == 'AssetFirstDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE account_types_detail SET deleted_at = '$date' where ACC_DETAIL_TYPE ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // Delete Second asset data 
    if ($_POST['chartOfAccountActionAsset'] == 'AssetSecondDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE chart_head SET deleted_at = '$date' where head_code ='$id'";
        // $query = "UPDATE coaa1 SET deleted_at = '$date' where id ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // Delete Third revenue data 
    if ($_POST['chartOfAccountActionAsset'] == 'AssetThirdDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE chart_detail SET deleted_at = '$date' where id = '$id'";
        // $query = "UPDATE coaa2 SET deleted_at = '$date' where id ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
}




// For Liabilities 
if (isset($_POST['chartOfAccountActionLib'])) {
    // Revenuse first select box main page
    if ($_POST['chartOfAccountActionLib'] == 'LibFirstTbodyGet') {
        $tabId = $_POST['tabId'];
        $query = "SELECT * from account_types_detail where deleted_at is null and ACCOUNT_TYPE = '$tabId'";
        $res = mysqli_query($con, $query);
        $output = '<option value="" selected disabled>SELECT</option>';
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '
                <option value="' . $row['ACC_DETAIL_TYPE'] . '">' . $row['DESCRIPTION'] . '</option>
                ';
            }
        }
        echo $output;
    }
    // revenue first Modal Data 
    if ($_POST['chartOfAccountActionLib'] == 'LibFirstModalTbodyGet') {
        $tabId = $_POST['tabId'];
        $query = "SELECT * from account_types_detail where deleted_at is null and ACCOUNT_TYPE = '$tabId'";
        $res = mysqli_query($con, $query);
        $output = '';
        if ($row = mysqli_num_rows($res) > 0) {
            $sno = 0;
            while ($row = mysqli_fetch_assoc($res)) {
                $sno++;
                $output .= "<tr>
                <td>" . $sno . "</td>
                <td class='firstLibId'>" . $row['ACC_DETAIL_TYPE'] . "</td>
                <td><input type='text' value='" . $row['DESCRIPTION'] . "' disabled class='firstLibName form-control'></td>
                <td><button class='firstLibEdit btn btn-success'>Edit</button>
                <button class='btn btn-danger firstLibDelete'>Delete</button></td>
                </tr>";
            }
        }
        echo $output;
    }
    // Revenuse Second select box
    if ($_POST['chartOfAccountActionLib'] == 'LibSecondTbody') {
        $rid = $_POST['headID'];
        $tabId = $_POST['tabId'];
        // $rid=$_GET['LibFirst'];
        $output = '<option value="" selected disabled>SELECT</option>';
        $sno = 0;
        $query = "SELECT chart_head.* from chart_head join account_types_detail on chart_head.ACC_DETAIL_TYPE = account_types_detail.ACC_DETAIL_TYPE where chart_head.ACC_DETAIL_TYPE = '$rid' and chart_head.ACC_TYPE = '$tabId' and chart_head.deleted_at is null ";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {

            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '<option value="' . $row['HEAD_CODE'] . '">' . $row['HEAD_DESC'] . '</option>';
            }
        }
        echo $output;
    }
    if ($_POST['chartOfAccountActionLib'] == 'libSecondModalTableBodyDataGet') {
        $libData = $_POST['libData'];
        $tabId = $_POST['tabId'];
        $output = '';
        $sno = 0;
        $query = "SELECT * from chart_head where ACC_DETAIL_TYPE = '$libData' and ACC_TYPE='$tabId' and deleted_at is null";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $sno++;
                $output .= "<tr>
                    <td>" . $sno . "</td>
                    <td class='secondLibId'>" . $row['HEAD_CODE'] . "</td>
                    <td><input type='text' value='" . $row['HEAD_DESC'] . "' disabled class='secondLibName form-control'></td>
                    <td><button class='secondLibEdit btn btn-success'>Edit</button>
                    <button class='btn btn-danger secondLibDelete'>Delete</button></td>
                    </tr>";
            }
        }
        echo $output;
    }
    if ($_POST['chartOfAccountActionLib'] == 'LibThirdTbodyGet') {
        $libSecondData = $_POST['r1_id'];
        $libFirstData = $_POST['r_id'];
        $tabId = $_POST['tabId'];
        $output = '';
        $sno = 0;
        $query = "SELECT * from chart_detail where ACC_TYPE = '$tabId' and ACC_DETAIL_TYPE = '$libFirstData' and CHART_HEAD_CODE = '$libSecondData' and deleted_at is null";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                if ($row['is_active'] == '1') {
                    $option = '<option value="1" class="success" selected>Active</option>
                    <option class="red" value="0" >Block</option>';
                }
                if ($row['is_block'] == '1') {
                    $option = '<option value="1" class="success" >Active</option>
                    <option class="red" value="0" selected>Block</option>';
                }
                $sno++;
                $output .= "<tr>
                <td>" . $sno . "</td>
                <td class='thirdLibId' style='display:none'>" . $row['id'] . "</td>
                <td>" . $row['CHART_ACC_CODE'] . "</td>
                <td><input type='text' value='" . $row['CHART_ACC_DESC'] . "' disabled class='thirdLibName form-control'></td>
                    
                    <td>
                    <select disabled class='thirdLibStatus form-control'>$option</select>
                    </td>
                    <td><button class='thirdLibEdit btn btn-success'>Edit</button>
                    <button class='btn btn-danger thirdLibDelete'>Delete</button></td>
                    </tr>";
            }
        }
        echo $output;
    }

    // add new data in lib
    if ($_POST['chartOfAccountActionLib'] == 'addLibFirstNature') {
        $name = $_POST['name'];
        $tabId = $_POST['tabId'];

        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(ACC_DETAIL_TYPE) AS max_acc_detail_type FROM account_types_detail WHERE ACCOUNT_TYPE = '$tabId'";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null) {
            $id = $row['max_acc_detail_type'];
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
        } else {
            $id = $tabId;
        }
        $id++;
        $query = "INSERT INTO account_types_detail (ACCOUNT_TYPE, ACC_DETAIL_TYPE, DESCRIPTION) VALUES ('$tabId', '$id', '$name')";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // add new data in lib second
    if ($_POST['chartOfAccountActionLib'] == 'addLibSecondNature') {
        $acType = $_POST['r_id'];
        $name = $_POST['name'];
        $tabId = $_POST['tabId'];

        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(HEAD_CODE) AS max_acc_detail_type FROM chart_head WHERE ACC_TYPE = '$tabId' ";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null) {
            $id = $row['max_acc_detail_type'];
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
        } else {
            $lastQuery = "SELECT MAX(HEAD_CODE) AS max_acc_detail_type FROM chart_head ";
            $res1 = mysqli_query($con, $lastQuery);
            $row = mysqli_fetch_assoc($res1);
            $id = $row['max_acc_detail_type'] ? 1 : $row['max_acc_detail_type'] ;;
        }
        $id++;

        $query = "INSERT INTO chart_head (ACC_TYPE,HEAD_CODE,HEAD_DESC,ACC_DETAIL_TYPE) VALUES('$tabId','$id','$name','$acType')";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // add new data in lib Third
    if ($_POST['chartOfAccountActionLib'] == 'addLibThirdNature') {
        $libSecondData = $_POST['r1_id'];
        $libFirstData = $_POST['r_id'];
        $tabId = $_POST['tabId'];
        $name = $_POST['name'];
        $status = $_POST['status'];
        $act = $status == 1 ? 'is_active' : 'is_block';

        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(CHART_ACC_CODE) AS max_acc_detail_type FROM chart_detail WHERE ACC_TYPE = '$tabId' and ACC_DETAIL_TYPE = '$libFirstData' and CHART_HEAD_CODE = '$libSecondData'";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null) {
            $id = $row['max_acc_detail_type'];
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
        } else {
            $lastQuery = "SELECT MAX(CHART_ACC_CODE) AS max_acc_detail_type FROM chart_detail ";
            $res1 = mysqli_query($con, $lastQuery);
            $row = mysqli_fetch_assoc($res1);
            $id = $row['max_acc_detail_type'] ? 1 : $row['max_acc_detail_type'] ;
        }
        $id++;


        $query = "INSERT INTO chart_detail(CHART_HEAD_CODE, CHART_ACC_CODE, CHART_ACC_DESC, ACC_TYPE, ACC_DETAIL_TYPE, `$act`) VALUES('$libSecondData','$id','$name','$tabId','$libFirstData',1)";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }

    // edit first lib data 
    if ($_POST['chartOfAccountActionLib'] == 'LibFirstEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $query = "UPDATE account_types_detail SET DESCRIPTION = '$name' where ACC_DETAIL_TYPE ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // edit Sedond lib data 
    if ($_POST['chartOfAccountActionLib'] == 'LibSecondEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $query = "UPDATE chart_head SET HEAD_DESC = '$name' where HEAD_CODE ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // edit Third lib data 
    if ($_POST['chartOfAccountActionLib'] == 'LibThirdEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $status = $_POST['status'];

        $act = $status == 1 ? 'is_active' : 'is_block';
        $act1 = $status == 1 ? 'is_block' : 'is_active';

        $query = "UPDATE chart_detail SET CHART_ACC_DESC = '$name', `$act` = '1' ,`$act1` = 0 where id = '$id' ";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }

    // Delete first lib data 
    if ($_POST['chartOfAccountActionLib'] == 'LibFirstDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE account_types_detail SET deleted_at = '$date' where ACC_DETAIL_TYPE ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // Delete Second lib data 
    if ($_POST['chartOfAccountActionLib'] == 'LibSecondDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE chart_head SET deleted_at = '$date' where head_code ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // Delete Third revenue data 
    if ($_POST['chartOfAccountActionLib'] == 'LibThirdDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE chart_detail SET deleted_at = '$date' where id = '$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
}




// For Capital 
if (isset($_POST['chartOfAccountActionCap'])) {
    // Revenuse first select box main page
    if ($_POST['chartOfAccountActionCap'] == 'CapFirstTbodyGet') {
        $tabId = $_POST['tabId'];
        $query = "SELECT * from account_types_detail where deleted_at is null and ACCOUNT_TYPE = '$tabId'";
        $res = mysqli_query($con, $query);
        $output = '<option value="" selected disabled>SELECT</option>';
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '
                <option value="' . $row['ACC_DETAIL_TYPE'] . '">' . $row['DESCRIPTION'] . '</option>
                ';
            }
        }
        echo $output;
    }
    // revenue first Modal Data 
    if ($_POST['chartOfAccountActionCap'] == 'CapFirstModalTbodyGet') {
        $tabId = $_POST['tabId'];
        $query = "SELECT * from account_types_detail where deleted_at is null and ACCOUNT_TYPE = '$tabId'";
        $res = mysqli_query($con, $query);
        $output = '';
        if ($row = mysqli_num_rows($res) > 0) {
            $sno = 0;
            while ($row = mysqli_fetch_assoc($res)) {
                $sno++;
                $output .= "<tr>
                <td>" . $sno . "</td>
                <td class='firstCapId'>" . $row['ACC_DETAIL_TYPE'] . "</td>
                <td><input type='text' value='" . $row['DESCRIPTION'] . "' disabled class='firstCapName form-control'></td>
                <td><button class='firstCapEdit btn btn-success'>Edit</button>
                <button class='btn btn-danger firstCapDelete'>Delete</button></td>
                </tr>";
            }
        }
        echo $output;
    }
    // Revenuse Second select box
    if ($_POST['chartOfAccountActionCap'] == 'CapSecondTbody') {
        $rid = $_POST['headID'];
        $tabId = $_POST['tabId'];
        // $rid=$_GET['CapFirst'];
        $output = '<option value="" selected disabled>SELECT</option>';
        $sno = 0;
        $query = "SELECT chart_head.* from chart_head join account_types_detail on chart_head.ACC_DETAIL_TYPE = account_types_detail.ACC_DETAIL_TYPE where chart_head.ACC_DETAIL_TYPE = '$rid' and chart_head.ACC_TYPE = '$tabId' and chart_head.deleted_at is null ";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {

            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '<option value="' . $row['HEAD_CODE'] . '">' . $row['HEAD_DESC'] . '</option>';
            }
        }
        echo $output;
    }
    if ($_POST['chartOfAccountActionCap'] == 'capSecondModalTableBodyDataGet') {
        $capData = $_POST['capData'];
        $tabId = $_POST['tabId'];
        $output = '';
        $sno = 0;
        $query = "SELECT * from chart_head where ACC_DETAIL_TYPE = '$capData' and ACC_TYPE='$tabId' and deleted_at is null";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $sno++;
                $output .= "<tr>
                    <td>" . $sno . "</td>
                    <td class='secondCapId'>" . $row['HEAD_CODE'] . "</td>
                    <td><input type='text' value='" . $row['HEAD_DESC'] . "' disabled class='secondCapName form-control'></td>
                    <td><button class='secondCapEdit btn btn-success'>Edit</button>
                    <button class='btn btn-danger secondCapDelete'>Delete</button></td>
                    </tr>";
            }
        }
        echo $output;
    }
    if ($_POST['chartOfAccountActionCap'] == 'CapThirdTbodyGet') {
        $capSecondData = $_POST['r1_id'];
        $capFirstData = $_POST['r_id'];
        $tabId = $_POST['tabId'];
        $output = '';
        $sno = 0;
        $query = "SELECT * from chart_detail where ACC_TYPE = '$tabId' and ACC_DETAIL_TYPE = '$capFirstData' and CHART_HEAD_CODE = '$capSecondData' and deleted_at is null";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                if ($row['is_active'] == '1') {
                    $option = '<option value="1" class="success" selected>Active</option>
                    <option class="red" value="0" >Block</option>';
                }
                if ($row['is_block'] == '1') {
                    $option = '<option value="1" class="success" >Active</option>
                    <option class="red" value="0" selected>Block</option>';
                }
                $sno++;
                $output .= "<tr>
                <td>" . $sno . "</td>
                <td class='thirdCapId' style='display:none'>" . $row['id'] . "</td>
                <td>" . $row['CHART_ACC_CODE'] . "</td>
                <td><input type='text' value='" . $row['CHART_ACC_DESC'] . "' disabled class='thirdCapName form-control'></td>
                    
                    <td>
                    <select disabled class='thirdCapStatus form-control'>$option</select>
                    </td>
                    <td><button class='thirdCapEdit btn btn-success'>Edit</button>
                    <button class='btn btn-danger thirdCapDelete'>Delete</button></td>
                    </tr>";
            }
        }
        echo $output;
    }

    // add new data in cap
    if ($_POST['chartOfAccountActionCap'] == 'addCapFirstNature') {
        $name = $_POST['name'];
        $tabId = $_POST['tabId'];

        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(ACC_DETAIL_TYPE) AS max_acc_detail_type FROM account_types_detail WHERE ACCOUNT_TYPE = '$tabId'";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null) {
            $id = $row['max_acc_detail_type'];
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
        } else {
            $id = $tabId;
        }
        $id++;
        $query = "INSERT INTO account_types_detail (ACCOUNT_TYPE, ACC_DETAIL_TYPE, DESCRIPTION) VALUES ('$tabId', '$id', '$name')";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // add new data in cap second
    if ($_POST['chartOfAccountActionCap'] == 'addCapSecondNature') {
        $acType = $_POST['r_id'];
        $name = $_POST['name'];
        $tabId = $_POST['tabId'];

        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(HEAD_CODE) AS max_acc_detail_type FROM chart_head WHERE ACC_TYPE = '$tabId' ";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null) {
            $id = $row['max_acc_detail_type'];
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
        } else {
            $lastQuery = "SELECT MAX(HEAD_CODE) AS max_acc_detail_type FROM chart_head ";
            $res1 = mysqli_query($con, $lastQuery);
            $row = mysqli_fetch_assoc($res1);
            $id = $row['max_acc_detail_type'] ? 1 : $row['max_acc_detail_type'] ;;
        }
        $id++;

        $query = "INSERT INTO chart_head (ACC_TYPE,HEAD_CODE,HEAD_DESC,ACC_DETAIL_TYPE) VALUES('$tabId','$id','$name','$acType')";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // add new data in cap Third
    if ($_POST['chartOfAccountActionCap'] == 'addCapThirdNature') {
        $capSecondData = $_POST['r1_id'];
        $capFirstData = $_POST['r_id'];
        $tabId = $_POST['tabId'];
        $name = $_POST['name'];
        $status = $_POST['status'];
        $act = $status == 1 ? 'is_active' : 'is_block';

        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(CHART_ACC_CODE) AS max_acc_detail_type FROM chart_detail WHERE ACC_TYPE = '$tabId' and ACC_DETAIL_TYPE = '$capFirstData' and CHART_HEAD_CODE = '$capSecondData'";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null) {
            $id = $row['max_acc_detail_type'];
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
        } else {
            $lastQuery = "SELECT MAX(CHART_ACC_CODE) AS max_acc_detail_type FROM chart_detail ";
            $res1 = mysqli_query($con, $lastQuery);
            $row = mysqli_fetch_assoc($res1);
            $id = $row['max_acc_detail_type'] ? 1 : $row['max_acc_detail_type'] ;
        }
        $id++;


        $query = "INSERT INTO chart_detail(CHART_HEAD_CODE, CHART_ACC_CODE, CHART_ACC_DESC, ACC_TYPE, ACC_DETAIL_TYPE, `$act`) VALUES('$capSecondData','$id','$name','$tabId','$capFirstData',1)";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }

    // edit first cap data 
    if ($_POST['chartOfAccountActionCap'] == 'CapFirstEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $query = "UPDATE account_types_detail SET DESCRIPTION = '$name' where ACC_DETAIL_TYPE ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // edit Sedond cap data 
    if ($_POST['chartOfAccountActionCap'] == 'CapSecondEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $query = "UPDATE chart_head SET HEAD_DESC = '$name' where HEAD_CODE ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // edit Third cap data 
    if ($_POST['chartOfAccountActionCap'] == 'CapThirdEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $status = $_POST['status'];

        $act = $status == 1 ? 'is_active' : 'is_block';
        $act1 = $status == 1 ? 'is_block' : 'is_active';

        $query = "UPDATE chart_detail SET CHART_ACC_DESC = '$name', `$act` = '1' ,`$act1` = 0 where id = '$id' ";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }

    // Delete first cap data 
    if ($_POST['chartOfAccountActionCap'] == 'CapFirstDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE account_types_detail SET deleted_at = '$date' where ACC_DETAIL_TYPE ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // Delete Second cap data 
    if ($_POST['chartOfAccountActionCap'] == 'CapSecondDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE chart_head SET deleted_at = '$date' where head_code ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // Delete Third revenue data 
    if ($_POST['chartOfAccountActionCap'] == 'CapThirdDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE chart_detail SET deleted_at = '$date' where id = '$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
}





// For Expense 
if (isset($_POST['chartOfAccountActionExp'])) {
    // Revenuse first select box main page
    if ($_POST['chartOfAccountActionExp'] == 'ExpFirstTbodyGet') {
        $tabId = $_POST['tabId'];
        $query = "SELECT * from account_types_detail where deleted_at is null and ACCOUNT_TYPE = '$tabId'";
        $res = mysqli_query($con, $query);
        $output = '<option value="" selected disabled>SELECT</option>';
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '
                <option value="' . $row['ACC_DETAIL_TYPE'] . '">' . $row['DESCRIPTION'] . '</option>
                ';
            }
        }
        echo $output;
    }
    // revenue first Modal Data 
    if ($_POST['chartOfAccountActionExp'] == 'ExpFirstModalTbodyGet') {
        $tabId = $_POST['tabId'];
        $query = "SELECT * from account_types_detail where deleted_at is null and ACCOUNT_TYPE = '$tabId'";
        $res = mysqli_query($con, $query);
        $output = '';
        if ($row = mysqli_num_rows($res) > 0) {
            $sno = 0;
            while ($row = mysqli_fetch_assoc($res)) {
                $sno++;
                $output .= "<tr>
                <td>" . $sno . "</td>
                <td class='firstExpId'>" . $row['ACC_DETAIL_TYPE'] . "</td>
                <td><input type='text' value='" . $row['DESCRIPTION'] . "' disabled class='firstExpName form-control'></td>
                <td><button class='firstExpEdit btn btn-success'>Edit</button>
                <button class='btn btn-danger firstExpDelete'>Delete</button></td>
                </tr>";
            }
        }
        echo $output;
    }
    // Revenuse Second select box
    if ($_POST['chartOfAccountActionExp'] == 'ExpSecondTbody') {
        $rid = $_POST['headID'];
        $tabId = $_POST['tabId'];
        // $rid=$_GET['ExpFirst'];
        $output = '<option value="" selected disabled>SELECT</option>';
        $sno = 0;
        $query = "SELECT chart_head.* from chart_head join account_types_detail on chart_head.ACC_DETAIL_TYPE = account_types_detail.ACC_DETAIL_TYPE where chart_head.ACC_DETAIL_TYPE = '$rid' and chart_head.ACC_TYPE = '$tabId' and chart_head.deleted_at is null ";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {

            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '<option value="' . $row['HEAD_CODE'] . '">' . $row['HEAD_DESC'] . '</option>';
            }
        }
        echo $output;
    }
    if ($_POST['chartOfAccountActionExp'] == 'expSecondModalTableBodyDataGet') {
        $expData = $_POST['expData'];
        $tabId = $_POST['tabId'];
        $output = '';
        $sno = 0;
        $query = "SELECT * from chart_head where ACC_DETAIL_TYPE = '$expData' and ACC_TYPE='$tabId' and deleted_at is null";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $sno++;
                $output .= "<tr>
                    <td>" . $sno . "</td>
                    <td class='secondExpId'>" . $row['HEAD_CODE'] . "</td>
                    <td><input type='text' value='" . $row['HEAD_DESC'] . "' disabled class='secondExpName form-control'></td>
                    <td><button class='secondExpEdit btn btn-success'>Edit</button>
                    <button class='btn btn-danger secondExpDelete'>Delete</button></td>
                    </tr>";
            }
        }
        echo $output;
    }
    if ($_POST['chartOfAccountActionExp'] == 'ExpThirdTbodyGet') {
        $expSecondData = $_POST['r1_id'];
        $expFirstData = $_POST['r_id'];
        $tabId = $_POST['tabId'];
        $output = '';
        $sno = 0;
        $query = "SELECT * from chart_detail where ACC_TYPE = '$tabId' and ACC_DETAIL_TYPE = '$expFirstData' and CHART_HEAD_CODE = '$expSecondData' and deleted_at is null";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                if ($row['is_active'] == '1') {
                    $option = '<option value="1" class="success" selected>Active</option>
                    <option class="red" value="0" >Block</option>';
                }
                if ($row['is_block'] == '1') {
                    $option = '<option value="1" class="success" >Active</option>
                    <option class="red" value="0" selected>Block</option>';
                }
                $sno++;
                $output .= "<tr>
                <td>" . $sno . "</td>
                <td class='thirdExpId' style='display:none'>" . $row['id'] . "</td>
                <td>" . $row['CHART_ACC_CODE'] . "</td>
                <td><input type='text' value='" . $row['CHART_ACC_DESC'] . "' disabled class='thirdExpName form-control'></td>
                    
                    <td>
                    <select disabled class='thirdExpStatus form-control'>$option</select>
                    </td>
                    <td><button class='thirdExpEdit btn btn-success'>Edit</button>
                    <button class='btn btn-danger thirdExpDelete'>Delete</button></td>
                    </tr>";
            }
        }
        echo $output;
    }

    // add new data in exp
    if ($_POST['chartOfAccountActionExp'] == 'addExpFirstNature') {
        $name = $_POST['name'];
        $tabId = $_POST['tabId'];

        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(ACC_DETAIL_TYPE) AS max_acc_detail_type FROM account_types_detail WHERE ACCOUNT_TYPE = '$tabId'";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null) {
            $id = $row['max_acc_detail_type'];
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
        } else {
            $id = $tabId;
        }
        $id++;
        $query = "INSERT INTO account_types_detail (ACCOUNT_TYPE, ACC_DETAIL_TYPE, DESCRIPTION) VALUES ('$tabId', '$id', '$name')";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // add new data in exp second
    if ($_POST['chartOfAccountActionExp'] == 'addExpSecondNature') {
        $acType = $_POST['r_id'];
        $name = $_POST['name'];
        $tabId = $_POST['tabId'];

        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(HEAD_CODE) AS max_acc_detail_type FROM chart_head WHERE ACC_TYPE = '$tabId' ";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null) {
            $id = $row['max_acc_detail_type'];
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
        } else {
            $lastQuery = "SELECT MAX(HEAD_CODE) AS max_acc_detail_type FROM chart_head ";
            $res1 = mysqli_query($con, $lastQuery);
            $row = mysqli_fetch_assoc($res1);
            $id = $row['max_acc_detail_type'] ? 1 : $row['max_acc_detail_type'] ;
        }
        $id++;

        $query = "INSERT INTO chart_head (ACC_TYPE,HEAD_CODE,HEAD_DESC,ACC_DETAIL_TYPE) VALUES('$tabId','$id','$name','$acType')";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // add new data in exp Third
    if ($_POST['chartOfAccountActionExp'] == 'addExpThirdNature') {
        $expSecondData = $_POST['r1_id'];
        $expFirstData = $_POST['r_id'];
        $tabId = $_POST['tabId'];
        $name = $_POST['name'];
        $status = $_POST['status'];
        $act = $status == 1 ? 'is_active' : 'is_block';
        
        // Query to get the last ACC_DETAIL_TYPE for the specified ACCOUNT_TYPE
        $lastQuery = "SELECT MAX(CHART_ACC_CODE) AS max_acc_detail_type FROM chart_detail WHERE ACC_TYPE = '$tabId' and ACC_DETAIL_TYPE = '$expFirstData' and CHART_HEAD_CODE = '$expSecondData'";
        $res1 = mysqli_query($con, $lastQuery);

        $row = mysqli_fetch_assoc($res1);
        if ($row['max_acc_detail_type'] != '' && $row['max_acc_detail_type'] != null) {
            $id = $row['max_acc_detail_type'];
            // Increment the retrieved ACC_DETAIL_TYPE or set it to 0 if no record found
        } else {
            $lastQuery = "SELECT MAX(CHART_ACC_CODE) AS max_acc_detail_type FROM chart_detail ";
            $res1 = mysqli_query($con, $lastQuery);
            $row = mysqli_fetch_assoc($res1);
            $id = $row['max_acc_detail_type'] ? 1 : $row['max_acc_detail_type'] ;
        }
        $id++;


        $query = "INSERT INTO chart_detail(CHART_HEAD_CODE, CHART_ACC_CODE, CHART_ACC_DESC, ACC_TYPE, ACC_DETAIL_TYPE, `$act`) VALUES('$expSecondData','$id','$name','$tabId','$expFirstData',1)";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }

    // edit first exp data 
    if ($_POST['chartOfAccountActionExp'] == 'ExpFirstEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $query = "UPDATE account_types_detail SET DESCRIPTION = '$name' where ACC_DETAIL_TYPE ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // edit Sedond exp data 
    if ($_POST['chartOfAccountActionExp'] == 'ExpSecondEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $query = "UPDATE chart_head SET HEAD_DESC = '$name' where HEAD_CODE ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // edit Third exp data 
    if ($_POST['chartOfAccountActionExp'] == 'ExpThirdEditData') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $status = $_POST['status'];

        $act = $status == 1 ? 'is_active' : 'is_block';
        $act1 = $status == 1 ? 'is_block' : 'is_active';

        $query = "UPDATE chart_detail SET CHART_ACC_DESC = '$name', `$act` = '1' ,`$act1` = 0 where id = '$id' ";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }

    // Delete first exp data 
    if ($_POST['chartOfAccountActionExp'] == 'ExpFirstDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE account_types_detail SET deleted_at = '$date' where ACC_DETAIL_TYPE ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // Delete Second exp data 
    if ($_POST['chartOfAccountActionExp'] == 'ExpSecondDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE chart_head SET deleted_at = '$date' where head_code ='$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
    // Delete Third revenue data 
    if ($_POST['chartOfAccountActionExp'] == 'ExpThirdDeleteData') {
        $id = $_POST['id'];
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE chart_detail SET deleted_at = '$date' where id = '$id'";
        $res = mysqli_query($con, $query);
        if ($res) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
