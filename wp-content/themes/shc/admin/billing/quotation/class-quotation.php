<?php
	class Quotation {
 
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



		function get_LoadingData($deposi_id = '', $key = '' ) {
			global $wpdb;
			$loading_table = $wpdb->prefix.'shc_loading';		
			$loading_detail = $wpdb->prefix.'shc_loading_detail';


			if($key!='total') {
				$loading_detail_query = "SELECT charge_amt FROM ${loading_detail} WHERE deposit_id = ${deposi_id} AND charge_for = '${key}' AND active = 1";
				$data = $wpdb->get_row($loading_detail_query);
				if($data) {
					return $data->charge_amt;
				}
			} else {
				$loading_detail_query = "SELECT loading_charge FROM ${loading_table} WHERE deposit_id = ${deposi_id} ";
				$data = $wpdb->get_row($loading_detail_query);
				if($data) {
					return $data->loading_charge;
				}
			}

			return false;
		}

	}