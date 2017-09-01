<?php
/**
 * Template Name: Delivery Invoice 
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
$security_data = false;
$deposit_detail = false;

if(isset($_GET['deposit_id'])) {
	$security_data = getDepositDetail($_GET['deposit_id']);
	$invoice_data = $security_data['invoice_data'];
	$deposit_detail = $security_data['deposit_detail'];

	$dt = new DateTime($security_data->deposit_date);
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
				padding-left: 80px;
				padding-right: 80px;
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




			.inner-container {
				padding-left: 80px;
				padding-right: 80px;
				width: 794px;
			}
			.left-float {
				float: left;
			}
			.top-left {
				width: 160px;
			}
			.left-logo img, .right-logo img {
				width: 100%;
			}
			.comp-detail {
				padding-left: 5px;
			}
			.top-center {
				width: 240px;
			}
			.top-right {
				width: 234px;
			}
			.comp-detail-in .detail-left {
				width: 55px;
			}

			.customer-detail-left {
				width: 400px;
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
			.bill-detail thead tr {
			    background-color: #67a3b7 !important;
			    -webkit-print-color-adjust: exact;
			}
			.bill-detail thead tr th div{
			    color: #fff !important;
			    -webkit-print-color-adjust: exact;
			}


			.vehicle-detail{
				width: 220px;
			}
			.hirer-detail{
    			width: 214px;
			}
			.hirer-detail .bottom-detail-in{
    			padding-left: 20px;
			}			
			.signature-detail{
				width: 200px;
			}
			.signature-detail .bottom-detail-in{
				padding-left: 20px;
			}
			.detail-in {
				margin-top: 2px;
			}
			.vehicle-box {
				height: 34px;
				width: 180px;
				border: 1px solid;
			}
			.table>tbody>tr>td {
				padding:5px;
				height: 29px;
			}
			.table-bordered>tbody>tr>td {
				border: 1px solid #67a3b7;
			}

	</style>




<table class=""> 
	<thead>
		<tr>
			<td>
				
				<div class="header-top inner-container">
					<div class="left-float top-left">
						<div class="left-logo">
							<img src="<?php echo get_template_directory_uri() . '/admin/inc/images/invoice/left-logo-1.jpg'; ?>">
						</div>
					</div>
					<div class="left-float top-center">
						<div class="comp-detail" style="margin-top:15px;">
							<div class="comp-detail-in">
								<div class="left-float">
									sd
								</div>
								<div class="detail-right">
									: 2278 0605, 2278 1866
								</div>
							</div>
							<div class="comp-detail-in">
								<div class="detail-left left-float">
									Phone
								</div>
								<div class="detail-right">
									: 2278 0605, 2278 1866
								</div>
							</div>
							<div class="comp-detail-in">
								<div class="detail-left left-float">
									Mobile
								</div>
								<div class="detail-right">
									: 94440 50664
								</div>
							</div>
							<div class="comp-detail-in" style="margin-top: 10px;">
								<div class="detail-left left-float">
									TIN
								</div>
								<div class="detail-right">
									: 33446373536
								</div>
							</div>
						</div>
					</div>
					<div class="left-float top-right">
						<div class="right-logo">
							<img src="<?php echo get_template_directory_uri() . '/admin/inc/images/invoice/right-logo-1.jpg'; ?>">
						</div>
					</div>

				</div>
				<div class="header-top inner-container">
					<div class="left-float top-left">
						NO : <?php echo $invoice_data->company_id.'/SD '.$invoice_data->bill_no; ?>
					</div>
					<div class="left-float top-center">
						<center><b>DELIVERY CHALLAN</b></center>
					</div>
					<div class="left-float top-right">
						Date : <?php echo $date; ?>
					</div>
					<div class="clear"></div>
				</div>	
				<div class="customer-detail inner-container" style="margin-top: 20px;">
					<div class="left-float customer-detail-left">
						<div class="customer-name">
							Customer Name : M/s <?php echo $invoice_data->name; ?>
						</div>
						<div class="customer-address">
							Address : <?php echo $invoice_data->address; ?>
						</div>			</div>
					<div class="left-float customer-detail-right">
						<div class="comp-detail-in">
							<div class="detail-left left-float">
								Time
							</div>
							<div class="detail-right">
								: <?php echo $time; ?>
							</div>
						</div>
						<div class="comp-detail-in">
							<div class="detail-left left-float">
								Site
							</div>
							<div class="detail-right">
								: <?php echo $invoice_data->site_name; ?>
							</div>
						</div>
						<div class="comp-detail-in">
							<div class="detail-left left-float">
								Phone
							</div>
							<div class="detail-right">
								: <?php echo $invoice_data->phone_number; ?>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>



			</td>
		</tr>
	</thead>
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
										<th style="padding: 0;width: 70px;"><div class="text-center">Rs</div></th>
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

<div class="footer">
		<div class="inner-container">
			<div  class="left-float" style="width: 434px">
				<div style="width: 100%;">
					<div class="left-float">Rupees</div>
					<div class="left-float" style="min-width: 360px;border-bottom: 1px dotted;height: 20px;margin-left: 5px;"></div>
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
						<td> </td>
					</tr>
					<tr>
						<td>Date <span style="float: right;">:</span> </td>
						<td></td>
					</tr>
					<tr>
						<td>amount Rs <span style="float: right;">:</span> </td>
						<td></td>
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

		<div class="inner-container foot" style="width: 810px;line-height: 25px;font-size: 14px;color: #fff !important;">
			<div class="left-float" style="width:325px;font-size: 14px;color: #fff !important;text-align: center;">Email : infojbcaccesss@gmail.com</div>
			<div class="left-float" style="width:325px;font-size: 14px;color: #fff !important;text-align: center;">Website : www.jcbascdfdsgdfg.in</div>
			<div class="clear"></div>
		</div>
</div>


</body>
</html>