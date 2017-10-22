jQuery(document).ready(function () {


    jQuery("#lot_number").select2({
        allowClear: true,
        width: '100%',
        multiple: false,
        minimumInputLength: 1,
        ajax: {
        type: 'POST',
        url: frontendajax.ajaxurl,
        delay: 250,
        dataType: 'json',
            data: function(params) {
                return {
                    action: 'search_lot', // search term
                    page: 1,
                    search_key: params.term,
                };
            },
            processResults: function(data) {
                console.log(data);
                var results = [];
                return {
                    results: jQuery.map(data.items, function(obj) {
                        return { id: obj.id, lot_no:obj.lot_no, product_name: obj.product_name, product_type:obj.product_type, unit_price:obj.unit_price };
                    })
                };
            },
            cache: true
        },
        initSelection: function (element, callback) {
            callback({ id: jQuery(element).val(), lot_no: jQuery(element).find(':selected').text() });
        },
        templateResult: formatStateStockCreate,
        templateSelection: formatStateStockCreate
    }).on("select2:select", function (e) { 
        jQuery('#product_name').val(e.params.data.product_name);
        jQuery('#product_type').val(e.params.data.product_type);
        jQuery('#unit_price').val(e.params.data.unit_price);
    });




    /*Add stock Form Submit*/
    jQuery("#add_stock").bind('submit', function (e) {
        jQuery('#lightbox').css('display','block');
        jQuery.ajax({
            type: "POST",
            dataType : "json",
            url: frontendajax.ajaxurl,
            data: {
                action : jQuery('.stock_action').val(),
                data : jQuery('#add_stock :input').serialize()
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




    /*Add stock Form Submit*/
    jQuery("#create_stock_closing").bind('submit', function (e) {
        jQuery('#lightbox').css('display','block');
        jQuery.ajax({
            type: "POST",
            dataType : "json",
            url: frontendajax.ajaxurl,
            data: {
                action : 'create_stock_closing',
                closing_date : jQuery('[name="stock_closing_to"]').val()
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



    jQuery('[name="stock_closing_to"]').on('change', function() {
        var stock_to = jQuery(this).val();
        jQuery('.previous_close_date').val('');
        jQuery('.stock_date_loader').css('display','block');
        jQuery.ajax({
            type: "POST",
            dataType : "json",
            url: frontendajax.ajaxurl,
            data: {
                action : 'getPreviousStockClosingdate',
                stock_to : stock_to
            },
            success: function (data) {
                jQuery('.previous_close_date').val(data.closing_date);
                jQuery('.stock_date_loader').css('display','none');
            }
        });
    })


});

function formatStateStockCreate (state) {
  if (!state.id) {
    return state.id;
  }
  var $state = jQuery(
    '<span>' +
      state.lot_no +
    '</span>'
  );
  return $state;
};

