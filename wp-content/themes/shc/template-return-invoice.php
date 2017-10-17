<?php
/**
 * Template Name: Return Invoice 
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
$return_data = false;
$return_detail = false;

if(isset($_GET['return_id'])) {
	$return_data = getReturnData($_GET['return_id']);
	$invoice_data = $return_data['invoice_data'];
	$return_detail = (isset($return_data['group_detail']) && $return_data['group_detail'])  ? $return_data['group_detail'] : false;

	$company_id = $invoice_data->bill_from_comp;
	$company_data = getCompaniesById($company_id);

	$dt = new DateTime($return_data['return_data']->return_date);
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
			.bottom-left {
				width: 210px;
			}
			.bottom-center {
				width: 214px;
			}
			.bottom-right {
				width: 210px;
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
			.top-center {
				width: 284px;
			}
			.top-right {
				width: 190px;
			}
			.bottom-left {
				width: 230px;
			}
			.bottom-center {
				width: 244px;
			}
			.bottom-right {
				width: 160px;
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
	</style>




<table class=""> 
	<thead>
		<tr>
			<td>
				
				<div class="header-top inner-container">
					<div class="left-float top-left">
						<div class="left-logo">
							<img src="<?php echo get_template_directory_uri(); ?>/admin/inc/images/invoice/right-logo-1.jpg">
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
						NO : <?php echo $invoice_data->company_id.'/MRR '.$invoice_data->bill_no; ?>
					</div>
					<div class="left-float top-center">
						<center><b>METERIAL RETURN RECEIPT</b></center>
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

			if($return_detail) {
				$pages = ceil(count($return_detail)/$per_page);
				$pieces = array_chunk($return_detail, $per_page);

				$tota_row = count($return_detail);
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
										<th class="center-th" style="width: 150px" rowspan="2">
											<div class="text-center">Qty</div>
										</th>
									</tr>
								</thead>
								<?php 
								$unloading = getUnloadingData($_GET['return_id'], 'unloading');
								$transportation = getUnloadingData($_GET['return_id'], 'transportation');
								$damage = getUnloadingData($_GET['return_id'], 'damage');
								$total = getUnloadingData($_GET['return_id'], 'total');

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
											<div class="text-right" style="padding-right: 25px;"><?php echo $value->qty; ?></div>
										</td>
									</tr>
								<?php
									$page_start++;
								}
								?>
								<tr>
									<td></td>
									<td><span style="width:110px;float: right;text-align: left;">-</span></td>
									<td><div class="text-right" style="padding-right: 25px;">-</div></td>
								</tr>
								<?php
									if($unloading != 0) {
								?>
								<tr>
									<td colspan="2"><div class="text-right">Unloading Charge : </div></td>
									<td><div class="text-right" style="padding-right: 20px;"><?php echo $unloading; ?></div></td>
								</tr>
								<?php
									}
									if($transportation != 0) {
								?>
								<tr>
									<td colspan="2"><div class="text-right">Transportation Charge : </div></td>
									<td><div class="text-right" style="padding-right: 20px;"><?php echo $transportation; ?></div></td>
								</tr>
								<?php
									}
									if($damage != 0) {
								?>
								<tr>
									<td colspan="2"><div class="text-right">Damage Charge : </div></td>
									<td><div class="text-right" style="padding-right: 20px;"><?php echo $damage; ?></div></td>
								</tr>
								<?php
									}
									if($total != 0) {
								?>
								<tr>
									<td colspan="2"><div class="text-right">Total : </div></td>
									<td><div class="text-right" style="padding-right: 20px;"><?php echo $total; ?></div></td>
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

<div class="footer">
		<div class="inner-container">

					<div class="left-float bottom-left">
						<div>
							Vehicle No.
						</div>
						<div style="width: 200px;height: 30px;border: 1px solid #67a3b7;padding: 5px;margin-bottom:10px;">
							<?php echo $invoice_data->vehicle_number; ?>
						</div>

						<div style="line-height: 25px;">
							<div style="float:left;width: 82px;">
								Driver Name <span style="float:right;">:</span>
							</div>
                            <div style="float:left;width:118px;border-bottom: 1px dotted;height: 22px;"> <?php echo $invoice_data->driver_name; ?></div>
							<div class="clear"></div>
						</div>
						<div style="line-height: 25px;">
							<div style="float:left;width: 82px;">
								Mobile No. <span style="float:right;">:</span>
							</div>
                            <div style="float:left;width:118px;border-bottom: 1px dotted;height: 22px;"> <?php echo $invoice_data->driver_mobile; ?></div>
							<div class="clear"></div>
						</div>


					</div>
					<div class="left-float bottom-center" style="padding-top: 32px;">
						<div style="line-height: 25px;">
							<div style="float:left;width: 100px;">
								Hirer Signature <span style="float:right;">:</span>
							</div>
                            <div style="float:left;width:118px;border-bottom: 1px dotted;height: 22px;"></div>
							<div class="clear"></div>
						</div>
						<div style="line-height: 25px;">
							<div style="float:left;width: 100px;">
								Name <span style="float:right;">:</span>
							</div>
                            <div style="float:left;width:118px;border-bottom: 1px dotted;height: 22px;"></div>
							<div class="clear"></div>
						</div>
						<div style="line-height: 25px;">
							<div style="float:left;width: 100px;">
								Mobile No. <span style="float:right;">:</span>
							</div>
                            <div style="float:left;width:118px;border-bottom: 1px dotted;height: 22px;"></div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="left-float bottom-right">
						<div class="company-name" style="font-family: serif;font-weight: bold;font-size: 16px;text-align: center;margin-top: 25px;">
							For <?php echo $company_data->company_name; ?>
						</div>
						<div style="margin-top: 30px;text-align: center;margin-top: 42px;">Manager / Accountant</div>
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