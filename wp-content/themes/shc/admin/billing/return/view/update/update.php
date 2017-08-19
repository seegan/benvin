<?php
	$master_data = false;
	$customer_detail = false;
	$site_detail = false;

	$pending_items = false;
	
	$customer_id = '';
	$site_id = '';

	$return_detail = false;
	$return_items = false;
	$unloading_data = false;
	$unloading_detail = false;


	if(isset($_GET['id'])) {
		$master_data = getMasterDetail($_GET['id']);
		$master_data = ($master_data) ? $master_data : false;

		if($master_data['master_data']) {
			$customer_id = $master_data['master_data']->customer_id;
			$site_id = $master_data['master_data']->site_id;

			$customer_detail = getCustomerData($customer_id);
			$site_detail = getSiteData($site_id);

			if(isset($_GET['return_id'])) {
				$return_items = (isset($return_data['return_detail']) && $return_data['return_detail'])  ? $return_data['return_detail'] : false;
				$return_detail = (isset($return_data['return_data']) && $return_data['return_data']) ? $return_data['return_data'] : false;

				$return_date = (isset($return_data['return_data']->return_date)) ? date('Y-m-d', strtotime($return_data['return_data']->return_date)) : date('Y-m-d');
				$return_time = (isset($return_data['return_data']->return_date)) ? date('H:i', strtotime($return_data['return_data']->return_date)) : date('H:i');
/*
				$unloading_data = $return_data['unloading_data'];
				$unloading_detail = $return_data['unloading_detail'];*/
			}
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
		<div class="col-lg-9">
			<div class="x_panel">
				<div class="x_title">
					<h2>Item Return</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="create_return">
						<div class="col-lg-6">
							<?php
							if($master_data) {
								echo "<div class='address-line'>No. BA/MRI : ".$master_data['master_data']->id."</div>";
								if($return_date) {
									echo "<div class='address-line'>No. BA/RR : ".$return_data['return_data']->id."</div>";
								}
							} ?>
							<div class="customer-name">Customer Name : M/s 
								<span class="customer-name"><?php echo ($customer_detail->name) ? $customer_detail->name : ''; ?></span>
							</div>
							<div class="address-line">Address : <span class="address-txt"><?php echo ($customer_detail->address) ? $customer_detail->address : ''; ?></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="address-line">Date : <span class="deposit-date"><input type="text" name="date" id="datepicker" value="<?php echo $return_date; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
							<div class="address-line">Time : <span class="deposit-time"><input type="time" name="time" value="<?php echo $return_time; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
							<div class="address-line">Site : 
								<select type="text" name="delivery_site_name" class="delivery_site_name" data-dvalue="<?php echo ($site_detail) ? $site_detail->id : ''; ?>"  data-sitename="<?php echo ($site_detail) ? $site_detail->site_name : ''; ?>">
								</select>
							</div>
							<div class="address-line">Phone : <span class="site-phone"><?php echo ($site_detail) ? $site_detail->phone_number : ''; ?></span></div>
						</div>
						<div class="col-lg-12">
						
							<div class="deposit-repeater return_detail" style="margin-top:20px;">
								<table class="table table-bordered" data-repeater-list="return_detail">
									<thead>
										<tr>
											<th rowspan="2" style="width:50px;" class="center-th"><div>S.No</div></th>
											<th rowspan="2" colspan="3" class="center-th" style="min-width: 200px;"><div>Description</div></th>
											<th rowspan="2" class="center-th" style="width:100px;">
												<div>Qty</div>
											</th>
											<th rowspan="2" style="width:50px;" class="center-th"><div>Action</div></th>
										</tr>
									</thead>
									<tbody>
									<?php


										if($return_items  && count($return_items) > 0) {
											$i = 1;
											foreach ($return_items as $r_value) {
									?>
										<tr class="div-table-row" data-repeater-item class="repeterin div-table-row" >
											<td>
												<div class="rowno align-txt"><?php echo $i; ?></div>
												<input type="hidden" class="return_detail_id" name="return_detail_id" value="<?php echo $r_value->return_detail_id; ?>">
											</td>
											<td colspan="3">
												<div class="align-txt">
													<span><?php echo $r_value->product_name ?></span>
													<span><?php echo $r_value->product_type ?></span>
												</div>
											</td>
											<td>
												<div class="align-txt">
													<input type="text" name="qty" style="border-color: rgba(118, 118, 118, 0);height:34px;margin:0;" class="return_qty" value="<?php echo $r_value->qty; ?>" >
												</div>
											</td>
											<td>
												<input type="hidden" name="unit_price" value="0" class="unit_price">
												<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
												<input type="hidden" value="Delete">
											</td>
										</tr>
									<?php
												$i++;
											}
										}

									?>
										<tr>
											<td colspan="2">
												<div style="width:500px;" class="align-txt">
													<div style="float:left;width:150px;">Vehicle Number : </div>
													<div>
													<input type="text" class="group_vehicle_number" name="vehicle_number" style="border: 0;border-bottom: 2px dotted;" value="<?php echo (isset($return_detail->vehicle_number)) ? $return_detail->vehicle_number : ''; ?>"></div>
												</div>
											</td>
											<td colspan="2"><div class="align-txt"><div class="return-charge-txt">Unloading</div></div></td>
											<td colspan="2"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text" name="unloading" class="return-charge-input unloading" value="<?php echo getUnloadingData($_GET['return_id'], 'unloading') ?>"></div></div></td>
										</tr>
										<tr>
											<td colspan="2">
												<div style="width:500px;" class="align-txt">
													<div style="float:left;width:150px;">Driver Name : </div>
													<div>
														<input type="text" class="group_driver_name" name="driver_name" style="border: 0;border-bottom: 2px dotted;" value="<?php echo (isset($return_detail->driver_name)) ? $return_detail->driver_name : ''; ?>">
													</div>
												</div>
											</td>
											<td colspan="2"><div class="align-txt"><div class="return-charge-txt">Transportation</div></div></td>
											<td colspan="2"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text" name="transportation" class="return-charge-input transportation" value="<?php echo getUnloadingData($_GET['return_id'], 'transportation') ?>"></div></div></td>
										</tr>
										<tr>
											<td colspan="2">
												<div style="width:500px;" class="align-txt">
													<div style="float:left;width:150px;">Mobile Number : </div>
													<div>
														<input type="text" class="group_driver_mobile" name="driver_mobile" style="border: 0;border-bottom: 2px dotted;" value="<?php echo (isset($return_detail->driver_mobile)) ? $return_detail->driver_mobile : ''; ?>">
													</div>
												</div>
											</td>
											<td colspan="2"><div class="align-txt"><div class="return-charge-txt">Damage (as Per detail overleaf)</div></div></td>
											<td colspan="2"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text" name="damage" class="return-charge-input damage" value="<?php echo getUnloadingData($_GET['return_id'], 'damage') ?>"></div></div></td>
										</tr>
										<tr>
											<td colspan="2"></td>
											<td colspan="2"><div class="align-txt"><div class="return-charge-txt">Total</div></div></td>
											<td colspan="2"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text" name="total" class="return-charge-input total" value="<?php echo getUnloadingData($_GET['return_id'], 'total') ?>"></div></div></td>
										</tr>
									</tbody>
								</table>
							</div>

							<div style="float:right;">
	                          	<?php 
	                          		if($master_data) {
	                          			echo "<input type='hidden' name='master_id' value='".$master_data['master_data']->id."'>";
	                          			echo "<input type='hidden' name='return_id' value='".$_GET['return_id']."'>";
	                          			echo "<input type='hidden' name='action' class='action' value='update_return'>";
										echo "<button type='submit' class='btn btn-success create_return'>Update Return</button>";
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