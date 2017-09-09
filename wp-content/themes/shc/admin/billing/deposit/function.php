<?php
require get_template_directory() . '/admin/billing/deposit/class-deposit.php';

function load_deposit_scripts() {
	wp_enqueue_script( 'deposit-script', get_template_directory_uri() . '/admin/billing/inc/js/deposit.js', array('jquery'), false, false );

	if( (is_admin() ) && (isset($_GET['page'])) && ( $_GET['page'] == 'deposit' ) ) {
		wp_enqueue_script( 'deposit-script-dub', get_template_directory_uri() . '/admin/billing/inc/js/deposit-dub.js', array('jquery'), false, false );
	}
}
add_action( 'admin_enqueue_scripts', 'load_deposit_scripts' );

function getDepositDetail($deposit_id = '') {
	global $wpdb;
	$deposit_table = $wpdb->prefix.'shc_deposit';
	$deposit_detail = $wpdb->prefix.'shc_deposit_detail';
	$lots_table = $wpdb->prefix.'shc_lots';

	$query = "SELECT * FROM ${deposit_table} WHERE active = 1 AND id = ${deposit_id}";


	$data['deposit_data'] = $wpdb->get_row($query);


	$detail_query = "SELECT f.*, l.lot_no, l.product_name, l.product_type FROM ( SELECT dd.* FROM ${deposit_table} as d JOIN ${deposit_detail} as dd ON d.id = dd.deposit_id WHERE d.active = 1 AND dd.active = 1 AND dd.deposit_id = ${deposit_id} ) as f JOIN ${lots_table} as l ON l.id = f.lot_id";
	
	$data['deposit_detail'] = $wpdb->get_results($detail_query);

	$invoice_query = "SELECT mf.*, c.name, c.mobile, c.address, cs.site_name, cs.site_address, cs.phone_number, cs.gst_number, cs.gst_for, comp.company_id, comp.company_name  FROM ( SELECT d.bill_from_comp, d.bill_no, d.master_id,d.amt_times, d.total_thirty_days, d.total_ninety_days, d.deposit_date, d.created_at, d.modified_at, d.active, m.customer_id, m.site_id, dc.cheque_no, dc.cheque_date, dc.cheque_amount FROM wp_shc_deposit as d JOIN wp_shc_master as m ON d.master_id = m.id JOIN wp_shc_deposit_cheque as dc ON dc.deposit_id = d.id WHERE d.id = ${deposit_id} ) as mf JOIN wp_shc_customers as c ON mf.customer_id = c.id JOIN wp_shc_customer_site as cs ON mf.site_id = cs.id JOIN wp_shc_companies as comp ON mf.bill_from_comp = comp.id";

	$data['invoice_data'] = $wpdb->get_row($invoice_query);


	return $data;
}


function getDepositChequeData($deposit_id = '') {
	global $wpdb;
	$cheque_table = $wpdb->prefix.'shc_deposit_cheque';
	$query = "SELECT * FROM ${cheque_table} WHERE active = 1 AND deposit_id = ${deposit_id}";
	$data['cheque_data'] = $wpdb->get_results($query);
	return $data;
}

function getLoadingData($deposit_id = 0, $key='') {
	$return = new Deposit();
	return $return->get_LoadingData($deposit_id, $key);
}



function get_lot_data(){
	$lot_id = $_POST['search_key'];

	$data['success'] = 0;
	global $wpdb;
	$lots_table = $wpdb->prefix.'shc_lots';
	$special_table = $wpdb->prefix.'shc_special_price';

	$cond = "";
	if(isset($_POST['site_id']) && $_POST['site_id'] && $_POST['site_id'] != 0 ) {
		$cond .= " AND ( (sp.site_id = ".$_POST['site_id']." OR sp.site_id = 0 ) AND sp.customer_id = ".$_POST['customer_id']." )";
	} else if(isset($_POST['customer_id']) && $_POST['customer_id'] && $_POST['customer_id'] != 0 ) {
		$cond .= " AND sp.customer_id = ".$_POST['customer_id']. " AND sp.site_id = 0";
	} else {
		$cond .= "no";
	}

	if($cond != 'no') {
		$query = "SELECT f.id, f.lot_no, f.product_name, f.product_type, f.tax1, 

		(
		    CASE
		        WHEN f.special_price is NULL
		        THEN f.unit_price
		        ELSE f.special_price
		    END
		) as unit_price

		FROM 

		(
		    SELECT *, 
		    (
		        SELECT sp.price FROM ${special_table} sp WHERE sp.lot_id = l.id AND sp.active = 1 ${cond} ORDER BY sp.id DESC LIMIT 1

		    ) as special_price

		    FROM ${lots_table} l WHERE ( lot_no LIKE '${lot_id}%' OR product_name LIKE '${lot_id}%' ) AND active = 1
		) as f";
	} else {
		$query = "SELECT * FROM ${lots_table} WHERE ( lot_no LIKE '${lot_id}%' OR product_name LIKE '${lot_id}%' ) AND active = 1";
	}


	if( $data['items'] = $wpdb->get_results( $query, ARRAY_A ) ) {
		$data['success'] = 1;
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_get_lot_data', 'get_lot_data' );
add_action( 'wp_ajax_nopriv_get_lot_data', 'get_lot_data' );

function create_deposit() {
	global $wpdb;
	$data['msg'] 	= 'Something Went Wrong! Please Try Again!';
	$data['redirect'] 	= 0;
	$data['success'] = 0;
	$loggdin_user = get_current_user_id();	
	$params = array();
	parse_str($_POST['data'], $params);

	$deposit_table = $wpdb->prefix.'shc_deposit';
	$deposit_detail_table = $wpdb->prefix.'shc_deposit_detail';
	$cheque_table = $wpdb->prefix.'shc_deposit_cheque'; 
	$loading_table = $wpdb->prefix.'shc_loading'; 
	$loading_detail_table = $wpdb->prefix.'shc_loading_detail'; 

	$deposit_date = $params['date'].' '.$params['time'].':00';
	$financial_year = getFinancialYear( $params['date'] );

	//$bill_detail = getBillDetail( $params['customer_id'], 'deposit');

	$loading = (isset($params['loading']) && $params['loading'] != '') ? $params['loading'] : 0.00;
	$transportation = (isset($params['transportation']) && $params['transportation'] != '') ? $params['transportation'] : 0.00;
	$loading_total = (isset($params['loading_total']) && $params['loading_total'] != '') ? $params['loading_total'] : 0.00;

	$detail_main = array(
		'financial_year' => $financial_year,
		'ref_number' => $params['ref_number'],
		'master_id' => $params['master_id'],
		'customer_id' => $params['customer_id'],
		'site_id' => $params['site_id'],
		'total_thirty_days' => $params['for_thirty_days'],
		'total_ninety_days' => $params['for_ninety_days'],
		'deposit_date' 	=> $deposit_date,
		'amt_times' => $params['amt_times'],
		'discount_avail' => $params['discount_avail'],
		'discount_percentage' => $params['discount_percentage'],
		'discount_amt' => $params['discount_amt'],
		'total' => $params['total'],
	);

	if(isset($params['action']) && $params['action'] != 'update_deposit') {

		$bill_no_data = getCorrectBillNumber($params['bill_no'], $params['site_id'], 'shc_deposit', $params['date']);

		$detail_main['bill_from_comp'] = $bill_no_data['bill_from_comp'];
		$detail_main['bill_no'] = $bill_no_data['bill_no'];
		$detail_main['updated_by'] = $loggdin_user;
		
		$wpdb->insert($deposit_table, $detail_main);
		$deposit_id = $wpdb->insert_id;
		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $deposit_id, 'detail' => 'deposit_create' ));


		$wpdb->insert($loading_table, array('deposit_id' => $deposit_id, 'master_id' => $params['master_id'], 'loading_charge' => $loading_total, 'deposit_date' => $deposit_date ) );
		$loading_id = $wpdb->insert_id;

		$wpdb->insert($loading_detail_table, array('deposit_id' => $deposit_id, 'loading_id' => $loading_id, 'charge_for' => 'loading', 'charge_amt' => $loading ) );
		$wpdb->insert($loading_detail_table, array('deposit_id' => $deposit_id, 'loading_id' => $loading_id, 'charge_for' => 'transportation', 'charge_amt' => $transportation ) );

	} else {

		$deposit_id = isset($params['deposit_id']) ? $params['deposit_id'] : 0;
		$wpdb->update($deposit_table, $detail_main, array('id' => $deposit_id));

		create_admin_history(array('updated_by' => $loggdin_user, 'update_in' => $deposit_id, 'detail' => 'deposit_update' ));

		$loadin_update_select = "SELECT * FROM ${loading_table} WHERE deposit_id = ${deposit_id} AND master_id = ".$params['master_id'];
		
		if($wpdb->get_row($loadin_update_select)) {
			$wpdb->update($loading_table, array('loading_charge' => $loading_total, 'deposit_date' => $deposit_date, 'active' => 1 ), array('deposit_id' => $deposit_id, 'master_id' => $params['master_id']) );

			$wpdb->update($loading_detail_table, array( 'charge_amt' => $loading, 'active' => 1 ), array('deposit_id' => $deposit_id, 'charge_for' => 'loading') );
			$wpdb->update($loading_detail_table, array( 'charge_amt' => $transportation, 'active' => 1 ), array('deposit_id' => $deposit_id, 'charge_for' => 'transportation') );
		} else {
			$wpdb->insert($loading_table, array('deposit_id' => $deposit_id, 'master_id' => $params['master_id'], 'loading_charge' => $loading_total, 'deposit_date' => $deposit_date ) );
			$loading_id = $wpdb->insert_id;

			$wpdb->insert($loading_detail_table, array('deposit_id' => $deposit_id, 'loading_id' => $loading_id, 'charge_for' => 'loading', 'charge_amt' => $loading ) );
			$wpdb->insert($loading_detail_table, array('deposit_id' => $deposit_id, 'loading_id' => $loading_id, 'charge_for' => 'transportation', 'charge_amt' => $transportation ) );
		}

	}


	$wpdb->update($deposit_detail_table, array('active' => 0), array('deposit_id' => $deposit_id));
	$wpdb->update($cheque_table, array('active' => 0), array('deposit_id' => $deposit_id));

	if($deposit_id) {

		if(isset($params['cheque_detail'])) {
			foreach($params['cheque_detail'] as $cd_value) {
				if(isset($cd_value['cheque_amt']) AND $cd_value['cheque_amt'] != '') {
					$cheque_data = array(
						'master_id' => $params['master_id'],
						'deposit_id' => $deposit_id,
						'cheque_no' => $cd_value['cheque_no'],
						'cheque_date' => $cd_value['cheque_date'],
						'cheque_amount' => $cd_value['cheque_amt'],
						'active' 		=> 1
						);

					if($cd_value['cheque_detail_id'] != 0) {
						$wpdb->update($cheque_table, $cheque_data, array('id' => $cd_value['cheque_detail_id'], 'deposit_id' => $deposit_id));
					} else {
						$wpdb->insert($cheque_table, $cheque_data);
					}

				}
			}
		}


		if( isset($params['deposit_detail']) ) {
			foreach($params['deposit_detail'] as $d_value) {
				if(isset($d_value['lot_id_orig']) AND $d_value['lot_id_orig'] != 0) {

					$detail_data = array(
						'deposit_id' 	=> $deposit_id,
						'lot_id' 		=> $d_value['lot_id_orig'],
						'qty' 			=> $d_value['qty'],
						'unit_price' 	=> $d_value['unit_price'],
						'rate_thirty' 	=> $d_value['thirty_rs_price'],
						'rate_ninety' 	=> $d_value['ninety_rs_price'],
						'active' 		=> 1
						);

					if($d_value['sale_detail_id'] != 0) {
						$wpdb->update($deposit_detail_table, $detail_data, array('id' => $d_value['sale_detail_id'], 'deposit_id' => $deposit_id));
					} else {
						$wpdb->insert($deposit_detail_table, $detail_data);
					}
				}
			}
		}



		$data['success'] = 1;
		$data['msg'] 	= 'Deposit Updated!';
		$redirect_url = 'admin.php?page=deposit&id='.$params['master_id'].'&deposit_id='.$deposit_id;
		$data['redirect'] = network_admin_url( $redirect_url );
		//$data['redirect'] = 0;
	}
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_create_deposit', 'create_deposit' );
add_action( 'wp_ajax_nopriv_create_deposit', 'create_deposit' );
?>