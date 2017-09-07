jQuery(document).ready(function(){

  populate_customer_select('old');
  populate_site_select('old');


  /*populate_select2()*/
  jQuery('.deposit-repeater').repeater({
      defaultValues: {
        qty : 1,
        sale_detail_id : 0,
        lot_id_orig : 0,
        unit_price : 0.00,
        thirty_rs_price : 0.00,
        ninety_rs_price : 0.00,
      },
      show: function () {

        if(jQuery(this).data('reptype') == 'site_address') {
          var count = 1;
          jQuery('.site_address .repeterin').each(function(){
            jQuery(this).find('.rowno').text(count);
            count++;
          });
        } else if(jQuery(this).data('reptype') == 'special_price') {
          var count = 1;
          jQuery('.special_price .repeterin').each(function(){
            jQuery(this).find('.rowno').text(count);
            count++;
          });
        } else {
          var count = 1;
          jQuery('.deposit-repeater .repeterin').each(function(){
            jQuery(this).find('.rowno').text(count);
            count++;
          });
        }


        populate_select2(this, 'new');
        jQuery(this).slideDown();

        jQuery(this).find('.unit_price_txt').text('0.00');
        jQuery(this).find('.t_rs_txt').text('0');
        jQuery(this).find('.t_ps_txt').text('00');
        jQuery(this).find('.n_rs_txt').text('0');
        jQuery(this).find('.n_ps_txt').text('00');
      },
      hide: function (deleteElement) {
          if(confirm('Are you sure you want to delete this element?')) {
            jQuery(this).slideUp(deleteElement);
            var count = 1;
            jQuery('.deposit-repeater .repeterin').each(function(){ 
              jQuery(this).find('.rowno').text(count);
              count++;
            })
          }
      },
      ready: function (setIndexes) {
      }
  });


  //Populate default lot_id row select2
  jQuery('.repeterin').each(function(){
    populate_select2(jQuery(this), 'old')
  });
/*  processDepositFull();*/


  //On click create deposit submit button
  jQuery('.create_deposit').on('click', function(){
    jQuery('#lightbox').css('display','block');
    jQuery.ajax({
      type: "POST",
      dataType : "json",
      url: frontendajax.ajaxurl,
      data: {
          action : 'create_deposit',
          data : jQuery('#create_deposit :input').serialize(),
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



  jQuery('.open_deposit').on('click', function(){
    var master_id = jQuery(this).parent().find('.master_id').val();
    window.location = admin_page.deposit+'&id='+master_id;
  })


});




function populate_select2(this_data = '', v) {

  jQuery(this_data).find('.lot_id').select2({
      allowClear: false,
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
              action: ( jQuery('.lot_search_action').val() ) ? jQuery('.lot_search_action').val() : 'get_lot_data', // search term
              page: 1,
              search_key: params.term,
              customer_id: jQuery('.customer_id').val(),
              site_id : jQuery('.site_id').val(),
            };
          },
          processResults: function(data) {
            var results = [];
            return {
                results: jQuery.map(data.items, function(obj) {
                    return { id: obj.id, lot_number:obj.lot_no, product_name: obj.product_name, product_type:obj.product_type, unit_price:obj.unit_price};
                })
            };
          },
          cache: true
      },
    initSelection: function (element, callback) {
        if(v == 'old') {
          callback({ id: jQuery(element).attr('data-dvalue'), lot_number: jQuery(element).attr('data-dtext'), product_name: jQuery(element).attr('data-dname'), product_type: jQuery(element).attr('data-dtype') });
        } else {
          callback({ id: '', lot_number: '', product_name: '', product_type : '' });
        }
    },

      templateResult: formatState,
      templateSelection: formatState1
  }).on("select2:select", function (e) {
    var current_sel = jQuery(this).parent().parent();
    current_sel.find('.unit_price_txt').text(e.params.data.unit_price);
    current_sel.find('.unit_price').val(e.params.data.unit_price);
    current_sel.find('.lot_id_orig').val(e.params.data.id);

    processDepositRow(current_sel);
    processDepositFull();
  });

}


jQuery('.dpt_qty').live('change keyup', function () {
  var current_sel = jQuery(this).parent().parent();
  processDepositRow(current_sel);
  processDepositFull();
});

jQuery('.amt_times').live('change keyup', function(){
  jQuery('.deposit_detail .repeterin').each(function(){
    var current_sel = jQuery(this);
    processDepositRow(current_sel);
    processDepositFull();
  })
})

jQuery('input[name=discount_avail]').live('change', function(){

  var discount_avail = jQuery('input[name=discount_avail]:checked').val();
  if(discount_avail == 'yes') {
    jQuery('.discount_percentage_deposit').val(jQuery('.discount_yes').val()).change();
    jQuery('.discount_percentage_deposit').attr('readonly', false);
  } else {
    jQuery('.discount_percentage_deposit').val(jQuery('.discount_no').val()).change();
    jQuery('.discount_percentage_deposit').attr('readonly', true);
  }

})


jQuery('.discount_percentage_deposit').live('change keyup', function(){
  processDepositFull();
})


function formatState (state) {
  if (!state.id) {
    return state.id;
  }
  var $state = jQuery(
    '<span> Lot No: ' +
      state.lot_number +
    '</span> <br>'+
    '<span>' +
      state.product_name +' '+ state.product_type +'</span>'
  );
  return $state;
};

function formatState1(state) {
  if (!state.id) {
    return state.id;
  }
  var $state = jQuery(
    '<span>' +
      state.product_name +
    '</span>' +
    '<span>' +
      state.product_type +
    '</span>'
  );
  return $state;
}


function processDepositRow(selector = '') {
  var dpt_qty = parseFloat(selector.find('.dpt_qty').val());
  dpt_qty = (isNaN(dpt_qty)) ? 0.00 : dpt_qty;

  var unit_price = parseFloat(selector.find('.unit_price').val());
  var thirty_days_total, ninety_days_total;



  thirty_days_total = (dpt_qty * unit_price * 30);
  thirty_days_total = Math.round10(thirty_days_total.toFixed(3), -2);
  selector.find('.thirty_rs_price').val(thirty_days_total);


  ninety_days_total = (dpt_qty * unit_price * (30*jQuery('.amt_times').val()));
  ninety_days_total = Math.round10(ninety_days_total.toFixed(3), -2);

  selector.find('.ninety_rs_price').val(ninety_days_total);


  var t_str = (thirty_days_total).toFixed(2);
  var t_substr = t_str.toString().split('.');
  var thirty_rs = t_substr[0];
  var thirty_ps = t_substr[1];
  selector.find('.t_rs_txt').text(thirty_rs);
  selector.find('.t_ps_txt').text(thirty_ps);


  var n_str = (ninety_days_total).toFixed(2);
  var n_substr = n_str.toString().split('.');
  var ninety_rs = n_substr[0];
  var ninety_ps = n_substr[1];
  selector.find('.n_rs_txt').text(ninety_rs);
  selector.find('.n_ps_txt').text(ninety_ps);
}

function processDepositFull() {
  var t_total = 0.00, n_total = 0.00, thirty_days_total, ninety_days_total;
  jQuery('.deposit-repeater .repeterin').each(function() {

    var t_cur_tot = parseFloat(jQuery(this).find('.thirty_rs_price').val())
    t_cur_tot = (isNaN(t_cur_tot)) ? 0.00 : t_cur_tot;
    t_total = t_total + t_cur_tot;

    var n_cur_tot = parseFloat(jQuery(this).find('.ninety_rs_price').val())
    n_cur_tot = (isNaN(n_cur_tot)) ? 0.00 : n_cur_tot;
    n_total = n_total + n_cur_tot;
  });

  thirty_days_total = Math.round10(t_total.toFixed(3), -2);
  jQuery('.total_thirty_days').val(thirty_days_total);

  var t_str = (thirty_days_total).toFixed(2);
  var t_substr = t_str.toString().split('.');
  var thirty_rs = t_substr[0];
  var thirty_ps = t_substr[1];
  jQuery('.t_rs_tot_txt').text(thirty_rs);
  jQuery('.t_ps_tot_txt').text(thirty_ps);


  ninety_days_total = Math.round10(n_total.toFixed(3), -2);
  jQuery('.total_ninety_days').val(ninety_days_total);

  var n_str = (ninety_days_total).toFixed(2);
  var n_substr = n_str.toString().split('.');
  var ninety_rs = n_substr[0];
  var ninety_ps = n_substr[1];
  jQuery('.n_rs_tot_txt').text(ninety_rs);
  jQuery('.n_ps_tot_txt').text(ninety_ps);


  jQuery('.rupee-words').text( inWordsFull(n_str) );


  var discount_percentage = jQuery('.discount_percentage').val();
  var discount_amt = (ninety_days_total*discount_percentage) / 100;
  var discount_amt = Math.round10(discount_amt.toFixed(3), -2);
  jQuery('.discount_amt').val(discount_amt);

  var d_str = (discount_amt).toFixed(2);
  var d_substr = d_str.toString().split('.');
  var discount_rs = d_substr[0];
  var discount_ps = d_substr[1];
  jQuery('.rs_discount_txt').text(discount_rs);
  jQuery('.p_discount_txt').text(discount_ps);


  var final_total = parseFloat(ninety_days_total) + parseFloat(discount_amt);
  jQuery('.total').val(final_total)

  var ft_str = (final_total).toFixed(2);
  var ft_substr = ft_str.toString().split('.');
  var final_total_rs = ft_substr[0];
  var final_total_ps = ft_substr[1];
  jQuery('.rs_tot_txt').text(final_total_rs);
  jQuery('.ps_tot_txt').text(final_total_ps);

}




function populate_customer_select(v = 'new') {

  jQuery('.customer_name').select2({
      allowClear: true,
      triggerChange: true,
      placeholder: {
        id: "",
        placeholder: "Leave blank to ..."
      },      
      width: '50%',
      multiple: false,
      minimumInputLength: 1,
      ajax: {
          type: 'POST',
          url: frontendajax.ajaxurl,
          delay: 250,
          dataType: 'json',
          data: function(params) {
            return {
              action: 'get_customers', // search term
              page: 1,
              search_key: params.term,
            };
          },
          processResults: function(data) {
            var results = [];
            return {
                results: jQuery.map(data.items, function(obj) {
                    return { id: obj.id, name:obj.name, mobile: obj.mobile, address:obj.address, type:obj.type};
                })
            };
          },
          cache: true
      },
    initSelection: function (element, callback) {
        if(v == 'old') {
          callback({ id: jQuery(element).attr('data-dvalue'), name: jQuery(element).attr('data-name'), mobile: jQuery(element).attr('data-mobile'), address: jQuery(element).attr('data-address'), type : jQuery(element).attr('data-type') });
        } else {
          callback({ id: '', name: '', mobile: '', address : '', type: '' });
        }
    },

      templateResult: formatCustomerState,
      templateSelection: formatCustomerState1
  }).on("select2:select", function (e) {


  jQuery(".customer_name option[value!="+jQuery(this).val()+"]").remove()

    jQuery(".site_name").val(null).trigger("change");


    jQuery(this).parents('#create_master').find('.address-txt').text(e.params.data.address);
    jQuery(this).parents('#create_master').find('.customer_id').val(e.params.data.id);

  });

}

function populate_site_select(v = 'new') {

  jQuery('.site_name').select2({
      allowClear: true,
      placeholder: {
        id: "",
        placeholder: "Leave blank to ..."
      },
      width: '50%',
      multiple: false,
      minimumInputLength: 1,
      ajax: {
          type: 'POST',
          url: frontendajax.ajaxurl,
          delay: 250,
          dataType: 'json',
          data: function(params) {
            return {
              action: 'get_site_data', // search term
              page: 1,
              search_key: params.term,
              customer_id : jQuery('.customer_name').val()
            };
          },
          processResults: function(data) {
            var results = [];
            return {
                results: jQuery.map(data.items, function(obj) {
                    return { id: obj.site_id, name:obj.site_name, mobile: obj.phone_number, address:obj.site_address};
                })
            };
          },
          cache: true
      },
    initSelection: function (element, callback) {
        if(v == 'old') {
          callback({ id: jQuery(element).attr('data-dvalue'), name: jQuery(element).attr('data-name'), mobile: jQuery(element).attr('data-mobile'), address: jQuery(element).attr('data-address') });
        } else {
          callback({ id: '', name: '', mobile: '', address : '', type: '' });
        }
    },

      templateResult: formatCustomerState,
      templateSelection: formatCustomerSiteState1
  }).on("select2:select", function (e) {
    jQuery(this).parents('#create_master').find('.site-phone').text(e.params.data.mobile);
    jQuery(this).parents('#create_master').find('.site_id').val(e.params.data.id);


  });

}


function formatCustomerState (state) {
  if (!state.id) {
    return state.id;
  }
  var $state = jQuery(
    '<span> Customer Name: ' +
      state.name+
    '</span> <br>'+
    '<span> Address : '+
      state.address+'</span> <br>' +
    '<span> Phone : '+
      state.mobile+'</span>' 
  );
  return $state;
};

function formatCustomerState1(state) {
  if (!state.id) {
    return state.id;
  }
  var $state = jQuery(
    '<span>' +
      state.name+
    '</span>'
  );
  return $state;
}

function formatCustomerSiteState1(state) {
  if (!state.id) {
    return state.id;
  }
  var $state = jQuery(
    '<span>' +
      state.name +', '+ state.address+
    '</span>'
  );
  return $state;
}