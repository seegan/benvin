<div class="return_detail_group" style="margin-top:20px;">
	<table class="table table-bordered" data-repeater-list="return_detail">
		<thead>
			<tr>
				<th rowspan="2" style="width:50px;" class="center-th"><div>S.No</div></th>
				<th rowspan="2" colspan="3" class="center-th" style="min-width: 200px;"><div>Description</div></th>
				<th rowspan="2" class="center-th" style="width:100px;">
					<div>Qty</div>
				</th>
				<th rowspan="2" style="width:50px;" class="center-th"><div>Action</div></th>
			</tr>
		</thead>
		<tbody>
		<?php


			if($group_items  && count($group_items) > 0) {
				$i = 1;
				foreach ($group_items as $g_value) {
		?>
			<tr class="div-table-row" data-repeater-item class="repeterin div-table-row" >
				<td>
					<div class="rowno align-txt"><?php echo $i; ?></div>
					<input type="hidden" class="lot_id" name="lot_id" value="<?php echo $g_value->lot_id; ?>">
				</td>
				<td colspan="3">
					<div class="align-txt">
						<span><?php echo $g_value->product_name ?></span>
						<span><?php echo $g_value->product_type ?></span>
					</div>
				</td>
				<td>
					<div class="align-txt">
						<input type="text" name="qty" style="border-color: rgba(118, 118, 118, 0);height:34px;margin:0;" class="return_qty" value="<?php echo $g_value->qty; ?>" >
					</div>
				</td>
				<td>
					<a href="#" data-repeater-delete="" style="font-size: 16px;font-weight: bold; color: #ff0000;line-height: 30px;">x</a>
					<input type="hidden" value="Delete">
				</td>
			</tr>
		<?php
					$i++;
				}
			}

		?>
			<tr>
				<td colspan="2">
					<div class="align-txt">
						<div style="float:left;width:150px; line-height: 15px;">Vehicle Number : </div>
						<div>
						<input type="text" style="border: 0;border-bottom: 2px dotted;padding: 0;" value="<?php echo (isset($return_detail->vehicle_number)) ? $return_detail->vehicle_number : ''; ?>"></div>
					</div>
				</td>
				<td colspan="2"><div class="align-txt"><div class="return-charge-txt">Unloading</div></div></td>
				<td colspan="2"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text" class="return-charge-input" value="<?php echo getUnloadingData($_GET['return_id'], 'unloading') ?>"></div></div></td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="align-txt">
						<div style="float:left;width:150px; line-height: 15px;">Driver Name : </div>
						<div>
							<input type="text" style="border: 0;border-bottom: 2px dotted;padding: 0;" value="<?php echo (isset($return_detail->driver_name)) ? $return_detail->driver_name : ''; ?>">
						</div>
					</div>
				</td>
				<td colspan="2"><div class="align-txt"><div class="return-charge-txt">Transportation</div></div></td>
				<td colspan="2"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text" class="return-charge-input" value="<?php echo getUnloadingData($_GET['return_id'], 'transportation') ?>"></div></div></td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="align-txt">
						<div style="float:left;width:150px; line-height: 15px;">Mobile Number : </div>
						<div>
							<input type="text" class="" style="border: 0;border-bottom: 2px dotted;padding: 0;" value="<?php echo (isset($return_detail->driver_mobile)) ? $return_detail->driver_mobile : ''; ?>">
						</div>
					</div>
				</td>
				<td colspan="2"><div class="align-txt"><div class="return-charge-txt">Damage (as Per detail overleaf)</div></div></td>
				<td colspan="2"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text" class="return-charge-input" value="<?php echo getUnloadingData($_GET['return_id'], 'damage') ?>"></div></div></td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td colspan="2"><div class="align-txt"><div class="return-charge-txt">Total</div></div></td>
				<td colspan="2"><div class="align-txt"><div class="return-charge-val">Rs. <input type="text" class="return-charge-input" value="<?php echo getUnloadingData($_GET['return_id'], 'total') ?>"></div></div></td>
			</tr>
		</tbody>
	</table>
</div>