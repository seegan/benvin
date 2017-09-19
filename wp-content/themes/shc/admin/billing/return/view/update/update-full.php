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
					<th colspan="2" class="center-th show_lost" style="display: none;">
						<div>
							Lost Cost
						</div>
					</th>
				</tr>
				<tr>
					<td style="width:20px;">Taken</td>
					<td style="width:20px;">In Hand</td>
					<td style="width:20px;">
						<span class="show_return">Return</span>
						<span class="show_lost" style="display: none;">Lost</span>
					</td>
					<td style="display: none;" class="show_lost">
						<span>Per Unit</span>
					</td>	
					<td style="display: none;" class="show_lost">
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
					<td class="show_lost" style="display: none;width:75px;">
						<div class="align-txt">
							<input type="text" name="lost_per_unit" class="lost_per_unit" value="<?php echo $g_value->buying_price; ?>" style="border-color: rgba(118, 118, 118, 0);height:34px;margin:0;width:75px;">
						</div>
					</td>
					<td class="show_lost" style="display: none;">
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
				<tr class="show_row_return">
					<td colspan="2">
						<div class="align-txt">
							<div style="float:left;width:150px;line-height: 15px;">Vehicle Number : </div>
							<div><input type="text" class="vehicle_number" style="border: 0;border-bottom: 2px dotted;padding: 0" value="<?php echo (isset($return_detail->vehicle_number)) ? $return_detail->vehicle_number : ''; ?>"></div>
						</div>
					</td>
					<td colspan="2" style=""><div class="align-txt"><div class="return-charge-txt">Unloading</div></div></td>
					<td colspan="3"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text"  class="return-charge-input unloading" value="<?php echo getUnloadingData($_GET['return_id'], 'unloading') ?>"></div></div></td>
				</tr>
				<tr class="show_row_return">
					<td colspan="2">
						<div class="align-txt">
							<div style="float:left;width:150px;line-height: 15px;">Driver Name : </div>
							<div>
								<input type="text" class="driver_name" style="border: 0;border-bottom: 2px dotted;padding: 0" value="<?php echo (isset($return_detail->driver_name)) ? $return_detail->driver_name : ''; ?>">
							</div>
						</div>
					</td>
					<td colspan="2" style=""><div class="align-txt"><div class="return-charge-txt">Transportation</div></div></td>
					<td colspan="3">
						<div class="align-txt">
							<div class="return-charge-val">Rs. 
								<input type="text"  class="return-charge-input transportation" value="<?php echo getUnloadingData($_GET['return_id'], 'transportation') ?>">
							</div>
						</div>
					</td>
				</tr>
				<tr class="show_row_return">
					<td colspan="2">
						<div class="align-txt">
							<div style="float:left;width:150px;line-height: 15px;">Mobile Number : </div>
							<div>
								<input type="text" class="driver_mobile" style="border: 0;border-bottom: 2px dotted;padding: 0" value="<?php echo (isset($return_detail->driver_mobile)) ? $return_detail->driver_mobile : ''; ?>">
							</div>
						</div>
					</td>
					<td colspan="2" style=""><div class="align-txt"><div class="return-charge-txt">Damage (as Per detail overleaf)</div></div></td>
					<td colspan="3">
						<div class="align-txt">
							<div class="return-charge-val">Rs. 
								<input type="text"  class="return-charge-input damage" value="<?php echo getUnloadingData($_GET['return_id'], 'damage') ?>" readonly="readonly">
							</div>
						</div>
					</td>
				</tr>
				<tr class="show_row_return">
					<td colspan="2"><div class="align-txt"></div></td>
					<td colspan="2" style="">
						<div class="align-txt"><div class="return-charge-txt">Total</div></div>
					</td>
					<td colspan="3">
						<div class="align-txt">
							<div class="return-charge-val">Rs. 
								<input type="text"  class="return-charge-input total" value="<?php echo getUnloadingData($_GET['return_id'], 'total') ?>">
							</div>
						</div>
					</td>
				</tr>
				<tr class="show_row_lost" style="display: none;">
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






<?php
	if(isset($damage_data['damage_detail'])) {
?>


	<div class="deposit-repeater1 damage_detail" style="margin-top:20px;">
		<h2>Damage Detailsssss</h2>
		<table class="table table-bordered" data-repeater-list="damage_detail">
			<thead>
				<tr>
					<th class="center-th" style="width:50px;"><div>S.No</div></th>
					<th>
						<div>Damage Detail</div>
					</th>
					<th style="width:100px;">
						<div>Amt</div>
					</th>
					<th style="width:50px;">
						<div>Action</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if(count($damage_data['damage_detail']) > 0) {
						$i = 1;
						foreach ($damage_data['damage_detail'] as $d_value) {
				?>
				<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row">
					<td>
						<div class="rowno align-txt">1</div>
					</td>
					<td>
						<div class="align-txt">
							<textarea name="damage_text" style="width: 100%;height: 38px;padding: 5px;" placeholder="Damage Details here"><?php echo $d_value->damage_detail; ?></textarea>
						</div>
					</td>
					<td>
						<div class="align-txt">
							<input type="text" name="damage_charge" value="<?php echo $d_value->damage_charge; ?>" style="width:70px;" class="damage_charge">
						</div>
					</td>
					<td>
						<div class="">
							<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
							<input type="hidden" value="Delete">
						</div>
					</td>
				</tr>
				<?php
						}
					} else {
				?>
				<tr data-repeater-item class="repeterin div-table-row" class="repeterin div-table-row">
					<td>
						<div class="rowno align-txt">1</div>
					</td>
					<td>
						<div class="align-txt">
							<textarea name="damage_text" style="width: 100%;height: 38px;padding: 5px;" placeholder="Damage Details here"></textarea>
						</div>
					</td>
					<td>
						<div class="align-txt">
							<input type="text" name="damage_charge" value="0.00" style="width:70px;" class="damage_charge">
						</div>
					</td>
					<td>
						<div class="">
							<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
							<input type="hidden" value="Delete">
						</div>
					</td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>

		<ul class="icons-labeled">
			<li><a data-repeater-create href="javascript:void(0);" id="add_new_price_range"><span class="icon-block-color add-c"></span>Add Damage</a></li>
		</ul>
	</div>
<?php
}
?>




	<div style="float:right;">
      	<?php 
      		if($master_data) {
      			echo "<input type='hidden' name='master_id' class='master_id_input' value='".$master_data['master_data']->id."'>";
				echo "<button type='submit' class='btn btn-success create_return'>Update Return</button>";
      			echo "<input type='hidden' name='return_id' value='".$return_data['return_data']->id."'>";
				echo "<input type='hidden' name='action' class='action' value='update_return'>";
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
				<tr>
					<td colspan="3">
						<div class="align-txt">
							<div style="float:left;width:150px;line-height: 15px;">Vehicle Number : </div>
							<div><input type="text" class="group_vehicle_number" name="vehicle_number" style="border: 0;border-bottom: 2px dotted;padding: 0;" value="<?php echo (isset($return_detail->vehicle_number)) ? $return_detail->vehicle_number : ''; ?>"></div>
						</div>
					</td>
					<td colspan="2" style="width:300px;">
						<div class="align-txt"><div class="return-charge-txt">Unloading</div></div>
					</td>
					<td colspan="3">
						<div class="align-txt"><div class="return-charge-val">Rs. <input type="text" name="unloading" class="return-charge-input group_unloading" value="<?php echo getUnloadingData($_GET['return_id'], 'unloading') ?>"></div></div>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<div class="align-txt">
							<div style="float:left;width:150px;line-height: 15px;">Driver Name : </div>
							<div><input type="text" class="group_driver_name" name="driver_name" style="border: 0;border-bottom: 2px dotted;padding: 0;" value="<?php echo (isset($return_detail->driver_name)) ? $return_detail->driver_name : ''; ?>"></div>
						</div>
					</td>
					<td colspan="2" style="width:300px;"><div class="align-txt"><div class="return-charge-txt">Transportation</div></div></td>
					<td colspan="3"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text" name="transportation" class="return-charge-input group_transportation" value="<?php echo getUnloadingData($_GET['return_id'], 'transportation') ?>"></div></div></td>
				</tr>
				<tr>
					<td colspan="3">
						<div class="align-txt">
							<div style="float:left;width:150px;line-height: 15px;">Mobile Number : </div>
							<div><input type="text" class="group_driver_mobile" name="driver_mobile" style="border: 0;border-bottom: 2px dotted;padding: 0;" value="<?php echo (isset($return_detail->driver_mobile)) ? $return_detail->driver_mobile : ''; ?>"></div>
						</div>
					</td>
					<td colspan="2" style="width:300px;"><div class="align-txt"><div class="return-charge-txt">Damage (as Per detail overleaf)</div></div></td>
					<td colspan="3"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text" name="damage" class="return-charge-input group_damage" value="<?php echo getUnloadingData($_GET['return_id'], 'damage') ?>"></div></div></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="2"><div class="align-txt"><div class="return-charge-txt">Total</div></div></td>
					<td colspan="3"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text" name="total" class="return-charge-input group_total" value="<?php echo getUnloadingData($_GET['return_id'], 'total') ?>"></div></div></td>
				</tr>
			</tbody>
		</table>
	</div>

</div>