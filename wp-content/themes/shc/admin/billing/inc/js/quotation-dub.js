jQuery(document).ready(function () {
  jQuery(".txtEditor1").richText();
  jQuery(".txtEditor2").richText();

	populate_site_select_search('old', 'quotation');


  jQuery('.round_off_rs, .round_off_ps').on('change',function(){
    processDepositFull();
  });



  jQuery('.tax_from').live('change', function(){
    var tax_from = jQuery('.tax_from:checked').val();

    jQuery('.tax_tr').css('display', 'none');
    jQuery('.vat_tr').css('display', 'none');
    jQuery('.gst_tr').css('display', 'none');

    if( tax_from == 'no_tax' ) {
      jQuery('.tax_tr').css('display', 'none');
    }
    if( tax_from == 'vat' ) {
      jQuery('.vat_tr, .tax_tr').css('display', 'table-row');
      jQuery('.gst_tr').css('display', 'none');
    }
    if( tax_from == 'gst' ) {
      jQuery('.gst_tr, .tax_tr').css('display', 'table-row');
      jQuery('.vat_tr').css('display', 'none');
    }

    processDepositFull();
  });

  jQuery('.discount_percentage').on('change keyup', function(){
    processDepositFull();
  });
  
  jQuery('.deposit_times').on('change keyup', function(){
    processDepositFull();
  });

  jQuery('.loading_weight, .price_per_ton, .loading_scope, .unloading_scope').on('change keyup', function(){
    var metric_ton = parseFloat(jQuery('.loading_weight').val());
    calculate_loading(metric_ton);
    calculateAmountPayable();
  });

  jQuery('.transport_charge, .transport_scope').on('change keyup', function(){
    var transport_scope = (jQuery('.transport_charge').val()) ? parseFloat(jQuery('.transport_charge').val()) : 0.00;
    calculate_transport(transport_scope);
    calculateAmountPayable();
  });
  jQuery('.return_transport_charge, .return_transport_scope').on('change keyup', function(){
    var return_transport_scope = (jQuery('.return_transport_charge').val()) ? parseFloat(jQuery('.return_transport_charge').val()) : 0.00;
    calculate_return_transport(return_transport_scope);
    calculateAmountPayable();
  });


  jQuery('.loading_scope, .loading_scope, .transport_scope, .return_transport_scope').on('click', function () {
    jQuery('li .loading_scope').change();
    jQuery('li .unloading_scope').change();
    jQuery('li .transport_scope').change();
    jQuery('li .return_transport_scope').change();
    calculateAmountPayable();
  });


  jQuery('.deposit_from').on('change', function () {
    processDepositFull();
  });




  jQuery('.company_bank').on('change', function () {
    jQuery('.bank_detail_span').text(jQuery(this).val()).change();
  });


  jQuery('.hiring_discount_avail').on('change', function(){
    var discount_avail = jQuery('input[name=hiring_discount_avail]:checked').val();
    if(discount_avail == 'yes') {
      jQuery('.discount_tr').css('display', 'table-row');
      jQuery('.discount_avail_no').css('display', 'none');
      jQuery('.discount_percentage').val(jQuery('.discount_yes').val()).change();
      jQuery('.discount_percentage').attr('readonly', false);
    } else {
      jQuery('.discount_tr').css('display', 'none');
      jQuery('.discount_avail_no').css('display', 'inline-block');
      jQuery('.discount_percentage').val(jQuery('.discount_no').val()).change();
      jQuery('.discount_percentage').attr('readonly', true);
    }
  });

});

function processDepositFull() {
  var n_total = 0.00, ninety_days_total, w_total = 0.00;
  jQuery('.deposit-repeater .repeterin').each(function() {

    var w_cur_tot = parseFloat(jQuery(this).find('.row_weight').val())
    w_cur_tot = (isNaN(w_cur_tot)) ? 0.00 : w_cur_tot;
    w_total = w_total + w_cur_tot;

    var n_cur_tot = parseFloat(jQuery(this).find('.ninety_rs_price').val())
    n_cur_tot = (isNaN(n_cur_tot)) ? 0.00 : n_cur_tot;
    n_total = n_total + n_cur_tot;
  });

  var metric_ton = (w_total * 0.001).toFixed(2);
  jQuery('.loading_weight').val(metric_ton);
  calculate_loading(metric_ton);

  var transport_scope = (jQuery('.transport_charge').val()) ? parseFloat(jQuery('.transport_charge').val()) : 0.00;
  calculate_transport(transport_scope);

  var return_transport_scope = (jQuery('.return_transport_charge').val()) ? parseFloat(jQuery('.return_transport_charge').val()) : 0.00;
  calculate_return_transport(return_transport_scope);


  ninety_days_total = Math.round10(n_total.toFixed(3), -2);
  jQuery('.total_ninety_days').val(ninety_days_total);

  var n_str = (ninety_days_total).toFixed(2);
  var n_substr = n_str.toString().split('.');
  var ninety_rs = n_substr[0];
  var ninety_ps = n_substr[1];
  jQuery('.n_rs_tot_txt').text(ninety_rs);
  jQuery('.n_ps_tot_txt').text(ninety_ps);



  var discount = getDiscountPrice(ninety_days_total);
  jQuery('.discount_amt').val(discount);

  var discount_sp = splitRupee(discount);
  jQuery('.discount_txt').text(discount_sp[0]);
  jQuery('.discount_txt_p').text(discount_sp[1]);



  var total_after_discount = (parseFloat(ninety_days_total) - parseFloat(discount) );
  total_after_discount = Math.round10(total_after_discount.toFixed(3), -2);
  total_after_discount = total_after_discount.toFixed(2);
  jQuery('.after_discount_amt').val(total_after_discount);

  var total_after_discount_sp = splitRupee(total_after_discount);
  jQuery('.after_discount_txt').text(total_after_discount_sp[0]);
  jQuery('.after_discount_txt_p').text(total_after_discount_sp[1]);
  
  var tax = getTaxPrice(total_after_discount);
  var tax_include = parseFloat(total_after_discount) + parseFloat(tax);
  tax_include = Math.round10(tax_include.toFixed(3), -2);
  tax_include = tax_include.toFixed(2);
  jQuery('.total_include_tax_amt').val( tax_include );

  var tax_include_sp = splitRupee(tax_include);
  jQuery('.total_include_tax_txt').text( tax_include_sp[0] );
  jQuery('.total_include_tax_txt_p').text( tax_include_sp[1] );

  var round_off = jQuery('.round_off_rs').val() +'.'+ jQuery('.round_off_ps').val()
  round_off = parseFloat(round_off);
  jQuery('.round_off').val(round_off);

  round_off = Math.round10(round_off.toFixed(3), -2);

  var final_total = parseFloat(tax_include) + parseFloat(round_off);
  final_total = Math.round10(final_total.toFixed(3), -2);
  final_total = final_total.toFixed(2);
  jQuery('.hiring_tot_val').val(final_total);




  var deposit_times = parseFloat(jQuery('.deposit_times').val());
  var security_from = ( jQuery('.deposit_from:checked').val() == 'h') ? total_after_discount : final_total;
  var security_amt = (security_from*deposit_times ).toFixed(2);

  jQuery('li .security_amt').text(moneyFormatIndia(security_amt)).change();
  jQuery('li .pdc_amt').text(moneyFormatIndia(final_total)).change();

  var final_total_sp = splitRupee(final_total);
  jQuery('.hiring_tot_txt').text(final_total_sp[0]);
  jQuery('.hiring_tot_txt_p').text(final_total_sp[1]);

  calculateAmountPayable();
}

function calculateAmountPayable() {
  var security_amt = jQuery('span.security_amt').text(); 
  security_amt = parseFloat(security_amt.replace(/[^0-9\.-]+/g,"")).toFixed(2);

  var loading_scope = jQuery('span.loading_scope').text();
  loading_scope = parseFloat(loading_scope.replace(/Rs\./,"").replace(/,/g ,'')); 
  loading_charge = isNaN(loading_scope) ? (0).toFixed(2) : loading_scope;

  var unloading_scope = jQuery('span.unloading_scope').text();
  unloading_scope = parseFloat(unloading_scope.replace(/Rs\./,"").replace(/,/g ,'')); 
  unloading_scope = isNaN(unloading_scope) ? (0).toFixed(2) : unloading_scope;

  var transport_scope = jQuery('span.transport_scope').text();
  transport_scope = parseFloat(transport_scope.replace(/Rs\./,"").replace(/,/g ,''));
  transport_charge = isNaN(transport_scope) ? (0).toFixed(2) : transport_scope;

  var return_transport_scope = jQuery('span.return_transport_scope').text();
  return_transport_scope = parseFloat(return_transport_scope.replace(/Rs\./,"").replace(/,/g ,''));
  return_transport_charge = isNaN(return_transport_scope) ? (0).toFixed(2) : return_transport_scope;

  var amount_payable = (parseFloat(security_amt)+parseFloat(loading_charge)+parseFloat(unloading_scope)+parseFloat(transport_charge)+parseFloat(return_transport_charge));

  jQuery('.amount_payable').val(amount_payable.toFixed(2));
}

function calculate_transport(transport_scope) {
  transport_scope = transport_scope.toFixed(2);
  transport_scope = 'Rs. '+moneyFormatIndia(transport_scope);
  if(jQuery('.transport_scope').is(':checked')) {
    transport_scope = 'Your Scope';
  }
  jQuery('li .transport_scope').text(transport_scope);
}
function calculate_return_transport(transport_scope) {
  transport_scope = transport_scope.toFixed(2);
  transport_scope = 'Rs. '+moneyFormatIndia(transport_scope);
  if(jQuery('.return_transport_scope').is(':checked')) {
    transport_scope = 'Your Scope';
  }
  jQuery('li .return_transport_scope').text(transport_scope);
}

function calculate_loading(metric_ton) {
  jQuery('li .mt_weight').text(metric_ton).change();
  var price_per_ton = parseFloat(jQuery('.price_per_ton').val());
  var loading_charge = price_per_ton*metric_ton;

  loading_charge = (Math.round10(loading_charge, -2)).toFixed(2);
  jQuery('.loading_charge').val(loading_charge);

  var loading_scope = 'Rs. '+moneyFormatIndia(loading_charge);
  var unloading_scope = 'Rs. '+moneyFormatIndia(loading_charge);
  if(jQuery('.loading_scope').is(':checked')) {
    loading_scope = 'Your Scope';
  }
  if(jQuery('.unloading_scope').is(':checked')) {
    unloading_scope = 'Your Scope';
  }

  jQuery('li .loading_scope').text(loading_scope);
  jQuery('li .unloading_scope').text(unloading_scope);
}


function getTaxPrice(sub_tot = 0) {

  var tax_from = jQuery('.tax_from:checked').val();
  var tax_total = 0.00;
  tax_total = tax_total.toFixed(2);

  jQuery('.gst_cgst_txt').text('0');
  jQuery('.gst_cgst_txt_p').text('00');
  jQuery('.gst_cgst').val(tax_total);

  jQuery('.gst_sgst_txt').text('0');
  jQuery('.gst_sgst_txt_p').text('00');
  jQuery('.gst_sgst').val(tax_total);

  jQuery('.gst_igst_txt').text('0');
  jQuery('.gst_igst_txt_p').text('00');
  jQuery('.gst_igst').val(tax_total);

  jQuery('.vat_amt_txt').text('0');
  jQuery('.vat_amt_txt_p').text('00');
  jQuery('.vat_amt').val(tax_total);





  if(tax_from == 'gst') {
    var gst_for = jQuery('.gst_for').val();
    tax_total = calculateGst(gst_for, sub_tot);
  }
  if(tax_from == 'vat') {
    tax_total = ( parseFloat(sub_tot) * 5 ) / 100;
    tax_total = tax_total.toFixed(3);
    tax_total = Math.round10(tax_total, -2);

    var tax_total_sp = splitRupee(tax_total);
    jQuery('.vat_amt_txt').text( tax_total_sp[0] );
    jQuery('.vat_amt_txt_p').text( tax_total_sp[1] );
    jQuery('.vat_amt').val(tax_total);

  }
  if(tax_from == 'no_tax') {
    tax_total = 0.00;
  }

  tax_total = tax_total.toFixed(3);  
  tax_total = Math.round10(tax_total, -2);
  return tax_total;
}

function getDiscountPrice(sub_tot = 0) {
  var discount_percentage = jQuery('.discount_percentage').val();
  var discount_price = ( parseFloat(sub_tot) * parseFloat(discount_percentage) ) / 100;
  discount_price = Math.round10(discount_price.toFixed(3), -2);
  discount_price = discount_price.toFixed(2);
  return discount_price;
}


function calculateGst(gst_for = '', sub_tot = 0) { 
  if(gst_for == 'cgst') {
    var cgst = parseFloat( sub_tot * 9 / 100 );
    var sgst = parseFloat( sub_tot * 9 / 100 );
    cgst = cgst.toFixed(2);
    sgst = sgst.toFixed(2);

    var cgst_sp = splitRupee(cgst);
    var sgst_sp = splitRupee(sgst);

    jQuery('.gst_cgst_txt').text(cgst_sp[0]);
    jQuery('.gst_cgst_txt_p').text(cgst_sp[1]);
    jQuery('.gst_cgst').val(cgst);

    jQuery('.gst_sgst_txt').text(sgst_sp[0]);
    jQuery('.gst_sgst_txt_p').text(sgst_sp[1]);
    jQuery('.gst_sgst').val(sgst);

    return (parseFloat(cgst) + parseFloat(sgst));
  } else {
    var igst = parseFloat( sub_tot * 18 / 100 );
    igst = igst.toFixed(2)

    var igst_sp = splitRupee(igst);

    jQuery('.gst_igst_txt').text(igst_sp[0]);
    jQuery('.gst_igst_txt_p').text(igst_sp[1]);
    jQuery('.gst_igst').val(igst);
    return parseFloat(igst);
  }
}










function processDepositRow(selector = '') {
  var weight = parseFloat(selector.find('.row_weight_unit').val());

  var dpt_qty = parseFloat(selector.find('.dpt_qty').val());
  dpt_qty = (isNaN(dpt_qty)) ? 0.00 : dpt_qty;

  var row_wight = dpt_qty*weight;
  selector.find('.row_weight').val(row_wight);
  selector.find('.weight').text(row_wight+' kg');

  var unit_price = parseFloat(selector.find('.unit_price').val());
  var thirty_days_total, ninety_days_total;


  //thirty_days_total = (dpt_qty * unit_price * 30);
  thirty_days_total = (1 * unit_price * 30);
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

















            function domo(){
                jQuery('#platform-details').html('<code>' + navigator.userAgent + '</code>');
                
/*                var elements = [
                    "esc","tab","space","return","backspace","scroll","capslock","numlock","insert","home","del","end","pageup","pagedown",
                    "left","up","right","down",
                    "f1","f2","f3","f4","f5","f6","f7","f8","f9","f10","f11","f12",
                    "1","2","3","4","5","6","7","8","9","0",
                    "a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
                    "Ctrl+a","Ctrl+b","Ctrl+c","Ctrl+d","Ctrl+e","Ctrl+f","Ctrl+g","Ctrl+h","Ctrl+i","Ctrl+j","Ctrl+k","Ctrl+l","Ctrl+m",
                    "Ctrl+n","Ctrl+o","Ctrl+p","Ctrl+q","Ctrl+r","Ctrl+s","Ctrl+t","Ctrl+u","Ctrl+v","Ctrl+w","Ctrl+x","Ctrl+y","Ctrl+z",
                    "Shift+a","Shift+b","Shift+c","Shift+d","Shift+e","Shift+f","Shift+g","Shift+h","Shift+i","Shift+j","Shift+k","Shift+l",
                    "Shift+m","Shift+n","Shift+o","Shift+p","Shift+q","Shift+r","Shift+s","Shift+t","Shift+u","Shift+v","Shift+w","Shift+x",
                    "Shift+y","Shift+z",
                    "Alt+a","Alt+b","Alt+c","Alt+d","Alt+e","Alt+f","Alt+g","Alt+h","Alt+i","Alt+j","Alt+k","Alt+l",
                    "Alt+m","Alt+n","Alt+o","Alt+p","Alt+q","Alt+r","Alt+s","Alt+t","Alt+u","Alt+v","Alt+w","Alt+x","Alt+y","Alt+z",
                    "Ctrl+esc","Ctrl+tab","Ctrl+space","Ctrl+return","Ctrl+backspace","Ctrl+scroll","Ctrl+capslock","Ctrl+numlock",
                    "Ctrl+insert","Ctrl+home","Ctrl+del","Ctrl+end","Ctrl+pageup","Ctrl+pagedown","Ctrl+left","Ctrl+up","Ctrl+right",
                    "Ctrl+down",
                    "Ctrl+f1","Ctrl+f2","Ctrl+f3","Ctrl+f4","Ctrl+f5","Ctrl+f6","Ctrl+f7","Ctrl+f8","Ctrl+f9","Ctrl+f10","Ctrl+f11","Ctrl+f12",
                    "Shift+esc","Shift+tab","Shift+space","Shift+return","Shift+backspace","Shift+scroll","Shift+capslock","Shift+numlock",
                    "Shift+insert","Shift+home","Shift+del","Shift+end","Shift+pageup","Shift+pagedown","Shift+left","Shift+up",
                    "Shift+right","Shift+down",
                    "Shift+f1","Shift+f2","Shift+f3","Shift+f4","Shift+f5","Shift+f6","Shift+f7","Shift+f8","Shift+f9","Shift+f10","Shift+f11","Shift+f12",
                    "Alt+esc","Alt+tab","Alt+space","Alt+return","Alt+backspace","Alt+scroll","Alt+capslock","Alt+numlock",
                    "Alt+insert","Alt+home","Alt+del","Alt+end","Alt+pageup","Alt+pagedown","Alt+left","Alt+up","Alt+right","Alt+down",
                    "Alt+f1","Alt+f2","Alt+f3","Alt+f4","Alt+f5","Alt+f6","Alt+f7","Alt+f8","Alt+f9","Alt+f10","Alt+f11","Alt+f12"
                ];*/
                var elements = [
                    "Shift+a", "Shift+d"
                ];

                // the fetching...
                jQuery.each(elements, function(i, e) { // i is element index. e is element as text.
                   var newElement = ( /[\+]+/.test(elements[i]) ) ? elements[i].replace("+","_") : elements[i];
                   
                   // Binding keys
                   jQuery(document).bind('keydown', elements[i], function assets() {
                      if(newElement == 'Shift_a') {
                        jQuery('#add_new_price_range').click();
                      }
                      if(newElement == 'Shift_d') {
                        var delete_dom = jQuery('[data-repeater-delete]');
                        var last_dom = (delete_dom.length - 1 );
                        jQuery(delete_dom[last_dom]).click();
                      }
                      return false;
                   });
                });
                
            }
            
            jQuery(document).ready(domo);