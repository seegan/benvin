<style type="text/css">
	.address-line, .customer-name {
		margin-bottom: 20px;
	}
	.return_qty {
		width: 80px;
	}
	.hiring_green {
	    width: 15px;
	    height: 15px;
	    background-color: #5e8e59;
	    float: right;
	    border-radius: 10px;
	    margin-top: 8px;
	}
	.hiring_red {
	    width: 15px;
	    height: 15px;
	    background-color: rgba(244, 67, 54, 0.88);
	    float: right;
	    border-radius: 10px;
	    margin-top: 8px;
	}

</style>

<?php
	$quotation = new Quotation();
	$menu_id = isset($_GET['id']) ? $_GET['id'] : false;
	if( isset($_GET['id']) && isset($_GET['deposit_id'])  && $security_data = getDepositDetail($_GET['deposit_id']) ) { 
		include( get_template_directory().'/admin/billing/deposit/view/update/update.php' );
	} else if( isset($_GET['id']) ) {  
		include( get_template_directory().'/admin/billing/deposit/view/update/new.php' );
	} else {
		include( get_template_directory().'/admin/billing/deposit/view/update/search.php' );
	}
?>