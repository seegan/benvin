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






/*Out Stocks*/

/*SELECT delivered.id as lot_id, ( delivered.delivery_qty - returned.return_qty ) as out_stock FROM
(
	SELECT l.id, (CASE WHEN delivery_data.delivery_qty IS NULL THEN 0 ELSE delivery_data.delivery_qty END ) as delivery_qty FROM wp_shc_lots as l LEFT JOIN ( SELECT dd.lot_id , SUM(dd.qty) as delivery_qty  FROM wp_shc_delivery as d JOIN wp_shc_delivery_detail as dd ON d.id = dd.delivery_id WHERE d.active = 1 AND date(d.delivery_date) >= date('2017-10-22') AND date(d.delivery_date) <= date('2017-10-30') AND dd.active = 1 GROUP BY dd.lot_id ) as delivery_data ON l.id = delivery_data.lot_id      
) as delivered

JOIN 

(
	SELECT l.id, (CASE WHEN return_data.return_qty IS NULL THEN 0 ELSE return_data.return_qty END ) as return_qty FROM wp_shc_lots as l LEFT JOIN ( SELECT rd.lot_id, SUM(rd.qty) as return_qty FROM wp_shc_return as r JOIN wp_shc_return_detail as rd ON r.id = rd.return_id WHERE r.active = 1 AND date(r.return_date) >= date('2017-10-22') AND date(r.return_date) <= date('2017-10-30') AND rd.active = 1 AND r.is_return = 1 GROUP BY rd.lot_id ) as return_data ON l.id = return_data.lot_id   
) as returned

ON 

delivered.id = returned.id*/





/*SELECT closing_stock.lot_id, ( new_stock.new_stock_total + closing_stock.closing_total ) as total_stock FROM
(
    SELECT l.id as lot_id, (CASE WHEN stock_closing.closing_stock IS NULL THEN 0 ELSE stock_closing.closing_stock END) as closing_total  FROM wp_shc_lots as l LEFT JOIN ( SELECT c.id, cd.lot_id, cd.closing_stock FROM wp_shc_stock_closing as c LEFT JOIN wp_shc_stock_closing_detail as cd ON c.id = cd.closing_id WHERE c.active = 1 AND cd.active = 1 AND c.closing_date = date('2017-10-21') ) as stock_closing ON l.id = stock_closing.lot_id     
) as closing_stock

JOIN 

( 
    SELECT l.id as lot_id, (CASE WHEN stock.new_stock IS NULL THEN 0 ELSE stock.new_stock END) as new_stock_total FROM wp_shc_lots as l LEFT JOIN ( SELECT s.lot_number as lot_no, SUM(s.stock_count) as new_stock FROM wp_shc_stock as s WHERE s.active = 1 AND s.created_at >= date('2017-10-22') AND s.created_at <= date('2017-10-30')  GROUP BY s.lot_number ) as stock ON l.id = stock.lot_no 
) as new_stock
ON
closing_stock.lot_id = new_stock.lot_id*/

?>