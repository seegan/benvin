<?php
require get_template_directory() . '/admin/customer/class-customer.php';

function load_customer_scripts() {
	wp_enqueue_script( 'customer-script', get_template_directory_uri() . '/admin/customer/inc/js/customer.js', array('jquery'), false, false );
}
add_action( 'admin_enqueue_scripts', 'load_customer_scripts' );


function get_customer($customer_id = 0) {
    global $wpdb;
    $customer_table =  $wpdb->prefix.'shc_customers';
    $query = "SELECT * FROM ${customer_table} WHERE id = ${customer_id}";
    return $wpdb->get_row($query);
}

function getCompanies()
{
	global $wpdb;
	$companies_table = $wpdb->prefix.'shc_companies';
    $query = "SELECT * FROM ${companies_table} WHERE active = 1";
    return $wpdb->get_results($query);
}

function create_customer() {
	$data['success'] 	= 0;
	$data['msg'] 	= 'Something Went Wrong! Please Try Again!';
	$data['redirect'] 	= 0;
	$loggdin_user = get_current_user_id();

	global $wpdb;
	$params = array();
	parse_str($_POST['data'], $params);
	unset($params['action']);

	$customer_table = $wpdb->prefix. 'shc_customers';
	$params['updated_by'] = $loggdin_user;
	$wpdb->insert($customer_table, $params);

	if($wpdb->insert_id) {
		$customer_id = $wpdb->insert_id;
		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $customer_id, 'detail' => 'customer_create' ));

		$data['success'] = 1;
		$data['msg'] 	= 'Customer Added!';
		$redirect_url = "admin.php?page=new_customer&id=${customer_id}";
		$data['redirect'] = network_admin_url($redirect_url);
	}
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_create_customer', 'create_customer' );
add_action( 'wp_ajax_nopriv_create_customer', 'create_customer' );



function update_customer() {
	$data['success'] 	= 0;
	$data['msg'] = 'Invalid Customer Please Check Again!';
	$data['redirect'] 	= 0;
	$loggdin_user = get_current_user_id();

	global $wpdb;
	$params = array();
	parse_str($_POST['data'], $params);
	$customer_id = $params['customer_id'];

	unset($params['action']);
	unset($params['customer_id']);


	if(get_customer($customer_id)) {


		$customer_table = $wpdb->prefix. 'shc_customers';
		$wpdb->update($customer_table, $params, array('id' => $customer_id));
		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $customer_id, 'detail' => 'customer_update' ));

		$data['success'] = 1;
		$data['msg'] = 'Customer Detail Updated!';
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_update_customer', 'update_customer' );
add_action( 'wp_ajax_nopriv_update_customer', 'update_customer' );




function create_site() {
	$data['success'] 	= 0;
	$data['msg'] = 'Invalid Try Again!';
	$data['redirect'] 	= 0;
	$loggdin_user = get_current_user_id();

	global $wpdb;
	$site_table = $wpdb->prefix.'shc_customer_site';
	$special_price = $wpdb->prefix.'shc_special_price';

	$params = array();
	parse_str($_POST['data'], $params);

	$customer_id = $params['customer_id'];


	//$wpdb->update($site_table, array('active' => 0), array('customer_id' => $customer_id) );
	if(isset($params['site_address']) ) {
		foreach ($params['site_address'] as $s_value) {

			if($s_value['site_id'] == 0) {
				$wpdb->insert($site_table, array('customer_id' => $customer_id, 'site_name' => $s_value['site_name'], 'site_address' => $s_value['site_address'], 'phone_number' => $s_value['site_phone'], 'extra_contact' => $s_value['extra_contact'], 'gst_number' => $s_value['gst_number'] , 'gst_for' => $s_value['gst_for'], 'updated_by' => $loggdin_user ));
				$site_id = $wpdb->insert_id;
				create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $site_id, 'detail' => 'site_create' ));

			} else {
				$wpdb->update($site_table, array( 'site_address' => $s_value['site_address'], 'site_name' => $s_value['site_name'], 'phone_number' => $s_value['site_phone'],'extra_contact' => $s_value['extra_contact'], 'gst_number' => $s_value['gst_number'] , 'gst_for' => $s_value['gst_for'], 'active' => 1), array('id' => $s_value['site_id']));
				create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $s_value['site_id'], 'detail' => 'site_update' ));
			}

		}
	}


	$wpdb->update($special_price, array('active' => 0), array('customer_id' => $customer_id) );
	if(isset($params['special_price']) ) {
		foreach ($params['special_price'] as $p_value) {

			$site_id = ($p_value['site_id'] && $p_value['site_id']) ? $p_value['site_id'] : 0;

			if($p_value['special_price_id'] == 0) {
				$wpdb->insert($special_price, array('customer_id' => $customer_id, 'site_id' => $site_id, 'lot_id' => $p_value['lot_id_orig'], 'price' => $p_value['unit_price'], 'updated_by' => $loggdin_user));
				$special_price_id = $wpdb->insert_id;
				create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $special_price_id, 'detail' => 'special_price_create' ));
			} else {
				$wpdb->update($special_price, array('customer_id' => $customer_id, 'site_id' => $site_id, 'lot_id' => $p_value['lot_id_orig'], 'price' => $p_value['unit_price'], 'active' => 1), array('id' => $p_value['special_price_id']));
			}

		}
	}



	$data['msg'] = 'Site Updated!';
	$data['success'] 	= 1;
	$redirect_url = "admin.php?page=new_customer&id=${customer_id}";
	$data['redirect'] = network_admin_url($redirect_url);


	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_create_site', 'create_site' );
add_action( 'wp_ajax_nopriv_create_site', 'create_site' );


function getSitedetail($customer_id = 0) {
	global $wpdb;
	$site_table = $wpdb->prefix.'shc_customer_site';

	$query = "SELECT * FROM ${site_table} WHERE active = 1 AND customer_id = ${customer_id}";
	return $wpdb->get_results($query);
}

function getSpecialPrice($customer_id = 0) {
	global $wpdb;
	$special_price_table = $wpdb->prefix.'shc_special_price';
	$lots_table = $wpdb->prefix.'shc_lots';

	$query = "SELECT sp.id,sp.customer_id,sp.site_id,sp.lot_id,sp.price, l.product_name, l.product_type FROM ${special_price_table} as sp JOIN ${lots_table} as l ON sp.lot_id = l.id WHERE sp.customer_id = ${customer_id} AND sp.active = 1 ORDER BY sp.site_id ASC";

	return $wpdb->get_results($query);
}


function customer_filter() {
	$customer = new Customer();
	include( get_template_directory().'/admin/customer/ajax_loading/customer-list.php' );
	die();
}
add_action( 'wp_ajax_customer_filter', 'customer_filter' );
add_action( 'wp_ajax_nopriv_customer_filter', 'customer_filter' );


function get_customers() {
	$customer = new Customer();

	if( $data['items'] = $customer->customerSearch($_POST['search_key']) ) {
		$data['success'] = 1;
	}
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_get_customers', 'get_customers' );
add_action( 'wp_ajax_nopriv_get_customers', 'get_customers' );


function get_site_data() {
	$customer = new Customer();

	if( $data['items'] = $customer->siteSearch($_POST['search_key'], $_POST['customer_id']) ) {
		$data['success'] = 1;
	}
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_get_site_data', 'get_site_data' );
add_action( 'wp_ajax_nopriv_get_site_data', 'get_site_data' );


function getCustomerData($customer_id = 0) {
	$customer = new Customer();
	return $customer->get_CustomerData($customer_id);
}

function getSiteData($site_id = 0, $bill_for = false ) {
	$customer = new Customer();
	return $customer->get_SiteData($site_id, $bill_for);
}