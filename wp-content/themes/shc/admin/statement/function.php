<?php
require get_template_directory() . '/admin/statement/class-statement.php';

function load_statement_scripts() {
	if( (is_admin() ) && (isset($_GET['page'])) && ( $_GET['page'] == 'new_statement' ) ) {
		wp_enqueue_script( 'statement-script', get_template_directory_uri() . '/admin/inc/js/statement.js', array('jquery'), false, false );
	}
}
add_action( 'admin_enqueue_scripts', 'load_statement_scripts' );

?>