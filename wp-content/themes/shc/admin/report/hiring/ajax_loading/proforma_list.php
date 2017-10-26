<?php
    $ppage = false;
    if(!$hiringlist) {
        $hiringlist = new HiringList();
        $ppage = 5;
    }
    $result_args = array(
        'orderby_field' => 'f.bill_status',
        'page' => $hiringlist->cpage,
        'order_by' => 'ASC',
        'items_per_page' => ($ppage) ? $ppage : $hiringlist->ppage ,
        'condition' => '',
    );
    $hiring_list = $hiringlist->proforma_list_pagination($result_args);
    $company_ids = getCompanies('to_list');    
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
                            <th class="column-title">Payment Status</th>
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

                                $hiring_bill = $c_value->bill_no;
                                $company_id = $c_value->bill_from_comp;
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center ">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class=""><?php echo 'MRI '.$c_value->master_id; ?></td>
                                    <td class="">
                                        <a class="bill_txt" href="<?php echo admin_url('admin.php?page=new_hiring')."&id=".$master_id."&bill_id=${bill_id}"; ?>">
                                            <?php echo $company_ids[$company_id].'/HB '.$hiring_bill; ?> 
                                        </a>
                                    </td>
                                    <td class=""><?php echo $c_value->name; ?></i></td>
                                    <td class=""><?php echo $c_value->site_name; ?></td>
                                    <td class=""><?php echo '( '.$c_value->bill_from.' - '.$c_value->bill_to.' )'; ?></td>
                                    <td class="">
                                        <?php
                                            if($c_value->bill_status == 1) {
                                                echo '<div class="pending_bill"><img src="'.get_template_directory_uri() . '/admin/billing/inc/images/pending.png'.'"></div>';
                                            }
                                            if($c_value->bill_status == 2) {
                                                echo '<img src="'.get_template_directory_uri() . '/admin/billing/inc/images/paid.png'.'">';
                                            }
                                        ?>
                                    </td>
                                    <td class=""><?php echo $c_value->hiring_total; ?></td>
                                    <td>
                                        <div class="list_action">
                                            <div class="open_record left-float">
                                                <a href="<?php echo admin_url('admin.php?page=new_hiring')."&id=".$master_id."&bill_id=${bill_id}"; ?>">
                                                    <img src="<?php echo get_template_directory_uri() . '/admin/inc/images/open-icon.png'?>">
                                                </a>
                                            </div>
                                            <div class="print_record left-float" data-action="print_hiring" data-action-from="list" data-print-id="<?php echo $bill_id; ?>">
                                                <img src="<?php echo get_template_directory_uri() . '/admin/inc/images/printer-icon.png'?>">
                                            </div>                                        
                                            <div class="delete_record left-float" data-action="shc_hiring" data-action-from="list" data-delete-id="<?php echo $bill_id; ?>">
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
                    echo $hiring_list['pagination'];
                    ?>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="dataTables_info" id="datatable-fixed-header_info" role="status" aria-live="polite"></div>
            </div>
        </div>
