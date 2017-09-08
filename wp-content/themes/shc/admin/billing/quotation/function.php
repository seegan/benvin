<?php
require get_template_directory() . '/admin/billing/quotation/class-quotation.php';

function load_quotation_scripts() {
	wp_enqueue_script( 'quotation-script', get_template_directory_uri() . '/admin/billing/inc/js/quotation.js', array('jquery'), false, false );

	if( (is_admin() ) && (isset($_GET['page'])) && ( $_GET['page'] == 'new_quotation' ) ) {
		wp_enqueue_script( 'quotation-script-dub', get_template_directory_uri() . '/admin/billing/inc/js/quotation-dub.js', array('jquery'), false, false );
	}
}
add_action( 'admin_enqueue_scripts', 'load_quotation_scripts' );
?>