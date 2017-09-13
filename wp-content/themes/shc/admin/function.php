<?php

function delete_record()
{
	global $wpdb;
	$bill_id = isset($_POST['bill_id']) ? $_POST['bill_id'] : 0;

	if( isset($_POST['bill_action']) && $_POST['bill_action'] == 'shc_quotation' ) {
		$quotation_table = $wpdb->prefix.$_POST['bill_action'];
		$quotation_detail_table = $wpdb->prefix.'shc_quotation_detail';
		$wpdb->update($quotation_table, array('active' => 0), array('id' => $bill_id));
		$wpdb->update($quotation_detail_table, array('active' => 0), array('quotation_id' => $bill_id));
		$redirect_url = 'admin.php?page=deposit&id='.$params['master_id'].'&deposit_id='.$deposit_id;
	}

	if( isset($_POST['bill_action']) && $_POST['bill_action'] == 'shc_deposit' ) {

	}

	if( isset($_POST['bill_action']) && $_POST['bill_action'] == 'shc_delivery' ) {
		
	}
	
	$data['redirect'] = (isset($_POST['action_from']) && $_POST['action_from'] == 'list') ? false : network_admin_url($redirect_url);
	$data['success'] = 1;
	$data['msg'] 	= 'Record Deleted!';
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_delete_record', 'delete_record' );
add_action( 'wp_ajax_nopriv_delete_record', 'delete_record' );
?>