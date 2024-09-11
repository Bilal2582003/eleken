<?php
$vno = $_GET['vno'];
$vtype = $_GET['vtype'];
$mode = $_GET['mode'];
$parent = "Booking";
$page = "Voucher Print";
include "../Views/master/links.php";

include "../Models/connection.php";

$query="SELECT * from property order by id desc limit 1";
$res=mysqli_query($con,$query);
if(mysqli_num_rows($res) > 0){
    $row=mysqli_fetch_assoc($res);
    $propertyName = $row['name']; 
    $companyName = $row['company_name']; 
}else{
    $companyName = ''; 
    $propertyName = '';
}
?>
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;

    }

    .voucher {
        width: 100%;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border: 1px solid #000;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        font-size: 12px;
    }

    header {
        margin-bottom: 20px;
        text-align: center;
    }

    .title-box {
        /* border: 1px solid #000; */
        display: inline-block;
        padding: 5px;
    }

    .voucher-info {
        display: flex;
        /* justify-content: space-between; */
        justify-content: space-evenly;
        margin-bottom: 20px;
    }

    .voucher-info .left,
    .voucher-info .right {
        width: 45%;
        text-align: right;
    }

    .voucher-info p {
        margin: 2px 0;
    }

    .payment-details {
        margin-bottom: 20px;
    }

    .payment-details .row {
        display: flex;
        justify-content: space-between;
    }

    .column {
        width: 45%;
    }

    .financial-details {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .financial-details th,
    .financial-details td {
        border: 1px solid #000;
        padding: 10px;
        text-align: left;
    }

    .financial-details th {
        background-color: #f2f2f2;
    }

    .financial-details .main-head {
        font-weight: bold;
    }

    .financial-details .sub-head {
        padding-left: 20px;
    }

    .remarks {
        margin-bottom: 20px;
    }

    .remarks p {
        margin: 0 0 10px 0;
    }

    .signatures .row {
        display: flex;
        justify-content: space-between;
    }

    .signatures .column {
        width: 45%;
    }

    .signatures p {
        margin: 0 0 10px 0;
    }

    h1 {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .bordered {
        border: 1px solid black;
        padding: 3px;
        font-weight: bold;
        font-size: 15px;
    }
    .bordered1 {
        border: 1px solid black;
        padding: 3px;
        font-weight: normal;
        font-size: 15px;
    }

    @media print {
        .card {
            page-break-inside: avoid !important;
        }
    }

    @page {
        size: A4 Portrait !important;
        /* margin: 0; */
    }
</style>
<div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php
                    if ($mode == 1) {
                        $table_name = 'v_master_c';
                        $table_nameD = 'v_detail_c';
                    } else if ($mode == 2) {
                        $table_name = 'v_master';
                        $table_nameD = 'v_detail';
                    }

                    function numberToWords($number)
                    {
                        $words = [
                            'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten',
                            'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
                        ];

                        $tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

                        if ($number < 20) {
                            return $words[$number];
                        } elseif ($number < 100) {
                            return $tens[(int)($number / 10)] . ($number % 10 ? ' ' . $words[$number % 10] : '');
                        } elseif ($number < 1000) {
                            return $words[(int)($number / 100)] . ' hundred' . ($number % 100 ? ' and ' . numberToWords($number % 100) : '');
                        } elseif ($number < 1000000) {
                            return numberToWords((int)($number / 1000)) . ' thousand' . ($number % 1000 ? ' ' . numberToWords($number % 1000) : '');
                        } elseif ($number < 1000000000) {
                            return numberToWords((int)($number / 1000000)) . ' million' . ($number % 1000000 ? ' ' . numberToWords($number % 1000000) : '');
                        }

                        return 'Number is too large to convert to words';
                    }

                    $query = "SELECT * from $table_name where vno = '$vno' and vtype_id = '$vtype'  and deleted_at is null  ";
                    $res = mysqli_query($con, $query);
                    if (mysqli_num_rows($res) > 0) {
                        $row = mysqli_fetch_assoc($res);
                    ?>
                        <div class="voucher">
                            <header>
                                <div class="row" style="display: flex;justify-content:space-between">
                                    <div class="title-box col-sm-3">
                                        <?php
                                        if ($mode == '2') {
                                            // $companyName = '<h1>S.P.G ENTERPRISES</h1>';
                                            $companyName = $companyName;
                                            $staric = '';
                                        ?>
                                            <img src="../assets/images/megamall.jpeg" width="100%" height="100px"></img>
                                        <?php
                                        } else {
                                            $companyName = $companyName;
                                            $staric = '*';
                                        ?>
                                            <div style="width:100%;height:100px"></div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="title-box col-sm-4">
                                        <h1 style="font-size:20px;"><?php echo $propertyName; ?></h1>
                                        <?php
                                        echo $companyName;
                                        ?>
                                    </div>
                                    <div class="title-box col-sm-3 text-break">
                                        <h1 style="width: 80%; height:70px;font-size:50px;border:1px solid black;">
                                            <?php
                                            echo $row['VTYPE'];
                                            ?>
                                        </h1>
                                        <p style="width: 80%;font-weight: bolder;">
                                            <?php
                                            if ($row['POSTED'] == 'Y') {
                                                echo "POSTED " . $staric;
                                            } else {
                                                echo "UN POSTED " . $staric;
                                            };
                                            ?>
                                        </p>
                                    </div>

                                </div>
                                <div class="voucher-info">
                                    <div class="left">

                                    </div>
                                    <div class="right" style="font-size:medium;font-weight:bolder">
                                        <!-- <p><strong>Paid:</strong> 0.00</p>
                                    <p><strong>Payable Balance:</strong> 0.00</p> -->
                                        <p><strong>Voucher No: </strong><?php echo $row['VNO'] . '-' . $row['VTYPE'];  ?></p>
                                        <p><strong>Date: </strong> <?php echo date("d-M-Y", strtotime($row['VDATE']));  ?></p>
                                    </div>
                                </div>
                            </header>

                            <section class="remarks">
                                <p class="row"><strong class="col-sm-2">RECEIVED BY: </strong> <span class="col-sm-10" style="border-bottom: 1px solid black;text-transform:capitalize;font-size:13px"> <?php echo $row['RECEIVED_BY'] ?> </span></p>

                                <p class="row"><strong class="col-sm-2">SUM OF RUPEES:</strong> <span class="col-sm-10" style="border-bottom: 1px solid black;text-transform:capitalize;font-size:13px" id="numInRs"> </span> </p>

                                <p class="row"><strong class="col-sm-2">REMARKS:</strong> <span class="col-sm-10" style="border-bottom: 1px solid black;text-transform:capitalize;font-size:13px"> <?php echo $row['REMARKS']; ?></span> </p>
                                <br>
                                <br>
                                <br>
                                <br>

                            </section>
                            <section class="row">
                                <div class="col-sm-6">
                                    <table style="width: 100%;border:1px solid black; text-align:center">
                                        <thead>
                                            <tr>
                                                <th class="bordered">Cheque #</th>
                                                <th class="bordered">Cheque Date</th>
                                                <th class="bordered">Payment Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="bordered">
                                                    <?php echo $row['CHQNO'] ?>
                                                </td>
                                                <td class="bordered">
                                                    <?php echo date("d-M-Y", strtotime($row['CHQDT'])); ?>
                                                </td>
                                                <td class="bordered" id="totalPaymentAmount">
                                                    0
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    <table style="width: 100%;border:1px solid black; text-align:center;background-color:#e6e9ed">
                                        <thead>
                                            <tr>
                                                <th class="bordered">Payable </th>
                                                <th class="bordered">Pay</th>
                                                <th class="bordered">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="bordered">
                                                    00
                                                </td>
                                                <td class="bordered">
                                                    00
                                                </td>
                                                <td class="bordered">
                                                    00
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-5">

                                </div>
                            </section>
                            <section class="row mt-3">
                                <div class="col-sm-12">

                                    <table style="width: 100%; text-align:center">
                                        <thead>
                                            <tr>
                                                <th style="border-top: 1px solid black; border-left:1px solid black;">

                                                </th>
                                                <th style="border-top: 1px solid black;">

                                                </th>
                                                <th colspan="2" class="bordered">
                                                    A/C DESC
                                                </th>
                                                <th class="bordered">
                                                    Debit
                                                </th>
                                                <th class="bordered">
                                                    Credit
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $vTypeName = $row['VTYPE'];
                                            $totalAmount = 0;
                                            $totalDebit = 0;
                                            $totalCredit = 0;
                                            $query1 = "SELECT $table_nameD.*  from $table_nameD where $table_nameD.vno = '$vno' and $table_nameD.vtype = '$vTypeName' and deleted_at is null ";
                                            $res1 = mysqli_query($con, $query1);
                                            if (mysqli_num_rows($res1) > 0) {
                                                while ($row1 = mysqli_fetch_assoc($res1)) {
                                                    $chart_acc_code = $row1['CHART_ACC_CODE'];
                                                    $head_code = $row1['HEAD_CODE'];
                                                    $acc_detail_type = $row1['ACC_DETAIL_TYPE'];
                                                    $acc_type = $row1['ACC_TYPE'];

                                                    $query2 = "SELECT * from chart_detail where chart_acc_code = '$chart_acc_code' and CHART_HEAD_CODE = '$head_code' and ACC_DETAIL_TYPE = '$acc_detail_type' and ACC_TYPE = '$acc_type'  and deleted_at is null ";
                                                    $res2 = mysqli_query($con, $query2);
                                                    if (mysqli_num_rows($res2) > 0) {
                                                        $row2 = mysqli_fetch_assoc($res2);
                                                        $chart_acc_code_name = $row2['CHART_ACC_DESC'];
                                                    } else {
                                                        $chart_acc_code_name = '';
                                                    }

                                                    $query3 = "SELECT * from chart_head where head_code = '$head_code' and ACC_DETAIL_TYPE = '$acc_detail_type' and ACC_TYPE = '$acc_type'  and deleted_at is null ";
                                                    $res2 = mysqli_query($con, $query3);
                                                    if (mysqli_num_rows($res2) > 0) {
                                                        $row2 = mysqli_fetch_assoc($res2);
                                                        $head_name = $row2['HEAD_DESC'];
                                                    } else {
                                                        $head_name = '';
                                                    }
                                                    $totalAmount += $row1['DEBIT'];
                                                    $totalDebit += $row1['DEBIT'];
                                                    $totalCredit += $row1['CREDIT'];
                                            ?>
                                                    <tr>
                                                        <td colspan="2" style="color:transparent; border-left: 1px solid #000;">
                                                            <?php echo $head_name; ?>
                                                        </td>

                                                        <td class="bordered1" style="text-align: left; text-wrap: wrap;">
                                                            <?php echo $head_name; ?>
                                                        </td>
                                                        <td class="bordered1" style="text-align: left; text-wrap: wrap;">
                                                            <?php echo $chart_acc_code_name; ?>
                                                        </td>
                                                        <td class="bordered1" style="width: 200px;">
                                                            <?php echo number_format($row1['DEBIT']); ?>
                                                        </td>
                                                        <td class="bordered1" style="width: 200px;">
                                                            <?php echo number_format($row1['CREDIT']); ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>

                                            <tr>


                                                <th class="bordered" colspan="2">
                                                    RECEIVED BY
                                                </th>
                                                <th class="bordered" colspan="2">Total: </th>
                                                <th class="bordered"><?php echo number_format($totalDebit) ?></th>
                                                <th class="bordered"><?php echo number_format($totalCredit) ?></th>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </section>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>

                            <section class="row mt-3" style="text-align: center;">
                                <!-- <div class="col-sm-12"> -->
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">___________________</p>
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">___________________</p>
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">___________________</p>
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">___________________</p>
                                <!-- </div> -->
                            </section>
                            <section class="row " style="text-align: center;">
                                <!-- <div class="col-sm-12"> -->
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">Prepared By</p>
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">Checked By</p>
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">Approved By</p>
                                <p class="col-sm-3" style="font-weight:bold;font-size:small">Sanctioned By</p>
                                <!-- </div> -->
                            </section>

                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var a = document.getElementById("totalPaymentAmount")
    a.innerText = `<?php echo number_format($totalAmount); ?>`;
    var b = document.getElementById('numInRs')
    b.innerText = `<?php echo numberToWords($totalAmount); ?> Only`;
</script>