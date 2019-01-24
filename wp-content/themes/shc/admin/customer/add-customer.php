<?php
	$customer = false;
	$site_detail = false;
	$special_price = false;
	$companies = getCompanies();
	$bill_from_comp = false;

	if(isset($_GET['id']) && $customer = get_customer($_GET['id']) ) {
		$user_id = $_GET['id'];
		$site_detail = getSitedetail($user_id);
		$special_price = getSpecialPrice($user_id);

		$bill_from_comp = $customer->bill_from_comp;

	}

?>
<div class="container">

	<div class="row">

		<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
			<div class="x_panel">
				<div class="x_title">
					<h2>Add New Customer <small>Sessions</small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form class="form-horizontal form-label-left" id="create_customer">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Customer Name <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($customer) ? $customer->name : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mobile <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="mobile" name="mobile" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($customer) ? $customer->mobile : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Address <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea id="address" name="address" required="required" class="form-control col-md-7 col-xs-12"><?php echo ($customer) ? $customer->address : ''; ?></textarea>
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Bill From <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="bill_from_comp" style="width:100%;">
									<?php 
										if($companies) {
											foreach ($companies as $c_value) {

												$selected = ($bill_from_comp == $c_value->id) ? 'selected' : '';
												echo "<option ".$selected." value='".$c_value->id."'>".$c_value->company_name."</option>";
											}
										}
									?>
								</select>

							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="gst-number">GST Number </label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="gst_number" name="gst_number" class="form-control col-md-7 col-xs-12" value="<?php echo ($customer) ? $customer->gst_number : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="attn-name">Attn. Name </label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="attn_name" name="attn_name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($customer) ? $customer->attn_name : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer-email">Customer Email </label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="customer_email" name="customer_email" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($customer) ? $customer->customer_email : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>


						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                          	<button class="btn btn-primary" type="button">Cancel</button>
							  	<button class="btn btn-primary" type="reset">Reset</button>
	                          	<button type="submit" class="btn btn-success">Submit</button>
	                          	<?php 
									if( $customer) {
										echo '<input type="hidden" name="action" class="customer_action" value="update_customer">';
										echo '<input type="hidden" name="customer_id" value="'.$_GET['id'].'">';
									} else {
										echo '<input type="hidden" name="action" class="customer_action" value="create_customer">';
									}
								?>
	                        </div>
						</div>

					</form>
				</div>
			</div>
		</div>


						<?php
							if($customer) {
						?>
							<div class="col-lg-12">
								<div class="update_site_form">
									
									<div class="deposit-repeater site_address" style="margin-top:20px;">
										<table class="table table-bordered" data-repeater-list="site_address">
											<thead>
												<tr>
													<th class="center-th" style="width:50px;"><div>S.No</div></th>
													<th>
														<div>Site Name</div>
													</th>
													<th>
														<div>Extra Details</div>
													</th>
													<th style="width: 300px;">
														<div>GST Detail</div>
													</th>
													<th style="width:50px;">
														<div>Action</div>
													</th>
												</tr>
											</thead>
											<tbody>
											<?php if($site_detail) {
												$i = 1;
												foreach ($site_detail as $s_value) {
											?>
												<tr data-repeater-item class="repeterin div-table-row site_address" class="repeterin div-table-row" data-lotid="0" data-stockbal="0" data-reptype="site_address">
													<td>
														<div class="rowno align-txt"><?php echo $i; ?></div>
														<input type="hidden" class="site_id" name="site_id" value="<?php echo $s_value->id; ?>">
													</td>
													<td>
														<div class="align-txt customer-phone-txt">
															<input type="text" name="site_name" style="width:100%;" value="<?php echo $s_value->site_name;?>" placeholder="Site Name">
														</div>
														<div class="align-txt customer-phone-txt">
															<input type="text" name="site_phone" style="width:100%;" value="<?php echo $s_value->phone_number;?>" placeholder="Site Phone Number">
														</div>
														<textarea name="site_address" style="width:100%;height:100px;" placeholder="Site Address"><?php echo $s_value->site_address;?></textarea>
													</td>
													<td>
														<div>
															Discount : <input type="text" name="discount" value="<?php echo $s_value->discount; ?>">
														</div>
														<div style="margin-top:20px;">
															<textarea name="extra_contact" style="width:100%;min-height:120px;" placeholder="Some Name : 987654321,"><?php echo $s_value->extra_contact;?></textarea>
														</div>
														
													</td>
													<td>
														<div>
															GST Number : <input type="text" name="gst_number" placeholder="GST Number" value="<?php echo $s_value->gst_number;?>">
														</div>
														<div style="line-height: 45px;">
															GST For : <input type="radio" name="gst_for" value="cgst" style="margin-top: -2px;" <?php echo ($s_value->gst_for == 'cgst') ? 'checked' : '';?>> CGST
															<input type="radio" name="gst_for" value="igst" style="margin-top: -2px;" <?php echo ($s_value->gst_for == 'igst') ? 'checked' : '';?>> IGST
														</div>
														<div style="line-height: 45px;">
															TIN : <input type="text" name="vat_number" placeholder="VAT Number" value="<?php echo $s_value->vat_number;?>">
														</div>
													</td>
													<td>
														<div class="customer-phone-txt">
															<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
															<input type="hidden" value="Delete">
														</div>
													</td>
												</tr>
											<?php
													$i++;
												}
											} else {
											?>
												<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row" data-lotid="0" data-stockbal="0" data-reptype="site_address">

													<td>
														<div class="rowno align-txt">1</div>
														<input type="hidden" class="site_id" name="site_id" value="">
													</td>
													<td>
														<div class="align-txt customer-phone-txt">
															<input type="text" name="site_name" style="width:100%;" value="" placeholder="Site Name">
														</div>
														<div class="align-txt customer-phone-txt">
															<input type="text" name="site_phone" style="width:100%;" value="" placeholder="Site Phone Number">
														</div>
														<textarea name="site_address" style="width:100%;height:100px;" placeholder="Site Address"></textarea>
													</td>
													<td>
														<div class="align-txt customer-phone-txt">
															<div>
																Discount : <input type="text" name="discount" value="0.00">
															</div>
															<div style="margin-top:20px;">
																<textarea name="extra_contact" style="width:100%;min-height:180px;" placeholder="Some Name : 987654321,"></textarea>
															</div>
														</div>
													</td>
													<td>
														<div>
															GST Number : <input type="text" name="gst_number" placeholder="GST Number" value="">
														</div>
														<div style="line-height: 45px;">
															GST For : <input type="radio" name="gst_for" value="cgst" style="margin-top: -2px;" checked> CGST
															<input type="radio" name="gst_for" value="igst" style="margin-top: -2px;"> IGST
														</div>
														<div style="line-height: 45px;">
															VAT : <input type="text" name="vat_number" placeholder="VAT Number" value="">
														</div>
													</td>
													<td>
														<div class="customer-phone-txt">
															<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
															<input type="hidden" value="Delete">
														</div>
													</td>
												</tr>
											<?php
											} ?>


											</tbody>
										</table>

										<ul class="icons-labeled">
											<li><a data-repeater-create href="javascript:void(0);" id="add_new_price_range"><span class="icon-block-color add-c"></span>Add Site</a></li>
										</ul>
									</div>




						<?php
							if($site_detail) {
						?>
						<div class="col-lg-6">
							<input type="hidden" value="without_special_price_lot" class="lot_search_action">
							<div class="deposit-repeater special_price" style="margin-top:20px;">
								<table class="table table-bordered" data-repeater-list="special_price">
									<thead>
										<tr>
											<th rowspan="2" style="width:50px;" class="center-th"><div>S.No</div></th>
											<th rowspan="2" class="center-th" style="min-width: 200px;"><div>Description</div></th>
											<th rowspan="2" class="center-th" style="width:100px;">
												<div>Rate Per Day</div>
											</th>
											<th rowspan="2" class="center-th" style="width:100px;">
												<div>Minimum Bill Days</div>
											</th>
											<th rowspan="2" class="center-th" style="width:100px;">
												<div>Site</div>
											</th>
											<th colspan="2">
												<div>Action</div>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php
											if($special_price){
												$i = 1;
												foreach ($special_price as $sp_value) {
										?>
										<tr data-repeater-item="" class="repeterin div-table-row" data-lotid="0" data-stockbal="0" data-reptype="special_price">
											<td>
												<div class="rowno align-txt"><?php echo $i; ?></div>
												<input type="hidden" class="special_price_id" name="special_price_id" value="<?php echo $sp_value->id; ?>">
												<input type="hidden" class="lot_id_orig" name="lot_id_orig" value="<?php echo $sp_value->lot_id; ?>">
											</td>
											<td>
												<select name="lot_number" class="lot_id select2-hidden-accessible" tabindex="-1" aria-hidden="true" data-dvalue="<?php echo $sp_value->lot_id; ?>" data-dtext="" data-dname="<?php echo $sp_value->product_name; ?>" data-dtype="<?php echo $sp_value->product_type; ?>"></select>
											</td>
											<td>
												<input type="text" name="unit_price" class="unit_price" value="<?php echo $sp_value->price; ?>">
											</td>
											<td>
												<input type="text" name="minimum_bill_day_spl" class="minimum_bill_day_spl" value="<?php echo $sp_value->minimum_bill_day_spl; ?>">
											</td>
											<td>
												<select name="site_id" class="site_id">
													<option <?php echo ($sp_value->site_id == 0) ? selected : '0'; ?>>All Site</option>
													<?php 
														if($site_detail) {
															foreach ($site_detail as $d_value) {
																$selected = ($d_value->id == $sp_value->site_id) ? 'selected' : '';
																echo "<option ".$selected." value='".$d_value->id."'>".ucfirst($d_value->site_name)."</option>";
															}
														}
													?>
												</select>
											</td>
											<td>
												<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
												<input type="hidden" value="Delete">
											</td>
										</tr>
										<?php
												$i++;
												}
											} else {
										?>
										<tr data-repeater-item="" class="repeterin div-table-row" data-lotid="0" data-stockbal="0" data-reptype="special_price">
											<td>
												<div class="rowno align-txt">1</div>
												<input type="hidden" class="special_price_id" name="special_price_id" value="0">
												<input type="hidden" class="lot_id_orig" name="lot_id_orig" value="0">
											</td>
											<td>
												<select name="lot_number" class="lot_id select2-hidden-accessible" tabindex="-1" aria-hidden="true"></select>
											</td>
											<td>
												<input type="text" name="unit_price" class="unit_price" value="0.00">
											</td>
											<td>
												<input type="text" name="minimum_bill_day_spl" class="minimum_bill_day_spl" value="30">
											</td>
											<td>
												<select name="site_id" class="site_id">
													<option value="0">All Site</option>
													<?php 
														if($site_detail) {
															foreach ($site_detail as $d_value) {
																echo "<option value='".$d_value->id."'>".ucfirst($d_value->site_name)."</option>";
															}
														}
													?>
												</select>
											</td>
											<td>
												<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
												<input type="hidden" value="Delete">
											</td>
										</tr>
										<?php
											}
										?>
									</tbody>
								</table>
								<ul class="icons-labeled">
									<li><a data-repeater-create="" href="javascript:void(0);" id="add_new_price_range"><span class="icon-block-color add-c"></span>Add Price</a></li>
								</ul>
							</div>
							<div style="float:right;"></div>
						</div>

						<?php
							}
						?>




									<div style="clear:both;"></div>
									<div style="float:right;">
		                      			<input type='hidden' name='customer_id' value='<?php echo $user_id ?>'>
		                      			<input type='hidden' name='action' class='action' value='update_site'>
		                      			<button type='submit' class='btn btn-success update_site'>Update</button>
			                       	</div>
			                    </div>
							</div>

						<?php
							}
						?>



























	</div>

</div>