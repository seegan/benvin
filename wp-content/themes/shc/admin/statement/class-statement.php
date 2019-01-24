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



	function get_AccountStatement($master_id = 0, $date_to = '0000-00-00', $sd = 1) {
		global $wpdb;
		$loading_table = $wpdb->prefix.'shc_loading';
		$deposit_table = $wpdb->prefix.'shc_deposit';
		$hiring_table = $wpdb->prefix.'shc_hiring';
		$obc_cheque_table = $wpdb->prefix.'shc_obc_cheque';
		$lost_table = $wpdb->prefix.'shc_lost';
		$return_table = $wpdb->prefix.'shc_return';


		$sd_query = "";
		if($sd == 1) {
			$sd_query = "SELECT deposit.* FROM 
			(
				SELECT 1 as priority, sd.bill_from_comp, sd.deposit_date as r_date, date(sd.deposit_date) as bill_date, 'To Security Deposit' as description, CONCAT('SD ', sd.bill_no) as bill_ref, '' as credit,  sd.total as debit FROM wp_shc_deposit as sd WHERE sd.active = 1 AND sd.master_id IN (${master_id}) AND date(sd.deposit_date) <= date('${date_to}')
			) as deposit

			UNION ALL";
		}

		$query = "SELECT * FROM (


			${sd_query}
			

			SELECT loading.* FROM
			(
				SELECT 
				( CASE 
				  WHEN ld.charge_for = 'loading' THEN 2
				  WHEN ld.charge_for = 'transportation' THEN 3
				END ) as priority,
				dp.bill_from_comp, dp.r_date, dp.bill_date, CONCAT('By ', ld.charge_for) as description, dp.bill_ref, ld.charge_amt as credit, '' as debit FROM ( SELECT sd.bill_from_comp, sd.deposit_date as r_date, date(sd.deposit_date) as bill_date, CONCAT('SD ', sd.bill_no) as bill_ref, l.id as loading_id  FROM wp_shc_deposit as sd JOIN wp_shc_loading l ON sd.id = l.deposit_id WHERE sd.active = 1 AND sd.master_id IN (${master_id}) AND date(sd.deposit_date) <= date('${date_to}') AND l.active = 1 )  as dp JOIN wp_shc_loading_detail as ld ON dp.loading_id = ld.loading_id WHERE ld.charge_amt != 0.00
			) as loading

			UNION ALL

			SELECT hiring.* FROM
			(
				SELECT 1 as priority, h.bill_from_comp, h.payment_date as r_date, date(h.payment_date) as bill_date, CONCAT('To Hire Bill (', h.bill_from ,' - ', h.bill_to ,')') as description, CONCAT('HB ', h.bill_no) as bill_ref, '' as credit, h.hiring_total as debit FROM ${hiring_table} as h WHERE h.active = 1 AND h.bill_status = 2 AND h.master_id IN (${master_id}) AND date(h.payment_date) <= date('${date_to}')    
			) as hiring

			UNION ALL

			SELECT proforma.* FROM
			(
				SELECT 1 as priority, h.bill_from_comp, h.bill_date as r_date, date(h.bill_date) as bill_date, CONCAT('To Proforma Bill (', h.bill_from ,' - ', h.bill_to ,')') as description, CONCAT('PFA ', h.proforma_no) as bill_ref, '' as credit, h.hiring_total as debit FROM ${hiring_table} as h WHERE h.active = 1 AND h.bill_status = 1 AND h.master_id IN (${master_id}) AND date(h.bill_date) <= date('${date_to}')    
			) as proforma

			UNION ALL

			SELECT cheque.* FROM
			(
				SELECT 1 as priority, c.bill_from_comp as bill_from_comp, c.obc_date as r_date, date(c.obc_date) as bill_date, CONCAT('By ',c.cheque_no, ' Dt. ', date(c.cheque_date)) as description, c.notes as bill_ref,  c.cheque_amount as credit, '' as debit FROM ${obc_cheque_table} as c WHERE c.master_id IN (${master_id}) AND date(c.obc_date) <= date('${date_to}') AND c.active = 1  AND cd_notes = 'credit'
			) as cheque

			UNION ALL

			SELECT debit.* FROM
			(
				SELECT 1 as priority, c.bill_from_comp as bill_from_comp, c.obc_date as r_date, date(c.obc_date) as bill_date, CONCAT('To ',c.cheque_no, ' Dt. ', date(c.cheque_date)) as description, c.notes as bill_ref,  '' as credit, c.cheque_amount as debit FROM ${obc_cheque_table} as c WHERE c.master_id IN (${master_id}) AND date(c.obc_date) <= date('${date_to}') AND c.active = 1  AND cd_notes = 'debit'
			) as debit

			UNION ALL

			SELECT lost.* FROM
			(
				SELECT 1 as priority, sr.bill_from_comp, NOW() as r_date, '' as bill_date, 'By Missing Cost' as description, '' as bill_ref, SUM(lst.lost_total) as credit, '' as debit FROM ${lost_table} as lst JOIN ${return_table} as sr ON lst.return_id = sr.id WHERE lst.master_id IN (${master_id}) AND date(sr.return_date) <= date('${date_to}') AND lst.active = 1 AND sr.active = 1
			) as lost

		    
		) as full ORDER BY full.r_date ASC, full.priority ASC";



		$credit_debit_total = "SELECT SUM(f.credit) as credit_total, SUM(f.debit) as debit_total, ( SUM(f.credit) - SUM(f.debit) ) as cd_bal FROM ( ${query} ) as f";

		$data['cd_total'] = $wpdb->get_row($credit_debit_total);
		$data['statement_data'] = $wpdb->get_results($query);

		return $data;


	}


	function get_LostStatement($master_id = 0, $date_to = '0000-00-00') {
		global $wpdb;
		$detail_query = "SELECT full.*, l.product_name, l.product_type FROM ( SELECT ld.lot_id, SUM(ld.lost_qty) as lost_qty, ld.lost_unit_price, SUM(ld.lost_total) as lost_total FROM (
				SELECT lst.* FROM wp_shc_lost as lst JOIN wp_shc_return as sr ON lst.return_id = sr.id WHERE lst.master_id IN (${master_id}) AND date(sr.return_date) <= date('${date_to}') AND lst.active = 1 AND sr.active = 1 )
			as lost_table JOIN wp_shc_lost_detail as ld ON ld.lost_id = lost_table.id WHERE ld.active = 1 GROUP BY ld.lot_id, ld.lost_unit_price ) as full JOIN wp_shc_lots as l ON full.lot_id = l.id";

		$total_query = "SELECT SUM(lst.lost_total) as debit FROM wp_shc_lost as lst JOIN wp_shc_return as sr ON lst.return_id = sr.id WHERE lst.master_id IN (${master_id}) AND date(sr.return_date) <= date('${date_to}') AND lst.active = 1 AND sr.active = 1";
		
		$data['lost_detail'] = $wpdb->get_results($detail_query);
		$data['lost_total'] = $wpdb->get_row($total_query);

		return $data;
	}


	function get_DamageStatement($master_id = 0, $date_to = '0000-00-00') {

		global $wpdb;
		$total_query = "SELECT SUM(rd.damage_total) as debit FROM wp_shc_return_damage as rd JOIN wp_shc_return as sr ON rd.return_id = sr.id WHERE rd.master_id IN (${master_id}) AND date(sr.return_date) <= date('${date_to}') AND rd.active = 1 AND sr.active = 1";

		$detail_query = "SELECT rdd.damage_detail, rdd.damage_charge FROM ( SELECT rd.* FROM wp_shc_return_damage as rd JOIN wp_shc_return as sr ON rd.return_id = sr.id WHERE rd.master_id IN (${master_id}) AND date(sr.return_date) <= date('${date_to}') AND rd.active = 1 AND sr.active = 1 ) as dmg JOIN wp_shc_return_damage_detail as rdd ON dmg.id = rdd.damage_id WHERE rdd.active = 1";

		$data['damage_total'] = $wpdb->get_row($total_query);
		$data['damage_detail'] = $wpdb->get_results($detail_query);

		return $data;
	}


}
?>