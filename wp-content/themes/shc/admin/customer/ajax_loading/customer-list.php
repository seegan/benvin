<?php
    $ppage = false;
    if(!$customer) {
        $customer = new Customer();
        $ppage = 5;
    }

    $result_args = array(
        'orderby_field' => 'created_at',
        'page' => $customer->cpage,
        'order_by' => 'DESC',
        'items_per_page' => ($ppage) ? $ppage : $customer->ppage ,
        'condition' => '',
    );
    $customer_list = $customer->customer_list_pagination($result_args);

?>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th>
                                S.No
                            </th>
                            <th class="column-title">Customer Name </th>
                            <th class="column-title">Mobile </th>
                            <th class="column-title">Address </th>
                            <th class="column-title">Registered On </th>
                            <th class="column-title">Action </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if( isset($customer_list['result']) && $customer_list['result'] ) {
                            $i = $customer_list['start_count']+1;

                            foreach ($customer_list['result'] as $c_value) {
                                $customer_id = $c_value->id;
                    ?>
                                <tr class="odd pointer">
                                    <td class="a-center ">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class=""><?php echo $c_value->name; ?></td>
                                    <td class=""><?php echo $c_value->mobile; ?></td>
                                    <td class=""><?php echo $c_value->address; ?></i>
                                    </td>
                                    <td class=""><?php echo $c_value->created_at; ?></td>
                                    <td><a href="<?php echo admin_url('admin.php?page=new_customer')."&id=${customer_id}"; ?>">Update</a></td>
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
                    echo $customer_list['pagination'];
                    ?>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="dataTables_info" id="datatable-fixed-header_info" role="status" aria-live="polite"></div>
            </div>
        </div>
