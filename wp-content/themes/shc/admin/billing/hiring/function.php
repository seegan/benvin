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

	$query = "SELECT d.id, cs.site_name, cs.phone_number, cs.site_address, c.name  FROM ${master_table} as d JOIN ${customers_table} as c ON d.customer_id = c.id JOIN ${site_table} as cs ON d.site_id = cs.id WHERE ( c.name LIKE '%${search}%' OR cs.site_name LIKE '%${search}%' OR cs.phone_number LIKE '${search}%' OR cs.site_address LIKE '${search}%' OR d.id = '${search}' ) ";

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
		'ref_number' => isset($params['ref_number']) ? $params['ref_number'] : '',
		'financial_year_proforma' => getFinancialYear( $params['billing_date'] ),
		'master_id' => isset($params['master_id']) ? $params['master_id'] : 0,
		'bill_from' => isset($params['master_id']) ? $params['bill_from'] : '0000:00:00',
		'bill_to'  => isset($params['master_id']) ? $params['bill_to'] : '0000:00:00',
		/*$params['transport_return_id']*/
		'return_ids' => isset($params['master_id']) ? '' : '',
		'transportation_charge' => isset($params['master_id']) ? $params['del_chrg'] : 0.00,
		'damage_charge' => isset($params['master_id']) ? $params['dmg_chrg'] : 0.00,
		'lost_charge' => isset($params['master_id']) ? $params['lost_chrg'] : 0.00,
		'sub_tot' => isset($params['sub_tot']) ? $params['sub_tot'] : 0.00,

		'discount_avail' => isset($params['hiring_discount_avail']) ? $params['hiring_discount_avail'] : 'no',
		'discount_percentage' => isset($params['discount_percentage']) ? $params['discount_percentage'] : 0.00,
		'discount_amount' => isset($params['discount_amt']) ? $params['discount_amt'] : 0.00,
		'total_after_discount' =>  isset($params['after_discount_amt']) ? $params['after_discount_amt'] : $params['sub_tot'],

		'total_before_tax' => isset($params['after_discount_amt']) ? $params['total_before_tax_amt'] : 0.00,

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
		'payment_date' => isset($params['master_id']) ? $params['billing_date'] : '0000:00:00',
	);

	if($params['action'] == 'create_billing') {
		
		$bill_no_data = getCorrectBillNumber($params['bill_no'], $params['site_id'], 'shc_hiring', $params['billing_date'], 'proforma_no', 'financial_year_proforma');

		$hiring_data['bill_from_comp'] = $bill_no_data['bill_from_comp'];
		$hiring_data['proforma_no'] = $bill_no_data['bill_no'];

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
		
		$hiring_data['proforma_no'] = $params['update_current_bill'];

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



	$gst_data['hiring_gst'] = array('hiring_id' => $hiring_bill_id ,'hsn_code' => '4545', 'hsn_name' => 'hiring', 'taxable_value' => $params['after_discount_amt'], 'cgst_val' => $params['hire_charge_cgst'], 'sgst_val' => $params['hire_charge_sgst'], 'igst_val' => $params['hire_charge_igst'] );
	$gst_data['transport_gst'] = array('hiring_id' => $hiring_bill_id ,'hsn_code' => '-', 'hsn_name' => 'transport', 'taxable_value' => $params['del_chrg'], 'cgst_val' => $params['delivery_charge_cgst'], 'sgst_val' => $params['delivery_charge_sgst'], 'igst_val' => $params['delivery_charge_igst'] );
	$gst_data['damage_gst'] = array('hiring_id' => $hiring_bill_id ,'hsn_code' => '-', 'hsn_name' => 'damage', 'taxable_value' => $params['dmg_chrg'], 'cgst_val' => $params['damage_charge_cgst'], 'sgst_val' => $params['damage_charge_sgst'], 'igst_val' => $params['damage_charge_igst'] );
	$gst_data['lost_gst'] = array('hiring_id' => $hiring_bill_id ,'hsn_code' =>'-', 'hsn_name' =>  'lost', 'taxable_value' => $params['lost_chrg'], 'cgst_val' => $params['lost_charge_cgst'], 'sgst_val' => $params['lost_charge_sgst'], 'igst_val' => $params['lost_charge_igst'] );

	$csgst_total = $params['hire_charge_cgst'] + $params['delivery_charge_cgst'] + $params['damage_charge_cgst'] + $params['lost_charge_cgst'];
	$igst_total = $params['hire_charge_igst'] + $params['delivery_charge_igst'] + $params['damage_charge_igst'] + $params['lost_charge_igst'];


	$gst_data['total_gst'] = array('hiring_id' => $hiring_bill_id ,'hsn_code' =>'Total', 'hsn_name' =>  'total', 'taxable_value' => $params['total_before_tax_amt'], 'cgst_val' => $csgst_total, 'sgst_val' => $csgst_total, 'igst_val' => $igst_total );

	$wpdb->delete( 'wp_shc_hiring_gst', array( 'hiring_id' => $hiring_bill_id ) );

	foreach ($gst_data as $gst_value) {
		$wpdb->insert('wp_shc_hiring_gst', $gst_value);
	}



	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_create_billing', 'create_billing' );
add_action( 'wp_ajax_nopriv_create_billing', 'create_billing' );


function bill_status_update() {
	global $wpdb;
	$hiring_table = $wpdb->prefix.'shc_hiring';
	$loggdin_user = get_current_user_id();
	$bill_id = isset($_POST['bill_id']) ? $_POST['bill_id'] : 0;
	$payment_date = isset($_POST['payment_date']) ? $_POST['payment_date'] : date('Y-m-d');
	$siteid = isset($_POST['siteid']) ? $_POST['siteid'] : 0;
	$status = isset($_POST['status']) ? $_POST['status'] : 1;

	$existing_query = "SELECT bill_no FROM $hiring_table WHERE id = $bill_id AND bill_no != 0 AND financial_year = ".getFinancialYear( $payment_date );

	$duplicate_query = "SELECT bill_no FROM $hiring_table  WHERE bill_no = ($existing_query) AND financial_year = ".getFinancialYear( $payment_date )." AND id != $bill_id";

	$existing = $wpdb->get_row($existing_query);
	$duplicate = $wpdb->get_row($duplicate_query);

	$bill_no = (isset($existing->bill_no) && !isset($duplicate->bill_no)) ? $existing->bill_no : getNextBillNumber(0, $siteid, 'shc_hiring', $payment_date, 'bill_no', 'financial_year');

	if( $status == "2") {
		$wpdb->update($hiring_table, array('bill_no' =>$bill_no, 'financial_year' => getFinancialYear( $payment_date ), 'bill_status' => $status, 'payment_date' => $payment_date ), array('id' => $bill_id));
	} else {
		$wpdb->update($hiring_table, array('bill_status' => $status), array('id' => $bill_id));
	}


	$bill_status_txt = 'bill_status_'.$_POST['status'];
	create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $_POST['bill_id'], 'detail' => $bill_status_txt ));

	die();
}
add_action( 'wp_ajax_bill_status_update', 'bill_status_update' );
add_action( 'wp_ajax_nopriv_bill_status_update', 'bill_status_update' );



function getHiringBillData($master_id = 0, $bill_id = 0) {
	$hiring_bill = new Hiring();
	return $hiring_bill->get_BillHiringData($master_id, $bill_id);
}

function getHiringBillDataPrint( $bill_id = 0) {
	$hiring_bill = new Hiring();
	return $hiring_bill->get_BillHiringDataPrint($bill_id);
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