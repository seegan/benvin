jQuery(document).ready(function () { 
	populate_site_select_search('old', 'return');




    jQuery('.deposit-date .return_date').on('change', function(){

      var return_date = jQuery(this).val();
      var return_url = admin_page.return;
      var master_id = '&id='+jQuery('.master_id_input').val();
      var bill_query = '&return_date='+return_date;

      var redirect_url = return_url + master_id + bill_query;
      window.location = redirect_url;

    });




	jQuery('.unloading, .transportation, .damage').on('change keyup', function(){
		calculateUnloadingCharge();
	});

	jQuery('.vehicle_number, .driver_name, .driver_mobile').on('change keyup', function(){
		var vehicle_number = jQuery('.vehicle_number').val();
		var driver_name = jQuery('.driver_name').val();
		var driver_mobile = jQuery('.driver_mobile').val();

		jQuery('.group_vehicle_number').val(vehicle_number);
		jQuery('.group_driver_name').val(driver_name);
		jQuery('.group_driver_mobile').val(driver_mobile);
	})


	jQuery('.return_detail_group .return_qty').on('change keyup', function(){
		var group_class = '.return_group_qty_'+jQuery(this).attr('data-lotid');
		//
		var return_tot = jQuery(this).val();

		jQuery(group_class).each(function(){
			var in_hand_total = jQuery(this).parent().parent().parent().find('.in_hand_group').val();
			
			return_tot = (parseInt(return_tot) - parseInt(in_hand_total));
			if(return_tot >= 0) {
				jQuery(this).val(in_hand_total);
			} else {
				var bal = parseInt(in_hand_total) + parseInt(return_tot); 
				if(bal > 0) {
					jQuery(this).val(bal);
				} else {
					jQuery(this).val(0);
				}
			}

		});
	});


	jQuery( ".show_hide_btn" ).click(function() {
		jQuery( ".show_hide_slide" ).slideToggle( "slow", function() {

		});
	});







});

function calculateUnloadingCharge() {
	var unloading = jQuery('.unloading').val();
	jQuery('.group_unloading').val(unloading).change();
	
	var transportation = jQuery('.transportation').val();
	jQuery('.group_transportation').val(transportation).change();

	var damage = jQuery('.damage').val();
	jQuery('.group_damage').val(damage).change();

	var total = 0.00;

	unloading = ( isInt(Number(unloading)) || isFloat(Number(unloading)) ) ? Number(unloading) : 0.00;
	transportation = ( isInt(Number(transportation)) || isFloat(Number(transportation)) ) ? Number(transportation) : 0.00;
	damage = ( isInt(Number(damage)) || isFloat(Number(damage)) ) ? Number(damage) : 0.00;

	total = (unloading + transportation + damage);

	jQuery('.total').val(total).change();
	jQuery('.group_total').val(total).change();

}


