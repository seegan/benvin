<?php
add_action('admin_menu', 'admin_menu_register');
function admin_menu_register(){


global $src_capabilities;


	add_menu_page(
	    __( 'Customers', 'shc'),
	    'Customers',
	    $src_capabilities['customers']['permission']['customer_list'],
	    'customer_list',
	    'customer_list',
	    'dashicons-id',
	    4
	);
	add_submenu_page('customer_list', 'Customer List', 'Customer List', $src_capabilities['customers']['permission']['customer_list'], 'customer_list', 'customer_list' );
	add_submenu_page('customer_list', 'New Customer', 'New Customer', $src_capabilities['customers']['permission']['add_customer'], 'new_customer', 'new_customer' );

	add_menu_page(
	    __( 'Products', 'shc'),
	    'Products',
	    $src_capabilities['lots']['permission']['lot_list'],
	    'list_lots',
	    'list_lots',
	    'dashicons-images-alt',
	    5
	);
	add_submenu_page('list_lots', 'Products List', 'Product List', $src_capabilities['lots']['permission']['lot_list'], 'list_lots', 'list_lots' );
	add_submenu_page('list_lots', 'Add Product', 'Add Product', $src_capabilities['lots']['permission']['add_lot'], 'add_lot', 'add_lot' );



	add_menu_page(
	    __( 'Stock', 'shc'),
	    'Stock',
	    $src_capabilities['stocks']['permission']['stock_list'],
	    'list_stocks',
	    'list_stocks',
	    'dashicons-list-view',
	    6
	);
	add_submenu_page('list_stocks', 'Stock List', 'Stock List', $src_capabilities['stocks']['permission']['stock_list'], 'list_stocks', 'list_stocks' );
	add_submenu_page('list_stocks', 'Add Stock', 'Add Stock', $src_capabilities['stocks']['permission']['add_stock'], 'add_stocks', 'add_stocks' );


	add_menu_page(
	    __( 'Billing', 'shc'),
	    'Billing',
	    $src_capabilities['billing']['permission']['deposit'],
	    'master',
	    'master',
	    'dashicons-id',
	    7
	);
	add_submenu_page('master', 'New Master', 'New Master', $src_capabilities['billing']['permission']['deposit'], 'master', 'master' );
	add_submenu_page('master', 'New Deposit', 'Deposit', $src_capabilities['billing']['permission']['deposit'], 'deposit', 'new_deposit' );
	add_submenu_page('master', 'New Delivery', 'Delivery', $src_capabilities['billing']['permission']['deposit'], 'new_delivery', 'new_delivery' );
	add_submenu_page('master', 'New Return', 'Return', $src_capabilities['billing']['permission']['deposit'], 'new_return', 'new_return' );
	add_submenu_page('master', 'New Hiring', 'Hiring Bill', $src_capabilities['billing']['permission']['deposit'], 'new_hiring', 'new_hiring' );
	add_submenu_page('master', 'New OBC', 'OBC', $src_capabilities['billing']['permission']['deposit'], 'new_obc', 'new_obc' );


	add_menu_page(
	    __( 'Report', 'shc'),
	    'Report',
	    $src_capabilities['billing']['permission']['deposit'],
	    'master_report',
	    'master_report',
	    'dashicons-id',
	    7
	);
	add_submenu_page('master_report', 'Master List', 'Master List', $src_capabilities['billing']['permission']['deposit'], 'master_report', 'master_report' );
	add_submenu_page('master_report', 'Deposit List', 'Deposit List', $src_capabilities['billing']['permission']['deposit'], 'deposit_report', 'deposit_report' );
	add_submenu_page('master_report', 'Delivery List', 'Delivery List', $src_capabilities['billing']['permission']['deposit'], 'delivery_report', 'delivery_report' );
	add_submenu_page('master_report', 'Return List', 'Return List', $src_capabilities['billing']['permission']['deposit'], 'return_report', 'return_report' );
	add_submenu_page('master_report', 'Hiring List', 'Hiring List', $src_capabilities['billing']['permission']['deposit'], 'hiring_report', 'hiring_report' );
	add_submenu_page('master_report', 'OBC List', 'OBC List', $src_capabilities['billing']['permission']['deposit'], 'obc_report', 'obc_report' );



	add_menu_page(
	    __( 'Admin Users', 'src'),
	    'Admins',
	    $src_capabilities['admin_user']['permission']['add_admin'],
	    'admin_users',
	    'add_admin',
	    'dashicons-businessman',
	    8
	);
	add_submenu_page('admin_users', 'New Admin User', 'New Admin User', $src_capabilities['admin_user']['permission']['add_admin'], 'add_admin', 'add_admin' );
	add_submenu_page('admin_users', 'Admin Users List', 'Admin Users List', $src_capabilities['admin_user']['permission']['admin_list'], 'list_admin_users', 'list_admin_users' );

	add_menu_page(
	    __( 'Admin Roles', 'src'),
	    'Roles',
	    $src_capabilities['roles']['permission']['add_roles'],
	    'user_roles',
	    'add_role',
	    'dashicons-awards',
	    9
	);
	add_submenu_page('user_roles', 'New Role', 'New Role', $src_capabilities['roles']['permission']['add_roles'], 'add_admin_role', 'add_admin_role' );
	add_submenu_page('user_roles', 'Role List', 'Role List', $src_capabilities['roles']['permission']['role_list'], 'list_roles', 'list_roles' );
}


function list_lots() {
	require 'lots/listing/lot-list.php';
}
function add_lot() {
    require 'lots/add-lot.php';
}
function list_stocks() {
	require 'stocks/listing/stock-list.php';
}
function add_stocks() {
	require 'stocks/add-stock.php';
}


function customer_list() {
	require 'customer/listing/customer-list.php';
}
function new_customer() {
	require 'customer/add-customer.php';
}




function add_admin() {
    require 'users/add-admin.php';
}
function list_admin_users() {
    require 'users/listing/user-list.php';
}

function add_admin_role() {
    require 'roles/add-role.php';
}
function list_roles() {
    require 'roles/listing/role-list.php';
}




function master() {
    require 'billing/master/add-master.php';
}
function new_deposit() {
    require 'billing/deposit/add-deposit.php';
}
function new_delivery() {
    require 'billing/delivery/new-delivery.php';
}
function new_return() {
    require 'billing/return/new-return.php';
}
function new_hiring() {
    require 'billing/hiring/new-hiring.php';
}
function new_obc() {
    require 'billing/obc/new-obc.php';
}


function master_report() {
    require 'report/master/list.php';
}
function deposit_report() {
    require 'report/deposit/list.php';
}
function delivery_report() {
    require 'report/delivery/list.php';
}
function return_report() {
    require 'report/return/list.php';
}
function hiring_report() {
    require 'report/hiring/list.php';
}
function obc_report() {
    require 'report/obc/list.php';
}

?>