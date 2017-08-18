<?php
require get_template_directory() . '/admin/report/delivery/class-delivery-list.php';

function load_delivery_list_scripts() {
	wp_enqueue_script( 'delivery_list', get_template_directory_uri() . '/admin/report/inc/js/delivery.js', array('jquery'), false, false );
}
add_action( 'admin_enqueue_scripts', 'load_delivery_list_scripts' );

function delivery_filter() {
	$deliverylist = new DeliveryList();
	include( get_template_directory().'/admin/report/delivery/ajax_loading/list.php' );
	die();
}
add_action( 'wp_ajax_delivery_filter', 'delivery_filter' );
add_action( 'wp_ajax_nopriv_delivery_filter', 'delivery_filter' );

?>