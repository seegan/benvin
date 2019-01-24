<?php
	$settings = new Settings();
	$bank_detail = $settings->getBankData();
?>
<div class="container">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
			<div class="x_panel">
				<div class="x_title">
					<h2>Bank Details</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form class="form-horizontal form-label-left" id="create_bank">
						<div class="settings-repeater bank_data" style="margin-top:20px;">
							<table class="table table-bordered" data-repeater-list="bank_data">
								<thead>
									<tr>
										<th class="center-th" style="width:50px;"><div>S.No</div></th>
										<th>
											<div>Bank Details</div>
										</th>
										<th>
											<div>Action</div>
										</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										if($bank_detail && count($bank_detail) > 0) {
											$count = 1;
											foreach ($bank_detail as $b_value) {
									?>
									<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row">
										<td>
											<div class="rowno align-txt"><?php echo $count; ?></div>
											<input type="hidden" class="bank_id" name="bank_id" value="<?php echo $b_value->id; ?>">
										</td>
										<td>
											<div class="align-txt">
												<input type="text" name="bank_name" style="width:100%;" value="<?php echo $b_value->bank_name; ?>" placeholder="Bank Name">
											</div>
											<div class="align-txt">
												<select name="bill_from_comp" style="width:100%;margin-bottom: 5px;">
													<option selected="" value="1" <?php echo ($b_value->company_id == 1) ? 'selected' : ''; ?>>Benvin Associates</option>
													<option value="2" <?php echo ($b_value->company_id == 2) ? 'selected' : ''; ?>>JVB Associates</option>
													<option value="3" <?php echo ($b_value->company_id == 3) ? 'selected' : ''; ?>>JBC Associates</option>
												</select>
											</div>
											<textarea name="account_details" class="bankDetailEditor" style="width:100%;height:100px;" placeholder="Account Details"><?php echo $b_value->bank_detail; ?></textarea>
										</td>
										<td>
											<div class="">
												<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
												<input type="hidden" value="Delete">
											</div>
										</td>
									</tr>
									<?php
												$count++;
											}
										} else {
									?>
									<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row">
										<td>
											<div class="rowno align-txt">1</div>
											<input type="hidden" class="bank_id" name="bank_id" value="">
										</td>
										<td>
											<div class="align-txt">
												<input type="text" name="bank_name" style="width:100%;" value="" placeholder="Bank Name">
											</div>
											<div class="align-txt">
												<select name="bill_from_comp" style="width:100%;margin-bottom: 5px;">
													<option selected="" value="1">Benvin Associates</option>
													<option value="2">JVB Associates</option>
													<option value="3">JBC Associates</option>
												</select>
											</div>
											<textarea name="account_details" class="bankDetailEditor" style="width:100%;height:100px;" placeholder="Account Details"></textarea>
										</td>
										<td>
											<div class="">
												<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
												<input type="hidden" value="Delete">
											</div>
										</td>
									</tr>
									<?php
										}

									?>
								</tbody>
							</table>

							<ul class="icons-labeled">
								<li><a data-repeater-create href="javascript:void(0);" id="add_new_price_range"><span class="icon-block-color add-c"></span>Add Bank</a></li>
							</ul>
						</div>



						<div class="divider-dashed"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                          	<button class="btn btn-primary" type="button">Cancel</button>
							  	<button class="btn btn-primary" type="reset">Reset</button>
	                          	<button type="submit" class="btn btn-success">Update</button>
	                          	<input type="hidden" name="action" class="bank_action" value="update_bank">
	                        </div>
						</div>

					</form>
				</div>
			</div>
		</div>





	</div>
</div>