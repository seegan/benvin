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

	jQuery('.damage_charge').live('change keyup', function(){
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


	jQuery('.return_detail_group .return_qty, .return_detail_group .lost_per_unit').on('change keyup', function(){
		var row_selector = jQuery(this).parent().parent().parent();

		var lost_per_unit = row_selector.find('.lost_per_unit').val();
		var return_tot = row_selector.find('.return_qty').val();

		var row_lost_tot = return_tot * lost_per_unit;
		row_lost_tot = Math.round10(row_lost_tot.toFixed(3), -2);

		row_selector.find('.lost_row_total').val(row_lost_tot).change();
		row_selector.find('.lost_row_total_txt').text(row_lost_tot);

		calculateHiringTotal();

	});



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


	jQuery('.return_status').on('change', function () {
		var return_status = jQuery(".return_status:checked").val();

		if(return_status == 'lost') {
			jQuery('.show_lost').css('display', 'table-cell');
			jQuery('.show_row_lost').css('display', 'table-row');
			jQuery('.show_return').css('display', 'none');
			jQuery('.show_row_return').css('display', 'none');


		} else {
			jQuery('.show_return').css('display', 'table-cell');
			jQuery('.show_row_return').css('display', 'table-row');
			jQuery('.show_lost').css('display', 'none');
			jQuery('.show_row_lost').css('display', 'none');
		}
	})




});


function calculateHiringTotal() {
	var sub_tot = 0.00, ur_tot;
	jQuery('.return_detail_group .return_qty').each(function(){
	    var ur_tot = parseFloat(jQuery(this).val())
	    ur_tot = (isNaN(ur_tot)) ? 0.00 : ur_tot;
	    sub_tot = sub_tot + ur_tot;

	    sub_tot = Math.round10(sub_tot.toFixed(3), -2);
	});


	var sub_tot1 = 0.00, ur_tot1;
	jQuery('.return_detail_group .lost_row_total').each(function(){
	    var ur_tot1 = parseFloat(jQuery(this).val())
	    ur_tot1 = (isNaN(ur_tot1)) ? 0.00 : ur_tot1;
	    sub_tot1 = sub_tot1 + ur_tot1;

	    sub_tot1 = Math.round10(sub_tot1.toFixed(3), -2);
	});

	jQuery('.lost_qty_total_txt').text(sub_tot);
	jQuery('.lost_qty_total').val(sub_tot);

	jQuery('.lost_total_txt').text(sub_tot1);
	jQuery('.lost_total').val(sub_tot1);
	
	console.log(sub_tot1);
}


function calculateUnloadingCharge() {
	var unloading = jQuery('.unloading').val();
	unloading = parseFloat(unloading);
	unloading = unloading.toFixed(2);

	jQuery('.group_unloading').val(unloading).change();
	
	var transportation = jQuery('.transportation').val();

	jQuery('.group_transportation').val(transportation).change();

	var damage = jQuery('.damage').val();
	jQuery('.group_damage').val(damage).change();

	var total = 0.00;

	unloading = ( isInt(Number(unloading)) || isFloat(Number(unloading)) ) ? Number(unloading) : 0.00;
	transportation = ( isInt(Number(transportation)) || isFloat(Number(transportation)) ) ? Number(transportation) : 0.00;
	//damage = ( isInt(Number(damage)) || isFloat(Number(damage)) ) ? Number(damage) : 0.00;
	damage = getDamageTotal();
	damage = damage.toFixed(2);
	jQuery('.damage').val(damage);

	total = ( parseFloat(unloading) + parseFloat(transportation) + parseFloat(damage) );
	total = Math.round10(total.toFixed(3), -2);
	total = total.toFixed(2);

	jQuery('.total').val(total).change();
	jQuery('.group_total').val(total).change();
}


function getDamageTotal() {
	var temp = 0.00;
	jQuery('.damage_charge').each(function(){
		var damage_tot = jQuery(this).val();
		temp = parseFloat(temp) + parseFloat(damage_tot);
	});
	temp = Math.round10(temp.toFixed(3), -2);
	return temp;
}