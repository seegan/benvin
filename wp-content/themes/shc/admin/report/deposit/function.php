<?php
require get_template_directory() . '/admin/report/deposit/class-deposit-list.php';

function load_deposit_list_scripts() {
	wp_enqueue_script( 'deposit_list', get_template_directory_uri() . '/admin/report/inc/js/deposit.js', array('jquery'), false, false );

}
add_action( 'admin_enqueue_scripts', 'load_deposit_list_scripts' );



function deposit_filter() {
	$depositlist = new DepositList();
	include( get_template_directory().'/admin/report/deposit/ajax_loading/list.php' );
	die();
}
add_action( 'wp_ajax_deposit_filter', 'deposit_filter' );
add_action( 'wp_ajax_nopriv_deposit_filter', 'deposit_filter' );

?>