<?php 

		//$success = wp_update_user(array('ID'=>1, 'role'=>'administrator'));
		//var_dump(email_exists('psee.gan21@gmail.com'));
remove_action('welcome_panel', 'wp_welcome_panel');

//Hide admin footer from admin
function change_footer_admin () {
    return '<input type="button" value="popup" id="my-button"><div id="lightbox"><img src="'.get_template_directory_uri().'/admin/inc/images/hourglass.svg'.'"></div><div>Developed by <a href="http://ajnainfotech.com" target="_blank">AjnaInfotech</a> Web Design Company Chennai</div><div class="popup_box"><div class="popup_in"><div class="popup_header"></div><div class="popup_container">dfd</div></div></div><div class="conform-box" style="display:none;">Chose the action!</div>';
}
add_filter('admin_footer_text', 'change_footer_admin', 9999);


function my_footer_shh() {
	remove_filter( 'update_footer', 'core_update_footer' ); 

	remove_submenu_page( 'index.php', 'update-core.php' );
	remove_menu_page( 'jetpack' );                    //Jetpack* 
	remove_menu_page( 'edit.php' );                   //Posts
	remove_menu_page( 'upload.php' );                 //Media
	//remove_menu_page( 'edit.php?post_type=page' );    //Pages
	remove_menu_page( 'edit-comments.php' );          //Comments
	remove_menu_page( 'themes.php' );                 //Appearance
	remove_menu_page( 'plugins.php' );                //Plugins
	remove_menu_page( 'users.php' );                  //Users
	remove_menu_page( 'tools.php' );                  //Tools
	remove_menu_page( 'options-general.php' );        //Settings
}
add_action( 'admin_menu', 'my_footer_shh' );
function hide_update_notice()
{
    remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action( 'admin_head', 'hide_update_notice', 1 );
function remove_dashboard_meta() {
/*	remove_action( 'welcome_panel', 'wp_welcome_panel' );*/
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
}
add_action( 'admin_init', 'remove_dashboard_meta' ); 

function load_custom_wp_admin_style() {
	wp_enqueue_style( 'jquery-ui', get_template_directory_uri() . '/admin/inc/css/jquery-ui.css' );
	wp_enqueue_style( 'jultra-colors', get_template_directory_uri() . '/admin/inc/css/ultra-colors.css' );
	wp_enqueue_style( 'jultra-admin', get_template_directory_uri() . '/admin/inc/css/ultra-admin.css' );
	wp_enqueue_style( 'bootstrap-min', get_template_directory_uri() . '/admin/inc/css/bootstrap.min.css' );
	wp_enqueue_style( 'custom-min', get_template_directory_uri() . '/admin/inc/css/custom.min.css' );
	wp_enqueue_style( 'src-select2', get_template_directory_uri() . '/admin/inc/js/select2/dist/css/select2.min.css' ); 
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/admin/inc/css/font-awesome.css' );

	wp_enqueue_style('kv_js_time_style' , get_template_directory_uri(). '/admin/inc/css/jquery-ui-timepicker-addon.css');
	wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css');
	
	wp_enqueue_script( 'bootstrap-min', get_template_directory_uri() . '/admin/inc/js/bootstrap.min.js', array('jquery'), false, false );
	wp_enqueue_script( 'bpopup-min', get_template_directory_uri() . '/admin/inc/js/jquery.bpopup.min.js', array('jquery'), false, false );
	wp_enqueue_script( 'select2', get_template_directory_uri() . '/admin/inc/js/select2/dist/js/select2.full.min.js', array('jquery'), false, false );
	wp_enqueue_script( 'repeater', get_template_directory_uri() . '/admin/inc/js/jquery.repeater.js', array('jquery'), false, false );
	wp_enqueue_script( 'jquery-ui-js', get_template_directory_uri() . '/admin/inc/js/jquery-ui.js', array('jquery'), false, false );
	wp_enqueue_script('jquery-time-picker' ,  get_template_directory_uri(). '/admin/inc/js/jquery-ui-timepicker-addon.js',  array('jquery' ));	

	wp_enqueue_script( 'hot_key',  get_template_directory_uri() . '/admin/inc/js/jquery.hotkeys.js', array('jquery'), false, false );
	wp_enqueue_script( 'custom_script',  get_template_directory_uri() . '/admin/inc/js/custom-script.js', array('jquery'), false, false );
	wp_localize_script( 'custom_script', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	wp_localize_script( 'custom_script', 'home_page', array( 'url' => home_url( '/' ) ));
	wp_localize_script( 'custom_script', 'admin_page', array( 'quotation' => admin_url('admin.php?page=new_quotation'), 'deposit' => admin_url('admin.php?page=deposit'), 'delivery' => admin_url('admin.php?page=new_delivery'), 'return' => admin_url('admin.php?page=new_return'), 'hiring' => admin_url('admin.php?page=new_hiring'), 'obc' => admin_url('admin.php?page=new_obc'), 'statement' => admin_url('admin.php?page=new_statement')  ));

}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );



require get_template_directory() . '/admin/function.php';

require get_template_directory() . '/admin/menu-functions.php';
require get_template_directory() . '/admin/roles/function.php';
require get_template_directory() . '/admin/users/function.php';

require get_template_directory() . '/admin/customer/function.php';
require get_template_directory() . '/admin/lots/function.php';
require get_template_directory() . '/admin/stocks/function.php';
require get_template_directory() . '/admin/employee/function.php';


require get_template_directory() . '/admin/billing/master/function.php';
require get_template_directory() . '/admin/billing/quotation/function.php';
require get_template_directory() . '/admin/billing/deposit/function.php';
require get_template_directory() . '/admin/billing/delivery/function.php';
require get_template_directory() . '/admin/billing/return/function.php';
require get_template_directory() . '/admin/billing/hiring/function.php';
require get_template_directory() . '/admin/billing/obc/function.php';

require get_template_directory() . '/admin/report/master/function.php';
require get_template_directory() . '/admin/report/quotation/function.php';
require get_template_directory() . '/admin/report/deposit/function.php';
require get_template_directory() . '/admin/report/delivery/function.php';
require get_template_directory() . '/admin/report/return/function.php';
require get_template_directory() . '/admin/report/hiring/function.php';
require get_template_directory() . '/admin/report/obc/function.php';

require get_template_directory() . '/admin/statement/function.php';



function sales_statistics_widget( $post, $callback_args ) {
	include('admin/customer/ajax_loading/customer-list.php');
}
function sales_delivery_status_widget( $post, $callback_args ) {
	include('report/sales-delivery-status.php');
}
function stock_status_widget( $post, $callback_args ) {
	include('report/list-template/list-stock-detail.php');
}
function customer_status_widget( $post, $callback_args ) {
	include('report/customers-report.php');
}
function lot_status_chart_widget( $post, $callback_args ) {
	include('report/lot-chart.php');
}

function add_dashboard_widgets() {
	add_meta_box( 'my_sales_tatistics_widget', 'Sales Statistics', 'sales_statistics_widget', 'dashboard', 'normal', 'high' );
	add_meta_box( 'my_sales_delivery_status_widget', 'Sales Delivery Status', 'sales_delivery_status_widget', 'dashboard', 'side', 'high' );
	add_meta_box( 'my_stock_status_widget', 'Stock Status', 'stock_status_widget', 'dashboard', 'normal', 'low' );
	add_meta_box( 'lot_status_chart_widget', 'Top Sale', 'lot_status_chart_widget', 'dashboard', 'side', 'low' );
	add_meta_box( 'customer_status_widget', 'Customer List', 'customer_status_widget', 'dashboard', 'side', 'low' );
} 
add_action('wp_dashboard_setup', 'add_dashboard_widgets' );




function splitCurrency($price = 0.00) {
	$datas = explode( '.', $price );
	$data['rs'] = (isset($datas[0])) ? $datas[0] : 0;
	$data['ps'] = (isset($datas[1])) ? $datas[1] : 00;
	return $data;
}



function convert_number_to_words_full($number) {
    $n_substr = splitCurrency($number);
    $rs = $n_substr['rs'];
    $ps = $n_substr['ps'];
    $con = '';
    $ps_txt = '';
    $rs_txt = '';


    $rs_txt = convert_number_to_words($rs);

    if($ps && $ps != '00' ) {
      $con = ' and ';
      if(strlen($ps) < 2) {
      	$ps = $ps.'0';
      }
      $ps_txt = convert_number_to_words($ps).' Paisa';
    } 

    return $rs_txt . $con . $ps_txt .' Only';
}

function convert_number_to_words($num) {
	if (strlen($num) > 9) {
		return 'overflow';
	}
	$num = '000000000'.$num;

	$a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
	$b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

	preg_match('/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/', substr($num,-9), $numbers);

	$str = '';


	$first = ($a[intval($numbers[1])]) ? $a[intval($numbers[1])] : ($b[$numbers[1][0]].' '.$a[$numbers[1][1]]);
	$str .= ($numbers[1] != 0) ? ($second . 'crore ') : '';

	$second = ($a[intval($numbers[2])]) ? $a[intval($numbers[2])] : ($b[$numbers[2][0]].' '.$a[$numbers[2][1]]);
	$str .= ($numbers[2] != 0) ? ($second . 'lakh ') : '';

	$third = ($a[intval($numbers[3])]) ? $a[intval($numbers[3])] : ($b[$numbers[3][0]].' '.$a[$numbers[3][1]]);
	$str .= ($numbers[3] != 0) ? ($third . 'thousand ') : '';

	$fourth = ($a[intval($numbers[4])]) ? $a[intval($numbers[4])] : ($b[$numbers[4][0]].' '.$a[$numbers[4][1]]);
	$str .= ($numbers[4] != 0) ? ($fourth . 'hundred ') : '';

	$fifth = (($str != '') ? 'and ' : '');
	$fifth .= ($a[intval($numbers[5])]) ? $a[intval($numbers[5])] : ($b[$numbers[5][0]].' '.$a[$numbers[5][1]]);
	$str .= ($numbers[5] != 0) ? $fifth : '';


    return $str;

}




function getCorrectBillNumber($bill_no = '', $site_id = '', $bill_for = false, $financial_date = '') {
	global $wpdb;

	if($bill_for) {
		$bill_for_table = $wpdb->prefix.$bill_for;

		$financial_year = getFinancialYear( $financial_date );

		$bill_exist_query = "SELECT dep.bill_no FROM ${bill_for_table} as dep WHERE dep.bill_no = ${bill_no} AND dep.financial_year = ${financial_year} AND dep.bill_from_comp = ( SELECT c.bill_from_comp FROM wp_shc_customer_site as cs JOIN wp_shc_customers as c ON c.id = cs.customer_id WHERE cs.id = ${site_id} LIMIT 1 )";

		
		if($wpdb->get_row($bill_exist_query)) {
			$query = "SELECT fc.*, comp.company_id, (CASE WHEN fc.bill_no is null THEN 1 ELSE fc.bill_no + 1 END) next_bill_no FROM (SELECT cs.*, c.bill_from_comp, (SELECT d.bill_no from ${bill_for_table} as d WHERE d.bill_from_comp = c.bill_from_comp AND d.financial_year = ${financial_year} ORDER BY bill_no DESC LIMIT 1 ) as bill_no FROM `wp_shc_customer_site` as cs JOIN wp_shc_customers as c ON c.id = cs.customer_id WHERE cs.id = ${site_id} ) as fc JOIN wp_shc_companies as comp ON comp.id = fc.bill_from_comp";
			if( $bill_data = $wpdb->get_row($query) ) {

				$data['bill_from_comp'] = $bill_data->bill_from_comp;
				$data['bill_no'] = $bill_data->next_bill_no;

				return $data;
			}
		} else {
			$query = "SELECT c.bill_from_comp FROM wp_shc_customer_site cs JOIN wp_shc_customers as c ON c.id = cs.customer_id WHERE cs.id = ${site_id}";
			$cus_data = $wpdb->get_row($query);

			$data['bill_from_comp'] = $cus_data->bill_from_comp;
			$data['bill_no'] = $bill_no;
			return $data;
		}
		return false;
	}

}


function billno_check() {
	$bill_no = isset( $_POST['bill_no'] ) ? $_POST['bill_no'] : 0;
	$bill_for = isset( $_POST['bill_for'] ) ? $_POST['bill_for'] : 0;
	$site_id = isset( $_POST['site_id'] ) ? $_POST['site_id'] : 0;
	$financial_date = isset( $_POST['financial_date'] ) ? $_POST['financial_date'] : date('Y-m-d');

	$bill_data = getCorrectBillNumber($bill_no, $site_id, $bill_for, $financial_date);
	if($bill_data['bill_no'] == $bill_no) {
		$data['success'] = true;
	} else {
		$data['success'] = false;
	}
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_billno_check', 'billno_check' );
add_action( 'wp_ajax_nopriv_billno_check', 'billno_check' );








if ( is_admin() ){
    add_action('init', 'create_initial_pages');
}
function create_initial_pages() {

    $pages = array( 
        'Quotation' => array(
            'Quotation'=>'template-quotation-invoice.php'),
        'Deposit' => array(
            'Deposit Invoice'=>'template-deposit-invoice.php'),
        'Delivery' => array(
            'Delivery Invoie'=>'template-delivery-invoice.php'),
        'Return' => array(
            'Return Invoice'=>'template-return-invoice.php'),
        'Hiring Bill' => array(
            'Hiring Bill'=>'template-hiring-invoice.php'),
        'Receipt' => array(
            'Receipt'=>'template-receipt-invoice.php'),
        'Statement' => array(
            'Statement'=>'template-statement-invoice.php'),
    );

    foreach( $pages as $page_url_title => $page_meta ) {

        $id = get_page_by_title($page_url_title);

        foreach ($page_meta as $page_content=>$page_template){

            $page = array(
                'post_type'   => 'page',
                'post_title'  => $page_url_title,
                'post_name'   => $page_url_title,
                'post_status' => 'publish',
                'post_content' => $page_content,
                'post_author' => 1,
                'post_parent' => ''
            );

            if(!isset($id->ID)){
                $new_page_id = wp_insert_post($page);
                if(!empty($page_template)){
                    update_post_meta($new_page_id, '_wp_page_template', $page_template);
                }
            }
        }
    }
}


function create_admin_history($data) {
	global $wpdb;
	$table = $wpdb->prefix.'shc_admin_history';
	$wpdb->insert($table, $data);

	
	//customer_create
	//customer_update
	//site_create
	//site_update
	//special_price_create
}



function billNumberText($bill_from_comp = 0, $bill_no = 0, $bill_for = 0) {

	$company_data = getCompaniesById($bill_from_comp);

	$data['company_name'] 	= 	$company_data->company_name;
	$data['company_id'] 	= 	$company_data->company_id;
	$data['bill_no'] = 0;
	if($bill_no && $bill_for) {
		$data['bill_no'] = $data['company_id'].'/'.$bill_for.' : '.$bill_no;
	}
	return $data;
}


function getFinancialYear( $current_date = '' ) {
	$month = date('m', strtotime($current_date));
	$year = date('Y', strtotime($current_date));

    if( $month >= 4 ) {
    	$financial_year = $year;
    } else {
		$financial_year = ( $year - 1 );
    }
    return $financial_year;
}


function moneyFormatIndia($num){

$explrestunits = "" ;
$num=preg_replace('/,+/', '', $num);
$words = explode(".", $num);
$des="00";
if(count($words)<=2){
    $num=$words[0];
    if(count($words)>=2){$des=$words[1];}
    if(strlen($des)<2){$des="$des0";}else{$des=substr($des,0,2);}
}
if(strlen($num)>3){
    $lastthree = substr($num, strlen($num)-3, strlen($num));
    $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
    $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
    $expunit = str_split($restunits, 2);
    for($i=0; $i<sizeof($expunit); $i++){
        // creates each of the 2's group and adds a comma to the end
        if($i==0)
        {
            $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
        }else{
            $explrestunits .= $expunit[$i].",";
        }
    }
    $thecash = $explrestunits.$lastthree;
} else {
    $thecash = $num;
}
return "$thecash.$des"; // writes the final format where $currency is the currency symbol.

}






// Admin footer modification
function remove_footer_admin() {
	echo '<div class="delete-box" style="display:none;"><div class="action-block"></div></div>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

/*SELECT l.*,sale_bal.sale_unit, stock_bal.stock_total FROM wp_shc_lots as l LEFT JOIN 
( SELECT sd.lot_id, sum(sd.sale_unit) sale_unit FROM wp_shc_sale_detail as sd JOIN wp_shc_sale as s ON s.id = sd.sale_id WHERE s.locked = 1 AND s.active = 1 AND sd.item_status = 'open' AND sd.active = 1 GROUP BY sd.lot_id ) as sale_bal
ON l.id = sale_bal.lot_id LEFT JOIN 

(SELECT st.lot_number, SUM(st.stock_count) as stock_total FROM wp_shc_stock as st WHERE st.active = 1 GROUP BY st.lot_number) as stock_bal
ON l.id = stock_bal.lot_number*/




/*function getBillDetail($customer_id=0, $bill_type = '') {
	
}*/
?>