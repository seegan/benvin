<?php
require get_template_directory() . '/admin/billing/delivery/class-delivery.php';

function load_delivery_scripts() {
	wp_enqueue_script( 'delivery-script', get_template_directory_uri() . '/admin/billing/inc/js/delivery.js', array('jquery'), false, false );

	if( (is_admin() ) && (isset($_GET['page'])) && ( $_GET['page'] == 'new_delivery' ) ) {
		wp_enqueue_script( 'delivery-script-dub', get_template_directory_uri() . '/admin/billing/inc/js/delivery-dub.js', array('jquery'), false, false );
	}

}

add_action( 'admin_enqueue_scripts', 'load_delivery_scripts' );




function create_delivery() {
	global $wpdb;
	$data['msg'] 	= 'Something Went Wrong! Please Try Again!';
	$data['redirect'] 	= 0;
	$data['success'] = 0;
	$loggdin_user = get_current_user_id();

	$params = array();
	parse_str($_POST['data'], $params);
	$delivery_table 		= $wpdb->prefix.'shc_delivery';
	$delivery_detail_table 	= $wpdb->prefix.'shc_delivery_detail';
	$processing_items_table 	= $wpdb->prefix.'shc_processing_items';

	$delivery_date = $params['date'].' '.$params['time'].':00';
	$financial_year = getFinancialYear( $params['date'] );

	$last_billed_date = date( 'Y-m-d', strtotime( $delivery_date . ' -1 day' ) );
	$master_id = $params['master_id'];

	$vehicle_number = isset($params['vehicle_number']) ? $params['vehicle_number'] : '';
	$driver_name = isset($params['driver_name']) ? $params['driver_name'] : '';
	$driver_mobile = isset($params['driver_mobile']) ? $params['driver_mobile'] : '';


	if(isset($params['action']) && $params['action'] == 'new_delivery') {

		$bill_no_data = getCorrectBillNumber($params['bill_no'], $params['site_id'], 'shc_delivery', $params['date']);

		$wpdb->insert($delivery_table, array('master_id' => $master_id, 'financial_year' => $financial_year, 'bill_from_comp' => $bill_no_data['bill_from_comp'], 'bill_no' => $bill_no_data['bill_no'], 'delivery_date' => $delivery_date, 'last_billed_date' => $last_billed_date, 'vehicle_number' => $vehicle_number , 'driver_name' => $driver_name , 'driver_mobile' => $driver_mobile, 'updated_by' => $loggdin_user ) );
		$delivery_id = $wpdb->insert_id;
		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $delivery_id, 'detail' => 'delivery_create' ));

		if($delivery_id) {

			foreach ($params['delivery_detail'] as $value) {

				if($value['lot_id_orig'] != 0 && $value['lot_id_orig'] != '') {
					$wpdb->insert($delivery_detail_table, array('delivery_id' => $delivery_id, 'master_id' => $master_id, 'lot_id' => $value['lot_id_orig'], 'qty' => $value['qty'], 'rate_per_unit' => $value['unit_price'], 'delivery_date' => $delivery_date, 'last_billed_date' => $last_billed_date ));
				}

			}

			$data['success'] = 1;
			$data['msg'] 	= 'Delivery Updated!';
			$redirect_url = 'admin.php?page=new_delivery&id='.$master_id.'&delivery_id='.$delivery_id;
			$data['redirect'] = network_admin_url( $redirect_url );
		}
	}


	if(isset($params['action']) && $params['action'] == 'update_delivery') {
		$delivery_id = isset($params['delivery_id']) ? $params['delivery_id'] : 0;

		$wpdb->update($delivery_table, array('financial_year' => $financial_year, 'delivery_date' => $delivery_date, 'last_billed_date' => $last_billed_date, 'vehicle_number' => $vehicle_number , 'driver_name' => $driver_name , 'driver_mobile' => $driver_mobile ), array('id' => $delivery_id) );

		$wpdb->update($delivery_detail_table, array('active' => 0), array('delivery_id' => $delivery_id));
		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $delivery_id, 'detail' => 'delivery_update' ));

		if($delivery_id) {

			foreach ($params['delivery_detail'] as $u_value) {

				if(isset($u_value['delivery_detail_id']) && $u_value['delivery_detail_id'] != '' && $u_value['delivery_detail_id'] != 0 ) {

					if($u_value['lot_id_orig'] != 0 && $u_value['lot_id_orig'] != '') {

						$wpdb->update($delivery_detail_table, array('delivery_id' => $delivery_id, 'master_id' => $master_id, 'lot_id' => $u_value['lot_id_orig'], 'qty' => $u_value['qty'], 'rate_per_unit' => $u_value['unit_price'], 'delivery_date' => $delivery_date, 'last_billed_date' => $last_billed_date, 'active' => 1 ), array('id' => $u_value['delivery_detail_id']));
					}

				} else {

					if($u_value['lot_id_orig'] != 0 && $u_value['lot_id_orig'] != '') {
						$wpdb->insert($delivery_detail_table, array('delivery_id' => $delivery_id, 'master_id' => $master_id, 'lot_id' => $u_value['lot_id_orig'], 'qty' => $u_value['qty'], 'rate_per_unit' => $u_value['unit_price'], 'delivery_date' => $delivery_date, 'last_billed_date' => $last_billed_date ));
					}

				}

			}

			$data['success'] = 1;
			$data['msg'] 	= 'Delivery Updated!';
			$redirect_url = 'admin.php?page=new_delivery&id='.$master_id.'&delivery_id='.$delivery_id;

			$data['redirect'] = network_admin_url( $redirect_url );
		}
	}


	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_create_delivery', 'create_delivery' );
add_action( 'wp_ajax_nopriv_create_delivery', 'create_delivery' );


function getDeliveryData($delivery_id = 0)
{
	$delivery = new Delivery();
	return $delivery->get_DeliveryData($delivery_id);
}