 <?php
 	$master_data = false;
	$customer_detail = false;
	$site_detail = false;
	
	$customer_id = 0;
	$site_id = 0;

	$quotation_detail = $quotation_data['quotation_data'];
	$quotation_list = $quotation_data['quotation_detail'];

	if(isset($_GET['id'])) {
		$master_data = getMasterDetail($_GET['id']);
		$master_data = ($master_data) ? $master_data : false;

		if($master_data) {
			$customer_id = $master_data['master_data']->customer_id;
			$site_id = $master_data['master_data']->site_id;
			$customer_detail = getCustomerData($customer_id);
			$site_detail = getSiteData($site_id);

			$quotation_date = date('Y-m-d', strtotime($quotation_detail->quotation_date));
			$quotation_time = date('H:i', strtotime($quotation_detail->quotation_date));
		}

	}
?>
<style type="text/css">
	.address-line, .customer-name {
		margin-bottom: 20px;
	}
</style>

<div class="container">

	<div class="row">
	<?php 
		include( get_template_directory().'/admin/side-menu.php' );
	?>
		<div class="col-lg-9">
			<div class="x_panel">
				<div class="x_title">
					<h1>Quotation</h1>
					<div class="print_record left-right" data-action="print_quotation" data-action-from="list" data-print-id="<?php echo  $quotation_detail->id; ?>">
						<img src="<?php echo get_template_directory_uri() ?>/admin/inc/images/printer-icon.png">
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="create_quotation">


						<div class="col-lg-6">
							<?php



								if($master_data) {
									echo "<div class='address-line'>";
									echo "<div style='float:left;width: 200px;'>";
									echo "MRI : ".$master_data['master_data']->id;
									echo "</div>";
									echo "<div style='float:left;width: 200px;'>";
									echo "Ref.<input type='text' name='ref_number' style='width: 150px;border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;' value='".$quotation_data['quotation_data']->ref_number."'>";
									echo "</div>";
									echo "<div style='clear:both;'></div>";
									echo "</div>";
									echo "<input type='hidden' name='master_id' value='".$master_data['master_data']->id."'>";


									echo '<div class="address-line">Bill No : ';
									echo '	<span class="deposit-time">';
									echo $site_detail->company_id."Quotation No. <input type='text' style='border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;' value='".$quotation_data['quotation_data']->bill_no."' name='bill_no' class='bill bill_no'>";
									echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/5.gif" style="width: 20px;display:none;" class="loadin-billfrom">';
									echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/check.png" style="width: 20px;display:none;" class="loadin-check">';
									echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/cross.png" style="width: 20px;display:none;" class="loadin-cross">';
									echo '	</span>';
									echo '<input type="hidden" class="billno_action" value="shc_quotation">';
									echo '</div>';

								}
							?>


							<div class="customer-name">Customer Name : 
								<span class="customer-name"><?php echo ($customer_detail->name) ? $customer_detail->name : ''; ?></span>
								<input type="hidden" class="customer_id" name="customer_id" value="<?php echo $customer_id; ?>">
							</div>
							<div class="address-line">Address : <span class="address-txt"><?php echo ($customer_detail->address) ? $customer_detail->address : ''; ?></span>
							</div>

							<div class="address-line">
								Discount : <input type="radio" name="hiring_discount_avail" class="hiring_discount_avail" value="yes" style="margin-top: -2px;" <?php echo (isset($quotation_detail->discount_avail) && $quotation_detail->discount_avail == 'yes') ? 'checked' : ''; ?> > Yes &nbsp;&nbsp; <input type="radio" name="hiring_discount_avail" class="hiring_discount_avail" value="no" style="margin-top: -2px;" <?php echo (isset($quotation_detail->discount_avail) && $quotation_detail->discount_avail == 'no') ? 'checked' : ''; ?>> No
								<input type="hidden" name="discount_yes" class="discount_yes" value="<?php echo $quotation_detail->discount_percentage; ?>">
								<input type="hidden" name="discount_no" class="discount_no" value="0.00">
							</div>
							<div class="address-line">
								Tax For : 
								<input type="radio" class="tax_from" name="tax_from" value="no_tax" style="margin-top: -2px;" <?php echo (isset($quotation_detail->tax_from) && $quotation_detail->tax_from == 'no_tax') ? 'checked' : ''; ?>> No Tax &nbsp;&nbsp; 
								<input type="radio" class="tax_from" name="tax_from" value="vat" style="margin-top: -2px;" <?php echo (isset($quotation_detail->tax_from) && $quotation_detail->tax_from == 'vat') ? 'checked' : ''; ?>> VAT &nbsp;&nbsp; 
								<input type="radio" class="tax_from" name="tax_from" value="gst" style="margin-top: -2px;"  <?php echo (isset($quotation_detail->tax_from) && $quotation_detail->tax_from == 'gst') ? 'checked' : ''; ?>> GST
							</div>



						</div>
						<div class="col-lg-6">
							<div class="address-line">Date : <span class="deposit-date"><input type="text" name="date" id="datepicker" class="financial_date" value="<?php echo $quotation_date; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
							
							<div class="address-line">Time : <span class="deposit-time"><input type="time" name="time" value="<?php echo $quotation_time; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
							<div class="address-line">Site : 
								<select type="text" name="delivery_site_name" class="delivery_site_name" data-dvalue='<?php echo ($site_id) ? $site_id : ""; ?>' data-sitename='<?php echo ($site_detail) ? $site_detail->site_name : ""; ?>'>
								</select>
								<input type="hidden" name="site_id" class="site_id" value="<?php echo $site_id; ?>">
							</div>
							<div class="address-line">Attn. Name : <span class="attn-name"><?php echo ($customer_detail) ? $customer_detail->attn_name : ''; ?></span></div>
							<div class="address-line">Attn Phone : <span class="site-phone"><?php echo ($customer_detail) ? $customer_detail->attn_phone : ''; ?></span></div>
							<div class="address-line">GST : <span class="site-phone"><?php echo ($site_detail) ? $site_detail->gst_number : ''; ?></span></div>
						</div>



						<div class="col-lg-12">
							<div class="deposit-repeater quotation_detail" style="margin-top:20px;">
								<table class="table table-bordered" data-repeater-list="quotation_detail">
									<thead>
										<tr>
											<th rowspan="2" style="width:50px;" class="center-th"><div>S.No</div></th>
											<th rowspan="2" class="center-th" style="min-width: 200px;"><div>Description</div></th>
											<th rowspan="2" class="center-th" style="width:100px;">
												<div>Quantity</div>
											</th>
											<th rowspan="2" class="center-th" style="width:80px;">
												<div>Unit Price</div>
											</th>
											<th colspan="2">
												<div>Rate / 30 days</div>
											</th>
											<th colspan="2">
												<div>  Hiring Charges For 30 Days
													<input type="hidden" name="amt_times" class="amt_times" value="1" style="width: 25px;height: 20px;"> 
												</div>
											</th>
											<th rowspan="2">
												<div>Action</div>
											</th>
										</tr>
										<tr>
											<th style="width:120px;">Rs.</th>
											<th style="width:40px;">Ps.</th>
											<th style="width:120px;">Rs.</th>
											<th style="width:40px;">Ps.</th>
										</tr>
									</thead>
									<tbody>
									<?php
										if($quotation_list) {
											$i = 1;
											foreach ($quotation_list as $key => $q_value) {
												$data_thirty = splitCurrency($q_value->rate_thirty);
												$data_ninety = splitCurrency($q_value->rate_ninety);
										?>
										<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row" data-lotid="0" data-stockbal="0">
											<td>
												<div class="rowno align-txt"><?php echo $i; ?></div>
												<input type="hidden" class="sale_detail_id" name="sale_detail_id" value="<?php echo $q_value->id; ?>">
												<input type="hidden" class="lot_id_orig" name="lot_id_orig" value="<?php echo $q_value->lot_id; ?>">
											</td>
											<td>
												<select name="lot_number" class="lot_id" tabindex="-1" aria-hidden="true" data-dvalue="<?php echo $q_value->id; ?>" data-dtext="<?php echo $q_value->lot_no; ?>" data-dname="<?php echo $q_value->product_name; ?>" data-dtype="<?php echo $q_value->product_type; ?>"></select>
											</td>
											<td>
												<input type="text" name="qty" style="border-color: rgba(118, 118, 118, 0);width:80px;height:34px;margin:0;" class="dpt_qty" value="<?php echo $q_value->qty; ?>">
											</td>
											<td>
												<div class="align-txt unit_price_txt"><?php echo $q_value->unit_price; ?></div>
												<input type="hidden" name="unit_price" class="unit_price" value="<?php echo $q_value->unit_price; ?>">
											</td>
											<td>
												<div class="align-txt t_rs_txt"><?php echo $data_thirty['rs']; ?></div>
												<input type="hidden" name="thirty_rs_price" value="<?php echo $q_value->rate_thirty; ?>" class="thirty_rs_price">
											</td>
											<td>
												<div class="align-txt t_ps_txt"><?php echo $data_thirty['ps']; ?></div>
											</td>
											<td>
												<div class="align-txt n_rs_txt"><?php echo $data_ninety['rs']; ?></div>
												<input type="hidden" name="ninety_rs_price" value="<?php echo $q_value->rate_ninety; ?>" class="ninety_rs_price">
											</td>
											<td>
												<div class="align-txt n_ps_txt"><?php echo $data_ninety['ps']; ?></div>
											</td>
											<td>
												<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
												<input type="hidden" value="Delete">
												<input type="hidden" name="row_weight_unit" class="row_weight_unit" value="<?php echo $q_value->row_weight_unit; ?>">
												<span class="weight"><?php echo $q_value->row_weight; ?> kg</span>
												<input type="hidden" name="row_weight" class="row_weight" value="<?php echo $q_value->row_weight; ?>">
											</td>
										</tr>
										<?php
												$i++;
											}
										} else {
									?>
										<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row" data-lotid="0" data-stockbal="0">
											<td>
												<div class="rowno align-txt">1</div>
												<input type="hidden" class="quotation_detail_id" name="quotation_detail_id" value="0">
												<input type="hidden" class="lot_id_orig" name="lot_id_orig" value="0">
											</td>
											<td>
												<select name="lot_number" class="lot_id" tabindex="-1" aria-hidden="true"></select>
											</td>
											<td>
												<input type="text" name="qty" value="1" style="border-color: rgba(118, 118, 118, 0);width:80px;height:34px;margin:0;" class="dpt_qty">
											</td>
											<td>
												<div class="align-txt unit_price_txt">0.00</div>
												<input type="hidden" name="unit_price" class="unit_price" value="0.00">
											</td>
											<td>
												<div class="align-txt t_rs_txt">0</div>
												<input type="hidden" name="thirty_rs_price" value="0.00" class="thirty_rs_price">
											</td>
											<td>
												<div class="align-txt t_ps_txt">00</div>
											</td>
											<td>
												<div class="align-txt n_rs_txt">0</div>
												<input type="hidden" name="ninety_rs_price" value="0.00" class="ninety_rs_price">
											</td>
											<td>
												<div class="align-txt n_ps_txt">00</div>
											</td>
											<td>
												<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
												<input type="hidden" value="Delete">
												<input type="hidden" name="row_weight_unit" class="row_weight_unit" value="0.00">
												<span class="weight">0.00 kg</span>
												<input type="hidden" name="row_weight" class="row_weight" value="0.00">
											</td>
										</tr>
									<?php
										}
									?>

									</tbody>
									<tfooter>
									<?php
										$discount_display = ( isset($quotation_detail->discount_avail) && $quotation_detail->discount_avail == 'yes') ? 'table-row' : 'none';
										$no_tax_avail = ( isset($quotation_detail->tax_from) && $quotation_detail->tax_from == 'no_tax' ) ? 'none' : 'table-row';
										$igst_avail = ( isset($quotation_detail->tax_from) && $quotation_detail->tax_from == 'gst' && $quotation_detail->gst_for == 'igst' ) ? 'table-row' : 'none';
										$cgst_avail = ( isset($quotation_detail->tax_from) && $quotation_detail->tax_from == 'gst' && $quotation_detail->gst_for == 'cgst' ) ? 'table-row' : 'none';
										$vat_avail = ( isset($quotation_detail->tax_from) && $quotation_detail->tax_from == 'vat') ? 'table-row' : 'none';

										$sub_total_amt = (isset( $quotation_detail->sub_total ) && $quotation_detail->sub_total) ? $quotation_detail->sub_total : 0.00;
										$sub_total_data = splitCurrency($sub_total_amt);

										$discount_percentage = (isset( $quotation_detail->discount_percentage ) && $quotation_detail->discount_percentage) ? $quotation_detail->discount_percentage : 0.00;

										$discount_amt = (isset( $quotation_detail->discount_amt ) && $quotation_detail->discount_amt) ? $quotation_detail->discount_amt : 0.00;
										$discount_data = splitCurrency($discount_amt);

										$after_discount_amt = (isset( $quotation_detail->after_discount_amt ) && $quotation_detail->after_discount_amt) ? $quotation_detail->after_discount_amt : 0.00;
										$after_discount_data = splitCurrency($after_discount_amt);


										$igst_amt = (isset( $quotation_detail->igst_amt ) && $quotation_detail->igst_amt) ? $quotation_detail->igst_amt : 0.00;
										$igst_data = splitCurrency($igst_amt);

										$cgst_amt = (isset( $quotation_detail->cgst_amt ) && $quotation_detail->cgst_amt) ? $quotation_detail->cgst_amt : 0.00;
										$cgst_data = splitCurrency($cgst_amt);

										$sgst_amt = (isset( $quotation_detail->sgst_amt ) && $quotation_detail->sgst_amt) ? $quotation_detail->sgst_amt : 0.00;
										$sgst_data = splitCurrency($sgst_amt);

										$vat_amt = (isset( $quotation_detail->vat_amt ) && $quotation_detail->vat_amt) ? $quotation_detail->vat_amt : 0.00;
										$vat_data = splitCurrency($vat_amt);

										$tax_include_tot = (isset( $quotation_detail->tax_include_tot ) && $quotation_detail->tax_include_tot) ? $quotation_detail->tax_include_tot : 0.00;
										$tax_data = splitCurrency($tax_include_tot);

										$round_off = (isset( $quotation_detail->round_off ) && $quotation_detail->round_off) ? $quotation_detail->round_off : 0.00;
										$round_off_data = splitCurrency($round_off);

										$for_thirty_days= (isset( $quotation_detail->for_thirty_days ) && $quotation_detail->for_thirty_days) ? $quotation_detail->for_thirty_days : 0.00;
										$thirty_days_data = splitCurrency($for_thirty_days);

										$deposit_times = (isset( $quotation_detail->deposit_times ) && $quotation_detail->deposit_times) ? $quotation_detail->deposit_times : 0;
										$deposit_from = (isset( $quotation_detail->deposit_from ) && $quotation_detail->deposit_from) ? $quotation_detail->deposit_from : 'h';

										$loading_weight  = (isset( $quotation_detail->loading_weight ) && $quotation_detail->loading_weight) ? $quotation_detail->loading_weight : 0.00;
										$loading_per_ton = (isset( $quotation_detail->loading_per_ton ) && $quotation_detail->loading_per_ton) ? $quotation_detail->loading_per_ton : 0.00;
										$loading_charge = (isset( $quotation_detail->loading_charge ) && $quotation_detail->loading_charge) ? $quotation_detail->loading_charge : 0.00;
										$loading_scope = (isset( $quotation_detail->loading_scope ) && $quotation_detail->loading_scope) ? $quotation_detail->loading_scope : 0;
										$unloading_scope = (isset( $quotation_detail->unloading_scope ) && $quotation_detail->unloading_scope) ? $quotation_detail->unloading_scope : 0;

										$transport_charge = (isset( $quotation_detail->transport_charge ) && $quotation_detail->transport_charge) ? $quotation_detail->transport_charge : 0.00;
										$transport_scope = (isset( $quotation_detail->transport_scope ) && $quotation_detail->transport_scope) ? $quotation_detail->transport_scope : 0;

										$return_transport_charge = (isset( $quotation_detail->return_transport_charge ) && $quotation_detail->return_transport_charge) ? $quotation_detail->return_transport_charge : 0.00;
										$return_transport_scope = (isset( $quotation_detail->return_transport_scope ) && $quotation_detail->return_transport_scope) ? $quotation_detail->return_transport_scope : 0;

									?>
										<tr class="discount_tr" style="display: <?php echo $discount_display; ?>">
											<td colspan="6" style="text-align:right">
											<div class="align-txt">
												<span class="discount_avail_yes">
													Total : 
												</span>
											</td>

											<td class="deposit_tot_td">
												<div class="align-txt n_rs_tot_txt"><?php echo $sub_total_data['rs']; ?></div>
												<input type="hidden" class="total_ninety_days" value="<?php echo $sub_total_amt; ?>" name="sub_total">
											</td>
											<td>
												<div class="align-txt n_ps_tot_txt"><?php echo $sub_total_data['ps']; ?></div>
											</td>
											<td colspan="2"></td>
										</tr>
										

										<tr class="discount_tr" style="display: <?php echo $discount_display; ?>"><!-- discount_tr -->
											<td colspan="6" style="text-align: right;">
												<div class="align-txt">
													<b>Discount % </b>
													<input type="text" name="discount_percentage" class="discount_percentage" value="<?php echo $discount_percentage; ?>" style="width:45px;height: 30px;">
												</div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="discount_txt"><?php echo $discount_data['rs']; ?></span>
													<input type="hidden" class="discount_amt" name="discount_amt" value="<?php echo $discount_amt; ?>">
												</div>
											</td>
											<td>
												<div class="align-txt discount_txt_p"><?php echo $discount_data['ps']; ?></div>
											</td>
											<td></td>
										</tr>
										<tr class="">
											<td colspan="6" style="text-align: right;">
												<div class="align-txt">
													<span style="font-size: 20px;font-weight: bold;text-align: center;">
														Total Hire Charges : 
													</span>
												</div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="after_discount_txt"><?php echo $after_discount_data['rs']; ?></span>
													<input type="hidden" class="after_discount_amt" name="after_discount_amt" value="<?php echo $after_discount_amt; ?>">
												</div>
											</td>
											<td>
												<div class="align-txt after_discount_txt_p"><?php echo $after_discount_data['ps']; ?></div>
											</td>
											<td></td>
										</tr>



									<?php if(isset($quotation_detail->gst_for) && $quotation_detail->gst_for == 'igst') { ?>
										<tr class="gst_tr tax_tr" style="display:<?php echo $igst_avail; ?>"> <!-- gst_tr tax_tr -->
											<td colspan="6" style="text-align: right;">
												<div class="align-txt">IGST - 18%: </div>
												<input type="hidden" class="gst_percentage" value="18.00">
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="gst_igst_txt"><?php echo $igst_data['rs']; ?></span>
													<input type="hidden" class="gst_igst" name="gst_igst" value="<?php echo $igst_amt; ?>">
												</div>
											</td>
											<td>
												<div class="align-txt gst_igst_txt_p"><?php echo $igst_data['ps']; ?></div>
											</td>
											<td></td>
										</tr>
									<?php } else {
									?>
										<tr class="gst_tr tax_tr" style="display:<?php echo $cgst_avail; ?>"><!-- gst_tr tax_tr -->
											<td colspan="6" style="text-align: right;">
												<div class="align-txt">CGST - 9% : </div>
												<input type="hidden" class="gst_percentage" value="9.00">
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="gst_cgst_txt"><?php echo $cgst_data['rs']; ?></span>
													<input type="hidden" class="gst_cgst" name="gst_cgst" value="<?php echo $cgst_amt; ?>">
												</div>
											</td>
											<td>
												<div class="align-txt gst_cgst_txt_p"><?php echo $cgst_data['ps']; ?></div>
											</td>
											<td></td>
										</tr>
										<tr class="gst_tr tax_tr" style="display:<?php echo $cgst_avail; ?>"><!-- gst_tr tax_tr -->
											<td colspan="6" style="text-align: right;">
												<div class="align-txt">SGST - 9% : </div>
												<input type="hidden" class="gst_percentage" value="0.00">
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="gst_sgst_txt"><?php echo $sgst_data['rs']; ?></span>
													<input type="hidden" class="gst_sgst" name="gst_sgst" value="<?php echo $sgst_amt; ?>">
												</div>
											</td>
											<td>
												<div class="align-txt gst_sgst_txt_p"><?php echo $sgst_data['ps']; ?></div>
											</td>
											<td></td>
										</tr>
									<?php
									} ?>
										<tr class="vat_tr tax_tr" style="display:<?php echo $vat_avail; ?>"> <!-- vat_tr tax_tr -->
											<td colspan="6" style="text-align: right;">
												<div class="align-txt">VAT - 5% : </div>
												<input type="hidden" class="vat_percentage" value="5.00">
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="vat_amt_txt"><?php echo $vat_data['rs']; ?></span>
													<input type="hidden" class="vat_amt" name="vat_amt" value="<?php echo $vat_amt; ?>">
												</div>
											</td>
											<td>
												<div class="align-txt vat_amt_txt_p"><?php echo $vat_data['ps']; ?></div>
											</td>
											<td></td>
										</tr>
										<tr class="vat_tr tax_tr" style="display:<?php echo $vat_avail; ?>"> <!-- vat_tr tax_tr -->
										<tr class="tax_tr" style="display:<?php echo $no_tax_avail; ?>"> <!-- tax_tr -->
											<td colspan="6" style="text-align: right;">
												<div class="align-txt">Total Including Tax : </div>
											</td>
											<td>
												<div class="align-txt gst_div right-align-txt">
													<span class="total_include_tax_txt"><?php echo $tax_data['rs']; ?></span>
													<input type="hidden" class="total_include_tax_amt" name="total_include_tax_amt" value="<?php echo $tax_include_tot; ?>">
													<!-- gst_include_total -->
												</div>
											</td>
											<td>
												<div class="align-txt total_include_tax_txt_p">
													<?php echo $tax_data['ps']; ?>
												</div>
											</td>
											<td></td>
										</tr>

										<tr>
											<td colspan="6" style="text-align: right;">
												<div class="align-txt">Round Off : </div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<input type="text" class="round_off_rs right-align-txt" value="<?php echo $round_off_data['rs']; ?>" style="border-color: rgba(118, 118, 118, 0);height:34px;margin:0;width: 45px;padding: 0;text-align:right;">
													<input type="hidden" name="round_off" value="<?php echo $round_off; ?>" class="round_off">
												</div>
											</td>
											<td>
												<input type="text" class="round_off_ps right-align-txt" value="<?php echo $round_off_data['ps']; ?>" style="border-color: rgba(118, 118, 118, 0);height:34px;margin:0;width: 45px;padding: 0;text-align:left;">
											</td>
											<td></td>
										</tr>
										<tr>
											<td colspan="6" style="text-align: right;">
												<div class="align-txt">
													<span style="font-size: 20px;font-weight: bold;text-align: center;">
														(for 30 days) Total Including Tax
													</span>
												</div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="hiring_tot_txt "><?php echo $thirty_days_data['rs'] ?></span>
													<input type="hidden" name="gst_for" class="gst_for"  value="<?php echo isset($site_detail->gst_for) ? $site_detail->gst_for : 'cgst'; ?>">
													<input type="hidden" class="hiring_tot_val" name="hiring_tot" value="<?php echo $for_thirty_days ?>">
												</div>
											</td>
											<td>
												<div class="align-txt hiring_tot_txt_p">
													<?php echo $thirty_days_data['ps'] ?>
												</div>
											</td>
											<td></td>
										</tr>



									<tfooter>
								</table>

								<ul class="icons-labeled">
									<li><a data-repeater-create href="javascript:void(0);" id="add_new_price_range"><span class="icon-block-color add-c"></span>Add Product</a></li>
								</ul>
							</div>


							<div class="row">
								<div class="col-lg-12">
									<ul>
										<li>
											<h2><u>Requirements</u></h2> Security Deposit <input style="width: 50px;" type="text" class="deposit_times" name="deposit_times" value="<?php echo $deposit_times; ?>"> Times From <b>Hire Charge</b> <input type="radio" name="deposit_from" style="margin: -2px 0 0;" class="deposit_from" value="h" <?php echo ($deposit_from == 'h') ? 'checked' : ''; ?>> or <b>GST Include Total</b> <input type="radio" name="deposit_from" style="margin: -2px 0 0;" class="deposit_from" value="g"  <?php echo ($deposit_from == 'g') ? 'checked' : ''; ?>>
											<br>
											Loading charge (Weight in MT) <input type="text" name="loading_weight" class="loading_weight" value="<?php echo $loading_weight; ?>" style="width: 70px;"> x <input type="text" name="price_per_ton" class="price_per_ton" value="<?php echo $loading_per_ton; ?>" style="width: 50px;"> = <input type="text" name="loading_charge" class="loading_charge" value="<?php echo $loading_charge; ?>" style="width: 70px;"> Loading Charges (User Scope) <input type="checkbox" name="loading_scope" class="loading_scope" style="margin-top:0;" <?php echo ($loading_scope == 1) ? 'checked' : ''; ?>> Un Loading Charges (User Scope) <input type="checkbox" name="unloading_scope" class="unloading_scope" style="margin-top:0;" <?php echo ($unloading_scope == 1) ? 'checked' : ''; ?>> 
											<br>
											Transport Charge <input type="text" name="transport_charge" class="transport_charge" value="<?php echo $transport_charge ?>" style="width: 100px;"> Transport Charges (User Scope) <input type="checkbox" name="transport_scope" class="transport_scope" style="margin-top:0;" <?php echo ($transport_scope == 1) ? 'checked' : ''; ?>>
											<br>
											Return Transport Charge <input type="text" name="return_transport_charge" class="return_transport_charge" value="<?php echo $return_transport_charge ?>" style="width: 100px;"> Return Transport Charges (User Scope) <input type="checkbox" name="return_transport_scope" class="return_transport_scope" style="margin-top:0;" <?php echo ($return_transport_scope == 1) ? 'checked' : ''; ?>>
											<br>

											<textarea class="txtEditor1" name="quotation_txt"><?php echo $quotation_detail->requirements ?></textarea> 
										</li>
										<li>
											<h2><u>Banking Details</u></h2>
											<?php
												if($banks && count($banks) > 1) {
													echo "<br>";
													echo "Bank Account ";
													echo "<select class='company_bank'>";
													foreach ($banks as $b_value) {
														echo "<option value='".urldecode ($b_value->bank_detail)."'>".$b_value->bank_name."</option>";
													}
													echo "</select>";
												}
											?>
											<textarea class="txtEditor2" name="bank_details">
												<span class="bank_detail_span">
													<?php echo $quotation_detail->bank_details ?>
												</span>
											</textarea>
										</li>
									</ul>
									<div>
										Amount Payable : <input type="text" name="amount_payable" value="<?php echo $quotation_detail->amount_payable ?>" class="amount_payable">
									</div>
								</div>
							</div>


							<div class="row">
								<div class="col-lg-6">
									
								</div>
								<div class="col-lg-6">
									
								</div>

								<div class="col-lg-12">
									<div style="float:right;">
										<input type='hidden' name='quotation_id' value='<?php echo $quotation_detail->id; ?>'>
	                          			<input type='hidden' name='action' class='action' value='update_quotation'>
	                          			<button type='submit' class='btn btn-success create_quotation'>Submit</button>
			                       	</div>
								</div>
							</div>

							

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>