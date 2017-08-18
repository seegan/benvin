<?php
    $ppage = false;
    if(!$hiringlist) {
        $hiringlist = new HiringList();
        $ppage = 5;
    }
    $result_args = array(
        'orderby_field' => 'f.bill_date',
        'page' => $hiringlist->cpage,
        'order_by' => 'DESC',
        'items_per_page' => ($ppage) ? $ppage : $hiringlist->ppage ,
        'condition' => '',
    );
    $hiring_list = $hiringlist->hiring_list_pagination($result_args);
?>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th>S.No</th>
                            <th>Master Id</th>
                            <th>Bill No</th>
                            <th class="column-title">Customer Name </th>
                            <th class="column-title">Site Name </th>
                            <th class="column-title">Bill Date</th>
                            <th class="column-title">Bill Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        if( isset($hiring_list['result']) && $hiring_list['result'] ) {
                            $i = $hiring_list['start_count']+1;

                            foreach ($hiring_list['result'] as $c_value) {
                                $bill_id = $c_value->id;
                                $master_id = $c_value->master_id;
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center ">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class=""><?php echo 'MRI '.$c_value->master_id; ?></td>
                                    <td class=""><?php echo 'HBI '.$c_value->id; ?></td>
                                    <td class=""><?php echo $c_value->name; ?></i></td>
                                    <td class=""><?php echo $c_value->site_name; ?></td>
                                    <td class=""><?php echo '( '.$c_value->bill_from.' - '.$c_value->bill_to.' )'; ?></td>
                                    <td class=""><?php echo $c_value->hiring_total; ?></td>
                                    <td><a href="<?php echo admin_url('admin.php?page=new_hiring')."&id=${master_id}&bill_id=${bill_id}"; ?>">View Bill</a></td>
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
                    echo $hiring_list['pagination'];
                    ?>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="dataTables_info" id="datatable-fixed-header_info" role="status" aria-live="polite"></div>
            </div>
        </div>
