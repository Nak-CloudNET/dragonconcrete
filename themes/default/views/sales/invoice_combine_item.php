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
            .cl_pd:nth-child(1){
                /*margin-left: -15px;*/
            }
            .cl_pd:nth-child(2){
                /*margin-right: -15px;*/
            }
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
            .p_th td{
                color: black!important;

            }
        }
        .trtd table th, td {
            padding: 5px;
            /*border-radius: 5px !important;*/
        }
        thead td {
            background-color:#323233;
            color:#fff;
        }
        .td_w{
            width:25%;
        }
    </style>
</head>

<body>
<div class="container print_rec" id="wrap">
    <div class="row">
        <div class="col-lg-12">

            <div class="col-xs-10 text-center" style="margin-bottom:20px;">
                <div id="textcenter" style="padding-left:300px; text-align:center;position: absolute;top: 500px;z-index:1;-webkit-transform: rotate(350deg);
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


                <div class="col-xs-6 cl_pd"  style="float: left;font-size:14px; margin-top: -30px !important;  ">
                    <table class="trtd" style=" width:100%;border:solid 1px #000; padding-left:10px !important;">
                        <tr>
                            <td class="td_w">Customer</td>
                            <td >: <b><?=$invs->customer;?></b></td>
                        </tr>
                        <tr>
                            <td class="td_w">Tel</td>
                            <td>: <b><?=$invs->phone?></b></td>
                        </tr>
                    </table>
                </div>

                <div class="col-xs-6 cl_pd"  style="float: right;font-size:14px; margin-top: -30px !important; ">
                    <table class="trtd" style=" width:100%;border:solid 1px #000; padding-left:10px !important;">
                        <tr>
                            <td class="td_w">From</td>
                            <td>: <b><?=$bill->biller;?></b></td>
                        </tr>
                        <tr>
                            <td class="td_w">Date</td>
                            <td>: <b><?=$this->erp->hrsd($bill->date);?></b></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
            <div><br/></div>
            <?php
                foreach($rows as $row){
                    $tax+=$row->item_tax;
                    $dis+=$row->discount;
                }
            $col_sp=3;
            ?>
            <div class="-table-responsive">
                <table class="table table-bordered table-striped" style="width: 100%;">
                    <thead style="height:50px;font-size: 13px;">
                    <tr class="p_th">
                        <td style="vertical-align:middle;text-align:center; width:70px;">Item/ ប្រការ</td>
                        <td style="vertical-align:middle;text-align:center; width:220px;">Delivery Date/ថ្ងៃញ្ចេញទំនិញ</td>
                        <td style="vertical-align:middle;text-align:center;">Location/ ទីតាំង</td>
                        <td style="vertical-align:middle;text-align:center;​ width:180px;">Typer of Concrete/ ប្រភេទ</td>
                        <td style="vertical-align:middle;text-align:center;">Quantity/ ចំនួន</td>
                        <td style="vertical-align:middle;text-align:center;">Unit Price/ តំលៃរាយ</td>
                        <?php if($dis>0){ $col_sp+=1; ?>
                        <td style="vertical-align:middle;text-align:center; width: 130px;">Discount/ បញ្ចុះតម្លៃ</td>
                        <?php }if($tax>0){ $col_sp+=1; ?>
                        <td style="vertical-align:middle;text-align:center; width: 130px;">Tax/ ពន្ធទំនិញ</td>
                        <?php } ?>
                        <td style="vertical-align:middle;text-align:center; width: 130px;">Amount/ តំលៃសរុប</td>
                    </tr>
                    </thead>
                    <tbody>
<!--                    --><?php //$this->erp->print_arrays($rows); ?>
                        <?php
                        $i = 1;
                        $stotal = 0;
                        $tqty = 0;
//                        $this->erp->print_arrays($rows);
                        $product_standard="";
                        $product_service="";
                        foreach($rows as $row){
                            $amt=$row->quantity*$row->unit_price;

                        $unit_price = $this->sales_model->getSaleByDeliveryID2($idd,$row->product_id);


                                    $product_standard.='
                                         <tr>

                                            <td>'.$i.'</td>
                
                                            <td>
                                                 '.$this->erp->hrsd($row->date1).'
                                            </td>
                
                                            <td>'. $row->location.' </td>
                                            <td style="text-align:left;">'.$row->product_name.'</td>
                                            <td>'.$this->erp->formatDecimal($row->quantity).'</td>
                                            <td>'.$this->erp->formatMoney($row->unit_price).' $</td>';

                                            if($dis>0){
                                                $product_standard.='<td>'.$this->erp->formatMoney($row->discount).' $</td>';
                                            $amt-=$row->discount;}

                                            if($tax>0){
                                            $product_standard.='<td>'.$this->erp->formatMoney($row->item_tax).' $</td>';
                                             $amt+=$row->item_tax;}

                                            $product_standard.='<td style="text-align:right;">'.$this->erp->formatMoney($amt).' $</td>
                                        </tr>
                                    
                                    ';



                        ?>

                        <?php
                        $i++;
                        $tqty +=$row->quantity;
                        $stotal +=$row->quantity*$row->unit_price;
                        }
                        echo $product_standard;
                        $co=15-($i-1);
                        for($k = 1;$k<=$co;$k++){
                        ?>
                        <tr class="blank">
                            <td><?=$i?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php if($dis>0){ ?>
                                <td></td>
                            <?php } ?>
                            <?php if($tax>0){ ?>
                            <td></td>
                            <?php } ?>
                            <td style="text-align:right;"></td>
                        </tr>

                        <?php
                        $i++;
                        }
                        $row_sp=1;

                        if($invs->order_discount>0){
                            $row_sp+=1;
                        }

                        if($invs->shipping>0){
                            $row_sp+=1;
                        }
                        if($invs->order_discount>0 || $invs->order_tax>0 || $invs->shipping>0){
                            $row_sp+=1;
                        }

                        ?>
                        <tr>

                            <td colspan="3" rowspan="<?= $row_sp; ?>" style="text-align:left; font-size: 11px;">បញ្ជាក់៖<br><?php echo nl2br($bill->invoice)?></td>
                            <td  style="text-align:right;"><b>សរុប/Sub Total</b></td>
                            <td ><b><?=$this->erp->formatDecimal($tqty);?></b></td>

                            <td></td>
                            <?php
                            if($dis>0){
                                ?>
                                <td></td>
                            <?php
                            }
                            ?>
                            <?php
                            if($tax>0){
                                ?>
                                <td></td>
                                <?php
                            }
                            ?>

                            <td  style="text-align:right;"><b><?=$this->erp->formatMoney($stotal);?> $</b></td>

                        </tr>
                        <?php
                            if($invs->order_discount>0){
                                $stotal-=$invs->order_discount;
                            ?>
                                <tr>
                                    <td  colspan="<?= $col_sp; ?>" style="text-align:right;​"><b>បញ្ចេុះតម្លៃ/Order Discount</b></td>
                                    <td   style="text-align:right;" ><b><?=$this->erp->formatMoney($invs->order_discount);?> $</b></td>
                                </tr>
                        <?php
                            }
                        ?>

                        <?php
                        if($invs->shipping>0){
                            $stotal+=$invs->shipping;
                            ?>
                            <tr>
                                <td  colspan="<?= $col_sp; ?>" style="text-align:right;​"><b>ដឹកជញ្ជូន/Shipping</b></td>
                                <td   style="text-align:right;" ><b><?=$this->erp->formatMoney($invs->shipping);?> $</b></td>
                            </tr>
                            <?php
                        }
                        if($row_sp>1){
                        ?>
                        <tr>
                            <td  colspan="<?= $col_sp; ?>"​ style="text-align:right;" ><b>ចំនួនទឹកប្រាក់សរុប/Grand total  USD</b></td>
                            <td   style="text-align:right;" ><b><?=$this->erp->formatMoney($stotal);?> $</b></td>
                        </tr>
                    <?php } ?>
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
