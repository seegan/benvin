<?php
	$stock_on_date = isset($_GET['stock_on']) ? $_GET['stock_on'] : date('Y-m-d');
	$stocks = getStockOnDate($stock_on_date);
?>



<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Stock Avaliable <small>Custom design</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                    </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            <div class="filter-section">
              <div class="row">
                <div class="col-md-6">
                    Stock On <input type="text" name="name" class="name" value="" placeholder="Customer Name">
                </div>
            </div>
        </div>
        <div class="customer_filter">
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <th>
                                    S.No
                                </th>
                                <th class="column-title"> Description </th>
                                <th class="column-title"> Stock </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                                if($stocks) {
                                    $i = 1;
                                    foreach ($stocks as $s_value) {
                            ?>
                                    <tr class="odd pointer">
                                        <td class="a-center ">
                                            <?php echo $i; ?>
                                        </td>
                                        <td class=""><?php echo $s_value->product_name.' '.$s_value->product_type; ?></td>
                                        <td class=""><?php echo $s_value->new_stock; ?></td>
                                    </tr>
                            <?php
                                        $i++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>