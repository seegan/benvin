jQuery(document).ready(function(){



  //On click create delivery submit button
  jQuery('.create_return').on('click', function(){
    jQuery('#lightbox').css('display','block');
    jQuery.ajax({
      type: "POST",
      dataType : "json",
      url: frontendajax.ajaxurl,
      data: {
          action : 'create_return',
          data : jQuery('#create_return :input').serialize(),
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


  //On click create delivery submit button
  jQuery('.update_lost').on('click', function(){
    jQuery('#lightbox').css('display','block');
    jQuery.ajax({
      type: "POST",
      dataType : "json",
      url: frontendajax.ajaxurl,
      data: {
          action : 'update_lost',
          data : jQuery('#update_lost :input').serialize(),
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

});


