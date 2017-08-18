<?php
	class ObcList {
 
		function __construct() {

		    if( isset($_POST['action']) ) {
		    	$params = array();
				parse_str($_POST['data'], $params);

		        $this->cpage = 1;
		        $this->ppage = isset($params['ppage']) ? $params['ppage'] : 20;
		        $this->id = isset($params['id']) ? $params['id'] : '';
		        $this->master_id = isset($params['master_id']) ? $params['master_id'] : '';
		        $this->name = isset($params['name']) ? $params['name'] : '';
		        $this->cheque_no = isset($params['cheque_no']) ? $params['cheque_no'] : '';
		        $this->site_name = isset($params['site_name']) ? $params['site_name'] : '';
		        $this->cheque_from = isset($params['cheque_from']) ? $params['cheque_from'] : '';
		        $this->cheque_to = isset($params['cheque_to']) ? $params['cheque_to'] : '';
		    } else {
		        $this->cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		        $this->ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		        $this->id = (isset( $_GET['id'] ) && $_GET['page'] == 'obc_report' ) ? $_GET['id']  : '';
		        $this->master_id = isset( $_GET['master_id'] ) ? $_GET['master_id']  : '';
		        $this->name = isset( $_GET['name'] ) ? $_GET['name']  : '';
		        $this->cheque_no = isset($_GET['cheque_no']) ? $_GET['cheque_no'] : '';
		        $this->site_name = isset( $_GET['site_name'] ) ? $_GET['site_name']  : '';
		        $this->cheque_from = isset( $_GET['cheque_from'] ) ? $_GET['cheque_from']  : '';
		        $this->cheque_to = isset( $_GET['chequen_to'] ) ? $_GET['cheque_to']  : '';
		    }
		}



		function obc_list_pagination( $args ) {


		    global $wpdb;
		    $customer_table =  $wpdb->prefix.'shc_customers';
		    $site_table = $wpdb->prefix.'shc_customer_site';
		    $master_table = $wpdb->prefix.'shc_master';
		    $obc_cheque_table = $wpdb->prefix.'shc_obc_cheque';


		    $customPagHTML      = "";

			$page_arg = [];
			$page_arg['ppage'] = $args['items_per_page'];
	        $page_arg['id'] = $this->id;
	        $page_arg['master_id'] = $this->master_id;
	        $page_arg['name'] = $this->name;
	        $page_arg['site_name'] = $this->site_name;
	        $page_arg['cheque_no'] = $this->cheque_no;
	    	$page_arg['cheque_from'] = $this->cheque_from;
	    	$page_arg['cheque_to'] = $this->cheque_to;
		    $page_arg['cpage'] = '%#%';

		    $condition = '';
		   	if($this->id != '') {
		    	$condition .= " AND om.id = ".$this->id." ";
		    }
		   	if($this->master_id != '') {
		    	$condition .= " AND om.master_id = ".$this->master_id." ";
		    }
		    if($this->name != '') {
		    	$condition .= " AND c.name LIKE '".$this->name."%' ";
		    }
		    if($this->site_name != '') {
		    	$condition .= " AND cs.site_name LIKE '".$this->site_name."%' ";
		    }
		    if($this->cheque_no != '') {
		    	$condition .= " AND om.cheque_no LIKE '".$this->cheque_no."%' ";
		    }
		    if($this->cheque_from != '' && $this->cheque_to != '') { 
		    	$condition .= " AND DATE(om.cheque_date) >= DATE('".$this->cheque_from."') AND DATE(om.cheque_date) <= DATE('".$this->cheque_to."')";
		    } else if($this->cheque_from != '' || $this->cheque_to != '') {
		    	if($this->cheque_from != '') {
		    		$condition .= " AND DATE(om.cheque_date) >= DATE('".$this->cheque_from."') AND DATE(om.cheque_date) <= DATE('".$this->cheque_from."')";
		    	} else {
		    		$condition .= " AND DATE(om.cheque_date) >= DATE('".$this->cheque_to."') AND DATE(om.cheque_date) <= DATE('".$this->cheque_to."')";
		    	}
		    }


		    $query = "SELECT om.*,c.name, cs.site_name FROM (SELECT o.*, m.customer_id, m.site_id FROM ${obc_cheque_table} as o JOIN ${master_table} as m ON o.master_id = m.id WHERE o.active = 1 AND m.active = 1) as om JOIN ${customer_table} as c ON om.customer_id = c.id JOIN ${site_table} as cs ON om.site_id = cs.id WHERE om.active = 1 ${condition}";

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
		                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=obc_report')),
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