<?php
	class HiringList {
 
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
		        $this->mobile = isset($params['site_name']) ? $params['site_name'] : '';
		        $this->bill_from = isset($params['bill_from']) ? $params['bill_from'] : '';
		        $this->bill_to = isset($params['bill_to']) ? $params['bill_to'] : '';
		    } else {
		        $this->cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		        $this->ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		        $this->id = (isset( $_GET['id'] ) && $_GET['page'] == 'hiring_report' ) ? $_GET['id']  : '';
		        $this->master_id = isset( $_GET['master_id'] ) ? $_GET['master_id']  : '';		        
		        $this->name = isset( $_GET['name'] ) ? $_GET['name']  : '';
		        $this->site_name = isset( $_GET['site_name'] ) ? $_GET['site_name']  : '';
		        $this->mobile = isset( $_GET['site_name'] ) ? $_GET['site_name']  : '';
		        $this->bill_from = isset( $_GET['bill_from'] ) ? $_GET['bill_from']  : '';
		        $this->bill_to = isset( $_GET['bill_to'] ) ? $_GET['bill_to']  : '';
		    }
		}



		function hiring_list_pagination( $args ) {
		    global $wpdb;
		    $hiring_table =  $wpdb->prefix.'shc_hiring';
		    $master_table =  $wpdb->prefix.'shc_master';
		    $customer_table =  $wpdb->prefix.'shc_customers';
		    $site_table =  $wpdb->prefix.'shc_customer_site';

		    $customPagHTML      = "";

			$page_arg = [];
			$page_arg['ppage'] = $args['items_per_page'];
	        $page_arg['id'] = $this->id;
	        $page_arg['master_id'] = $this->master_id;
	        $page_arg['name'] = $this->name;
	        $page_arg['site_name'] = $this->site_name;
	    	$page_arg['bill_from'] = $this->return_from;
	    	$page_arg['bill_to'] = $this->return_to;
		    $page_arg['cpage'] = '%#%';

		    $condition = '';
		   	if($this->id != '') {
		    	$condition .= " AND f.id = ".$this->id." ";
		    }
		   	if($this->master_id != '') {
		    	$condition .= " AND f.master_id = ".$this->master_id." ";
		    }
		    if($this->name != '') {
		    	$condition .= " AND c.name LIKE '".$this->name."%' ";
		    }
		    if($this->site_name != '') {
		    	$condition .= " AND s.site_name LIKE '".$this->site_name."%' ";
		    }

		    if($this->bill_from != '' && $this->bill_to != '') { 
		    	$condition .= " AND DATE(f.bill_from) >= DATE('".$this->bill_from."') AND DATE(f.bill_to) <= DATE('".$this->bill_to."')";
		    } else if($this->bill_from != '' || $this->bill_to != '') {
		    	if($this->bill_from != '') {
		    		$condition .= " AND DATE(f.bill_from) >= DATE('".$this->bill_from."') AND DATE(f.bill_to) <= DATE('".$this->bill_from."')";
		    	} else {
		    		$condition .= " AND DATE(f.bill_from) >= DATE('".$this->bill_to."') AND DATE(f.bill_to) <= DATE('".$this->bill_to."')";
		    	}
		    }

		    $query 				= " SELECT f.*, c.name, s.site_name FROM (SELECT h.*, m.customer_id, m.site_id FROM ${hiring_table} as h JOIN ${master_table} as m ON h.master_id = m.id WHERE m.active = 1) as f JOIN ${customer_table} as c ON f.customer_id = c.id JOIN ${site_table} as s ON f.site_id = s.id WHERE f.active = 1 ${condition}";


		    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";
		    $total              = $wpdb->get_var( $total_query );
		    $page               = $this->cpage;
		    $ppage 				= $this->ppage;
		    $offset             = ( $page * $args['items_per_page'] ) - $args['items_per_page'] ;

		    $data['result']         = $wpdb->get_results( $query . "ORDER BY ${args['orderby_field']} ${args['order_by']} LIMIT ${offset}, ${args['items_per_page']}" );


		    $totalPage         = ceil($total / $args['items_per_page']);

		    if($totalPage > 1){
		        $data['start_count'] = ($ppage * ($page-1));
		        $pagination = paginate_links( array(
		                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=hiring_report')),
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