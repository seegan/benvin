<?php
    $ppage = false;
    if(!$employee) {
        $employee = new employee();
        $ppage = 5;
    }

    $result_args = array(
        'orderby_field' => 'emp_created_at',
        'page' => $employee->cpage,
        'order_by' => 'DESC',
        'items_per_page' => ($ppage) ? $ppage : $employee->ppage ,
        'condition' => '',
    );


    $employee_list = $employee->employee_list_pagination($result_args);

?>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th>
                                S.No
                            </th>
                            <th class="column-title">employee Name </th>
                            <th class="column-title">Mobile </th>
                            <th class="column-title">Address </th>
                            <th class="column-title">Salary </th>
                            <th class="column-title">Join Date </th>
                            <th class="column-title">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        if( isset($employee_list['result']) && $employee_list['result'] ) {
                            $i = $employee_list['start_count']+1;

                            foreach ($employee_list['result'] as $e_value) {
                                $employee_id = $e_value->id;
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center ">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class=""><?php echo $e_value->emp_name; ?></td>
                                    <td class=""><?php echo $e_value->emp_mobile; ?></td>
                                    <td class=""><?php echo $e_value->emp_address; ?></i>
                                    </td>
                                    <td class=""><?php echo $e_value->emp_salary; ?></td>
                                    <td class=""><?php echo $e_value->emp_joining; ?></td>
                                    <td><a href="<?php echo admin_url('admin.php?page=new_employee')."&id=${employee_id}"; ?>">Update</a></td>
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
