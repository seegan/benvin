jQuery(document).ready(function () {

  jQuery('.settings-repeater').repeater({
      defaultValues: {
        bill_from_comp : 1,
      },
      show: function () {
        var count = 1;
        jQuery('.settings-repeater .repeterin').each(function(){
          jQuery(this).find('.rowno').text(count);
          count++;
        });
        jQuery(this).slideDown();
      },
      hide: function (deleteElement) {
          if(confirm('Are you sure you want to delete this element?')) {
            jQuery(this).slideUp(deleteElement);
            var count = 1;
            jQuery('.settings-repeater .repeterin').each(function(){ 
              jQuery(this).find('.rowno').text(count);
              count++;
            })
          }
      },
      ready: function (setIndexes) {
      }
  });


  /*Add Lot Form Submit*/
  jQuery("#create_bank").bind('submit', function (e) {
      jQuery('#lightbox').css('display','block');
      jQuery.ajax({
          type: "POST",
          dataType : "json",
          url: frontendajax.ajaxurl,
          data: {
              action : jQuery('.bank_action').val(),
              data : jQuery('#create_bank :input').serialize()
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
      e.preventDefault();
      return false;
  });

})