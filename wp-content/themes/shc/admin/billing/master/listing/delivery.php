<?php
    $ppage = false;
    if(!$deliverylist) {
        $deliverylist = new DeliveryList();
        $ppage = 5;
    }
    $result_args = array(
        'orderby_field' => 'd.delivery_date',
        'page' => $deliverylist->cpage,
        'order_by' => 'DESC',
        'items_per_page' => ($ppage) ? $ppage : $deliverylist->ppage ,
        'condition' => '',
    );

    $deliverylist->master_id = $master_id;
    $delivery_list = $deliverylist->delivery_list_pagination($result_args);

?>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th>
                                S.No
                            </th>
                            <th class="column-title">#DC</th>
                            <th class="column-title">#MRI</th>
                            <th class="column-title">Customer Name </th>
                            <th class="column-title">Site </th>
                            <th class="column-title">Delivery On </th>
                            <th class="column-title">Action </th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        if( isset($delivery_list['result']) && $delivery_list['result'] ) {
                            $i = $delivery_list['start_count']+1;

                            foreach ($delivery_list['result'] as $d_value) {
                                $master_id = $d_value->master_id;
                                $delivery_id = $d_value->id;
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center ">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class=""><?php echo 'DC'.$delivery_id; ?></td>
                                    <td class=""><?php echo 'MRI'.$master_id; ?></td>
                                    <td class=""><?php echo $d_value->name; ?></td>
                                    <td class=""><?php echo $d_value->site_name; ?></td>
                                    <td class=""><?php echo $d_value->delivery_date; ?></td>
                                    <td><a href="<?php echo menu_page_url( 'new_delivery', 0 )."&id=".$master_id."&delivery_id=${delivery_id}"; ?>">View</a></td>
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
                    echo $delivery_list['pagination'];
                    ?>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="dataTables_info" id="datatable-fixed-header_info" role="status" aria-live="polite"></div>
            </div>
        </div>
