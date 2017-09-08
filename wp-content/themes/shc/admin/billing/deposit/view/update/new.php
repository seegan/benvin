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
			$site_detail = getSiteData($site_id, $bill_for = 'shc_deposit', $deposit_date);
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
					<h2><small>List</small></h2>
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
					<h2>Security Deposit</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="create_deposit">


						<div class="col-lg-6">
							<?php
								if($master_data) {
									echo "<div class='address-line'>MRI : ".$master_data['master_data']->id."</div>";
									echo "<input type='hidden' name='master_id' value='".$master_data['master_data']->id."'>";


									echo '<div class="address-line">Bill No : ';
									echo '	<span class="deposit-time">';
									echo $site_detail->company_id."/SD <input type='text' style='border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;' value='".$site_detail->next_bill_no."' name='bill_no' class='bill bill_no'>";
									echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/5.gif" style="width: 20px;display:none;" class="loadin-billfrom">';
									echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/check.png" style="width: 20px;display:none;" class="loadin-check">';
									echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/cross.png" style="width: 20px;display:none;" class="loadin-cross">';
									echo '	</span>';
									echo '<input type="hidden" class="billno_action" value="shc_deposit">';
									echo '</div>';

								}
							?>


							<div class="customer-name">Customer Name : M/s  
								<span class="customer-name"><?php echo ($customer_detail->name) ? $customer_detail->name : ''; ?></span>
								<input type="hidden" class="customer_id" name="customer_id" value="<?php echo $customer_id; ?>">
							</div>
							<div class="address-line">Address : <span class="address-txt"><?php echo ($customer_detail->address) ? $customer_detail->address : ''; ?></span>
							</div>
							<div class="address-line">
								Discount : <input type="radio" name="discount_avail" value="yes" style="margin-top: -2px;"> Yes &nbsp;&nbsp; <input type="radio" name="discount_avail" value="no" style="margin-top: -2px;" checked> No
								<input type="hidden" name="discount_yes" class="discount_yes" value="<?php echo $site_detail->discount; ?>">
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
												<div>Amount @ <input type="text" name="amt_times" class="amt_times" value="3" style="width: 25px;height: 20px;"> Times</div>
											</th>
											<th rowspan="2">
												<div>Action</div>
											</th>
										</tr>
										<tr>
											<th style="width:120px;">Rs.</th>
											<th style="width:40px;">Ps.</th>
											<th style="width:120px;">Rs.</th>
											<th style="width:40px;">Ps.</th>
										</tr>
									</thead>
									<tbody>

										<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row" data-lotid="0" data-stockbal="0">
											<td>
												<div class="rowno align-txt">1</div>
												<input type="hidden" class="sale_detail_id" name="sale_detail_id" value="0">
												<input type="hidden" class="lot_id_orig" name="lot_id_orig" value="0">
											</td>
											<td>
												<select name="lot_number" class="lot_id" tabindex="-1" aria-hidden="true"></select>
											</td>
											<td>
												<input type="text" name="qty" value="1" style="border-color: rgba(118, 118, 118, 0);width:80px;height:34px;margin:0;" class="dpt_qty">
											</td>
											<td>
												<div class="align-txt unit_price_txt">0.00</div>
												<input type="hidden" name="unit_price" class="unit_price" value="0.00">
											</td>
											<td>
												<div class="align-txt t_rs_txt">0</div>
												<input type="hidden" name="thirty_rs_price" value="0.00" class="thirty_rs_price">
											</td>
											<td>
												<div class="align-txt t_ps_txt">00</div>
											</td>
											<td>
												<div class="align-txt n_rs_txt">0</div>
												<input type="hidden" name="ninety_rs_price" value="0.00" class="ninety_rs_price">
											</td>
											<td>
												<div class="align-txt n_ps_txt">00</div>
											</td>
											<td>
												<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
												<input type="hidden" value="Delete">
											</td>
										</tr>
									</tbody>
									<tfooter>
										<tr>
											<td colspan="4" style="text-align:center"><b>Actual Total </b></td>
											<td class="minimum_pay_td">
												<div class="align-txt t_rs_tot_txt">0</div>
												<input type="hidden" class="total_thirty_days" value="0.00" name="for_thirty_days">
											</td>
											<td>
												<div class="align-txt t_ps_tot_txt">00</div>
											</td>
											<td class="deposit_tot_td">
												<div class="align-txt n_rs_tot_txt">0</div>
												<input type="hidden" class="total_ninety_days" value="0.00" name="for_ninety_days">
											</td>
											<td>
												<div class="align-txt n_ps_tot_txt">00</div>
											</td>
											<td colspan="2"></td>
										</tr>
										<tr>
											<td colspan="6" style="text-align:center">
												<div>
													<b>Discount % </b>
													<input type="text" name="discount_percentage" class="discount_percentage_deposit" value="0.00" style="width:45px;" readonly="readonly">
												</div>
											</td>
											<td class="deposit_tot_td">
												<div class="align-txt rs_discount_txt">0</div>
												<input type="hidden" class="discount_amt" value="0.00" name="discount_amt">
											</td>
											<td>
												<div class="align-txt p_discount_txt">00</div>
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
												<div class="align-txt rs_tot_txt">0</div>
												<input type="hidden" class="total" value="0.00" name="total">
											</td>
											<td>
												<div class="align-txt ps_tot_txt">00</div>
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
																	<input type="text" name="loading" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" class="deposit-charge-input loading" value="0.00">
																</td>
															</tr>
															<tr>
																<td>Transport : </td>
																<td>
																	<input type="text" name="transportation" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" class="deposit-charge-input transportation" value="0.00">
																</td>
															</tr>
															<tr>
																<td>Total :</td>
																<td>
																	<input type="text" name="loading_total" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" class="deposit-charge-input loading_total" value="0.00">
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
										</span>
									</div>
									<div class="check-block">
										<div class="row">
											<div class="col-lg-3">
												Received By <br>
												Chash / Cheque
											</div>
											<div class="col-lg-9">
												<div class="check-container">
													<input type="hidden" name="cheque_detail[0][cheque_detail_id]" value="0">
													<table class="table table-bordered">
														<tr>
															<td  style="width:150px;">Cheque No : </td>
															<td><input type="text" name="cheque_detail[0][cheque_no]" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" value="0.00"></td>
														</tr>
														<tr>
															<td>Date : </td>
															<td><input type="text" name="cheque_detail[0][cheque_date]" class="datepicker" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" value="0.00"></td>
														</tr>
														<tr>
															<td>Amount Rs. :</td>
															<td><input type="text" name="cheque_detail[0][cheque_amt]" style="border-color: rgba(118, 118, 118, 0);width: 100%;height: 25px;margin: 0;padding: 0;" value="0.00"></td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-lg-12">
									<div style="float:right;">
	                          			<input type='hidden' name='action' class='action' value='create_deposit'>
	                          			<button type='submit' class='btn btn-success create_deposit'>Submit</button>
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