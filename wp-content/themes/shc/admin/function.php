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
		$redirect_url = 'admin.php?page=quotation_report';
	}

	if( isset($_POST['bill_action']) && $_POST['bill_action'] == 'shc_deposit' ) {
		$deposit_table = $wpdb->prefix.'shc_deposit';
		$deposit_detail_table = $wpdb->prefix.'shc_deposit_detail';
		$deposit_cheque = $wpdb->prefix.'shc_deposit_cheque';
		$loading_table = $wpdb->prefix.'shc_loading';
		$loading_detail_table = $wpdb->prefix.'shc_loading_detail';

		$wpdb->update($deposit_table, array('active' => 0), array('id' => $bill_id));
		$wpdb->update($deposit_detail_table, array('active' => 0), array('deposit_id' => $bill_id));
		$wpdb->update($deposit_cheque, array('active' => 0), array('deposit_id' => $bill_id));
		$wpdb->update($loading_table, array('active' => 0), array('deposit_id' => $bill_id));
		$wpdb->update($loading_detail_table, array('active' => 0), array('deposit_id' => $bill_id));
		$redirect_url = 'admin.php?page=deposit_report';
	}

	if( isset($_POST['bill_action']) && $_POST['bill_action'] == 'shc_delivery' ) {
		$delivery_table = $wpdb->prefix.'shc_delivery';
		$delivery_detail_table = $wpdb->prefix.'shc_delivery_detail';

		$wpdb->update($delivery_table, array('active' => 0), array('id' => $bill_id));
		$wpdb->update($delivery_detail_table, array('active' => 0), array('delivery_id' => $bill_id));
		$redirect_url = 'admin.php?page=deposit_report';
	}

	if( isset($_POST['bill_action']) && $_POST['bill_action'] == 'shc_return' ) {
		$return_table = $wpdb->prefix.'shc_return';
		$return_detail_table = $wpdb->prefix.'shc_return_detail';
		$return_damage_table = $wpdb->prefix.'shc_return_damage';
		$return_damage_detail = $wpdb->prefix.'shc_return_damage_detail';
		$return_unloading = $wpdb->prefix.'shc_unloading';
		$return_unloading_detail = $wpdb->prefix.'shc_unloading_detail';
		$lost_table = $wpdb->prefix.'shc_lost';
		$lost_detail_table = $wpdb->prefix.'shc_lost_detail';


		$wpdb->update($return_table, array('active' => 0), array('id' => $bill_id));
		$wpdb->update($return_detail_table, array('active' => 0), array('return_id' => $bill_id));
		$wpdb->update($return_damage_table, array('active' => 0), array('return_id' => $bill_id));
		$wpdb->update($return_damage_detail, array('active' => 0), array('return_id' => $bill_id));
		$wpdb->update($return_unloading, array('active' => 0), array('return_id' => $bill_id));
		$wpdb->update($return_unloading_detail, array('active' => 0), array('return_id' => $bill_id));
		$wpdb->update($lost_table, array('active' => 0), array('return_id' => $bill_id));
		$wpdb->update($lost_detail_table, array('active' => 0), array('return_id' => $bill_id));

		$redirect_url = 'admin.php?page=return_report';
	}
	
	if( isset($_POST['bill_action']) && $_POST['bill_action'] == 'shc_hiring' ) {
		$hiring_table = $wpdb->prefix.'shc_hiring';
		$hiring_detail_table = $wpdb->prefix.'shc_hiring_detail';

		$wpdb->update($hiring_table, array('active' => 0), array('id' => $bill_id));
		$wpdb->update($hiring_detail_table, array('active' => 0), array('hiring_bill_id' => $bill_id));

		$redirect_url = 'admin.php?page=hiring_report';
	}

	if( isset($_POST['bill_action']) && $_POST['bill_action'] == 'shc_obc' ) {

		$obc_table = $wpdb->prefix.'shc_obc_cheque';
		$wpdb->update($obc_table, array('active' => 0), array('id' => $bill_id));
		$redirect_url = 'admin.php?page=obc_report';
	}

	$data['redirect'] = (isset($_POST['action_from']) && $_POST['action_from'] == 'list') ? false : network_admin_url($redirect_url);
	$data['success'] = 1;
	$data['msg'] 	= 'Record Deleted!';
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_delete_record', 'delete_record' );
add_action( 'wp_ajax_nopriv_delete_record', 'delete_record' );


















function crypto_rand_secure($min, $max) {
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}

function getToken($table, $identifier = '') {	
	global $wpdb; 
    $token_exists = false;
    do{
    	$token = $identifier.generateToken();
    	$token_exists = $wpdb->get_row("SELECT id from ${table} WHERE id = '${token}'");
    } while($token_exists);

    return $token;
}

function generateToken() {
	$month = date("m");
	$year = date("Y");
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < 7; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }
	$token = $month.$year.$token;
	return $token;
}

?>