<?php
require get_template_directory() . '/admin/roles/class-roles.php';

function load_roles_scripts() {
	wp_enqueue_script( 'roles-script', get_template_directory_uri() . '/admin/roles/inc/js/roles.js', array('jquery'), false, false );
}
add_action( 'admin_enqueue_scripts', 'load_roles_scripts' );

function src_global_var() {
    global $src_capabilities;
	$src_capabilities = array( 
  
		'lots' => array(
			'name' => 'Products',
			'data' => array(
				'add_lot' => 'Add Product',
				'lot_list' => 'Product List', 
			),
			'permission' => array(
				'add_lot' => (is_super_admin()) ? 'manage_options' : 'add_lot',
				'lot_list' => (is_super_admin()) ? 'manage_options' : 'lot_list', 
			),
		),
		'stocks' => array(
			'name' => 'Stocks',
			'data' => array(
				'add_stock' => 'Add Stock',
				'stock_list' => 'Stock List', 
				'stock_data' => 'Stock Data', 
			),
			'permission' => array(
				'add_stock' => (is_super_admin()) ? 'manage_options' : 'add_stock',
				'stock_list' => (is_super_admin()) ? 'manage_options' : 'stock_list', 
			),			
		),
		'customers' => array(
			'name' => 'Customers',
			'data' => array(
				'add_customer' => 'Add Customer',
				'customer_list' => 'Customer List', 
			),
			'permission' => array(
				'add_customer' => (is_super_admin()) ? 'manage_options' : 'add_customer',
				'customer_list' => (is_super_admin()) ? 'manage_options' : 'customer_list', 
			),			
		),
		'billing' => array(
			'name' => 'Billing',
			'data' => array(
				'new_master' => 'Create Master',
				'new_deposit' => 'Create Deposit',
				'new_delivery' => 'Create Delivery',
				'new_return' => 'Create Return',
				'new_bill' => 'Create Hiring Bill',
				'new_obc' => 'Create OBC',
			),
			'permission' => array(
				'new_master' => (is_super_admin()) ? 'manage_options' : 'new_master',
				'new_deposit' => (is_super_admin()) ? 'manage_options' : 'new_deposit',
				'new_delivery' => (is_super_admin()) ? 'manage_options' : 'new_delivery',
				'new_return' => (is_super_admin()) ? 'manage_options' : 'new_return',
				'new_bill' => (is_super_admin()) ? 'manage_options' : 'new_bill',
				'new_obc' => (is_super_admin()) ? 'manage_options' : 'new_obc',
			),			
		),
		'report' => array(
			'name' => 'Report',
			'data' => array(
				'master_report' => 'Master Report',
				'deposit_report' => 'Deposit Report',
				'delivery_report' => 'Delivery Report',
				'return_report' => 'Return Report',
				'bill_report' => 'Hiring bill Report',
				'obc_report' => 'OBC Report',
			),
			'permission' => array(
				'master_report' => (is_super_admin()) ? 'manage_options' : 'master_report',
				'deposit_report' => (is_super_admin()) ? 'manage_options' : 'deposit_report',
				'delivery_report' => (is_super_admin()) ? 'manage_options' : 'delivery_report',
				'return_report' => (is_super_admin()) ? 'manage_options' : 'return_report',
				'bill_report' => (is_super_admin()) ? 'manage_options' : 'bill_report',
				'obc_report' => (is_super_admin()) ? 'manage_options' : 'obc_report',
			),			
		),
		'admin_user' => array(
			'name' => 'Admin Users',
			'data' => array(
				'add_admin' => 'Add New Admin', 
				'admin_list' => 'Admin List',
			),
			'permission' => array(
				'add_admin' => (is_super_admin()) ? 'manage_options' : 'add_admin',
				'admin_list' => (is_super_admin()) ? 'manage_options' : 'admin_list', 
			),			
		),
		'roles' => array(
			'name' => 'Admin Roles',
			'data' => array(
				'add_roles' => 'Add New Role', 
				'role_list' => 'Role List', 
			),
			'permission' => array(
				'add_roles' => (is_super_admin()) ? 'manage_options' : 'add_roles',
				'role_list' => (is_super_admin()) ? 'manage_options' : 'role_list', 
			),			

		),
		'Employee' => array(
			'name' => 'Employee',
			'data' => array(
				'add_employee' => 'Add Employee', 
				'list_employee' => 'Employee List', 
				'employee_attendance' => 'Employee Attendance', 
				'employee_salary' => 'Employee Salary', 
			),
			'permission' => array(
				'add_employee' => (is_super_admin()) ? 'manage_options' : 'add_employee',
				'list_employee' => (is_super_admin()) ? 'manage_options' : 'list_employee', 
				'employee_attendance' => (is_super_admin()) ? 'manage_options' : 'employee_attendance', 
				'employee_salary' => (is_super_admin()) ? 'manage_options' : 'employee_salary', 
			),			

		),
	);

}
add_action( 'init', 'src_global_var' );


function create_roles() {
	$data['success'] 	= 0;
	$data['msg'] 	= 'Something Went Wrong Please Try Again!';
	$data['redirect'] 	= 0;

	global $src_capabilities;
	$params = array();
	parse_str($_POST['data'], $params);


	$role_name 	=  	$params['role_name'];
	$role_slug 	= 	$params['role_slug'];

	$grant_true		= true;
	$grant_false 	= false;	

	foreach ($params['main_menu'] as $cap_value) {
		if($src_capabilities[$cap_value]) {

			if(is_array($src_capabilities[$cap_value])) {
				foreach ($src_capabilities[$cap_value]['data'] as $cap_key => $c_value) {
					$capabilities[] = $cap_key;
				}
			} else {
				$capabilities[] = $cap_value;
			}
		} else {
			$capabilities[] = $cap_value;
		}
	}
	$new_cap = array_unique($capabilities); 
	$new_cap[] = 'read';


	$new_role = add_role( $role_slug, __( $role_name ) );
	if ( null !== $new_role ) {
		foreach ($new_cap as  $cap_value) {
			$new_role->add_cap( $cap_value, $grant_true );
		}
		$data['success'] = 1;
		$data['msg'] 	= 'Role Created!';
		$data['redirect'] = network_admin_url( 'admin.php?page=add_admin_role' );
	}


	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_create_roles', 'create_roles' );
add_action( 'wp_ajax_nopriv_create_roles', 'create_roles' );


function update_roles() {
	$data['success'] 	= 0;
	$data['msg'] 	= 'Role Not Exist Please Try Again!';
	$data['redirect'] 	= 0;

	global $src_capabilities;
	$params = array();
	parse_str($_POST['data'], $params);

	$current_cap = get_role($params['role_slug']);
	$editable_roles = get_editable_roles();


	$capabilities = array();

	if($params['main_menu']) {
		foreach ($params['main_menu'] as $cap_value) {
			if($src_capabilities[$cap_value]) {
				if(is_array($src_capabilities[$cap_value])) {
					foreach ($src_capabilities[$cap_value]['data'] as $cap_key => $c_value) {
						$capabilities[] = $cap_key;
					}
				} else {
					$capabilities[] = $cap_value;
				}
			} else {
				$capabilities[] = $cap_value;
			}
		}
	}


	$new_cap = array_unique($capabilities);  
	$new_cap[] = 'read';

	$new_fliped1 = array_flip($new_cap);
	$new_fliped2 = $current_cap->capabilities;

	$new_data 		= array_diff_key($new_fliped1, $new_fliped2);
	$delete_data 	= array_diff_key($new_fliped2, $new_fliped1);


	if( count($new_data) > 0) {
		foreach ($new_data as $n_key => $n_value) {
			$current_cap->add_cap( $n_key );
		}
	}
	if( count($delete_data) > 0) {
		foreach ($delete_data as $d_key => $d_value) {
			$current_cap->remove_cap( $d_key );
		}
	}

	$data['success'] = 1;
	$data['msg'] 	= 'Role Updated!';

	echo json_encode($data);
	die();

}
add_action( 'wp_ajax_update_roles', 'update_roles' );
add_action( 'wp_ajax_nopriv_update_roles', 'update_roles' );