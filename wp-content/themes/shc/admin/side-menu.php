<?php
	$id_txt_list = (isset($menu_id) && $menu_id) ? '&master_id='.$menu_id : '';
	$id_txt_new = (isset($menu_id) && $menu_id) ? '&id='.$menu_id : '';
?>
		<div class="col-lg-3">
			<div class="x_panel">
				<div class="x_title">
					<h2><small>New</small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<ul>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=new_quotation').$id_txt_new;  ?>">Create Quotation</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=deposit').$id_txt_new;  ?>">New Deposit</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=new_delivery').$id_txt_new;  ?>">New Delivery</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=new_return').$id_txt_new; ?>">New Return</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=new_hiring').$id_txt_new; ?>">Generate Hiring Bill</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=new_obc').$id_txt_new; ?>">New OBC</a></li>
					</ul>
				</div>
			</div>
			<div class="x_panel">
				<div class="x_title">
					<h2><small>List</small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<ul>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=quotation_report').$id_txt_list; ?>">Quotation List</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=deposit_report').$id_txt_list; ?>">Deposit List</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=delivery_report').$id_txt_list; ?>">Delivery List</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=return_report').$id_txt_list; ?>">Return List</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=hiring_report').$id_txt_list; ?>">Hiring Bill List</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=obc_report').$id_txt_list; ?>">OBC List</a></li>
						<li class="parallelogram"><a href="<?php echo admin_url('admin.php?page=new_statement').$id_txt_new; ?>">Statement</a></li>
					</ul>
				</div>
			</div>
		</div>