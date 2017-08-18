<?php
    $ppage = false;
    if(!$masterlist) {
        $masterlist = new MasterList();
        $ppage = 5;
    }
    $result_args = array(
        'orderby_field' => 'm.master_date',
        'page' => $masterlist->cpage,
        'order_by' => 'DESC',
        'items_per_page' => ($ppage) ? $ppage : $masterlist->ppage ,
        'condition' => '',
    );
    $master_list = $masterlist->master_list_pagination($result_args);

?>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th>
                                S.No
                            </th>
                            <th class="column-title">#MRI</th>
                            <th class="column-title">Customer Name </th>
                            <th class="column-title">Site </th>
                            <th class="column-title">Site Address </th>
                            <th class="column-title">Deposit Date</th>
                            <th class="column-title">Action </th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        if( isset($master_list['result']) && $master_list['result'] ) {
                            $i = $master_list['start_count']+1;

                            foreach ($master_list['result'] as $m_value) {
                                $master_id = $m_value->id;
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center ">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class=""><?php echo 'MRI'.$m_value->id; ?></td>
                                    <td class=""><?php echo $m_value->name; ?></td>
                                    <td class=""><?php echo $m_value->site_name; ?></td>
                                    <td class=""><?php echo $m_value->site_address.', '.$m_value->phone_number; ?></i>
                                    </td>
                                    <td class=""><?php echo $m_value->master_date; ?></td>
                                    <td><a href="<?php echo admin_url('admin.php?page=master')."&id=${master_id}"; ?>">View</a></td>
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
                    echo $master_list['pagination'];
                    ?>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="dataTables_info" id="datatable-fixed-header_info" role="status" aria-live="polite"></div>
            </div>
        </div>
