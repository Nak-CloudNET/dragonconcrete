<?php //$this->erp->print_arrays($Settings);?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->lang->line("sales_invoice") . " " . $inv->reference_no; ?></title>
    <link href="<?php echo $assets ?>styles/theme.css" rel="stylesheet">
    <style type="text/css">
        html, body {
            height: 100%;
            background: #FFF;
            font-family: Khmer OS Content;
        }

        body:before, body:after {
            display: none !important;
        }
        .container {
            min-height: 27.7cm;
        }
        .table th {
            text-align: center;
            padding: 5px;
        }

        .table td {
            padding: 4px;
        }
        hr{
            border-color: #333;
            width:100px;
            margin-top: 70px;
        }
        .table, .table tr td, .table tr th {
            border: 1px solid #000 !important;
        }
        @media print{
            .page {
                page-break-after: always;
            }
            .table {
                font-size: 11px !important;
            }
            .table thead {
                font-size: 11px !important;
            }
            .container {
                width: 95% !important;
                height: 27.7cm !important;
                margin: 0 auto !important;
            }
            .table thead > tr > th {
                background-color: #444 !important;
                color: #FFF !important;
            }
            #textcenter {
                margin-left:-150px !important;
            }
            hr {
                width: 150px !important;
            }

            #footer div {
                padding-left: 5px !important;
            }
            #customer {
                padding-left: 0 !important;
            }
            #customer-table {
                width: 7.50cm !important;
            }
        }
        .trtd table th, td {
            padding: 5px;
            border-radius: 5px !important;
        }
        thead th, th {
            background-color:#323233;
            color:#fff;
        }
    </style>
</head>

<body>
<div class="container print_rec" id="wrap">
    <div class="row">
        <div class="col-lg-12">

            <div class="col-xs-10 text-center" style="margin-bottom:20px;">
                <div id="textcenter" style="padding-left:250px; text-align:center;position: absolute;top: 500px;z-index:1;-webkit-transform: rotate(350deg);
                    -moz-transform: rotate(350deg);-o-transform: rotate(350deg);writing-mode: lr-tb;">
			<span style="font-size:40px;font-family:Khmer OS;
                    color: rgba(0, 0, 0, 0.3) !important;
			" >វិក័យប័ត្រនេះមិនអាចប្រកាសជា<br>បន្ទុកចំណាយបានទេ</span>
                </div>
            </div>

            <div class="col-xs-12 text-center">
                <h2 style="font-family: Khmer M1"><?= lang("invoice_kh"); ?></h2>
                <h2 style="margin-top: -10px !important; margin-bottom: 0px !important"><?= lang("Invoice"); ?></h2>
            </div>
            <div class="col-xs-3"></div>
            <div class="clearfix"></div>
            <br>
            <br>
            <br>
            <br>
            <div class="row padding10" style="margin-top: -20px !important">
                <div class="col-xs-6" id="customer" style="float: left;font-size:14px; margin-top: -30px !important">
                    <table class="trtd" style="width:100%;border: 1px solid #000000">
                        <tr>
                            <td>Customer</td>
                            <td>: <b><?=$invs->customer;?></b></td>
                        </tr>
                       <!-- <tr>
                            <td>Address</td>
                            <td>: <b><?=$invs->group_area;?></b></td>
                        </tr>-->
                        <tr>
                            <td>Tel</td>
                            <td>: <b><?=$invs->phone;?></b></td>
                        </tr>
                       <!-- <tr>
                            <td>Model</td>
                            <td>: </td>
                        </tr>-->
                        <!--<tr>
                            <td>Time</td>
                            <td>: <b><?= date('H:II')?></b></td>
                        </tr>-->
                    </table>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-6"  style="float: right;font-size:14px; margin-top: -30px !important; ">
                    <table class="trtd" style=" width:100%;border:solid 1px #000; padding-left:10px !important;">
                        <tr>
                            <td>From</td>
                            <td>: <b><?=$bill->biller;?></b></td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td>: <b><?=$this->erp->hrsd($bill->date);?></b></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
            <div><br/></div>

            <div class="-table-responsive">
                <table class="table table-bordered table-striped" style="width: 100%;">
                    <thead style="height:50px;font-size: 13px;">
                    <tr>
                        <th style="vertical-align:middle;text-align:center; width:70px;">Item/ប្រការ</th>
                        <th style="vertical-align:middle;text-align:center; width:220px;">Delivery Date/ថ្ងៃបញ្ចេញទំនិញ</th>
                        <th style="vertical-align:middle;text-align:center;">Location/ទីតាំង</th>
                        <th style="vertical-align:middle;text-align:center;​ width:180px;">Typer of Concrete /ប្រភេទ</th>
                        <th style="vertical-align:middle;text-align:center;">Quantity/ចំនួន</th>
                        <th style="vertical-align:middle;text-align:center;">Unit Price/តំលៃរាយ</th>
                        <th style="vertical-align:middle;text-align:center; width: 130px;">Amount/តំលៃសរុប</th>
                    </tr>
                    </thead>
                    <tbody>
<!--                    --><?php //$this->erp->print_arrays($rows); ?>
                        <?php
                        $i = 1;
                        $stotal = 0;
                        $tqty = 0;

                        foreach($rows as $row){
//                            $this->erp->print_arrays($row);
                        $unit_price = $this->sales_model->getSaleByDeliveryID2($idd,$row->product_id);

                        ?>
                        <tr>

                            <td><?=$i?></td>
                            <td><?=$this->erp->hrsd($row->date1);?></td>
                            <td><?= $row->location ?></td>
                            <td style="text-align:left;"><?=$row->product_name?></td>
                            <td><?=$this->erp->formatDecimal($row->quantity);?></td>
                            <td><?=$this->erp->formatMoney($row->unit_price)?> $</td>
                            <td style="text-align:right;"><?=$this->erp->formatMoney($row->quantity*$row->unit_price)?> $</td>
                        </tr>
                        <?php
                        $i++;
                        $tqty +=$row->quantity;
                        $stotal +=$row->quantity*$row->unit_price;
                        }
                        for($k = 0;$k<12;$k++){
                        ?>
                        <tr class="blank">
                            <td><?=$i?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align:right;"></td>
                        </tr>

                        <?php
                        $i++;
                        }
                        ?>
                        <tr>

                            <td colspan="3" rowspan="3" style="text-align:left; font-size: 11px;">បញ្ជាក់៖<br><?php echo nl2br($bill->invoice)?></td>
                            <td  style="text-align:right;"><b>សរុប/Sub Total</b></td>
                            <td ><b><?=$this->erp->formatDecimal($tqty);?></b></td>
                            <td></td>

                            <td  style="text-align:right;"><b><?=$this->erp->formatMoney($stotal);?> $</b></td>

                        </tr>
                        <tr>
                            <td  colspan="3" style="text-align:right;​"><b>ចំនួនទឹកប្រាក់ដែលមិនទាន់បានបង់ពីមុន/Unpaid previous period  USD</b></td>
                            <td   ></td>

                        </tr>
                        <tr>
                            <td  colspan="3"​ style="text-align:right;" ><b>ចំនួនទឹកប្រាក់សរុប/Grand total  USD</b></td>
                            <td   style="text-align:right;" ><b><?=$this->erp->formatMoney($stotal);?> $</b></td>

                        </tr>
                    </tbody>
                </table>
                <p>Remark: The invoice above is excluding 10% VAT.</p>
                <p>ផ្សេងៗ៖ តំលៃខាងលើមិនបូករួមពន្ធ 10% នៃ VAT</p>
                <br>
            </div>
        </div>
    </div>
    <div id="footer" class="row" style="margin-top: 50px !important; margin: 0 !important">
        <div class="col-sm-4 col-xs-4">
            <center>
                <p>ហត្ថលេខាអ្នកទទួល</p>
                <p>Received By :</p>
            </center>
        </div>
        <div class="col-sm-4 col-xs-4">
            <center>
                <p>អនុម័តដោយ</p>
                <p>Approved By :</p>
            </center>
        </div>
        <div class="col-sm-4 col-xs-4">
            <center>
                <p>គណនេយ្យ</p>
                <p>Accountant By:</p>
            </center>
        </div>

    </div>
</div>
<br>
<div style="width: 63%;margin: 0 auto;">
    <a class="btn btn-warning no-print" href="<?= site_url('sales'); ?>">
        <i class="fa fa-hand-o-left" aria-hidden="true"></i>&nbsp;<?= lang("back"); ?>
    </a>
</div>
<br>
<div></div>
<!--<div style="margin-bottom:50px;">
	<div class="col-xs-4" id="hide" >
		<a href="<?= site_url('sales'); ?>"><button class="btn btn-warning " ><?= lang("Back to AddSale"); ?></button></a>&nbsp;&nbsp;&nbsp;
		<button class="btn btn-primary" id="print_receipt"><?= lang("Print"); ?>&nbsp;<i class="fa fa-print"></i></button>
	</div>
</div>-->
<script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '#b-add-quote' ,function(event){
            event.preventDefault();
            localStorage.removeItem('slitems');
            window.location.href = "<?= site_url('purchases_request/add'); ?>";
        });
        $(document).on('click', '#b-view-pr' ,function(event){
            event.preventDefault();
            localStorage.removeItem('slitems');
            window.location.href = "<?= site_url('purchases_request/index'); ?>";
        });
    });

</script>
</body>
</html>
