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
	if( isset($_GET['id']) ) {  
		include( get_template_directory().'/admin/statement/view/new.php' );
	} else {
		include( get_template_directory().'/admin/statement/view/search.php' );
	}
?>