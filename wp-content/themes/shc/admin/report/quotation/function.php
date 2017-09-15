<?php
require get_template_directory() . '/admin/report/quotation/class-quotation-list.php';

function load_quotation_list_scripts() {
	wp_enqueue_script( 'quotation_list', get_template_directory_uri() . '/admin/report/inc/js/quotation.js', array('jquery'), false, false );

}
add_action( 'admin_enqueue_scripts', 'load_quotation_list_scripts' );



function quotation_filter() {
	$quotationlist = new QuotationList();
	include( get_template_directory().'/admin/report/quotation/ajax_loading/list.php' );
	die();
}
add_action( 'wp_ajax_quotation_filter', 'quotation_filter' );
add_action( 'wp_ajax_nopriv_quotation_filter', 'quotation_filter' );

?>