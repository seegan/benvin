<?php
class Settings {

	function __construct() {

	}

	function getBankData($company_id = false) {
		global $wpdb;
		$bank_table = $wpdb->prefix. 'shc_banks';

		$query = "SELECT * FROM ${bank_table} as b WHERE b.active = 1";
		if($company_id) {
			$query = "SELECT * FROM ${bank_table} as b WHERE b.active = 1 and b.company_id = ${company_id}";
		}
		$data = $wpdb->get_results($query);
		return $data;
	}



}
?>