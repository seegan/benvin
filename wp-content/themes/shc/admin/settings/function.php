<?php
require get_template_directory() . '/admin/settings/class-settings.php';


function load_settings_scripts() {
	wp_enqueue_script( 'settings-script', get_template_directory_uri() . '/admin/settings/inc/js/settings.js', array('jquery'), false, false );
}
add_action( 'admin_enqueue_scripts', 'load_settings_scripts' );

function update_bank() {

	$data['success'] 	= 0;
	$data['msg'] 	= 'Something Went Wrong! Please Try Again!';
	$data['redirect'] 	= 0;

	global $wpdb;
	$params = array();
	parse_str($_POST['data'], $params);
	unset($params['action']);
	$bank_table = $wpdb->prefix. 'shc_banks';

	$wpdb->update($bank_table, array('active' => 0), array('active' => 1));

	if(isset($params['bank_data']) && count($params['bank_data']) > 0 ) {
		foreach ($params['bank_data'] as $b_data) {

			$update_data = array('bank_name' => $b_data['bank_name'], 'company_id' => $b_data['bill_from_comp'] , 'bank_detail' => $b_data['account_details'], 'active' => 1);
			if($b_data['bank_id'] != 0) {
				$wpdb->update($bank_table, $update_data, array('id' => $b_data['bank_id']));
			} else {
				$update_data['id'] = getToken($bank_table, 'BNK');
				$wpdb->insert($bank_table, $update_data);
			}
		}
	}
	$wpdb->delete($bank_table, array('active' => 0));

	$data['success'] = 1;
	$data['msg'] 	= 'Banks Added!';
	$redirect_url = "admin.php?page=admin_settings";
	$data['redirect'] = network_admin_url($redirect_url);
	echo json_encode($data);

	die();
}
add_action( 'wp_ajax_update_bank', 'update_bank' );
add_action( 'wp_ajax_nopriv_update_bank', 'update_bank' );


function getBanksByCompanyId($company_id = ''  ) {
	$settings = new Settings();
	return $settings->getBankData($company_id);
}
