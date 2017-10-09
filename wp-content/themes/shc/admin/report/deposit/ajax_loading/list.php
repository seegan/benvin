<?php
    $ppage = false;
    if(!$depositlist) {
        $depositlist = new DepositList();
        $ppage = 5;
    }
    $result_args = array(
        'orderby_field' => 'd.deposit_date',
        'page' => $depositlist->cpage,
        'order_by' => 'DESC',
        'items_per_page' => ($ppage) ? $ppage : $depositlist->ppage ,
        'condition' => '',
    );
    $deposit_list = $depositlist->deposit_list_pagination($result_args);
    $company_ids = getCompanies('to_list');
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
                            <th class="column-title">#SD</th>
                            <th class="column-title">Customer Name </th>
                            <th class="column-title">Site </th>
                            <th class="column-title">Site Address </th>
                            <th class="column-title">Deposit On </th>
                            <th class="column-title">Action </th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        if( isset($deposit_list['result']) && $deposit_list['result'] ) {
                            $i = $deposit_list['start_count']+1;

                            foreach ($deposit_list['result'] as $d_value) {
                                $master_id = $d_value->master_id;
                                $deposit_id = $d_value->id;

                                $deposit_bill = $d_value->bill_no;
                                $company_id = $d_value->bill_from_comp;
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center ">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class="">
                                        <?php echo 'MRI '.$master_id; ?>
                                    </td>
                                    <td class="">
                                        <a class="bill_txt" href="<?php echo admin_url('admin.php?page=deposit')."&id=".$master_id."&deposit_id=${deposit_id}"; ?>">
                                            <?php echo $company_ids[$company_id].'/SD '.$deposit_bill; ?> 
                                        </a>                                        
                                    </td>
                                    <td class=""><?php echo $d_value->name; ?></td>
                                    <td class=""><?php echo $d_value->site_name; ?></td>
                                    <td class=""><?php echo $d_value->site_address.', '.$d_value->phone_number; ?></i>
                                    </td>
                                    <td class=""><?php echo $d_value->deposit_date; ?></td>
                                    <td>
                                        <div class="list_action">
                                            <div class="open_record left-float">
                                                <a href="<?php echo admin_url('admin.php?page=deposit')."&id=".$master_id."&deposit_id=${deposit_id}"; ?>">
                                                    <img src="<?php echo get_template_directory_uri() . '/admin/inc/images/open-icon.png'?>">
                                                </a>
                                            </div>
                                            <div class="print_record left-float" data-action="print_deposit" data-action-from="list" data-print-id="<?php echo $deposit_id; ?>">
                                              <img src="<?php echo get_template_directory_uri() . '/admin/inc/images/printer-icon.png'?>">
                                            </div>                                        
                                            <div class="delete_record left-float" data-action="shc_deposit" data-action-from="list" data-delete-id="<?php echo $deposit_id; ?>">
                                                <img class="shake" src="<?php echo get_template_directory_uri() . '/admin/inc/images/remove-icon.png'?>">
                                            </div> 
                                            <div class="clear"></div>
                                        </div>
                                    </td>
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
                    echo $deposit_list['pagination'];
                    ?>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="dataTables_info" id="datatable-fixed-header_info" role="status" aria-live="polite"></div>
            </div>
        </div>
