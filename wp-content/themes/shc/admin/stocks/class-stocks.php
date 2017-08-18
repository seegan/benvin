<?php
	class Stocks {
 
		function __construct() {

		    if( isset($_POST['action']) ) {
		    	$params = array();
				parse_str($_POST['data'], $params);

		        $this->cpage = 1;
		        $this->ppage = isset($params['ppage']) ? $params['ppage'] : 20;
		        $this->lot_no = isset($params['lot_no']) ? $params['lot_no'] : '';
		        $this->product_name = isset($params['product_name']) ? $params['product_name'] : '';
		        $this->product_type = isset($params['product_type']) ? $params['product_type'] : '';
		        $this->stock_from = isset($params['stock_from']) ? $params['stock_from'] : '';
		        $this->stock_to = isset($params['stock_to']) ? $params['stock_to'] : '';


		    } else {
		        $this->cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		        $this->ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		        $this->lot_no = isset( $_GET['lot_no'] ) ? $_GET['lot_no']  : '';
		        $this->product_name = isset( $_GET['product_name'] ) ? $_GET['product_name']  : '';
		        $this->product_type = isset( $_GET['product_type'] ) ? $_GET['product_type']  : '';
		        $this->stock_from = isset( $_GET['stock_from'] ) ? $_GET['stock_from']  : '';
		        $this->stock_to = isset( $_GET['stock_to'] ) ? $_GET['stock_to']  : '';
		    }
		}



		function stock_list_pagination( $args ) {
		    global $wpdb;
		    $stock_table =  $wpdb->prefix.'shc_stock';
		    $lots_table =  $wpdb->prefix.'shc_lots';
		    $customPagHTML      = "";

			$page_arg = [];
			$page_arg['ppage'] = $args['items_per_page'];
	        $page_arg['lot_no'] = $this->lot_no;
	        $page_arg['product_name'] = $this->product_name;
	    	$page_arg['product_type'] = $this->product_type;
	    	$page_arg['stock_from'] = $this->stock_from;
	    	$page_arg['stock_to'] = $this->stock_to;
		    $page_arg['cpage'] = '%#%';

		    $condition = '';
		    if($this->lot_no != '') {
		    	$condition .= " AND l.lot_no LIKE '".$this->lot_no."%' ";
		    }
		    if($this->product_name != '') {
		    	$condition .= " AND l.product_name LIKE '".$this->product_name."%' ";
		    }
		    if($this->product_type != '') {
		    	$condition .= " AND l.product_type LIKE '".$this->product_type."%' ";
		    }

		    if($this->stock_from != '' && $this->stock_to != '') {
		    	$condition .= " AND DATE(s.created_at) >= DATE('".$this->stock_from."') AND DATE(s.created_at) <= DATE('".$this->stock_to."')";
		    } else if($this->stock_from != '' || $this->stock_to != '') {
		    	if($this->stock_from != '') {
		    		$condition .= " AND DATE(s.created_at) >= DATE('".$this->stock_from."') AND DATE(s.created_at) <= DATE('".$this->stock_from."')";
		    	} else {
		    		$condition .= " AND DATE(s.created_at) >= DATE('".$this->stock_to."') AND DATE(s.created_at) <= DATE('".$this->stock_to."')";
		    	}
		    }

		    $query 				= "SELECT l.*, s.id as stock_id, s.stock_count, s.buying_total, s.created_at as stock_created FROM ${stock_table} as s JOIN ${lots_table} as l ON s.lot_number = l.id WHERE s.active = 1 ${condition}";

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
		                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=list_stocks')),
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