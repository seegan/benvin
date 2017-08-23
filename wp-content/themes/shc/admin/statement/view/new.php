<?php
	$master_id = ( isset($_GET['id']) && $_GET['id'] != 0 ) ? $_GET['id'] : 0;

	$master_data = getMasterDetail($master_id);
	$master_data = ($master_data) ? $master_data : false;
	$statement_date = (isset($_GET['date_to'])) ? $_GET['date_to'] : date('Y-m-d');

	if($master_data['master_data']) {
		$customer_id = $master_data['master_data']->customer_id;
		$site_id = $master_data['master_data']->site_id;

		$customer_detail = getCustomerData($customer_id);
		$site_detail = getSiteData($site_id);

		$statement = getAccountStatement($master_id, $statement_date);
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
					<h2>Account Statement</h2>
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
								<table class="table table-bordered" data-repeater-list="hiring_detail">
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
										?>
													<tr>
														<td>
															<?php echo $s_value->r_date; ?>
														</td>
														<td>
															<?php echo $s_value->description; ?>
														</td>
														<td>
															<?php echo $s_value->bill_ref; ?>
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

















