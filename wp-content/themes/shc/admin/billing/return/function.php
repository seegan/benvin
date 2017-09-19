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

function getPendingItemsUpdate($master_id = 0, $return_date = '0000-00-00' ) {
	$return = new BillReturn();
	return $return->get_PendingItemsUpdate($master_id, $return_date);
}

function getDamageData($return_id = 0) {
	$return = new BillReturn();
	return $return->get_DamageData($return_id);
}

function create_return() {
	global $wpdb;
	$data['msg'] 	= 'Something Went Wrong! Please Try Again!';
	$data['redirect'] 	= 0;
	$data['success'] = 0;
	$loggdin_user = get_current_user_id();

	$params = array();
	parse_str($_POST['data'], $params);
	$return_table 			= $wpdb->prefix.'shc_return';
	$return_detail_table 	= $wpdb->prefix.'shc_return_detail';
	$unloading_table 		= $wpdb->prefix.'shc_unloading';
	$unloading_detail_table = $wpdb->prefix.'shc_unloading_detail';
	$lost_table 			= $wpdb->prefix.'shc_lost';
	$lost_detail_table 		= $wpdb->prefix.'shc_lost_detail';
	
	$damage_table 		= $wpdb->prefix.'shc_return_damage';
	$damage_detail_table 		= $wpdb->prefix.'shc_return_damage_detail';

	$return_date = $params['date'].' '.$params['time'].':00';
	$financial_year = getFinancialYear( $params['date'] );

	$master_id = $params['master_id'];

	$unloading = (isset($params['unloading']) && $params['unloading'] != '') ? $params['unloading'] : 0.00;
	$transportation = (isset($params['transportation']) && $params['transportation'] != '') ? $params['transportation'] : 0.00;
	$damage = (isset($params['damage']) && $params['damage'] != '') ? $params['damage'] : 0.00;
	$total = (isset($params['total']) && $params['total'] != '') ? $params['total'] : 0.00;
	$is_return = (isset($params['return_status']) && $params['return_status'] == 'return' ) ? 1 : 0;
	$vehicle_number = (isset($params['vehicle_number']) && $params['vehicle_number'] != '') ? $params['vehicle_number'] : '';
	$driver_name = (isset($params['driver_name']) && $params['driver_name'] != '') ? $params['driver_name'] : '';
	$driver_mobile = (isset($params['driver_mobile']) && $params['driver_mobile'] != '') ? $params['driver_mobile'] : '';


	if(isset($params['action']) && $params['action'] == 'new_return') {

		$return_data = array('ref_number' => $params['ref_number'], 'financial_year' => $financial_year, 'master_id' => $master_id, 'return_date' => $return_date, 'is_return' => $is_return, 'vehicle_number' => $vehicle_number, 'driver_name' => $driver_name, 'driver_mobile' => $driver_mobile);

		$return_data['updated_by'] = $loggdin_user;

		$bill_no_data = getCorrectBillNumber($params['bill_no'], $params['site_id'], 'shc_return', $params['date']);
		if($is_return) {
			$return_data['bill_from_comp'] 	= $bill_no_data['bill_from_comp'];
			$return_data['bill_no'] 		= $bill_no_data['bill_no'];
		} else {
			$return_data['bill_from_comp'] 	= $bill_no_data['bill_from_comp'];
		}

		$wpdb->insert($return_table,  $return_data);
		$return_id = $wpdb->insert_id;
		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $return_id, 'detail' => 'return_create' ));

		$wpdb->insert($unloading_table, array('return_id' => $return_id, 'master_id' => $master_id, 'unloading_charge' => $total, 'return_date' => $return_date ) );
		$loading_id = $wpdb->insert_id;

		$wpdb->insert( $damage_table, array('return_id' => $return_id, 'master_id' => $master_id, 'damage_total' => $damage, 'updated_by' => $loggdin_user) );
		$damage_id = $wpdb->insert_id;


		$wpdb->insert($unloading_detail_table, array('return_id' => $return_id, 'unloading_id' => $loading_id, 'charge_for' => 'unloading', 'charge_amt' => $unloading ) );
		$wpdb->insert($unloading_detail_table, array('return_id' => $return_id, 'unloading_id' => $loading_id, 'charge_for' => 'transportation', 'charge_amt' => $transportation ) );
		$wpdb->insert($unloading_detail_table, array('return_id' => $return_id, 'unloading_id' => $loading_id, 'charge_for' => 'damage', 'charge_amt' => $damage ) );

		if($return_id) {


			if(isset($params['return_detail'])) {
				foreach ($params['return_detail'] as $n_value) {
					if($n_value['delivery_detail_id'] != 0 && $n_value['delivery_detail_id'] != '' && $n_value['qty'] != 0 && $n_value['qty'] != '') {
						$wpdb->insert($return_detail_table, array('return_id' => $return_id, 'master_id' => $master_id, 'lot_id' => $n_value['lot_id'], 'delivery_detail_id' => $n_value['delivery_detail_id'] , 'qty' => $n_value['qty'], 'return_date' => $return_date ));
					}
				}
			}

			if(isset($params['damage_detail'])) {
				foreach ($params['damage_detail'] as $d_value) {

					if($d_value['damage_charge'] != '' && $d_value['damage_charge'] != 0) {
						$wpdb->insert($damage_detail_table, array('damage_id' => $damage_id ,'master_id' => $master_id, 'return_id' => $return_id, 'damage_detail' => $d_value['damage_text'] , 'damage_charge' => $d_value['damage_charge']));
					}
				}
			}






			if(!$is_return) {
				$lost_data = array('master_id' => $master_id, 'return_id' => $return_id, 'lost_qty' => $params['lost_qty_total'], 'lost_total' => $params['lost_cost'], 'updated_by' => $loggdin_user);

				$wpdb->insert($lost_table, $lost_data);
				$lost_id = $wpdb->insert_id;
				create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $lost_id, 'detail' => 'lost_create' ));

				foreach ($params['return_detail_group'] as $l_value) {

					if($l_value['lost_qty'] != '' && $l_value['lost_qty'] > 0 ) {
						$wpdb->insert($lost_detail_table, array('master_id' => $master_id, 'lost_id' => $lost_id, 'return_id' => $return_id, 'lot_id' => $l_value['lot_id'], 'lost_qty' => $l_value['lost_qty'] , 'lost_unit_price' => $l_value['lost_per_unit'], 'lost_total' => $l_value['lost_row_total'] ));
					}
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
		$damage_id = isset($params['damage_id']) ? $params['damage_id'] : 0;

		$wpdb->update($return_table, array('ref_number' => $params['ref_number'], 'financial_year' => $financial_year, 'return_date' => $return_date, 'is_return' => $is_return, 'vehicle_number' => $vehicle_number, 'driver_name' => $driver_name, 'driver_mobile' => $driver_mobile), array('id' => $return_id) );
		$wpdb->update($damage_table, array('damage_total' => $damage), array('id' => $damage_id) );


		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $return_id, 'detail' => 'return_update' ));

		$wpdb->update($return_detail_table, array('active' => 0), array('return_id' => $return_id));
		$wpdb->update($damage_detail_table, array('active' => 0), array('return_id' => $return_id));





		$wpdb->update($unloading_table, array( 'unloading_charge' => $total, 'return_date' => $return_date ), array('return_id' => $return_id, 'master_id' => $master_id) );

		$wpdb->update($unloading_detail_table, array( 'charge_amt' => $unloading ), array('return_id' => $return_id, 'charge_for' => 'unloading') );
		$wpdb->update($unloading_detail_table, array( 'charge_amt' => $transportation ), array('return_id' => $return_id, 'charge_for' => 'transportation') );
		$wpdb->update($unloading_detail_table, array( 'charge_amt' => $damage ), array('return_id' => $return_id, 'charge_for' => 'damage',) );


		if($return_id) {

			foreach ($params['return_detail'] as $n_value) {
				if($n_value['delivery_detail_id'] != 0 && $n_value['delivery_detail_id'] != '' && $n_value['qty'] != 0 && $n_value['qty'] != '') {
					$wpdb->insert($return_detail_table, array('return_id' => $return_id, 'master_id' => $master_id, 'lot_id' => $n_value['lot_id'], 'delivery_detail_id' => $n_value['delivery_detail_id'] , 'qty' => $n_value['qty'], 'return_date' => $return_date ));
				}
			}

			foreach ($params['damage_detail'] as $d_value) {
				if($d_value['damage_charge'] != 0 && $d_value['damage_charge'] != '') {

					$wpdb->insert($damage_detail_table, array('master_id' => $master_id, 'return_id' => $return_id, 'damage_id' => $damage_id, 'damage_detail' => $d_value['damage_text'] , 'damage_charge' => $d_value['damage_charge'], 'active' => 1 ));
				}
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

function getLostData($lost_id = 0) {
	$lost = new BillReturn();
	return $lost->get_LostData($lost_id);
}

function getUnloadingData($return_id = 0, $key='') {
	$return = new BillReturn();
	return $return->get_UnloadingData($return_id, $key);
}



function update_lost() {
	global $wpdb;
	$data['msg'] 	= 'Something Went Wrong! Please Try Again!';
	$data['redirect'] 	= 0;
	$data['success'] = 0;
	$loggdin_user = get_current_user_id();

	$params = array();
	parse_str($_POST['data'], $params);
	$return_table 			= $wpdb->prefix.'shc_return';
	$return_detail_table 	= $wpdb->prefix.'shc_return_detail';
	$lost_table 			= $wpdb->prefix.'shc_lost';
	$lost_detail_table 		= $wpdb->prefix.'shc_lost_detail';

	$return_date = $params['date'].' '.$params['time'].':00';
	$financial_year = getFinancialYear( $params['date'] );

	$master_id = $params['master_id'];


	$return_id = isset($params['return_id']) ? $params['return_id'] : 0;
	$lost_id =  isset($params['lost_id']) ? $params['lost_id'] : 0;



	if($return_id) {

		$wpdb->update($return_table, array('ref_number' => $params['ref_number'], 'financial_year' => $financial_year, 'return_date' => $return_date, 'is_return' => 0), array('id' => $return_id) );
		$wpdb->update($lost_table, array('lost_qty' => $params['lost_qty_total'], 'lost_total' => $params['lost_cost'] ), array('id' => $lost_id) );

		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $return_id, 'detail' => 'lost_update' ));
		$wpdb->update($return_detail_table, array('active' => 0), array('return_id' => $return_id));
		$wpdb->update($lost_detail_table, array('active' => 0), array('return_id' => $return_id));


		foreach ($params['return_detail'] as $n_value) {
			if($n_value['delivery_detail_id'] != 0 && $n_value['delivery_detail_id'] != '' && $n_value['qty'] != 0 && $n_value['qty'] != '') {
				$wpdb->insert($return_detail_table, array('return_id' => $return_id, 'master_id' => $master_id, 'lot_id' => $n_value['lot_id'], 'delivery_detail_id' => $n_value['delivery_detail_id'] , 'qty' => $n_value['qty'], 'return_date' => $return_date ));
			}
		}

		foreach ($params['return_detail_group'] as $l_value) {

			if($l_value['lost_qty'] != '' && $l_value['lost_qty'] > 0 ) {
				$wpdb->insert($lost_detail_table, array('master_id' => $master_id, 'lost_id' => $lost_id, 'return_id' => $return_id, 'lot_id' => $l_value['lot_id'], 'lost_qty' => $l_value['lost_qty'] , 'lost_unit_price' => $l_value['lost_per_unit'], 'lost_total' => $l_value['lost_row_total'] ));
			}
		}
		
		$data['success'] = 1;
		$data['msg'] 	= 'Lost Updated!';
		$redirect_url = 'admin.php?page=new_return&id='.$master_id.'&return_id='.$return_id;
		$data['redirect'] = network_admin_url( $redirect_url );
	}

	echo json_encode($data);
	die();

}
add_action( 'wp_ajax_update_lost', 'update_lost' );
add_action( 'wp_ajax_nopriv_update_lost', 'update_lost' );