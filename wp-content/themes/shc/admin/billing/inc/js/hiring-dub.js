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
})


function calculateHiringTotal() {
	var tot = 0.00, ur_tot;
	jQuery('.row_hiring_amt').each(function(){
	    var ur_tot = parseFloat(jQuery(this).val())
	    ur_tot = (isNaN(ur_tot)) ? 0.00 : ur_tot;
	    tot = tot + ur_tot;

	    tot = Math.round10(tot.toFixed(3), -2);
	});

	jQuery('.hiring_tot_txt').text(tot);
	jQuery('.hiring_tot_val').val(tot);
}