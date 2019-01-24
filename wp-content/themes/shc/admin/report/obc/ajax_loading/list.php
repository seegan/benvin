<?php
    $ppage = false;
    if(!$obclist) {
        $obclist = new ObcList();
        $ppage = 5;
    }
    $result_args = array(
        'orderby_field' => 'om.modified_at',
        'page' => $obclist->cpage,
        'order_by' => 'DESC',
        'items_per_page' => ($ppage) ? $ppage : $obclist->ppage ,
        'condition' => '',
    );
    $obc_list = $obclist->obc_list_pagination($result_args);
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
                            <th class="column-title">#MRR</th>
                            <th class="column-title">Customer Name </th>
                            <th class="column-title">Site </th>
                            <th class="column-title">Payment Detail </th>
                            <th class="column-title">Receipt type </th>
                            <th class="column-title">Amount </th>
                            <th class="column-title">Receipt Date </th>
                            <th class="column-title">Action </th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        if( isset($obc_list['result']) && $obc_list['result'] ) {
                            $i = $obc_list['start_count']+1;

                            foreach ($obc_list['result'] as $r_value) {
                                $master_id = $r_value->master_id;
                                $obc_id = $r_value->id;

                                $obc_bill = $r_value->bill_no;
                                $company_id = $r_value->bill_from_comp;
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center ">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class=""><?php echo 'MRI '.$master_id; ?></td>
                                    <td class="">
                                        <a class="bill_txt" href="<?php echo admin_url('admin.php?page=new_obc')."&id=".$master_id."&obc_id=${obc_id}"; ?>">
                                            <?php echo $company_ids[$company_id].'/OBC '.$obc_bill; ?> 
                                        </a>
                                    </td>
                                    <td class=""><?php echo $r_value->name; ?></td>
                                    <td class=""><?php echo $r_value->site_name; ?></td>
                                    <td class="">
                                        No : <?php echo $r_value->cheque_no; ?><br/>
                                        Date : <?php echo $r_value->cheque_date; ?><br/>
                                    </td>
                                    <td>
                                        <?php echo $r_value->cd_notes; ?>
                                    </td>
                                    <td>
                                        <?php echo $r_value->cheque_amount; ?>
                                    </td>
                                    <td class=""><?php echo $r_value->obc_date; ?></td>
                                    <td>
                                        <div class="list_action">
                                            <div class="open_record left-float">
                                                <a href="<?php echo admin_url('admin.php?page=new_obc')."&id=".$master_id."&obc_id=${obc_id}"; ?>">
                                                    <img src="<?php echo get_template_directory_uri() . '/admin/inc/images/open-icon.png'?>">
                                                </a>
                                            </div>
                                                                                 
                                            <div class="delete_record left-float" data-action="shc_obc" data-action-from="list" data-delete-id="<?php echo $obc_id; ?>">
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
                    echo $obc_list['pagination'];
                    ?>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="dataTables_info" id="datatable-fixed-header_info" role="status" aria-live="polite"></div>
            </div>
        </div>
