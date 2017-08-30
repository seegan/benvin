<?php
	class Customer {
 
		function __construct() {

		    if( isset($_POST['action']) ) {
		    	$params = array();
				parse_str($_POST['data'], $params);

		        $this->cpage = 1;
		        $this->ppage = isset($params['ppage']) ? $params['ppage'] : 20;
		        $this->name = isset($params['name']) ? $params['name'] : '';
		        $this->mobile = isset($params['mobile']) ? $params['mobile'] : '';
		        $this->customer_from = isset($params['customer_from']) ? $params['customer_from'] : '';
		        $this->customer_to = isset($params['customer_to']) ? $params['customer_to'] : '';


		    } else {
		        $this->cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		        $this->ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		        $this->name = isset( $_GET['name'] ) ? $_GET['name']  : '';
		        $this->mobile = isset( $_GET['mobile'] ) ? $_GET['mobile']  : '';
		        $this->customer_from = isset( $_GET['customer_from'] ) ? $_GET['customer_from']  : '';
		        $this->customer_to = isset( $_GET['customer_to'] ) ? $_GET['customer_to']  : '';
		    }
		}



		function customer_list_pagination( $args ) {


		    global $wpdb;
		    $customer_table =  $wpdb->prefix.'shc_customers';
		    $customPagHTML      = "";

			$page_arg = [];
			$page_arg['ppage'] = $args['items_per_page'];
	        $page_arg['name'] = $this->name;
	        $page_arg['mobile'] = $this->mobile;
	    	$page_arg['customer_from'] = $this->customer_from;
	    	$page_arg['customer_to'] = $this->customer_to;
		    $page_arg['cpage'] = '%#%';

		    $condition = '';
		    if($this->name != '') {
		    	$condition .= " AND name LIKE '".$this->name."%' ";
		    }
		    if($this->mobile != '') {
		    	$condition .= " AND mobile LIKE '".$this->mobile."%' ";
		    }

		    if($this->customer_from != '' && $this->customer_to != '') { 
		    	$condition .= " AND DATE(created_at) >= DATE('".$this->customer_from."') AND DATE(created_at) <= DATE('".$this->customer_to."')";
		    } else if($this->customer_from != '' || $this->customer_to != '') {
		    	if($this->customer_from != '') {
		    		$condition .= " AND DATE(created_at) >= DATE('".$this->customer_from."') AND DATE(created_at) <= DATE('".$this->customer_from."')";
		    	} else {
		    		$condition .= " AND DATE(created_at) >= DATE('".$this->customer_to."') AND DATE(created_at) <= DATE('".$this->customer_to."')";
		    	}
		    }


		    $query 				= "SELECT * FROM wp_shc_customers WHERE active = 1 ${condition}";

		   // $query              = "SELECT * FROM ${table} WHERE active = 1 ${condition}";

		    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";
		    $total              = $wpdb->get_var( $total_query );
		    //$page               = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : abs( (int) $args['page'] );
		    $page               = $this->cpage;
		    $ppage 				= $this->ppage;
		    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

		    $data['result']         = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );

		    $totalPage         = ceil($total / $args['items_per_page']);

		    if($totalPage > 1){
		        $data['start_count'] = ($ppage * ($page-1));

		        $pagination = paginate_links( array(
		                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=customer_list')),
		                'format' => '',
		                'type' => 'array',
		                'prev_text' => __('prev'),
		                'next_text' => __('next'),
		                'total' => $totalPage,
		                'current' => $page
		                )
		            );
		        if ( ! empty( $pagination ) ) : 
		            $customPagHTML .= '<ul class="paginate pag3 clearfix"><li class="single">Page '.$page.' of '.$totalPage.'</li>';
		            foreach ($pagination as $key => $page_link ) {
		                if( strpos( $page_link, 'current' ) !== false ) {
		                    $customPagHTML .=  '<li class="current">'.$page_link.'</li>';
		                } else {
		                    $customPagHTML .=  '<li>'.$page_link.'</li>';
		                }
		            }
		            $customPagHTML .=  '</ul>';
		        endif;
		    }

		    $data['pagination'] = $customPagHTML;
		    return $data;
		}


		function customerSearch($search_key = '') {
		    global $wpdb;
		    $customer_table =  $wpdb->prefix.'shc_customers';
		    $query = "SELECT * FROM ${customer_table} WHERE active = 1 AND ( name LIKE '${search_key}%' OR mobile LIKE '${search_key}%' OR address LIKE '${search_key}%' )";
		    return $wpdb->get_results($query, ARRAY_A);
		}

		function siteSearch($search_key = '', $customer_id = 0) {

		    global $wpdb;
		    $customer_table =  $wpdb->prefix.'shc_customers';
		    $customer_site_table =  $wpdb->prefix.'shc_customer_site';


			$query = "SELECT c.*,cs.id as site_id, cs.site_name, cs.site_address, cs.phone_number FROM ${customer_table} c JOIN ${customer_site_table} cs ON c.id = cs.customer_id WHERE c.active = 1 AND cs.active = 1 AND (cs.site_address LIKE '${search_key}%' OR cs.site_name LIKE '${search_key}%' OR cs.phone_number LIKE '${search_key}%')";

			if($customer_id != 0 AND $customer_id != '') {
				$query = "SELECT c.*,cs.id as site_id, cs.site_name, cs.site_address, cs.phone_number FROM ${customer_table} c JOIN ${customer_site_table} cs ON c.id = cs.customer_id WHERE c.active = 1 AND cs.active = 1 AND c.id = ${customer_id} AND (cs.site_address LIKE '${search_key}%' OR cs.site_name LIKE '${search_key}%' OR cs.phone_number LIKE '${search_key}%')";
			}

		    return $wpdb->get_results($query, ARRAY_A);
		}





		function get_CustomerData($customer_id = 0) {
		    global $wpdb;
		    $customer_table =  $wpdb->prefix.'shc_customers';
		    $query = "SELECT * FROM ${customer_table} WHERE active = 1 AND id = ${customer_id}";
		    return $wpdb->get_row($query);
		}


		function get_SiteData($site_id = 0, $bill_for = false) { 
		    global $wpdb;
		    $bill_for_table = $wpdb->prefix.$bill_for;
		    $site_table =  $wpdb->prefix.'shc_customer_site';
		    if($bill_for) {
		    	$query = "SELECT fc.*, comp.company_id, (CASE WHEN fc.bill_no is null THEN 1 ELSE fc.bill_no + 1 END) next_bill_no FROM (SELECT cs.*, c.bill_from_comp, (SELECT d.bill_no from ${bill_for_table} as d WHERE d.bill_from_comp = c.bill_from_comp ORDER BY bill_no DESC LIMIT 1 ) as bill_no FROM `wp_shc_customer_site` as cs JOIN wp_shc_customers as c ON c.id = cs.customer_id WHERE cs.id = ${site_id} ) as fc JOIN wp_shc_companies as comp ON comp.id = fc.bill_from_comp";
		    } else {
		    	$query = "SELECT * FROM ${site_table} WHERE active = 1 AND id = ${site_id}";
		    }
		    
		    return $wpdb->get_row($query);
		}

	}


?>