<?php
$stock = false;
if(isset($_GET['stock_id']) && $stock = get_stock($_GET['stock_id']) ) {
	$stock_id = $_GET['stock_id'];
}
?>
<div class="container">

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
			<div class="x_panel">
				<div class="x_title">
					<h2>Add New Lot <small>Sessions</small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form class="form-horizontal form-label-left" id="add_stock">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Lot Number <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="lot_number" id="lot_number" required="required">
									<?php
										if($stock) {
											echo "<option value='".$stock->lot_number."' selected>".$stock->lot_no."</option>";
										}
									?>
								</select>
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Count / Unit <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="number" id="stock_count" name="stock_count" required="required" min="1" class="form-control col-md-7 col-xs-12" value="<?php echo ($stock) ? $stock->stock_count : '1'; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Stock Date <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="created_at" name="created_at" required="required" min="1" class="form-control col-md-7 col-xs-12 datepicker" value="<?php echo ($stock) ? $stock->created_at : date('Y-m-d'); ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product Name <span class="required"></span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="product_name" readonly class="form-control col-md-7 col-xs-12" value="<?php echo ($stock) ? $stock->product_name : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product Type <span class="required"></span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="product_type" readonly class="form-control col-md-7 col-xs-12" value="<?php echo ($stock) ? $stock->product_type : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Unit Price <span class="required"></span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="unit_price" readonly class="form-control col-md-7 col-xs-12" value="<?php echo ($stock) ? $stock->unit_price : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                          	<button class="btn btn-primary" type="button">Cancel</button>
							  	<button class="btn btn-primary" type="reset">Reset</button>
	                          	<button type="submit" class="btn btn-success">Submit</button>

								<?php 
									if(  $stock ) {
										echo '<input type="hidden" name="stock_id" value="'.$stock_id.'">';
										echo '<input type="hidden" name="action" class="stock_action" value="update_stock">';
									} else {
										echo '<input type="hidden" name="action" class="stock_action" value="add_stock">';
									}
								?>


	                        </div>
						</div>





					</form>
				</div>
			</div>
		</div>
	</div>

</div>