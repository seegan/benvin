<?php
	$return_date = date('Y-m-d');
	$return_time = date('H:i:s');
?>
<div class="container">

	<div class="row">
	<?php 
		include( get_template_directory().'/admin/side-menu.php' );
	?>
		<div class="col-lg-9">
			<div class="x_panel">
				<div class="x_title">
					<h2>Item Return</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="create_return">
						<div class="col-lg-6">
							<div class='address-line'>No. BA/SD : </div>
							<div class="customer-name">Customer Name : M/s 
								<span class="customer-name"></span>
							</div>
							<div class="address-line">Address : <span class="address-txt"></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="address-line">Date : <span class="deposit-date"><?php echo $return_date; ?></span></div>
							<div class="address-line">Time : <span class="deposit-time"><?php echo $return_time; ?></span></div>
							<div class="address-line">Site : 
								<select type="text" name="delivery_site_name" class="delivery_site_name" data-dvalue=""  data-sitename=""></select>
							</div>
							<div class="address-line">Phone : <span class="site-phone"></span></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>