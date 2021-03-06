<?php
    $ppage = false;
    if(!$returnlist) {
        $returnlist = new ReturnList();
        $ppage = 5;
        $returnlist->financial_year = '-';
    }

    $result_args = array(
        'orderby_field' => 'r.return_date',
        'page' => $returnlist->cpage,
        'order_by' => 'DESC',
        'items_per_page' => ($ppage) ? $ppage : $returnlist->ppage ,
        'condition' => '',
    );
    $returnlist->master_id = $master_id;
    $return_list = $returnlist->return_list_pagination($result_args);

?>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th>
                                S.No
                            </th>
                            <th class="column-title">#MRR</th>
                            <th class="column-title">#MRI</th>
                            <th class="column-title">Customer Name </th>
                            <th class="column-title">Site </th>
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
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center ">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class=""><?php echo 'MRR'.$return_id; ?></td>
                                    <td class=""><?php echo 'MRI'.$master_id; ?></td>
                                    <td class=""><?php echo $r_value->name; ?></td>
                                    <td class=""><?php echo $r_value->site_name; ?></td>
                                    <td class=""><?php echo $r_value->return_date; ?></td>
                                    <td><a href="<?php echo menu_page_url( 'new_return', 0 )."&id=".$master_id."&return_id=${return_id}"; ?>">View</a></td>
                                </tr>
                    <?php
                                $i++;
                            }
                        } else {
                            echo "<td colspan='8'>No Record!</td>";
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
