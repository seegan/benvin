			<tr>
				<td>
					<div class="inner-container" style="margin-top: 0px;">
						<div class="bill-detail">
							<table class="table table-bordered" style="margin-bottom: 2px;">
								<thead>
									<tr>
										<th colspan="3">
											<div style="min-height: 100px;padding:5px;">
												<div style="line-height:10px;">
													To: 
												</div>
												<div style="margin-left:55px;line-height:10px;width:230px;">
													<?php
														echo $customer_detail->name;
													?>
												</div>
												<div style="margin-left:55px;margin-top:5px;width:230px;">
													<?php
														echo $customer_detail->address;
													?>
												</div>
												<?php 
													if($site_detail->gst_number && $site_detail->gst_number != '') {
												?>
													<div>
														<div style="width:50px;line-height:10px;margin-top:7px;float:left;">
															GSTIN: 
														</div>
														<div style="margin-left:5px;margin-top:5px;float:left;">
															<?php
																echo $site_detail->gst_number;
															?>
														</div>
														<div style="clear:both;"></div>
													</div>
												<?php
													} 
												?>
											</div>
										</th>
										<th colspan="3">
											<div style="min-height: 100px;padding:5px;">
												<div>
													<div style="line-height: 18px;height: 18px;">
														<div style="float:left;">
															<?php echo $bill_number['bill_no']; ?>
														</div>
														<div class="clear"></div>
													</div>
													<div style="line-height: 18px;height: 18px;">
														<div style="float:left;width: 60px">DATE</div>
														<div style="float:left;">
															: <?php echo date('d-m-Y', strtotime($quotation_data->quotation_date)); ?>
														</div>
														<div class="clear"></div>
													</div>
													<?php
													if( $customer_detail->attn_name && $customer_detail->attn_name != '') {
													?>
													<div style="line-height: 18px;height: 18px;">
														<div style="float:left;width: 60px">Kind Attn. </div>
														<div style="float:left;">
															: <?php echo $customer_detail->attn_name; ?>
														</div>
														<div class="clear"></div>
													</div>
													<?php
													}
													if( $customer_detail->customer_email && $customer_detail->customer_email != '') {
													?>
													<div style="line-height: 18px;height: 18px;">
														<div style="float:left;width: 60px">Email </div>
														<div style="float:left;">
															: <?php echo $customer_detail->customer_email; ?>
														</div>
														<div class="clear"></div>
													</div>
													<?php
													}
													?>

													<div class="clear"></div>
													<div style="line-height: 18px;height: 18px;">
														<div style="float:left;width: 60px">SITE</div>
														<div style="float:left;float: left;height: 30px;width: 190px;">
															: <?php echo $site_detail->site_name; ?>
														</div>
														<div class="clear"></div>
													</div>
													<div class="clear"></div>
												</div>
											</div>
										</th>
									</tr>
									<tr>
										<th class="center-th" style="width: 50px;" rowspan="2">
											<div class="text-center">S.No</div>
										</th>
										<th class="center-th" style="" rowspan="2">
											<div class="text-center">Description</div>
										</th>
										<th class="center-th" style="width: 50px;" rowspan="2">
											<div class="text-center">Qty</div>
										</th>
										<th class="center-th" style="width: 50px;" rowspan="2">
											<div class="text-center">UOM</div>
										</th>
										<th class="center-th" style="padding: 0;">
											<div class="text-center">Rate / 30 Days</div>
										</th>
										<th class="center-th" style="padding: 0;width: 100px;">
											<div class="text-center">Hiring Charges For 30 Days</div>
										</th>
									</tr>
								</thead>	
								<?php
								foreach ($pieces[$i] as $key => $value) {
									$data_thirty = splitCurrency($value->rate_thirty);
									$data_ninety = splitCurrency($value->rate_ninety);
								?>
									<tr class="<?php echo $tr_class; ?>">
										<td>
											<div class="text-center">
												<?php echo $page_start ?>
											</div>
										</td>
										<td>
											<?php echo $value->product_name; ?>
											<span style="text-align: left;"><?php echo $value->product_type; ?></span>
										</td>
										<td>
											<div class="text-center">
												<?php echo $value->qty; ?>
											</div>
										</td>
										<td>
											<div class="text-center">
												Nos
											</div>
										</td>
										<td>
											<div class="text-rigth">
												<?php echo moneyFormatIndia($value->rate_thirty); ?>
											</div>
										</td>
										<td>
											<div class="text-rigth">
												<?php echo moneyFormatIndia($value->rate_ninety); ?>
											</div>
										</td>
									</tr>

									<?php
										$page_start++;
									}
									if($pages == $current_page) {
									?>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td colspan="5"><div class="text-center">Total </div></td>
										<td>
											<div class="text-rigth">
												<?php echo moneyFormatIndia($quotation_data->sub_total); ?>
											</div>
										</td>
									</tr>
									<?php
									if($quotation_data->discount_avail != 'no' && $quotation_data->discount_amt != 0) {
									?>
									<tr>
										<td colspan="5"><div class="text-center">Discount <?php echo $quotation_data->discount_percentage."%" ?></div></td>
										<td>
											<div class="text-right">
												<?php echo moneyFormatIndia($quotation_data->discount_amt); ?>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="5"><div class="text-center">Total After Discount</div></td>
										<td>
											<div class="text-rigth">
												<?php echo moneyFormatIndia($quotation_data->after_discount_amt); ?>
											</div>
										</td>
									</tr>
									<?php
									}
									if( isset($quotation_data->transportation_charge) && $quotation_data->transportation_charge != 0 ) {
									?>
									<tr>
										<td colspan="5"><div class="text-center">Delivery Charges</div></td>
										<td>
											<div class="text-right">
												<?php echo moneyFormatIndia($quotation_data->transportation_charge); ?>
											</div>
										</td>
									</tr>
									<?php
									}
									if( isset($quotation_data->damage_charge) && $quotation_data->damage_charge != 0 ) {
									?>
									<tr>
										<td colspan="5"><div class="text-center">Cleaning and Maintanance Charges</div></td>
										<td>
											<div class="text-right">
												<?php echo moneyFormatIndia($quotation_data->damage_charge); ?>
											</div>
										</td>
									</tr>
									<?php
									}
									if( isset($quotation_data->lost_charge) && $quotation_data->lost_charge != 0 ) {
									?>
									<tr>
										<td colspan="5"><div class="text-center">Material Lost Charges</div></td>
										<td>
											<div class="text-right">
												<?php echo moneyFormatIndia($quotation_data->lost_charge); ?>
											</div>
										</td>
									</tr>
									<?php
									}
									if( isset($quotation_data->transportation_charge) && $quotation_data->transportation_charge != 0 && isset($quotation_data->transportation_charge) && $quotation_data->transportation_charge != 0 && isset($quotation_data->lost_charge) && $quotation_data->lost_charge != 0 ) {
									?>
										<tr class="lost-tr">
											<td colspan="5" >
												<div class="text-center">Total (Included Transport and Others)</div>
											</td>
											<td>
												<div class="text-right">
													<span><?php echo moneyFormatIndia($quotation_data->total_before_tax); ?></span>					
												</div>
											</td>
										</tr>
									<?php
									}

									if($quotation_data->tax_from != 'no_tax') {

										if($quotation_data->tax_from == 'gst') {

											if($quotation_data->gst_for == 'cgst') {

									?>
											<tr>
												<td colspan="5"><div class="text-center"><b>CGST - 9%</b></div></td>
												<td>
													<div class="text-rigth">
														<?php echo moneyFormatIndia($quotation_data->cgst_amt); ?>
													</div>
												</td>
											</tr>
											<tr>
												<td colspan="5"><div class="text-center"><b>SGST - 9%</b></div></td>
												<td>
													<div class="text-rigth">
														<?php echo moneyFormatIndia($quotation_data->sgst_amt); ?>
													</div>
												</td>
											</tr>
									<?php
											}
											if($quotation_data->gst_for == 'igst') {
									?>
											<tr>
												<td colspan="5"><div class="text-center"><b>IGST - 18%</b></div></td>
												<td>
													<div class="text-rigth">
														<?php echo moneyFormatIndia($quotation_data->igst_amt); ?>
													</div>
												</td>
											</tr>
									<?php
											}
										}
										if($quotation_data->tax_from == 'vat') {
										?>
											<tr>
												<td colspan="5"><div class="text-center"><b>VAT - 5%</b></div></td>
												<td>
													<div class="text-rigth">
														<?php echo moneyFormatIndia($quotation_data->vat_amt); ?>
													</div>
												</td>
											</tr>
										<?php
										}
										?>

										<tr>
											<td colspan="5"><div class="text-center">Total Hire Charges (30 Days)</div></td>
											<td>
												<div class="text-right">
													<?php echo moneyFormatIndia($quotation_data->tax_include_tot); ?>
												</div>
											</td>
										</tr>
									<?php
									}
									?>

									<tr>
										<td colspan="5"><div class="text-center">Round off</div></td>
										<td>
											<div class="text-right">
												<?php echo moneyFormatIndia($quotation_data->round_off); ?>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="5"><div class="text-center"><b>Total (Including GST)</b></div></td>
										<td>
											<div class="text-right">
												<?php echo moneyFormatIndia($quotation_data->for_thirty_days); ?>
											</div>
										</td>
									</tr>
									<?php 
										}
									?>
							</table>
						</div>
					</div>
				</td>
			</tr>