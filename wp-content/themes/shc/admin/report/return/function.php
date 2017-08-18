<?php
require get_template_directory() . '/admin/report/return/class-return-list.php';

function load_return_list_scripts() {
	wp_enqueue_script( 'return_list', get_template_directory_uri() . '/admin/report/inc/js/return.js', array('jquery'), false, false );
}
add_action( 'admin_enqueue_scripts', 'load_return_list_scripts' );

function return_filter() {
	$returnlist = new ReturnList();
	include( get_template_directory().'/admin/report/return/ajax_loading/list.php' );
	die();
}
add_action( 'wp_ajax_return_filter', 'return_filter' );
add_action( 'wp_ajax_nopriv_return_filter', 'return_filter' );

?>