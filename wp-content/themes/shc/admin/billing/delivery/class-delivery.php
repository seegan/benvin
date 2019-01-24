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

			$detail_query = "SELECT l.lot_no, l.product_name, l.product_type, f.* FROM ${lots_table} as l JOIN ( SELECT dd.id as delivery_detail_id, dd.delivery_id, d.master_id, dd.lot_id, dd.rate_per_unit, dd.minimum_bill_day, dd.qty FROM ${delivery_table} as d JOIN ${delivery_detail} dd ON d.id = dd.delivery_id WHERE d.id = ${delivery_id} AND dd.active = 1 ) as f ON l.id = f.lot_id";
			$data['delivery_detail'] = $wpdb->get_results($detail_query);

			$invoice_query = "SELECT mf.*, c.name, c.mobile, c.address, cs.site_name, cs.site_address, cs.phone_number, cs.gst_number, cs.gst_for, comp.company_id, comp.company_name  FROM ( SELECT d.bill_from_comp, d.bill_no, d.master_id, d.delivery_date, d.vehicle_number, d.driver_name, d.driver_mobile, d.created_at, d.active, m.customer_id, m.site_id FROM wp_shc_delivery as d JOIN wp_shc_master as m ON d.master_id = m.id WHERE d.id = ${delivery_id} ) as mf JOIN wp_shc_customers as c ON mf.customer_id = c.id JOIN wp_shc_customer_site as cs ON mf.site_id = cs.id JOIN wp_shc_companies as comp ON mf.bill_from_comp = comp.id";

			$data['invoice_data'] = $wpdb->get_row($invoice_query);

			return $data;
		}

	}