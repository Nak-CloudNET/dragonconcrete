<?php 
	//$this->erp->print_arrays($rows);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->lang->line("sales") . " " . $inv->reference_no; ?></title>
    <link href="<?php echo $assets ?>styles/theme.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Moul|Raleway" rel="stylesheet"> 
    <style type="text/css">
		.container {
			width: 29.7cm;
			margin: 20px auto;
			/*padding: 10px;*/
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
		}
        html, body {
            height: 100%;
            background: #FFF;
        }

        body:before, body:after {
            display: none !important;
        }

        .table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {
			border: 1px solid #000 !important;
		}

        .table th {
            text-align: center;
            padding: 5px;
        }

        .table td {
            padding: 4px;
        }

        table,tr,td{
            font-size: 13px !important;
        }
		
		.table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
			padding: 8px;
			line-height: 0.30;
			vertical-align: middle;
		}
		
		.table {
			border: 4px double #000 !important;
		}

		@media print {
			body {
				font-size: 12px !important;
			}
			.container {
				height: 28cm !important;
			}
			.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {
			border: 1px solid #000 !important;
			}
		}
    </style>
</head>

<body class="form">
	<div class="container">
	
		<div class="col-sm-12 col-xs-12" style="margin-top:5px !important;">
			<div class="row">
						<div class="col-sm-3 col-xs-3">
							<?php if(!empty($biller->logo)) { ?>
								<img src="<?= base_url() ?>assets/uploads/logos/<?= $biller->logo; ?>" style="width: 165px; margin-left: 25px;" />
							<?php } ?>
						</div>
				
						<div class="col-sm-6 col-xs-6 company_addr" style="margin-top: -15px !important">
						<center>
							<?php if(!empty($biller->cf1)) { ?>
								<h3><?= $biller->cf1 ?></h3>
							<?php }else { ?>
								<h3>CloudNET Cambodia</h3>
							<?php } ?>
						
							<?php if(!empty($biller->vat_no)) { ?>
								<p style="font-size: 11px;">លេខអត្តសញ្ញាណកម្ម អតប (VAT No):&nbsp;<?= $biller->vat_no; ?></p>
							<?php } ?>
							
							<?php if(!empty($biller->address)) { ?>
								<p style="margin-top:-10px !important;font-size: 11px;">អាសយដ្ឋាន ៖ &nbsp;<?= $biller->address; ?></p>
							<?php } ?>
							
							<?php if(!empty($biller->phone)) { ?>
								<p style="margin-top:-10px !important;font-size: 11px;">ទូរស័ព្ទលេខ (Tel):&nbsp;<?= $biller->phone; ?></p>
							<?php } ?>
							
							<?php if(!empty($biller->email)) { ?>
								<p style="margin-top:-10px !important;font-size: 11px;">សារអេឡិចត្រូនិច (E-mail):&nbsp;<?= $biller->email; ?></p>
							<?php } ?>
						</center>
						</div>
						<div class="col-sm-3 col-xs-3">
							<button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
								<i class="fa fa-print"></i> <?= lang('print'); ?>
							</button>
						</div>
			</div>
			<center><h4	style="font-weight:bold;"><u><?= strtoupper(lang('official receipt')) ?></u></h4></center>
			<div class="row">
				<div class="col-lg-7 col-sm-7 col-xs-7">
					<table style="font-size: 11px;">
						<?php if(!empty($customer->company)) { ?>
						<tr>
							<td style="width: 5%; font-size:12px !important;font-weight: bold !important;">Recieved From</td>
							<td style="width: 5%;">:</td>
							<td style="width: 30%; font-size:14px !important;font-weight: 900 !important;"><?= $customer->company ?></td>
						</tr>
						<?php } ?>
						<?php if(!empty($customer->name_kh || $customer->name)) { ?>
						<tr>
							<td style="width: 5%; font-size:12px !important;font-weight: bold !important;">ATTN</td>
							<td>:</td>
							<?php if(!empty($customer->name_kh)) { ?>
							<td style="width: 30%; font-size:12px !important;font-weight: 900 !important;"><?= $customer->name_kh ?></td>
							<?php }else { ?>
							<td style="width: 30%; font-size:12px !important;font-weight: bold !important;"><?= $customer->name ?></td>
							<?php } ?>
						</tr>
						<?php } ?>
						<?php if(!empty($customer->address_kh || $customer->address)) { ?>
						<?php } ?>
						<?php if(!empty($customer->address_kh || $customer->address)) { ?>
						<tr>
							<td style="width: 30%; font-size:12px !important;font-weight: bold !important;">Tel</td>
							<td>:</td>
							<td style="width: 30%; font-size:12px !important;font-weight: 900 !important;"><?= $customer->phone ?></td>
						</tr>
						<?php } ?>
						
					</table>
				</div>
				<div class="col-lg-5 col-sm-5 col-xs-5">
					<table width="100%">
						<tr>
							<td style="font-size:12px;"><b>RECIEPT No:</b></td>
							<td style="text-align:right; color:#8B0000; font-size:12px"><strong><?=$payment->reference_no; ?></strong></td>
						</tr>
						<tr>
							<td style="width:50%; font-size:12px"> <b>DATE:<b></td>
						<td style="text-align:right; color:#8B0000; font-size:12px"><strong><?= $this->erp->hrsd($payment->date); ?></strong></td>
						</tr>
					</table>
				</div>
				
			</div>
			<div class="row">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="th_left" style="width:100px !important;">Item</th>
							<th class="th_center" style="width:300px !important;">Description</th>
							<th class="th_center" style="width:150px !important;">Check No</th>
							<th class="th_center" style="width:200px !important;">Reference</th>
							<th class="th_right" style="width:200px !important;">Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php
						$no = 1;
						$m_us = 0;
						$payments = 0;
						foreach($rowpay as $row){
							echo '<tr class="item"><td class="text-center">' . $no . "</td>";
							echo '<td class="text-center">' . $payment->note; '</td>';
							echo '<td class="text-center">' . $payment->cheque_no;'</td>';
							echo '<td class="text-center">' . $row->reslae. '</td>';						
							echo '<td class="text-center">' . ($this->erp->formatMoney($row->amount)) . '</td>';
							$no++;
							$payments += $row->amount;
						}
						?>
						<?php
								if($no<6){
									$k=6 - $no;
									for($j=1;$j<=$k;$j++){
										if($discount != 0) {
											echo  '<tr>
													<td height="34px" class="text-center">'.$no.'</td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													
												</tr>';
										}else {
											echo  '<tr>
													<td height="34px" class="text-center">'.$no.'</td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													
												</tr>';
										}
										$no++;
									}
								}
							?>
						</tr>
					</tbody>
					<tfoot>
						<tr style="border-top:4px double #000">
							<td colspan="3"><p><b>Amount In Word: <?=  ucwords($this->erp->convert_number_to_words($payments)); ?> US Dollar Only</p></b></td>
							<th class="text-center"><?= lang("total"); ?></th>
							<th class="text-center">$<?=  $this->erp->formatMoney($payments); ?></th>
						</tr>
						
					</tfoot>
				</table>
			</div>
			<div class="row" style="margin-top:-10px !important;">
					<div class="col-lg-3 col-sm-3 col-xs-3">
						<p">Prepared By</p>
						
						<hr style="margin:0;margin-top:50px !important; border:1px solid #000;">
					</div>
					<div class="col-lg-3 col-sm-3 col-xs-3">
					</div>
					<div class="col-lg-3 col-sm-3 col-xs-3">
						
					</div>
					<div class="col-lg-3 col-sm-3 col-xs-3">
						<p>Recieved By</p>
						<hr style="margin:0;margin-top:50px !important;border:1px solid #000;">
					</div>
			</div>
		</div>
		
	</div>
</body>
</html>