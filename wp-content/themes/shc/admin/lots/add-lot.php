<?php
$lot = false;
if(isset($_GET['id']) && $lot = get_lot($_GET['id']) ) {
	$lot_id = $_GET['id'];
}
?>
<div class="container">

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
			<div class="x_panel">
				<div class="x_title">
				<?php 
					if($lot_id) {
						echo "<h2>Update Product</h2>";
					} else {
						echo "<h2>New Product</h2>";
					}
				?>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form class="form-horizontal form-label-left" id="create_lot">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Lot Number <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="lot_no" name="lot_no" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($lot) ? $lot->lot_no : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product Name <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="product_name" name="product_name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($lot) ? $lot->product_name : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product Type <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="product_type" name="product_type" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($lot) ? $lot->product_type : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Rate Per Day <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="unit_price" name="unit_price" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($lot) ? $lot->unit_price : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Buying Price<span class="required"></span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="buying_price" name="buying_price" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($lot) ? $lot->buying_price : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Weight (in kg per unit)<span class="required"></span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="weight" name="weight" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($lot) ? $lot->weight : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Minimum Bill Days<span class="required"></span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="minimum_bill_day" name="minimum_bill_day" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($lot) ? $lot->minimum_bill_day : 30; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<input type="hidden" id="tax1" name="tax1" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($lot) ? $lot->tax1 : 0; ?>">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                          	<button class="btn btn-primary" type="button">Cancel</button>
							  	<button class="btn btn-primary" type="reset">Reset</button>
	                          	<button type="submit" class="btn btn-success">Submit</button>
								<?php 
									if(  $lot ) {
										echo '<input type="hidden" name="lot_id" value="'.$lot_id.'">';
										echo '<input type="hidden" name="action" class="lot_action" value="update_lot">';
									} else {
										echo '<input type="hidden" name="action" class="lot_action" value="create_lot">';
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