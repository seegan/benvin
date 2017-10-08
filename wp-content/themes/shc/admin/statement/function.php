<?php
require get_template_directory() . '/admin/statement/class-statement.php';

function load_statement_scripts() {
	if( (is_admin() ) && (isset($_GET['page'])) && ( $_GET['page'] == 'new_statement' ) ) {
		wp_enqueue_script( 'statement-script', get_template_directory_uri() . '/admin/inc/js/statement.js', array('jquery'), false, false );
	}
}
add_action( 'admin_enqueue_scripts', 'load_statement_scripts' );


function getAccountStatement($master_id = 0, $date_to = '0000-00-00', $sd = 1) {
	$statement = new Statement();
	return $statement->get_AccountStatement($master_id, $date_to, $sd);
}

function getLostStatement($master_id = 0, $date_to = '0000-00-00') {
	$lost_data = new Statement();
	return $lost_data->get_LostStatement($master_id, $date_to);
}

function getDamageStatement($master_id = 0, $date_to = '0000-00-00') {
	$lost_data = new Statement();
	return $lost_data->get_DamageStatement($master_id, $date_to);
}
?>