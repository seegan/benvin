<?php
	$master_data = false;
	$customer_detail = false;
	$site_detail = false;
	
	$customer_id = '';
	$site_id = '';

	$obc_date = date('Y-m-d');
	$obc_time = date('H:i');

	if(isset($_GET['id'])) {
		$master_data = getMasterDetail($_GET['id']);

		$master_data = ($master_data) ? $master_data : false;

		if($master_data['master_data']) {
			$customer_id = $master_data['master_data']->customer_id;
			$site_id = $master_data['master_data']->site_id;

			$customer_detail = getCustomerData($customer_id);
			$site_detail = getSiteData($site_id);


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
					<h2>Update OBC</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="create_obc">
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
							<div class="address-line">Date : <span class="billing-date"><input type="text" name="obc_date" value="<?php echo $obc_date; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;" class="datepicker"></span></div>
							<div class="address-line">Time : <input type="time" name="obc_time" value="<?php echo $obc_time; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;" class="billing-time"></div>
							<div class="address-line">Site : 
								<select type="text" name="delivery_site_name" class="delivery_site_name" data-dvalue="<?php echo ($site_detail) ? $site_detail->id : ''; ?>"  data-sitename="<?php echo ($site_detail) ? $site_detail->site_name : ''; ?>">
								</select>
							</div>
							<div class="address-line">Phone : <span class="site-phone"><?php echo ($site_detail) ? $site_detail->phone_number : ''; ?></span></div>
						</div>
						<div class="col-lg-12">


							<div class="obc_detail amt_update style="margin-top:20px;">

								<div class="check-block">
									<div class="row">
										<div class="col-lg-3">
											Received By <br>
											Chash / Cheque
										</div>
										<div class="col-lg-9">
											<?php
											if($obc_data) {
											?>
												<div class="check-container">
													<input type="hidden" name="obc_id" value="<?php echo $obc_data->id ?>">
													<table class="table table-bordered">
														<tr>
															<td  style="width:150px;">Cheque No : </td>
															<td><input type="text" name="cheque_no" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" value="<?php echo $obc_data->cheque_no ?>"></td>
														</tr>
														<tr>
															<td>Date : </td>
															<td><input type="text" name="cheque_date" class="datepicker" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" value="<?php echo $obc_data->cheque_date ?>"></td>
														</tr>
														<tr>
															<td>Amount :</td>
															<td><input type="text" class="cheque_amt" name="cheque_amt" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" value="<?php echo $obc_data->cheque_amount ?>"></td>
														</tr>
														<tr>
															<td>Notes :</td>
															<td><textarea name="obc_notes" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 50px;margin: 0;padding: 10px 0;"><?php echo $obc_data->notes ?></textarea>
															</td>
														</tr>

													</table>
												</div>
											<?php
											} 
											?>
										</div>
									</div>
								</div>


								<div class="rupee-txt" style="padding-bottom:15px;">
									Rupees : 
									<span class="rupee-words" style="border-bottom: 2px dotted;padding-bottom: 5px;line-height: 35px;">
										0
									</span>
								</div>

								
							</div>

							<div style="float:right;">
	                          	<?php 
	                          		if($master_data) {
	                          			echo "<input type='hidden' name='master_id' class='master_id_input' value='".$master_data['master_data']->id."'>";
										echo "<button type='submit' class='btn btn-success create_obc'>Create OBC</button>";
										echo "<input type='hidden' name='action' class='action' value='update_obc'>";
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

















