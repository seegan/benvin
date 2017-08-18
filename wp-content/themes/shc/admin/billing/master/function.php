<?php
require get_template_directory() . '/admin/billing/master/class-master.php';

function load_master_scripts() {
	wp_enqueue_script( 'master-script', get_template_directory_uri() . '/admin/billing/inc/js/master.js', array('jquery'), false, false );

	if( (is_admin() ) && (isset($_GET['page'])) && ( $_GET['page'] == 'master' ) ) {
		wp_enqueue_script( 'master-script-dub', get_template_directory_uri() . '/admin/billing/inc/js/master-dub.js', array('jquery'), false, false );
	}
}
add_action( 'admin_enqueue_scripts', 'load_master_scripts' );


function create_master() {
	global $wpdb;
	$data['msg'] 	= 'Something Went Wrong! Please Try Again!';
	$data['redirect'] 	= 0;
	$data['success'] = 0;
	$params = array();
	parse_str($_POST['data'], $params);

	$master_table = $wpdb->prefix.'shc_master';


	$master_date = $params['date'].' '.$params['time'].':00';

	$detail_main = array(
			'customer_id' => $params['customer_name'],
			'site_id' => $params['site_name'],
			'master_date' 	=> $master_date
		);
	
	if(isset($params['action']) && $params['action'] != 'update_master') {
		$wpdb->insert($master_table, $detail_main);
		$master_id = $wpdb->insert_id;
	} else {
		$masterid = $params['master_id'];
		$wpdb->update($master_table, $detail_main, array('id' => $master_id));
	}

	$data['success'] = 1;
	$data['msg'] 	= 'Master Created!';
	$redirect_url = 'admin.php?page=master&id='.$master_id;
	$data['redirect'] = network_admin_url( $redirect_url );

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_create_master', 'create_master' );
add_action( 'wp_ajax_nopriv_create_master', 'create_master' );



function getMasterDetail($master_id = '') {
	global $wpdb;
	$master_table = $wpdb->prefix.'shc_master';
	$deposit_table = $wpdb->prefix.'shc_deposit';
	$deposit_detail = $wpdb->prefix.'shc_deposit_detail';
	$lots_table = $wpdb->prefix.'shc_lots';

	$query = "SELECT * FROM ${master_table} WHERE active = 1 AND id = ${master_id}";

	$data['master_data'] = $wpdb->get_row($query);

	return $data;
}
?>