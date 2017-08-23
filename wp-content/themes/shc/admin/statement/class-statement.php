<?php
class Statement {

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



	function get_AccountStatement($master_id = 0, $date_to = '0000-00-00') {
		global $wpdb;

		$query = "SELECT * FROM (

			SELECT loading.* FROM
			(
				SELECT l.deposit_date as r_date, 'To Loading Charge' as description, CONCAT('SD ', l.deposit_id) as bill_ref, '' as credit,  l.loading_charge as debit  FROM wp_shc_loading as l JOIN wp_shc_deposit as d ON d.id = l.deposit_id WHERE l.active = 1 AND d.active = 1 AND l.master_id = ${master_id} AND date(l.deposit_date) <= date('${date_to}')
			) as loading

			UNION ALL

			SELECT hiring.* FROM
			(
				SELECT h.bill_date as r_date, CONCAT('To Hire Bill (', h.bill_from ,' - ', h.bill_to ,')') as description, CONCAT('HB ', h.id) as bill_ref, '' as credit, h.hiring_total as debit FROM wp_shc_hiring as h WHERE h.active = 1 AND h.master_id = ${master_id} AND date(h.bill_date) <= date('${date_to}')    
			) as hiring

			UNION ALL

			SELECT cheque.* FROM
			(
				SELECT c.obc_date as r_date, CONCAT('By Chq. ',c.cheque_no, ' Dt. ', date(c.obc_date)) as description, 'OBC' as bill_ref, c.cheque_amount as credit, '' as debit FROM wp_shc_obc_cheque as c WHERE c.master_id = ${master_id} AND date(c.obc_date) <= date('${date_to}')     
			) as cheque

		    
		) as full ORDER BY full.r_date ASC";


		return $wpdb->get_results($query);


	}
}
?>