<?php
	$master_data = false;
	$customer_detail = false;
	$site_detail = false;

	$pending_items = false;
	
	$customer_id = '';
	$site_id = '';

	$return_detail = false;
	$return_items = false;
	$unloading_data = false;
	$unloading_detail = false;


	if(isset($_GET['id'])) {
		$master_data = getMasterDetail($_GET['id']);
		$master_data = ($master_data) ? $master_data : false;

		if($master_data['master_data']) {
			$customer_id = $master_data['master_data']->customer_id;
			$site_id = $master_data['master_data']->site_id;

			$customer_detail = getCustomerData($customer_id);
			$site_detail = getSiteData($site_id);

			if(isset($_GET['return_id'])) {
				$return_items = (isset($return_data['return_detail']) && $return_data['return_detail'])  ? $return_data['return_detail'] : false;

				$group_items = (isset($return_data['group_detail']) && $return_data['group_detail'])  ? $return_data['group_detail'] : false;
				$return_detail = (isset($return_data['return_data']) && $return_data['return_data']) ? $return_data['return_data'] : false;

				$return_date = (isset($return_data['return_data']->return_date)) ? date('Y-m-d', strtotime($return_data['return_data']->return_date)) : date('Y-m-d');
				$return_time = (isset($return_data['return_data']->return_date)) ? date('H:i', strtotime($return_data['return_data']->return_date)) : date('H:i');


				$pending_items = getPendingItemsUpdate($_GET['id'], $return_date);

			}
		}
	}

?>

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
					<h2><small>Sessions</small></h2>
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
					<h2>Lost Items</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-horizontal form-label-left" id="update_lost">
						<div class="col-lg-6">
							<?php
							if($master_data) {

								echo "<div class='address-line'>";
								echo "<div style='float:left;width: 200px;'>";
								echo "MRI : ".$master_data['master_data']->id;
								echo "</div>";
								echo "<div style='float:left;width: 200px;'>";
								echo "Ref. <input type='text' name='ref_number' value='".$return_data['return_data']->ref_number."' style='width: 150px;border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;'>";
								echo "</div>";
								echo "<div style='clear:both;'></div>";
								echo "</div>";


								if($return_date) {

									$bill_number = billNumberText($return_data['return_data']->bill_from_comp, $return_data['return_data']->bill_no, 'MRR');
									echo "<div class='address-line'>No. ".$bill_number['bill_no']."</div>";
								}
							} ?>
							<div class="customer-name">Customer Name : M/s 
								<span class="customer-name"><?php echo ($customer_detail->name) ? $customer_detail->name : ''; ?></span>
							</div>
							<div class="address-line">Address : <span class="address-txt"><?php echo ($customer_detail->address) ? $customer_detail->address : ''; ?></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="address-line">Date : <span class="deposit-date"><input type="text" name="date" id="datepicker" value="<?php echo $return_date; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
							<div class="address-line">Time : <span class="deposit-time"><input type="time" name="time" value="<?php echo $return_time; ?>" style="border-color: rgba(118, 118, 118, 0);height: 34px;margin: 0;"></span></div>
							<div class="address-line">Site : 
								<select type="text" name="delivery_site_name" class="delivery_site_name" data-dvalue="<?php echo ($site_detail) ? $site_detail->id : ''; ?>"  data-sitename="<?php echo ($site_detail) ? $site_detail->site_name : ''; ?>">
								</select>
							</div>
							<div class="address-line">Phone : <span class="site-phone"><?php echo ($site_detail) ? $site_detail->phone_number : ''; ?></span></div>
							<button class="btn btn-success return_update_again">Modify This Lost Data</button>
						</div>
						<div class="col-lg-12">


							

						<div class="update_detail">
							<?php
								include( get_template_directory().'/admin/billing/return/view/update/lost-update-detail.php' );
							?>
						</div>
						<div class="update_full" style="display: none;">
							<?php
								include( get_template_directory().'/admin/billing/return/view/update/lost-update-full.php' );
							?>
						</div>



						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function () {
		jQuery('.return_update_again').live('click', function(){
			jQuery('.update_detail').css('display','none');
			jQuery('.update_full').css('display','block');

			jQuery('.update_detail .div-table-row').each(function(){
				var lot_id = jQuery(this).find('.lot_id').val();
				var return_qty = jQuery(this).find('.return_qty').val();

				jQuery('[data-lotid="'+lot_id+'"]').val(return_qty).change();
			});
		});
	});
</script>