jQuery(document).ready(function () { 
	populate_site_select_search('old', 'deposit');


	jQuery('.loading, .transportation').on('change keyup', function(){
		calculateloadingCharge();
	});


});



function calculateloadingCharge() {

	var loading = jQuery('.loading').val();
	var transportation = jQuery('.transportation').val();

	var total = 0.00;

	loading = ( isInt(Number(loading)) || isFloat(Number(loading)) ) ? Number(loading) : 0.00;
	transportation = ( isInt(Number(transportation)) || isFloat(Number(transportation)) ) ? Number(transportation) : 0.00;

	total = (loading + transportation );

	jQuery('.loading_total').val(total).change();

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


  var discount_percentage = jQuery('.discount_percentage_deposit').val();
  var discount_amt = (ninety_days_total*discount_percentage) / 100;
  var discount_amt = Math.round10(discount_amt.toFixed(3), -2);
  jQuery('.discount_amt').val(discount_amt);

  var d_str = (discount_amt).toFixed(2);
  var d_substr = d_str.toString().split('.');
  var discount_rs = d_substr[0];
  var discount_ps = d_substr[1];
  jQuery('.rs_discount_txt').text(discount_rs);
  jQuery('.p_discount_txt').text(discount_ps);


  var final_total = ( parseFloat(ninety_days_total) - parseFloat(discount_amt) );
  jQuery('.total').val(final_total)

  var ft_str = (final_total).toFixed(2);
  var ft_substr = ft_str.toString().split('.');
  var final_total_rs = ft_substr[0];
  var final_total_ps = ft_substr[1];
  jQuery('.rs_tot_txt').text(final_total_rs);
  jQuery('.ps_tot_txt').text(final_total_ps);

}