<?php
	$master_data = false;
	$customer_detail = false;
	$site_detail = false;

	$pending_items = false;
	
	$customer_id = '';
	$site_id = '';

	$return_date = (isset($_GET['return_date'])) ? $_GET['return_date'] : date('Y-m-d');
	$delivery_time = date('H:i');

	if(isset($_GET['id'])) {
		$master_data = getMasterDetail($_GET['id']);
		$master_data = ($master_data) ? $master_data : false;

		if($master_data['master_data']) {
			$customer_id = $master_data['master_data']->customer_id;
			$site_id = $master_data['master_data']->site_id;

			$customer_detail = getCustomerData($customer_id);
			$site_detail = getSiteData($site_id, $bill_for = 'shc_return', $return_date);

			$pending_items = getPendingItems($_GET['id'], $return_date);
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
					<h2>Items Return</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="create_return">


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
								echo $site_detail->company_id."/MRR <input type='text' style='border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;' value='".$site_detail->next_bill_no."' name='bill_no' class='bill bill_no'>";
								echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/5.gif" style="width: 20px;display:none;" class="loadin-billfrom">';
								echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/check.png" style="width: 20px;display:none;" class="loadin-check">';
								echo '<img src="'.get_template_directory_uri() . '/admin/inc/images/cross.png" style="width: 20px;display:none;" class="loadin-cross">';
								echo '	</span>';
								echo '<input type="hidden" class="billno_action" value="shc_return">';
								echo '</div>';

							}
							?>
							<div class="customer-name">Customer Name : M/s <?php echo ($customer_detail->name) ? $customer_detail->name : ''; ?>
								<span class="customer-name"></span>
							</div>
							<div class="address-line">Address : <span class="address-txt"><?php echo ($customer_detail->address) ? $customer_detail->address : ''; ?></span>
							</div>
							<div class="return_lost">
								<input type="radio" name="return_status" class="return_status" value="return" style="margin: -2px 0 0;" checked><span> Return </span> &nbsp;&nbsp;
								<input type="radio" name="return_status" class="return_status" value="lost" style="margin: -2px 0 0;"> <span> Lost </span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="address-line">Date : <span class="deposit-date"><input type="text" name="date" id="datepicker" value="<?php echo $return_date; ?>" class="return_date financial_date" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
							<div class="address-line">Time : <span class="deposit-time"><input type="time" name="time" value="<?php echo $delivery_time; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
							<div class="address-line">Site : 
								<select type="text" name="delivery_site_name" class="delivery_site_name" data-dvalue="<?php echo ($site_detail) ? $site_detail->id : ''; ?>"  data-sitename="<?php echo ($site_detail) ? $site_detail->site_name : ''; ?>">
								</select>
								<input type="hidden" name="site_id" class="site_id" value="<?php echo $site_id; ?>">
							</div>
							<div class="address-line">Phone : <span class="site-phone"><?php echo ($site_detail) ? $site_detail->phone_number : ''; ?></span></div>
						</div>




						<div class="col-lg-12">
							<div class="deposit-repeater return_detail_group" style="margin-top:20px;">
								<table class="table table-bordered" data-repeater-list="return_detail_group">
									<thead>
										<tr>
											<th rowspan="2" style="width:50px;" class="center-th"><div>S.No</div></th>
											<th rowspan="2" colspan="3" class="center-th" style="min-width: 200px;">
												<div>Description</div></th>
											<th colspan="3" class="center-th" style="width:80px;">
												<div>Qty</div>
											</th>
											<th colspan="2" class="center-th show_lost" style="display: none;">
												<div>
													Lost Cost
												</div>
											</th>
										</tr>
										<tr>
											<td style="width:20px;">Taken</td>
											<td style="width:20px;">In Hand</td>
											<td style="width:20px;">
												<span class="show_return">Return</span>
												<span class="show_lost" style="display: none;">Lost</span>
											</td>
											<td style="display: none;" class="show_lost">
												<span>Per Unit</span>
											</td>	
											<td style="display: none;" class="show_lost">
												<span>Total</span>
											</td>										
										</tr>
									</thead>
									<tbody class="return-group">
									<?php


										if($pending_items && isset($pending_items['grouping_detail']) && count($pending_items['grouping_detail']) > 0) {
											$i = 1;
											foreach ($pending_items['grouping_detail'] as $g_value) {
									?>
										<tr class="div-table-row" class="repeterin div-table-row" data-repeater-item>
											<td>
												<div class="rowno align-txt"><?php echo $i; ?></div>
											</td>
											<td colspan="3">
												<div class="align-txt">
													<div>
														<div style="float: left;width:400px;">
															<span><?php echo $g_value->product_name ?></span> 
															<span><?php echo $g_value->product_type ?></span> 
														</div>
														<div style="float: left;">
															<span><?php echo $g_value->lot_no ?></span> 
														</div>
														<div style="clear:both"></div>
														
													</div>

													
													<input type="hidden" name="lot_id" value="<?php echo $g_value->lot_id ?>">
												</div>
											</td>
											<td>
												<div class="align-txt">
													<span><?php echo $g_value->qty; ?></span>
												</div>
											</td>
											<td>
												<div class="align-txt">
													<input type="hidden" class="in_hand" value="<?php echo $g_value->return_pending; ?>">
													<span><?php echo $g_value->return_pending; ?></span>
												</div>
											</td>
											<td>
												<div class="align-txt">
													<input type="text" style="border-color: rgba(118, 118, 118, 0);height:34px;margin:0;" class="return_qty" value="0" data-lotid="<?php echo $g_value->lot_id ?>" name="lost_qty">
												</div>
											</td>
											<td class="show_lost" style="display: none;width:75px;">
												<div class="align-txt">
													<input type="text" name="lost_per_unit" class="lost_per_unit" value="<?php echo $g_value->buying_price; ?>" style="border-color: rgba(118, 118, 118, 0);height:34px;margin:0;width:75px;">
												</div>
											</td>
											<td class="show_lost" style="display: none;">
												<div class="align-txt lost_row_total_txt">0</div>
												<input type="hidden" name="lost_row_total" value="0" class="lost_row_total">
											</td>
										</tr>
									<?php
												$i++;
											}
										} else {
									?>
										<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row">
											<td colspan="7">
												<center>No Pending Items</center>
											</td>
										</tr>
									<?php
										}

										//echo (getUnloadingData('unloading'));
									?>
										<tr class="show_row_return">
											<td colspan="2">
												<div class="align-txt">
													<div style="float:left;width:150px;line-height: 15px;">Vehicle Number : </div>
													<div><input type="text" class="vehicle_number" style="border: 0;border-bottom: 2px dotted;padding: 0"></div>
												</div>
											</td>
											<td colspan="2" style=""><div class="align-txt"><div class="return-charge-txt">Unloading</div></div></td>
											<td colspan="3"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text"  class="return-charge-input unloading"></div></div></td>
										</tr>
										<tr class="show_row_return">
											<td colspan="2">
												<div class="align-txt">
													<div style="float:left;width:150px;line-height: 15px;">Driver Name : </div>
													<div><input type="text" class="driver_name" style="border: 0;border-bottom: 2px dotted;padding: 0"></div>
												</div>
											</td>
											<td colspan="2" style=""><div class="align-txt"><div class="return-charge-txt">Transportation</div></div></td>
											<td colspan="3"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text"  class="return-charge-input transportation"></div></div></td>
										</tr>
										<tr class="show_row_return">
											<td colspan="2">
												<div class="align-txt">
													<div style="float:left;width:150px;line-height: 15px;">Mobile Number : </div>
													<div><input type="text" class="driver_mobile" style="border: 0;border-bottom: 2px dotted;padding: 0"></div>
												</div>
											</td>
											<td colspan="2" style=""><div class="align-txt"><div class="return-charge-txt">Damage (as Per detail overleaf)</div></div></td>
											<td colspan="3"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text"  class="return-charge-input damage"></div></div></td>
										</tr>
										<tr class="show_row_return">
											<td colspan="2"><div class="align-txt"></div></td>
											<td colspan="2" style="">
												<div class="align-txt"><div class="return-charge-txt">Total</div></div>
											</td>
											<td colspan="3"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text"  class="return-charge-input total"></div></div></td>
										</tr>
										<tr class="show_row_lost" style="display: none;">
											<td colspan="6" style="">
												<div class="align-txt">
													<div class="return-charge-txt">Total</div>
												</div>
											</td>
											<td>
												<div class="align-txt">
													<div class="return-charge-val">
														<span class="lost_qty_total_txt">0</span>
														<input type="hidden" name="lost_qty_total" class="lost_qty_total" value="0">
													</div>
												</div>
											</td>
											<td colspan="2">
												<div class="align-txt">
													<div class="return-charge-val">Rs.
														<span class="lost_total_txt">0</span> 
														<input type="hidden" name="lost_cost" class="lost_total" value="0">
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>


							<div style="float:right;">
	                          	<?php 
	                          		if($master_data) {
	                          			echo "<input type='hidden' name='master_id' class='master_id_input' value='".$master_data['master_data']->id."'>";
										echo "<button type='submit' class='btn btn-success create_return'>Update Return</button>";

	                          			if(isset($return_data['return_data']) && $return_data['return_data']) {
	                          				echo "<input type='hidden' name='return_id' value='".$return_data['return_data']->id."'>";
	                          				echo "<input type='hidden' name='action' class='action' value='update_return'>";
	                          			} else {
	                          				echo "<input type='hidden' name='action' class='action' value='new_return'>";
	                          			}
	                          		}
	                          	?>
	                       	</div>
	                       	<button class="show_hide_btn" style="float:left;">Show / Hide Detail</button>


						</div>



						
						<div class="col-lg-12 show_hide_slide" style="display:none;">
							

							<div class="deposit-repeater return_detail" style="margin-top:20px;">
								<table class="table table-bordered" data-repeater-list="return_detail">
									<thead>
										<tr>
											<th rowspan="2" style="width:50px;" class="center-th"><div>S.No</div></th>
											<th rowspan="2" colspan="3" class="center-th" style="min-width: 200px;"><div>Description</div></th>
											<th rowspan="2" class="center-th" style="width: 100px;"><div>Delivery Taken</div></th>
											<th colspan="3" class="center-th" style="width:80px;">
												<div>Qty</div>
											</th>
										</tr>
										<tr>
											<td style="width:20px;">Taken</td>
											<td style="width:20px;">In Hand</td>
											<td style="width:20px;">Return</td>
										</tr>
									</thead>
									<tbody class="return-detail">
									<?php
										if($pending_items && isset($pending_items['pending_detail']) && count($pending_items['pending_detail']) > 0) {
											$i = 1;
											foreach ($pending_items['pending_detail'] as $p_value) {
									?>
										<tr class="div-table-row" data-repeater-item class="repeterin div-table-row" >
											<td>
												<div class="rowno align-txt"><?php echo $i; ?></div>
												<input type="hidden" class="delivery_detail_id" name="delivery_detail_id" value="<?php echo $p_value->id; ?>">
											</td>
											<td colspan="3">
												<div class="align-txt">
													<span><?php echo $p_value->product_name ?></span>
													<span><?php echo $p_value->product_type ?></span>
													<input type="hidden" name="lot_id" value="<?php echo $p_value->lot_id ?>">
												</div>
											</td>
											<td>
												<div class="align-txt">
													<span><?php echo $p_value->delivery_date ?></span>
												</div>
											</td>
											<td>
												<div class="align-txt">
													<span><?php echo $p_value->qty; ?></span>
												</div>
											</td>
											<td>
												<div class="align-txt">
													<input type="hidden" class="in_hand_group" value="<?php echo $p_value->return_pending; ?>">
													<span><?php echo $p_value->return_pending; ?></span>
												</div>
											</td>
											<td>
												<div class="align-txt">
													<input type="text" name="qty" style="border-color: rgba(118, 118, 118, 0);height:34px;margin:0;" class="return_qty return_group_qty_<?php echo $p_value->lot_id ?>" value="0" >
												</div>
											</td>
										</tr>
									<?php
												$i++;
											}
										} else {
									?>
										<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row">
											<td colspan="6">
												<center>No Pending Items</center>
											</td>
										</tr>
									<?php
										}

										//echo (getUnloadingData('unloading'));
									?>
										<tr>
											<td colspan="3">
												<div class="align-txt">
													<div style="float:left;width:150px;line-height: 15px;">Vehicle Number : </div>
													<div><input type="text" class="group_vehicle_number" name="vehicle_number" style="border: 0;border-bottom: 2px dotted;padding: 0;"></div>
												</div>
											</td>
											<td colspan="2" style="width:300px;">
												<div class="align-txt"><div class="return-charge-txt">Unloading</div></div>
											</td>
											<td colspan="3">
												<div class="align-txt"><div class="return-charge-val">Rs. <input type="text" name="unloading" class="return-charge-input group_unloading"></div></div>
											</td>
										</tr>
										<tr>
											<td colspan="3">
												<div class="align-txt">
													<div style="float:left;width:150px;line-height: 15px;">Driver Name : </div>
													<div><input type="text" class="group_driver_name" name="driver_name" style="border: 0;border-bottom: 2px dotted;padding: 0;"></div>
												</div>
											</td>
											<td colspan="2" style="width:300px;"><div class="align-txt"><div class="return-charge-txt">Transportation</div></div></td>
											<td colspan="3"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text" name="transportation" class="return-charge-input group_transportation"></div></div></td>
										</tr>
										<tr>
											<td colspan="3">
												<div class="align-txt">
													<div style="float:left;width:150px;line-height: 15px;">Mobile Number : </div>
													<div><input type="text" class="group_driver_mobile" name="driver_mobile" style="border: 0;border-bottom: 2px dotted;padding: 0;"></div>
												</div>
											</td>
											<td colspan="2" style="width:300px;"><div class="align-txt"><div class="return-charge-txt">Damage (as Per detail overleaf)</div></div></td>
											<td colspan="3"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text" name="damage" class="return-charge-input group_damage"></div></div></td>
										</tr>
										<tr>
											<td colspan="3"></td>
											<td colspan="2"><div class="align-txt"><div class="return-charge-txt">Total</div></div></td>
											<td colspan="3"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text" name="total" class="return-charge-input group_total"></div></div></td>
										</tr>
									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>