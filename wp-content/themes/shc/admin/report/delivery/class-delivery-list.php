<?php
	class DeliveryList {
 
		function __construct() {

		    if( isset($_POST['action']) ) {
		    	$params = array();
				parse_str($_POST['data'], $params);

		        $this->cpage = 1;
		        $this->ppage = isset($params['ppage']) ? $params['ppage'] : 20;
		        $this->id = isset($params['id']) ? $params['id'] : '';
		        $this->master_id = isset($params['master_id']) ? $params['master_id'] : '';
		        $this->name = isset($params['name']) ? $params['name'] : '';
		        $this->site_name = isset($params['site_name']) ? $params['site_name'] : '';
		        $this->delivery_from = isset($params['delivery_from']) ? $params['delivery_from'] : '';
		        $this->delivery_to = isset($params['delivery_to']) ? $params['delivery_to'] : '';

		        $this->financial_year = isset($params['financial_year']) ? $params['financial_year'] : date('Y');
		        $this->bill_from_comp = isset($params['bill_from_comp']) ? $params['bill_from_comp'] : '-';
		        $this->ref_number = isset($params['ref_number']) ? $params['ref_number'] : '';

		    } else {
		        $this->cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		        $this->ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;;
		        $this->id = (isset( $_GET['id'] ) && $_GET['page'] == 'delivery_report' ) ? $_GET['id']  : '';
		        $this->master_id = isset( $_GET['master_id'] ) ? $_GET['master_id']  : '';
		        $this->name = isset( $_GET['name'] ) ? $_GET['name']  : '';
		        $this->site_name = isset( $_GET['site_name'] ) ? $_GET['site_name']  : '';
		        $this->delivery_from = isset( $_GET['delivery_from'] ) ? $_GET['delivery_from']  : '';
		        $this->delivery_to = isset( $_GET['delivery_to'] ) ? $_GET['delivery_to']  : '';

		        $this->financial_year = isset( $_GET['financial_year'] ) ? $_GET['financial_year']  : date('Y');
		        $this->bill_from_comp = isset( $_GET['bill_from_comp'] ) ? $_GET['bill_from_comp']  : '-';
		        $this->ref_number = isset( $_GET['ref_number'] ) ? $_GET['ref_number']  : '';
		    }
		}



		function delivery_list_pagination( $args ) {


		    global $wpdb;
		    $customer_table =  $wpdb->prefix.'shc_customers';
		    $site_table = $wpdb->prefix.'shc_customer_site';
		    $master_table = $wpdb->prefix.'shc_master';
		    $delivery_table = $wpdb->prefix.'shc_delivery';

		    $customPagHTML      = "";

			$page_arg = [];
			$page_arg['ppage'] = $args['items_per_page'];
	        $page_arg['id'] = $this->id;
	        $page_arg['master_id'] = $this->master_id;
	        $page_arg['name'] = $this->name;
	        $page_arg['site_name'] = $this->site_name;
	    	$page_arg['delivery_from'] = $this->delivery_from;
	    	$page_arg['delivery_to'] = $this->delivery_to;

	    	$page_arg['financial_year'] = $this->financial_year;
	    	$page_arg['bill_from_comp'] = $this->bill_from_comp;
	    	$page_arg['ref_number'] = $this->ref_number;

		    $page_arg['cpage'] = '%#%';

		    $condition = '';
		   	if($this->id != '') {
		    	$condition .= " AND d.bill_no = ".$this->id." ";
		    }
		   	if($this->master_id != '') {
		    	$condition .= " AND d.master_id = ".$this->master_id." ";
		    }
		    if($this->name != '') {
		    	$condition .= " AND c.name LIKE '".$this->name."%' ";
		    }
		    if($this->site_name != '') {
		    	$condition .= " AND cs.site_name LIKE '".$this->site_name."%' ";
		    }

		   	if($this->financial_year != '-') {
		    	$condition .= " AND d.financial_year = ".$this->financial_year." ";
		    }
		   	if($this->bill_from_comp != '-') {
		    	$condition .= " AND d.bill_from_comp = ".$this->bill_from_comp." ";
		    }
		   	if($this->ref_number != '') {
		    	$condition .= " AND d.ref_number = '".$this->ref_number."' ";
		    }

		    if($this->delivery_from != '' && $this->delivery_to != '') { 
		    	$condition .= " AND DATE(d.delivery_date) >= DATE('".$this->delivery_from."') AND DATE(d.delivery_date) <= DATE('".$this->delivery_to."')";
		    } else if($this->delivery_from != '' || $this->delivery_to != '') {
		    	if($this->delivery_from != '') {
		    		$condition .= " AND DATE(d.delivery_date) >= DATE('".$this->delivery_from."') AND DATE(d.delivery_date) <= DATE('".$this->delivery_from."')";
		    	} else {
		    		$condition .= " AND DATE(d.delivery_date) >= DATE('".$this->delivery_to."') AND DATE(d.delivery_date) <= DATE('".$this->delivery_to."')";
		    	}
		    }

		    $query 				= "SELECT d.*,c.name, c.mobile, c.address, cs.site_name, cs.site_address, cs.phone_number FROM (SELECT de.*, m.customer_id, m.site_id FROM ${delivery_table} as de JOIN ${master_table} as m ON de.master_id = m.id ) as d JOIN ${customer_table} as c ON d.customer_id = c.id JOIN ${site_table} as cs ON d.site_id = cs.id WHERE d.active = 1 ${condition}";

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
		                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=delivery_report')),
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
	}
?>