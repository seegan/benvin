<?php
	$master_id = ( isset($_GET['id']) && $_GET['id'] != 0 ) ? $_GET['id'] : 0;

	$master_data = getMasterDetail($master_id);
	$master_data = ($master_data) ? $master_data : false;
	$statement_date = (isset($_GET['date_to'])) ? $_GET['date_to'] : date('Y-m-d');

	$lost_data['lost_detail'] = false;
	$lost_data['lost_total'] = false;
	$with_sd = ( isset($_GET['sd']) && $_GET['sd'] == 0 ) ? 0 : 1;

	if($master_data['master_data']) {
		$customer_id = $master_data['master_data']->customer_id;
		$site_id = $master_data['master_data']->site_id;

		$customer_detail = getCustomerData($customer_id);
		$site_detail = getSiteData($site_id);
		$statement_data = getAccountStatement($master_id, $statement_date, $with_sd);

		$statement = isset($statement_data['statement_data']) ? $statement_data['statement_data'] : false;
		$cd_data = isset($statement_data['cd_total']) ? $statement_data['cd_total'] : false;

		$lost_data = getLostStatement($master_id, $statement_date);
		$damage_data = getDamageStatement($master_id, $statement_date);
	}
	$company_ids = getCompanies('to_list');


	$credit_amount = 0.00;
	$debit_amount = 0.00;
	$credit_close = '';
	$debit_close = '';

	if( isset($cd_data->credit_total) && $cd_data->credit_total <= $cd_data->debit_total ) {
		$credit_amount = number_format((float)$cd_data->debit_total, 2, '.', '');
		$debit_amount = number_format((float)$cd_data->debit_total, 2, '.', '');
	} else {
		$credit_amount = number_format((float)$cd_data->credit_total, 2, '.', '');
		$debit_amount = number_format((float)$cd_data->credit_total, 2, '.', '');
	}

	if($cd_data->cd_bal < 0) {
		$credit_bal = number_format((float)(abs($cd_data->cd_bal)), 2, '.', '');
		$debit_bal = '';
	}
	if($cd_data->cd_bal > 0) {
		$credit_bal = '';
		$debit_bal = number_format((float)(abs($cd_data->cd_bal)), 2, '.', '');
	}
	if($cd_data->cd_bal == 0) {
		$credit_bal = '';
		$debit_bal = '';
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
					<h2>Account Statement</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="create_billing">
						<div class="col-lg-6">
							<input type="hidden" class="statement_id" value="<?php echo $master_id; ?>">
							<?php
							if($master_data) {
								echo "<div class='address-line'>MRI : ".$master_data['master_data']->id."</div>";
							}
							?>
							<div class="customer-name">Customer Name : M/s 
								<span class="customer-name"><?php echo ($customer_detail->name) ? $customer_detail->name : ''; ?></span>
							</div>
							<div class="address-line">Address : <span class="address-txt"><?php echo ($customer_detail->address) ? $customer_detail->address : ''; ?></span>
							</div>
							<div class="address-line">
								With SD : <input type="checkbox" class="statement_with_sd" value="1" style="margin-top: -2px;" <?php echo ($with_sd == 1 ) ? 'checked' : ''; ?>>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="address-line">Date : <span class="billing-date"><input type="text" name="billing_date" value="<?php echo $statement_date; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;" class="datepicker"></span>
							</div>
							<div class="address-line">Site : 
								<select type="text" name="delivery_site_name" class="delivery_site_name" data-dvalue="<?php echo ($site_detail) ? $site_detail->id : ''; ?>"  data-sitename="<?php echo ($site_detail) ? $site_detail->site_name : ''; ?>">
								</select>
							</div>
							<div class="address-line">Phone : <span class="site-phone"><?php echo ($site_detail) ? $site_detail->phone_number : ''; ?></span></div>
						</div>
						<div class="col-lg-12">


							<div class="deposit-repeater hiring_detail" style="margin-top:20px;">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th rowspan="2" style="width:100px;" class="center-th"><div>Date</div></th>
											<th rowspan="2" class="center-th"><div>Description</div></th>
											<th rowspan="2" class="center-th" style="width:100px;"><div>Bill Ref</div></th>
											<th rowspan="2" style="width:140px;" class="center-th"><div>Cr.</div></th>
											<th rowspan="2" style="width:140px;" class="center-th"><div>Dr.</div></th>
										</tr>
									</thead>
									<tbody>
										<?php
											if($statement) {
										
												foreach ($statement as $s_value) {
													$company_id = $s_value->bill_from_comp;

													if($s_value->description == 'Missing Cost'  ) {
														if($s_value->debit && $s_value->debit != 0) {
										?>
													<tr>
														<td>
															<?php echo date("d-m-Y", strtotime($s_value->bill_date)); ?>
														</td>
														<td>
															<?php echo $s_value->description; ?>
														</td>
														<td>
															
														</td>
														<td class="right-align-txt">
															<?php echo $s_value->credit; ?>
														</td>
														<td class="right-align-txt">
															<?php echo $s_value->debit; ?>
														</td>
													</tr>
										<?php
														}
													} else {
										?>
													<tr>
														<td>
															<?php echo date("d-m-Y", strtotime($s_value->bill_date)); ?>
														</td>
														<td>
															<?php echo $s_value->description; ?>
														</td>
														<td>
															<?php
																echo $company_ids[$company_id].'/'.$s_value->bill_ref;
															?>
														</td>
														<td class="right-align-txt">
															<?php echo $s_value->credit; ?>
														</td>
														<td class="right-align-txt">
															<?php echo $s_value->debit; ?>
														</td>
													</tr>
										<?php
													}
												}
										?>
													<tr>
														<td colspan="3">
															<div class="center-txt" style="font-size: 13px;font-weight: 600;">
																Closing Balance
															</div>
														</td>
														<td class="right-align-txt">
															<?php echo $credit_bal ?>
														</td>
														<td class="right-align-txt">
															<?php echo $debit_bal ?>
														</td>
													</tr>
													<tr>
														<td colspan="3">
															<div class="center-txt" style="font-size: 13px;font-weight: 600;">
																Total
															</div>
														</td>
														<td class="right-align-txt">
															<?php echo $credit_amount; ?>
														</td>
														<td class="right-align-txt">
															<?php echo $debit_amount; ?>
														</td>
													</tr>
										<?php
											}
										?>
									</tbody>
								</table>
							</div>



							<?php
								if( $lost_data['lost_detail'] && $lost_data['lost_total'] ) {
							?>
							<div class="deposit-repeater hiring_detail" style="margin-top:20px;">
								<h2>Missing Cost</h2>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th rowspan="2" style="width:80px;" class="center-th"><div>SL#</div></th>
											<th rowspan="2" class="center-th"><div>Description</div></th>
											<th rowspan="2" class="center-th"><div>Qty</div></th>
											<th rowspan="2" style="width:140px;" class="center-th"><div>Rate</div></th>
											<th rowspan="2" style="width:140px;" class="right-align-txt"><div>Amount</div></th>
										</tr>
									</thead>
									<tbody>
										<?php
												$i = 1;
												foreach ($lost_data['lost_detail'] as $ld_value) {
										?>
													<tr>
														<td>
															<?php echo $i; ?>
														</td>
														<td>
															<?php echo $ld_value->product_name.' '.$ld_value->product_type; ?>
														</td>
														<td>
															<?php echo $ld_value->lost_qty; ?>
														</td>
														<td>
															<?php echo $ld_value->lost_unit_price; ?>
														</td>
														<td class="right-align-txt">
															<?php echo $ld_value->lost_total; ?>
														</td>
													</tr>
										<?php
													$i++;
												}
										?>
													<tr>
														<td colspan="4">Total</td>
														<td class="right-align-txt"><?php echo $lost_data['lost_total']->debit; ?></td>
													</tr>
									</tbody>
								</table>
							</div>
							<?php
								}
							?>



							<?php
								if( $damage_data['damage_detail'] && $damage_data['damage_total'] ) {
							?>
							<div class="deposit-repeater hiring_detail" style="margin-top:20px;">
								<h2>Damage Detail</h2>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th rowspan="2" style="width:80px;" class="center-th"><div>SL#</div></th>
											<th rowspan="2" class="center-th"><div>Description</div></th>
											<th rowspan="2" style="width:140px;" class="center-th"><div>Amount</div></th>
										</tr>
									</thead>
									<tbody>
										<?php
												$i = 1;
												foreach ($damage_data['damage_detail'] as $dd_value) {
										?>
													<tr>
														<td>
															<?php echo $i; ?>
														</td>
														<td>
															<?php echo $dd_value->damage_detail; ?>
														</td>
														<td class="right-align-txt">
															<?php echo $dd_value->damage_charge; ?>
														</td>
													</tr>
										<?php
													$i++;
												}
										?>
													<tr>
														<td colspan="2">Total</td>
														<td class="right-align-txt"><?php echo $damage_data['damage_total']->debit; ?></td>
													</tr>
									</tbody>
								</table>
							</div>
							<?php
								}
							?>




						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>