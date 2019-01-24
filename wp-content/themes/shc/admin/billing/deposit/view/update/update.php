 <?php
 	$master_data = false;
	$security_data = false;
	$cheque_data = false;
	$customer_detail = false;
	$site_detail = false;
	
	$customer_id = 0;
	$site_id = 0;

	$deposit_date = date('Y-m-d');
	$deposit_time = date('H:i');



	if(isset($_GET['id'])) {
		$master_data = getMasterDetail($_GET['id']);
		$master_data = ($master_data) ? $master_data : false;

		if($master_data) {
			$customer_id = $master_data['master_data']->customer_id;
			$site_id = $master_data['master_data']->site_id;
			$customer_detail = getCustomerData($customer_id);
			$site_detail = getSiteData($site_id);	


			if(isset($_GET['deposit_id'])) {
				$security_data = getDepositDetail($_GET['deposit_id']);
				$security_data = ($security_data) ? $security_data : false;
				if($security_data) {
					$deposit_date = date('Y-m-d', strtotime($security_data['deposit_data']->deposit_date));
					$deposit_time = date('H:i', strtotime($security_data['deposit_data']->deposit_date));
				}

				$cheque_data = getDepositChequeData($_GET['deposit_id']);
				$cheque_data = ($cheque_data) ? $cheque_data : false;
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
	<?php 
		include( get_template_directory().'/admin/side-menu.php' );
	?>
		<div class="col-lg-9">
			<div class="x_panel">
				<div class="x_title">
					<h1>Security Deposit</h1>
					<div class="print_record left-right" data-action="print_deposit" data-action-from="list" data-print-id="<?php echo $_GET['deposit_id']; ?>">
						<img src="<?php echo get_template_directory_uri() ?>/admin/inc/images/printer-icon.png">
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="create_deposit">


						<div class="col-lg-6">
							<?php
								if($master_data) {
									echo "<div class='address-line'>";
									echo "<div style='float:left;width: 200px;'>";
									echo "MRI : ".$master_data['master_data']->id;
									echo "</div>";
									echo "<div style='float:left;width: 200px;'>";
									echo "Ref.<input type='text' name='ref_number' style='width: 150px;border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;' value='".$security_data['deposit_data']->ref_number."'>";
									echo "</div>";
									echo "<div style='clear:both;'></div>";
									echo "</div>";
									echo "<input type='hidden' name='master_id' value='".$master_data['master_data']->id."'>";


									if($security_data) { 
										$bill_number = billNumberText($security_data['deposit_data']->bill_from_comp, $security_data['deposit_data']->bill_no, 'SD');
										echo "<div class='address-line'>No.".$bill_number['bill_no']."</div>";
									}
								} else {
									echo "<div>";
									echo "<div class='address-line' style='float:left;'>No. MRI : <input type='text' class='master_id' name='master_id' value='".$master_data['master_data']->id."'></div>";
									echo "<button type='submit' class='btn btn-success open_deposit' style='float:left;margin-left:10px;'>Submit</button>";
									echo "<div style='clear:both;'></div></div>";
								}
							?>
							<div class="customer-name">Customer Name : M/s  
								<span class="customer-name"><?php echo ($customer_detail->name) ? $customer_detail->name : ''; ?></span>
								<input type="hidden" class="customer_id" name="customer_id" value="<?php echo $customer_id; ?>">
							</div>
							<div class="address-line">Address : <span class="address-txt"><?php echo ($customer_detail->address) ? $customer_detail->address : ''; ?></span>
							</div>
							<div class="address-line">
								Discount : <input type="radio" name="discount_avail" value="yes" style="margin-top: -2px;" <?php  echo (isset($security_data['deposit_data']) && $security_data['deposit_data']->discount_avail == 'yes')  ? 'checked' : ''; ?> > Yes &nbsp;&nbsp; <input type="radio" name="discount_avail" value="no" style="margin-top: -2px;" <?php  echo (isset($security_data['deposit_data']) && $security_data['deposit_data']->discount_avail != 'yes')  ? 'checked' : ''; ?> > No
								<input type="hidden" name="discount_yes" class="discount_yes" value="<?php  echo (isset($security_data['deposit_data']) && $security_data['deposit_data']->discount_percentage != '0.00')  ? $security_data['deposit_data']->discount_percentage : '0.00'; ?>">
								<input type="hidden" name="discount_no" class="discount_no" value="0.00">
							</div>

						</div>
						<div class="col-lg-6">
							<div class="address-line">Date : <span class="deposit-date"><input type="text" name="date" id="datepicker" class="financial_date" value="<?php echo $deposit_date; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
							
							<div class="address-line">Time : <span class="deposit-time"><input type="time" name="time" value="<?php echo $deposit_time; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
							<div class="address-line">Site : 
								<select type="text" name="delivery_site_name" class="delivery_site_name" data-dvalue='<?php echo ($site_id) ? $site_id : ""; ?>' data-sitename='<?php echo ($site_detail) ? $site_detail->site_name : ""; ?>'>
								</select>
								<input type="hidden" name="site_id" class="site_id" value="<?php echo $site_id; ?>">
							</div>
							<div class="address-line">Phone : <span class="site-phone"><?php echo ($site_detail) ? $site_detail->phone_number : ''; ?></span></div>
						</div>



						<div class="col-lg-12">
							<div class="deposit-repeater deposit_detail" style="margin-top:20px;">
								<table class="table table-bordered" data-repeater-list="deposit_detail">
									<thead>
										<tr>
											<th rowspan="2" style="width:50px;" class="center-th"><div>S.No</div></th>
											<th rowspan="2" class="center-th" style="min-width: 200px;"><div>Description</div></th>
											<th rowspan="2" class="center-th" style="width:100px;">
												<div>Qty</div>
											</th>
											<th rowspan="2" class="center-th" style="width:80px;">
												<div>Unit Price</div>
											</th>
											<th colspan="2">
												<div>Rate/30 days</div>
											</th>
											<th colspan="2">
												<div>Amount @ <input type="text" name="amt_times" class="amt_times" value="<?php echo (isset($security_data['deposit_data']->amt_times)) ? $security_data['deposit_data']->amt_times : 3; ?>" style="width: 25px;height: 20px;"> Times</div>
											</th>
											<th colspan="2">
												<div>Action</div>
											</th>
										</tr>
										<tr>
											<th style="width:120px;">Rs.</th>
											<th style="width:40px;">Ps.</th>
											<th style="width:120px;">Rs.</th>
											<th style="width:40px;">Ps.</th>
											<th style="width:40px;">Pay</th>
											<th style="width:40px;">Delete</th>
										</tr>
									</thead>
									<tbody>
									<?php
										if($security_data['deposit_detail']) {
											$i = 1;
											foreach ($security_data['deposit_detail'] as $key => $d_value) {
												$data_thirty = splitCurrency($d_value->rate_thirty);
												$data_ninety = splitCurrency($d_value->rate_ninety);
									?>
										<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row" data-lotid="0" data-stockbal="0">
											<td>
												<div class="rowno align-txt"><?php echo $i; ?></div>
												<input type="hidden" class="sale_detail_id" name="sale_detail_id" value="<?php echo $d_value->id; ?>">
												<input type="hidden" class="lot_id_orig" name="lot_id_orig" value="<?php echo $d_value->lot_id; ?>">
											</td>
											<td>
												<select name="lot_number" class="lot_id" tabindex="-1" aria-hidden="true" data-dvalue="<?php echo $d_value->id; ?>" data-dtext="<?php echo $d_value->lot_no; ?>" data-dname="<?php echo $d_value->product_name; ?>" data-dtype="<?php echo $d_value->product_type; ?>"></select>
											</td>
											<td>
												<input type="text" name="qty" style="border-color: rgba(118, 118, 118, 0);width:80px;height:34px;margin:0;" class="dpt_qty" value="<?php echo $d_value->qty; ?>">
											</td>
											<td>
												<div class="align-txt unit_price_txt"><?php echo $d_value->unit_price; ?></div>
												<input type="hidden" name="minimum_bill_day" value="<?php echo $d_value->minimum_bill_day; ?>" class="minimum_bill_day_spl">
												<input type="hidden" name="unit_price" class="unit_price" value="<?php echo $d_value->unit_price; ?>">
											</td>
											<td>
												<div class="align-txt t_rs_txt"><?php echo $data_thirty['rs']; ?></div>
												<input type="hidden" name="thirty_rs_price" value="<?php echo $d_value->rate_thirty; ?>" class="thirty_rs_price">
											</td>
											<td>
												<div class="align-txt t_ps_txt"><?php echo $data_thirty['ps']; ?></div>
											</td>
											<td>
												<div class="align-txt n_rs_txt"><?php echo $data_ninety['rs']; ?></div>
												<input type="hidden" name="ninety_rs_price" value="<?php echo $d_value->rate_ninety; ?>" class="ninety_rs_price">
											</td>
											<td>
												<div class="align-txt n_ps_txt"><?php echo $data_ninety['ps']; ?></div>
											</td>
											<td>
												<div class="align-txt">
													<input type="checkbox" style="margin-top: -5px;">
												</div>
											</td>
											<td>
												<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
												<input type="hidden" value="Delete">
											</td>
										</tr>
									<?php
												$i++;
											}
										} 
									?>
									</tbody>
											<?php
												$thirty_total = ($security_data && $security_data['deposit_data']->total_thirty_days) ? $security_data['deposit_data']->total_thirty_days : 0.00;
												$thirty_total_data = splitCurrency($thirty_total);

												$ninety_total = ($security_data && $security_data['deposit_data']->total_ninety_days) ? $security_data['deposit_data']->total_ninety_days : 0.00;
												$ninety_total_data = splitCurrency($ninety_total);

												$discount_amt = (isset( $security_data['deposit_data'] ) && $security_data['deposit_data']->discount_amt) ? $security_data['deposit_data']->discount_amt : 0.00;
												$discount_total_data = splitCurrency($discount_amt);

												$total_amt = (isset( $security_data['deposit_data'] ) && $security_data['deposit_data']->total) ? $security_data['deposit_data']->total : 0.00;
												$total_data = splitCurrency($total_amt);

											?>
									<tfooter>
										<tr>
											<td colspan="4" style="text-align:center"><b>Actual Total </b></td>
											<td class="minimum_pay_td">
												<div class="align-txt t_rs_tot_txt"><?php echo $thirty_total_data['rs']  ?></div>
												<input type="hidden" class="total_thirty_days" value="<?php  echo $thirty_total; ?>" name="for_thirty_days">
											</td>
											<td>
												<div class="align-txt t_ps_tot_txt"><?php echo $thirty_total_data['ps']  ?></div>
											</td>
											<td class="deposit_tot_td">
												<div class="align-txt n_rs_tot_txt"><?php echo $ninety_total_data['rs']  ?></div>
												<input type="hidden" class="total_ninety_days" value="<?php  echo $ninety_total; ?>" name="for_ninety_days">
											</td>
											<td>
												<div class="align-txt n_ps_tot_txt"><?php echo $ninety_total_data['ps']  ?></div>
											</td>
											<td colspan="2"></td>
										</tr>
										<tr>
											<td colspan="6" style="text-align:center">
												<div>
													<b>Discount % </b>
													<input type="text" name="discount_percentage" class="discount_percentage_deposit" value="<?php  echo (isset($security_data['deposit_data']) && $security_data['deposit_data']->discount_percentage != '0.00')  ? $security_data['deposit_data']->discount_percentage : '0.00'; ?>" style="width:45px;" <?php  echo (isset($security_data['deposit_data']) && $security_data['deposit_data']->discount_avail != 'yes')  ? 'readonly=readonly' : ''; ?> >
												</div>
											</td>
											<td class="deposit_tot_td">
												<div class="align-txt rs_discount_txt"><?php echo $discount_total_data['rs']  ?></div>
												<input type="hidden" class="discount_amt" value="<?php  echo (isset($security_data['deposit_data']) && $security_data['deposit_data']->discount_amt != '0.00')  ? $security_data['deposit_data']->discount_amt : '0.00'; ?>" name="discount_amt">
											</td>
											<td>
												<div class="align-txt p_discount_txt"><?php echo $discount_total_data['ps']  ?></div>
											</td>
											<td colspan="2"></td>
										</tr>
										<tr>
											<td colspan="6" style="text-align:center">
												<div>
													<b>Total </b>
												</div>
											</td>
											<td class="deposit_tot_td">
												<div class="align-txt rs_tot_txt"><?php echo $total_data['rs']  ?></div>
												<input type="hidden" class="total" value="<?php  echo (isset($security_data['deposit_data']) && $security_data['deposit_data']->total != '0.00')  ? $security_data['deposit_data']->total : '0.00'; ?>" name="total">
											</td>
											<td>
												<div class="align-txt ps_tot_txt"><?php echo $total_data['ps']  ?></div>
											</td>
											<td colspan="2"></td>
										</tr>


									<tfooter>
								</table>

								<ul class="icons-labeled">
									<li><a data-repeater-create href="javascript:void(0);" id="add_new_price_range"><span class="icon-block-color add-c"></span>Add Product</a></li>
								</ul>
							</div>




							<div class="row">
								<div class="col-lg-6">

									<div style="height:50px;padding-bottom:15px;">
										
									</div>


									<div class="check-block">
										<div class="row">
											<div class="col-lg-3">
												Loading Charges 
											</div>
											<div class="col-lg-9">
												<div class="check-container">
													<input type="hidden" name="cheque_detail[0][cheque_detail_id]" value="0">
													<table class="table table-bordered">
														<tbody>
															<tr>
																<td style="width:150px;">Loading : </td>
																<td>
																	<input type="text" name="loading" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" class="deposit-charge-input loading" value="<?php echo getLoadingData($_GET['deposit_id'], 'loading') ?>">
																</td>
															</tr>
															<tr>
																<td>Transport : </td>
																<td>
																	<input type="text" name="transportation" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" class="deposit-charge-input transportation" value="<?php echo getLoadingData($_GET['deposit_id'], 'transportation') ?>">
																</td>
															</tr>
															<tr>
																<td>Total :</td>
																<td>
																	<input type="text" name="loading_total" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" class="deposit-charge-input loading_total" value="<?php echo getLoadingData($_GET['deposit_id'], 'total') ?>">
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="rupee-txt" style="padding-bottom:15px;">
										Rupees : 
										<span class="rupee-words" style="border-bottom: 2px dotted;padding-bottom: 5px;line-height: 35px;">
											<?php 
												if(isset($security_data['deposit_data']->total_ninety_days)) {
													echo ucfirst( convert_number_to_words_full($security_data['deposit_data']->total_ninety_days) );
												} else {
													echo "0";
												}

											?>
										</span>
									</div>
									<div class="check-block">
										<div class="row">
											<div class="col-lg-3">
												Received By <br>
												Chash / Cheque
											</div>
											<div class="col-lg-9">
												<?php
												if($cheque_data && $cheque_data['cheque_data']) {
													foreach ($cheque_data['cheque_data'] as $cd_value) {
												?>
													<div class="check-container">
														<input type="hidden" name="cheque_detail[0][cheque_detail_id]" value="<?php echo $cd_value->id ?>">
														<table class="table table-bordered">
															<tr>
																<td  style="width:150px;">Cheque No : </td>
																<td><input type="text" name="cheque_detail[0][cheque_no]" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" value="<?php echo $cd_value->cheque_no ?>"></td>
															</tr>
															<tr>
																<td>Date : </td>
																<td><input type="text" name="cheque_detail[0][cheque_date]" class="datepicker" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" value="<?php echo $cd_value->cheque_date ?>"></td>
															</tr>
															<tr>
																<td>Amount Rs. :</td>
																<td><input type="text" name="cheque_detail[0][cheque_amt]" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" value="<?php echo $cd_value->cheque_amount ?>"></td>
															</tr>
														</table>
													</div>
												<?php
													}
												} else {
												?>
													<div class="check-container">
														<input type="hidden" name="cheque_detail[0][cheque_detail_id]" value="0">
														<table class="table table-bordered">
															<tr>
																<td  style="width:150px;">Cheque No : </td>
																<td><input type="text" name="cheque_detail[0][cheque_no]" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;"></td>
															</tr>
															<tr>
																<td>Date : </td>
																<td><input type="text" name="cheque_detail[0][cheque_date]" class="datepicker" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;"></td>
															</tr>
															<tr>
																<td>Amount Rs. :</td>
																<td><input type="text" name="cheque_detail[0][cheque_amt]" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;"></td>
															</tr>
														</table>
													</div>
												<?php
												}
												?>

											</div>
										</div>
									</div>
								</div>

								<div class="col-lg-12">
									<div style="float:right;">
			                          	<?php 
			                          		if($security_data) {
			                          			echo "<input type='hidden' name='deposit_id' value='".$security_data['deposit_data']->id."'>";
			                          			echo "<input type='hidden' name='action' class='action' value='update_deposit'>";
			                          			echo "<button type='submit' class='btn btn-success create_deposit'>Update</button>";
			                          		} else {
			                          			echo "<input type='hidden' name='action' class='action' value='create_deposit'>";
			                          			echo "<button type='submit' class='btn btn-success create_deposit'>Submit</button>";
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
	</div>

</div>