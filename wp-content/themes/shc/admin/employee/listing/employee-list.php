<?php
    $employee = new Employee();
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
                    <option value="5" <?php echo ($employee->ppage == 5) ? 'selected' : '' ?>>5</option>
                    <option value="10" <?php echo ($employee->ppage == 10) ? 'selected' : '' ?>>10</option>
                    <option value="20" <?php echo ($employee->ppage == 20) ? 'selected' : '' ?>>20</option>
                    <option value="50" <?php echo ($employee->ppage == 50) ? 'selected' : '' ?>>50</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <input type="text" name="name" class="name" value="<?php echo $employee->name; ?>" placeholder="employee Name">
                </div>
                <div class="col-md-2">
                  <input type="text" name="mobile" class="mobile" value="<?php echo $employee->mobile; ?>" placeholder="Mobile">
                </div>
                <div class="col-md-2 form-group">
                  <input type="text" name="employee_from" class="employee_from form-control datepicker" value="<?php echo $employee->employee_from; ?>" placeholder="employee From">
                </div>
                <div class="col-md-2 form-group">
                  <input type="text" name="employee_to" class="employee_to form-control datepicker" value="<?php echo $employee->employee_to; ?>" placeholder="employee To">
                </div>
              </div>
              <input type="hidden" name="filter_action" class="filter_action" value="employee_filter">
              
            </div>
        </div>
        <div class="employee_filter">
        <?php
            include( get_template_directory().'/admin/employee/ajax_loading/employee-list.php' );
        ?>
        </div>
    </div>
</div>