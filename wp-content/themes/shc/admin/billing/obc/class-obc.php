<?php
class Obc {

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


	function get_ObcData($obc_id=0, $master_id = 0)
	{
		global $wpdb;
		$obc_table = $wpdb->prefix.'shc_obc_cheque';
		$query = "SELECT * FROM ${obc_table} WHERE id = ${obc_id} AND master_id = ${master_id}";
		return $wpdb->get_row($query);
	}

}



?>