<?php
/**
 * Template Name: Deposit Invoice 
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
$hiring_data = false;
$bill_data = getHiringBillDataPrint($_GET['bill_no']);
if(isset($bill_data['hiring_data']) && isset($_GET['bill_no']) && $_GET['bill_no'] != '') {
	$hiring_data = $bill_data['hiring_data'];

	$company_id = $hiring_data->bill_from_comp;
	$company_data = getCompaniesById($company_id);

	$master_data = getMasterDetail($hiring_data->master_id);
	$master_data = ($master_data) ? $master_data : false;

	$customer_id = $master_data['master_data']->customer_id;
	$site_id = $master_data['master_data']->site_id;

	$customer_detail = getCustomerData($customer_id);
	$site_detail = getSiteData($site_id);

	$bill_number = billNumberText($company_id, $bill_data['hiring_data']->bill_no, 'HB');

	$tax_for = $hiring_data->tax_from;

	$gst_total = $hiring_data->cgst_amt + $hiring_data->sgst_amt + $hiring_data->igst_amt;
}

	$pages = false;
	$per_page = 16;
	$pieces = false;
	$tota_row = 0;

	if($hiring_data) {
		$pages = ceil(count($bill_data['hiring_detail'])/$per_page);
		$pieces = array_chunk($bill_data['hiring_detail'], $per_page);
		$tota_row = count($bill_data['hiring_detail']);
		$reminder = ($tota_row % $per_page);
/*				$page_short = false;
		if($reminder > 12) {
			$pages = $pages + 1;
			$page_short = true;
		}*/
	}



	$page_total[-1] = 0;
	for ($i = 0; $i < $pages; $i++) { 
		$tot_tmp = 0;
		foreach ($pieces[$i] as $key => $h_value) {
			$tot_tmp = $tot_tmp + $h_value->hiring_amt;
		}
		$page_total[$i] = $page_total[$i-1] + $tot_tmp;
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
						HIRE BILL
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
										<th colspan="4">
											<div style="min-height: 100px;padding:5px;">
												<div style="line-height:10px;">
													To: 
												</div>
												<div style="margin-left:30px;line-height:10px;">
													<?php
														echo $customer_detail->name;
													?>
												</div>
												<div style="margin-left:30px;margin-top:5px;">
													<?php
														echo $customer_detail->address;
													?>
												</div>
											</div>
										</th>
										<th colspan="4">
											<div style="min-height: 100px;padding:5px;">
												<div>
													<div style="line-height: 20px;height: 25px;">
														<div style="float:left;width: 60px">BILL NO</div>
														<div style="float:left;">
															: <?php echo $bill_number['bill_no']; ?>
														</div>
														<div class="clear"></div>
													</div>
													<div style="line-height: 20px;height: 25px;">
														<div style="float:left;width: 60px">DATE</div>
														<div style="float:left;">
															: <?php echo date('d-m-Y', strtotime($hiring_data->bill_date)); ?>
														</div>
														<div class="clear"></div>
													</div>
													<div style="line-height: 20px;height: 25px;">
														<div style="float:left;width: 60px">SITE</div>
														<div style="float:left;">
															: <?php echo $site_detail->site_name; ?>
														</div>
														<div class="clear"></div>
													</div>
													<div class="clear"></div>
												</div>
											</div>
										</th>
									</tr>
									<tr>
										<th style="width:35px;padding:0" class="center-th" rowspan="2">
											<div class="text-center">S.No</div>
										</th>
										<th class="center-th" style="" rowspan="2">
											<div class="text-center">Description</div>
										</th>
										<th class="center-th" style="width:35px;padding:0;" rowspan="2">
											<div class="text-center">Qty</div>
										</th>
										<th class="center-th" style="padding: 0;" colspan="3">
											<div class="text-center">Peroid</div>
										</th>
										<th class="center-th" style="padding: 0;">
											<div class="text-center">Rate/Day</div>
										</th>
										<th class="center-th" style="padding: 0;width: 80px;">
											<div class="text-center">Amount</div>
										</th>
									</tr>
									<tr>
										<th style="padding: 0;width: 70px;"><div class="text-center">From</div></th>
										<th style="padding: 0;width: 70px;"><div class="text-center">To</div></th>
										<th style="padding: 0;width: 35px;"><div class="text-center">No of Days</div></th>
										<th style="padding: 0;width: 65px;"><div class="text-right">Rs Ps</div></th>
										<th style="padding: 0;width: 35px;"><div class="text-right">Rs Ps</div></th>
									</tr>
								</thead>


								<?php
								if($current_page > 1) {
								?>
									<tr>
										<td></td>
										<td>
											<div class="text-center">BF / TOTAL</div>
										</td>
										<td><div class="text-center">-</div></td>
										<td><div class="text-center">-</div></td>
										<td><div class="text-center">-</div></td>
										<td><div class="text-center">-</div></td>
										<td><div class="text-right">-</div></td>
										<td>
											<div class="text-right">
												<?php echo moneyFormatIndia( number_format($page_total[$i-1],2) ); ?>
											</div>
										</td>
									</tr>
								<?php
								}
								foreach ($pieces[$i] as $key => $value) {
								?>
									<tr>
										<td>
											<div class="text-center">
												<?php echo $page_start ?>
											</div>
										</td>
										<td>
											<?php echo $value->product_name; ?>
											<span style="text-align: left;"><?php echo $value->product_type; ?></span>
										</td>
										<td>
											<div class="text-center">
												<?php echo $value->qty; ?>
											</div>
										</td>
										<td>
											<div class="text-center" style="text-align: right;">
												<?php echo date('d.m.Y', strtotime($value->bill_from));?>
											</div>
										</td>
										<td>
											<div class="text-center">
												<?php echo date('d.m.Y', strtotime($value->bill_to));?>
											</div>
										</td>
										<td>
											<div class="text-center">
												<?php echo $value->bill_days; ?>
											</div>
										</td>
										<td>
											<div class="text-rigth">
												<?php echo moneyFormatIndia($value->rate_per_day); ?>
											</div>
										</td>
										<td>
											<div class="text-rigth">
												<?php echo moneyFormatIndia($value->hiring_amt); ?>
											</div>
										</td>
									</tr>


								<?php
									$page_start++;
								}
									if($pages == $current_page) {
								?>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="7">MRR Transport & Unloading </td>
											<td>
												<div class="text-rigth">
													<?php echo moneyFormatIndia($hiring_data->transportation_charge); ?>
												</div>
											</td>
										</tr>
										<?php
											if($hiring_data->discount_avail != 'no') {
										?>
										<tr>
											<td colspan="7"><div class="text-center">Discount</div></td>
											<td>
												<div class="text-right">
													<?php echo moneyFormatIndia($hiring_data->discount_amount); ?>
												</div>
											</td>
										</tr>
										<?php
											}
										?>
										<tr>
											<td colspan="7"><div class="text-center">Taxable Amount</div></td>
											<td>
												<div class="text-right">
													<?php echo moneyFormatIndia($hiring_data->total_after_discount); ?>
												</div>
											</td>
										</tr>
										<?php

										if($hiring_data->tax_from != 'tax_from') {

											if($hiring_data->tax_from == 'gst') {

												if($hiring_data->gst_for == 'cgst') {

										?>
												<tr>
													<td colspan="7"><div class="text-center"><b>CGST - 9%</b></div></td>
													<td>
														<div class="text-rigth">
															<?php echo moneyFormatIndia($hiring_data->cgst_amt); ?>
														</div>
													</td>
												</tr>
												<tr>
													<td colspan="7"><div class="text-center"><b>SGST - 9%</b></div></td>
													<td>
														<div class="text-rigth">
															<?php echo moneyFormatIndia($hiring_data->sgst_amt); ?>
														</div>
													</td>
												</tr>
										<?php
												}
												if($hiring_data->gst_for == 'igst') {
										?>
												<tr>
													<td colspan="7"><div class="text-center"><b>IGST - 18%</b></div></td>
													<td>
														<div class="text-rigth">
															<?php echo moneyFormatIndia($hiring_data->igst_amt); ?>
														</div>
													</td>
												</tr>
										<?php
												}
											}
											if($hiring_data->tax_from == 'vat') {
											?>
												<tr>
													<td colspan="7"><div class="text-center"><b>VAT - 5%</b></div></td>
													<td>
														<div class="text-rigth">
															<?php echo moneyFormatIndia($hiring_data->vat_amt); ?>
														</div>
													</td>
												</tr>
											<?php
											}
											?>

											<tr>
												<td colspan="7"><div class="text-center">Total Including Tax</div></td>
												<td>
													<div class="text-right">
														<?php echo moneyFormatIndia($hiring_data->tax_include_tot); ?>
													</div>
												</td>
											</tr>
										<?php
										}
										?>

										<tr>
											<td colspan="7"><div class="text-center">Round off</div></td>
											<td>
												<div class="text-right">
													<?php echo moneyFormatIndia($hiring_data->round_off); ?>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="7"><div class="text-center"><b>Total</b></div></td>
											<td>
												<div class="text-right">
													<?php echo moneyFormatIndia($hiring_data->hiring_total); ?>
												</div>
											</td>
										</tr>

										<table>
											<tr>
												<td>Amount Chargable (in words)</td>
											</tr>
											<tr>
												<td><b>INR <?php echo ucwords(convert_number_to_words_full($hiring_data->hiring_total)); ?></b></td>
											</tr>
										</table>

							<?php
								if($hiring_data->tax_from != 'tax_from') {
							?>
										<table class="table table-bordered" style="margin-top:10px;margin-bottom: 5px;">
											<thead>
												<tr>
													<th class="center-th" style="" rowspan="2">
														<div class="text-center">HSN</div>
													</th>
													<th class="center-th" style="width:90px;padding:0;" rowspan="2">
														<div class="text-center">Taxable Value</div>
													</th>
													<?php 
														if($hiring_data->gst_for == 'cgst') {
													?>
															<th class="center-th" style="padding: 0;" colspan="2">
																<div class="text-center">CGST</div>
															</th>
															<th class="center-th" style="padding: 0;" colspan="2">
																<div class="text-center">SGST</div>
															</th>
													<?php
														}
														if($hiring_data->gst_for == 'igst') {
													?>
															<th class="center-th" style="padding: 0;" colspan="2">
																<div class="text-center">IGST</div>
															</th>
													<?php
														}
													?>

												</tr>
												<tr>
													<?php 
														if($hiring_data->gst_for == 'cgst') {
													?>
															<th style="padding: 0;width: 70px;"><div class="text-center">Rate</div></th>
															<th style="padding: 0;width: 70px;"><div class="text-center">Amount</div></th>
															<th style="padding: 0;width: 70px;"><div class="text-center">Rate</div></th>
															<th style="padding: 0;width: 70px;"><div class="text-center">Amount</div></th>
													<?php
														}
														if($hiring_data->gst_for == 'igst') {
													?>
															<th style="padding: 0;width: 70px;"><div class="text-center">Rate</div></th>
															<th style="padding: 0;width: 70px;"><div class="text-center">Amount</div></th>
													<?php 
														}
													?>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<div class="text-center">
															4545
														</div>
													</td>
													<td>
														<div class="text-right">
															<?php echo moneyFormatIndia($hiring_data->total_after_discount); ?>
														</div>
													</td>
													<?php 
														if($hiring_data->gst_for == 'cgst') {
													?>
															<td>
																<div class="text-right">
																	9%
																</div>
															</td>
															<td>
																<div class="text-right">
																	<?php echo moneyFormatIndia($hiring_data->cgst_amt); ?>
																</div>
															</td>
															<td>
																<div class="text-right">
																	9%
																</div>
															</td>
															<td>
																<div class="text-right">
																	<?php echo moneyFormatIndia($hiring_data->sgst_amt); ?>
																</div>
															</td>
													<?php
														}
														if($hiring_data->gst_for == 'igst') {
													?>
															<td>
																<div class="text-right">
																	18%
																</div>
															</td>
															<td>
																<div class="text-right">
																	<?php echo moneyFormatIndia($hiring_data->igst_amt); ?>
																</div>
															</td>
													<?php
														}
													?>
												</tr>
												<tr>
													<td>
														<div class="text-right">
															<b>Total</b>
														</div>
													</td>
													<td>
														<div class="text-right">
															<?php echo moneyFormatIndia($hiring_data->total_after_discount); ?>
														</div>
													</td>
													<td>
														<div class="text-right">
														
														</div>
													</td>
													<?php 
														if($hiring_data->gst_for == 'cgst') {
													?>
														<td>
															<div class="text-right">
																<?php echo moneyFormatIndia($hiring_data->cgst_amt); ?>
															</div>
														</td>
														<td></td>
														<td>
															<div class="text-right">
																<?php echo moneyFormatIndia($hiring_data->sgst_amt); ?>
															</div>														
														</td>
													<?php 
														}
														if($hiring_data->gst_for == 'igst') {
													?>
														<td>
															<div class="text-right">
																<?php echo moneyFormatIndia($hiring_data->igst_amt); ?>
															</div>	
														</td>
													<?php
													}
													?>
												</tr>
											</tbody>
										</table>
										<table>
											<tr>
												<td>Tax Amount (in words)</td>
											</tr>
											<tr>
												<td><b>INR <?php echo ucwords(convert_number_to_words_full($gst_total)); ?></b></td>
											</tr>
										</table>
								<?php
								}
									} else {
								?>
										<tr>
											<td colspan="7">
												<div class="text-center">CF / TOTAL</div>
											</td>
											<td>
												<div class="text-right">
													<?php echo moneyFormatIndia( number_format($page_total[$i],2) ); ?>
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