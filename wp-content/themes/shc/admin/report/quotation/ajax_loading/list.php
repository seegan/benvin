<?php
    $ppage = false;
    if(!$quotationlist) {
        $quotationlist = new QuotationList();
        $ppage = 5;
    }
    $result_args = array(
        'orderby_field' => 'q.quotation_date',
        'page' => $quotationlist->cpage,
        'order_by' => 'DESC',
        'items_per_page' => ($ppage) ? $ppage : $quotationlist->ppage ,
        'condition' => '',
    );
    $quotation_list = $quotationlist->quotation_list_pagination($result_args);
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
                            <th class="column-title">#Q.No</th>
                            <th class="column-title">Customer Name </th>
                            <th class="column-title">Site </th>
                            <th class="column-title">Site Address </th>
                            <th class="column-title">Quotation On </th>
                            <th class="column-title">Action </th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        if( isset($quotation_list['result']) && $quotation_list['result'] ) {
                            $i = $quotation_list['start_count']+1;

                            foreach ($quotation_list['result'] as $d_value) {
                                $master_id = $d_value->master_id;
                                $quotation_id = $d_value->id;

                                $quotation_bill = $d_value->bill_no;
                                $company_id = $d_value->bill_from_comp;
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center ">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class=""><?php echo 'MRI'.$master_id; ?></td>
                                    <td class=""><?php echo $company_ids[$company_id].'/Q.No '.$quotation_bill; ?></td>
                                    <td class=""><?php echo $d_value->name; ?></td>
                                    <td class=""><?php echo $d_value->site_name; ?></td>
                                    <td class=""><?php echo $d_value->site_address.', '.$d_value->phone_number; ?></i>
                                    </td>
                                    <td class=""><?php echo $d_value->quotation_date; ?></td>
                                    <td><a href="<?php echo admin_url('admin.php?page=new_quotation')."&id=".$master_id."&quotation_id=${quotation_id}"; ?>">View</a></td>
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
                    echo $quotation_list['pagination'];
                    ?>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="dataTables_info" id="datatable-fixed-header_info" role="status" aria-live="polite"></div>
            </div>
        </div>
