<div class="col-lg-12">
	<div class="deposit-repeater return_detail_group" style="margin-top:20px;">
		<table class="table table-bordered" data-repeater-list="return_detail_group">
			<thead>
				<tr>
					<th rowspan="2" style="width:50px;" class="center-th"><div>S.No</div></th>
					<th rowspan="2" colspan="3" class="center-th" style="min-width: 200px;"><div>Description</div></th>
					<th colspan="3" class="center-th" style="width:80px;">
						<div>Qty</div>
					</th>
					<th colspan="2" class="center-th show_lost">
						<div>
							Lost Cost
						</div>
					</th>
				</tr>
				<tr>
					<td style="width:20px;">Taken</td>
					<td style="width:20px;">In Hand</td>
					<td style="width:20px;">
						<span class="show_lost">Lost</span>
					</td>
					<td class="show_lost">
						<span>Per Unit</span>
					</td>	
					<td class="show_lost">
						<span>Total</span>
					</td>										
				</tr>
			</thead>
			<tbody class="return-group">
			<?php


				if($pending_items && isset($pending_items['grouping_detail']) && count($pending_items['grouping_detail']) > 0) {
					$i = 1;
					foreach ($pending_items['grouping_detail'] as $g_value) {
			?>
				<tr class="div-table-row" class="repeterin div-table-row" data-repeater-item>
					<td>
						<div class="rowno align-txt"><?php echo $i; ?></div>
					</td>
					<td colspan="3">
						<div class="align-txt">
							<span><?php echo $g_value->product_name ?></span>
							<span><?php echo $g_value->product_type ?></span>
							<input type="hidden" name="lot_id" value="<?php echo $g_value->lot_id ?>">
						</div>
					</td>
					<td>
						<div class="align-txt">
							<span><?php echo $g_value->qty; ?></span>
						</div>
					</td>
					<td>
						<div class="align-txt">
							<input type="hidden" class="in_hand" value="<?php echo $g_value->return_pending; ?>">
							<span><?php echo $g_value->return_pending; ?></span>
						</div>
					</td>
					<td>
						<div class="align-txt">
							<input type="text" style="border-color: rgba(118, 118, 118, 0);height:34px;margin:0;" class="return_qty" value="0" data-lotid="<?php echo $g_value->lot_id ?>" name="lost_qty">
						</div>
					</td>
					<td class="show_lost" style="width:75px;">
						<div class="align-txt">
							<input type="text" name="lost_per_unit" class="lost_per_unit" value="<?php echo $g_value->buying_price; ?>" style="border-color: rgba(118, 118, 118, 0);height:34px;margin:0;width:75px;">
						</div>
					</td>
					<td class="show_lost">
						<div class="align-txt lost_row_total_txt">0</div>
						<input type="hidden" name="lost_row_total" value="0" class="lost_row_total">
					</td>
				</tr>
			<?php
						$i++;
					}
				} else {
			?>
				<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row">
					<td colspan="7">
						<center>No Pending Items</center>
					</td>
				</tr>
			<?php
				}

				//echo (getUnloadingData('unloading'));
			?>
				<tr class="show_row_lost">
					<td colspan="6" style="">
						<div class="align-txt">
							<div class="return-charge-txt">Total</div>
						</div>
					</td>
					<td>
						<div class="align-txt">
							<div class="return-charge-val">
								<span class="lost_qty_total_txt">0</span>
								<input type="hidden" name="lost_qty_total" class="lost_qty_total" value="0">
							</div>
						</div>
					</td>
					<td colspan="2">
						<div class="align-txt">
							<div class="return-charge-val">Rs.
								<span class="lost_total_txt">0</span> 
								<input type="hidden" name="lost_cost" class="lost_total" value="0">
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>


	<div style="float:right;">
      	<?php 
      		if($master_data) {
      			echo "<input type='hidden' name='master_id' class='master_id_input' value='".$master_data['master_data']->id."'>";
				echo "<button type='submit' class='btn btn-success update_lost'>Update Lost</button>";
      			echo "<input type='hidden' name='return_id' value='".$return_data['return_data']->id."'>";
      			echo "<input type='hidden' name='lost_id' value='".$lost_data['lost_data']->id."'>";
				echo "<input type='hidden' name='action' class='action' value='update_lost'>";
      		}
      	?>
   	</div>
   	<button class="show_hide_btn" style="float:left;">Show / Hide Detail</button>


</div>




<div class="col-lg-12 show_hide_slide" style="display:none;">
	

	<div class="deposit-repeater return_detail" style="margin-top:20px;">
		<table class="table table-bordered" data-repeater-list="return_detail">
			<thead>
				<tr>
					<th rowspan="2" style="width:50px;" class="center-th"><div>S.No</div></th>
					<th rowspan="2" colspan="3" class="center-th" style="min-width: 200px;"><div>Description</div></th>
					<th rowspan="2" class="center-th" style="width: 100px;"><div>Delivery Taken</div></th>
					<th colspan="3" class="center-th" style="width:80px;">
						<div>Qty</div>
					</th>
				</tr>
				<tr>
					<td style="width:20px;">Taken</td>
					<td style="width:20px;">In Hand</td>
					<td style="width:20px;">Return</td>
				</tr>
			</thead>
			<tbody class="return-detail">
			<?php
				if($pending_items && isset($pending_items['pending_detail']) && count($pending_items['pending_detail']) > 0) {
					$i = 1;
					foreach ($pending_items['pending_detail'] as $p_value) {
			?>
				<tr class="div-table-row" data-repeater-item class="repeterin div-table-row" >
					<td>
						<div class="rowno align-txt"><?php echo $i; ?></div>
						<input type="hidden" class="delivery_detail_id" name="delivery_detail_id" value="<?php echo $p_value->id; ?>">
					</td>
					<td colspan="3">
						<div class="align-txt">
							<span><?php echo $p_value->product_name ?></span>
							<span><?php echo $p_value->product_type ?></span>
							<input type="hidden" name="lot_id" value="<?php echo $p_value->lot_id ?>">
						</div>
					</td>
					<td>
						<div class="align-txt">
							<span><?php echo $p_value->delivery_date ?></span>
						</div>
					</td>
					<td>
						<div class="align-txt">
							<span><?php echo $p_value->qty; ?></span>
						</div>
					</td>
					<td>
						<div class="align-txt">
							<input type="hidden" class="in_hand_group" value="<?php echo $p_value->return_pending; ?>">
							<span><?php echo $p_value->return_pending; ?></span>
						</div>
					</td>
					<td>
						<div class="align-txt">
							<input type="text" name="qty" style="border-color: rgba(118, 118, 118, 0);height:34px;margin:0;" class="return_qty return_group_qty_<?php echo $p_value->lot_id ?>" value="0" >
						</div>
					</td>
				</tr>
			<?php
						$i++;
					}
				} else {
			?>
				<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row">
					<td colspan="6">
						<center>No Pending Items</center>
					</td>
				</tr>
			<?php
				}

				//echo (getUnloadingData('unloading'));
			?>
			</tbody>
		</table>
	</div>

</div>