jQuery(document).ready(function () {

    /*Add Lot Form Submit*/
    jQuery("#create_lot").bind('submit', function (e) {
        jQuery('#lightbox').css('display','block');
        jQuery.ajax({
            type: "POST",
            dataType : "json",
            url: frontendajax.ajaxurl,
            data: {
                action : jQuery('.lot_action').val(),
                data : jQuery('#create_lot :input').serialize()
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
            

                /*setTimeout(function() {
                    managePopupContent(data);
                }, 4000);*/
            }
        });
        e.preventDefault();
        return false;
    });



});