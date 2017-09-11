<div style="margin-top:20px;">
	<table class="table table-bordered" data-repeater-list="return_detail">
		<thead>
			<tr>
				<th rowspan="2" style="width:50px;" class="center-th"><div>S.No</div></th>
				<th rowspan="2" colspan="3" class="center-th" style="min-width: 200px;"><div>Description</div></th>
				<th rowspan="2" class="center-th" style="width:100px;">
					<div>Qty</div>
				</th>
				<th rowspan="2" class="center-th" style="width:100px;">
					<div>Lost Total</div>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if($lost_data['lost_detail']  && count($lost_data['lost_detail']) > 0) {
				$i = 1;
				foreach ($lost_data['lost_detail'] as $g_value) {
		?>
			<tr class="div-table-row" class="repeterin div-table-row" >
				<td>
					<div class="rowno align-txt"><?php echo $i; ?></div>
					<input type="hidden" class="lot_id" value="<?php echo $g_value->lot_id; ?>">
				</td>
				<td colspan="3">
					<div class="align-txt">
						<span><?php echo $g_value->product_name ?></span>
						<span><?php echo $g_value->product_type ?></span>
					</div>
				</td>
				<td>
					<div class="align-txt">
						<input type="text" style="border-color: rgba(118, 118, 118, 0);height:34px;margin:0;" class="return_qty" value="<?php echo $g_value->lost_qty; ?>" >
					</div>
				</td>
				<td>
					<div class="align-txt">
						<?php echo $g_value->lost_total; ?>
					</div>
				</td>
			</tr>
		<?php
					$i++;
				}
			}
		?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4">
					<div class="align-txt">
						<b>Total</b>
					</div>
				</td>
				<td>
					<div>
						<?php echo $lost_data['lost_data']->lost_qty; ?>
					</div>
				</td>
				<td>
					<div>
						<?php echo $lost_data['lost_data']->lost_total; ?>
					</div>
				</td>		
			</tr>
		</tfoot>
	</table>
</div>