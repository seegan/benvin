<?php
	$master_data = false;
	$customer_detail = false;
	$site_detail = false;
	
	$customer_id = '';
	$site_id = '';

	$obc_date = (isset($_GET['obc_date'])) ? $_GET['obc_date'] : date('Y-m-d');
	$obc_time = date('H:i');

	if(isset($_GET['id'])) {
		$master_data = getMasterDetail($_GET['id']);

		$master_data = ($master_data) ? $master_data : false;

		if($master_data['master_data']) {
			$customer_id = $master_data['master_data']->customer_id;
			$site_id = $master_data['master_data']->site_id;

			$customer_detail = getCustomerData($customer_id);
			$site_detail = getSiteData($site_id, $bill_for = 'shc_obc_cheque', $obc_date);
		}
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
					<h2>New Receipt</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="create_obc">
						<div class="col-lg-6">
							<?php
							if($master_data) {
								echo "<div class='address-line'>";
								echo "<div style='float:left;width: 200px;'>";
								echo "MRI : ".$master_data['master_data']->id;
								echo "</div>";
								echo "<div style='float:left;width: 200px;'>";
								echo "Ref.<input type='text' name='ref_number' style='width: 150px;border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;'>";
								echo "</div>";								
								echo "<div style='clear:both;'></div>";
								echo "</div>";
								echo "<input type='hidden' name='master_id' value='".$master_data['master_data']->id."'>";

								echo '<div class="address-line">Bill No : ';
								echo '	<span class="deposit-time">';
								echo $site_detail->company_id."/OBC <input type='text' style='border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;' value='".$site_detail->next_bill_no."' name='bill_no' class='bill bill_no'>";
								echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/5.gif" style="width: 20px;display:none;" class="loadin-billfrom">';
								echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/check.png" style="width: 20px;display:none;" class="loadin-check">';
								echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/cross.png" style="width: 20px;display:none;" class="loadin-cross">';
								echo '	</span>';
								echo '<input type="hidden" class="billno_action" value="shc_obc_cheque">';
								echo '</div>';

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
								<input type="hidden" name="site_id" class="site_id" value="<?php echo $site_id; ?>">
							</div>
							<div class="address-line">Phone : <span class="site-phone"><?php echo ($site_detail) ? $site_detail->phone_number : ''; ?></span></div>
						</div>
						<div class="col-lg-12">
							Receipt Type
							<div style="margin-top: 5px;">
								<input type="radio" name="cd_notes" style="margin-top:-2px;" class="cd_notes" checked value="credit"> Credit 
								<input type="radio" name="cd_notes" style="margin-top:-2px;" class="cd_notes" value="debit"> Debit 
							</div>
						</div>
						<div class="col-lg-12">


							<div class="obc_detail" style="margin-top:20px;">
								<div class="check-block">
									<div class="row">
										<div class="col-lg-3">
											Received By <br>
											<div style="margin-top: 5px;">
												<input type="radio" name="received_by" style="margin-top:-2px;" class="received_by" checked value="cheque"> Cheque 
											</div>
											<div style="margin-top: 5px;">
												<input type="radio" name="received_by" style="margin-top:-2px;" class="received_by" value="cash"> Cash 
											</div>
											<div style="margin-top: 5px;">
												<input type="radio" name="received_by" style="margin-top:-2px;" class="received_by" value="neft"> NEFT/Other 
											</div>
										</div>
										<div class="col-lg-9">
											<div class="check-container">
												<input type="hidden" name="obc_id" value="0">
												<table class="table table-bordered">
													<tr>
														<td  style="width:150px;">Cheque No : </td>
														<td><input type="text" name="cheque_no" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" value="Chq.No "></td>
													</tr>
													<tr>
														<td>Ref :</td>
														<td>
															<input type="text" name="obc_notes" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;">
														</td>
													</tr>
													<tr>
														<td>Date : </td>
														<td><input type="text" name="cheque_date" class="datepicker" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;"></td>
													</tr>
													<tr>
														<td>Amount :</td>
														<td><input type="text" class="cheque_amt" name="cheque_amt" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;"></td>
													</tr>
													<tr>
														<td>Notes :</td>
														<td><textarea name="obc_extra_notes" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 50px;margin: 0;padding: 10px 0;"></textarea>
														</td>
													</tr>
												</table>
											</div>
										</div>
									</div>
								</div>

								<div class="rupee-txt" style="padding-bottom:15px;">
									Rupees : 
									<span class="rupee-words" style="border-bottom: 2px dotted;padding-bottom: 5px;line-height: 35px;">
										
									</span>
								</div>
							</div>

							<div style="float:right;">
	                          	<?php 
	                          		if($master_data) {
	                          			echo "<input type='hidden' name='master_id' class='master_id_input' value='".$master_data['master_data']->id."'>";
										echo "<button type='submit' class='btn btn-success create_obc'>Create Receipt</button>";
										echo "<input type='hidden' name='action' class='action' value='create_obc'>";
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

















