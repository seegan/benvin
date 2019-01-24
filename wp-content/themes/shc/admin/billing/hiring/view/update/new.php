<?php
	$master_data = false;
	$customer_detail = false;
	$site_detail = false;

	$pending_items = false;
	$bill_exist = false;
	
	$customer_id = '';
	$site_id = '';

	$billing_date = date('Y-m-d');
	$billing_time = date('H:i');

	if(isset($_GET['id'])) {
		$master_data = getMasterDetail($_GET['id']);
		$master_data = ($master_data) ? $master_data : false;

		if($master_data['master_data']) {
			$customer_id = $master_data['master_data']->customer_id;
			$site_id = $master_data['master_data']->site_id;

			$customer_detail = getCustomerData($customer_id);
			$site_detail = getSiteData($site_id, 'shc_hiring', $billing_date, 'proforma_no', 'financial_year_proforma');

			$bill_from = (isset($_GET['bill_from']) && $_GET['bill_from'] != '') ? $_GET['bill_from'] : date('Y-m-01');
			$bill_to = (isset($_GET['bill_to']) && $_GET['bill_to'] != '') ? $_GET['bill_to'] : date('Y-m-d', strtotime('last day of this month'));
			$hiring_items = getHiringItems($_GET['id'], $bill_from, $bill_to);
			$existin_bill = getExistBillData($_GET['id'], $bill_from, $bill_to);

			$current_bill_no = isset($existin_bill->proforma_no) ? $existin_bill->proforma_no : $site_detail->next_bill_no;
			$billing_date = isset($existin_bill->bill_date) ? $existin_bill->bill_date : $billing_date;
			$billing_time = isset($existin_bill->bill_date) ? $existin_bill->bill_time : $billing_time;
		}
	}
?>
<div class="container">
	<div class="row">
	<?php 
		include( get_template_directory().'/admin/side-menu.php' );
	?>
		<?php
		if($existin_bill) {
		?>
			<div class="col-lg-9">
				<div class="x_panel">
					<div class="x_title">
						<h2>Proforma Exist</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-bordered">
							<thead>
								<tr>
									<td>Master Id</td>
									<td>Proforma Date</td>
									<td>Bill From</td>
									<td>Bill To</td>
									<td>Transport Charge</td>
									<td>Bill Total</td>
									<td>HB Status</td>
									<td>Action</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $existin_bill->master_id; ?></td>
									<td><?php echo $existin_bill->bill_date.' '.$existin_bill->bill_time; ?></td>
									<td><?php echo $existin_bill->bill_from; ?></td>
									<td><?php echo $existin_bill->bill_to; ?></td>
									<td><?php echo $existin_bill->transportation_charge; ?></td>
									<td><?php echo $existin_bill->hiring_total; ?></td>
									<td><?php echo ($existin_bill->bill_status == 2) ? '<img src="'.get_template_directory_uri() . '/admin/billing/inc/images/paid.png'.'">' : '<img src="'.get_template_directory_uri() . '/admin/billing/inc/images/pending.png'.'">'; ?></td>
									<td>
										<a href="<?php echo admin_url('admin.php?page=new_hiring').'&page=new_hiring&id='.$existin_bill->master_id.'&bill_id='.$existin_bill->id; ?>"><button type="submit" class="btn btn-success">View Detail</button></a>
										<button type="submit" class="btn btn-success">Print Bill</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		<?php
		}
		?>
		<div class="col-lg-9">
			<div class="x_panel">
				<div class="x_title">
					<h2>Hiring Bill</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="create_billing">
						<div class="col-lg-6">
							<?php
								if($master_data) {
									echo "<div class='address-line'>";
									echo "<div style='float:left;width: 200px;'>";
									echo "MRI : ".$master_data['master_data']->id;
									echo "</div>";
									echo "<div style='float:left;width: 200px;'>";
									echo "Ref.<input type='text' name='ref_number' style='width: 150px;border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;'>";
									echo "</div>";
									echo "<div style='clear:both;'></div>";
									echo "</div>";
									echo "<input type='hidden' name='master_id' value='".$master_data['master_data']->id."'>";



									echo"<input type='hidden' name='site_id' class='site_id' value='".$site_id."'>";

									echo '<div class="address-line">Preforma No : ';
									echo '	<span class="deposit-time">';
									echo $site_detail->company_id."/PFA <input type='text' style='border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;' value='".$current_bill_no."' name='bill_no' class='bill bill_no'>";
									echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/5.gif" style="width: 20px;display:none;" class="loadin-billfrom">';
									echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/check.png" style="width: 20px;display:none;" class="loadin-check">';
									echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/cross.png" style="width: 20px;display:none;" class="loadin-cross">';
									echo '	</span>';
									echo '<input type="hidden" class="billno_action" value="shc_hiring">';
									echo '<input type="hidden" class="bill_no_field" value="proforma_no">';
									echo '<input type="hidden" class="financial_year_field" value="financial_year_proforma">';
									echo '</div>';
								}
							?>

							<div class="customer-name">Customer Name : M/s 
								<span class="customer-name"><?php echo ($customer_detail->name) ? $customer_detail->name : ''; ?></span>
							</div>
							<div class="address-line">Address : <span class="address-txt"><?php echo ($customer_detail->address) ? $customer_detail->address : ''; ?></span>
							</div>
							<div class="bill-date">
								<div>
									<div style="float:left; width:60px;line-height: 35px;"> Bill From </div>
									<div style="float:left;">: <input type="text" name="bill_from" value="<?php echo isset($_GET['bill_from']) ? $_GET['bill_from'] : $bill_from ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;width:90px;" class="datepicker bill_from"></div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="bill-date">
								<div>
									<div style="float:left; width:60px;line-height: 35px;"> Bill To </div>
									<div style="float:left;">: <input type="text" name="bill_to" value="<?php echo isset($_GET['bill_to']) ? $_GET['bill_to'] : $bill_to ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;width:90px;" class="datepicker bill_to"></div>
									<div style="float:left;"><input type="button" class="get_bill" value="Get Proforma Invoice"></div>
								</div>
								<div class="clear"></div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="address-line">Proforma Invoice Date : <span class="billing-date"><input type="text" name="billing_date" value="<?php echo $billing_date; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;" class="datepicker financial_date"></span></div>
							<div class="address-line">Time : <input type="time" name="billing_time" value="<?php echo $billing_time; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;" class="billing-time"></div>
							<div class="address-line">Site : 
								<select type="text" name="delivery_site_name" class="delivery_site_name" data-dvalue="<?php echo ($site_detail) ? $site_detail->id : ''; ?>"  data-sitename="<?php echo ($site_detail) ? $site_detail->site_name : ''; ?>">
								</select>
							</div>
							<div class="address-line">Phone : <span class="site-phone"><?php echo ($site_detail) ? $site_detail->phone_number : ''; ?></span>
							</div>
							<div class="address-line">
								Discount : <input type="radio" name="hiring_discount_avail" class="hiring_discount_avail" value="yes" style="margin-top: -2px;"> Yes &nbsp;&nbsp; <input type="radio" name="hiring_discount_avail" class="hiring_discount_avail" value="no" style="margin-top: -2px;" checked> No
								<input type="hidden" name="discount_yes" class="discount_yes" value="<?php echo $site_detail->discount; ?>">
								<input type="hidden" name="discount_no" class="discount_no" value="0.00">
							</div>
							<div class="address-line">
								Tax For : <input type="radio" class="tax_from" name="tax_from" value="no_tax" style="margin-top: -2px;"> No Tax &nbsp;&nbsp; <input type="radio" class="tax_from" name="tax_from" value="vat" style="margin-top: -2px;"> VAT &nbsp;&nbsp; <input type="radio" class="tax_from" name="tax_from" value="gst" style="margin-top: -2px;" checked> GST
							</div>
						</div>
						<div class="col-lg-12">


							<div class="deposit-repeater hiring_detail" style="margin-top:20px;">
								<table class="table table-bordered" data-repeater-list="hiring_detail">
									<thead>
										<tr>
											<th rowspan="2" style="width:50px;" class="center-th"><div>S.No</div></th>
											<th rowspan="2" class="center-th" style="min-width: 200px;"><div>Description</div></th>
											<th rowspan="2" class="center-th" style="width:80px;"><div>Qty</div></th>
											<th colspan="3" class="center-th" style="width: 100px;"><div>Peroid</div></th>
											<th rowspan="2" class="center-th" style="width: 100px;"><div>Rate Per Day</div></th>
											<th rowspan="2" class="center-th" style="width: 130px;"><div>Amount</div></th>
											<th rowspan="2" class="center-th" style="width: 100px;"><div>Min. Return Check</div></th>
										</tr>
										<tr>
											<td>From</td>
											<td>To</td>
											<td>No of days</td>
										</tr>
									</thead>
									<tbody>
									<?php


										if($hiring_items && isset($hiring_items['hiring_detail']) && count($hiring_items['hiring_detail']) > 0) {
											$i = 1;
											foreach ($hiring_items['hiring_detail'] as $h_value) {
									?>
										<tr class="div-table-row" data-repeater-item class="repeterin div-table-row" >
											<td>
												<div class="rowno align-txt">
													<?php echo $i; ?>
													<?php 
														if($h_value->got_return == 'yes') {
															echo '<div class="hiring_red"></div>';
															echo '<input type="hidden" name="hiring_detail[][got_return]" value="1">';
														}
														if($h_value->got_return == 'no') {
															echo '<div class="hiring_green"></div>';
															echo '<input type="hidden" name="hiring_detail[][got_return]" value="0">';
														}
													?>
													
												</div>
												<input type="hidden" class="delivery_detail_id" name="hiring_detail[][delivery_detail_id]" value="<?php echo $h_value->id; ?>">
											</td>
											<td>
												<div class="align-txt">
													<span><?php echo $h_value->product_name; ?></span>
													<span><?php echo $h_value->product_type; ?></span>
													<input type="hidden" name="hiring_detail[][lot_id]" value="<?php echo $h_value->lot_id; ?>">
												</div>

											</td>
											<td>
												<div class="align-txt">
													<span><?php echo $h_value->bill_qty; ?></span>
													<input type="hidden" name="hiring_detail[][qty]" value="<?php echo $h_value->bill_qty; ?>">
												</div>
											</td>
											<td>
												<div class="align-txt">	
													<span><?php echo $h_value->bill_from; ?></span>
													<input type="hidden" name="hiring_detail[][bill_from]" value="<?php echo $h_value->bill_from; ?>">
													<?php
														if($h_value->got_return == 'yes') {
													?>
													<div class="tooltipo tootip-black" data-stockalert="1">
														<span class="tooltiptext">
															Delivery Date : <span class="slab_sys_txt"><?php echo $h_value->delivery_date; ?></span>
															<input type="hidden" name="hiring_detail[][delivery_date]" value="<?php echo $h_value->delivery_date; ?>">
															<!-- <hr class="tooltip-hr"> -->
														</span>
													</div>
													<?php
														}
													?>	
												</div>
											</td>
											<td>
												<div class="align-txt">
													<span><?php echo $h_value->bill_to; ?></span>
													<input type="hidden" name="hiring_detail[][bill_to]" value="<?php echo $h_value->bill_to; ?>">
												</div>
											</td>
											<td>
												<div class="align-txt">
													<span><?php echo $h_value->bill_days; ?></span>
													<input type="hidden" name="hiring_detail[][bill_days]" value="<?php echo $h_value->bill_days; ?>">
													<?php
														if($h_value->got_return == 'yes') {
													?>
													<div class="tooltipo tootip-black" data-stockalert="1">
														<span class="tooltiptext">
															Total Days : <span class="slab_sys_txt"><?php echo $h_value->total_days; ?></span>
															<input type="hidden" name="hiring_detail[][total_days]" value="<?php echo $h_value->total_days; ?>">
															<!-- <hr class="tooltip-hr"> -->
														</span>
													</div>
													<?php
														}
													?>													
												</div>
											</td>
											<td>
												<div class="align-txt">
													<span><?php echo $h_value->rate_per_unit; ?></span>
													<input type="hidden" name="hiring_detail[][rate_per_day]" value="<?php echo $h_value->rate_per_unit; ?>">
												</div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="bill_amount_txt"><?php echo $h_value->bill_amount; ?></span>
													<input type="hidden" class="row_hiring_amt" name="hiring_detail[][amount]" value="<?php echo $h_value->bill_amount; ?>">
													<input type="hidden" name="hiring_detail[][hiring_amt]" class="hiring_amt" value="<?php echo $h_value->bill_amount; ?>">
													<input type="hidden" name="hiring_detail[][hiring_amt_min]" class="hiring_amt_min" value="<?php echo $h_value->min_bill_bal ; ?>">
												</div>
											</td>
											<td>
												<div class="align-txt">
													<span>
														<?php 
															if( $h_value->min_bill === 'yes') {
																echo '<input type="hidden" name="hiring_detail[][min_checkbox_avail]" value="1">';
														?>
																<input type="checkbox" name="hiring_detail[][min_checked]" class="bill_min_days">
																<div class="tooltipo tootip-black" data-stockalert="1">
																	<span class="tooltiptext" style="width:400px;">

																		Payment For <?php echo $h_value->minimum_bill_day ?> Days : <span class="slab_sys_txt"><?php echo $h_value->min_bill_amt; ?></span>
																		<input type="hidden" name="hiring_detail[][for_thirty_days]" value="<?php echo $h_value->min_bill_amt; ?>">
																		<hr class="tooltip-hr">
																		Previous Paid : <span class="slab_sys_txt"><?php echo ($h_value->min_bill_amt - $h_value->min_bill_bal); ?></span>
																		<input type="hidden" name="hiring_detail[][previous_paid]" value="<?php echo ($h_value->min_bill_amt - $h_value->min_bill_bal); ?>">
																		<hr class="tooltip-hr">
																		Balance To Pay : <span class="slab_sys_txt"><?php echo $h_value->min_bill_bal ; ?></span>
																		<input type="hidden" name="hiring_detail[][bal_to_pay]" value="<?php echo $h_value->min_bill_bal ; ?>">
																		
																		<!-- <hr class="tooltip-hr"> -->
																	</span>
																</div>
														<?php
															} else {
																echo '<input type="hidden" class="row_hiring_amt" name="hiring_detail[][min_checkbox_avail]" value="0">';
															}
														?>
													</span>
													
												</div>
											</td>
										</tr>
									<?php
												$i++;
											}
									?>


										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt"><b>Total (Hire Charges) : </b></div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="sub_tot_txt"></span>
													<input type="hidden" class="sub_tot_val" name="sub_tot" value="0.00">
												</div>
											</td>
											<td></td>
										</tr>

										<tr class="discount_tr">
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">
													Discount % 
													<input type="text" name="discount_percentage" class="discount_percentage" value="0.00" style="width:45px;height: 30px;" readonly="readonly">
												</div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="discount_txt"></span>
													<input type="hidden" class="discount_amt" name="discount_amt" value="0.00">
												</div>
											</td>
											<td></td>
										</tr>
										<tr class="discount_tr">
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">
													<b>Total (Hire Charges) : </b>
												</div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="after_discount_txt"></span>
													<input type="hidden" class="after_discount_amt" name="after_discount_amt" value="0.00">
													<input type="hidden" class="hire_charge_cgst" name="hire_charge_cgst" value="0.00">
													<input type="hidden" class="hire_charge_sgst" name="hire_charge_sgst" value="0.00">
													<input type="hidden" class="hire_charge_igst" name="hire_charge_igst" value="0.00">
												</div>
											</td>
											<td></td>
										</tr>


										<tr class="delivery-tr">
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">Delivery Charges</div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="del_tot_txt"><?php echo moneyFormatIndia(number_format($hiring_items['delivery_charges'],2)); ?></span>
													<input type="hidden" class="del_chrg_val" name="del_chrg" value="<?php echo $hiring_items['delivery_charges']; ?>">
													<input type="hidden" class="delivery_charge_cgst" name="delivery_charge_cgst" value="0.00">
													<input type="hidden" class="delivery_charge_sgst" name="delivery_charge_sgst" value="0.00">
													<input type="hidden" class="delivery_charge_igst" name="delivery_charge_igst" value="0.00">


													<input type="hidden" class="vat_transport_charges" value="<?php echo $hiring_items['vat_transport_charges']; ?>">
													<input type="hidden" class="gst_transport_charges" value="<?php echo $hiring_items['delivery_charges']; ?>">

												</div>
											</td>
											<td></td>
										</tr>

										<tr class="damage-tr">
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">Cleaning and Maintanance Charges</div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="dmg_tot_txt"><?php echo moneyFormatIndia(number_format($hiring_items['damage_charges'],2)); ?></span>
													<input type="hidden" class="dmg_chrg_val" name="dmg_chrg" value="<?php echo $hiring_items['damage_charges']; ?>">
													<input type="hidden" class="damage_charge_cgst" name="damage_charge_cgst" value="0.00">
													<input type="hidden" class="damage_charge_sgst" name="damage_charge_sgst" value="0.00">
													<input type="hidden" class="damage_charge_igst" name="damage_charge_igst" value="0.00">
												</div>
											</td>
											<td></td>
										</tr>
										<tr class="lost-tr">
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">Material Lost Charges </div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="lost_tot_txt"><?php echo moneyFormatIndia(number_format($hiring_items['lost_charges'],2)); ?></span>
													<input type="hidden" class="lost_chrg_val" name="lost_chrg" value="<?php echo $hiring_items['lost_charges']; ?>">
													<input type="hidden" class="lost_charge_cgst" name="lost_charge_cgst" value="0.00">
													<input type="hidden" class="lost_charge_sgst" name="lost_charge_sgst" value="0.00">
													<input type="hidden" class="lost_charge_igst" name="lost_charge_igst" value="0.00">													
												</div>
											</td>
											<td></td>
										</tr>


										<tr class="before-tax-tr">
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">Total</div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="total_before_tax_txt">0.00</span>
													<input type="hidden" class="total_before_tax_amt" name="total_before_tax_amt" value="0.00">
													<!-- gst_include_total -->
												</div>
											</td>
											<td></td>
										</tr>


									<?php if(isset($site_detail->gst_for) && $site_detail->gst_for == 'igst') { ?>
										<tr class="gst_tr tax_tr">
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">IGST - 9%: </div>
												<input type="hidden" class="gst_percentage" value="18.00">
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="gst_igst_txt"></span>
													<input type="hidden" class="gst_igst" name="gst_igst" value="0.00">
												</div>
											</td>
											<td></td>
										</tr>
									<?php } else {
									?>
										<tr class="gst_tr tax_tr">
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">CGST - 9% : </div>
												<input type="hidden" class="gst_percentage" value="9.00">
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="gst_cgst_txt"></span>
													<input type="hidden" class="gst_cgst" name="gst_cgst" value="0.00">
												</div>
											</td>
											<td></td>
										</tr>
										<tr class="gst_tr tax_tr">
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">SGST - 9% : </div>
												<input type="hidden" class="gst_percentage" value="0.00">
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="gst_sgst_txt"></span>
													<input type="hidden" class="gst_sgst" name="gst_sgst" value="0.00">
												</div>
											</td>
											<td></td>
										</tr>
									<?php
									} ?>
										<tr class="vat_tr tax_tr">
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">VAT - 5% : </div>
												<input type="hidden" class="vat_percentage" value="5.00">
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="vat_amt_txt"></span>
													<input type="hidden" class="vat_amt" name="vat_amt" value="0.00">
												</div>
											</td>
											<td></td>
										</tr>
										<tr class="tax_tr">
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">Total Including Tax : </div>
											</td>
											<td>
												<div class="align-txt gst_div right-align-txt">
													<span class="total_include_tax_txt">0.00</span>
													<input type="hidden" class="total_include_tax_amt" name="total_include_tax_amt" value="0.00">
													<!-- gst_include_total -->
												</div>
											</td>
											<td></td>
										</tr>

										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">Round Off : </div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<input type="text" class="round_off right-align-txt" name="round_off" value="0.00" style="border-color: rgba(118, 118, 118, 0);height:34px;margin:0;">
												</div>
											</td>
											<td></td>
										</tr>
										<tr>
											<td colspan="7" style="font-size: 20px;font-weight: bold;text-align: center;">
												<div class="align-txt">Total</div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="hiring_tot_txt "></span>
													<input type="hidden" name="gst_for" class="gst_for"  value="<?php echo isset($site_detail->gst_for) ? $site_detail->gst_for : 'cgst'; ?>">
													<input type="hidden" class="hiring_tot_val" name="hiring_tot" value="0.00">
												</div>
											</td>
											<td></td>
										</tr>

									<?php
										} else {
									?>
										<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row" data-lotid="0" data-stockbal="0">
											<td colspan="9">
												<center><b>No Pending Items</b></center>
											</td>
										</tr>
									<?php
										}
									?>
									</tbody>
								</table>
							</div>

							<div style="float:right;">
	                          	<?php 
	                          		if($master_data) {
	                          			echo "<input type='hidden' name='master_id' class='master_id_input' value='".$master_data['master_data']->id."'>";
									
	                          			if(isset($existin_bill) && $existin_bill->id) {
	                          				echo "<input type='hidden' name='bill_id' value='".$existin_bill->id."'>";
	                          				echo "<input type='hidden' name='action' class='action' value='update_billing'>";
	                          				echo "<button type='submit' class='btn btn-success create_billing'>Update Bill</button>";
	                          				echo "<input type='hidden' name='update_current_bill' value='".$current_bill_no."'>";
	                          			} else {
	                          				echo "<input type='hidden' name='action' class='action' value='create_billing'>";
	                          				echo "<button type='submit' class='btn btn-success create_billing'>Generate Invoice</button>";
	                          			}
	                          		}
	                          	?>
	                       	</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

















