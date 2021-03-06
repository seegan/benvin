<?php
    $obclist = new ObcList();
?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Receipt List</h2>
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
                    <option value="5" <?php echo ($obclist->ppage == 5) ? 'selected' : '' ?>>5</option>
                    <option value="10" <?php echo ($obclist->ppage == 10) ? 'selected' : '' ?>>10</option>
                    <option value="20" <?php echo ($obclist->ppage == 20) ? 'selected' : '' ?>>20</option>
                    <option value="50" <?php echo ($obclist->ppage == 50) ? 'selected' : '' ?>>50</option>
                  </select>
                </div>
                <div class="col-md-1">
                  <input type="text" name="id" class="id" value="<?php echo $obclist->id; ?>" placeholder="OBC ID" style="width:100%;">
                </div>
                <div class="col-md-1">
                  <input type="text" name="master_id" class="master_id" value="<?php echo $obclist->master_id; ?>" placeholder="Master ID" style="width:100%;">
                </div>
                <div class="col-md-2">
                  <input type="text" name="cheque_no" class="cheque_no" value="<?php echo $obclist->cheque_no; ?>" placeholder="Cheque Number">
                </div>                
                <div class="col-md-2">
                  <input type="text" name="name" class="name" value="<?php echo $obclist->name; ?>" placeholder="Customer Name">
                </div>
                <div class="col-md-2">
                  <input type="text" name="site_name" class="site1_name" value="<?php echo $obclist->site_name; ?>" placeholder="Site Name">
                </div>
                <div class="col-md-2 form-group">
                  <input type="text" name="cheque_from" class="datepicker cheque_from form-control" value="<?php echo $obclist->cheque_from; ?>" placeholder="Cheque Date From">
                </div>
                <div class="col-md-2 form-group">
                  <input type="text" name="cheque_to" class="datepicker cheque_to form-control" value="<?php echo $obclist->cheque_to; ?>" placeholder="Cheque Date To">
                </div>
              </div>
              <input type="hidden" name="filter_action" class="filter_action" value="obc_filter">
              
            </div>
        </div>
        <div class="obc_filter">
        <?php
            include( get_template_directory().'/admin/report/obc/ajax_loading/list.php' );
        ?>
        </div>
    </div>
</div>