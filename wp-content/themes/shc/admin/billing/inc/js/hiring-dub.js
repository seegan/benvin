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
	jQuery('.row_hiring_amt').each(function(){
	    var ur_tot = parseFloat(jQuery(this).val())
	    ur_tot = (isNaN(ur_tot)) ? 0.00 : ur_tot;
	    sub_tot = sub_tot + ur_tot;
	    sub_tot = Math.round10(sub_tot.toFixed(3), -2);
	});

	sub_tot = sub_tot.toFixed(2);

	jQuery('.sub_tot_txt').text(sub_tot);
	jQuery('.sub_tot_val').val(sub_tot);

	var discount = getDiscountPrice(sub_tot);

	jQuery('.discount_txt').text(discount);
	jQuery('.discount_amt').val(discount);

	var total_after_discount = (parseFloat(sub_tot) - parseFloat(discount) );
	total_after_discount = Math.round10(total_after_discount.toFixed(3), -2);
	total_after_discount = total_after_discount.toFixed(2);
	jQuery('.after_discount_txt').text(total_after_discount);
	jQuery('.after_discount_amt').val(total_after_discount);

	
	var tax = getTaxPrice(total_after_discount);
	var tax_include = parseFloat(total_after_discount) + parseFloat(tax);
	tax_include = Math.round10(tax_include.toFixed(3), -2);
	tax_include = tax_include.toFixed(2);
	jQuery('.total_include_tax_txt').text( tax_include );
	jQuery('.total_include_tax_amt').val( tax_include );

	var round_off = parseFloat(jQuery('.round_off').val());
	round_off = Math.round10(round_off.toFixed(3), -2);

	var final_total = (tax_include - round_off);
	final_total = Math.round10(final_total.toFixed(3), -2);
	final_total = final_total.toFixed(2);

	jQuery('.hiring_tot_txt').text(final_total);
	jQuery('.hiring_tot_val').val(final_total);

}

function getTaxPrice(sub_tot = 0) {

	var tax_from = jQuery('.tax_from:checked').val();
	var tax_total = 0.00;
	tax_total = tax_total.toFixed(2);

	jQuery('.gst_cgst_txt').text(tax_total);
	jQuery('.gst_cgst').val(tax_total);
	jQuery('.gst_sgst_txt').text(tax_total);
	jQuery('.gst_sgst').val(tax_total);
	jQuery('.gst_igst_txt').text(tax_total);
	jQuery('.gst_igst').val(tax_total);

	jQuery('.vat_amt_txt').text(tax_total);
	jQuery('.vat_amt').val(tax_total);


	if(tax_from == 'gst') {
		var gst_for = jQuery('.gst_for').val();
		tax_total = calculateGst(gst_for, sub_tot);
	}
	if(tax_from == 'vat') {
		tax_total = ( parseFloat(sub_tot) * 5 ) / 100;
		tax_total = Math.round10(tax_total.toFixed(3), -2);

		jQuery('.vat_amt_txt').text(tax_total);
		jQuery('.vat_amt').val(tax_total);
	}
	if(tax_from == 'no_tax') {
		tax_total = parseFloat(0.00);
	}
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


function calculateGst(gst_for = '', sub_tot = 0) { 
	if(gst_for == 'cgst') {
		var cgst = parseFloat(( sub_tot * 9 / 100 ).toFixed(2));
		var sgst = parseFloat(( sub_tot * 9 / 100 ).toFixed(2));

		jQuery('.gst_cgst_txt').text(cgst);
		jQuery('.gst_cgst').val(cgst);
		jQuery('.gst_sgst_txt').text(sgst);
		jQuery('.gst_sgst').val(sgst);

    	return (parseFloat(cgst) + parseFloat(sgst));
	} else {
		var igst = parseFloat(( sub_tot * 18 / 100 ).toFixed(2));
		jQuery('.gst_igst_txt').text(igst);
		jQuery('.gst_igst').val(igst);
		return igst;
	}
}