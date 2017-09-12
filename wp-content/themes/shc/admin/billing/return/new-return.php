<style type="text/css">
	.address-line, .customer-name {
		margin-bottom: 20px;
	}
	.return_qty {
		width: 80px;
	}
	.return-charge-txt {
		width: 190px;
		float: right;
	}
	.return-charge-input {
		border-color: rgba(118, 118, 118, 0) !important;
    	height: 34px !important;
    	margin: 0;
    	margin-bottom: 0 !important;
    	width: 110px;
	}
</style>
<?php
	if( isset($_GET['id']) && isset($_GET['return_id'])  && $return_data = getReturnData($_GET['return_id']) ) {

		if( isset( $return_data['return_data']->is_return ) && $return_data['return_data']->is_return == 0 ) {
			$lost_data = getLostData($_GET['return_id']);

			include( get_template_directory().'/admin/billing/return/view/update/lost-update.php' );
		} else {
			include( get_template_directory().'/admin/billing/return/view/update/update.php' );
		}
	} else if( isset($_GET['id']) ) {
		include( get_template_directory().'/admin/billing/return/view/update/new.php' );
	} else {
		include( get_template_directory().'/admin/billing/return/view/update/search.php' );
	}
?>