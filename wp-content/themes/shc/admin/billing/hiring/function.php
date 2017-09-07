<?php
require get_template_directory() . '/admin/billing/hiring/class-hiring.php';

function load_hiring_scripts() {
	wp_enqueue_script( 'hiring-script', get_template_directory_uri() . '/admin/billing/inc/js/hiring.js', array('jquery'), false, false );
	if( (is_admin() ) && (isset($_GET['page'])) && ( $_GET['page'] == 'new_hiring' ) ) {
		wp_enqueue_script( 'hiring-script-dub', get_template_directory_uri() . '/admin/billing/inc/js/hiring-dub.js', array('jquery'), false, false );
	}
}
add_action( 'admin_enqueue_scripts', 'load_hiring_scripts' );


function getHiringItems($master_id = 0, $bill_from, $bill_to) {
	$return = new Hiring();
	return $return->get_HiringItems($master_id, $bill_from, $bill_to);
}


function get_deposit_site_list() {
	$search = $_POST['search_key'];
	$data['success'] = 0;
	global $wpdb;
	$master_table = $wpdb->prefix.'shc_master';
	$customers_table = $wpdb->prefix.'shc_customers';
	$site_table = $wpdb->prefix.'shc_customer_site';

	$query = "SELECT d.id, cs.site_name, cs.phone_number, cs.site_address, c.name  FROM ${master_table} as d JOIN ${customers_table} as c ON d.customer_id = c.id JOIN ${site_table} as cs ON d.site_id = cs.id WHERE ( cs.site_name LIKE '${search}%' OR cs.phone_number LIKE '${search}%' OR cs.site_address LIKE '${search}%' OR d.id = '${search}' ) ";

	if( $data['items'] = $wpdb->get_results( $query, ARRAY_A ) ) {
		$data['success'] = 1;
	}
	echo json_encode($data);
	die();
}	
add_action( 'wp_ajax_get_deposit_site_list', 'get_deposit_site_list' );
add_action( 'wp_ajax_nopriv_get_deposit_site_list', 'get_deposit_site_list' );



function create_billing() {
	$data['msg'] 	= 'Something Went Wrong! Please Try Again!';
	$data['redirect'] 	= 0;
	$data['success'] = 0;
	$loggdin_user = get_current_user_id();	

	global $wpdb;
	$params = array();
	$hiring_table = $wpdb->prefix.'shc_hiring';
	$hiring_detail_table = $wpdb->prefix.'shc_hiring_detail';
	parse_str($_POST['data'], $params);

	//unset($params['action']);
	$master_id = isset($params['master_id']) ? $params['master_id'] : 0;



	$hiring_data = array(
		'master_id' => isset($params['master_id']) ? $params['master_id'] : 0,
		'bill_from' => isset($params['master_id']) ? $params['bill_from'] : '0000:00:00',
		'bill_to'  => isset($params['master_id']) ? $params['bill_to'] : '0000:00:00',
		'return_ids' => isset($params['master_id']) ? $params['transport_return_id'] : '',
		'transportation_charge' => isset($params['master_id']) ? $params['unloading_total'] : 0.00,
		'sub_tot' => isset($params['sub_tot']) ? $params['sub_tot'] : 0.00,


		'discount_avail' => isset($params['hiring_discount_avail']) ? $params['hiring_discount_avail'] : 'no',
		'discount_percentage' => isset($params['discount_percentage']) ? $params['discount_percentage'] : 0.00,
		'discount_amount' => isset($params['discount_amt']) ? $params['discount_amt'] : 0.00,
		'total_after_discount' =>  isset($params['after_discount_amt']) ? $params['after_discount_amt'] : $params['sub_tot'],

		'tax_from' 	=> isset($params['tax_from']) ? $params['tax_from'] : 'no_tax',
		'gst_for' 	=> isset($params['gst_for']) ? $params['gst_for'] : '',
		'igst_amt' 	=> isset($params['gst_igst']) ? $params['gst_igst'] : 0.00,
		'cgst_amt' 	=> isset($params['gst_cgst']) ? $params['gst_cgst'] : 0.00,
		'sgst_amt' 	=> isset($params['gst_sgst']) ? $params['gst_sgst'] : 0.00,
		'vat_amt' 	=> isset($params['vat_amt']) ? $params['vat_amt'] : 0.00,
		'tax_include_tot' =>  isset($params['total_include_tax_amt']) ? $params['total_include_tax_amt'] : $hiring_data['total_after_discount'],

		'round_off' => isset($params['round_off']) ? $params['round_off'] : 0.00,
		'hiring_total' => isset($params['master_id']) ? $params['hiring_tot'] : 0.00,

		'bill_date' => isset($params['master_id']) ? $params['billing_date'] : '0000:00:00',
		'bill_time' => isset($params['master_id']) ? $params['billing_time'] : '00:00',
	);



	if($params['action'] == 'create_billing') {
		
		$bill_no_data = getCorrectBillNumber($params['bill_no'], $params['site_id'], 'shc_hiring', $params['billing_date']);

		$hiring_data['bill_from_comp'] = $bill_no_data['bill_from_comp'];
		$hiring_data['bill_no'] = $bill_no_data['bill_no'];
		$hiring_data['updated_by'] = $loggdin_user;

		$wpdb->insert($hiring_table, $hiring_data);
		$hiring_bill_id = $wpdb->insert_id;
		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $hiring_bill_id, 'detail' => 'hiring_create' ));

		if($hiring_bill_id && $params['hiring_detail']) {
			foreach ($params['hiring_detail'] as $h_value) {
				$hiring_detail = array(
					'hiring_bill_id' 		=> $hiring_bill_id,
					'delivery_detail_id' 	=> (isset($h_value['delivery_detail_id'])) ? $h_value['delivery_detail_id'] : 0,
					'lot_id'				=> (isset($h_value['lot_id'])) ? $h_value['lot_id'] : 0,
					'qty'					=> (isset($h_value['qty'])) ? $h_value['qty'] : 0,
					'bill_from'				=> (isset($h_value['bill_from'])) ? $h_value['bill_from'] : '0000:00:00',
					'bill_to'				=> (isset($h_value['bill_to'])) ? $h_value['bill_to'] : '0000:00:00',
					'bill_days'				=> (isset($h_value['bill_days'])) ? $h_value['bill_days'] : 0,
					'delivery_date'			=> (isset($h_value['delivery_date'])) ? $h_value['delivery_date'] : '0000:00:00',
					'total_days'			=> (isset($h_value['total_days'])) ? $h_value['total_days'] : 0,
					'rate_per_day'			=> (isset($h_value['rate_per_day'])) ? $h_value['rate_per_day'] : 0.00,
					'amount'				=> (isset($h_value['amount'])) ? $h_value['amount'] : 0.00,
					'got_return'			=> (isset($h_value['got_return'])) ? $h_value['got_return'] : 0,
					'min_checkbox_avail'	=> (isset($h_value['min_checkbox_avail'])) ? $h_value['min_checkbox_avail'] : 0,
					'min_checked'			=> (isset($h_value['min_checked'])) ? 1 : 0,
					'hiring_amt'			=> (isset($h_value['hiring_amt'])) ? $h_value['hiring_amt'] : 0.00,
					'hiring_amt_min'		=> (isset($h_value['hiring_amt_min'])) ? $h_value['hiring_amt_min'] : 0.00,
					'for_thirty_days'		=> (isset($h_value['for_thirty_days'])) ? $h_value['for_thirty_days'] : 0.00,
					'previous_paid'			=> (isset($h_value['previous_paid'])) ? $h_value['previous_paid'] : 0.00,
					'bal_to_pay'			=> (isset($h_value['bal_to_pay'])) ? $h_value['bal_to_pay'] : 0.00,
					);

				$wpdb->insert($hiring_detail_table, $hiring_detail);

				$bill_from = (isset($h_value['bill_from'])) ? $h_value['bill_from'] : '0000:00:00';
				$bill_to = (isset($h_value['bill_to'])) ? $h_value['bill_to'] : '0000:00:00';

				$data['success'] = 1;
				$data['msg'] 	= 'Bill generated for the date/payment '.$bill_from.' to '.$bill_to.'!';
				$redirect_url = 'admin.php?page=new_hiring&id='.$master_id.'&bill_id='.$hiring_bill_id;

				$data['redirect'] = network_admin_url( $redirect_url );
			}
		}

	}

	if($params['action'] == 'update_billing' && isset($params['bill_id'])) {

		$hiring_bill_id = $params['bill_id'];

		$wpdb->update($hiring_table, $hiring_data, array('id' => $hiring_bill_id));
		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $hiring_bill_id, 'detail' => 'hiring_update' ));

		$wpdb->update($hiring_detail_table, array('active' => 0), array('hiring_bill_id' => $hiring_bill_id) );


		if($hiring_bill_id && $params['hiring_detail']) {
			foreach ($params['hiring_detail'] as $h_value) {
				$hiring_detail = array(
					'hiring_bill_id' 		=> $hiring_bill_id,
					'delivery_detail_id' 	=> (isset($h_value['delivery_detail_id'])) ? $h_value['delivery_detail_id'] : 0,
					'lot_id'				=> (isset($h_value['lot_id'])) ? $h_value['lot_id'] : 0,
					'qty'					=> (isset($h_value['qty'])) ? $h_value['qty'] : 0,
					'bill_from'				=> (isset($h_value['bill_from'])) ? $h_value['bill_from'] : '0000:00:00',
					'bill_to'				=> (isset($h_value['bill_to'])) ? $h_value['bill_to'] : '0000:00:00',
					'bill_days'				=> (isset($h_value['bill_days'])) ? $h_value['bill_days'] : 0,
					'delivery_date'			=> (isset($h_value['delivery_date'])) ? $h_value['delivery_date'] : '0000:00:00',
					'total_days'			=> (isset($h_value['total_days'])) ? $h_value['total_days'] : 0,
					'rate_per_day'			=> (isset($h_value['rate_per_day'])) ? $h_value['rate_per_day'] : 0.00,
					'amount'				=> (isset($h_value['amount'])) ? $h_value['amount'] : 0.00,
					'got_return'			=> (isset($h_value['got_return'])) ? $h_value['got_return'] : 0,
					'min_checkbox_avail'	=> (isset($h_value['min_checkbox_avail'])) ? $h_value['min_checkbox_avail'] : 0,
					'min_checked'			=> (isset($h_value['min_checked'])) ? 1 : 0,
					'hiring_amt'			=> (isset($h_value['hiring_amt'])) ? $h_value['hiring_amt'] : 0.00,
					'hiring_amt_min'		=> (isset($h_value['hiring_amt_min'])) ? $h_value['hiring_amt_min'] : 0.00,
					'for_thirty_days'		=> (isset($h_value['for_thirty_days'])) ? $h_value['for_thirty_days'] : 0.00,
					'previous_paid'			=> (isset($h_value['previous_paid'])) ? $h_value['previous_paid'] : 0.00,
					'bal_to_pay'			=> (isset($h_value['bal_to_pay'])) ? $h_value['bal_to_pay'] : 0.00,
					);

				$wpdb->insert($hiring_detail_table, $hiring_detail);

				$bill_from = (isset($h_value['bill_from'])) ? $h_value['bill_from'] : '0000:00:00';
				$bill_to = (isset($h_value['bill_to'])) ? $h_value['bill_to'] : '0000:00:00';

				$data['success'] = 1;
				$data['msg'] 	= 'Bill Updated for the date/payment '.$bill_from.' to '.$bill_to.'!';
				$redirect_url = 'admin.php?page=new_hiring&id='.$master_id.'&bill_id='.$hiring_bill_id;

				$data['redirect'] = network_admin_url( $redirect_url );

			}
		}
	}


	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_create_billing', 'create_billing' );
add_action( 'wp_ajax_nopriv_create_billing', 'create_billing' );


function getHiringBillData($master_id = 0, $bill_id = 0) {
	$hiring_bill = new Hiring();
	return $hiring_bill->get_BillHiringData($master_id, $bill_id);
}


function getExistBillData($master_id = 0, $bill_from = '', $bill_to = '') {
	$data['msg'] 	= 'Something Went Wrong! Please Try Again!';
	$data['redirect'] 	= 0;
	$data['success'] = 0;

	global $wpdb;
	$params = array();
	$hiring_table = $wpdb->prefix.'shc_hiring';

	$query = "SELECT * FROM ${hiring_table} WHERE active = 1 AND DATE(bill_from) = DATE('${bill_from}') AND DATE(bill_to) = DATE('${bill_to}') AND master_id = ${master_id}";
	$hiring_bill= $wpdb->get_row($query);

	return $hiring_bill;
}

?>