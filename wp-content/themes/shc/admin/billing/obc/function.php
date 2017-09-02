<?php
require get_template_directory() . '/admin/billing/obc/class-obc.php';

function load_obc_scripts() {
	wp_enqueue_script( 'obc-script', get_template_directory_uri() . '/admin/billing/inc/js/obc.js', array('jquery'), false, false );
	if( (is_admin() ) && (isset($_GET['page'])) && ( $_GET['page'] == 'new_obc' ) ) {
		wp_enqueue_script( 'obc-script-dub', get_template_directory_uri() . '/admin/billing/inc/js/obc-dub.js', array('jquery'), false, false );
	}
}
add_action( 'admin_enqueue_scripts', 'load_obc_scripts' );

function getObcData($return_id = 0, $master_id = 0) {
	$return = new Obc();
	return $return->get_ObcData($return_id, $master_id);
}


function create_obc() {
	global $wpdb;
	$data['msg'] 	= 'Something Went Wrong! Please Try Again!';
	$data['redirect'] 	= 0;
	$data['success'] = 0;
	$loggdin_user = get_current_user_id();

	$params = array();
	parse_str($_POST['data'], $params);

	$obc_table 		= $wpdb->prefix.'shc_obc_cheque';

	$master_id = $params['master_id'];

	$obc_date = (isset($params['obc_date']) && $params['obc_date'] != '') ? $params['obc_date'] : '000-00-00';
	$obc_time = (isset($params['obc_time']) && $params['obc_time'] != '') ? $params['time'].':00' : '00:00:00';
	$obc_date_time = $obc_date.' '.$obc_time;

	$obc_id = (isset($params['obc_id']) && $params['obc_id'] != '') ? $params['obc_id'] : 0;
	$cheque_no = (isset($params['cheque_no']) && $params['cheque_no'] != '') ? $params['cheque_no'] : 0;
	$cheque_date = (isset($params['cheque_date']) && $params['cheque_date'] != '') ? $params['cheque_date'] : '0000-00-00';
	$cheque_amt = (isset($params['cheque_amt']) && $params['cheque_amt'] != '') ? $params['cheque_amt'] : 0.00;
	$notes = (isset($params['obc_notes']) && $params['obc_notes'] != '') ? $params['obc_notes'] : '';



	if(isset($params['action']) && $params['action'] == 'create_obc') {

		$wpdb->insert($obc_table, array('master_id' => $master_id, 'cheque_no' => $cheque_no, 'cheque_date' => $cheque_date, 'cheque_amount' => $cheque_amt, 'notes' => $notes, 'obc_date' => $obc_date_time, 'updated_by' => $loggdin_user ) );
		$obc_id = $wpdb->insert_id;
		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $obc_id, 'detail' => 'obc_create' ));

		$data['success'] = 1;
		$data['msg'] 	= 'OBC Updated!';
		$redirect_url = 'admin.php?page=new_obc&id='.$master_id.'&obc_id='.$obc_id;
		$data['redirect'] = network_admin_url( $redirect_url );
	}


	if(isset($params['action']) && $params['action'] == 'update_obc') {

		$wpdb->update($obc_table, array( 'cheque_no' => $cheque_no, 'cheque_date' => $cheque_date, 'cheque_amount' => $cheque_amt, 'notes' => $notes, 'obc_date' => $obc_date_time ), array('master_id' => $master_id, 'id' => $obc_id) );
		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $obc_id, 'detail' => 'obc_update' ));

		$data['success'] = 1;
		$data['msg'] 	= 'OBC Updated!';
		$redirect_url = 'admin.php?page=new_obc&id='.$master_id.'&obc_id='.$obc_id;
		$data['redirect'] = network_admin_url( $redirect_url );
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_create_obc', 'create_obc' );
add_action( 'wp_ajax_nopriv_create_obc', 'create_obc' );


?>