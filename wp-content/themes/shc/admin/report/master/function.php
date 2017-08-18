<?php
require get_template_directory() . '/admin/report/master/class-master-list.php';

function load_master_list_scripts() {
	wp_enqueue_script( 'master_list', get_template_directory_uri() . '/admin/report/inc/js/master.js', array('jquery'), false, false );
}
add_action( 'admin_enqueue_scripts', 'load_master_list_scripts' );


function master_filter() {
	$masterlist = new MasterList();
	include( get_template_directory().'/admin/report/master/ajax_loading/list.php' );
	die();
}
add_action( 'wp_ajax_master_filter', 'master_filter' );
add_action( 'wp_ajax_nopriv_master_filter', 'master_filter' );

?>