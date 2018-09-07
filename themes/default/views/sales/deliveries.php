<style type="text/css">
	.sale_order_delivery_link {
		cursor: pointer;
	}
</style>
<script>
	$(document).ready(function () {
        CURI = '<?= site_url('sales/deliveries'); ?>';
    });
</script>

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
?>

<script>

    $(document).ready(function () {
    	
        var oTable = $('#sale_item').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('sales/getDeliveries').'/'.$start_date.'/'.$end_date ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{
                "bSortable": false,
                "mRender": checkbox
            }, {"mRender": fld}, 
			null, 
			null, 
			{"bSearchable": false}, 
			{"bSearchable": false}, 
			{"mRender": formatQuantity, "bSearchable": false},
			{"mRender": formatQuantity, "bSearchable": false},
			{"mRender": deliveries_status, "bSearchable": false}, 
			{"bSortable": false}],
			'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
                nRow.className = "delivery_inv_link";
                return nRow;
            },
			"fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var gtotal = 0;
                var qototal = 0;
                for (var i = 0; i < aaData.length; i++) {
					qototal += parseFloat(aaData[aiDisplay[i]][6]);
					gtotal += parseFloat(aaData[aiDisplay[i]][7]);
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[6].innerHTML = currencyFormat(parseFloat(qototal));
                nCells[7].innerHTML = currencyFormat(parseFloat(gtotal));
            }
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 1, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('do_no');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('so_no');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('customer');?>]", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?=lang('salesman');?>]", filter_type: "text", data: []},
			{column_number: 8, filter_default_label: "[<?=lang('status');?>]", filter_type: "text", data: []},
        ], "footer");
    });
	
	function deliveries_status(x){
		if(x == 'completed') {
			return '<div class="text-center"><span class="label label-success"><a href="'+site.base_url+'pos" style="text-decoration:none;color:#fff;">'+lang[x]+'</a></span></div>';
		}else {
			return '<div class="text-center"><span class="label label-warning">'+lang['pending']+'</span></div>';
		}
	}
	
	$(document).ready(function () {
        var oTable = $('#sale_order').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('sales/getSaleOrderDeliveries'.($warehouse_id ? '/' . $warehouse_id : '')).'/?v=1'.$v ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{
                "bSortable": false,
                "mRender": checkbox2
            }, 
            {"mRender": fld},
            null,
            null, 
            null, 
            null, 
            null,
            {"mRender": formatQuantity, "bSearchable": false},
            {"mRender": formatQuantity, "bSearchable": false},

            {"mRender": delivery_status, "bSearchable": false}, 
            {"bSortable": false}],
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
				$('td:eq(3)', nRow).addClass('so_num');
                nRow.className = "delivery_so_link";
				if (aData[8] == 'completed') {
					 $('td:eq(9)', nRow).find('.edit_deli').remove();
					 $('td:eq(9)', nRow).find('.add_deli').remove();
					 $('td:eq(9)', nRow).find('.add_sale').remove();
				}
				
                return nRow;
            },
			"fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
				var gtotal = 0;
				var qtotal = 0;
                for (var i = 0; i < aaData.length; i++) {
					qtotal += parseFloat(aaData[aiDisplay[i]][7]);
					gtotal += parseFloat(aaData[aiDisplay[i]][8]);
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[7].innerHTML = currencyFormat(parseFloat(qtotal));
                nCells[8].innerHTML = currencyFormat(parseFloat(gtotal));
            }
			
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 1, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('do_no');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('sale_ref');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('customer');?>]", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?=lang('salesman');?>]", filter_type: "text", data: []},
            {column_number: 6, filter_default_label: "[<?=lang('location');?>]", filter_type: "text", data: []},
			{column_number: 9, filter_default_label: "[<?=lang('issue_invoice');?>]", filter_type: "text", data: []},
        ], "footer");
		
		function delivery_status(x) {
			if(x == null) {
				return '';
			} else if(x == 'pending') {
				return '<div class="text-center"><span class="label label-warning">'+lang[x]+'</span></div>';
			} else if(x == 'completed') {
				return '<div class="text-center"><span class="label label-success"><a href="'+site.base_url+'pos" style="text-decoration:none;color:#fff;">'+lang[x]+'</a></span></div>';
			} else {
				 return '<div class="text-center"><span class="label label-info">'+lang[x]+'</span></div>';
			}
		}	
		
		
		$('body').on('click', '#add_sale_combine_deliveries', function(e) {
	        e.preventDefault();
			
			var i = 0;
				var items = [];
				//var first = 1;
				//var refer_f ="";
				var b=false;
				var k = false;
				$.each($("input[name='val[]']:checked"), function(){

					/*var parent = $(this).parent().parent().parent().parent();
					var refer_s = parent.find('td:nth-child(4)').html();
					var status = parent.find('td:nth-child(8)').html();
					
					alert(status.find('.text-center'));
					if(first == 1){
						refer_f = refer_s;
					}
					//var old = refer_f.split('/');
					//var ne = refer_s.split('/');
					//alert(old[2]);
					//alert(ne[2]);
					if(refer_f != refer_s){
						b=true;
					}
					if(status == 'completed'){
						k = true;
					}*/
					items[i] = {'delivery_id': $(this).val()};
					i++;
					//first++;

				});

				$.ajax({
					type: 'get',
					url: site.base_url+'sales/checkrefer',
					dataType: "json",
					async:false,
					data: { <?= $this->security->get_csrf_token_name() ?>: '<?= $this->security->get_csrf_hash() ?>',items:items },
					success: function (data) {
						if(data.isAuth == 1){
							b = true;
						}
						if(data.status == 2){
							k = true;
						}
					}
				});
			if(b == true){
					bootbox.alert('Sale Order reference is not match!');
					return false;
				}
				if(k == true){
					bootbox.alert('Sale Order  is  completed!');
					return false;
				}
			
	        $('#form_action').val($('#add_sale_combine_deliveries').attr('data-action'));
	        $('#action-form-submit').trigger('click');
    	});
    	<?php if($Settings->delivery == 'both'){?>
			$("#status_").val('1');
			
	 		$("#dbTab #action1").on("click",function(){
	 			var x = $("#action1").attr("class");
				$("#status_").val('1');
				
	 		});
	 		$("#dbTab #action2").on("click",function(){
	 			var x = $("#action2").attr("class");
				$("#status_").val('2');
				
	 		});
	 	<?php }?>
	 	<?php if($Settings->delivery == 'invoice'){?>
	 		$("#status_").val('1');
		<?php }?>
		<?php if($Settings->delivery == 'sale_order'){?>
	 		$("#status_").val('2');
		<?php }?>
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
<?php
	$wh = str_replace(',', '-', $warehouse_id);
 	echo form_open('sales/delivery_actions/'.($wh ? $wh : ''), 'id="action-form"');?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-truck"></i><?= lang('list_deliveries'); ?></h2>

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
    </div>

    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?=form_submit('performAction', 'performAction', 'id="action-form-submit"')?>
    </div>
    <?= form_close()?>

    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('list_results'); ?></p>
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



                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="Do_no"><?= lang("Do_no"); ?></label>
                                <?php echo form_input('Do_no', (isset($_POST['Do_no']) ? $_POST['Do_no'] : ""), 'class="form-control tip" id="Do_no"'); ?>
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
					<?php if ($Owner || $Admin || $GP['sales-deliveries']) { ?>
						<?php if($Settings->delivery == 'invoice' || $Settings->delivery == 'both') { ?>
							<li id="action1" class=""><a href="#sales"><?= lang('sale_delivery') ?></a></li>
						<?php } ?>
					<?php } if ($Owner || $Admin || $GP['sales-deliveries']) { ?>
						<?php if($Settings->delivery == 'sale_order' || $Settings->delivery == 'both') { ?>
							<li id="action2" class=""><a href="#quotes" ><?= lang('sale_order_delivery') ?></a></li>
						<?php } ?>
					<?php } ?>
				</ul>

				<div class="tab-content">
					<div id="sales" class="tab-pane fade in">
						<div class="row">
							<div class="col-sm-12">
								<div class="table-responsive">
									<table id="sale_item" class="table table-bordered table-hover table-striped table-condensed">
										<thead>
										<tr>
											<th style="min-width:30px; width: 30px; text-align: center;">
												<input class="checkbox checkft" type="checkbox" name="check"/>
											</th>
											<th><?php echo $this->lang->line("date"); ?></th>
											<th><?php echo $this->lang->line("do_no"); ?></th>
											<th><?php echo $this->lang->line("sale_ref"); ?></th>
											<th><?php echo $this->lang->line("customer"); ?></th>
											<th style="width:220px"><?php echo $this->lang->line("Sales Man"); ?></th>
											<th><?php echo $this->lang->line("quantity_order"); ?></th>
											<th><?php echo $this->lang->line("quantity"); ?></th>
											<th><?php echo $this->lang->line("status"); ?></th>
											<th style="width:10px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th>
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
											<th style="width:10px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th>
										</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>
					
					<div id="quotes" class="tab-pane fade in">
						<div class="row">
							<div class="col-sm-12">
								<div class="table-responsive">
									<table id="sale_order" class="table table-bordered table-hover table-striped table-condensed">
										<thead>
										<tr>
											<th style="min-width:30px; width: 30px; text-align: center;">
												<input class="checkbox checkft2" type="checkbox" name="check"/>
											</th>
											<th><?php echo $this->lang->line("date"); ?></th>
											<th style="width:110px"><?php echo $this->lang->line("do_no"); ?></th>
											<th style="width:110px"><?php echo $this->lang->line("so_no"); ?></th>
											<th style="width:100px"><?php echo $this->lang->line("customer"); ?></th>
											<th style="width:100px"><?php echo $this->lang->line("Sales Man"); ?></th>
											<th><?php echo $this->lang->line("location"); ?></th>
											<th><?php echo $this->lang->line("quantity_order"); ?></th>
											<th><?php echo $this->lang->line("quantity"); ?></th>
											<th><?php echo $this->lang->line("issue_invoice"); ?></th>
											<th style="width:10px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th>
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
												<input class="checkbox checkft2" type="checkbox" name="check"/>
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
											<th style="width:10px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th>
										</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>
					
				</div>
            </div>
        </div>
    </div>
</div>
<div style="display: none;">
    <input type="hidden" name="form_action" value="" id="form_action"/>
    <input type="hidden" name="status_" value="" id="status_"/>
    <?= form_submit('perform_action', 'perform_action', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>
    

<script type="text/javascript">

$(document).on('ifChecked', '.checkft2', function(event) {
    $('.checkft2').iCheck('check');
    $('.multi-select2').each(function() {
        $(this).iCheck('check');
    });
});
$(document).on('ifUnchecked', '.checkft2', function(event) {
    $('.checkft2').iCheck('uncheck');
    $('.multi-select2').each(function() {
        $(this).iCheck('uncheck');
    });
});

function checkbox2(x) {
    return '<center><input class="checkbox multi-select2" type="checkbox" name="val[]" value="' + x + '" /></center>';
}
 $("#add_sale_combine_deliveries").click(function(){

	$('sale_order .sale_order_delivery_link').each(function() {
		var tr         = $(this).parent().parent().parent();
	    var chk_so_num = tr.find(".so_num").html();
		if (tr.find(".checkbox").is(':checked')) {
		   var so_num = tr.find(".so_num").html();
		   alert(so_num+"=="+chk_so_num);
		   if(so_num==chk_so_num){
			   alert("true");
			   return true;
		   }else{
			   alert("false");
			   return false;
		   }
		}
	});	
 });
 
</script>
