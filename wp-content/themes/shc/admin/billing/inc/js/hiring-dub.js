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
	})
})


function calculateHiringTotal() {
	var sub_tot = 0.00, ur_tot;
	jQuery('.row_hiring_amt').each(function(){
	    var ur_tot = parseFloat(jQuery(this).val())
	    ur_tot = (isNaN(ur_tot)) ? 0.00 : ur_tot;
	    sub_tot = sub_tot + ur_tot;

	    sub_tot = Math.round10(sub_tot.toFixed(3), -2);
	});

	jQuery('.sub_tot_txt').text(sub_tot);
	jQuery('.sub_tot_val').val(sub_tot);

	var gst_for = jQuery('.gst_for').val();
	var gst_total = calculateGst(gst_for, sub_tot);

	var gst_include = parseFloat(sub_tot) + parseFloat(gst_total);
	jQuery('.gst_include_total_txt').text( gst_include );
	jQuery('.gst_include_total').val( gst_include );

	var round_off = parseFloat(jQuery('.round_off').val());

	var final_total = (gst_include - round_off);

	jQuery('.hiring_tot_txt').text(final_total);
	jQuery('.hiring_tot_val').val(final_total);
}

function calculateGst(gst_for = '', sub_tot = 0) { 
	if(gst_for == 'cgst') {
		var cgst = parseFloat(( sub_tot * 9 / 100 ).toFixed(2));
		var sgst = parseFloat(( sub_tot * 9 / 100 ).toFixed(2));

		jQuery('.gst_cgst_txt').text(cgst);
		jQuery('.gst_cgst').val(cgst);
		jQuery('.gst_sgst_txt').text(sgst);
		jQuery('.gst_sgst').val(sgst);

		return (cgst + sgst);
	} else {
		var igst = parseFloat(( sub_tot * 18 / 100 ).toFixed(2));
		jQuery('.gst_igst_txt').text(igst);
		jQuery('.gst_igst').val(igst);
		return igst;
	}
}