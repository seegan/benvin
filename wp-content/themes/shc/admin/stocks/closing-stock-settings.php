<?php
$stock_dates = getStockDates(date('Y-m-d'));
$closing_detail = getStockClosingDetail();
?>
<div class="container">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
			<div class="x_panel">
				<div class="x_title">
					<h2>Closing Stock Update<small>Sessions</small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form class="form-horizontal form-label-left" id="create_stock_closing">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Previous Closing<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12" style="position:relative">
								<input type="text" id="name" readonly class="previous_close_date form-control col-md-7 col-xs-12" value="<?php echo $stock_dates->previous_stock_end; ?>">
								<img class="stock_date_loader" src="<?php echo get_template_directory_uri().'/admin/stocks/inc/images/ajax-loader.gif' ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Update To<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name="stock_closing_to" required="required" class="form-control datepicker col-md-7 col-xs-12" value="<?php echo date('Y-m-d'); ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                          	<button class="btn btn-primary" type="button">Cancel</button>
							  	<button class="btn btn-primary" type="reset">Reset</button>
	                          	<?php 
									echo '<button type="submit" class="btn btn-success">Submit</button>';
								?>
	                        </div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
		    <div class="x_panel">
		       
		        <div class="customer_filter">
		            <div class="x_content">
			            <div class="table-responsive">
			                <table class="table table-striped jambo_table bulk_action">
			                    <thead>
			                        <tr class="headings">
			                            <th>
			                                S.No
			                            </th>
			                            <th class="column-title">Closing Date</th>
			                            <th class="column-title">Modified at </th>
			                        </tr>
			                    </thead>

			                    <tbody>
			                    <?php
									if($closing_detail) {
										$i = 1;
										foreach ($closing_detail as $c_value) {
			                    ?>
			                        <tr class="odd pointer">
			                            <td class="a-center"><?php echo $i; ?></td>
			                            <td class="a-center "><?php echo $c_value->closing_date; ?></td>
			                            <td class=""><?php echo $c_value->modified_at; ?></td>
			                        </tr>
			                    <?php
			                    		$i++;
			                    	}
			                    }
			                    ?>
			                    </tbody>
			                </table>
			            </div>
		        	</div>
		        </div>
		    </div>
		</div>


	</div>
</div>
