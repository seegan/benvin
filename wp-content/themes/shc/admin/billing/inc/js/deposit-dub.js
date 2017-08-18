jQuery(document).ready(function () { 
	populate_site_select_search('old', 'deposit');


	jQuery('.loading, .transportation').on('change keyup', function(){
		calculateloadingCharge();
	});


});



function calculateloadingCharge() {

	var loading = jQuery('.loading').val();
	var transportation = jQuery('.transportation').val();

	var total = 0.00;

	loading = ( isInt(Number(loading)) || isFloat(Number(loading)) ) ? Number(loading) : 0.00;
	transportation = ( isInt(Number(transportation)) || isFloat(Number(transportation)) ) ? Number(transportation) : 0.00;

	total = (loading + transportation );

	jQuery('.loading_total').val(total).change();

}