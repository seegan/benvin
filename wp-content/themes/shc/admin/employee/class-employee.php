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

				$this->attendance_date = ($params['attendance_date'] != '') ? $params['attendance_date'] : date("Y-m-d", time());
				$this->attendance_from = ($params['attendance_from'] != '') ? $params['attendance_from'] : '';
				$this->attendance_to = ($params['attendance_to'] != '') ? $params['attendance_to'] : '';

				$this->attendance_status = $params['attendance_status'];

				$this->emp_id = isset( $params['emp_id'] ) ? $params['emp_id']  : '0';
		    } else {
		        $this->cpage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		        $this->ppage = isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20;
		        $this->name = isset( $_GET['name'] ) ? $_GET['name']  : '';
		        $this->mobile = isset( $_GET['mobile'] ) ? $_GET['mobile']  : '';
		        $this->employee_from = isset( $_GET['employee_from'] ) ? $_GET['employee_from']  : '';
		        $this->employee_to = isset( $_GET['employee_to'] ) ? $_GET['employee_to']  : '';

				$this->attendance_date = isset( $_GET['attendance_date'] ) ? $_GET['attendance_date']  : date("Y-m-d", time());
				$this->attendance_from = isset( $_GET['attendance_from'] ) ? $_GET['attendance_from']  : '';
				$this->attendance_to = isset( $_GET['attendance_to'] ) ? $_GET['attendance_to']  : '';

				$this->attendance_status = isset( $_GET['attendance_status'] ) ? $_GET['attendance_status']  : '-';
				
				$this->emp_id = isset( $_GET['emp_id'] ) ? $_GET['emp_id']  : '0';
		    }
		}



		function employee_list_pagination( $args ) {


		    global $wpdb;
		    $employee_table 	=  $wpdb->prefix.'shc_employees';
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


		function employee_attendance_list_pagination($args ) {

		    global $wpdb;
		    $table =  $wpdb->prefix.'shc_employees';
		    $attendance_table = $wpdb->prefix.'shc_employee_attendance';
		    $customPagHTML      = "";
		    $attendance_date = $this->attendance_date;


			$page_arg = [];
			$page_arg['ppage'] = $args['items_per_page'];
	        $page_arg['name'] = $this->name;
	        $page_arg['mobile'] = $this->mobile;
	    	$page_arg['attendance_date'] = $this->attendance_date;
		    $page_arg['cpage'] = '%#%';


		    $condition = '';
		    if($this->name != '') {
		    	$condition .= " AND emp_name LIKE '".$this->name."%' ";
		    }
		    if($this->mobile != '') {
		    	$condition .= " AND emp_mobile LIKE '".$this->mobile."%' ";
		    }

		    $query = " SELECT ff.* from ( SELECT f.*, (CASE WHEN f.attendance_today IS Null THEN 0 ELSE f.attendance_today END) as att from ( SELECT e.*, CONCAT('EMP', id) as employee_id, (SELECT ea.emp_attendance FROM ${attendance_table} ea WHERE ea.emp_id = e.id AND DATE(ea.attendance_date) = '${attendance_date}' AND active = 1 LIMIT 1 ) AS attendance_today FROM ${table} AS e WHERE DATE(e.emp_joining) <= '${attendance_date}' ) as f ) as ff WHERE ff.active = 1  ${condition}";

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
		                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=list_attendance')),
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



		function employee_attendance_detail_pagination( $args ) {


		    global $wpdb;
		    $table =  $wpdb->prefix.'shc_employees';
		    $attendance_table = $wpdb->prefix.'shc_employee_attendance';
		    $customPagHTML      = "";
		    $attendance_date = $this->attendance_date;


			$page_arg = [];
			$page_arg['ppage'] = $args['items_per_page'];
	    	$page_arg['attendance_from'] = $this->attendance_from;
	    	$page_arg['attendance_to'] = $this->attendance_to;
	    	$page_arg['emp_id'] = $this->emp_id;
		    $page_arg['cpage'] = '%#%';

		    $emp_id = $this->emp_id;

/*attendance_status*/
		    $condition = '';
		    if($this->attendance_status != '' && $this->attendance_status != '-') {
		    	$condition .= " AND ea.emp_attendance = '".$this->attendance_status."' ";
		    }
		    if($this->attendance_from != '' && $this->attendance_to != '') { 
		    	$condition .= " AND DATE(attendance_date) >= DATE('".$this->attendance_from."') AND DATE(attendance_date) <= DATE('".$this->attendance_to."')";
		    } else if($this->attendance_from != '' || $this->attendance_to != '') {
		    	if($this->attendance_from != '') {
		    		$condition .= " AND DATE(attendance_date) >= DATE('".$this->attendance_from."') AND DATE(attendance_date) <= DATE('".$this->attendance_from."')";
		    	} else {
		    		$condition .= " AND DATE(attendance_date) >= DATE('".$this->attendance_to."') AND DATE(attendance_date) <= DATE('".$this->attendance_to."')";
		    	}
		    }

		    $query              = "SELECT ea.*, e.emp_name, e.emp_mobile, CONCAT('EMP', e.id) as empp_id,
			CASE 
			 WHEN ea.emp_attendance = 1
			 THEN 'Present'
			 ELSE 'Absent' END as attendance
			     FROM ${attendance_table} ea JOIN ${table} e ON ea.emp_id = e.id WHERE ea.active = 1 AND ea.emp_id = ${emp_id} ${condition}";


			    $total_query        = "SELECT COUNT(1) FROM (${query}) AS combined_table";

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
		                'base' => add_query_arg( $page_arg , admin_url('admin.php?page=list_attendance&action=attendance_detail')),
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