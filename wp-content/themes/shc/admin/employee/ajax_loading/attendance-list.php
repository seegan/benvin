<?php
    $ppage = false;
    if(!$employee) {
        $employee = new employee();
        $ppage = 5;
    }

    $result_args = array(
        'orderby_field' => 'emp_created_at',
        'page' => $employee->cpage,
        'attendance_date' => $employee->attendance_date,
        'order_by' => 'DESC',
        'items_per_page' => ($ppage) ? $ppage : $employee->ppage ,
        'condition' => '',
    );

    $employee_list = $employee->employee_attendance_list_pagination($result_args);

?>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th>
                                S.No
                            </th>
                            <th class="column-title">Employee Name </th>
                            <th class="column-title">Mobile </th>
                            <th class="column-title">Date </th>
                            <th class="column-title">Attendance </th>
                            <th class="column-title">Action </th>
                            <th class="column-title">History</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        if( isset($employee_list['result']) && $employee_list['result'] ) {


                            $i = $employee_list['start_count']+1;
                            foreach ($employee_list['result'] as $e_value) {


                                $attendance_today =  '-';
                                if($e_value->attendance_today === "0") {
                                    $attendance_today =  'Absent';
                                }
                                if($e_value->attendance_today === "1") {
                                    $attendance_today =  'Present';
                                }
                                $employee_id = $e_value->id;
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center ">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class=""><?php echo $e_value->emp_name; ?></td>
                                    <td class=""><?php echo $e_value->emp_mobile; ?></td>
                                    <td class=""><?php echo $employee->attendance_date; ?></i></td>
                                    <td><div class="attendance_val"><?php echo $attendance_today; ?></div></td>
                                    <td>
                                        <select name="attendance_type" class="atten_type mark_attendance" data-attdate="<?php echo $employee->attendance_date; ?>" data-empid="<?php echo $e_value->id; ?>" >
                                            <option value="-" <?php echo ($attendance_today === '-') ? 'selected' : '' ?> >Mark Attendance</option>
                                            <option value="1" <?php echo ($attendance_today === 'Present') ? 'selected' : '' ?> >Present</option>
                                            <option value="0" <?php echo ($attendance_today === 'Absent') ? 'selected' : '' ?> >Absent</option>
                                        </select>
                                    </td>
                                    <td><a href="<?php echo admin_url('admin.php?page=list_attendance').'&action=attendance_detail&emp_id='.$e_value->id; ?>">Attendance History</a></td>
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



        <div class="row">
            <div class="col-sm-7">
                <div class="paging_simple_numbers" id="datatable-fixed-header_paginate">
                    <?php
                    echo $employee_list['pagination'];
                    ?>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="dataTables_info" id="datatable-fixed-header_info" role="status" aria-live="polite"></div>
            </div>
        </div>
