<?php
    $ppage = false;

    $from_dashboard = false;    
    if(!$returnlist) {
        $from_dashboard = true;
        $returnlist = new ReturnList();
        $ppage = 5;
    }
    $result_args = array(
        'orderby_field' => 'r.return_date',
        'page' => $returnlist->cpage,
        'order_by' => 'DESC',
        'items_per_page' => ($ppage) ? $ppage : $returnlist->ppage ,
        'condition' => '',
    );
    $return_list = $returnlist->return_list_pagination($result_args);
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
                            <?php 
                                if(!$from_dashboard) {
                                    echo '<th class="column-title">Site Address </th>';
                                }
                            ?>
                            <th class="column-title">return On </th>
                            <th class="column-title">Action </th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        if( isset($return_list['result']) && $return_list['result'] ) {
                            $i = $return_list['start_count']+1;

                            foreach ($return_list['result'] as $r_value) {
                                $master_id = $r_value->master_id;
                                $return_id = $r_value->id;

                                $return_bill = $r_value->bill_no;
                                $company_id = $r_value->bill_from_comp;
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center ">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class=""><?php echo 'MRI '.$master_id; ?></td>
                                    <td class="">
                                        <a class="bill_txt" href="<?php echo admin_url('admin.php?page=new_return')."&id=".$master_id."&return_id=${return_id}"; ?>">
                                            <?php echo $company_ids[$company_id].'/MRR '.$return_bill; ?> 
                                        </a>
                                    </td>              
                                    <td class=""><?php echo $r_value->name; ?></td>
                                    <td class=""><?php echo $r_value->site_name; ?></td>
                                    <?php 
                                        if(!$from_dashboard) {
                                            echo '<td class="">'.$r_value->site_address.', '.$r_value->phone_number.'</td>';
                                        }
                                    ?>
                                    <td class=""><?php echo $r_value->return_date; ?></td>
                                    <td>
                                        <div class="list_action">
                                            <div class="open_record left-float">
                                                <a href="<?php echo admin_url('admin.php?page=new_return')."&id=".$master_id."&return_id=${return_id}"; ?>">
                                                    <img src="<?php echo get_template_directory_uri() . '/admin/inc/images/open-icon.png'?>">
                                                </a>
                                            </div>
                                            <div class="print_record left-float" data-action="print_return" data-action-from="list" data-print-id="<?php echo $return_id; ?>">
                                                <img src="<?php echo get_template_directory_uri() . '/admin/inc/images/printer-icon.png'?>">
                                            </div>                                        
                                            <div class="delete_record left-float" data-action="shc_return" data-action-from="list" data-delete-id="<?php echo $return_id; ?>">
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
                    echo $return_list['pagination'];
                    ?>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="dataTables_info" id="datatable-fixed-header_info" role="status" aria-live="polite"></div>
            </div>
        </div>
