<?php

	$master_id = (isset($bill_data['hiring_data']->master_id)) ? $bill_data['hiring_data']->master_id : 0;


	$master_data = getMasterDetail($master_id);
	$master_data = ($master_data) ? $master_data : false;

	$hire_data = false;	
	$bill_no = 'N/A';
	$proforma_no = 'N/A';


	if($master_data['master_data']) {
		$customer_id = $master_data['master_data']->customer_id;
		$site_id = $master_data['master_data']->site_id;

		$customer_detail = getCustomerData($customer_id);
		$site_detail = getSiteData($site_id);

		$bill_from = (isset($bill_data['hiring_data']->bill_from) && $bill_data['hiring_data']->bill_from != '') ? $bill_data['hiring_data']->bill_from : date('Y-m-01');
		$bill_to = (isset($bill_data['hiring_data']->bill_to) && $bill_data['hiring_data']->bill_to != '') ? $bill_data['hiring_data']->bill_to : date('Y-m-d', strtotime('last day of this month'));
		$hiring_items = getHiringItems($_GET['id'], $bill_from, $bill_to);

		$billing_date = (isset($bill_data['hiring_data']->bill_date) && $bill_data['hiring_data']->bill_date != '') ? $bill_data['hiring_data']->bill_date : date('Y-m-d');
		$billing_time = (isset($bill_data['hiring_data']->bill_time)) ? date('H:i', strtotime($bill_data['hiring_data']->bill_time)) : date('H:i');


		if(isset($bill_data['hiring_data'])) {
			$hire_data = $bill_data['hiring_data'];
			$proforma_no = $hire_data->proforma_no;
			$bill_no = ($hire_data->bill_status == '2' ) ? $hire_data->bill_no : 'N/A';
		}
		$bill_number = billNumberText($bill_data['hiring_data']->bill_from_comp, $bill_no, 'HB');
		$proforma_number = billNumberText($bill_data['hiring_data']->bill_from_comp, $proforma_no, 'PFA');
	}
?>
<div class="container">

	<div class="row">
	<?php 
		include( get_template_directory().'/admin/side-menu.php' );
	?>
		<div class="col-lg-9">
			<div class="x_panel">
				<div class="x_title">
					<h1>Hiring Bill</h1>
					
						<?php
							if($bill_data['hiring_data']->bill_status == 1) {
								echo '<div class="bill_ststus_change left-right" data-action="bill_status_update" data-status="2" data-billdate="'.date('Y-m-d').'" data-billid="'.$_GET['bill_id'].'" data-siteid="'.$site_detail->id.'">';
								echo '<img class="pay-now" src="'.get_template_directory_uri().'/admin/billing/inc/images/pay-now.png">';
								echo '</div>';
							} else {
								echo '<div class="bill_ststus_change left-right" data-action="bill_status_update" data-status="1" data-billdate="0000-00-00" data-billid="'.$_GET['bill_id'].'" data-siteid="'.$site_detail->id.'">';
								echo '<img class="paid" src="'.get_template_directory_uri().'/admin/billing/inc/images/paid.jpg">';
								echo '</div>';
							}
						?>
					<div class="print_record left-right" data-action="print_hiring" data-action-from="list" data-print-id="<?php echo $_GET['bill_id']; ?>">
						<img src="<?php echo get_template_directory_uri() ?>/admin/inc/images/printer-icon.png">
					</div>
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
								echo "Ref. ".$bill_data['hiring_data']->ref_number;
								echo "</div>";
								echo "<div style='clear:both;'></div>";
								echo "</div>";

								if($bill_data) {
									echo "<div class='address-line'>Profroma No. ".$proforma_number['bill_no']."</div>";
									echo "<div class='address-line'>Bill No. ".$bill_number['bill_no']."</div>";
								}
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
									<div style="float:left;">: <input type="text" name="bill_from" value="<?php echo isset($bill_from) ? $bill_from : '0000:00:00' ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;width:90px;" class="datepicker bill_from"></div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="bill-date">
								<div>
									<div style="float:left; width:60px;line-height: 35px;"> Bill To </div>
									<div style="float:left;">: <input type="text" name="bill_to" value="<?php echo isset($bill_to) ? $bill_to : '0000:00:00' ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;width:90px;" class="datepicker bill_to"></div>
									<div style="float:left;"><input type="button" class="get_bill" value="Get Bill"></div>
								</div>
								<div class="clear"></div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="address-line">Date : <span class="billing-date"><input type="text" name="billing_date" value="<?php echo $billing_date; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;" class="datepicker"></span></div>
							<div class="address-line">Time : <input type="time" name="billing_time" value="<?php echo $billing_time; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;" class="billing-time"></div>
							<div class="address-line">Site : 
								<select type="text" name="delivery_site_name" class="delivery_site_name" data-dvalue="<?php echo ($site_detail) ? $site_detail->id : ''; ?>"  data-sitename="<?php echo ($site_detail) ? $site_detail->site_name : ''; ?>">
								</select>
							</div>
							<div class="address-line">Phone : <span class="site-phone"><?php echo ($site_detail) ? $site_detail->phone_number : ''; ?></span></div>
						</div>
						<div class="col-lg-12">


							<div class="hiring_detail" style="margin-top:20px;">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th rowspan="2" style="width:50px;" class="center-th"><div>S.No</div></th>
											<th rowspan="2" class="center-th" style="min-width: 200px;"><div>Description</div></th>
											<th rowspan="2" class="center-th" style="width:80px;"><div>Qty</div></th>
											<th colspan="3" class="center-th" style="width: 100px;"><div>Peroid</div></th>
											<th rowspan="2" class="center-th" style="width: 100px;"><div>Rate Per Day</div></th>
											<th rowspan="2" class="center-th" style="width: 130px;"><div>Amount</div></th>
										</tr>
										<tr>
											<td>From</td>
											<td>To</td>
											<td>No of days</td>
										</tr>
									</thead>
									<tbody>
									<?php
										if($bill_data && isset($bill_data['hiring_detail']) && count($bill_data['hiring_detail']) > 0) {
											$i = 1;
											foreach ($bill_data['hiring_detail'] as $h_value) {
									?>
										<tr class="div-table-row" class="div-table-row">
											<td>
												<div class="rowno align-txt">
													<?php echo $i; ?>
												</div>
											</td>
											<td>
												<div class="align-txt">
													<span><?php echo $h_value->product_name; ?></span>
													<span><?php echo $h_value->product_type; ?></span>
												</div>
											</td>
											<td>
												<div class="align-txt">
													<span><?php echo $h_value->qty; ?></span>
												</div>
											</td>
											<td>
												<div class="align-txt">	
													<span><?php echo $h_value->bill_from; ?></span>	
												</div>
											</td>
											<td>
												<div class="align-txt">
													<span><?php echo $h_value->bill_to; ?></span>
												</div>
											</td>
											<td>
												<div class="align-txt">
													<span><?php echo $h_value->bill_days; ?></span>	
												</div>
											</td>
											<td>
												<div class="align-txt">
													<span><?php echo $h_value->rate_per_day; ?></span>
												</div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class="bill_amount_txt"><?php echo $h_value->amount; ?></span>
												</div>
											</td>
										</tr>
									<?php
												$i++;
											}
									?>
										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">Total (Hire Charges) : </div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class=""><?php echo $bill_data['hiring_data']->sub_tot ?></span>
												</div>
											</td>
										</tr>
										<?php 
										if( isset($bill_data['hiring_data']->discount_avail) && $bill_data['hiring_data']->discount_avail == 'yes' ) {
										?>
										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">
													<b>Discount <?php echo $bill_data['hiring_data']->discount_percentage; ?>% </b>
												</div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span><?php echo $bill_data['hiring_data']->discount_amount; ?></span>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">
													Total After Discount : 
												</div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span><?php echo $bill_data['hiring_data']->total_after_discount; ?></span>
												</div>
											</td>
										</tr>
										<?php
										}

										
										if( isset($bill_data['hiring_data']->transportation_charge) && $bill_data['hiring_data']->transportation_charge != 0 ) {
										?>
											<tr class="delivery-tr">
												<td colspan="7" style="text-align: right;">
													<div class="align-txt">Delivery Charges</div>
												</td>
												<td>
													<div class="align-txt right-align-txt">
														<span><?php echo $bill_data['hiring_data']->transportation_charge; ?></span>
													</div>
												</td>
											</tr>
										<?php
										}
										if( isset($bill_data['hiring_data']->damage_charge) && $bill_data['hiring_data']->damage_charge != 0 ) {
										?>
											<tr class="damage-tr">
												<td colspan="7" style="text-align: right;">
													<div class="align-txt">Cleaning and Maintanance Charges</div>
												</td>
												<td>
													<div class="align-txt right-align-txt">
														<span><?php echo $bill_data['hiring_data']->damage_charge; ?></span>
													</div>
												</td>
											</tr>
										<?php
										}
										if( isset($bill_data['hiring_data']->lost_charge) && $bill_data['hiring_data']->lost_charge != 0 ) {
										?>
											<tr class="lost-tr">
												<td colspan="7" style="text-align: right;">
													<div class="align-txt">Material Lost Charges </div>
												</td>
												<td>
													<div class="align-txt right-align-txt">
														<span><?php echo $bill_data['hiring_data']->lost_charge; ?></span>					
													</div>
												</td>
											</tr>
										<?php
										}
										if( isset($bill_data['hiring_data']->transportation_charge) && $bill_data['hiring_data']->transportation_charge != 0 && isset($bill_data['hiring_data']->transportation_charge) && $bill_data['hiring_data']->transportation_charge != 0 && isset($bill_data['hiring_data']->lost_charge) && $bill_data['hiring_data']->lost_charge != 0 ) {
										?>
											<tr class="lost-tr">
												<td colspan="7" style="text-align: right;">
													<div class="align-txt">Total </div>
												</td>
												<td>
													<div class="align-txt right-align-txt">
														<span><?php echo $bill_data['hiring_data']->total_before_tax; ?></span>					
													</div>
												</td>
											</tr>
										<?php
										}
										if($bill_data['hiring_data']->tax_from != 'no_tax') {

											if($bill_data['hiring_data']->tax_from == 'gst') {

												if( isset($bill_data['hiring_data']->gst_for) && $bill_data['hiring_data']->gst_for == 'igst') {
											?>
											<tr>
												<td colspan="7" style="text-align: right;">
													<div class="align-txt">IGST - 18%: </div>
												</td>
												<td>
													<div class="align-txt right-align-txt">
														<span class=""><?php echo $bill_data['hiring_data']->igst_amt; ?></span>
													</div>
												</td>
											</tr>
											<?php
												} else {
											?>
											<tr>
												<td colspan="7" style="text-align: right;">
													<div class="align-txt">CGST - 9% : </div>
												</td>
												<td>
													<div class="align-txt right-align-txt">
														<span class=""><?php echo $bill_data['hiring_data']->cgst_amt ?></span>
													</div>
												</td>
											</tr>
											<tr>
												<td colspan="7" style="text-align: right;">
													<div class="align-txt">SGST - 9% : </div>
												</td>
												<td>
													<div class="align-txt right-align-txt">
														<span class=""><?php echo $bill_data['hiring_data']->sgst_amt ?></span>
													</div>
												</td>
											</tr>
											<?php
												}
											}

											if($bill_data['hiring_data']->tax_from == 'vat') {
											?>
												<tr>
													<td colspan="7" style="text-align: right;">
														<div class="align-txt">VAT - 5% : </div>
													</td>
													<td>
														<div class="align-txt right-align-txt">
															<span class=""><?php echo $bill_data['hiring_data']->vat_amt ?></span>
														</div>
													</td>
												</tr>
											<?php
											}
											?>
											<tr class="tax_tr">
												<td colspan="7" style="text-align: right;">
													<div class="align-txt">Total Including Tax : </div>
												</td>
												<td>
													<div class="align-txt right-align-txt">
														<span class=""><?php echo $bill_data['hiring_data']->tax_include_tot; ?></span>
													</div>
												</td>
											</tr>											
										<?php
										}
										?>
										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">Round Off : </div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class=""><?php echo $bill_data['hiring_data']->round_off ?></span>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="7" style="font-size: 20px;font-weight: bold;text-align: center;">
												<div class="align-txt">Total</div>
											</td>
											<td>
												<div class="align-txt right-align-txt">
													<span class=""><?php echo $bill_data['hiring_data']->hiring_total ?></span>
												</div>
											</td>
										</tr>



									<?php
										} else {
									?>
										<tr class="div-table-row" class="div-table-row">
											<td>
												No Bill Found
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
