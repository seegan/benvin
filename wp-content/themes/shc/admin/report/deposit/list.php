<?php
    $depositlist = new DepositList();
?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Table design <small>Custom design</small></h2>
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
                <div class="col-md-1">
                  <select name="ppage" class="ppage">
                    <option value="5" <?php echo ($depositlist->ppage == 5) ? 'selected' : '' ?>>5</option>
                    <option value="10" <?php echo ($depositlist->ppage == 10) ? 'selected' : '' ?>>10</option>
                    <option value="20" <?php echo ($depositlist->ppage == 20) ? 'selected' : '' ?>>20</option>
                    <option value="50" <?php echo ($depositlist->ppage == 50) ? 'selected' : '' ?>>50</option>
                  </select>
                </div>
                <div class="col-md-1">
                  <input type="text" name="id" class="id" value="<?php echo $masterlist->id; ?>" placeholder="Deposit ID" style="width:100%;">
                </div>
                <div class="col-md-1">
                  <input type="text" name="master_id" class="master_id" value="<?php echo $masterlist->master_id; ?>" placeholder="Master ID" style="width:100%;">
                </div>
                <div class="col-md-2">
                  <input type="text" name="name" class="name" value="<?php echo $masterlist->name; ?>" placeholder="Customer Name">
                </div>
                <div class="col-md-2">
                  <input type="text" name="site_name" class="site1_name" value="<?php echo $masterlist->site_name; ?>" placeholder="Site Name">
                </div>
                <div class="col-md-2 form-group">
                  <input type="text" name="deposit_from" class="datepicker deposit_from form-control" value="<?php echo $masterlist->deposit_from; ?>" placeholder="Deposit Date From">
                </div>
                <div class="col-md-2 form-group">
                  <input type="text" name="deposit_to" class="datepicker deposit_to form-control" value="<?php echo $masterlist->deposit_to; ?>" placeholder="Deposit Date To">
                </div>
              </div>
              <input type="hidden" name="filter_action" class="filter_action" value="deposit_filter">
              
            </div>
        </div>
        <div class="deposit_filter">
        <?php
            include( get_template_directory().'/admin/report/deposit/ajax_loading/list.php' );
        ?>
        </div>
    </div>
</div>