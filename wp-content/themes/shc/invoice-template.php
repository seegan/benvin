<?php
/**
 * Template Name: SRC Invoice
 *
 * @package WordPress
 * @subpackage SHC
 */

    $bill_data = false;
    $invoice_id = '';
    if(isset($_GET['id']) && $_GET['id'] != '' && isValidInvoice($_GET['id'], 1) ) {
        $update = true;
        $invoice_id = $_GET['id'];
        $bill_data = getBillData($invoice_id);
        $bill_fdata = $bill_data['bill_data'];
        $bill_ldata = $bill_data['ordered_data'];
        $bill_rdata = $bill_data['returned_data'];
    }
?>
<head>
	<link rel='stylesheet' id='bootstrap-min-css'  href='http://ajnainfotech.com/demo/shc/wp-content/themes/shc/admin/inc/css/bootstrap.min.css' type='text/css' media='all' />
	<link rel='stylesheet' id='custom-min-css'  href='http://ajnainfotech.com/demo/shc/wp-content/themes/shc/admin/inc/css/custom.min.css' type='text/css' media='all' />

  <style type="text/css">
  @media screen {
    div.divFooter {
      display: none;
    }
  }
  @media print {
    div.divFooter {
      position: fixed;
      bottom: 0;
    }
  }
  </style>
  <title>Saravana Health Center - #<?php echo $bill_fdata->inv_id; ?></title>
<div class="divFooter">UNCLASSIFIED</div>

</head>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_content">

        <?php
            if($bill_data) {
        ?>
          <section class="content invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12 invoice-header">
                    <h1>
                        <i class="fa fa-globe"></i> Invoice. #<?php echo $bill_fdata->inv_id; ?>
                        <small class="pull-right">Date: 16/08/2016</small>
                    </h1>
                </div>
                <!-- /.col -->
            </div>
            <div class="x_title"></div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                From
                <address>
                    <strong>Iron Admin, Inc.</strong>
                    <br>795 Freedom Ave, Suite 600
                    <br>New York, CA 94107
                    <br>Phone: 1 (804) 123-9876
                    <br>Email: ironadmin.com
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                To
                <address>
                    <strong><?php echo $bill_fdata->customer_name; ?></strong>
                    <br><?php echo $bill_fdata->address; ?>
                    <br><?php echo $bill_fdata->mobile; ?>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-2 invoice-col">
              	<b>Invoice <?php echo $bill_fdata->inv_id; ?></b>
                <br>
              </div>
              <div class="col-sm-2 invoice-col">
                <b>Order ID:</b> <?php echo $bill_fdata->order_id; ?>
                <br>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-xs-12 table">



                <h2>Billed Items</h2>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width:50px;">S.No</th>
                      <th style="width:300px;">PRODUCT</th>
                      <th style="width:80px;">QTY</th>
                      <th style="width:120px;">RATE</th>
                      <th style="width:140px;">AMOUNT</th>
                      <th style="width:90px;">TAX RATE</th>
                      <th style="width:120px;">TAX AMOUNT</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        if($bill_data && $bill_ldata && count($bill_ldata)>0) {
                            $i = 1;
                            foreach ($bill_ldata as $d_value) {
                    ?>
                        <tr>
                          <td>
                            <div class="rowno"><?php echo $i; ?></div>
                          </td>
                          <td>
                            <span class="span_product_type"><?php echo $d_value->product_type; ?></span>
                          </td>
                          <td>
                            <span class="span_unit_count"><?php echo $d_value->sale_unit; ?><span>
                          </td>
                          <td>
                            <span class="span_unit_price"><?php echo $d_value->unit_price; ?><span>
                          </td>
                          <td>
                            <span class="span_sub_total"><?php echo $d_value->sale_value; ?></span>
                          </td>
                          <td>
                            <span class="span_unit_price"><?php echo $d_value->sal_tax_percentage; ?><span>
                          </td>                                  
                          <td>
                            <span class="span_sale_tax"><?php echo $d_value->sal_tax; ?></span>
                          </td>
                        </tr>
                    <?php
                        $i++;
                        }
                    }

                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-xs-6">
                <p class="lead">Payment Methods:</p>
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                  Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                </p>
              </div>
              <!-- /.col -->
              <div class="col-xs-6">
                <p class="lead">Amount Due 2/22/2014</p>
                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td><?php echo $bill_fdata->sub_total; ?></td>
                      </tr>
                      <tr>
                        <th>Tax (9.3%)</th>
                        <td><?php echo $bill_fdata->vat_tax; ?></td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td><?php echo $bill_fdata->shipping_charge; ?></td>
                      </tr>
                      <tr>
                        <th>Discount:</th>
                        <td><?php echo $bill_fdata->discount; ?></td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td><?php echo $bill_fdata->final_total; ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

          </section>


          <?php
            }
          ?>








        </div>
      </div>
    </div>
  </div>
</div>