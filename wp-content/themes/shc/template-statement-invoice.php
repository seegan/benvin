<?php
/**
 * Template Name: Statement
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
$statement_data = false;
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d');
$bill_data = getAccountStatement($_GET['statement_id'], $date_to);

$cd_data = isset($bill_data['cd_total']) ? $bill_data['cd_total'] : false;


	$credit_amount = 0.00;
	$debit_amount = 0.00;
	$credit_close = '';
	$debit_close = '';

	if( isset($cd_data->credit_total) && $cd_data->credit_total <= $cd_data->debit_total ) {
		$credit_amount = number_format((float)$cd_data->debit_total, 2, '.', '');
		$debit_amount = number_format((float)$cd_data->debit_total, 2, '.', '');
	} else {
		$credit_amount = number_format((float)$cd_data->credit_total, 2, '.', '');
		$debit_amount = number_format((float)$cd_data->credit_total, 2, '.', '');
	}

	if($cd_data->cd_bal < 0) {
		$credit_bal = number_format((float)(abs($cd_data->cd_bal)), 2, '.', '');
		$debit_bal = '';
	}
	if($cd_data->cd_bal > 0) {
		$credit_bal = '';
		$debit_bal = number_format((float)(abs($cd_data->cd_bal)), 2, '.', '');
	}
	if($cd_data->cd_bal == 0) {
		$credit_bal = '';
		$debit_bal = '';
	}





$statement_id = explode(",", $_GET['statement_id']);
$statement_id = isset($statement_id[0]) ? $statement_id[0] : 0;

if(isset($_GET['statement_id']) && $_GET['statement_id'] != ''){
	$statement_data = $bill_data['statement_data'];

	$master_data = getMasterDetail($statement_id);
	$master_data = ($master_data) ? $master_data : false;



/*	$company_id = $statement_data->bill_from_comp;
	$company_data = getCompaniesById($company_id);*/

	$customer_id = $master_data['master_data']->customer_id;
	$site_id = $master_data['master_data']->site_id;

	$customer_detail = getCustomerData($customer_id);
	$site_detail = getSiteData($site_id);

	$company_ids = getCompanies('to_list');
}

	$pages = false;
	$per_page = 32;
	$pieces = false;
	$tota_row = 0;

	if($statement_data) {
		$pages = ceil(count($bill_data['statement_data'])/$per_page);
		$pieces = array_chunk($bill_data['statement_data'], $per_page);
		$tota_row = count($bill_data['statement_data']);
		$reminder = ($tota_row % $per_page);
/*				$page_short = false;
		if($reminder > 12) {
			$pages = $pages + 1;
			$page_short = true;
		}*/
	}



	$credit[-1] = 0;
	$debit[-1] = 0;
	for ($i = 0; $i < $pages; $i++) { 
		$tot_tmp_cr = 0;
		$tot_tmp_dr = 0;
		foreach ($pieces[$i] as $key => $h_value) {
			$tot_tmp_cr = $tot_tmp_cr + $h_value->credit;
			$tot_tmp_dr = $tot_tmp_dr + $h_value->debit;
		}
		$credit[$i] = $credit[$i-1] + $tot_tmp_cr;
		$debit[$i] = $debit[$i-1] + $tot_tmp_dr;
	}


?>


	<style type="text/css">

		@page {
		    size: 'A4';
		    margin: 0px;
		    padding: 0;
		}
		@media print {



/*total width 794*/

			.body {
				font-family: "Lucida Sans Unicode", "Lucida Grande", "sans-serif";
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
			.company-detail-left .company-address {
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
		    .bill-detail {
		    	height: 650px;
		    }

			.footer {
				position: fixed;
            	bottom: 0px;
            	left: 0px;
			}
			.footer .foot {
			    background-color: #67a3b7 !important;
			    -webkit-print-color-adjust: exact;
			}

			.table>tbody>tr>td {
				padding: 0 3px;
				height: 20px;
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
/*.footer {
  background: #ade6df;
  color: #fff;
  text-align: center;
  font-family: 'Open Sans', sans-serif;
  padding: 5px 0;
  font-weight: 300;
  position: fixed;
  bottom: 0;
  width: 715px;
}*/

		}



			.body {
				font-family: "Lucida Sans Unicode", "Lucida Grande", "sans-serif";
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
			.company-detail-left .company-address {
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
		    .bill-detail {
		    	height: 650px;
		    }

			.footer {
				position: fixed;
            	bottom: 0px;
            	left: 0px;
			}
			.footer .foot {
			    background-color: #67a3b7 !important;
			    -webkit-print-color-adjust: exact;
			}

			.table>tbody>tr>td {
				padding: 0 3px;
				height: 20px;
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
	</style>



<table class=""> 
	<thead>
		<tr>
			<td>
				<div class="customer-detail inner-container" style="margin-top: 20px;">
					<div class="left-float company-detail-left">
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

						<div class="company-address">
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
							<img src="http://192.168.0.150/benvin/wp-content/themes/shc/admin/inc/images/invoice/right-logo-1.jpg">
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
		?>
			<tr>
				<td>
					<div class="inner-container" style="margin-top: 0px;">
						<div class="bill-detail">
							<table class="table table-bordered" style="margin-bottom: 2px;">
								<thead>
									<tr>
										<th colspan="6">
											<div class="text-center" style="padding:5px;">
												<div style="margin-left:30px;line-height:10px;">
													<?php
														echo strtoupper($customer_detail->name) .' - A/C STATEMENT';
													?>
												</div>
												<div style="margin-left:30px;margin-top:5px;">
													<?php
														echo 'Site : '. $site_detail->site_name;
													?>
												</div>
												<div style="margin-left:30px;margin-top:5px;">
													<?php
														echo 'As On : '. $date_to;
													?>
												</div>
											</div>
										</th>
									</tr>
									<tr>
										<th style="width:35px;" class="center-th">
											<div class="text-center">S.No</div>
										</th>
										<th class="center-th" style="width: 85px;">
											<div class="text-center">Date</div>
										</th>
										<th class="center-th">
											<div class="text-center">Description</div>
										</th>
										<th class="center-th">
											<div class="text-center">Bill Ref</div>
										</th>
										<th class="center-th">
											<div class="text-center">Cr.</div>
										</th>
										<th class="center-th">
											<div class="text-center">Dr.</div>
										</th>
									</tr>
								</thead>


								<?php
								if($current_page > 1) {
								?>
									<tr>
										<td colspan="4">
											<div class="text-center">BF / TOTAL</div>
										</td>
										<td>
											<div class="text-right">
												<?php echo moneyFormatIndia( number_format($credit[$i-1],2) ); ?>
											</div>
										</td>
										<td>
											<div class="text-right">
												<?php echo moneyFormatIndia( number_format($debit[$i-1],2) ); ?>
											</div>
										</td>
									</tr>
								<?php
								}
								foreach ($pieces[$i] as $key => $value) {
									$company_id = $value->bill_from_comp;

									if($value->description == 'Missing Cost'  ) {
										if($value->debit && $value->debit != 0) {
								?>
											<tr>
												<td>
													<?php echo date("d-m-Y", strtotime($value->bill_date)); ?>
												</td>
												<td>
													<?php echo $value->description; ?>
												</td>
												<td>
													
												</td>
												<td class="right-align-txt">
													<?php echo $value->credit; ?>
												</td>
												<td class="right-align-txt">
													<?php echo $value->debit; ?>
												</td>
											</tr>
								<?php
										}
									} else {
								?>
									<tr>
										<td>
											<div class="text-center">
												<?php echo $page_start ?>
											</div>
										</td>
										<td>
											<div class="text-center">
												<?php echo date("d-m-Y", strtotime($value->bill_date)); ?>
											</div>
										</td>
										<td>
											<div class="text-center">
												<?php echo $value->description; ?>
											</div>
										</td>
										<td>
											<div class="text-center">
												<?php echo $company_ids[$company_id].'/'.$value->bill_ref; ?>
											</div>
										</td>
										<td>
											<div class="text-rigth">
												<?php echo $value->credit; ?>
											</div>
										</td>
										<td>
											<div class="text-rigth">
												<?php echo $value->debit; ?>
											</div>
										</td>
									</tr>
								<?php
										$page_start++;
									}
								}
									if($pages == $current_page) {
								?>
										<tr>
											<td colspan="3">
												<div class="text-center">Closing Balance</div>
											</td>
											<td class="right-align-txt">RS</td>
											<td class="right-align-txt">
												<?php echo ( $credit_bal != 0 ) ? moneyFormatIndia($credit_bal) : ''; ?>
											</td>
											<td class="right-align-txt">
												<?php echo ( $debit_bal != 0 ) ? moneyFormatIndia($debit_bal) : ''; ?>
											</td>
										</tr>
										<tr>
											<td colspan="3">
												<div class="text-center">Total</div>
											</td>
											<td class="right-align-txt">RS</td>
											<td class="right-align-txt">
												<?php echo ( $credit_amount != 0 ) ? moneyFormatIndia($credit_amount) : ''; ?>
											</td>
											<td class="right-align-txt">
												<?php echo ( $debit_amount != 0 ) ? moneyFormatIndia($debit_amount) : ''; ?>
											</td>
										</tr>
								<?php
									} else {
								?>
										<tr>
											<td colspan="4">
												<div class="text-center">CF / TOTAL</div>
											</td>
											<td>
												<div class="text-right">
													<?php echo moneyFormatIndia( number_format($credit[$i],2) ); ?>
												</div>
											</td>
											<td>
												<div class="text-right">
													<?php echo moneyFormatIndia( number_format($debit[$i],2) ); ?>
												</div>
											</td>
										</tr>
								<?php
									}

								?>
								
							</table>
						</div>
					</div>
				</td>
			</tr>
		<?php
			}
		?>
	</tbody>
</table>

<div class="footer" style="margin-bottom:20px;">





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
			<div class="left-float" style="width:325px;font-size: 14px;color: #fff !important;text-align: center;">Email : infojbcaccesss@gmail.com</div>
			<div class="left-float" style="width:325px;font-size: 14px;color: #fff !important;text-align: center;">Website : www.jcbascdfdsgdfg.in</div>
			<div class="clear"></div>
		</div>
</div>


</body>
</html>