 <?php
	$master_data = false;
	$customer_detail = false;
	$site_detail = false;

	$delivery_data = false;

	$vehicle_number = false;
	$driver_name = false;
	$driver_mobile = false;


	$customer_id = '';
	$site_id = '';

	$delivery_date = date('Y-m-d');
	$delivery_time = date('H:i');

	if(isset($_GET['id'])) {
		$master_data = getMasterDetail($_GET['id']);
		$master_data = ($master_data) ? $master_data : false;



		if($master_data['master_data']) {
			
			$customer_id = $master_data['master_data']->customer_id;

			$site_id = $master_data['master_data']->site_id;

			$customer_detail = getCustomerData($customer_id);
			$site_detail = getSiteData($site_id);

			if(isset($_GET['delivery_id'])) {
				$delivery_data = getDeliveryData($_GET['delivery_id']);
				$delivery_date = date('Y-m-d', strtotime($delivery_data['delivery_data']->delivery_date));
				$delivery_time = date('H:i', strtotime($delivery_data['delivery_data']->delivery_date));



				
				$vehicle_number = isset($delivery_data['delivery_data']->vehicle_number) ? $delivery_data['delivery_data']->vehicle_number : false; 
				$driver_name = isset($delivery_data['delivery_data']->driver_name) ? $delivery_data['delivery_data']->driver_name : false; 
				$driver_mobile = isset($delivery_data['delivery_data']->driver_mobile) ? $delivery_data['delivery_data']->driver_mobile : false; 
			}
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
					<h2>Delivery</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="create_delivery">
						<div class="col-lg-6">
							<?php
							if($master_data) {

								echo "<div class='address-line'>";
								echo "<div style='float:left;width: 200px;'>";
								echo "MRI : ".$master_data['master_data']->id;
								echo "</div>";
								echo "<div style='float:left;width: 200px;'>";
								echo "Ref.<input type='text' name='ref_number' style='width: 150px;border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;' value='".$delivery_data['delivery_data']->ref_number."'>";
								echo "</div>";
								echo "<div style='clear:both;'></div>";
								echo "</div>";
								echo "<input type='hidden' name='master_id' value='".$master_data['master_data']->id."'>";
								
								if($delivery_data) {

									$bill_number = billNumberText($delivery_data['delivery_data']->bill_from_comp, $delivery_data['delivery_data']->bill_no, 'DC');
									echo "<div class='address-line'>No. ".$bill_number['bill_no']."</div>";
								}
							}
							?>
							<div class="customer-name">Customer Name : M/s  
								<span class="customer-name"><?php echo ($customer_detail->name) ? $customer_detail->name : ''; ?></span>
								<input type="hidden" class="customer_id" value="<?php echo ($customer_detail->id) ? $customer_detail->id : 0; ?>">
							</div>
							<div class="address-line">Address : <span class="address-txt"><?php echo ($customer_detail->address) ? $customer_detail->address : ''; ?></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="address-line">Site : 
								<select type="text" name="delivery_site_name" class="delivery_site_name" data-dvalue="<?php echo ($site_detail) ? $site_detail->id : ''; ?>"  data-sitename="<?php echo ($site_detail) ? $site_detail->site_name : ''; ?>">
								</select>
								<input type="hidden" class="site_id" value="<?php echo ($site_detail) ? $site_detail->id : 0; ?>">
							</div>
							<div class="address-line">Date : <span class="deposit-date"><input type="text" name="date" id="datepicker" class="financial_date" value="<?php echo $delivery_date; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
							<div class="address-line">Time : <span class="deposit-time"><input type="time" name="time" value="<?php echo $delivery_time; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
							<div class="address-line">Phone : <span class="site-phone"><?php echo ($site_detail) ? $site_detail->phone_number : ''; ?></span></div>
						</div>
						<div class="col-lg-12">
							<?php
								if($master_data) {
							?>
							<div class="deposit-repeater delivery_detail" style="margin-top:20px;">
								<table class="table table-bordered" data-repeater-list="delivery_detail">
									<thead>
										<tr>
											<th rowspan="2" style="width:50px;" class="center-th"><div>S.No</div></th>
											<th rowspan="2" colspan="3" class="center-th" style="min-width: 200px;"><div>Description</div></th>
											<th rowspan="2" class="center-th" style="width:100px;">
												<div>Qty</div>
											</th>
											<th colspan="2">
												<div>Action</div>
											</th>
										</tr>
									</thead>
									<tbody>
									<?php
										if($delivery_data && isset($delivery_data['delivery_detail']) && count($delivery_data['delivery_detail']) > 0) {
											$i = 1;
											foreach ($delivery_data['delivery_detail'] as $d_value) {
									?>
										<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row" data-lotid="<?php echo $d_value->lot_id; ?>" data-stockbal="0">
											<td>
												<div class="rowno align-txt"><?php echo $i; ?></div>
												<input type="hidden" class="delivery_detail_id" name="delivery_detail_id" value="<?php echo $d_value->delivery_detail_id; ?>">
												<input type="hidden" class="lot_id_orig" name="lot_id_orig" value="<?php echo $d_value->lot_id; ?>">
											</td>
											<td colspan="3">
												<select name="lot_number" class="lot_id" tabindex="-1" aria-hidden="true" data-dvalue="<?php echo $d_value->lot_id; ?>" data-dtext="<?php echo $d_value->lot_no; ?>" data-dname="<?php echo $d_value->product_name; ?>" data-dtype="<?php echo $d_value->product_type; ?>"></select>
											</td>
											<td>
												<input type="text" name="qty" style="border-color: rgba(118, 118, 118, 0);width:80px;height:34px;margin:0;" class="dpt_qty" value="<?php echo $d_value->qty; ?>" >
											</td>
											<td>
												<input type="hidden" name="unit_price" class="unit_price" value="<?php echo $d_value->rate_per_unit; ?>">
												<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
												<input type="hidden" value="Delete">
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
												<input type="hidden" class="delivery_detail_id" name="delivery_detail_id" value="0">
												<input type="hidden" class="lot_id_orig" name="lot_id_orig" value="0">
											</td>
											<td colspan="3">
												<select name="lot_number" class="lot_id" tabindex="-1" aria-hidden="true"></select>
											</td>
											<td>
												<input type="text" name="qty" value="1" style="border-color: rgba(118, 118, 118, 0);width:80px;height:34px;margin:0;" class="dpt_qty">
											</td>
											<td>
												<input type="hidden" name="unit_price" value="0" class="unit_price">
												<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
												<input type="hidden" value="Delete">
											</td>
										</tr>
									<?php
										}
									?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3">
												<div style="width:400px;" class="align-txt">
													<div style="float:left;width:150px;">Vehicle Number : </div>
													<div style="float: left;">
														<input type="text" name="vehicle_number" class="vehicle_number" style="border: 0;border-bottom: 2px dotted;" value="<?php echo ($vehicle_number) ? $vehicle_number : ''; ?>">
													</div>
												</div>
											</td>
											<td colspan="3">
												
											</td>
										</tr>
										<tr>
											<td colspan="3">
												<div style="width:400px;" class="align-txt">
													<div style="float:left;width:150px;">Driver Name : </div>
													<div style="float: left;">
														<input type="text" name="driver_name" class="driver_name" style="border: 0;border-bottom: 2px dotted;" value="<?php echo ($driver_name) ? $driver_name : ''; ?>">
													</div>
												</div>
											</td>
											<td colspan="3">
												
											</td>
										</tr>
										<tr>
											<td colspan="3">
												<div style="width:400px;" class="align-txt">
													<div style="float:left;width:150px;">Mobile Number : </div>
													<div style="float: left;">
														<input type="text" name="driver_mobile" class="driver_mobile" style="border: 0;border-bottom: 2px dotted;" value="<?php echo ($driver_mobile) ? $driver_mobile : ''; ?>">
													</div>
												</div>
											</td>
											<td colspan="3">
												
											</td>
										</tr>
									</tfoot>
								</table>

								<ul class="icons-labeled">
									<li><a data-repeater-create href="javascript:void(0);" id="add_new_price_range"><span class="icon-block-color add-c"></span>Add</a></li>
								</ul>
							</div>

							<div style="float:right;">
	                          	<?php 
                          			echo "<input type='hidden' name='master_id' value='".$master_data['master_data']->id."'>";
									echo "<button type='submit' class='btn btn-success create_delivery'>Update Delivery</button>";

                          			if(isset($delivery_data['delivery_data']) && $delivery_data['delivery_data']) {
                          				echo "<input type='hidden' name='delivery_id' value='".$delivery_data['delivery_data']->id."'>";
                          				echo "<input type='hidden' name='action' class='action' value='update_delivery'>";
                          			} else {
                          				echo "<input type='hidden' name='action' class='action' value='new_delivery'>";
                          			}	                          	
                          		?>
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