<?php
/**
 * Template Name: Hiring Invoice 
 *
 * @package WordPress
 * @subpackage SHC
 */
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/admin/inc/css/bootstrap.min.css';?>" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/admin/inc/css/custom.min.css';?>" type="text/css" media="all" />
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
}

/*echo "<pre>";
var_dump($hiring_data);
echo "</pre>";
*/
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
				padding: 0 3px;px;
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
	</style>




<table class="" > 
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
		<tr>
			<td>








<table class=""> 

	<tbody>


		<?php
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


			for ($i = 0; $i < $pages; $i++) { 
				$page_start = ( $i * $per_page ) + 1;

				$current_page = ($i + 1);
		?>
			<tr>
				<td>
					<div class="inner-container" style="margin-top: 1px;">
						<div class="bill-detail">



							<table class="table table-bordered">
								<thead>
									<tr>
										<th colspan="4">
											<div style="min-height: 100px;padding:10px;">
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
											<div style="min-height: 100px;padding:10px;">
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
											<td></td>
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
												<?php echo $value->rate_per_day; ?>
											</div>
										</td>
										<td>
											<div class="text-rigth">
												<?php echo $value->amount; ?>
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
													<?php echo $hiring_data->transportation_charge; ?>
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
													<?php echo $hiring_data->discount_amount; ?>
												</div>
											</td>
										</tr>
										<?php
											}
										?>

										<tr>
											<td colspan="7"><div class="text-center">Taxable Amount</div></td>
											<td>
												<div class="text-right"><?php echo $hiring_data->total_after_discount; ?></div>
											</td>
										</tr>
										<tr>
											<td colspan="7"><div class="text-center"><b>CGST - 9%</b></div></td>
											<td>
												<div class="text-rigth">
													<?php echo $hiring_data->cgst_amt; ?>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="7"><div class="text-center"><b>SGST - 9%</b></div></td>
											<td>
												<div class="text-rigth">
													<?php echo $hiring_data->sgst_amt; ?>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="7"><div class="text-center">Total Including Tax</div></td>
											<td>
												<div class="text-right">
													<?php echo $hiring_data->tax_include_tot; ?>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="7"><div class="text-center">Round off</div></td>
											<td>
												<div class="text-right">
													<?php echo $hiring_data->round_off; ?>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="7"><div class="text-center"><b>Total</b></div></td>
											<td>
												<div class="text-right">
													<?php echo $hiring_data->hiring_total; ?>
												</div>
											</td>
										</tr>


										<table class="table table-bordered">
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
															<?php echo $hiring_data->total_after_discount; ?>
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
																	<?php echo $hiring_data->cgst_amt; ?>
																</div>
															</td>
															<td>
																<div class="text-right">
																	9%
																</div>
															</td>
															<td>
																<div class="text-right">
																	<?php echo $hiring_data->sgst_amt; ?>
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
																	<?php echo $hiring_data->igst_amt; ?>
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
															<?php echo $hiring_data->total_after_discount; ?>
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
																<?php echo $hiring_data->cgst_amt; ?>
															</div>
														</td>
														<td></td>
														<td>
															<div class="text-right">
																<?php echo $hiring_data->sgst_amt; ?>
															</div>														
														</td>
													<?php 
														}
														if($hiring_data->gst_for == 'igst') {
													?>
														<td></td>
														<td>
															<div class="text-right">
																<?php echo $hiring_data->igst_amt; ?>
															</div>	
														</td>
													<?php
													}
													?>
												</tr>
											</tbody>

										</table>
								<?php
									} else {
								?>
										<tr>
											<td colspan="7">
												<div class="text-center">CF / TOTAL</div>
											</td>
											<td></td>
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









			</td>
		</tr>
	</tbody>
</table>



<div class="footer" style="margin-bottom:25px;">
		<div class="inner-container">
			<div  class="left-float" style="width: 434px">
				<div style="width: 100%;">
					<div class="left-float">Rupees</div>
					<div class="left-float" style="min-width: 360px;border-bottom: 1px dotted;height: 20px;margin-left: 5px;">
						<?php echo ucfirst(convert_number_to_words_full($invoice_data->total_ninety_days)); ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="">
					<div style="width: 310px;float: left;padding-right: 10px;font-size: 10px;margin-top: 20px;">The Security Deposit will be returned on immediately on safe receipt of the hired equipments * Rental peroid - minimum 30 days * No part payment of the Security Deposit will be returned on receipt of the part quantity of the hired equipments. </div>
					<div style="float: left;width: 124px;padding: 0 10px;text-align: right;">
						<div style="margin-top: 5px; ">
							Received by <br>Cash / Cheque
						</div>

					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="left-float" style="width:200px;">
				<table class="table table-bordered" style="margin-bottom: 0px;">
					<tr>
						<td style="width: 110px;">Cheque No <span style="float: right;">:</span> </td>
						<td><?php  echo ($invoice_data->cheque_no !== '0.00') ? $invoice_data->cheque_no : ''; ?></td>
					</tr>
					<tr>
						<td>Date <span style="float: right;">:</span> </td>
						<td><?php echo ($invoice_data->cheque_date !== '0000-00-00') ? $invoice_data->cheque_date : ''; ?></td>
					</tr>
					<tr>
						<td>amount Rs <span style="float: right;">:</span> </td>
						<td><?php echo ($invoice_data->cheque_amount !== '0') ? $invoice_data->cheque_amount : ''; ?></td>
					</tr>
				</table>
			</div>
			<div class="clear"></div>
		</div>




		<div class="inner-container" style="margin-top: 5px;">


			<div class="left-float" style="width: 310px;float: left;padding-right: 10px;">
				<div>Hirer Signature</div>
				<div style="border-bottom: 1px dotted;height: 20px;margin-left: 5px;"></div>
				<div style="width: 310px;float: left;padding-right: 10px;font-size: 10px;margin-top: 2px;">Received the above construction equipments in good condition</div>
			</div>
			<div class="left-float" style="width: 170px;float: left;padding: 0 10px;">
				WORKING HOURS<br>
				9.00 AM to 5.00 PM<br>
				SUNDAY HOLIDAY
			</div>
			<div class="left-float" style="width: 154px;">
				<div style="margin-top: -10px;">For JBC Associates</div>
				<div style="margin-top: 30px;">Manager / Accountant</div>
			</div>
			<div class="clear"></div>
		</div>

		<div class="inner-container foot" style="width: 794px;line-height: 25px;font-size: 14px;color: #fff !important;">
			<div class="left-float" style="width:317px;font-size: 14px;color: #fff !important;text-align: center;">Email : infojbcaccesss@gmail.com</div>
			<div class="left-float" style="width:317px;font-size: 14px;color: #fff !important;text-align: center;">Website : www.jcbascdfdsgdfg.in</div>
			<div class="clear"></div>
		</div>
</div>


</body>
</html>