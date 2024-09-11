<?php
include "connection.php";
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'getVType') {
        $id = $_POST['id'];
        $output = 0;
        $query = "SELECT * from voucher_type where id= '$id' and deleted_at is null";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $output  = $row['name'];
        }
        echo $output;
    }
    if ($_POST['action'] == 'getFirstData') {
        $cheque = $_POST['cheque'];
        $mode = $_POST['mode'];
        $output = 0;
        // un-official
        if ($mode == 1) {
            $query = "SELECT * from v_master_c where id= '$id' and deleted_at is null";
        }
        // official 
        else if ($mode == 2) {
            $query = "SELECT * from v_master where CHQNO= '$cheque' and posted != 'Y' and auto_posted != 'Y' and deleted_at is null ";
        }
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $output  = $row['VNO'];
        }
        echo $output;
    }
    if ($_POST['action'] == 'postFirst') {
        $voucherId = $_POST["voucherId"];
        $vTypeId = $_POST["vTypeId"];
        $receivedBy = $_POST['receivedBy'] && !empty($_POST['receivedBy']) ? $_POST['receivedBy'] : '-';
        $remark = $_POST["remark"] && !empty($_POST['remark']) ?  $_POST["remark"] : '-';
        $source = $_POST["source"] && !empty($_POST['source']) ? $_POST["source"] : '-';
        $taxDepDate = $_POST["taxDepDate"] && !empty($_POST['taxDepDate']) ? $_POST["taxDepDate"] : '-';
        $cheque = $_POST["cheque"] && !empty($_POST['cheque']) ? $_POST["cheque"] : '-';
        $chequeDate = $_POST["chequeDate"] && !empty($_POST['chequeDate']) ? $_POST["chequeDate"] : '-';
        $vDate = $_POST["vDate"] && !empty($_POST['vDate']) ? $_POST["vDate"] : '-';
        $mode = $_POST["mode"];
        $voucherTypeName = $_POST["voucherTypeName"];
        $cpr = $_POST["cpr"];
        $postFlag = $_POST["postFlag"];
        $array = $_POST['array'];

        $invoiceLast = $_POST['invoiceLast'];
        $chequeLast = $_POST['chequeLast'];
        $poLast = $_POST['poLast'];
        $agentID = $_POST['agentID'];
        $agType = null;
        $btnType = $_POST['btnType'];
        if ($agentID > 0) {
            $agType = "SELECT * from set_supplier_master where ag_id = '$agentID'";
            $Agres = mysqli_query($con, $agType);
            if (mysqli_num_rows($Agres) > 0) {
                $rowAg = mysqli_fetch_assoc($Agres);
                $agType = $rowAg['SUPPLIER_TYPE'];
            }
        }
        $date = date("Y-m-d H:i:s");

        if ($postFlag == 'N') {
            $postedVal = null;
            $post_dateVal = null;
            $AutoPostVal = $postFlag;
        }
        if ($postFlag == 'Y') {
            $postedVal = $postFlag;
            $post_dateVal = $date;
            $AutoPostVal = $postFlag;
        }

        if ($voucherId != 'N') {
            if ($mode == '1') {
                $tableName = 'v_master_c';
                $tableDetail = 'v_detail_c';
            }
            if ($mode == '2') {
                $tableName = 'v_master';
                $tableDetail = 'v_detail';
            }
            
            $queryDelete = "UPDATE $tableName set deleted_at = NOW() where vno = $voucherId and VTYPE = '$voucherTypeName' and deleted_at is null";
            $resdel = mysqli_query($con, $queryDelete);
           
            $queryDelete = "UPDATE $tableDetail set deleted_at = NOW() where vno = $voucherId and VTYPE = '$voucherTypeName' and deleted_at is null";
            $resdel = mysqli_query($con, $queryDelete);

        }else{
            if ($mode == '1') {
                $query = "SELECT * from v_master_c where VTYPE = '$voucherTypeName' and deleted_at is null order by vno desc limit 1;";
            }
            if ($mode == '2') {
                $query = "SELECT * from v_master where VTYPE = '$voucherTypeName' and deleted_at is null order by vno desc limit 1;";
            }
            $voucherId = 0;
            $res = mysqli_query($con, $query);
            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_assoc($res);
                $voucherId = (int)$row['VNO'];
            }
            $voucherId++;
        }
        
            // if ($voucherId == '' || empty($voucherId)) {
                if($btnType == 'notUpdate' && $postFlag != 'Y'){
                    if ($mode == '1') {
                        $query = "SELECT * from v_master_c where VTYPE = '$voucherTypeName' and deleted_at is null order by vno desc limit 1;";
                    }
                    if ($mode == '2') {
                        $query = "SELECT * from v_master where VTYPE = '$voucherTypeName' and deleted_at is null order by vno desc limit 1;";
                    }
                    $voucherId = 0;
                    $res = mysqli_query($con, $query);
                    if (mysqli_num_rows($res) > 0) {
                        $row = mysqli_fetch_assoc($res);
                        $voucherId = (int)$row['VNO'];
                    }
                    $voucherId++;
                }
            // }
            if ($mode == '1') {
                $query = "INSERT INTO v_master_c(VNO, VType, VDATE, REMARKS, CHQDT, CHQNO, POSTED, POST_DT, SOURCE, VTYPE_ID, AUTO_POSTED, CPR_INT, TAX_DEPOSITE_DATE, RECEIVED_BY) VALUES( '$voucherId', '$voucherTypeName', '$vDate', '$remark', '$chequeDate', '$cheque', '$postedVal', '$post_dateVal', '$source', '$vTypeId', '$AutoPostVal', '$cpr', '$taxDepDate', '$receivedBy' )";
            } else if ($mode == '2') {
                $query = "INSERT INTO v_master(VNO, VType, VDATE, REMARKS, CHQDT, CHQNO, POSTED, POST_DT, SOURCE, VTYPE_ID, AUTO_POSTED, CPR_INT, TAX_DEPOSITE_DATE, RECEIVED_BY) VALUES( '$voucherId', '$voucherTypeName', '$vDate', '$remark', '$chequeDate', '$cheque', '$postedVal', '$post_dateVal', '$source', '$vTypeId', '$AutoPostVal', '$cpr', '$taxDepDate', '$receivedBy' )";
            }

            $res = mysqli_query($con, $query);

            // $jvVno = 1;
            // if($mode == '1'){
            //     $tableNameM = "v_master_c";
            //     $tableNameD = "v_detail_c";
            // }else if($mode == '2'){
            //     $tableNameM = "v_master";
            //     $tableNameD = "v_detail";
            // }

            // if($tax == 'Y'){
            //     $query3="SELECT ( vno + 1 ) as vno from $tableNameM where vType = 'JV' order by vno desc";
            //     $res3=mysqli_query($con,$query3);
            //     if(mysqli_num_rows($res3) > 0){
            //         $row3=mysqli_fetch_assoc($res3);
            //         $jvVno = $row3['vno'];
            //     }

            //     $query4 = "INSERT INTO $tableNameM (VNO, VType, VDATE, REMARKS, CHQDT, CHQNO, POSTED, POST_DT, SOURCE, VTYPE_ID, AUTO_POSTED, CPR_INT, TAX_DEPOSITE_DATE, RECEIVED_BY) VALUES( '$jvVno', 'JV', '$vDate', 'JV for Tax against Voucher #$voucherId $voucherTypeName', '$chequeDate', '$cheque', '$postedVal', '$post_dateVal', '$source', (SELECT id from voucher_type where name = 'PV' limit 1), '$AutoPostVal', '$cpr', '$taxDepDate', '$receivedBy' )";

            // }

                // $aaaa=[];
            for ($i = 0; $i < sizeof($array); $i++) {
                $data = $array[$i];
                $head = $data['head'];
                $acc = $data['acc'];
                $desc = $data['desc'];
                $debit = $data['debit'] ? $data['debit'] : 0;
                $credit = $data['credit'] ? $data['credit'] : 0;
                $acc_type = $data['acc_type'];
                $acc_detail_type = $data['acc_detail_type'];
                $v_type_name = $data['v_type_name'];
                $exam_tax = $data['exam_tax'];
                $on_tax = $data['on_tax'];
                $tax = $data['tax'];

                // $query1="SELECT * from v_detail order by vno desc limit 1";
                // $res1=mysqli_query($con,$query1);
                // if(mysqli_num_rows($res1) > 0){
                //     $vno = $row['VNO'] ;
                // }else{
                //     $vno = 1;
                // }

                if ($mode == '1') {
                    $query2 = 'INSERT INTO v_detail_c(VNO, VTYPE, HEAD_CODE, CHART_ACC_CODE, DEBIT, CREDIT, INVNO, PONO, SUPNO, SUPTYPE, CHQNO, ACC_DETAIL_TYPE, ACC_TYPE, TAX_CHK, EXEM_TAX, ON_TAX) VALUES("' . $voucherId . '", "' . $v_type_name . '", "' . $head . '", "' . $acc . '", "' . $debit . '", "' . $credit . '", "' . $invoiceLast . '", "' . $poLast . '" , "' . $agentID . '" , "' . $agType . '" , " ' . $chequeLast . ' ", "' . $acc_detail_type . '", "' . $acc_type . '", "' . $tax . '", "' . $exam_tax . '", "' . $on_tax . '")';
                } else if ($mode == '2') {
                    $query2 = 'INSERT INTO v_detail(VNO, VTYPE, HEAD_CODE, CHART_ACC_CODE, DEBIT, CREDIT, INVNO, PONO, SUPNO, SUPTYPE, CHQNO, ACC_DETAIL_TYPE, ACC_TYPE, TAX_CHK, EXEM_TAX, ON_TAX) VALUES("' . $voucherId . '", "' . $v_type_name . '", "' . $head . '", "' . $acc . '", "' . $debit . '", "' . $credit . '", "' . $invoiceLast . '", "' . $poLast . '" , "' . $agentID . '" ,  "' . $agType . '" , " ' . $chequeLast . ' ", "' . $acc_detail_type . '", "' . $acc_type . '", "' . $tax . '", "' . $exam_tax . '", "' . $on_tax . '")';
                }
                $res2 = mysqli_query($con, $query2);
                // array_push($aaaa,$query2);

                // $query5 = 'INSERT INTO '.$tableNameD.'(VNO, VTYPE, HEAD_CODE, CHART_ACC_CODE, DEBIT, CREDIT, INVNO, PONO, SUPNO, SUPTYPE, CHQNO, ACC_DETAIL_TYPE, ACC_TYPE, TAX_CHK ) VALUES("' . $jvVno . '", "JV", "' . $head . '", "' . $acc . '", "' . $debit . '", "' . $credit . '", "' . $acc_detail_type . '", "' . $acc_type . '", "' . $tax .'")';
                // $res4=mysqli_query($con,$query4);


                // echo " head ".$data['head'].' acc '.$data['acc'].' desc '.$data['desc'].' debit '.$data['debit'].' credit '.$data['credit'];
            }

            if ($res) {
                // echo json_encode($aaaa);
                echo $voucherId;
            } else {
                echo 0;
            }
        
       
    }

    if ($_POST['action'] == 'taxRevese') {
        $OldvoucherId = $_POST["voucherId"];
        $vTypeId = $_POST["vTypeId"];
        $receivedBy = $_POST['receivedBy'] && !empty($_POST['receivedBy']) ? $_POST['receivedBy'] : '-';
        $remark = $_POST["remark"] && !empty($_POST['remark']) ?  $_POST["remark"] : '-';
        $source = 'VNO-'.$OldvoucherId.'-'.$_POST["voucherTypeName"];
        $taxDepDate = $_POST["taxDepDate"] && !empty($_POST['taxDepDate']) ? $_POST["taxDepDate"] : '-';
        $cheque = $_POST["cheque"] && !empty($_POST['cheque']) ? $_POST["cheque"] : '-';
        $chequeDate = $_POST["chequeDate"] && !empty($_POST['chequeDate']) ? $_POST["chequeDate"] : '-';
        $vDate = $_POST["vDate"] && !empty($_POST['vDate']) ? $_POST["vDate"] : '-';
        $mode = $_POST["mode"];
        $voucherTypeName = $_POST["voucherTypeName"];
        $cpr = $_POST["cpr"];
        $postFlag = 'Y';
        $array = $_POST['array'];

        $invoiceLast = $_POST['invoiceLast'];
        $chequeLast = $_POST['chequeLast'];
        $poLast = $_POST['poLast'];
        $agentID = $_POST['agentID'];

        

        $agType = null;
        if ($agentID > 0) {
            $agType = "SELECT * from set_supplier_master where ag_id = '$agentID'";
            $Agres = mysqli_query($con, $agType);
            if (mysqli_num_rows($Agres) > 0) {
                $rowAg = mysqli_fetch_assoc($Agres);
                $agType = $rowAg['SUPPLIER_TYPE'];
            }
        }
        $date = date("Y-m-d H:i:s");
        $postedVal = $postFlag;
        $post_dateVal = $date;
        $AutoPostVal = $postFlag;
        // if ($voucherId == '' || empty($voucherId)) {
        if ($mode == '1') {
            $query = "SELECT * from v_master_c where VTYPE = 'JV' order by vno desc limit 1;";
        }
        if ($mode == '2') {
            $query = "SELECT * from v_master where VTYPE = 'JV' order by vno desc limit 1;";
        }
        $voucherId = 0;
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $voucherId = (int)$row['VNO'];
        }
        $voucherId++;
        // }
        if ($mode == '1') {
            $query = "INSERT INTO v_master_c(VNO, VType, VDATE, REMARKS, CHQDT, CHQNO, POSTED, POST_DT, SOURCE, VTYPE_ID, AUTO_POSTED, JV_TAX, JV_TYPE, CPR_INT, TAX_DEPOSITE_DATE, RECEIVED_BY) VALUES( '$voucherId', 'JV', '$vDate', 'JV for Tax against Voucher #$OldvoucherId $voucherTypeName', '$chequeDate', '$cheque', '$postedVal', '$post_dateVal', '$source', (SELECT id from voucher_type where name = 'JV' limit 1), '$AutoPostVal', '$OldvoucherId', '$voucherTypeName', '$cpr', '$taxDepDate', '$receivedBy' )";
        } else if ($mode == '2') {
            $query = "INSERT INTO v_master(VNO, VType, VDATE, REMARKS, CHQDT, CHQNO, POSTED, POST_DT, SOURCE, VTYPE_ID, AUTO_POSTED, JV_TAX, JV_TYPE, CPR_INT, TAX_DEPOSITE_DATE, RECEIVED_BY) VALUES( '$voucherId', 'JV', '$vDate', 'JV for Tax against Voucher #$OldvoucherId $voucherTypeName', '$chequeDate', '$cheque', '$postedVal', '$post_dateVal', '$source', (SELECT id from voucher_type where name = 'JV' limit 1), '$AutoPostVal', '$OldvoucherId', '$voucherTypeName', '$cpr', '$taxDepDate', '$receivedBy' )";
        }

        $res = mysqli_query($con, $query);


        for ($i = 0; $i < sizeof($array); $i++) {
            $data = $array[$i];
            $head = $data['head'];
            $acc = $data['acc'];
            $desc = $data['desc'];
            $debit = $data['debit'] ? $data['debit'] : 0;
            $credit = $data['credit'] ? $data['credit'] : 0;
            $acc_type = $data['acc_type'];
            $acc_detail_type = $data['acc_detail_type'];
            $v_type_name = $data['v_type_name'];
            $exam_tax = $data['exam_tax'];
            $on_tax = $data['on_tax'];
            $tax = $data['tax'];

            if($tax == 'Y'){
                $debit1 = $credit;
                $credit1 = $debit;
            }else{
                $debit1 = $debit;
                $credit1 = $credit;
            }

            if ($mode == '1') {
                $query2 = 'INSERT INTO v_detail_c(VNO, VTYPE, HEAD_CODE, CHART_ACC_CODE, DEBIT, CREDIT, INVNO, PONO, SUPNO, SUPTYPE, CHQNO, ACC_DETAIL_TYPE, ACC_TYPE) VALUES("' . $voucherId . '", "JV", "' . $head . '", "' . $acc . '", "' . $debit1 . '", "' . $credit1 . '", "' . $invoiceLast . '", "' . $poLast . '" , "' . $agentID . '" , "' . $agType . '" , " ' . $chequeLast . ' ", "' . $acc_detail_type . '", "' . $acc_type . '")';
            } else if ($mode == '2') {
                $query2 = 'INSERT INTO v_detail(VNO, VTYPE, HEAD_CODE, CHART_ACC_CODE, DEBIT, CREDIT, INVNO, PONO, SUPNO, SUPTYPE, CHQNO, ACC_DETAIL_TYPE, ACC_TYPE) VALUES("' . $voucherId . '", "JV", "' . $head . '", "' . $acc . '", "' . $debit1 . '", "' . $credit1 . '", "' . $invoiceLast . '", "' . $poLast . '" , "' . $agentID . '" ,  "' . $agType . '" , " ' . $chequeLast . ' ", "' . $acc_detail_type . '", "' . $acc_type . '")';
            }
            $res2 = mysqli_query($con, $query2);

        }

        if($res) {
            echo $voucherId;
        } else {
            echo 0;
        }
    }


    if ($_POST['action'] == 'getChartHead') {
        // echo "
        // <option>1</option>
        // <option>2</option>
        // <option>3</option>
        // <option>4</option>
        // ";
        // $mode = $_POST['mode'];
        $output = '<option value="" selected>SELECT</option>';

        $query = "SELECT * from chart_detail where deleted_at is null ";

        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $output .= '
                <option value="' . $row['id'] . '">' . $row['CHART_ACC_DESC'] . '</option>
                ';
            }
        }
        echo $output;
    }

    if ($_POST['action'] == 'getsecondAccDetail') {
        $id = $_POST['id'];
        $query = "SELECT * from chart_detail where id = $id";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            echo $row['CHART_HEAD_CODE'] . '!' . $row['CHART_ACC_CODE'] . "!" . $row['ACC_TYPE'] . '!' . $row['ACC_DETAIL_TYPE'];
        } else {
            echo "!!!";
        }
    }


    // Your existing code to connect to the database and handle the request
    if ($_POST['action'] == 'getDetails') {
        $id = $_POST['id'];
        $mode = $_POST['mode'];
        $type = $_POST['type'];

        $data = array(); // Initialize an empty array to store the data

        if ($mode == 1) {
            $query = "SELECT * from v_master_c where vno = '$id' and vType = '$type' and deleted_at is null";
            $res = mysqli_query($con, $query);
            if ($res) {
                if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $query1="SELECT * from v_master_c where jv_tax = '$id' and  jv_type = '$type' and deleted_at is null";
                        $res1=mysqli_query($con,$query1);
                        if(mysqli_num_rows($res1) > 0){
                            $row['jv_made'] = '1';
                        }else{
                            $row['jv_made'] = '0';
                        }
                        $data['master'][] = $row;
                    }
                } else {
                    $data['master'] = array();
                }
            } else {
                echo json_encode(array(
                    'success' => false,
                    'error' => mysqli_error($con)
                ));
                exit;
            }

            $query1 = "SELECT v_detail_c.*,chart_detail.id as cId from v_detail_c join chart_detail on v_detail_c.head_code = chart_detail.chart_head_code where v_detail_c.vno = '$id' and v_detail_c.vType = '$type' and v_detail_c.head_code = chart_detail.chart_head_code and v_detail_c.chart_acc_code = chart_detail.chart_acc_code and chart_detail.deleted_at is null and v_detail_c.deleted_at is null order by v_detail_c.id";
            $res1 = mysqli_query($con, $query1);
            if ($res1) {
                if (mysqli_num_rows($res1) > 0) {
                    while ($row1 = mysqli_fetch_assoc($res1)) {
                        $data['detail'][] = $row1;
                    }
                } else {
                    $data['detail'] = array();
                }
            } else {
                echo json_encode(array(
                    'success' => false,
                    'error' => mysqli_error($con)
                ));
                exit;
            }
        } elseif ($mode == 2) {
            $query = "SELECT * from v_master where vno = '$id' and vType = '$type' and deleted_at is null";
            $res = mysqli_query($con, $query);
            if ($res) {
                if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $query1="SELECT * from v_master where jv_tax = '$id' and  jv_type = '$type' and deleted_at is null";
                        $res1=mysqli_query($con,$query1);
                        if(mysqli_num_rows($res1) > 0){
                            $row['jv_made'] = '1';
                        }else{
                            $row['jv_made'] = '0';
                        }
                        $data['master'][] = $row;
                    }
                } else {
                    $data['master'] = array();
                }
            } else {
                echo json_encode(array(
                    'success' => false,
                    'error' => mysqli_error($con)
                ));
                exit;
            }

            $query1 = "SELECT v_detail.*,chart_detail.id as cId from v_detail join chart_detail on v_detail.head_code = chart_detail.chart_head_code where v_detail.vno = '$id' and v_detail.vType = '$type' and v_detail.head_code = chart_detail.chart_head_code and v_detail.chart_acc_code = chart_detail.chart_acc_code and chart_detail.deleted_at is null and v_detail.deleted_at is null order by v_detail.id";
            $res1 = mysqli_query($con, $query1);
            if ($res1) {
                if (mysqli_num_rows($res1) > 0) {
                    while ($row1 = mysqli_fetch_assoc($res1)) {
                        $data['detail'][] = $row1;
                    }
                } else {
                    $data['detail'] = array();
                }
            } else {
                echo json_encode(array(
                    'success' => false,
                    'error' => mysqli_error($con)
                ));
                exit;
            }
        }

        // Return the data as JSON
        echo json_encode(array(
            'success' => true,
            'data' => $data
        ));
    }
}
