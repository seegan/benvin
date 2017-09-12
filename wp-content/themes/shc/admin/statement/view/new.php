<?php
	$master_id = ( isset($_GET['id']) && $_GET['id'] != 0 ) ? $_GET['id'] : 0;

	$master_data = getMasterDetail($master_id);
	$master_data = ($master_data) ? $master_data : false;
	$statement_date = (isset($_GET['date_to'])) ? $_GET['date_to'] : date('Y-m-d');

	$lost_data['lost_detail'] = false;
	$lost_data['lost_total'] = false;

	if($master_data['master_data']) {
		$customer_id = $master_data['master_data']->customer_id;
		$site_id = $master_data['master_data']->site_id;

		$customer_detail = getCustomerData($customer_id);
		$site_detail = getSiteData($site_id);

		$statement = getAccountStatement($master_id, $statement_date);

		$lost_data = getLostStatement($master_id, $statement_date);
	}


	$company_ids = getCompanies('to_list');


?>

<div class="container">

	<div class="row">
		<div class="col-lg-3">
			<div class="x_panel">
				<div class="x_title">
					<h2><small>Sessions</small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
				<?php
					$id_txt = (isset($_GET['id'])) ? '&id='.$_GET['id'] : '';
				?>
					<ul>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=new_delivery').$id_txt;  ?>">New Delivery</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=new_return').$id_txt; ?>">New Return</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=new_hiring').$id_txt; ?>">Generate Hiring Bill</a></li>
					</ul>
				</div>
			</div>

			<div class="x_panel">
				<div class="x_title">
					<h2><small>Sessions</small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
				<?php
					$id_txt = (isset($_GET['id'])) ? '&id='.$_GET['id'] : '';
				?>
					<ul>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=new_delivery'); ?>">Delivery List</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=new_return'); ?>">Return List</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=new_hiring'); ?>">Hiring Bill List</a></li>
					</ul>
				</div>
			</div>
		</div>




		<div class="col-lg-9">
			<div class="x_panel">
				<div class="x_title">
					<h2>Account Statement</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="create_billing">
						<div class="col-lg-6">
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
											<th rowspan="2" style="width:140px;" class="center-th"><div>Date</div></th>
											<th rowspan="2" class="center-th"><div>Description</div></th>
											<th rowspan="2" class="center-th"><div>Bill Ref</div></th>
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
															<?php echo $s_value->bill_date; ?>
														</td>
														<td>
															<?php echo $s_value->description; ?>
														</td>
														<td>
															
														</td>
														<td>
															<?php echo $s_value->credit; ?>
														</td>
														<td>
															<?php echo $s_value->debit; ?>
														</td>
													</tr>
										<?php
														}
													} else {
										?>
													<tr>
														<td>
															<?php echo $s_value->bill_date; ?>
														</td>
														<td>
															<?php echo $s_value->description; ?>
														</td>
														<td>
															<?php
																echo $company_ids[$company_id].'/'.$s_value->bill_ref;
															?>
														</td>
														<td>
															<?php echo $s_value->credit; ?>
														</td>
														<td>
															<?php echo $s_value->debit; ?>
														</td>
													</tr>
										<?php
													}
										?>

										<?php
												}
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
											<th rowspan="2" style="width:140px;" class="center-th"><div>Amount</div></th>
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
														<td>
															<?php echo $ld_value->lost_total; ?>
														</td>
													</tr>
										<?php
													$i++;
												}
										?>
													<tr>
														<td colspan="4">Total</td>
														<td><?php echo $lost_data['lost_total']->debit; ?></td>
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