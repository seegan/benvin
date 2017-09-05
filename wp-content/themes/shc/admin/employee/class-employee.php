<?php
	class Employee {
 
		function __construct() {

		    if( isset($_POST['action']) ) {
		    	$params = array();
				parse_str($_POST['data'], $params);

		        $this->cpage = 1;
		        $this->ppage = isset($params['ppage']) ? $params['ppage'] : 20;
		        $this->name = isset($params['name']) ? $params['name'] : '';
		        $this->mobile = isset($params['mobile']) ? $params['mobile'] : '';
		        $this->employee_from = isset($params['employee_from']) ? $params['employee_from'] : '';
		        $this->employee_to = isset($params['employee_to']) ? $params['employee_to'] : '';


		    } else {
		        $this->cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		        $this->ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		        $this->name = isset( $_GET['name'] ) ? $_GET['name']  : '';
		        $this->mobile = isset( $_GET['mobile'] ) ? $_GET['mobile']  : '';
		        $this->employee_from = isset( $_GET['employee_from'] ) ? $_GET['employee_from']  : '';
		        $this->employee_to = isset( $_GET['employee_to'] ) ? $_GET['employee_to']  : '';
		    }
		}



		function employee_list_pagination( $args ) {


		    global $wpdb;
		    $employee_table =  $wpdb->prefix.'shc_employees';
		    $customPagHTML      = "";

			$page_arg = [];
			$page_arg['ppage'] = $args['items_per_page'];
	        $page_arg['name'] = $this->name;
	        $page_arg['mobile'] = $this->mobile;
	    	$page_arg['employee_from'] = $this->employee_from;
	    	$page_arg['employee_to'] = $this->employee_to;
		    $page_arg['cpage'] = '%#%';

		    $condition = '';
		    if($this->name != '') {
		    	$condition .= " AND emp_name LIKE '".$this->name."%' ";
		    }
		    if($this->mobile != '') {
		    	$condition .= " AND emp_mobile LIKE '".$this->mobile."%' ";
		    }

		    if($this->employee_from != '' && $this->employee_to != '') { 
		    	$condition .= " AND DATE(emp_joining) >= DATE('".$this->employee_from."') AND DATE(emp_joining) <= DATE('".$this->employee_to."')";
		    } else if($this->employee_from != '' || $this->employee_to != '') {
		    	if($this->employee_from != '') {
		    		$condition .= " AND DATE(emp_joining) >= DATE('".$this->employee_from."') AND DATE(emp_joining) <= DATE('".$this->employee_from."')";
		    	} else {
		    		$condition .= " AND DATE(emp_joining) >= DATE('".$this->employee_to."') AND DATE(emp_joining) <= DATE('".$this->employee_to."')";
		    	}
		    }

		    $query 				= "SELECT * FROM ${employee_table} WHERE active = 1 ${condition}";

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
		                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=list_employee')),
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


		function employeeSearch($search_key = '') {
		    global $wpdb;
		    $employee_table =  $wpdb->prefix.'shc_employees';
		    $query = "SELECT * FROM ${employee_table} WHERE active = 1 AND ( name LIKE '${search_key}%' OR mobile LIKE '${search_key}%' OR address LIKE '${search_key}%' )";
		    return $wpdb->get_results($query, ARRAY_A);
		}





		function get_employeeData($employee_id = 0) {
		    global $wpdb;
		    $employee_table =  $wpdb->prefix.'shc_employees';
		    $query = "SELECT * FROM ${employee_table} WHERE active = 1 AND id = ${employee_id}";
		    return $wpdb->get_row($query);
		}

	}


?>