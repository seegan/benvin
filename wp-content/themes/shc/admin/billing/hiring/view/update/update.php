<?php

	$master_id = (isset($bill_data['hiring_data']->master_id)) ? $bill_data['hiring_data']->master_id : 0;


	$master_data = getMasterDetail($master_id);
	$master_data = ($master_data) ? $master_data : false;


	if($master_data['master_data']) {
		$customer_id = $master_data['master_data']->customer_id;
		$site_id = $master_data['master_data']->site_id;

		$customer_detail = getCustomerData($customer_id);
		$site_detail = getSiteData($site_id);

		$bill_from = (isset($bill_data['hiring_data']->bill_from) && $bill_data['hiring_data']->bill_from != '') ? $bill_data['hiring_data']->bill_from : date('Y-m-01');
		$bill_to = (isset($bill_data['hiring_data']->bill_to) && $bill_data['hiring_data']->bill_to != '') ? $bill_data['hiring_data']->bill_to : date('Y-m-d', strtotime('last day of this month'));
		$hiring_items = getHiringItems($_GET['id'], $bill_from, $bill_to);

		$billing_date = (isset($bill_data['hiring_data']->bill_date) && $bill_data['bill_date']->bill_date != '') ? $master_data['hiring_data']->bill_date : date('Y-m-d');
		$billing_time = (isset($bill_data['hiring_data']->bill_time)) ? date('H:i', strtotime($bill_data['hiring_data']->bill_time)) : date('H:i');
	}
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
					$id_txt = (isset($master_id)) ? '&id='.$master_id : '';
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
					<h2>Hiring Bill</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="create_billing">
						<div class="col-lg-6">
							<?php
							if($master_data) {
								echo "<div class='address-line'>No. BA/SD : ".$master_data['master_data']->id."</div>";
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
										<tr class="div-table-row" class="div-table-row" >
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
												<div class="align-txt">
													<span class="bill_amount_txt"><?php echo $h_value->amount; ?></span>
												</div>
											</td>
										</tr>
									<?php
												$i++;
											}
									?>
										<tr>
											<td colspan="7" style="font-size: 13px;font-weight: bold;">MRRs <?php echo $bill_data['hiring_data']->return_ids ?> Transport & Unloading.
											</td>
											<td>
												<?php echo $bill_data['hiring_data']->transportation_charge ?>
											</td>
										</tr>
										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">Sub Total : </div>
											</td>
											<td>
												<div class="align-txt">
													<span class=""><?php echo $bill_data['hiring_data']->hiring_total ?></span>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">GST : </div>
											</td>
											<td>
												<div class="align-txt">
													<span class="hiring_tot_txt"></span>
													<input type="hidden" class="hiring_tot_val" name="hiring_tot" value="">
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">Round Off : </div>
											</td>
											<td>
												<div class="align-txt">
													<span class="hiring_tot_txt"></span>
													<input type="hidden" class="hiring_tot_val" name="hiring_tot" value="">
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="7" style="font-size: 20px;font-weight: bold;text-align: center;">
												<div class="align-txt">Total</div>
											</td>
											<td>
												<div class="align-txt">
													<span class="hiring_tot_txt"></span>
													<input type="hidden" class="hiring_tot_val" name="hiring_tot" value="">
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

















