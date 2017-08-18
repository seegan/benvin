<?php
	class Delivery {
 
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


		function get_DeliveryData($delivery_id = 0) {
			global $wpdb;
			$lots_table = $wpdb->prefix.'shc_lots';
			$delivery_table = $wpdb->prefix.'shc_delivery';
			$delivery_detail = $wpdb->prefix.'shc_delivery_detail';

			$query = "SELECT * FROM ${delivery_table} WHERE active = 1 AND id = ${delivery_id}";
			$data['delivery_data'] = $wpdb->get_row($query);

			$detail_query = "SELECT l.lot_no, l.product_name, l.product_type, f.* FROM ${lots_table} as l JOIN ( SELECT dd.id as delivery_detail_id, dd.delivery_id, d.master_id, dd.lot_id, dd.rate_per_unit, dd.qty FROM ${delivery_table} as d JOIN ${delivery_detail} dd ON d.id = dd.delivery_id WHERE d.id = ${delivery_id} AND dd.active = 1 ) as f ON l.id = f.lot_id";
			$data['delivery_detail'] = $wpdb->get_results($detail_query);
			return $data;
		}

	}