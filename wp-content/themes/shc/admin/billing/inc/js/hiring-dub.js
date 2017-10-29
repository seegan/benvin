jQuery(document).ready(function () { 
	populate_site_select_search('old', 'hiring');
	calculateHiringTotal();


	jQuery('.bill_min_days').on('change', function(){
		var row_hiring = 0.00;
		if(jQuery(this).prop('checked')) {
			row_hiring = jQuery(this).parent().parent().parent().parent().find('.hiring_amt_min').val();
		} else {
			row_hiring = jQuery(this).parent().parent().parent().parent().find('.hiring_amt').val();
		}
		jQuery(this).parent().parent().parent().parent().find('.bill_amount_txt').text(row_hiring)
		jQuery(this).parent().parent().parent().parent().find('.row_hiring_amt').val(row_hiring)

		calculateHiringTotal();
	});

	jQuery('.round_off').on('change',function(){
		calculateHiringTotal();
	});




	jQuery('.tax_from').live('change', function(){
		var tax_from = jQuery('.tax_from:checked').val();

		jQuery('.tax_tr').css('display', 'none');
		jQuery('.vat_tr').css('display', 'none');
		jQuery('.gst_tr').css('display', 'none');

		console.log('dfsdf');

		if( tax_from == 'no_tax' ) {
			jQuery('.tax_tr').css('display', 'none');
		}
		if( tax_from == 'vat' ) {
			jQuery('.vat_tr, .tax_tr').css('display', 'table-row');
			jQuery('.gst_tr').css('display', 'none');
		}
		if( tax_from == 'gst' ) {
			jQuery('.gst_tr, .tax_tr').css('display', 'table-row');
			jQuery('.vat_tr').css('display', 'none');
		}

		calculateHiringTotal();
	});

	jQuery('.discount_percentage').on('change keyup', function(){
		calculateHiringTotal();
	});

	jQuery('.hiring_discount_avail').on('change', function(){
		var discount_avail = jQuery('input[name=hiring_discount_avail]:checked').val();
		if(discount_avail == 'yes') {
			jQuery('.discount_tr').css('display', 'table-row');
			jQuery('.discount_percentage').val(jQuery('.discount_yes').val()).change();
			jQuery('.discount_percentage').attr('readonly', false);
		} else {
			jQuery('.discount_tr').css('display', 'none');
			jQuery('.discount_percentage').val(jQuery('.discount_no').val()).change();
			jQuery('.discount_percentage').attr('readonly', true);
		}
	});



})


function calculateHiringTotal() {
	var sub_tot = 0.00, ur_tot;
	var tax_from = jQuery('.tax_from:checked').val();

	jQuery('.row_hiring_amt').each(function(){
	    var ur_tot = parseFloat(jQuery(this).val())
	    ur_tot = (isNaN(ur_tot)) ? 0.00 : ur_tot;
	    sub_tot = sub_tot + ur_tot;
	    sub_tot = Math.round10(sub_tot.toFixed(3), -2);
	});

	sub_tot = sub_tot.toFixed(2);

	jQuery('.sub_tot_txt').text(moneyFormatIndia(sub_tot));
	jQuery('.sub_tot_val').val(sub_tot);

	var discount = getDiscountPrice(sub_tot);

	jQuery('.discount_txt').text(moneyFormatIndia(discount));
	jQuery('.discount_amt').val(discount);

	var total_after_discount = (parseFloat(sub_tot) - parseFloat(discount) );
	total_after_discount = Math.round10(total_after_discount.toFixed(3), -2);
	total_after_discount = total_after_discount.toFixed(2);
	jQuery('.after_discount_txt').text(moneyFormatIndia(total_after_discount));
	jQuery('.after_discount_amt').val(total_after_discount);

	if(tax_from == 'gst') {
		var delivery_chrg = jQuery('.gst_transport_charges').val();
	} else {
		var delivery_chrg = jQuery('.vat_transport_charges').val();
	}
	delivery_chrg = parseFloat(delivery_chrg);
	delivery_chrg = delivery_chrg.toFixed(2);

	jQuery('.del_tot_txt').text(moneyFormatIndia(delivery_chrg));
	jQuery('.del_chrg_val').val(delivery_chrg);

	if( parseFloat(delivery_chrg) == 0 ) {
		jQuery('.delivery-tr').css('display', 'none');
	} else {
		jQuery('.delivery-tr').css('display', 'table-row');
	}

	var damage_chrg = jQuery('.dmg_chrg_val').val();
	if( parseFloat(damage_chrg) == 0) {
		jQuery('.damage-tr').css('display', 'none');
	}

	var lost_chrg = jQuery('.lost_chrg_val').val();
	if( parseFloat(lost_chrg) == 0 ) {
		jQuery('.lost-tr').css('display', 'none');
	}

	if(parseFloat(delivery_chrg) == 0 && parseFloat(damage_chrg) == 0 && parseFloat(lost_chrg) == 0) {
		jQuery('.before-tax-tr').css('display','none');
	}

	
	var tax = getTaxPrice(total_after_discount, delivery_chrg, damage_chrg, lost_chrg);

	var total_before_tax = parseFloat(total_after_discount) + parseFloat(delivery_chrg) + parseFloat(damage_chrg) + parseFloat(lost_chrg);
	total_before_tax = Math.round10(total_before_tax.toFixed(3), -2);
	total_before_tax = total_before_tax.toFixed(2);

	jQuery('.total_before_tax_amt').val(total_before_tax);
	jQuery('.total_before_tax_txt').text(moneyFormatIndia(total_before_tax));


	var tax_include = parseFloat(total_before_tax) + parseFloat(tax);
	tax_include = Math.round10(tax_include.toFixed(3), -2);
	tax_include = tax_include.toFixed(2);
	jQuery('.total_include_tax_txt').text( moneyFormatIndia(tax_include) );
	jQuery('.total_include_tax_amt').val( tax_include );

	var round_off = parseFloat(jQuery('.round_off').val());
	round_off = Math.round10(round_off.toFixed(3), -2);

	var final_total = (tax_include - round_off);
	final_total = Math.round10(final_total.toFixed(3), -2);
	final_total = final_total.toFixed(2);

	jQuery('.hiring_tot_txt').text( moneyFormatIndia(final_total));
	jQuery('.hiring_tot_val').val(final_total);

}

function getTaxPrice(sub_tot = 0, delivery_chrg=0, damage_chrg = 0, lost_chrg = 0) {

	var tax_from = jQuery('.tax_from:checked').val();
	var tax_total = 0.00;
	tax_total = tax_total.toFixed(2);

	jQuery('.gst_cgst_txt').text(moneyFormatIndia(tax_total));
	jQuery('.gst_cgst').val(tax_total);
	jQuery('.gst_sgst_txt').text(moneyFormatIndia(tax_total));
	jQuery('.gst_sgst').val(tax_total);
	jQuery('.gst_igst_txt').text(moneyFormatIndia(tax_total));
	jQuery('.gst_igst').val(tax_total);

	jQuery('.hire_charge_cgst').val(tax_total);
	jQuery('.hire_charge_sgst').val(tax_total);
	jQuery('.hire_charge_igst').val(tax_total);

	jQuery('.delivery_charge_cgst').val(tax_total);
	jQuery('.delivery_charge_sgst').val(tax_total);
	jQuery('.delivery_charge_igst').val(tax_total);

	jQuery('.damage_charge_cgst').val(tax_total);
	jQuery('.damage_charge_sgst').val(tax_total);
	jQuery('.damage_charge_igst').val(tax_total);

	jQuery('.lost_charge_cgst').val(tax_total);
	jQuery('.lost_charge_sgst').val(tax_total);
	jQuery('.lost_charge_igst').val(tax_total);

	jQuery('.vat_amt_txt').text(tax_total);
	jQuery('.vat_amt').val(tax_total);


	if(tax_from == 'gst') {
		var gst_for = jQuery('.gst_for').val();
		tax_total = calculateGst(gst_for, sub_tot, delivery_chrg, damage_chrg, lost_chrg);
	}
	if(tax_from == 'vat') {
		tax_total = ( parseFloat(sub_tot) * 5 ) / 100;
		tax_total = Math.round10(tax_total.toFixed(3), -2);

		jQuery('.vat_amt_txt').text(moneyFormatIndia(tax_total));
		jQuery('.vat_amt').val(tax_total);
	}
	if(tax_from == 'no_tax') {
		tax_total = parseFloat(0.00);
	}
	tax_total = parseFloat(tax_total);
	tax_total = Math.round10(tax_total.toFixed(3), -2);
	return tax_total;
}

function getDiscountPrice(sub_tot = 0) {
	var discount_percentage = jQuery('.discount_percentage').val();
	var discount_price = ( parseFloat(sub_tot) * parseFloat(discount_percentage) ) / 100;
	discount_price = Math.round10(discount_price.toFixed(3), -2);
	discount_price = discount_price.toFixed(2);
	return discount_price;
}


function calculateGst(gst_for = '', sub_tot = 0, delivery_chrg = 0, damage_chrg = 0, lost_chrg= 0) { 
	if(gst_for == 'cgst') {
		var subtot_cgst = parseFloat(( sub_tot * 9 / 100 ).toFixed(2));
		var subtot_sgst = parseFloat(( sub_tot * 9 / 100 ).toFixed(2));

		var delivery_chrg_cgst = parseFloat(( delivery_chrg * 9 / 100 ).toFixed(2));
		var delivery_chrg_sgst = parseFloat(( delivery_chrg * 9 / 100 ).toFixed(2));

		var damage_chrg_cgst = parseFloat(( damage_chrg * 9 / 100 ).toFixed(2));
		var damage_chrg_sgst = parseFloat(( damage_chrg * 9 / 100 ).toFixed(2));

		var lost_chrg_cgst = parseFloat(( lost_chrg * 9 / 100 ).toFixed(2));
		var lost_chrg_sgst = parseFloat(( lost_chrg * 9 / 100 ).toFixed(2));


		jQuery('.hire_charge_cgst').val(subtot_cgst);
		jQuery('.hire_charge_sgst').val(subtot_sgst);

		jQuery('.delivery_charge_cgst').val(delivery_chrg_cgst);
		jQuery('.delivery_charge_sgst').val(delivery_chrg_sgst);

		jQuery('.damage_charge_cgst').val(damage_chrg_cgst);
		jQuery('.damage_charge_sgst').val(damage_chrg_sgst);

		jQuery('.lost_charge_cgst').val(lost_chrg_cgst);
		jQuery('.lost_charge_sgst').val(lost_chrg_sgst);


		var cgst = (subtot_cgst + delivery_chrg_cgst + damage_chrg_cgst + lost_chrg_cgst);
		cgst = Math.round10(cgst.toFixed(3), -2);
		cgst = cgst.toFixed(2);

		var sgst = (subtot_sgst + delivery_chrg_sgst + damage_chrg_sgst + lost_chrg_sgst);
		sgst = Math.round10(sgst.toFixed(3), -2);
		sgst = sgst.toFixed(2);


		jQuery('.gst_cgst_txt').text(moneyFormatIndia(cgst));
		jQuery('.gst_cgst').val(cgst);
		jQuery('.gst_sgst_txt').text(moneyFormatIndia(sgst));
		jQuery('.gst_sgst').val(sgst);

    	return (parseFloat(cgst) + parseFloat(sgst));
	} else {
		var subtot_igst = parseFloat(( sub_tot * 18 / 100 ).toFixed(2));
		var delivery_chrg_igst = parseFloat(( delivery_chrg * 18 / 100 ).toFixed(2));
		var damage_chrg_igst = parseFloat(( damage_chrg * 18 / 100 ).toFixed(2));
		var lost_chrg_igst = parseFloat(( lost_chrg * 18 / 100 ).toFixed(2));

		jQuery('.hire_charge_igst').val(subtot_igst);
		jQuery('.delivery_charge_igst').val(delivery_chrg_igst);
		jQuery('.damage_charge_igst').val(damage_chrg_igst);
		jQuery('.lost_charge_igst').val(lost_chrg_igst);

		var igst = (subtot_igst + delivery_chrg_igst + damage_chrg_igst + lost_chrg_igst);

		jQuery('.gst_igst_txt').text(moneyFormatIndia(igst));
		jQuery('.gst_igst').val(igst);
		return igst;
	}
}