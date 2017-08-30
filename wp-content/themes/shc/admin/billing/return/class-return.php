<?php
class BillReturn {

	function __construct() {
	    if( isset($_POST['action']) ) {
	    	$params = array();
			parse_str($_POST['data'], $params);
	        $this->cpage = 1;
	        $this->ppage = isset($params['ppage']) ? $params['ppage'] : 20;
	        $this->lot_no = isset($params['lot_no']) ? $params['lot_no'] : '';
	        $this->product_name = isset($params['product_name']) ? $params['product_name'] : '';
	        $this->product_type = isset($params['product_type']) ? $params['product_type'] : '';
	    } else {
	        $this->cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
	        $this->ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
	        $this->lot_no = isset( $_GET['lot_no'] ) ? $_GET['lot_no']  : '';
	        $this->product_name = isset( $_GET['product_name'] ) ? $_GET['product_name']  : '';
	        $this->product_type = isset( $_GET['product_type'] ) ? $_GET['product_type']  : '';
	    }
	}


	function get_PendingItems($master_id = 0, $return_date = '0000-00-00') {
		global $wpdb;
		$lots_table = $wpdb->prefix.'shc_lots';
		$delivery_table = $wpdb->prefix.'shc_delivery';
		$delivery_detail = $wpdb->prefix.'shc_delivery_detail';
		$return_table = $wpdb->prefix.'shc_return';
		$return_detail = $wpdb->prefix.'shc_return_detail';




/*( SELECT dd.* FROM ${delivery_detail} as dd JOIN ${delivery_table} as d ON d.id = dd.delivery_id  WHERE dd.master_id = ${master_id} AND dd.active = 1 AND d.active = 1 AND DATE(d.delivery_date) <= '${return_date}' ) as del

LEFT JOIN

(SELECT rd.delivery_detail_id, sum(rd.qty) tot_return FROM ${return_detail} as rd JOIN ${return_table} as r ON r.id= rd.return_id WHERE rd.master_id = ${master_id} AND rd.active = 1 AND r.active = 1 AND DATE(r.return_date) > '${return_date}' GROUP BY rd.delivery_detail_id) as ret

ON del.id = ret.delivery_detail_id WHERE */



	$return_query = "SELECT f.*, l.product_name, l.product_type FROM 

( SELECT del.*,

( case 
when ret.tot_return is NULL
THEN 0
ELSE ret.tot_return
END ) as return_qty,

(
    del.qty -
    ( case 
when ret.tot_return is NULL
THEN 0
ELSE ret.tot_return
END )
    
) as return_pending


FROM 

( SELECT dd.* FROM ${delivery_detail} as dd JOIN ${delivery_table} as d ON d.id = dd.delivery_id  WHERE dd.master_id = ${master_id} AND dd.active = 1 AND d.active = 1  ) as del

LEFT JOIN

(SELECT rd.delivery_detail_id, sum(rd.qty) tot_return FROM ${return_detail} as rd JOIN ${return_table} as r ON r.id= rd.return_id WHERE rd.master_id = ${master_id} AND rd.active = 1 AND r.active = 1 GROUP BY rd.delivery_detail_id) as ret

ON del.id = ret.delivery_detail_id WHERE 



(
    del.qty -
    ( case 
when ret.tot_return is NULL
THEN 0
ELSE ret.tot_return
END )
    
) > 0 ) as f JOIN ${lots_table} as l ON l.id = f.lot_id ORDER BY f.lot_id ASC, f.delivery_date ASC";
//var_dump($return_query); die();



$return_group = "SELECT f.lot_id, SUM(f.qty) as qty, f.rate_per_unit, SUM(f.return_qty) as return_qty, SUM(f.return_pending) as return_pending, l.product_name, l.product_type, l.buying_price FROM 


( SELECT del.*,

( case 
when ret.tot_return is NULL
THEN 0
ELSE ret.tot_return
END ) as return_qty,

(
    del.qty -
    ( case 
when ret.tot_return is NULL
THEN 0
ELSE ret.tot_return
END )
    
) as return_pending



FROM 

( SELECT dd.* FROM ${delivery_detail} as dd JOIN ${delivery_table} as d ON d.id = dd.delivery_id  WHERE dd.master_id = ${master_id} AND dd.active=1 AND d.active = 1 ) as del

LEFT JOIN

(SELECT rd.delivery_detail_id, sum(rd.qty) tot_return FROM ${return_detail} as rd JOIN ${return_table} as r ON r.id= rd.return_id WHERE rd.master_id = ${master_id} AND rd.active = 1 AND r.active = 1 GROUP BY rd.delivery_detail_id) as ret

ON del.id = ret.delivery_detail_id WHERE 



(
    del.qty -
    ( case 
when ret.tot_return is NULL
THEN 0
ELSE ret.tot_return
END )
    
) > 0 ) as f JOIN ${lots_table} as l ON l.id = f.lot_id GROUP BY f.lot_id, f.rate_per_unit ORDER BY f.lot_id ASC, f.delivery_date ASC";

		$data['grouping_detail'] = $wpdb->get_results($return_group);
		$data['pending_detail'] = $wpdb->get_results($return_query);
		return $data;
	}



	function get_ReturnData($return_id = 0) {
		global $wpdb;
		$lots_table = $wpdb->prefix.'shc_lots';
		$return_table = $wpdb->prefix.'shc_return';
		$return_detail = $wpdb->prefix.'shc_return_detail';
		$unloading_table = $wpdb->prefix.'shc_unloading';		
		$unloading_detail = $wpdb->prefix.'shc_unloading_detail';


		$query = "SELECT * FROM ${return_table} WHERE active = 1 AND id = ${return_id}";
		

		if($data['return_data'] = $wpdb->get_row($query)) {
			$return_detail_query = "SELECT l.lot_no, l.product_name, l.product_type, f.* FROM ${lots_table} as l JOIN ( 
    
    SELECT rd.id as return_detail_id, rd.lot_id, rd.qty FROM ${return_table} as r 
    
    JOIN ${return_detail} rd ON r.id = rd.return_id WHERE r.id = ${return_id} AND rd.active = 1 AND r.active = 1

) as f ON l.id = f.lot_id";


			$group_detail_query = "SELECT l.lot_no, l.product_name, l.product_type, f.* FROM ${lots_table} as l JOIN ( 
    
    SELECT rd.lot_id, SUM(rd.qty) as qty  FROM ${return_table} as r 
    
    JOIN ${return_detail} rd ON r.id = rd.return_id WHERE r.id = ${return_id} AND rd.active = 1 AND r.active = 1 GROUP BY rd.lot_id

) as f ON l.id = f.lot_id";

			$data['return_detail'] = $wpdb->get_results($return_detail_query);
			$data['group_detail'] = $wpdb->get_results($group_detail_query);
			
			return $data;
		}

		return false;

	}


	function get_UnloadingData($return_id = 0, $key = ''){

		global $wpdb;
		$unloading_table = $wpdb->prefix.'shc_unloading';		
		$unloading_detail = $wpdb->prefix.'shc_unloading_detail';

		if($key!='total') {
			$unloading_detail_query = "SELECT charge_amt FROM ${unloading_detail} WHERE return_id = ${return_id} AND charge_for = '${key}' AND active = 1";
			$data = $wpdb->get_row($unloading_detail_query);
			if($data) {
				return $data->charge_amt;
			}
		} else {
			$unloading_detail_query = "SELECT unloading_charge FROM ${unloading_table} WHERE return_id = ${return_id} ";
			$data = $wpdb->get_row($unloading_detail_query);
			if($data) {
				return $data->unloading_charge;
			}
		}

		return false;
	}



}