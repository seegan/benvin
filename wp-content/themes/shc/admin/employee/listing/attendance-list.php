<?php
    $employee = new Employee();
    if(isset($_GET['action']) && $_GET['action'] == 'attendance_detail') {
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
                    <div class="col-md-2 form-group">
                        <input type="text" name="attendance_from" id="attendance_from" class="datepicker" autocomplete="off" placeholder="Attendance From" value="<?php echo $employee->attendance_from; ?>">
                    </div>
                    <div class="col-md-2 form-group">
                        <input type="text" name="attendance_to" id="attendance_to" class="datepicker" autocomplete="off" placeholder="Attendance To" value="<?php echo $employee->attendance_to; ?>">
                    </div>
                    <div class="col-md-2 form-group">
                        <select name="attendance_status" id="attendance_status">
                            <option value="-" >Select Status</option>
                            <option value="1" <?php echo ($employee->attendance_status === 1) ? 'selected' : ''; ?>>Present</option>
                            <option value="0" <?php echo ($employee->attendance_status === 0) ? 'selected' : ''; ?>>Absent</option>
                        </select>
                    </div>
                  </div>
                  <input type="hidden" name="emp_id" value="<?php echo $_GET['emp_id']; ?>">
                  <input type="hidden" name="filter_action" class="filter_action" value="attendance_detail_filter">
                  
                </div>
            </div>
            <div class="attendance_detail_filter">
            <?php
                include( get_template_directory().'/admin/employee/ajax_loading/attendance-detail-list.php' );
            ?>
            </div>
        </div>
    </div>

<?php
    } else {
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
                        <input type="text" name="attendance_date" id="attendance_date" class="datepicker" autocomplete="off" placeholder="Attendance Date" value="<?php echo $employee->attendance_date; ?>">
                    </div>
                    <div class="col-md-2 form-group">
                        <select name="attendance_status" id="attendance_status">
                            <option value="-" >Select Status</option>
                            <option value="1" <?php echo ($employee->attendance_status === 1) ? 'selected' : ''; ?>>Present</option>
                            <option value="0" <?php echo ($employee->attendance_status === 0) ? 'selected' : ''; ?>>Absent</option>
                        </select>
                    </div>
                  </div>
                  <input type="hidden" name="filter_action" class="filter_action" value="attendance_filter">
                  
                </div>
            </div>
            <div class="attendance_filter">
            <?php
                include( get_template_directory().'/admin/employee/ajax_loading/attendance-list.php' );
            ?>
            </div>
        </div>
    </div>
<?php
    }
?>
