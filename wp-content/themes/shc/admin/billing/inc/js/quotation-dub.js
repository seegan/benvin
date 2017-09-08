jQuery(document).ready(function () { 
	populate_site_select_search('old', 'quotation');



  jQuery('.round_off_rs, .round_off_ps').on('change',function(){
    processDepositFull();
  });



  jQuery('.tax_from').live('change', function(){
    var tax_from = jQuery('.tax_from:checked').val();

    jQuery('.tax_tr').css('display', 'none');
    jQuery('.vat_tr').css('display', 'none');
    jQuery('.gst_tr').css('display', 'none');

    console.log('dfsdf');

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

  jQuery('.hiring_discount_avail').on('change', function(){
    var discount_avail = jQuery('input[name=hiring_discount_avail]:checked').val();
    if(discount_avail == 'yes') {
      jQuery('.discount_tr').css('display', 'table-row');
      jQuery('.discount_percentage').val(jQuery('.discount_yes').val()).change();
      jQuery('.discount_percentage').attr('readonly', false);
    } else {
      jQuery('.discount_tr').css('display', 'none');
      jQuery('.discount_percentage').val(jQuery('.discount_no').val()).change();
      jQuery('.discount_percentage').attr('readonly', true);
    }
  });




});


function processDepositFull() {
  var n_total = 0.00, ninety_days_total;
  jQuery('.deposit-repeater .repeterin').each(function() {

    var n_cur_tot = parseFloat(jQuery(this).find('.ninety_rs_price').val())
    n_cur_tot = (isNaN(n_cur_tot)) ? 0.00 : n_cur_tot;
    n_total = n_total + n_cur_tot;
  });


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

  var final_total = (tax_include - round_off);
  final_total = Math.round10(final_total.toFixed(3), -2);
  final_total = final_total.toFixed(2);
  jQuery('.hiring_tot_val').val(final_total);

  var final_total_sp = splitRupee(final_total);
  jQuery('.hiring_tot_txt').text(final_total_sp[0]);
  jQuery('.hiring_tot_txt_p').text(final_total_sp[1]);


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
    tax_total = Math.round10(tax_total.toFixed(3), -2);

    var tax_total_sp = splitRupee(tax_total);
    jQuery('.vat_amt_txt').text( tax_total_sp[0] );
    jQuery('.vat_amt_txt_p').text( tax_total_sp[1] );
    jQuery('.vat_amt').val(tax_total);

  }
  if(tax_from == 'no_tax') {
    tax_total = parseFloat(0.00);
  }
  tax_total = Math.round10(tax_total.toFixed(3), -2);
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
    var cgst = parseFloat(( sub_tot * 9 / 100 ).toFixed(2));
    var sgst = parseFloat(( sub_tot * 9 / 100 ).toFixed(2));
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

    return (cgst + sgst);
  } else {
    var igst = parseFloat(( sub_tot * 18 / 100 ).toFixed(2));
    
    var igst_sp = splitRupee(igst);

    jQuery('.gst_igst_txt').text(igst_sp[0]);
    jQuery('.gst_igst_txt_p').text(igst_sp[1]);
    jQuery('.gst_igst').val(igst);
    return igst;
  }
}
















function processDepositRow(selector = '') {
  var dpt_qty = parseFloat(selector.find('.dpt_qty').val());
  dpt_qty = (isNaN(dpt_qty)) ? 0.00 : dpt_qty;

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