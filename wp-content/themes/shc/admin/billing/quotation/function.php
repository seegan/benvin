<?php
require get_template_directory() . '/admin/billing/quotation/class-quotation.php';

function load_quotation_scripts() {
	wp_enqueue_script( 'quotation-script', get_template_directory_uri() . '/admin/billing/inc/js/quotation.js', array('jquery'), false, false );

	if( (is_admin() ) && (isset($_GET['page'])) && ( $_GET['page'] == 'new_quotation' ) ) {
		wp_enqueue_style( 'richtext-editor', get_template_directory_uri() . '/admin/billing/inc/css/richtext.min.css' );

		wp_enqueue_script( 'quotation-script-dub', get_template_directory_uri() . '/admin/billing/inc/js/quotation-dub.js', array('jquery'), false, false );
		wp_enqueue_script( 'richtext-editor', get_template_directory_uri() . '/admin/billing/inc/js/jquery.richtext.js', array('jquery'), false, false );
	}
}
add_action( 'admin_enqueue_scripts', 'load_quotation_scripts' );




function create_quotation() {
	global $wpdb;
	$data['msg'] 	= 'Something Went Wrong! Please Try Again!';
	$data['redirect'] 	= 0;
	$data['success'] = 0;
	$loggdin_user = get_current_user_id();	
	$params = array();
	parse_str($_POST['data'], $params);

	$quotation_table = $wpdb->prefix.'shc_quotation';
	$quotation_detail_table = $wpdb->prefix.'shc_quotation_detail';

	$quotation_date = $params['date'].' '.$params['time'].':00';
	$financial_year = getFinancialYear( $params['date'] );


	//$bill_detail = getBillDetail( $params['customer_id'], 'quotation');


	$detail_main = array(
		'financial_year' => $financial_year,
		'ref_number' => isset($params['ref_number']) ? $params['ref_number'] : '',
		'master_id' => isset($params['master_id']) ? $params['master_id'] : 0,
		'customer_id' => isset($params['customer_id']) ? $params['customer_id'] : 0,
		'site_id' => isset($params['site_id']) ? $params['site_id'] : 0,
		'quotation_date' 	=> isset($quotation_date) ? $quotation_date : '0000-00-00',
		'sub_total' => isset($params['sub_total']) ? $params['sub_total'] : 0.00,
		'discount_avail' => isset($params['hiring_discount_avail']) ? $params['hiring_discount_avail'] : 'no',
		'discount_percentage' => isset($params['discount_percentage']) ? $params['discount_percentage'] : 0.00,
		'discount_amt' => isset($params['discount_amt']) ? $params['discount_amt'] : 0.00,
		'after_discount_amt' => isset($params['after_discount_amt']) ? $params['after_discount_amt'] : 0.00,
		'tax_from' => isset($params['tax_from']) ? $params['tax_from'] : 'gst',
		'gst_for' => isset($params['gst_for']) ? $params['gst_for'] : 'cgst',
		'igst_amt' => isset($params['gst_igst']) ? $params['gst_igst'] : 0.00,
		'cgst_amt' => isset($params['gst_cgst']) ? $params['gst_cgst'] : 0.00,
		'sgst_amt' => isset($params['gst_sgst']) ? $params['gst_sgst'] : 0.00,
		'vat_amt' => isset($params['vat_amt']) ? $params['vat_amt'] : 0.00,
		'tax_include_tot' => isset($params['total_include_tax_amt']) ? $params['total_include_tax_amt'] : 0.00,
		'round_off' => $params['round_off'],
		'hiring_total' => (isset($params['hiring_discount_avail']) && $params['hiring_discount_avail'] == 'yes') ? $params['after_discount_amt'] : $params['sub_total'],
		'for_thirty_days' => isset($params['hiring_tot']) ? $params['hiring_tot'] : 0.00,
		'requirements' => isset($params['quotation_txt']) ? $params['quotation_txt'] : 0.00,
		'amount_payable' => isset($params['amount_payable']) ? $params['amount_payable'] : 0.00,
	);



	if(isset($params['action']) && $params['action'] == 'create_quotation') {

		$bill_no_data = getCorrectBillNumber($params['bill_no'], $params['site_id'], 'shc_quotatio', $params['date']);

		$detail_main['bill_from_comp'] = $bill_no_data['bill_from_comp'];
		$detail_main['bill_no'] = $bill_no_data['bill_no'];
		$detail_main['updated_by'] = $loggdin_user;

		$wpdb->insert($quotation_table, $detail_main);
		$quotation_id = $wpdb->insert_id;

		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $quotation_id, 'detail' => 'quotation_create' ));

	} else {

		$quotation_id = isset($params['quotation_id']) ? $params['quotation_id'] : 0;
		$wpdb->update($quotation_table, $detail_main, array('id' => $quotation_id));

		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $quotation_id, 'detail' => 'quotation_update' ));

	}


	$wpdb->update($quotation_detail_table, array('active' => 0), array('quotation_id' => $quotation_id));

	if($quotation_id) {

		if( isset($params['quotation_detail']) ) {
			foreach($params['quotation_detail'] as $d_value) {
				if(isset($d_value['lot_id_orig']) AND $d_value['lot_id_orig'] != 0) {

					$detail_data = array(
						'quotation_id' 	=> $quotation_id,
						'lot_id' 		=> $d_value['lot_id_orig'],
						'qty' 			=> $d_value['qty'],
						'unit_price' 	=> $d_value['unit_price'],
						'rate_thirty' 	=> $d_value['thirty_rs_price'],
						'rate_ninety' 	=> $d_value['ninety_rs_price'],
						'active' 		=> 1
						);

					if($d_value['quotation_detail_id'] != 0) {
						$wpdb->update($quotation_detail_table, $detail_data, array('id' => $d_value['quotation_detail_id'], 'quotation_id' => $quotation_id));
					} else {
						$wpdb->insert($quotation_detail_table, $detail_data);
					}
				}
			}
		}

		$data['success'] = 1;
		$data['msg'] 	= 'Quotation Updated!';
		$redirect_url = 'admin.php?page=new_quotation&id='.$params['master_id'].'&quotation_id='.$quotation_id;
		$data['redirect'] = network_admin_url( $redirect_url );
		//$data['redirect'] = 0;
	}
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_create_quotation', 'create_quotation' );
add_action( 'wp_ajax_nopriv_create_quotation', 'create_quotation' );

function getQutationDetail($quotation_id = '') {
	global $wpdb;
	$quotation_table = $wpdb->prefix.'shc_quotation';
	$quotation_detail = $wpdb->prefix.'shc_quotation_detail';
	$lots_table = $wpdb->prefix.'shc_lots';

	$query = "SELECT * FROM ${quotation_table} WHERE active = 1 AND id = ${quotation_id}";

	$data['quotation_data'] = $wpdb->get_row($query);

	$detail_query = "SELECT f.*, l.lot_no, l.product_name, l.product_type FROM ( SELECT qd.* FROM ${quotation_table} as q JOIN ${quotation_detail} as qd ON q.id = qd.quotation_id WHERE q.active = 1 AND qd.active = 1 AND qd.quotation_id = ${quotation_id} ) as f JOIN ${lots_table} as l ON l.id = f.lot_id";
	$data['quotation_detail'] = $wpdb->get_results($detail_query);

	return $data;
}



?>