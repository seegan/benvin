<?php
    $masterlist = new MasterList();
?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Master List</h2>
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
                    <option value="5" <?php echo ($masterlist->ppage == 5) ? 'selected' : '' ?>>5</option>
                    <option value="10" <?php echo ($masterlist->ppage == 10) ? 'selected' : '' ?>>10</option>
                    <option value="20" <?php echo ($masterlist->ppage == 20) ? 'selected' : '' ?>>20</option>
                    <option value="50" <?php echo ($masterlist->ppage == 50) ? 'selected' : '' ?>>50</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <input type="text" name="id" class="id" value="<?php echo $masterlist->id; ?>" placeholder="Master ID">
                </div>
                <div class="col-md-2">
                  <input type="text" name="name" class="name" value="<?php echo $masterlist->name; ?>" placeholder="Customer Name">
                </div>
                <div class="col-md-2">
                  <input type="text" name="site_name" class="site1_name" value="<?php echo $masterlist->site_name; ?>" placeholder="Site Name">
                </div>
                <div class="col-md-2 form-group">
                  <input type="text" name="master_from" class="datepicker master_from form-control" value="<?php echo $masterlist->master_from; ?>" placeholder="Master Date From">
                </div>
                <div class="col-md-2 form-group">
                  <input type="text" name="master_to" class="datepicker master_to form-control" value="<?php echo $masterlist->master_to; ?>" placeholder="Master Date To">
                </div>
              </div>
              <input type="hidden" name="filter_action" class="filter_action" value="master_filter">
              
            </div>
        </div>
        <div class="master_filter">
        <?php
            include( get_template_directory().'/admin/report/master/ajax_loading/list.php' );
        ?>
        </div>
    </div>
</div>