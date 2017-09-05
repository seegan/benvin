<?php
require get_template_directory() . '/admin/employee/class-employee.php';

function load_employee_scripts() {
	wp_enqueue_script( 'employee-script', get_template_directory_uri() . '/admin/employee/inc/js/employee.js', array('jquery'), false, false );
}
add_action( 'admin_enqueue_scripts', 'load_employee_scripts' );



function create_employee(){


	$data['success'] 	= 0;
	$data['msg'] 	= 'Something Went Wrong! Please Try Again!';
	$data['redirect'] 	= 0;
	$loggdin_user = get_current_user_id();

	global $wpdb;
	$params = array();
	parse_str($_POST['data'], $params);
	unset($params['action']);

	$employees_table = $wpdb->prefix. 'shc_employees';
	$params['updated_by'] = $loggdin_user;
	$wpdb->insert($employees_table, $params);

	if($wpdb->insert_id) {
		$employee_id = $wpdb->insert_id;
		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $employee_id, 'detail' => 'employee_create' ));

		$data['success'] = 1;
		$data['msg'] 	= 'Employee Added!';
		$redirect_url = "admin.php?page=new_employee&id=${employee_id}";
		$data['redirect'] = network_admin_url($redirect_url);
	}
	echo json_encode($data);
	die();

}
add_action( 'wp_ajax_create_employee', 'create_employee' );
add_action( 'wp_ajax_nopriv_create_employee', 'create_employee' );


function update_employee(){

	$data['success'] 	= 0;
	$data['msg'] 	= 'Product Not Exist Please Try Again!';
	$data['redirect'] 	= 0;
	$loggdin_user = get_current_user_id();

	global $wpdb;
	$params = array();
	parse_str($_POST['data'], $params);
	$employee_id = $params['employee_id'];

	unset($params['action']);
	unset($params['employee_id']);

	$employee_table = $wpdb->prefix. 'shc_employees';
	if($employee_id != '' && get_employee($employee_id)) {
		$wpdb->update($employee_table, $params, array('id' => $employee_id));
		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $employee_id, 'detail' => 'employee_update' ));
		$data['success'] = 1;
		$data['msg'] 	= 'Lot Updated!';
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_update_employee', 'update_employee' );
add_action( 'wp_ajax_nopriv_update_employee', 'update_employee' );


function get_employee($employee_id = 0) {
    global $wpdb;
    $employees_table =  $wpdb->prefix.'shc_employees';
    $query = "SELECT * FROM ${employees_table} WHERE id = ${employee_id}";
    return $wpdb->get_row($query);
}


function employee_filter() {
	$employee = new Employee();
	include( get_template_directory().'/admin/employee/ajax_loading/employee-list.php' );
	die();
}
add_action( 'wp_ajax_employee_filter', 'employee_filter' );
add_action( 'wp_ajax_nopriv_employee_filter', 'employee_filter' );

?>