 <?php
	$master_data = false;
	$customer_detail = false;
	$site_detail = false;
	
	$customer_id = 0;
	$site_id = 0;

	$master_date = date('Y-m-d');
	$master_time = date('H:i');

	if(isset($_GET['id'])) {
		$master_data = getMasterDetail($_GET['id']);
		$master_data = ($master_data) ? $master_data : false;

		if($master_data) {
			$customer_id = $master_data['master_data']->customer_id;
			$site_id = $master_data['master_data']->site_id;
			$customer_detail = getCustomerData($customer_id);
			$site_detail = getSiteData($site_id);

			$master_date = date('Y-m-d', strtotime($master_data['master_data']->master_date));
			$master_time = date('H:i', strtotime($master_data['master_data']->master_date));
		}
	}
?>
<style type="text/css">
	.address-line, .customer-name {
		margin-bottom: 20px;
	}
	.x_panel {
		min-height: 200px;
	}
</style>

<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Master Entry</h2>
					<div class="clearfix"></div>
					<input type="hidden" class="in_page" value="master_duplicate_check">
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="create_master">
						<div class="col-lg-6">
							<?php 
								if($master_data) {
									echo "<div class='address-line'>No. BA/MRI : ".$master_data['master_data']->id."</div>";
								}
							?>
							<div class="customer-name">Customer Name : M/s 
								<select type="text" name="customer_name" class="customer_name" data-dvalue='<?php echo $customer_id; ?>' data-name='<?php echo ($customer_detail) ? $customer_detail->name : ""; ?>'>
								<?php
									if($security_data) {
										echo "<option value=${customer_id}></option>";
									}
								?>
								</select>
								<input type="hidden" class="customer_id" value="<?php echo $customer_id; ?>">
							</div>
							<div class="address-line">Address : <span class="address-txt"><?php echo ($customer_detail->address) ? $customer_detail->address : ''; ?></span> </div>
						</div>
						<div class="col-lg-6">
							<div class="address-line">Date : <span class="deposit-date"><input type="text" name="date" id="datepicker" value="<?php echo $master_date; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
							
							<div class="address-line">Time : <span class="deposit-time"><input type="time" name="time" value="<?php echo $master_time; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
							<div class="address-line">Site : 
								<select type="text" name="site_name" class="site_name" data-dvalue='<?php echo $site_id; ?>' data-name='<?php echo ($site_detail) ? $site_detail->site_name : ""; ?>' data-address='<?php echo ($site_detail) ? $site_detail->site_address : ""; ?>'>
								<?php
									if($master_data) {
										echo "<option value=${site_id}></option>";
									}
								?>
								</select>
								<input type="hidden" class="site_id" value="<?php echo $site_id; ?>">
							</div>
							<div class="address-line">Phone : <span class="site-phone"><?php echo ($site_detail) ? $site_detail->phone_number : ''; ?></span></div>
						</div>


						<div style="float:right;">
                          	<?php 
                          		if($master_data) {
                          			echo "<input type='hidden' name='master_id' value='".$master_data['master_data']->id."'>";
                          			echo "<input type='hidden' name='action' class='action' value='update_deposit'>";
                          			echo "<button type='submit' class='btn btn-success create_master'>Update</button>";
                          		} else {
                          			echo "<input type='hidden' name='action' class='action' value='create_master'>";
                          			echo "<button type='submit' class='btn btn-success create_master' disabled>Submit</button>";
                          			echo "<img class='submit_loder' src='".get_template_directory_uri().'/admin/inc/images/5.gif'."'>";
                          		}
                          	?>
                       	</div>


					</div>
				</div>
			</div>
		</div>




		<?php
		if(isset($master_data['master_data']->id)) {
			$master_id = $master_data['master_data']->id;
			$menu_txt = '&id='.$master_id;
		?>
			<div class="col-lg-6">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="x_panel">
						<div class="x_title">
							<h2><big>Deposits</big></h2>
							
							<div class="parallelogram1">
								<a href="<?php echo admin_url('admin.php?page=deposit').$menu_txt;?>">New Deposit</a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<?php
								include( get_template_directory().'/admin/billing/master/listing/deposit.php' );
							?>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="x_panel">
						<div class="x_title">
							<h2><big>Delivery</big></h2>
							<div class="parallelogram1">
								<a href="<?php echo admin_url('admin.php?page=new_delivery').$menu_txt;?>">New Delivery</a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<?php
								include( get_template_directory().'/admin/billing/master/listing/delivery.php' );
							?>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="x_panel">
						<div class="x_title">
							<h2><big>Return</big></h2>
							<div class="parallelogram1">
								<a href="<?php echo admin_url('admin.php?page=new_return').$menu_txt;?>">New Return</a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<?php
								include( get_template_directory().'/admin/billing/master/listing/return.php' );
							?>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12">
					<div class="x_panel">
						<div class="x_title">
							<h2><big>Hiring Bill</big></h2>
							<div class="parallelogram1">
								<a href="<?php echo admin_url('admin.php?page=new_hiring').$menu_txt;?>">New Bill</a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<?php
								include( get_template_directory().'/admin/billing/master/listing/hiring.php' );
							?>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		?>

	</div>

</div>