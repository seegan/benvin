<?php
require get_template_directory() . '/admin/employee/class-employee.php';

function load_employee_scripts() {
	wp_enqueue_script( 'lot-script', get_template_directory_uri() . '/admin/employee/inc/js/employee.js', array('jquery'), false, false );
}
add_action( 'admin_enqueue_scripts', 'load_employee_scripts' );
?>