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
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .inputBorder {
        width: 100%;
        border: none;
    }

    .tdborder {
        border: 1px solid black;

    }

    .checkboxCenter {
        text-align: center;
    }

    .con1 {
        width: 200px;
        padding: 8px;
        font-size: medium;
    }

    .desc {
        max-width: 100% !important;
    }

    #totalCredit,
    #totalDebit {
        background-color: lightgray;
        margin: 2px;
        border-left: 1px solid black;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-style: none !important;
        top: 61%
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 25px;
        height: 36px;
    }

    .select2 .select2-container,
    .select2-container--default,
    .select2-container--open,
    .select2-container--focus,
    .select2-container--above {
        width: 100% !important;

    }

    .select2 .select2-container,
    .select2-container--default,
    .select2-container--focus {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        height: 36px
    }

    .select2,
    .select2-container,
    .select2-container--default,
    .select2-container--below,
    .select2-container--open {
        width: 100%;
    }

    .blue-c {
        background-color: #727cf5;
        color: white;
    }

    .blue-r {
        background-color: white;
        color: #727cf5;
        border-color: #727cf5;
    }

    .yellow-c {
        background-color: #d7a103;
        color: white;
    }

    .yellow-r {
        background-color: white;
        color: #d7a103;
        border-color: #d7a103;
    }

    td {
        width: 10%
    }

    /* Optional: Adjust padding and margin for the tbody */
</style>
<div class="page-content" style="max-width:100%">

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Voucher</h6>
                    <h6 class="card-title" class="PaymentModeName"></h6>

                    <br>
                    <div style="display: flex;justify-content:center">

                        <!-- <button id="fetch" class="m-2 btn btn-secondary">Fetch</button> -->
                        <button id="officialBtn" class="m-2 btn blue-c">Official</button>
                        <button id="unofficialBtn" class="m-2 btn yellow-c">Un-official</button>
                        <div id="PaymentMode" style="display:none">2</div>
                    </div>
                    <hr>
                    <br>
                    <div class="row">
                        <button type="button" class="m-2 btn btn-primary" id="query">query</button>
                        <div style="display: none;" class="query">no</div>
                        <button id="save" class="m-2 btn btn-success">Save</button>
                        <button id="print" class="m-2 btn btn-success">Print</button>
                    </div>
                    <div class="row first">
                        <div class="col-sm-2 col-md-2 " style="display: flex;justify-content:center;align-items:center;">
                            <div style="border:1px solid black; margin:10px;height:70%;width:80%;font-size:4rem;display:flex;justify-content:center;align-items:center" id="vTypeNameHed">

                            </div>
                        </div>

                        <div class="col-sm-8" id="voucherMainData" style="border: 1px solid black;padding:20px;border-radius:8px;box-shadow:1px 1px 5px black">
                            <div class="row p-1">
                                <div class="col-sm-2" style="font-size:medium ;">Voucher#</div>
                                <input type="number" min="1" id="voucher" style="width: 40%;" class="col-sm-3 navigate" />
                                <div class="col-sm-1 navigate"></div>
                                <div class="col-sm-1"></div>
                                <div class="col-sm-3" style="font-size:medium ;">Voucher Date</div>
                                <input type="date" style="width: 40%;" id="vDate" value="<?php echo date("Y-m-d");  ?>" class="col-sm-2 form-control navigate" />
                            </div>
                            <div class="row p-1">
                                <div class="col-sm-2">Voucher Type</div>
                                <input type="text" class="col-sm-1 mr-1 navigate" id="vTypeId" />
                                <input type="text" class="col-sm-2 mr-1 navigate" id="vTypeName" style="width: 40%;" disabled />
                            </div>
                            <div class="row p-1">
                                <div class="col-sm-12 ">
                                    <div class="row" style="display:flex; justify-content:space-between;">

                                        <div class="col-sm-2 ">Cheque No</div>
                                        <input type="text" class="col-sm-3 navigate" id="cheque" />


                                        <div class=" offset-2 col-sm-2 ">Cheque Date</div>
                                        <input class="col-sm-3 navigate" value="<?php echo date("Y-m-d");  ?>" type="date" id="chequeDate" />

                                    </div>
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-sm-2">CPR No</div>
                                <input type="text" class="col-sm-2 navigate" id="cpr" />
                                <div class="col-sm-2">Tax Dep Date</div>
                                <input type="date" class="col-sm-2 navigate" id="taxDepDate" style="width: 40%;" />
                                <div class="col-sm-2 pr-0">Source</div>
                                <input type="text" id="source" class="col-sm-2 p-l-1 navigate" style="width: 40%;" />
                            </div>
                            <div class="row p-1">
                                <div class="col-sm-2">Remarks</div>
                                <input type="text" id="remark" class="col-sm-10 navigate" />
                            </div>
                            <div class="row p-1">
                                <div class="col-sm-2">Received By</div>
                                <input type="text" id="receivedBy" class="col-sm-10 navigate" />
                            </div>
                        </div>

                        <div class="col-sm-1 p-5" style="text-align:center">
                            <!-- <button class="row p-1 btn btn-primary m-1" id="postBtn">POST</button> -->
                            <!-- <button class="row p-1 btn btn-primary m-1">Copy Voucher</button>
                            <button class="row p-1 btn btn-primary m-1" id="taxReverse">Tax Reverse</button> -->
                        </div>

                    </div>
                    <div class="row mt-2 second navigate" id="voucherSecondData" style="border: 1px solid black;padding:20px;border-radius:8px;box-shadow:1px 2px 8px black">
                        <div class="col-sm-12 navigate" style="border: 1px solid black;padding:20px;border-radius:8px;box-shadow:1px 2px 8px black; ">
                            <div style="display:block;overflow-y:auto;max-height:200px;margin-bottom:10px">
                                <table width="100%" cellpadding="4px" cellspacing="4px">
                                    <thead>
                                        <th>H/Code</th>
                                        <th>A/c</th>
                                        <th>Description</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th class="m-1">Tax</th>
                                        <th class="m-1">On Tax</th>
                                        <th class="m-1">Exam Tax</th>
                                        <th class="m-1">CHK</th>
                                        <th class="m-1"></th>
                                        <th class="m-1">Cheque</th>
                                    </thead>
                                    <tbody id="secondTbody">
                                        <?php
                                        for ($i = 0; $i <= 50; $i++) {
                                        ?>
                                            <tr>
                                                <td class="tdborder"><input disabled class="inputBorder headCode1 bg-white navigate" type="text"></td>
                                                <td class="tdborder"><input disabled class="inputBorder accCode1 bg-white navigate" type="text"></td>
                                                <td class="tdborder navigate" style="width: 40%;">
                                                    <select class="navigate inputBorder e1 desc desc1 mySelectBox ">

                                                    </select>
                                                </td>
                                                <td class="tdborder"><input class="inputBorder debit navigate" type="text"></td>
                                                <td class="tdborder"><input class="inputBorder credit navigate" type="text"></td>
                                                <td class="checkboxCenter"><input type="checkbox"></td>
                                                <td class="checkboxCenter"><input type="checkbox"></td>
                                                <td class="checkboxCenter"><input type="checkbox"></td>
                                                <td class="checkboxCenter"><input type="checkbox"></td>
                                                <td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                                <td class="checkboxCenter"><input type="checkbox"></td>
                                                <td style="display:none"><input class="acc_detail_type" type="text"></td>
                                                <td style="display:none"><input class="acc_type" type="text"></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        <!-- <tr>
                                            <td class="tdborder"><input disabled class="inputBorder headCode2 bg-white" type="text"></td>
                                            <td class="tdborder"><input disabled class="inputBorder accCode2 bg-white" type="text"></td>
                                            <td class="tdborder" style="width: 40%;">
                                                <select class="inputBorder e1 desc desc2">

                                                </select>
                                            </td>
                                            <td class="tdborder"><input class="inputBorder debit" type="text"></td>
                                            <td class="tdborder"><input class="inputBorder credit" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td style="display:none"><input class="acc_detail_type" type="text"></td>
                                            <td style="display:none"><input class="acc_type" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td class="tdborder"><input disabled class="inputBorder headCode3 bg-white" type="text"></td>
                                            <td class="tdborder"><input disabled class="inputBorder accCode3 bg-white" type="text"></td>
                                            <td class="tdborder" style="width: 40%;">
                                                <select class="inputBorder e1 desc desc3">

                                                </select>
                                            </td>
                                            <td class="tdborder"><input class="inputBorder debit" type="text"></td>
                                            <td class="tdborder"><input class="inputBorder credit" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td style="display:none"><input class="acc_detail_type" type="text"></td>
                                            <td style="display:none"><input class="acc_type" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td class="tdborder"><input disabled class="inputBorder headCode4 bg-white" type="text"></td>
                                            <td class="tdborder"><input disabled class="inputBorder accCode4 bg-white" type="text"></td>
                                            <td class="tdborder" style="width: 40%;">
                                                <select class="inputBorder e1 desc desc4">

                                                </select>
                                            </td>
                                            <td class="tdborder"><input class="inputBorder debit" type="text"></td>
                                            <td class="tdborder"><input class="inputBorder credit" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td style="display:none"><input class="acc_detail_type" type="text"></td>
                                            <td style="display:none"><input class="acc_type" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td class="tdborder"><input disabled class="inputBorder headCode5 bg-white" type="text"></td>
                                            <td class="tdborder"><input disabled class="inputBorder accCode5 bg-white" type="text"></td>
                                            <td class="tdborder" style="width: 40%;">
                                                <select class="inputBorder e1 desc desc5">

                                                </select>
                                            </td>
                                            <td class="tdborder"><input class="inputBorder debit" type="text"></td>
                                            <td class="tdborder"><input class="inputBorder credit" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td style="display:none"><input class="acc_detail_type" type="text"></td>
                                            <td style="display:none"><input class="acc_type" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td class="tdborder"><input disabled class="inputBorder headCode5 bg-white" type="text"></td>
                                            <td class="tdborder"><input disabled class="inputBorder accCode5 bg-white" type="text"></td>
                                            <td class="tdborder" style="width: 40%;">
                                                <select class="inputBorder e1 desc desc5">

                                                </select>
                                            </td>
                                            <td class="tdborder"><input class="inputBorder debit" type="text"></td>
                                            <td class="tdborder"><input class="inputBorder credit" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td style="display:none"><input class="acc_detail_type" type="text"></td>
                                            <td style="display:none"><input class="acc_type" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td class="tdborder"><input disabled class="inputBorder headCode5 bg-white" type="text"></td>
                                            <td class="tdborder"><input disabled class="inputBorder accCode5 bg-white" type="text"></td>
                                            <td class="tdborder" style="width: 40%;">
                                                <select class="inputBorder e1 desc desc5">

                                                </select>
                                            </td>
                                            <td class="tdborder"><input class="inputBorder debit" type="text"></td>
                                            <td class="tdborder"><input class="inputBorder credit" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td style="display:none"><input class="acc_detail_type" type="text"></td>
                                            <td style="display:none"><input class="acc_type" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td class="tdborder"><input disabled class="inputBorder headCode5 bg-white" type="text"></td>
                                            <td class="tdborder"><input disabled class="inputBorder accCode5 bg-white" type="text"></td>
                                            <td class="tdborder" style="width: 40%;">
                                                <select class="inputBorder e1 desc desc5">

                                                </select>
                                            </td>
                                            <td class="tdborder"><input class="inputBorder debit" type="text"></td>
                                            <td class="tdborder"><input class="inputBorder credit" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td style="display:none"><input class="acc_detail_type" type="text"></td>
                                            <td style="display:none"><input class="acc_type" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td class="tdborder"><input disabled class="inputBorder headCode5 bg-white" type="text"></td>
                                            <td class="tdborder"><input disabled class="inputBorder accCode5 bg-white" type="text"></td>
                                            <td class="tdborder" style="width: 40%;">
                                                <select class="inputBorder e1 desc desc5">

                                                </select>
                                            </td>
                                            <td class="tdborder"><input class="inputBorder debit" type="text"></td>
                                            <td class="tdborder"><input class="inputBorder credit" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td style="display:none"><input class="acc_detail_type" type="text"></td>
                                            <td style="display:none"><input class="acc_type" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td class="tdborder"><input disabled class="inputBorder headCode5 bg-white" type="text"></td>
                                            <td class="tdborder"><input disabled class="inputBorder accCode5 bg-white" type="text"></td>
                                            <td class="tdborder" style="width: 40%;">
                                                <select class="inputBorder e1 desc desc5">

                                                </select>
                                            </td>
                                            <td class="tdborder"><input class="inputBorder debit" type="text"></td>
                                            <td class="tdborder"><input class="inputBorder credit" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td style="display:none"><input class="acc_detail_type" type="text"></td>
                                            <td style="display:none"><input class="acc_type" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td class="tdborder"><input disabled class="inputBorder headCode5 bg-white" type="text"></td>
                                            <td class="tdborder"><input disabled class="inputBorder accCode5 bg-white" type="text"></td>
                                            <td class="tdborder" style="width: 40%;">
                                                <select class="inputBorder e1 desc desc5">

                                                </select>
                                            </td>
                                            <td class="tdborder"><input class="inputBorder debit" type="text"></td>
                                            <td class="tdborder"><input class="inputBorder credit" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td style="display:none"><input class="acc_detail_type" type="text"></td>
                                            <td style="display:none"><input class="acc_type" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td class="tdborder"><input disabled class="inputBorder headCode5 bg-white" type="text"></td>
                                            <td class="tdborder"><input disabled class="inputBorder accCode5 bg-white" type="text"></td>
                                            <td class="tdborder" style="width: 40%;">
                                                <select class="inputBorder e1 desc desc5">

                                                </select>
                                            </td>
                                            <td class="tdborder"><input class="inputBorder debit" type="text"></td>
                                            <td class="tdborder"><input class="inputBorder credit" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td style="display:none"><input class="acc_detail_type" type="text"></td>
                                            <td style="display:none"><input class="acc_type" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td class="tdborder"><input disabled class="inputBorder headCode5 bg-white" type="text"></td>
                                            <td class="tdborder"><input disabled class="inputBorder accCode5 bg-white" type="text"></td>
                                            <td class="tdborder" style="width: 40%;">
                                                <select class="inputBorder e1 desc desc5">

                                                </select>
                                            </td>
                                            <td class="tdborder"><input class="inputBorder debit" type="text"></td>
                                            <td class="tdborder"><input class="inputBorder credit" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                            <td class="checkboxCenter"><input type="checkbox"></td>
                                            <td style="display:none"><input class="acc_detail_type" type="text"></td>
                                            <td style="display:none"><input class="acc_type" type="text"></td>
                                        </tr> -->
                                    </tbody>

                                </table>
                            </div>
                            <div class="con" style="display: flex;justify-content:flex-start;align-items:flex-start">

                                <div class="con1" style="width:30%"><input class="inputBorder" style="color: rgba(0, 0, 0, 0);" value="H/Code"></div>
                                <div class="con1" style="width:30%" style="color: rgba(0, 0, 0, 0);"><input class="inputBorder" style="color: rgba(0, 0, 0, 0);" value="A/c"></div>
                                <!-- <div class="con1" style="width:93%" style="color: rgba(0, 0, 0, 0);"><input class="inputBorder" style="color: rgba(0, 0, 0, 0);" value="DESCRIPTION"></div> -->

                                <div class="con1" style="width:90%; background-color:lightgreen;text-align:center;cursor:pointer;" id="addmorerows">Add Rows</div>
                                <div class="con1" style="width:25%" id="totalDebit"></div>
                                <div class="con1" style="width:30%" id="totalCredit"></div>
                                <div class="con1" style="width:45%">&nbsp;</div>
                                <div class="con1" style="width:45%">&nbsp;</div>
                                <!-- <div class="con1" style="width:45%">&nbsp;</div> -->

                            </div>

                            <div class="row p-1">
                                <div class="col-sm-2">
                                    Invoice Bill#
                                </div>
                                <input type="text" class="col-sm-2 pl-1 invoiceBillLast" />
                                <div class="col-sm-2">
                                    Cheque#
                                </div>
                                <input type="text" class="col-sm-2 pl-1 chequeLast" />
                                <div class="col-sm-1">
                                    PO
                                </div>
                                <input type="text" class="col-sm-2 pl-1 poLast" />
                            </div>
                            <div class="row p-1">
                                <div class="col-sm-2">
                                    Supplier/Customer
                                </div>
                                <input type="text" class="col-sm-1 m-1 agent-id" disabled />

                                <!-- <input type="text" class="col-sm-8 m-1"  /> -->
                                <div class="col-sm-7 m-1">
                                    <select class="e1  agent">
                                        <option value="0" selected>
                                            SELECT
                                        </option>

                                        <?php
                                        $query = "SELECT * from a_admin ";
                                        $res = mysqli_query($con, $query);
                                        if (mysqli_num_rows($res) > 0) {
                                            while ($row = mysqli_fetch_assoc($res)) {
                                                echo "<option value='" . $row['id'] . "'>" . $row['name']  . "</option>";
                                            }
                                        }

                                        ?>
                                    </select>

                                </div>

                            </div>
                        </div>
                        <!-- <div class="col-sm-4"> -->
                        <!-- <table width="100%" style="text-align: center;"> -->
                        <!-- <thead>
                                    <th class="m-1">Tax</th>
                                    <th class="m-1">On Tax</th>
                                    <th class="m-1">Exam Tax</th>
                                    <th class="m-1">CHK</th>
                                    <th class="m-1"></th>
                                    <th class="m-1">Cheque</th>
                                </thead> -->
                        <!-- <tbody>
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td><input type="checkbox"></td>
                                        <td style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                </tbody> -->
                        <!-- </table> -->

                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="save_post_flag" style="display:none">

</div>

<?php include "footer.php"; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        $(".e1").select2();
    });
</script>

<script>
    $(document).ready(function() {
        $('.mySelectBox').on('select2:select', function(e) {
            var selectedValue = e.params.data.text; // Select2 data object has 'text' and 'id'
            var tempInput = document.createElement('input');
            tempInput.style = 'position: absolute; left: -1000px; top: -1000px';
            tempInput.value = selectedValue;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);

        });
    });

    $(document).ready(function() {
        $("#addmorerows").on("click", function() {

            var mode = $("#PaymentMode").html()
            $.ajax({
                url: "_reverseVoucher.php",
                type: "POST",
                data: {
                    mode: mode,
                    action: "getChartHead"
                },
                success: function(data) {
                    // console.log(data)

                    // element.setAttribute('data-live-search', 'true');
                    var select = `<select class="inputBorder e1 desc desc1 mySelectBox navigate" >${data}</select>`;

                    var table = $("#secondTbody")
                    for (var i = 1; i <= 20; i++) {
                        table.append(`<tr><td class="tdborder"><input disabled class="inputBorder headCode5 bg-white" type="text"></td><td class="tdborder"><input disabled class="inputBorder accCode5 bg-white" type="text"></td><td class="tdborder" style="width: 40%;">${select}</td><td class="tdborder"><input class="inputBorder debit" type="text"></td><td class="tdborder"><input class="inputBorder credit" type="text"></td><td class="checkboxCenter"><input type="checkbox"></td><td class="checkboxCenter"><input type="checkbox"></td><td class="checkboxCenter"><input type="checkbox"></td><td class="checkboxCenter"><input type="checkbox"></td><td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td><td class="checkboxCenter"><input type="checkbox"></td><td style="display:none"><input class="acc_detail_type" type="text"></td><td style="display:none"><input class="acc_type" type="text"></td></tr> `);
                    }
                    document.querySelectorAll('.desc').forEach(function(element) {
                        element.setAttribute('data-live-search', 'true');
                        // console.log("this " + element.innerHTML);
                    });
                    $(".e1").select2();
                }

            })

        })

        function formatNumberWithCommas(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Event listener for debit input field
        $(document).on('input', '.debit, .credit', function() {
            let value = $(this).val().replace(/,/g, ''); // Remove existing commas
            if (!isNaN(value) && value !== "") {
                $(this).val(formatNumberWithCommas(value));
            }
        });


        $("#print").on("click", function() {
            window.location.assign("_voucherPrint.php?vno=" + $("#voucher").val() + '&vtype=' + $("#vTypeId").val() + '&mode=' + $("#PaymentMode").html())
        })
        var button = document.getElementById('query');

        function vouchersBtn() {
            // Check if the element has the class 'btn-primary'
            if (button.classList.contains('btn-primary')) {
                // Disable the element
                $("#voucher").prop("disabled", true)
            } else {
                $("#voucher").prop("disabled", false)
            }
        }
        vouchersBtn();

        $("#query").on("click", function() {
            $("#voucher").prop("disabled", false)
            $(".query").html("yes")
            $("#vTypeId").prop("disabled", false)

            $("#save").prop("disabled", true)
            $(this).removeClass("btn-primary").addClass("btn-success");
            vouchersBtn()
        })

        $(".agent").on("change", function() {
            $(".agent-id").val($(this).val())
        })

        $(".first").hide()
        $(".second").hide()
        $("#officialBtn").on("click", function() {
            $("body").css('color', 'black')
            $("#officialBtn").removeClass("blue-c").addClass("blue-r");
            $("#unofficialBtn").removeClass("yellow-r").addClass("yellow-c");

            $(".first").hide()
            $(".second").hide()
            $(".first").slideDown("slow")
            $(".second").slideDown("slow")
            $("#PaymentMode").html(2)
            $(".PaymentModeName").html("Official")

            $(".query").html("no")
            $("#query").removeClass("btn-success").addClass("btn-primary");
            $('#voucherSecondData').each(function() {
                $(this).find('input').each(function() {
                    $(this).val(''); // Clear the input value
                });
                $(this).find('select').each(function() {
                    $(this).val(''); // Reset the select box to its default value
                });
            });
            $("#totalDebit").html(0.00)
            $("#totalCredit").html(0.00)

            $('#voucherMainData').find('input').each(function() {
                if ($(this).attr('type') == 'date') {
                    $(this).val('<?php echo date("Y-m-d"); ?>');
                } else {
                    $(this).val('');
                }
            });

            vouchersBtn()

            getChartOfAccHeads()
        })
        $("#unofficialBtn").on("click", function() {
            $("body").css('color', 'red')
            $("#unofficialBtn").removeClass("yellow-c").addClass("yellow-r");
            $("#officialBtn").removeClass("blue-r").addClass("blue-c");

            $(".first").hide()
            $(".second").hide()
            $(".first").slideDown("slow")
            $(".second").slideDown("slow")
            $("#PaymentMode").html(1)
            $(".PaymentModeName").html("Un-Official")

            $(".query").html("no")
            $("#query").removeClass("btn-success").addClass("btn-primary");
            $('#voucherSecondData').each(function() {
                $(this).find('input').each(function() {
                    $(this).val(''); // Clear the input value
                });
                $(this).find('select').each(function() {
                    $(this).val(0); // Reset the select box to its default value
                });
            });
            $("#totalDebit").html(0.00)
            $("#totalCredit").html(0.00)
            $('#voucherMainData').find('input').each(function() {
                if ($(this).attr('type') == 'date') {
                    $(this).val('<?php echo date("Y-m-d"); ?>');
                } else {
                    $(this).val('');
                }
            });
            vouchersBtn()

            getChartOfAccHeads()
        })

        function getChartOfAccHeads() {
            var mode = $("#PaymentMode").html()
            $.ajax({
                url: "_reverseVoucher.php",
                type: "POST",
                data: {
                    mode: mode,
                    action: "getChartHead"
                },
                success: function(data) {
                    // console.log(data)

                    document.querySelectorAll('.desc').forEach(function(element) {
                        element.innerHTML = data;
                        element.setAttribute('data-live-search', 'true');
                        // console.log("this " + element.innerHTML);

                    });
                    // $('.desc').html(data).attr('data-live-search', 'true').select2();

                    // for (var i = 0; i <= 4; i++) {
                    //     document.getElementsByClassName('desc')[i].innerHTML = data
                    //     console.log("this " + document.getElementsByClassName('desc')[i].innerHTML)
                    // }
                    // $('.desc').select2();
                }

            })
        }
        $("#vTypeId").on("keyup", function() {
            var id = $(this).val();
            var mode = $(".PaymentMode").html();
            console.log("yes" + id)
            if (id && id != '0') {
                $.ajax({
                    url: "_reverseVoucher.php",
                    type: "POST",
                    data: {
                        mode: mode,
                        id: id,
                        action: "getVType"
                    },
                    success: function(data) {
                        console.log(data)
                        if (data != 0) {
                            $("#vTypeName").val(data)
                            $("#vTypeNameHed").html(data)
                        } else {
                            $("#vTypeName").val('')
                            $("#vTypeNameHed").html('')
                        }
                    }
                })
            } else {
                $("#vTypeName").val('')
                $("#vTypeNameHed").html('')
            }
        })

        $("#cheque").on("keyup", function() {

            setTimeout(() => {

                autofillFirst();
            }, 2000)
        })

        function autofillFirst() {
            var cheque = $("#cheque").val();
            var mode = $("#PaymentMode").html();
            $.ajax({
                url: "_reverseVoucher.php",
                type: "POST",
                data: {
                    cheque: cheque,
                    mode: mode,
                    action: "getFirstData"
                },
                success: function(data) {
                    console.log(data)
                    if (data != 0) {
                        $("#voucher").val(data)

                    } else {
                        $("#voucher").val('')
                    }
                }
            })

        }

        function addDatainTable() {
            var postFlag = $(".save_post_flag").html();
            var voucher = $("#voucher");
            voucher.prop("disabled", false)
            var voucherId = voucher.val()
            if (!voucherId) {
                voucherId = 'N';
            }
            // alert(voucherId)
            voucher.prop("disabled", true)
            var vDate = $("#vDate").val()
            var cheque = $("#cheque").val()
            var chequeDate = $("#chequeDate").val()
            var taxDepDate = $("#taxDepDate").val()
            var source = $("#source").val()
            var remark = $("#remark").val()
            var receivedBy = $("#receivedBy").val()
            var vTypeId = $("#vTypeId").val()
            var cpr = $("#cpr").val()
            var voucherTypeName = $("#vTypeName").val();
            var mode = $("#PaymentMode").html();

            var invoiceLast = $(".invoiceBillLast").val() ? $(".invoiceBillLast").val() : '-';
            var chequeLast = $(".chequeLast").val() ? $(".chequeLast").val() : '-';
            var poLast = $(".poLast").val() ? $(".poLast").val() : '-';
            var agentID = $(".agent-id").val() ? $(".agent-id").val() : '-';
            // console.log(invoiceLast+' '+ chequeLast + ' '+ poLast + ' '+ agentID)
            // console.log(
            //     "voucherId: " + voucherId + "\n" +
            //     "vDate: " + vDate + "\n" +
            //     "cheque: " + cheque + "\n" +
            //     "chequeDate: " + chequeDate + "\n" +
            //     "taxDepDate: " + taxDepDate + "\n" +
            //     "source: " + source + "\n" +
            //     "remark: " + remark + "\n" +
            //     "receivedBy: " + receivedBy + "\n" +
            //     "vTypeId: " + vTypeId + "\n" +
            //     "cpr: " + cpr + "\n" +
            //     "voucherTypeName: " + voucherTypeName
            // );


            const descElement = document.querySelectorAll('.desc');
            var arrays = [];
            // Convert the NodeList to an array and use reduce to calculate the sum
            const desces = Array.from(descElement).reduce((accumulator, input) => {
                const parentTr = $(input).closest('tr');
                // head 
                var td = parentTr.children('td').eq(0); // Selects the first <td> element
                var input1 = td.find('input')
                // acc 
                var td1 = parentTr.children('td').eq(1); // Selects the first <td> element
                var input2 = td1.find('input')
                // debit 
                var td2 = parentTr.children('td').eq(3); // Selects the first <td> element
                var input3 = td2.find('input')
                // credit 
                var td3 = parentTr.children('td').eq(4); // Selects the first <td> element
                var input4 = td3.find('input')

                var td5 = parentTr.children('td').eq(5);
                var input5 = td5.find('input')

                var td6 = parentTr.children('td').eq(6);
                var input6 = td6.find('input')

                var td7 = parentTr.children('td').eq(7);
                var input7 = td7.find('input')


                var acc_type = parentTr.find(".acc_type")
                var acc_detail_type = parentTr.find(".acc_detail_type")
                var vtypename = $("#vTypeName").val()
                if (input1.val() && input2.val()) {
                    var tax = input5.prop('checked') == true ? 'Y' : 'N'
                    var on_tax = input6.prop('checked') == true ? 'Y' : 'N'
                    var exam_tax = input7.prop('checked') == true ? 'Y' : 'N'


                    var data = {
                        "head": input1.val(),
                        "acc": input2.val(),
                        "desc": $(input).find("option:selected").text(),
                        "debit": input3.val().replace(/,/g, ''),
                        "credit": input4.val().replace(/,/g, ''),
                        "acc_type": acc_type.val(),
                        "acc_detail_type": acc_detail_type.val(),
                        "v_type_name": vtypename,
                        "tax": tax,
                        "on_tax": on_tax,
                        "exam_tax": exam_tax

                    }
                    arrays.push(data);
                }
                // if (!parentTr.is(':hidden')) {
                // if (!parentTr.hasClass('disabled-row')) {
                //     const value = parseFloat(input.value) || 0; // Convert input value to a number
                //     return accumulator + value;
                // }
                return arrays;
            }, 0);

            console.log(arrays);
            if ($("#totalDebit").html() == $("#totalCredit").html()) {


                if (confirm('Do you want to post!')) {
                    var buttonType = 'notUpdate';
                    if (postFlag == 'N') {
                        if ($("#save").html() == 'Update') {
                            buttonType = 'update'
                        }
                    }
                    $.ajax({
                        url: "_reverseVoucher.php",
                        type: "POST",
                        data: {
                            btnType: buttonType,
                            voucherTypeName: voucherTypeName,
                            vTypeId: vTypeId,
                            receivedBy: receivedBy,
                            remark: remark,
                            source: source,
                            taxDepDate: taxDepDate,
                            cheque: cheque,
                            chequeDate: chequeDate,
                            vDate: vDate,
                            mode: mode,
                            voucherId: voucherId,
                            cpr: cpr,
                            postFlag: postFlag,
                            array: arrays,
                            invoiceLast: invoiceLast,
                            chequeLast: chequeLast,
                            poLast: poLast,
                            agentID: agentID,
                            action: "postFirst"
                        },
                        success: function(data) {
                            console.log(data)
                            $("#voucher").val(data)
                            fetchDetail($("#voucher").val(), $("#PaymentMode").html(), $("#vTypeName").val())
                        }
                    })
                }
            } else {
                alert("Debit Credit are not equal!")
            }
        }
        $("#save").on("click", function() {
            $(".save_post_flag").html("N")
            addDatainTable()
        })
        $("#postBtn").on('click', function() {
            $(this).prop("disabled", true)
            $(".save_post_flag").html("Y")
            addDatainTable()
        })

        $(document).on('change', ".desc", function() {
            var id = $(this).val() ? $(this).val() : 0
            var tr = $(this).closest('tr')
            var td = tr.children('td').eq(0); // Selects the first <td> element
            var input1 = td.find('input')

            var td1 = tr.children('td').eq(1); // Selects the first <td> element
            var input2 = td1.find('input')

            var acc_type = tr.find(".acc_type")
            var acc_detail_type = tr.find(".acc_detail_type")
            $.ajax({
                url: "_reverseVoucher.php",
                type: "POST",
                data: {
                    id: id,
                    action: "getsecondAccDetail"
                },
                success: function(data) {
                    var data = data.split('!')
                    var hed = data[0]
                    var acc = data[1]
                    var acc_type_val = data[2]
                    var acc_detail_type_val = data[3]
                    input1.val(hed)
                    input2.val(acc)

                    acc_type.val(acc_type_val)
                    acc_detail_type.val(acc_detail_type_val)
                    // console.log(acc_detail_type.val())

                }
            })
        })

        $("#taxReverse").on("click", function() {
            var voucher = $("#voucher");
            voucher.prop("disabled", false)
            var voucherId = voucher.val()
            // alert(voucherId)
            voucher.prop("disabled", true)
            var vDate = $("#vDate").val()
            var cheque = $("#cheque").val()
            var chequeDate = $("#chequeDate").val()
            var taxDepDate = $("#taxDepDate").val()
            var source = $("#source").val()
            var remark = $("#remark").val()
            var receivedBy = $("#receivedBy").val()
            var vTypeId = $("#vTypeId").val()
            var cpr = $("#cpr").val()
            var voucherTypeName = $("#vTypeName").val();
            var mode = $("#PaymentMode").html();

            var invoiceLast = $(".invoiceBillLast").val() ? $(".invoiceBillLast").val() : '-';
            var chequeLast = $(".chequeLast").val() ? $(".chequeLast").val() : '-';
            var poLast = $(".poLast").val() ? $(".poLast").val() : '-';
            var agentID = $(".agent-id").val() ? $(".agent-id").val() : '-';

            const descElement = document.querySelectorAll('.desc');
            var arrays = [];
            // Convert the NodeList to an array and use reduce to calculate the sum
            const desces = Array.from(descElement).reduce((accumulator, input) => {
                const parentTr = $(input).closest('tr');
                // head 
                var td = parentTr.children('td').eq(0); // Selects the first <td> element
                var input1 = td.find('input')
                // acc 
                var td1 = parentTr.children('td').eq(1); // Selects the first <td> element
                var input2 = td1.find('input')
                // debit 
                var td2 = parentTr.children('td').eq(3); // Selects the first <td> element
                var input3 = td2.find('input')
                // credit 
                var td3 = parentTr.children('td').eq(4); // Selects the first <td> element
                var input4 = td3.find('input')

                var td5 = parentTr.children('td').eq(5);
                var input5 = td5.find('input')

                var td6 = parentTr.children('td').eq(6);
                var input6 = td6.find('input')

                var td7 = parentTr.children('td').eq(7);
                var input7 = td7.find('input')


                var acc_type = parentTr.find(".acc_type")
                var acc_detail_type = parentTr.find(".acc_detail_type")
                var vtypename = $("#vTypeName").val()
                if (input1.val() && input2.val() && input3.val().replace(/,/g, '') && input3.val().replace(/,/g, '') > 0) {
                    var tax = input5.prop('checked') == true ? 'Y' : 'N'
                    var on_tax = input6.prop('checked') == true ? 'Y' : 'N'
                    var exam_tax = input7.prop('checked') == true ? 'Y' : 'N'


                    var data = {
                        "head": input1.val(),
                        "acc": input2.val(),
                        "desc": $(input).find("option:selected").text(),
                        "debit": input3.val().replace(/,/g, ''),
                        "credit": input4.val().replace(/,/g, ''),
                        "acc_type": acc_type.val(),
                        "acc_detail_type": acc_detail_type.val(),
                        "v_type_name": vtypename,
                        "tax": tax,
                        "on_tax": on_tax,
                        "exam_tax": exam_tax

                    }
                    arrays.push(data);
                }
                // if (!parentTr.is(':hidden')) {
                // if (!parentTr.hasClass('disabled-row')) {
                //     const value = parseFloat(input.value) || 0; // Convert input value to a number
                //     return accumulator + value;
                // }
                return arrays;
            }, 0);

            console.log(arrays);
            if (confirm('Do you want to post!')) {
                $.ajax({
                    url: "_reverseVoucher.php",
                    type: "POST",
                    data: {
                        voucherTypeName: voucherTypeName,
                        vTypeId: vTypeId,
                        receivedBy: receivedBy,
                        remark: remark,
                        source: source,
                        taxDepDate: taxDepDate,
                        cheque: cheque,
                        chequeDate: chequeDate,
                        vDate: vDate,
                        mode: mode,
                        voucherId: voucherId,
                        cpr: cpr,
                        array: arrays,
                        invoiceLast: invoiceLast,
                        chequeLast: chequeLast,
                        poLast: poLast,
                        agentID: agentID,
                        action: "taxRevese"
                    },
                    success: function(data) {
                        console.log(data)
                        // $("#voucher").val(data)
                        fetchDetail($("#voucher").val(), $("#PaymentMode").html(), $("#vTypeName").val())
                    }
                })
            }
        })

        // function data() {
        //     $("#officialBtn").trigger("click");
        // }
        // data()

        // $("#voucher").on("change", function() {
        //     if ($("#vTypeName").val()) {
        //         fetchDetail($(this).val(), $("#PaymentMode").html(), $("#vTypeName").val())
        //     } else {
        //         console.log("no")
        //     }
        // })
        $("#voucher").on("keyup", function() {
            if ($("#vTypeName").val()) {
                if (event.keyCode === 13 && $(".query").html() == 'yes') {

                    $("#save").prop("disabled", false)
                    fetchDetail($(this).val(), $("#PaymentMode").html(), $("#vTypeName").val())
                    $(".query").html('no')
                    $("#query").removeClass("btn-success").addClass("btn-primary");

                }
            } else {
                console.log("no")
            }
        })

        function fetchDetail(id, mode, vType) {
            // console.log(id + mode + vType)
            clearForm();

            $.ajax({
                url: "_reverseVoucher.php",
                type: "POST",
                data: {
                    id: id,
                    mode: mode,
                    type: vType,
                    action: "getDetails"
                },
                success: function(data) {

                    var jsonData = JSON.parse(data); // Parse the JSON string into an object

                    if (jsonData.success) {
                        var detailData = jsonData.data; // Access the data object
                        var master = detailData['master'][0]
                        var detail = detailData['detail']

                        // Now you can access the specific data you need from the detailData object
                        console.log("master" + JSON.stringify(detailData['master'][0])); // For testing purposes
                        console.log("this" + JSON.stringify(detail[0])); // For testing purposes
                        if (detailData['master'][0]) {


                            $("#voucher").prop('disabled', true)
                            // $("#save").prop('disabled', true)
                            $("#save").html('Update')
                            $("#vTypeId").prop('disabled', true)
                            $("#vDate").val(master['VDATE'])
                            $("#cheque").val(master['CHQNO'])
                            $("#remark").val(master['REMARKS'])
                            $("#cpr").val(master['CRP_INT'])
                            $("#source").val(master['SOURCE'])
                            $("#chequeDate").val(master['CHQDT'])
                            $("#receivedBy").val(master['RECEIVED_BY'])
                            if (master['POSTED'] == 'Y') {
                                $("#postBtn").prop('disabled', true)
                            } else {
                                $("#postBtn").prop('disabled', false)
                            }
                            if (master['jv_made'] == '1') {
                                $("#postBtn").prop('disabled', true)
                                $("#taxReverse").prop('disabled', true)
                            } else if (master['jv_made'] == '0') {
                                $("#taxReverse").prop('disabled', false)
                            }
                            var tableBody = $("#secondTbody")
                            var selectboxes = $(".e1").eq(1).html();
                            for (var i = 0; i < detail.length; i++) {
                                // Check if the current row exists; if not, create it
                                var tr = tableBody.children('tr').eq(i);
                                if (tr.length === 0) {
                                    // Create a new row with the same structure as the others
                                    tr = $('<tr>');
                                    for (var j = 0; j < 1; j++) { // Assuming there are 8 columns
                                        tr.append(`<td class="tdborder"><input disabled class="inputBorder headCode1 bg-white" type="text"></td><td class="tdborder"> <input disabled class="inputBorder accCode1 bg-white" type="text"></td><td class="tdborder" style="width: 40%;"><select class="inputBorder e1 desc desc1 mySelectBox">${selectboxes}</select></td><td class="tdborder"><input class="inputBorder debit" type="text"></td><td class="tdborder"><input class="inputBorder credit" type="text"></td><td class="checkboxCenter"><input type="checkbox"></td><td class="checkboxCenter"><input type="checkbox"></td><td class="checkboxCenter"><input type="checkbox"></td><td class="checkboxCenter"><input type="checkbox"></td><td class="checkboxCenter" style="max-width: 51px;"><input style="width: -webkit-fill-available;" type="text"></td><td class="checkboxCenter"><input type="checkbox"></td><td style="display:none"><input class="acc_detail_type" type="text"></td><td style="display:none">  <input class="acc_type" type="text"></td>`); // Modify based on your actual row structure
                                    }
                                    tableBody.append(tr);
                                }

                                var td = tr.find('td').eq(2); // Assuming the dropdown is in the third column
                                var debitTd = tr.find('td').eq(3); // Assuming the debit column is the fourth
                                var creditTd = tr.find('td').eq(4); // Assuming the credit column is the fifth

                                // Set debit and credit values
                                var debitInput = debitTd.find('input').val(formatNumberWithCommas(detail[i]['DEBIT']));
                                var creditInput = creditTd.find('input').val(formatNumberWithCommas(detail[i]['CREDIT']));

                                var selectedId = detail[i]['cId']; // Assuming 'cId' is the correct key for the dropdown value
                                var selectElement = td.find('select');

                                // Iterate over the options of the select element
                                selectElement.find('option').each(function() {
                                    if ($(this).val() == selectedId) {
                                        $(this).prop('selected', true);
                                        $(this).trigger('change');
                                        return false;
                                    }
                                });

                                $(".agent").find('option').each(function() {
                                    if ($(this).val() == detail[i]['SUPNO']) {
                                        $(this).prop('selected', true);
                                        $(this).trigger('change');
                                        return false;
                                    }
                                });

                                // Set checkbox values
                                var tax = detail[i]['TAX_CHK'];
                                var on_tax = detail[i]['ON_TAX'];
                                var exam_tax = detail[i]['EXAM_TAX'];

                                var taxTd = tr.find('td').eq(5); // Assuming the tax column is the sixth
                                var onTaxTd = tr.find('td').eq(6); // Assuming the on_tax column is the seventh
                                var examTaxTd = tr.find('td').eq(7); // Assuming the exam_tax column is the eighth

                                if (tax == 'Y') {
                                    taxTd.find('input').prop('checked', true);
                                }
                                if (on_tax == 'Y') {
                                    onTaxTd.find('input').prop('checked', true);
                                }
                                if (exam_tax == 'Y') {
                                    examTaxTd.find('input').prop('checked', true);
                                }
                            }

                            // for (var i = 0; i < detail.length; i++) {
                            //     var tr = tableBody.children('tr').eq(i); // Use 'i' to iterate through rows
                            //     var td = tr.find('td').eq(2); // Assuming the dropdown is in the third column

                            //     var debitTd = tr.find('td').eq(3); // Assuming the debit 
                            //     var debitInput = debitTd.find('input').val(formatNumberWithCommas(detail[i]['DEBIT']));

                            //     var creditTd = tr.find('td').eq(4); // Assuming the credit 
                            //     var creditInput = creditTd.find('input').val(formatNumberWithCommas(detail[i]['CREDIT']));

                            //     var selectedId = detail[i]['cId']; // Assuming 'id' is the correct key for the dropdown value
                            //     // Find the select element within the td
                            //     var selectElement = td.find('select');

                            //     // Iterate over the options of the select element
                            //     selectElement.find('option').each(function() {
                            //         // Check if the value of the option matches the selectedId
                            //         if ($(this).val() == selectedId) {
                            //             // Set the selected property of the matching option to true
                            //             $(this).prop('selected', true);
                            //             $(this).trigger('change');
                            //             // console.log('desc id' + selectedId + ' ')
                            //             // Exit the loop once a match is found
                            //             return false;
                            //         }
                            //     });

                            //     $(".agent").find('option').each(function() {
                            //         // Check if the value of the option matches the selectedId
                            //         if ($(this).val() == detail[i]['SUPNO']) {
                            //             // Set the selected property of the matching option to true
                            //             $(this).prop('selected', true);
                            //             $(this).trigger('change');
                            //             // Exit the loop once a match is found
                            //             return false;
                            //         }
                            //     });

                            //     var tax = detail[i]['TAX_CHK'];
                            //     var on_tax = detail[i]['ON_TAX'];
                            //     var exam_tax = detail[i]['EXAM_TAX'];

                            //     var taxTd = tr.find('td').eq(5);
                            //     var onTaxTd = tr.find('td').eq(6);
                            //     var examTaxTd = tr.find('td').eq(7);

                            //     if (tax == 'Y') {
                            //         taxTd.find('input').prop('checked', true);
                            //     }
                            //     if (on_tax == 'Y') {
                            //         onTaxTd.find('input').prop('checked', true);
                            //     }
                            //     if (exam_tax == 'Y') {
                            //         examTaxTd.find('input').prop('checked', true);
                            //     }

                            // }

                        } else {
                            $("#save").html('Save')
                            $("#save").prop('disabled', false)
                            $("#vTypeId").prop('disabled', false)
                        }

                    } else {
                        console.error("Error: " + jsonData.message); // Log the error message
                    }
                    debitTotal();
                    creditTotal();
                }
            });
        }



        function clearForm() {
            $("#vDate").val('')
            $("#cheque").val('')
            $("#remark").val('')
            $("#cpr").val('')
            $("#source").val('')
            $("#chequeDate").val('')
            $("#receivedBy").val('')
            $(".debit").val('')
            $(".credit").val('')

            $("tbody tr td").find(".e1 option").each(function() {
                // var element = $(this);
                // Check if the value of the element is empty
                if (!$(this).val().trim()) {

                    // Set the selected property of the matching option to true
                    $(this).prop('selected', true);
                    // Trigger a change event if necessary
                    $(this).trigger('change');
                }
            });
            $("input[type='checkbox']").each(function() {
                $(this).prop('checked', false);
            });
        }


        function debitTotal() {
            var totalDebit = 0;

            $('.debit').each(function() {
                let value = $(this).val().replace(/,/g, '')
                var debitVal = parseFloat(value) || 0;
                totalDebit += debitVal;
            });

            $('#totalDebit').text(formatNumberWithCommas(totalDebit.toFixed(2)));
        }

        function creditTotal() {
            var totalCredit = 0;

            $('.credit').each(function() {
                let value = $(this).val().replace(/,/g, '')
                var creditVal = parseFloat(value) || 0;
                totalCredit += creditVal;
            });

            $('#totalCredit').text(formatNumberWithCommas(totalCredit.toFixed(2)));
        }

        $(document).ready(function() {
            // Initial calculation
            debitTotal();
            creditTotal();

            // Bind change event to inputs in each row to update totals when values change
            $(document).on('input', '.debit', debitTotal);
            $(document).on('input', '.credit', creditTotal);
        });



    })
</script>