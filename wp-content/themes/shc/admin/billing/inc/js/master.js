jQuery(document).ready(function () {

	//On click create deposit submit button
	jQuery('.create_master').on('click', function(){
		jQuery('#lightbox').css('display','block');
		jQuery.ajax({
			type: "POST",
			dataType : "json",
			url: frontendajax.ajaxurl,
			data: {
				action : 'create_master',
				data : jQuery('#create_master :input').serialize(),
			},
			success: function (data) {
				clearPopup();
				jQuery('#lightbox').css('display','none');

				if(data.redirect != 0) { 
					setTimeout(function() {
						managePopupContent(data);
					}, 1000);
				}

				if(data.success == 0) {
					popItUp('Error', data.msg);
				} else {
					popItUp('Success', data.msg);
				}
			}
		});
	});


})