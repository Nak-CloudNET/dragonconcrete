<style type="text/css">
	.sale_order_add_delivery_link {
		cursor: pointer;
	}
</style>
<?php
$start_date=date('Y-m-d',strtotime($start));
$rep_space_end=str_replace(' ','_',$end);
$end_date=str_replace(':','-',$rep_space_end);

if ($this->input->post('so_no')) {
    $v .= "&so_no=" . $this->input->post('so_no');
}
if ($this->input->post('Do_no')) {
    $v .= "&Do_no=" . $this->input->post('Do_no');
}
if ($this->input->post('start_date')) {
    $v .= "&start_date=" . $this->input->post('start_date');
}
if ($this->input->post('end_date')) {
    $v .= "&end_date=" . $this->input->post('end_date');
}
if ($this->input->post('saleman')) {
    $v .= "&saleman=" . $this->input->post('saleman');
}
if ($this->input->post('customer')) {
    $v .= "&customer=" . $this->input->post('customer');
}
if ($this->input->post('biller')) {
    $v .= "&biller=" . $this->input->post('biller');
}
?>

<script>
    $(document).ready(function () {
        var oTable = $('#DOData').dataTable({
            "aaSorting": [[2, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('sales/getSales_items').'/'.(isset($start_date)?$start_date:"").'/'.(isset($end_date)?$end_date:"") ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
                nRow.className = "";
                return nRow;
            },
            "aoColumns": [{
                "bSortable": false,
                "mRender": checkbox
            }, {"mRender": fld}, null, null, null, null, {"mRender": currencyFormat},{"mRender": currencyFormat},{"mRender": currencyFormat},{"mRender": invoice_delivery_status}],
			"fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var total_quantity = 0;
				var total_quantity_received=0;
				var total_balance = 0;
                for (var i = 0; i < aaData.length; i++) {
					total_quantity += parseFloat(aaData[aiDisplay[i]][6]);
					total_quantity_received+= parseFloat(aaData[aiDisplay[i]][7]);
					total_balance += parseFloat(aaData[aiDisplay[i]][8]);
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[6].innerHTML = currencyFormat(parseFloat(total_quantity));
				nCells[7].innerHTML = currencyFormat(parseFloat(total_quantity_received));
				nCells[8].innerHTML = currencyFormat(parseFloat(total_balance));
            }
        }).fnSetFilteringDelay().dtFilter([
			
			{column_number: 1, filter_default_label: "[<?=lang('date');?>]", filter_type: "text", data: []},
			{column_number: 2, filter_default_label: "[<?=lang('sale_reference_no');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('project');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('customer');?>]", filter_type: "text", data: []},
			{column_number: 5, filter_default_label: "[<?=lang('saleman');?>]", filter_type: "text", data: []},
			{column_number: 9, filter_default_label: "[<?=lang('status');?>]", filter_type: "text", data: []},
        ], "footer");
		
		
		var oTable = $('#Sale_Order').dataTable({
            "aaSorting": [[1, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('sales/getSaleOrderitems').($warehouse_id ? '/' . $warehouse_id : '').'/?v=1'.$v ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
                nRow.className = "sale_order_add_delivery_link";
                return nRow;
            },
            "aoColumns": [{
                "bSortable": false,
                "mRender": checkbox
            }, {"mRender": fld}, null, null, null, null, {"mRender": formatQuantity},{"mRender": formatQuantity},{"mRender": formatQuantity},{"mRender": sale_order_delivery_status}],
			"fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var total_quantity = 0;
				var total_quantity_received=0;
				var total_balance = 0;
                for (var i = 0; i < aaData.length; i++) {
					total_quantity += parseFloat(aaData[aiDisplay[i]][6]);
					total_quantity_received+= parseFloat(aaData[aiDisplay[i]][7]);
					total_balance += parseFloat(aaData[aiDisplay[i]][8]);
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[6].innerHTML = formatQuantity(parseFloat(total_quantity));
				nCells[7].innerHTML = formatQuantity(parseFloat(total_quantity_received));
				nCells[8].innerHTML = formatQuantity(parseFloat(total_balance));
            }
        }).fnSetFilteringDelay().dtFilter([
			
			{column_number: 1, filter_default_label: "[<?=lang('date');?>]", filter_type: "text", data: []},
			{column_number: 2, filter_default_label: "[<?=lang('sale_reference_no');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('project');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('customer');?>]", filter_type: "text", data: []},
			{column_number: 5, filter_default_label: "[<?=lang('saleman');?>]", filter_type: "text", data: []},
			{column_number: 9, filter_default_label: "[<?=lang('status');?>]", filter_type: "text", data: []},
        ], "footer");
		
		
		
    });
	
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#form').hide();
        $('.toggle_down').click(function () {
            $("#form").slideDown();
            return false;
        });
        $('.toggle_up').click(function () {
            $("#form").slideUp();
            return false;
        });
        $("#product").autocomplete({
            source: '<?= site_url('reports/suggestions'); ?>',
            select: function (event, ui) {
                $('#product_id').val(ui.item.id);
                //$(this).val(ui.item.label);
            },
            minLength: 1,
            autoFocus: false,
            delay: 300,
        });
    });
</script>

<div class="row" style="margin-bottom: 15px;">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-tasks"></i> <?= lang('add_deliveries') ?></h2>
                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown">
                            <a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>">
                                <i class="icon fa fa-toggle-up"></i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>">
                                <i class="icon fa fa-toggle-down"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="box-icon">
                    <ul class="btn-tasks">
                        <?php if ($Owner || $Admin || $GP['sales-add_delivery'] || $GP['sales-export_delivery'] || $GP['sales-combine_delivery']) { ?>
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i></a>
                                <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">

                                    <?php if ($Owner || $Admin || $GP['sales-add_delivery']) { ?>
                                        <li>
                                            <a href="<?= site_url('sales/add_deliveries') ?>" id="add_delivery">
                                                <i class="fa fa-heart"></i> <?= lang('Add Delivery') ?>
                                            </a>
                                        </li>
                                    <?php }?>

                                    <?php if ($Owner || $Admin || $GP['sales-export_delivery']) { ?>
                                        <li><a href="#" id="excel" data-action="export_excel"><i
                                                        class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?></a></li>
                                        <li><a href="#" id="pdf" data-action="export_pdf"><i
                                                        class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?></a>
                                        </li>
                                    <?php } ?>

                                    <?php if ($Owner || $Admin || $GP['sales-combine_delivery']) { ?>
                                        <li><a href="#" id="add_sale_combine_deliveries" data-action="add_sale_combine_deliveries"><i class="fa fa-plus"></i> <?= lang('add_sale_combine_deliveries') ?></a></li>
                                    <?php } ?>

                                    <!-- <?php if ($Owner || $Admin || $GP['sales-delete_delivery']) { ?>
							<li><a href="#" class="bpo" title="<?= $this->lang->line("delete_deliveries") ?>"
								   data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger' id='delete' data-action='delete'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button>"
								   data-html="true" data-placement="left"><i
										class="fa fa-trash-o"></i> <?= lang('delete_deliveries') ?></a></li>
						<?php } ?> -->

                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </div>


            </div>

            <div style="display: none;">
                <input type="hidden" name="form_action" value="" id="form_action"/>
                <?=form_submit('performAction', 'performAction', 'id="action-form-submit"')?>
            </div>
			<div class="box-content">
				<div class="row">
					<div class="col-md-12">
                        <div id="form">

                            <?php echo form_open("sales/deliveries"); ?>
                            <div class="row">


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label" for="customer"><?= lang("customer"); ?></label>
                                        <?php echo form_input('customer', (isset($_POST['customer']) ? $_POST['customer'] : ""), 'class="form-control" id="customer" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("customer") . '"'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label" for="so_no"><?= lang("so_no"); ?></label>
                                        <?php
                                        echo form_input('so_no', (isset($_POST['so_no']) ? $_POST['so_no'] : ""), 'class="form-control" id="so_no" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("so_no") . '"');
                                        ?>
                                    </div>
                                </div>



<!--                                <div class="col-sm-4">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="control-label" for="Do_no">--><?//= lang("Do_no"); ?><!--</label>-->
<!--                                        --><?php //echo form_input('Do_no', (isset($_POST['Do_no']) ? $_POST['Do_no'] : ""), 'class="form-control tip" id="Do_no"'); ?>
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label" for="project"><?= lang("project"); ?></label>
                                        <?php
                                        if ($Owner || $Admin) {
                                            $bl[""] = "";
                                            foreach ($billers as $biller) {
                                                $bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
                                            }
                                            echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : ""), 'class="form-control" id="biller" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("biller") . '"');
                                        } else {
                                            $user_pro[""] = "";
                                            foreach ($user_billers as $user_biller) {
                                                $user_pro[$user_biller->id] = $user_biller->company;
                                            }
                                            echo form_dropdown('biller', $user_pro, (isset($_POST['biller']) ? $_POST['biller'] : ''), 'class="form-control" id="biller" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("biller") . '"');
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("saleman", "saleman"); ?>
                                        <?php
                                        $salemans['0'] = lang("all");
                                        foreach($agencies as $agency){
                                            $salemans[$agency->id] = $agency->username;
                                        }
                                        echo form_dropdown('saleman', $salemans, (isset($_POST['saleman']) ? $_POST['saleman'] : ""), 'id="saleman" class="form-control saleman"');
                                        ?>
                                    </div>
                                </div>



                                <?php if($this->Settings->product_serial) { ?>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <?= lang('serial_no', 'serial'); ?>
                                            <?= form_input('serial', '', 'class="form-control tip" id="serial"'); ?>
                                        </div>
                                    </div>
                                <?php } ?>


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <?= lang("start_date", "start_date"); ?>
                                        <?php echo form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ""), 'class="form-control date" id="start_date"'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <?= lang("end_date", "end_date"); ?>
                                        <?php echo form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : ""), 'class="form-control date" id="end_date"'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                            </div>
                            <?php echo form_close(); ?>

                        </div>
						<ul id="dbTab" class="nav nav-tabs">
							<?php if ($Owner || $Admin || $GP['sales-add_delivery']) { ?>
								<?php if($Settings->delivery == 'invoice' || $Settings->delivery == 'both') { ?>
										<li class=""><a href="#sales"><?= lang('invoice') ?></a></li>
								<?php } ?>
							<?php } if ($Owner || $Admin || $GP['sales-add_delivery']) { ?>
								<?php if($Settings->delivery == 'sale_order' || $Settings->delivery == 'both') { ?>
									<li class=""><a href="#quotes"><?= lang('sale_order') ?></a></li>
								<?php } ?>
							<?php } ?>
						</ul>
						<div class="tab-content">
							<?php if ($Owner || $Admin || $GP['sales-add_delivery']) { ?>
								<div id="sales" class="tab-pane fade in">
									<div class="row">
										<div class="col-sm-12">
											<div class="table-responsive">
												<table id="DOData" class="table table-bordered table-hover table-striped table-condensed">
													<thead>
													<tr>
														<th style="min-width:30px; width: 30px; text-align: center;">
															<input class="checkbox checkft" type="checkbox" name="check"/>
														</th>
														<th><?php echo $this->lang->line("date"); ?></th>
														<th><?php echo $this->lang->line("sale_reference_no"); ?></th>
														<th><?php echo $this->lang->line("project"); ?></th>
														<th><?php echo $this->lang->line("customer"); ?></th>
														<th><?php echo $this->lang->line("saleman"); ?></th>
														<th><?php echo $this->lang->line("quantity"); ?></th>
														<th><?php echo $this->lang->line("quantity_received"); ?></th>
														<th><?php echo $this->lang->line("balance"); ?></th>
														<th style="width:150px"><?php echo $this->lang->line("actions"); ?></th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td colspan="9" class="dataTables_empty"><?php echo $this->lang->line("loading_data"); ?></td>
													</tr>
													</tbody>
													<tfoot class="dtFilter">
														<tr class="active">
															<th style="min-width:30px; width: 30px; text-align: center;">
																<input class="checkbox checkft" type="checkbox" name="check"/>
															</th>
															<th></th>
															<th></th>
															<th></th>
															<th></th>
															<th></th>
															<th></th>
															<th></th>
															<th></th>
															<th></th>
														</tr>
													</tfoot>
												</table>
											</div>
										</div>
								    </div>
								</div>

									<?php } if ($Owner || $Admin || $GP['sales-add_delivery']) { ?>

									<div id="quotes" class="tab-pane fade">
										<div class="row">
											<div class="col-sm-12">
												<div class="table-responsive">
													<table id="Sale_Order" class="table table-bordered table-hover table-striped table-condensed">
														<thead>
														<tr>
															<th style="min-width:30px; width: 30px; text-align: center;">
																<input class="checkbox checkft" type="checkbox" name="check"/>
															</th>
															
															<th><?php echo $this->lang->line("date"); ?></th>
															<th><?php echo $this->lang->line("Sale Order Reference No."); ?></th>
															<th><?php echo $this->lang->line("project"); ?></th>
															<th><?php echo $this->lang->line("customer"); ?></th>
															<th><?php echo $this->lang->line("saleman"); ?></th>
															<th><?php echo $this->lang->line("quantity"); ?></th>
															<th><?php echo $this->lang->line("quantity_received"); ?></th>
															<th><?php echo $this->lang->line("balance"); ?></th>
															<th style="width:50px"><?php echo $this->lang->line("actions"); ?></th>
														</tr>
														</thead>
														<tbody>
														<tr>
															<td colspan="8" class="dataTables_empty"><?php echo $this->lang->line("loading_data"); ?></td>
														</tr>
														</tbody>
														<tfoot class="dtFilter">
															<tr class="active">
																<th style="min-width:30px; width: 30px; text-align: center;">
																	<input class="checkbox checkft" type="checkbox" name="check"/>
																</th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>
									</div>
									
									<?php } ?>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>

