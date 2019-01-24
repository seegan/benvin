<?php
    $ppage = false;
    if(!$depositlist) { 
        $depositlist = new DepositList();
        $ppage = 5;
        $depositlist->financial_year = '-';
    }
    $result_args = array(
        'orderby_field' => 'd.deposit_date',
        'page' => $depositlist->cpage,
        'order_by' => 'DESC',
        'items_per_page' => ($ppage) ? $ppage : $depositlist->ppage ,
        'condition' => '',
    );

    $depositlist->master_id = $master_id;
    $deposit_list = $depositlist->deposit_list_pagination($result_args);

?>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th>
                                S.No
                            </th>
                            <th class="column-title">#SD</th>
                            <th class="column-title">Customer Name </th>
                            <th class="column-title">Site </th>
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
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center ">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class=""><?php echo 'SD'.$deposit_id; ?></td>
                                    <td class=""><?php echo $d_value->name; ?></td>
                                    <td class=""><?php echo $d_value->site_name; ?></td>
                                    </td>
                                    <td class=""><?php echo $d_value->deposit_date; ?></td>
                                    <td><a href="<?php echo menu_page_url( 'deposit', 0 )."&id=".$master_id."&deposit_id=${deposit_id}"; ?>">View</a></td>
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
                    echo $deposit_list['pagination'];
                    ?>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="dataTables_info" id="datatable-fixed-header_info" role="status" aria-live="polite"></div>
            </div>
        </div>
