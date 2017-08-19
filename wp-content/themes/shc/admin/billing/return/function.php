<?php
require get_template_directory() . '/admin/billing/return/class-return.php';

function load_return_scripts() {
	wp_enqueue_script( 'return-script', get_template_directory_uri() . '/admin/billing/inc/js/return.js', array('jquery'), false, false );
	if( (is_admin() ) && (isset($_GET['page'])) && ( $_GET['page'] == 'new_return' ) ) {
		wp_enqueue_script( 'return-script-dub', get_template_directory_uri() . '/admin/billing/inc/js/return-dub.js', array('jquery'), false, false );
	}
}
add_action( 'admin_enqueue_scripts', 'load_return_scripts' );


function getPendingItems($master_id = 0, $return_date = '0000-00-00' ) {
	$return = new BillReturn();
	return $return->get_PendingItems($master_id, $return_date);
}


function create_return() {
	global $wpdb;
	$data['msg'] 	= 'Something Went Wrong! Please Try Again!';
	$data['redirect'] 	= 0;
	$data['success'] = 0;
	$params = array();
	parse_str($_POST['data'], $params);

	$return_table 		= $wpdb->prefix.'shc_return';
	$return_detail_table 	= $wpdb->prefix.'shc_return_detail';
	$unloading_table 	= $wpdb->prefix.'shc_unloading';
	$unloading_detail_table 	= $wpdb->prefix.'shc_unloading_detail';

	$return_date = $params['date'].' '.$params['time'].':00';
	$master_id = $params['master_id'];

	$unloading = (isset($params['unloading']) && $params['unloading'] != '') ? $params['unloading'] : 0.00;
	$transportation = (isset($params['transportation']) && $params['transportation'] != '') ? $params['transportation'] : 0.00;
	$damage = (isset($params['damage']) && $params['damage'] != '') ? $params['damage'] : 0.00;
	$total = (isset($params['total']) && $params['total'] != '') ? $params['total'] : 0.00;
	$is_return = (isset($params['return_status']) && $params['return_status'] == 'return' ) ? 1 : 0;

	if(isset($params['action']) && $params['action'] == 'new_return') {

		$wpdb->insert($return_table, array('master_id' => $master_id, 'return_date' => $return_date, 'is_return' => $is_return) );
		$return_id = $wpdb->insert_id;

		$wpdb->insert($unloading_table, array('return_id' => $return_id, 'master_id' => $master_id, 'unloading_charge' => $total, 'return_date' => $return_date ) );
		$loading_id = $wpdb->insert_id;


		$wpdb->insert($unloading_detail_table, array('return_id' => $return_id, 'unloading_id' => $loading_id, 'charge_for' => 'unloading', 'charge_amt' => $unloading ) );
		$wpdb->insert($unloading_detail_table, array('return_id' => $return_id, 'unloading_id' => $loading_id, 'charge_for' => 'transportation', 'charge_amt' => $transportation ) );
		$wpdb->insert($unloading_detail_table, array('return_id' => $return_id, 'unloading_id' => $loading_id, 'charge_for' => 'damage', 'charge_amt' => $damage ) );


		if($return_id) {

			foreach ($params['return_detail'] as $n_value) {

				if($n_value['delivery_detail_id'] != 0 && $n_value['delivery_detail_id'] != '' && $n_value['qty'] != 0 && $n_value['qty'] != '') {
					$wpdb->insert($return_detail_table, array('return_id' => $return_id, 'master_id' => $master_id, 'lot_id' => $n_value['lot_id'], 'delivery_detail_id' => $n_value['delivery_detail_id'] , 'qty' => $n_value['qty'], 'return_date' => $return_date ));
				}
			}

			$data['success'] = 1;
			$data['msg'] 	= 'Return Updated!';
			$redirect_url = 'admin.php?page=new_return&id='.$master_id.'&return_id='.$return_id;
			$data['redirect'] = network_admin_url( $redirect_url );
		}
	}


	if(isset($params['action']) && $params['action'] == 'update_return') {

		$return_id = isset($params['return_id']) ? $params['return_id'] : 0;

		$wpdb->update($return_table, array('return_date' => $return_date, 'is_return' => $is_return), array('id' => $return_id) );
		$wpdb->update($return_detail_table, array('active' => 0), array('return_id' => $return_id));



		$wpdb->update($unloading_table, array( 'unloading_charge' => $total, 'return_date' => $return_date ), array('return_id' => $return_id, 'master_id' => $master_id) );

		$wpdb->update($unloading_detail_table, array( 'charge_amt' => $unloading ), array('return_id' => $return_id, 'charge_for' => 'unloading') );
		$wpdb->update($unloading_detail_table, array( 'charge_amt' => $transportation ), array('return_id' => $return_id, 'charge_for' => 'transportation') );
		$wpdb->update($unloading_detail_table, array( 'charge_amt' => $damage ), array('return_id' => $return_id, 'charge_for' => 'damage',) );


		if($return_id) {

			foreach ($params['return_detail'] as $r_value) {
				$wpdb->update($return_detail_table, array( 'qty' => $r_value['qty'], 'return_date' => $return_date, 'active' => 1 ), array('id' => $r_value['return_detail_id']) );
			}
			$data['success'] = 1;
			$data['msg'] 	= 'Return Updated!';
			$redirect_url = 'admin.php?page=new_return&id='.$master_id.'&return_id='.$return_id;

			$data['redirect'] = network_admin_url( $redirect_url );
		}
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_create_return', 'create_return' );
add_action( 'wp_ajax_nopriv_create_return', 'create_return' );


function getReturnData($return_id = 0) {
	$return = new BillReturn();
	return $return->get_ReturnData($return_id);
}

function getUnloadingData($return_id = 0, $key='') {
	$return = new BillReturn();
	return $return->get_UnloadingData($return_id, $key);
}
