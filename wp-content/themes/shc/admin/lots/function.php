<?php
require get_template_directory() . '/admin/lots/class-lots.php';

function load_lot_scripts() {
	wp_enqueue_script( 'lot-script', get_template_directory_uri() . '/admin/lots/inc/js/lot.js', array('jquery'), false, false );
}
add_action( 'admin_enqueue_scripts', 'load_lot_scripts' );


function get_lot($lot_id = 0) {
    global $wpdb;
    $lot_table =  $wpdb->prefix.'shc_lots';
    $query = "SELECT * FROM ${lot_table} WHERE id = ${lot_id}";
    return $wpdb->get_row($query);
}


/*Ajax Functions*/
function create_lot(){


	$data['success'] 	= 0;
	$data['msg'] 	= 'Something Went Wrong Please Try Again!';
	$data['redirect'] 	= 0;
	$loggdin_user = get_current_user_id();

	global $wpdb;
	$params = array();
	parse_str($_POST['data'], $params);
	unset($params['action']);
	$lot_table = $wpdb->prefix. 'shc_lots';
	$params['updated_by'] = $loggdin_user;

	$wpdb->insert($lot_table, $params);
	$lot_id = $wpdb->insert_id;

	create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $lot_id, 'detail' => 'lot_create' ));

	if($wpdb->insert_id) {
		$data['success'] = 1;
		$data['msg'] 	= 'Lot Created!';
		$data['redirect'] = network_admin_url( 'admin.php?page=list_lots' );
	}
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_create_lot', 'create_lot' );
add_action( 'wp_ajax_nopriv_create_lot', 'create_lot' );

function update_lot(){

	$data['success'] 	= 0;
	$data['msg'] 	= 'Product Not Exist Please Try Again!';
	$data['redirect'] 	= 0;
	$loggdin_user = get_current_user_id();

	global $wpdb;
	$params = array();
	parse_str($_POST['data'], $params);
	$lot_id = $params['lot_id'];

	unset($params['action']);
	unset($params['lot_id']);

	$lot_table = $wpdb->prefix. 'shc_lots';
	if($lot_id != '' && get_lot($lot_id)) {
		$wpdb->update($lot_table, $params, array('id' => $lot_id));
		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $lot_id, 'detail' => 'lot_update' ));
		$data['success'] = 1;
		$data['msg'] 	= 'Lot Updated!';
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_update_lot', 'update_lot' );
add_action( 'wp_ajax_nopriv_update_lot', 'update_lot' );



function lot_filter() {
	$lots = new Lots();
	include( get_template_directory().'/admin/lots/ajax_loading/lot-list.php' );
	die();	
}
add_action( 'wp_ajax_lot_filter', 'lot_filter' );
add_action( 'wp_ajax_nopriv_lot_filter', 'lot_filter' );





function without_special_price_lot($value='')
{
	$lot_id = $_POST['search_key'];

	$data['success'] = 0;
	global $wpdb;
	$lots_table = $wpdb->prefix.'shc_lots';
	$query = "SELECT id, lot_no, product_name, product_type, tax1, unit_price, minimum_bill_day FROM ${lots_table} l WHERE ( lot_no LIKE '${lot_id}%' OR product_name LIKE '${lot_id}%' )";

	if( $data['items'] = $wpdb->get_results( $query, ARRAY_A ) ) {
		$data['success'] = 1;
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_without_special_price_lot', 'without_special_price_lot' );
add_action( 'wp_ajax_nopriv_without_special_price_lot', 'without_special_price_lot' );


?>