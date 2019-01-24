<?php
/**
 * Template Name: Quotation Invoice 
 *
 * @package WordPress
 * @subpackage SHC
 */
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/admin/inc/css/ultra-colors.css';?>" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/admin/inc/css/ultra-admin.css';?>" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/admin/inc/css/bootstrap.min.css';?>" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/admin/inc/css/custom.min.css';?>" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/admin/inc/images/invoice/fonts/stylesheet.css';?>" type="text/css" media="all" />
</head>
<body class="page">

<?php
$quotation_data = false;
$hiring_gst_data = false;
$bill_data = getQutationDetail($_GET['quotation_no']);
$headers = ( isset($_GET['headers']) && $_GET['headers'] !== '' && $_GET['headers'] == 'yes' ) ? true : false;
if(!$headers) {
	echo "<style>";
	echo ".company-head{height:105px;} .company-detail-left .company-address, .company-detail-left .company-name {display:none;} .right-logo {display:none;} .footerb .foot {height:20px; background: none !important; height:20px;} .footerb .foot div { display: none;}";
	echo "</style>";
} else {
	echo ".footerb .foot {background-color: #67a3b7;-webkit-print-color-adjust: exact;}";
}


if(isset($bill_data['quotation_data']) && isset($_GET['quotation_no']) && $_GET['quotation_no'] != '') {
	$quotation_data = $bill_data['quotation_data'];
	$company_id = $quotation_data->bill_from_comp;
	$company_data = getCompaniesById($company_id);
	$master_data = getMasterDetail($quotation_data->master_id);
	$master_data = ($master_data) ? $master_data : false;
	$customer_id = $master_data['master_data']->customer_id;
	$site_id = $master_data['master_data']->site_id;
	$customer_detail = getCustomerData($customer_id);
	$site_detail = getSiteData($site_id);
	$bill_number = billNumberText($company_id, $bill_data['quotation_data']->bill_no, 'Quotation');
	$tax_for = $quotation_data->tax_from;
	$gst_total = $quotation_data->cgst_amt + $quotation_data->sgst_amt + $quotation_data->igst_amt;
}


/*$tot_record = 23;
//$tot_record = 77;
$p_pag = 27;
$rem = ($tot_record%$p_pag);
$to_pages = ceil($tot_record/$p_pag);
$to_pages = ($rem < 23 && $rem !=0 ) ? $to_pages : $to_pages + 1;
$adj = ($rem < 23 && $rem !=0 ) ? false : true;



var_dump("tot_record ".$tot_record);echo "<br>";
var_dump("rem ".$rem);echo "<br>";
var_dump("tot_page ".$to_pages);echo "<br>";


for ($i=1; $i <= $to_pages ; $i++) {
	$last_prev = $to_pages - 1;

	$cur_count = $p_pag;

	if($i == $to_pages) {
		$cur_count = ( $tot_record < 23 ) ? $tot_record : $rem;
		$cur_count = ($rem == 0 ) ? 1  : $cur_count;

		var_dump($cur_count);
	}
	if($i == $last_prev) {
		//$cur_count = ($tot_record < $p_pag ) ? ($rem - 1)  : $p_pag;
		$cur_count = ($tot_record < $rem ) ? ($rem - 1)  : $p_pag;
		$cur_count = ( $rem <= 23 ) ? ($rem - 1) : $cur_count;
		$cur_count = ($rem == 0 ) ? ($p_pag - 1)  : $cur_count;
	}


	var_dump("page ".$i." count ".$cur_count);
	echo "<br>";

}
*/

	$pages = false;
	$per_page = 23;
	$pieces = false;
	$tota_row = 0;
	$reminder = 8;
	$last_page = 0;

	if($quotation_data) {
		$pages = ceil(count($bill_data['quotation_detail'])/$per_page);
		$pieces = array_chunk($bill_data['quotation_detail'], $per_page);
		$tota_row = count($bill_data['quotation_detail']);
		$reminder = ($tota_row % $per_page);
	}
?>
	<style type="text/css">

		@page {
		    size: 'A4';
		    margin: 0px;
		    padding-bottom: 100px;
		    font-size: 10px;
		}
		@media print {


			body {
				font-family: "Lucida Sans Unicode", "Lucida Grande", "sans-serif";
				font-size: 10px;
			}
			.inner-container {
				padding-left: 100px;
				padding-right: 60px;
				width: 794px;
			}
			.left-float {
				float: left;
			}
			.top-left {
				width: 160px;
			}
			.top-center {
				width: 284px;
			}
			.top-right {
				width: 190px;
			}
			.left-logo img, .right-logo img {
				width: 100%;
			}
			.comp-detail {
				padding-left: 5px;
			}

			.comp-detail-in .detail-left {
				width: 55px;
			}

			.customer-detail-left {
				width: 400px;
			}
			.company-detail-left {
				width: 444px;
			}
			.company-detail-left .company-name h3 {
			    font-family: serif;
    			font-weight: bold;
    			font-size: 24px;
    			margin-bottom: 3px;
			}
			.company-detail-left .company-address, .company-detail-left .company-gst {
			    font-size: 13px;
    			font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
			}

			.customer-detail-right {
				width: 234px;
			}

			.text-center {
				text-align: center;
			}
			.text-rigth {
				text-align: right;
			}
		    .table td, .table th {
		      background-color: transparent !important;
		    }
		    .page-block {
		    	padding-bottom: 100px;
		    }
			.footerb {
			    position: static;
			    bottom: 20px;
			    left: 0px;
			    width: 100%;
			    background: gray;
			}
			.table>tbody>tr>td {
				padding: 1px 3px;
				height: 15px;
			}
			.table-bordered>tbody>tr>td, .table-bordered>thead>tr>th {
				border: 1px solid #000 !important;
				-webkit-print-color-adjust: exact;
			}
			.billing-title {
				text-align: center;
				font-weight: bold;
				font-size: 14px;
    			text-decoration: underline;
			}
			h3 {
				margin-top: 0px;
			}
			ol, ul {
				padding-left: 13px;
				list-style: none;
			}
			.change_height {
				height: 23px;
			}
			.pagebreak { page-break-before: always; }

		}
			body {
				font-family: "Lucida Sans Unicode", "Lucida Grande", "sans-serif";
				font-size: 10px !important;
			}
			.inner-container {
				padding-left: 100px;
				padding-right: 60px;
				width: 794px;
			}
			.left-float {
				float: left;
			}
			.top-left {
				width: 160px;
			}
			.top-center {
				width: 284px;
			}
			.top-right {
				width: 190px;
			}
			.left-logo img, .right-logo img {
				width: 100%;
			}
			.comp-detail {
				padding-left: 5px;
			}

			.comp-detail-in .detail-left {
				width: 55px;
			}

			.customer-detail-left {
				width: 400px;
			}
			.company-detail-left {
				width: 444px;
			}
			.company-detail-left .company-name h3 {
			    font-family: serif;
    			font-weight: bold;
    			font-size: 24px;
    			margin-bottom: 3px;
			}
			.company-detail-left .company-address, .company-detail-left .company-gst {
			    font-size: 13px;
    			font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
			}

			.customer-detail-right {
				width: 234px;
			}

			.text-center {
				text-align: center;
			}
			.text-rigth {
				text-align: right;
			}
		    .table td, .table th {
		      background-color: transparent !important;
		    }
		    .page-block {
		    	padding-bottom: 100px;
		    }
			.footerb {
				/*position: fixed;*/
            	bottom: 0px;
            	left: 0px;
			}

			.table>tbody>tr>td {
				padding: 1px 3px;
				height: 15px;
			}
			.table-bordered>tbody>tr>td, .table-bordered>thead>tr>th {
				border: 1px solid #000 !important;
				-webkit-print-color-adjust: exact;
			}

			.billing-title {
				text-align: center;
				font-weight: bold;
				font-size: 14px;
    			text-decoration: underline;
			}
			h3 {
				margin-top: 0px;
			}
			ol, ul {
				padding-left: 15px;
				list-style: none;
			}
			.change_height {
				height: 23px;
			}
			.pagebreak { page-break-before: always; }

	</style>

<div class="page-block">
	<table class=""> 
		<thead>
			<tr>
				<td>
					<div class="customer-detail inner-container" style="margin-top: 20px;">
						<div class="left-float company-detail-left">
							<div class="company-head">
								<div class="company-name">
									<h3><?php echo $company_data->company_name; ?></h3>
								</div>
								<div class="company-address">
									<?php echo $company_data->address; ?>
								</div>
								<div class="company-address">
									TEL: <?php echo $company_data->phone; ?>
								</div>
								<div class="company-address">
									Mobile: <?php echo $company_data->mobile; ?>
								</div>	
							</div>
							<div class="company-gst" style="margin-top:20px;">
							<?php
								if(isset($tax_for) && $tax_for == 'no_tax') {
									echo "";
								} else if(isset($tax_for) && $tax_for == 'vat') {
									echo "<b>TIN: ".$company_data->tin_number."</b>";
								} else {
									echo "<b>GSTIN: ".$company_data->gst_number."</b>";
								}
							?>
							</div>
						</div>
						<div class="left-float top-right">
							<div class="right-logo">
								<img src="<?php echo get_template_directory_uri().'/admin/inc/images/invoice/'.$company_data->company_id.'.jpg' ;?>">
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="customer-detail inner-container" style="margin-top: 2px;margin-bottom:2px;">
						<div class="billing-title">
							QUOTATION
						</div>
					</div>
				</td>
			</tr>
		</thead>
		<tbody>
		<?php
			for ($i = 0; $i < $pages; $i++) { 
				$page_start = ( $i * $per_page ) + 1;
				$current_page = ($i + 1);
				$tr_class = ($current_page != $pages) ? 'change_height' : '';
				include( get_template_directory().'/quotation-print-contenet.php' );
			}
		?>
		</tbody>
	</table>

	<?php 
		if($reminder == 0) {
	?>
		<div class="pagebreak" style="margin-top:100px;"> </div>
		<div class="" style="padding-top:5px;"></div>
		<table>
			<tr>
				<td>
					<div class="customer-detail inner-container" style="margin-top: 20px;">
						<div class="left-float company-detail-left">
							<div class="company-head">
								<div class="company-name">
									<h3><?php echo $company_data->company_name; ?></h3>
								</div>
								<div class="company-address">
									<?php echo $company_data->address; ?>
								</div>
								<div class="company-address">
									TEL: <?php echo $company_data->phone; ?>
								</div>
								<div class="company-address">
									Mobile: <?php echo $company_data->mobile; ?>
								</div>								
							</div>

							<div class="company-gst" style="margin-top:20px;">
							<?php
								if(isset($tax_for) && $tax_for == 'no_tax') {
									echo "";
								} else if(isset($tax_for) && $tax_for == 'vat') {
									echo "<b>TIN: ".$company_data->tin_number."</b>";
								} else {
									echo "<b>GSTIN: ".$company_data->gst_number."</b>";
								}
							?>
							</div>
						</div>
						<div class="left-float top-right">
							<div class="right-logo">
								<img src="<?php echo get_template_directory_uri().'/admin/inc/images/invoice/'.$company_data->company_id.'.jpg' ;?>">
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</td>
			</tr>			
		</table>
		<div class="" style="padding-top:15px;"></div>
	<?php
		}

		$requirement_arr = explode("<li>", str_replace(array("<ol>","</ol>"),"",$quotation_data->requirements));
		$requirement_arr = array_filter($requirement_arr, function($value) { return trim($value) !== ''; });
		$fixed = 18;
		$to_loop = $fixed - $reminder;
		if($reminder >= 11 && $reminder < 18) {
	?>
		<div>
			<table>
				<tr>
					<td>
						<div class="customer-detail inner-container" style="margin-top: 15px;">
							<h4><u>Requirements :-</u></h4>
							<ul>
							<?php 
								foreach ($requirement_arr as $key => $value) {
									$count = $key . '. ';
									$li_data = str_replace(array("<ol>","</ol>","<li>","</li>"),"",$value);
									if( $key <= $to_loop && $li_data != '') {
										echo "<li>".$count.$li_data."</li>";
										unset($requirement_arr[$key]);
									}
								}
							?>
							</ul>
						</div>
					</td>
				</tr>
			</table>
		</div>
	<?php
		}
		if($reminder>=11) {
	?>
		<div class="pagebreak" style="margin-top:100px;"> </div>
		<div class="" style="padding-top:5px;"></div>
		<table>
			<tr>
				<td>
					<div class="customer-detail inner-container" style="margin-top: 20px;">
						<div class="left-float company-detail-left">
							<div class="company-head">
								<div class="company-name">
									<h3><?php echo $company_data->company_name; ?></h3>
								</div>
								<div class="company-address">
									<?php echo $company_data->address; ?>
								</div>
								<div class="company-address">
									TEL: <?php echo $company_data->phone; ?>
								</div>
								<div class="company-address">
									Mobile: <?php echo $company_data->mobile; ?>
								</div>								
							</div>

							<div class="company-gst" style="margin-top:20px;">
							<?php
								if(isset($tax_for) && $tax_for == 'no_tax') {
									echo "";
								} else if(isset($tax_for) && $tax_for == 'vat') {
									echo "<b>TIN: ".$company_data->tin_number."</b>";
								} else {
									echo "<b>GSTIN: ".$company_data->gst_number."</b>";
								}
							?>
							</div>
						</div>
						<div class="left-float top-right">
							<div class="right-logo">
								<img src="<?php echo get_template_directory_uri().'/admin/inc/images/invoice/'.$company_data->company_id.'.jpg' ;?>">
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</td>
			</tr>			
		</table>
		<div class="" style="padding-top:15px;"></div>
	<?php
		}
		if(is_array($requirement_arr) && count($requirement_arr) > 0) {
	?>
		<div>
			<table>
				<tr>
					<td>
						<div class="customer-detail inner-container" style="margin-top: 15px;">
							<?php
								if(array_key_exists(1,$requirement_arr)) {
									echo "<h4><u>Requirements :-</u></h4>";
								}
							?>
							<ul>
							<?php 
								foreach ($requirement_arr as $key => $value) {
									$count = $key . '. ';
									$li_data = str_replace(array("<ol>","</ol>","<li>","</li>"),"",$value);
									echo "<li>".$count.$li_data."</li>";
									unset($requirement_arr[$key]);
								}
							?>
							</ul>
						</div>
					</td>
				</tr>
			</table>
		</div>
	<?php
		}
		if($reminder > 6 && $reminder < 11) {
	?>
		<div class="pagebreak" style="margin-top:100px;"> </div>
		<div class="" style="padding-top:5px;"></div>
		<table>
			<tr>
				<td>
					<div class="customer-detail inner-container" style="margin-top: 20px;">
						<div class="left-float company-detail-left">
							<div class="company-head">
								<div class="company-name">
									<h3><?php echo $company_data->company_name; ?></h3>
								</div>
								<div class="company-address">
									<?php echo $company_data->address; ?>
								</div>
								<div class="company-address">
									TEL: <?php echo $company_data->phone; ?>
								</div>
								<div class="company-address">
									Mobile: <?php echo $company_data->mobile; ?>
								</div>								
							</div>

							<div class="company-gst" style="margin-top:20px;">
							<?php
								if(isset($tax_for) && $tax_for == 'no_tax') {
									echo "";
								} else if(isset($tax_for) && $tax_for == 'vat') {
									echo "<b>TIN: ".$company_data->tin_number."</b>";
								} else {
									echo "<b>GSTIN: ".$company_data->gst_number."</b>";
								}
							?>
							</div>
						</div>
						<div class="left-float top-right">
							<div class="right-logo">
								<img src="<?php echo get_template_directory_uri().'/admin/inc/images/invoice/'.$company_data->company_id.'.jpg' ;?>">
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</td>
			</tr>			
		</table>
		<div class="" style="padding-top:15px;"></div>
	<?php
		}
	?>

		<div class="customer-detail inner-container" style="margin-top: 0px;margin-bottom:0px;">
			<table class="table" style="margin-bottom:0px;">
				<tr>
					<td style="width:380px;">
						<table class="table table-bordered">
							<tr>
								<td style="width: 120px;"><div class="text-center" style="padding:5px;">Other Requirements</div></td>
								<td><div class="text-center" style="padding:5px;">Passport size Photo, ID Proof, Address Proof, (Company Details, Site Details, All Contract Details)</div></td>
							</tr>
						</table>
						<table class="table table-bordered" style="margin-bottom:0px;">
							<tr>
								<td style="width: 120px;"><div class="text-center" style="padding:5px;">Amount Payable</div></td>
								<td><div class="text-center" style="padding:5px;font-weight:bold;font-size:16px;">Rs. <?php echo moneyFormatIndia($quotation_data->amount_payable); ?></div></td>
							</tr>
						</table>
					</td>
					<td>
						<table class="table table-bordered" style="margin-bottom:0px;">
							<tr>
								<td>
									<div class="text-left" style="padding:5px;   min-height: 115px;">
										<b><u>Banking Details</u></b><br>
										<?php echo $quotation_data->bank_details ?>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
</div>




<div class="footerb" style="margin-bottom:20px;position:fixed;bottom:0;">
	<div class="inner-container" style="margin-top: 5px;">
		<div class="left-float" style="width: 480px;float: left;padding-right: 10px;">
			<div style="float: left;padding-right: 10px;font-size: 10px;margin-top: 30px;">
				Immediate interest @ 24% p.a. will be charged if not paid within 3 days from the date of the bill
				<ul style="margin-bottom: 2px;">
					<li>All materials should be returned thoroughly cleaned and oiled</li>
					<li>White waste oil should be used for oiling all materials</li>
					<li>For all materials minimum hire charges will be for 30 days</li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		<div class="left-float" style="width: 154px;margin-top:15px;">
			<div class="company-name" style="font-family: serif;font-weight: bold;font-size: 16px;">
				For <?php echo $company_data->company_name; ?>
			</div>
			<div style="margin-top: 30px;">Manager / Accountant</div>
		</div>
		<div class="clear"></div>
	</div>

	<div class="inner-container foot" style="width: 810px;line-height: 20px;font-size: 14px;color: #fff !important;">
		<div class="left-float" style="width:325px;font-size: 14px;color: #fff !important;text-align: center;">Email : <?php echo $company_data->email; ?></div>
		<div class="left-float" style="width:325px;font-size: 14px;color: #fff !important;text-align: center;">Website : <?php echo $company_data->website; ?></div>
		<div class="clear"></div>
	</div>
</div>


</body>
</html>