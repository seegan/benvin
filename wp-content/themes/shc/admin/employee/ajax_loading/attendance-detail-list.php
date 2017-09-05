<?php
    $ppage = false;
    if(!$employee) {
        $employee = new employee();
        $ppage = 5;
    }

	$result_args = array(
		'orderby_field' => 'id',
		'page' => isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1 ,
		'order_by' => 'ASC',
		'items_per_page' => isset( $_GET['ppage'] ) ? abs( (int) $_GET['ppage'] ) : 20 ,
		'condition' => '',
	);

	$employee_attendance = $employee->employee_attendance_detail_pagination($result_args);

?>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th>
                                S.No
                            </th>
                            <th class="column-title">Date</th>
                            <th class="column-title">Attendance </th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        if( isset($employee_attendance['result']) && $employee_attendance['result'] ) {

                            $i = $employee_attendance['start_count']+1;
                            foreach ($employee_attendance['result'] as $a_value) {
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center ">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class=""><?php echo $a_value->attendance_date; ?></td>
                                    <td class=""><?php echo $a_value->attendance; ?></td>
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
