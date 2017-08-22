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
			$site_detail = getSiteData($site_id);

			$bill_from = (isset($_GET['bill_from']) && $_GET['bill_from'] != '') ? $_GET['bill_from'] : date('Y-m-01');
			$bill_to = (isset($_GET['bill_to']) && $_GET['bill_to'] != '') ? $_GET['bill_to'] : date('Y-m-d', strtotime('last day of this month'));
			$hiring_items = getHiringItems($_GET['id'], $bill_from, $bill_to);
			$existin_bill = getExistBillData($_GET['id'], $bill_from, $bill_to);
		}
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



		<?php
		if($existin_bill) {
		?>
			<div class="col-lg-9">
				<div class="x_panel">
					<div class="x_title">
						<h2>Passed Bill Data</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-bordered">
							<thead>
								<tr>
									<td>Bill ID</td>
									<td>Bill Date</td>
									<td>Master Id</td>
									<td>Bill From</td>
									<td>Bill To</td>
									<td>Transport Charge</td>
									<td>Bill Total</td>
									<td>Action</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $existin_bill->id; ?></td>
									<td><?php echo $existin_bill->bill_date.' '.$existin_bill->bill_time; ?></td>
									<td><?php echo $existin_bill->master_id; ?></td>
									<td><?php echo $existin_bill->bill_from; ?></td>
									<td><?php echo $existin_bill->bill_to; ?></td>
									<td><?php echo $existin_bill->transportation_charge; ?></td>
									<td><?php echo $existin_bill->hiring_total; ?></td>
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
									<div style="float:left;">: <input type="text" name="bill_from" value="<?php echo isset($_GET['bill_from']) ? $_GET['bill_from'] : $bill_from ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;width:90px;" class="datepicker bill_from"></div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="bill-date">
								<div>
									<div style="float:left; width:60px;line-height: 35px;"> Bill To </div>
									<div style="float:left;">: <input type="text" name="bill_to" value="<?php echo isset($_GET['bill_to']) ? $_GET['bill_to'] : $bill_to ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;width:90px;" class="datepicker bill_to"></div>
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
												<div class="align-txt">
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
																		Payment For 30 Days : <span class="slab_sys_txt"><?php echo $h_value->min_bill_amt; ?></span>
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
											<td colspan="7" style="font-size: 13px;font-weight: bold;">MRRs <?php echo $hiring_items['return_ids'] ?> Transport & Unloading.
											<input type="hidden" name="transport_return_id" value="<?php echo $hiring_items['return_ids'] ?>">
											</td>
											<td>
												<?php
													echo $hiring_items['loading_charges'];
												?>
												<input type="hidden" class="row_hiring_amt" name="unloading_total" value="<?php echo $hiring_items['loading_charges']; ?>">
											</td>
											<td></td>
										</tr>
										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">Sub Total</div>
											</td>
											<td>
												<div class="align-txt">
													<span class="sub_tot_txt"></span>
													<input type="hidden" class="sub_tot_val" name="sub_tot" value="0">
												</div>
											</td>
											<td></td>
										</tr>



									<?php if(isset($site_detail->gst_for) && $site_detail->gst_for == 'igst') { ?>
										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">IGST : </div>
												<input type="hidden" class="gst_percentage" value="18">
											</td>
											<td>
												<div class="align-txt">
													<span class="gst_igst_txt"></span>
													<input type="hidden" class="gst_igst" name="gst_igst" value="0">
												</div>
											</td>
											<td></td>
										</tr>
									<?php } else {
									?>
										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">CGST : </div>
												<input type="hidden" class="gst_percentage" value="9">
											</td>
											<td>
												<div class="align-txt">
													<span class="gst_cgst_txt"></span>
													<input type="hidden" class="gst_cgst" name="gst_cgst" value="0">
												</div>
											</td>
											<td></td>
										</tr>
										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">SGST : </div>
												<input type="hidden" class="gst_percentage" value="0">
											</td>
											<td>
												<div class="align-txt">
													<span class="gst_sgst_txt"></span>
													<input type="hidden" class="gst_sgst" name="gst_sgst" value="0">
												</div>
											</td>
											<td></td>
										</tr>
									<?php
									} ?>
										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">Total Including GST : </div>
											</td>
											<td>
												<div class="align-txt">
													<span class="gst_include_total_txt"></span>
													<input type="hidden" class="gst_include_total" name="gst_include_total" value="">
												</div>
											</td>
											<td></td>
										</tr>
										<tr>
											<td colspan="7" style="text-align: right;">
												<div class="align-txt">Round Off : </div>
											</td>
											<td>
												<div class="align-txt">
													<input type="text" class="round_off" name="round_off" value="0" style="border-color: rgba(118, 118, 118, 0);height:34px;margin:0;">
												</div>
											</td>
											<td></td>
										</tr>
										<tr>
											<td colspan="7" style="font-size: 20px;font-weight: bold;text-align: center;">
												<div class="align-txt">Total</div>
											</td>
											<td>
												<div class="align-txt">
													<span class="hiring_tot_txt"></span>
													<input type="hidden" name="gst_for" class="gst_for"  value="<?php echo isset($site_detail->gst_for) ? $site_detail->gst_for : 'cgst'; ?>">
													<input type="hidden" class="hiring_tot_val" name="hiring_tot" value="0">
												</div>
											</td>
											<td></td>
										</tr>

									<?php
										} else {
									?>
										<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row" data-lotid="0" data-stockbal="0">
											<td>
												No Pending Items
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
	                          			} else {
	                          				echo "<input type='hidden' name='action' class='action' value='create_billing'>";
	                          				echo "<button type='submit' class='btn btn-success create_billing'>Generate Bill</button>";
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

















