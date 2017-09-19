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
$bill_from_comp = getHiringBillDataPrint($_GET['bill_no']);
if(isset($bill_from_comp['hiring_data']) && isset($_GET['bill_no']) && $_GET['bill_no'] != '') {
	$company_id = $bill_from_comp['hiring_data']->bill_from_comp;
	$company_data = getCompaniesById($company_id);
}





if(isset($_GET['bill_no'])) {
	$security_data = getDepositDetail($_GET['bill_no']);
	$invoice_data = $security_data['invoice_data'];
	$deposit_detail = $security_data['deposit_detail'];

	$dt = new DateTime($security_data['deposit_data']->deposit_date);
	$date = $dt->format('d-m-Y');
	$time = $dt->format('h:i A');
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
			.company-detail-left .company-name h3{
			    font-family: serif;
    			font-weight: bold;
    			font-size: 24px;
			}
			.customer-detail-right {
				width: 234px;
			}

			.text-center {
				text-align: center;
			}

		    .table td, .table th {
		      background-color: transparent !important;
		    }
		    .bill-detail {
		    	height: 650px;
		    }
			.bill-detail thead tr {
			    background-color: #67a3b7 !important;
			    -webkit-print-color-adjust: exact;
			}
			.bill-detail thead tr th div{
			    color: #fff !important;
			    -webkit-print-color-adjust: exact;
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
				padding:5px;
				height: 29px;
			}
			.table-bordered>tbody>tr>td {
				border: 1px solid #67a3b7 !important;
				-webkit-print-color-adjust: exact;
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
			    font-size: 14px;
    			font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
			}

			.customer-detail-right {
				width: 234px;
			}

			.text-center {
				text-align: center;
			}

		    .table td, .table th {
		      background-color: transparent !important;
		    }
		    .bill-detail {
		    	height: 650px;
		    }
			.bill-detail thead tr {
			    background-color: #67a3b7 !important;
			    -webkit-print-color-adjust: exact;
			}
			.bill-detail thead tr th div{
			    color: #fff !important;
			    -webkit-print-color-adjust: exact;
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
				padding:5px;
				height: 29px;
			}
			.table-bordered>tbody>tr>td {
				border: 1px solid #67a3b7 !important;
				-webkit-print-color-adjust: exact;
			}

			.billing-title {
				text-align: center;
				font-weight: bold;
				font-size: 14px;
    			text-decoration: underline;
			}
	</style>




<table class="" style="margin-top: 25px;"> 
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
							if(isset($_GET['tax_from']) && $_GET['tax_from'] == 'no_tax') {
								echo "";
							} else if(isset($_GET['tax_from']) && $_GET['tax_from'] == 'vat') {
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
		<tr>
			<td>
				<div class="customer-detail inner-container">
					<table class="table table-bordered">
						<tr>
							<td>
								
									wsd
								
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</thead>
</table>




<table class="" style="margin-top: 25px;"> 

	<tbody>

		<tr>
			<td>


			</td>
		</tr>


		<?php
			$pages = false;
			$per_page = 17;
			$pieces = false;
			$tota_row = 0;

			if($deposit_detail) {
				$pages = ceil(count($deposit_detail)/$per_page);
				$pieces = array_chunk($deposit_detail, $per_page);

				$tota_row = count($deposit_detail);
			}



			for ($i=0; $i < $pages; $i++) { 
				$page_start = ( $i * $per_page ) + 1;

				$current_page = ($i + 1);

		?>
			<tr>
				<td>
					<div class="inner-container" style="margin-top: 20px;">
						<div class="bill-detail">



							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="width:50px;" class="center-th" rowspan="2">
											<div class="text-center">S.No</div>
										</th>
										<th class="center-th" style="" rowspan="2">
											<div class="text-center">Description</div>
										</th>
										<th class="center-th" style="width:70px;" rowspan="2">
											<div class="text-center">Qty</div>
										</th>
										<th class="center-th" style="padding: 0;" colspan="2">
											<div class="text-center">Rate/30 Days</div>
										</th>
										<th class="center-th" style="padding: 0;" colspan="2">
											<div class="text-center">Amount@<?php echo $invoice_data->amt_times; ?> Times</div>
										</th>
									</tr>
									<tr>
										<th style="padding: 0;width: 70px;"><div class="text-center">Rs</div></th>
										<th style="padding: 0;width: 35px;"><div class="text-center">Ps</div></th>
										<th style="padding: 0;width: 80px;"><div class="text-center">Rs</div></th>
										<th style="padding: 0;width: 35px;"><div class="text-center">Ps</div></th>
									</tr>
								</thead>
								<?php 
								foreach ($pieces[$i] as $key => $value) {
									$data_thirty = splitCurrency($value->rate_thirty);
									$data_ninety = splitCurrency($value->rate_ninety);
								?>
									<tr>
										<td><?php echo $page_start ?></td>
										<td>
											<?php echo $value->product_name; ?>
											<span style="width:110px;float: right;text-align: left;"><?php echo $value->product_type; ?></span>
										</td>
										<td>
											<div class="text-center"><?php echo $value->qty; ?></div>
										</td>
										<td>
											<div class="text-center" style="text-align: right;"><?php echo $data_thirty['rs']; ?></div>
										</td>
										<td>
											<div class="text-center"><?php echo $data_thirty['ps']; ?></div>
										</td>
										<td>
											<div class="text-center" style="text-align: right;"><?php echo $data_ninety['rs']; ?></div>
										</td>
										<td>
											<div class="text-center"><?php echo $data_ninety['ps']; ?></div>
										</td>
									</tr>


									<tr>
										<td><?php echo $page_start ?></td>
										<td>
											<?php echo $value->product_name; ?>
											<span style="width:110px;float: right;text-align: left;"><?php echo $value->product_type; ?></span>
										</td>
										<td>
											<div class="text-center"><?php echo $value->qty; ?></div>
										</td>
										<td>
											<div class="text-center" style="text-align: right;"><?php echo $data_thirty['rs']; ?></div>
										</td>
										<td>
											<div class="text-center"><?php echo $data_thirty['ps']; ?></div>
										</td>
										<td>
											<div class="text-center" style="text-align: right;"><?php echo $data_ninety['rs']; ?></div>
										</td>
										<td>
											<div class="text-center"><?php echo $data_ninety['ps']; ?></div>
										</td>
									</tr>


									<tr>
										<td><?php echo $page_start ?></td>
										<td>
											<?php echo $value->product_name; ?>
											<span style="width:110px;float: right;text-align: left;"><?php echo $value->product_type; ?></span>
										</td>
										<td>
											<div class="text-center"><?php echo $value->qty; ?></div>
										</td>
										<td>
											<div class="text-center" style="text-align: right;"><?php echo $data_thirty['rs']; ?></div>
										</td>
										<td>
											<div class="text-center"><?php echo $data_thirty['ps']; ?></div>
										</td>
										<td>
											<div class="text-center" style="text-align: right;"><?php echo $data_ninety['rs']; ?></div>
										</td>
										<td>
											<div class="text-center"><?php echo $data_ninety['ps']; ?></div>
										</td>
									</tr>

									<tr>
										<td><?php echo $page_start ?></td>
										<td>
											<?php echo $value->product_name; ?>
											<span style="width:110px;float: right;text-align: left;"><?php echo $value->product_type; ?></span>
										</td>
										<td>
											<div class="text-center"><?php echo $value->qty; ?></div>
										</td>
										<td>
											<div class="text-center" style="text-align: right;"><?php echo $data_thirty['rs']; ?></div>
										</td>
										<td>
											<div class="text-center"><?php echo $data_thirty['ps']; ?></div>
										</td>
										<td>
											<div class="text-center" style="text-align: right;"><?php echo $data_ninety['rs']; ?></div>
										</td>
										<td>
											<div class="text-center"><?php echo $data_ninety['ps']; ?></div>
										</td>
									</tr>																		


								<?php
									if($tota_row == $page_start) {
										$total_thirty_days = splitCurrency($invoice_data->total_thirty_days);
										$total_ninety_days = splitCurrency($invoice_data->total_ninety_days);
								?>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="3"><div class="text-center">Total</div></td>
											<td><div class="text-center" style="text-align: right;"><?php echo $total_thirty_days['rs'] ?></div></td>
											<td><div class="text-center"><?php echo $total_thirty_days['ps'] ?></div></td>
											<td style="text-align: right;"><div class="text-center" style="text-align: right;"><?php echo $total_ninety_days['rs'] ?></div></td>
											<td><div class="text-center"><?php echo $total_ninety_days['ps'] ?></div></td>
										</tr>
								<?php
									}
									$page_start++;
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