<?php
require get_template_directory() . '/admin/report/obc/class-obc-list.php';

function load_obc_list_scripts() {
	wp_enqueue_script( 'obc_list', get_template_directory_uri() . '/admin/report/inc/js/obc.js', array('jquery'), false, false );
}
add_action( 'admin_enqueue_scripts', 'load_obc_list_scripts' );

function obc_filter() {
	$obclist = new ObcList();
	include( get_template_directory().'/admin/report/obc/ajax_loading/list.php' );
	die();
}
add_action( 'wp_ajax_obc_filter', 'obc_filter' );
add_action( 'wp_ajax_nopriv_obc_filter', 'obc_filter' );

?>