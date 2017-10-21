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


	$pages = false;
	$per_page = 16;
	$pieces = false;
	$tota_row = 0;

	if($quotation_data) {
		$pages = ceil(count($bill_data['quotation_detail'])/$per_page);
		$pieces = array_chunk($bill_data['quotation_detail'], $per_page);
		$tota_row = count($bill_data['quotation_detail']);
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
			ol, ul {
				padding-left: 13px;
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

			.footer {
				/*position: fixed;*/
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
			ol, ul {
				padding-left: 15px;
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
							<img src="<?php echo get_template_directory_uri(); ?>/admin/inc/images/invoice/right-logo-1.jpg">
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
										<th colspan="3">
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
										<th colspan="3">
											<div style="min-height: 100px;padding:5px;">
												<div>
													<div style="line-height: 20px;height: 25px;">
														<div style="float:left;">
															<?php echo $bill_number['bill_no']; ?>
														</div>
														<div class="clear"></div>
													</div>
													<div style="line-height: 20px;height: 25px;">
														<div style="float:left;width: 60px">DATE</div>
														<div style="float:left;">
															: <?php echo date('d-m-Y', strtotime($quotation_data->quotation_date)); ?>
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
										<th class="center-th" style="width: 50px;" rowspan="2">
											<div class="text-center">S.No</div>
										</th>
										<th class="center-th" style="" rowspan="2">
											<div class="text-center">Description</div>
										</th>
										<th class="center-th" style="width: 50px;" rowspan="2">
											<div class="text-center">Qty</div>
										</th>
										<th class="center-th" style="width: 50px;" rowspan="2">
											<div class="text-center">UOM</div>
										</th>
										<th class="center-th" style="padding: 0;">
											<div class="text-center">Rate / 30 Days</div>
										</th>
										<th class="center-th" style="padding: 0;width: 100px;">
											<div class="text-center">Hiring Charges For 30 Days</div>
										</th>
									</tr>
								</thead>

								<?php
								foreach ($pieces[$i] as $key => $value) {
									$data_thirty = splitCurrency($value->rate_thirty);
									$data_ninety = splitCurrency($value->rate_ninety);
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
											<div class="text-center">
												Nos
											</div>
										</td>
										<td>
											<div class="text-rigth">
												<?php echo moneyFormatIndia($value->rate_thirty); ?>
											</div>
										</td>
										<td>
											<div class="text-rigth">
												<?php echo moneyFormatIndia($value->rate_ninety); ?>
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
										</tr>
										<tr>
											<td colspan="5"><div class="text-center">Total (Hire Charges)</div></td>
											<td>
												<div class="text-rigth">
													<?php echo moneyFormatIndia($quotation_data->after_discount_amt); ?>
												</div>
											</td>
										</tr>
										<?php
										if($quotation_data->discount_avail != 'no' && $quotation_data->discount_amount != 0) {
										?>
										<tr>
											<td colspan="5"><div class="text-center">Discount</div></td>
											<td>
												<div class="text-right">
													<?php echo moneyFormatIndia($quotation_data->discount_amount); ?>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="5"><div class="text-center">Total After Discount</div></td>
											<td>
												<div class="text-rigth">
													<?php echo moneyFormatIndia($quotation_data->total_after_discount); ?>
												</div>
											</td>
										</tr>
										<?php
										}
										if( isset($quotation_data->transportation_charge) && $quotation_data->transportation_charge != 0 ) {
										?>
										<tr>
											<td colspan="5"><div class="text-center">Delivery Charges</div></td>
											<td>
												<div class="text-right">
													<?php echo moneyFormatIndia($quotation_data->transportation_charge); ?>
												</div>
											</td>
										</tr>
										<?php
										}
										if( isset($quotation_data->damage_charge) && $quotation_data->damage_charge != 0 ) {
										?>
										<tr>
											<td colspan="5"><div class="text-center">Cleaning and Maintanance Charges</div></td>
											<td>
												<div class="text-right">
													<?php echo moneyFormatIndia($quotation_data->damage_charge); ?>
												</div>
											</td>
										</tr>
										<?php
										}
										if( isset($quotation_data->lost_charge) && $quotation_data->lost_charge != 0 ) {
										?>
										<tr>
											<td colspan="5"><div class="text-center">Material Lost Charges</div></td>
											<td>
												<div class="text-right">
													<?php echo moneyFormatIndia($quotation_data->lost_charge); ?>
												</div>
											</td>
										</tr>
										<?php
										}
										if( isset($quotation_data->transportation_charge) && $quotation_data->transportation_charge != 0 && isset($quotation_data->transportation_charge) && $quotation_data->transportation_charge != 0 && isset($quotation_data->lost_charge) && $quotation_data->lost_charge != 0 ) {
										?>
											<tr class="lost-tr">
												<td colspan="5" >
													<div class="text-center">Total</div>
												</td>
												<td>
													<div class="text-right">
														<span><?php echo moneyFormatIndia($quotation_data->total_before_tax); ?></span>					
													</div>
												</td>
											</tr>
										<?php
										}

										if($quotation_data->tax_from != 'no_tax') {

											if($quotation_data->tax_from == 'gst') {

												if($quotation_data->gst_for == 'cgst') {

										?>
												<tr>
													<td colspan="5"><div class="text-center"><b>CGST - 9%</b></div></td>
													<td>
														<div class="text-rigth">
															<?php echo moneyFormatIndia($quotation_data->cgst_amt); ?>
														</div>
													</td>
												</tr>
												<tr>
													<td colspan="5"><div class="text-center"><b>SGST - 9%</b></div></td>
													<td>
														<div class="text-rigth">
															<?php echo moneyFormatIndia($quotation_data->sgst_amt); ?>
														</div>
													</td>
												</tr>
										<?php
												}
												if($quotation_data->gst_for == 'igst') {
										?>
												<tr>
													<td colspan="5"><div class="text-center"><b>IGST - 18%</b></div></td>
													<td>
														<div class="text-rigth">
															<?php echo moneyFormatIndia($quotation_data->igst_amt); ?>
														</div>
													</td>
												</tr>
										<?php
												}
											}
											if($quotation_data->tax_from == 'vat') {
											?>
												<tr>
													<td colspan="5"><div class="text-center"><b>VAT - 5%</b></div></td>
													<td>
														<div class="text-rigth">
															<?php echo moneyFormatIndia($quotation_data->vat_amt); ?>
														</div>
													</td>
												</tr>
											<?php
											}
											?>

											<tr>
												<td colspan="5"><div class="text-center">Total Including Tax</div></td>
												<td>
													<div class="text-right">
														<?php echo moneyFormatIndia($quotation_data->tax_include_tot); ?>
													</div>
												</td>
											</tr>
										<?php
										}
										?>

										<tr>
											<td colspan="5"><div class="text-center">Round off</div></td>
											<td>
												<div class="text-right">
													<?php echo moneyFormatIndia($quotation_data->round_off); ?>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="5"><div class="text-center"><b>Total</b></div></td>
											<td>
												<div class="text-right">
													<?php echo moneyFormatIndia($quotation_data->for_thirty_days); ?>
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
			<tr>
				<td>
					<div class="customer-detail inner-container" style="margin-top: 15px;">
						<h4><u>Requirements :-</u></h4>
						<?php echo $quotation_data->requirements ?></td>
					</div>
			</tr>
			<tr>
				<td>
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
											<td><div class="text-center" style="padding:5px;">Rs. 1,43,875.00</div></td>
										</tr>
									</table>
								</td>
								<td>
									<table class="table table-bordered" style="margin-bottom:0px;">
										<tr>
											<td>
												<div class="text-center" style="padding:5px;    min-height: 115px;">
													<b><u>Account Details</u></b>
													<?php echo $quotation_data->bank_details ?>
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						
					</div>
				</td>
			</tr>
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