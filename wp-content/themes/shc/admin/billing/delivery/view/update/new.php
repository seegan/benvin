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
			$site_detail = getSiteData($site_id, $bill_for = 'shc_delivery');
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
								echo "<div class='address-line'>No. BA/MRI : ".$master_data['master_data']->id."</div>";
								echo "<input type='hidden' name='master_id' value='".$master_data['master_data']->id."'>";

								echo '<div class="address-line">Bill No : ';
								echo '	<span class="deposit-time">';
								echo $site_detail->company_id."/DC <input type='text' style='border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;' value='".$site_detail->next_bill_no."' name='bill_no' class='bill bill_no'>";
								echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/5.gif" style="width: 20px;display:none;" class="loadin-billfrom">';
								echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/check.png" style="width: 20px;display:none;" class="loadin-check">';
								echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/cross.png" style="width: 20px;display:none;" class="loadin-cross">';
								echo '	</span>';
								echo '<input type="hidden" class="billno_action" value="shc_delivery">';
								echo '</div>';
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
								<input type="hidden" class="site_id" name="site_id" value="<?php echo ($site_detail) ? $site_detail->id : 0; ?>">
							</div>
							<div class="address-line">Date : <span class="deposit-date"><input type="text" name="date" id="datepicker" value="<?php echo $delivery_date; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
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
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3">
												<div style="width:400px;" class="align-txt">
													<div style="float:left;width:150px;">Vehicle Number : </div>
													<div style="float: left;">
														<input type="text" name="vehicle_number" class="vehicle_number" style="border: 0;border-bottom: 2px dotted;" value="">
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
														<input type="text" name="driver_name" class="driver_name" style="border: 0;border-bottom: 2px dotted;" value="">
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
														<input type="text" name="driver_mobile" class="driver_mobile" style="border: 0;border-bottom: 2px dotted;" value="">
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
									echo "<button type='submit' class='btn btn-success create_delivery'>Update Delivery</button>";
                          			echo "<input type='hidden' name='action' class='action' value='new_delivery'>";	                          	
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