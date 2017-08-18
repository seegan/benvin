<?php
require get_template_directory() . '/admin/report/hiring/class-hiring-list.php';

function load_hiring_list_scripts() {
	wp_enqueue_script( 'hiring_list', get_template_directory_uri() . '/admin/report/inc/js/hiring.js', array('jquery'), false, false );
}
add_action( 'admin_enqueue_scripts', 'load_hiring_list_scripts' );


function hiring_filter() {
	$hiringlist = new HiringList();
	include( get_template_directory().'/admin/report/hiring/ajax_loading/list.php' );
	die();
}
add_action( 'wp_ajax_hiring_filter', 'hiring_filter' );
add_action( 'wp_ajax_nopriv_hiring_filter', 'hiring_filter' );

?>