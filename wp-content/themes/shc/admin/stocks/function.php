<?php
require get_template_directory() . '/admin/stocks/class-stocks.php';

function load_stock_scripts() {
	wp_enqueue_script( 'stock-script', get_template_directory_uri() . '/admin/stocks/inc/js/stock.js', array('jquery'), false, false );
}
add_action( 'admin_enqueue_scripts', 'load_stock_scripts' );


function get_stock($stock_id = 0) {	
	global $wpdb;
	$stock_table = $wpdb->prefix.'shc_stock';
	$lot_table = $wpdb->prefix. 'shc_lots';

	$query = "SELECT s.*, l.lot_no, l.product_name, l.product_type, l.unit_price FROM {$stock_table} as s JOIN ${lot_table} as l ON s.lot_number = l.id WHERE s.id = ${stock_id} AND s.active = 1";
	return $wpdb->get_row( $query );
}


/*Ajax Functions*/
function search_lot(){

	$data['success'] = 0;
	global $wpdb;
	$params = array();
	parse_str($_POST['data'], $params);
	$lot_table = $wpdb->prefix. 'shc_lots';

	$search_term = $_POST['search_key'];

	$query = "SELECT * FROM {$lot_table} WHERE lot_no like '%${search_term}%' AND active = 1";

	if( $data['items'] = $wpdb->get_results( $query, ARRAY_A ) ) {
		$data['success'] = 1;
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_search_lot', 'search_lot' );
add_action( 'wp_ajax_nopriv_search_lot', 'search_lot' );



function add_stock(){

	$data['success'] 	= 0;
	$data['msg'] 	= 'Something Went Wrong! Please Try Again!';
	$data['redirect'] 	= 0;

	global $wpdb;
	$stock_table = $wpdb->prefix. 'shc_stock';
	$lot_table = $wpdb->prefix. 'shc_lots';
	$params = array();
	parse_str($_POST['data'], $params);
	unset($params['action']);

	$lot_id = $params['lot_number'];
	$stock_count = $params['stock_count'];

	if($lot_id != '') {

		$wpdb->insert($stock_table, $params);
		if($wpdb->insert_id) {
			$data['success'] = 1;
			$data['msg'] 	= 'Stock Added!';
			$data['redirect'] = network_admin_url( 'admin.php?page=list_stocks' );
		}
		
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_add_stock', 'add_stock' );
add_action( 'wp_ajax_nopriv_add_stock', 'add_stock' );


function update_stock(){

	$data['success'] 	= 0;
	$data['msg'] = 'Invalid Stock Please check again!';
	$data['redirect'] 	= 0;

	global $wpdb;
	$stock_table = $wpdb->prefix. 'shc_stock';
	$params = array();
	parse_str($_POST['data'], $params);
	$stock_id = $params['stock_id'];

	unset($params['action']);
	unset($params['stock_id']);

	$lot_id = $params['lot_number'];
	$stock_count = $params['stock_count'];

	if($lot_id != '' && get_stock($stock_id)) {
		$wpdb->update($stock_table, $params, array('id' => $stock_id));
		$data['success'] = 1;
		$data['msg'] = 'Stock Updated Successfully!';
	}

	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_update_stock', 'update_stock' );
add_action( 'wp_ajax_nopriv_update_stock', 'update_stock' );


function stock_filter() {
	$stocks = new Stocks();
	include( get_template_directory().'/admin/stocks/ajax_loading/stock-list.php' );
	die();	
}
add_action( 'wp_ajax_stock_filter', 'stock_filter' );
add_action( 'wp_ajax_nopriv_stock_filter', 'stock_filter' );



function getStockClosingDetail() {
	global $wpdb;
	$stock_closing_table = $wpdb->prefix."shc_stock_closing";

	$query = "SELECT * FROM ${stock_closing_table} WHERE active = 1 ORDER BY modified_at DESC";
	return $wpdb->get_results($query);
}

function getPreviousStockClosingdate() {
	$closing_date = $_POST['stock_to'];
	$closing_data = getStockDates($closing_date);
	$data['closing_date'] = $closing_data->previous_stock_end;
	echo json_encode($data);
	die();	
}
add_action( 'wp_ajax_getPreviousStockClosingdate', 'getPreviousStockClosingdate' );
add_action( 'wp_ajax_nopriv_getPreviousStockClosingdate', 'getPreviousStockClosingdate' );

function getStockDates($update_till = '') {
	global $wpdb;
	$query = "SELECT 
		( CASE WHEN from_closing.previous_stock_end IS NULL THEN from_lot.stock_start_date ELSE from_closing.previous_stock_end  END) as previous_stock_end,
		( CASE WHEN from_closing.stock_start_date IS NULL THEN from_lot.stock_start_date ELSE from_closing.stock_start_date  END) as next_stock_from
		FROM 
		(
		SELECT date(l.created_at) as stock_start_date FROM wp_shc_lots as l ORDER BY l.created_at ASC LIMIT 1
		) as from_lot

		LEFT JOIN 

		(
		SELECT DATE_ADD(sc.closing_date, INTERVAL 1 DAY) as stock_start_date, sc.closing_date as previous_stock_end FROM wp_shc_stock_closing as sc WHERE sc.active = 1 AND date(sc.closing_date) < date('".$update_till."') ORDER BY sc.modified_at DESC LIMIT 1
		) as from_closing

		ON 1=1";

	if( $data = $wpdb->get_row( $query ) ) {
		return $data;
	}
	return FALSE;
}


function create_stock_closing() {
	global $wpdb;
	$stock_closing_table = $wpdb->prefix."shc_stock_closing";
	$stock_closing_detail_table = $wpdb->prefix."shc_stock_closing_detail";
	
	$closing_date = isset($_POST['closing_date']) ? $_POST['closing_date'] : date('Y-m-d');

	$closing_data = getStockDates($closing_date);
	$delete_from = $closing_data->next_stock_from;

	$stock_closing_delete_query = "DELETE FROM ${stock_closing_table} WHERE date(closing_stock) >=date('${delete_from}')";
	$stock_closing_detail_delete_query = "DELETE FROM ${stock_closing_detail_table} WHERE date(closing_stock) >=date('${delete_from}')";

	$wpdb->query($stock_closing_delete_query);
	$wpdb->query($stock_closing_detail_delete_query);

	$stocks_bal = getStockOnDate($closing_date);

	$wpdb->insert($stock_closing_table, array('closing_date' => $closing_date ));
	$closing_id = $wpdb->insert_id;


	if($stocks_bal) {
		foreach ($stocks_bal as $key => $s_value) {
			$wpdb->insert($stock_closing_detail_table, array('closing_id' => $closing_id, 'lot_id' => $s_value->id, 'closing_stock' => $s_value->new_stock, 'closing_date' => $closing_date  ));
		}
	}

	$data['success'] = 1;
	$data['msg'] 	= 'Closing Date Updated!';
	$redirect_url = "admin.php?page=stock_closing_settings";
	$data['redirect'] = network_admin_url($redirect_url);

	echo json_encode($data);
	die();

/*	$previous_closing_data = getStockDates($closing_date);
	$previous_closing_date 	= $previous_closing_data->previous_stock_end;

*/



}
add_action( 'wp_ajax_create_stock_closing', 'create_stock_closing' );
add_action( 'wp_ajax_nopriv_create_stock_closing', 'create_stock_closing' );


function getStockOnDate($closing_date = '') {

	global $wpdb;

	$previous_closing_data = getStockDates($closing_date);

	$previous_closing_date 	= $previous_closing_data->previous_stock_end;
	$opening_date 			= $previous_closing_data->next_stock_from;

	$opening_stocks = "SELECT closing_stock.lot_id, ( new_stock.new_stock_total + closing_stock.closing_total ) as total_stock FROM
	(
	    SELECT l.id as lot_id, (CASE WHEN stock_closing.closing_stock IS NULL THEN 0 ELSE stock_closing.closing_stock END) as closing_total  FROM wp_shc_lots as l LEFT JOIN ( SELECT c.id, cd.lot_id, cd.closing_stock FROM wp_shc_stock_closing as c LEFT JOIN wp_shc_stock_closing_detail as cd ON c.id = cd.closing_id WHERE c.active = 1 AND cd.active = 1 AND c.closing_date = date('${previous_closing_date}') ) as stock_closing ON l.id = stock_closing.lot_id     
	) as closing_stock 
	JOIN 
	( 
	    SELECT l.id as lot_id, (CASE WHEN stock.new_stock IS NULL THEN 0 ELSE stock.new_stock END) as new_stock_total FROM wp_shc_lots as l LEFT JOIN ( SELECT s.lot_number as lot_no, SUM(s.stock_count) as new_stock FROM wp_shc_stock as s WHERE s.active = 1 AND s.created_at >= date('${opening_date}') AND s.created_at <= date('${closing_date}')  GROUP BY s.lot_number ) as stock ON l.id = stock.lot_no 
	) as new_stock 
	ON 
	closing_stock.lot_id = new_stock.lot_id";

	$in_stock = "SELECT delivered.id as lot_id, (  returned.return_qty - delivered.delivery_qty  ) as in_stock FROM
	(
		SELECT l.id, (CASE WHEN delivery_data.delivery_qty IS NULL THEN 0 ELSE delivery_data.delivery_qty END ) as delivery_qty FROM wp_shc_lots as l LEFT JOIN ( SELECT dd.lot_id , SUM(dd.qty) as delivery_qty  FROM wp_shc_delivery as d JOIN wp_shc_delivery_detail as dd ON d.id = dd.delivery_id WHERE d.active = 1 AND date(d.delivery_date) >= date('${opening_date}') AND date(d.delivery_date) <= date('${closing_date}') AND dd.active = 1 GROUP BY dd.lot_id ) as delivery_data ON l.id = delivery_data.lot_id      
	) as delivered 
	JOIN 
	(
		SELECT l.id, (CASE WHEN return_data.return_qty IS NULL THEN 0 ELSE return_data.return_qty END ) as return_qty FROM wp_shc_lots as l LEFT JOIN ( SELECT rd.lot_id, SUM(rd.qty) as return_qty FROM wp_shc_return as r JOIN wp_shc_return_detail as rd ON r.id = rd.return_id WHERE r.active = 1 AND date(r.return_date) >= date('${opening_date}') AND date(r.return_date) <= date('${closing_date}') AND rd.active = 1 AND r.is_return = 1 GROUP BY rd.lot_id ) as return_data ON l.id = return_data.lot_id   
	) as returned 
	ON 
	delivered.id = returned.id";

	$stock_on_date_query = "SELECT l.id,  (old_stock.total_stock + stocks_in.in_stock) as new_stock FROM (${opening_stocks}) as old_stock JOIN (${in_stock}) as stocks_in ON old_stock.lot_id = stocks_in.lot_id JOIN wp_shc_lots as l ON stocks_in.lot_id = l.id ORDER BY l.id ASC";
	$stock_data = $wpdb->get_results($stock_on_date_query);

	return $stock_data;
}
?>