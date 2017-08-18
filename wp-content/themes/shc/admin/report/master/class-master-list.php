<?php
	class MasterList {
 
		function __construct() {

		    if( isset($_POST['action']) ) {
		    	$params = array();
				parse_str($_POST['data'], $params);

		        $this->cpage = 1;
		        $this->ppage = isset($params['ppage']) ? $params['ppage'] : 20;
		        $this->id = isset($params['id']) ? $params['id'] : '';
		        $this->name = isset($params['name']) ? $params['name'] : '';
		        $this->site_name = isset($params['site_name']) ? $params['site_name'] : '';
		        $this->master_from = isset($params['master_from']) ? $params['master_from'] : '';
		        $this->master_to = isset($params['master_to']) ? $params['master_to'] : '';
		    } else {
		        $this->cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		        $this->ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		        $this->id = isset( $_GET['id'] ) ? $_GET['id']  : '';
		        $this->id = (isset( $_GET['id'] ) && $_GET['page'] == 'master_report' ) ? $_GET['id']  : '';
		        $this->name = isset( $_GET['name'] ) ? $_GET['name']  : '';
		        $this->site_name = isset( $_GET['site_name'] ) ? $_GET['site_name']  : '';
		        $this->master_from = isset( $_GET['master_from'] ) ? $_GET['master_from']  : '';
		        $this->master_to = isset( $_GET['master_to'] ) ? $_GET['master_to']  : '';
		    }
		}



		function master_list_pagination( $args ) {


		    global $wpdb;
		    $master_table = $wpdb->prefix.'shc_master';
		    $customer_table =  $wpdb->prefix.'shc_customers';
		    $site_table =  $wpdb->prefix.'shc_customer_site';

		    $customPagHTML      = "";

			$page_arg = [];
			$page_arg['ppage'] = $args['items_per_page'];
	        $page_arg['id'] = $this->id;
	        $page_arg['name'] = $this->name;
	        $page_arg['site_name'] = $this->site_name;
	    	$page_arg['master_from'] = $this->master_from;
	    	$page_arg['master_to'] = $this->master_to;
		    $page_arg['cpage'] = '%#%';

		    $condition = '';
		   	if($this->id != '') {
		    	$condition .= " AND m.id = ".$this->id." ";
		    }
		    if($this->name != '') {
		    	$condition .= " AND c.name LIKE '".$this->name."%' ";
		    }
		    if($this->site_name != '') {
		    	$condition .= " AND cs.site_name LIKE '".$this->site_name."%' ";
		    }

		    if($this->master_from != '' && $this->master_to != '') { 
		    	$condition .= " AND DATE(m.master_date) >= DATE('".$this->master_from."') AND DATE(m.master_date) <= DATE('".$this->master_to."')";
		    } else if($this->master_from != '' || $this->master_to != '') {
		    	if($this->master_from != '') {
		    		$condition .= " AND DATE(m.master_date) >= DATE('".$this->master_from."') AND DATE(m.master_date) <= DATE('".$this->master_from."')";
		    	} else {
		    		$condition .= " AND DATE(m.master_date) >= DATE('".$this->master_to."') AND DATE(m.master_date) <= DATE('".$this->master_to."')";
		    	}
		    }

		    $query 				= "SELECT m.*, c.name, c.mobile, c.address, cs.site_name, cs.site_address, cs.phone_number FROM ${master_table} as m JOIN ${customer_table} as c ON m.customer_id = c.id JOIN ${site_table} as cs ON m.site_id = cs.id WHERE  m.active = 1 ${condition}";

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
		                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=master_report')),
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