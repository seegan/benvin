(function() {


  
jQuery(document).ready(function(){
  jQuery( "#datepicker, .datepicker" ).datepicker( {dateFormat: 'yy-mm-dd'} );

  jQuery('.bill.bill_no, .financial_date').on('change', function() {
    jQuery('.loadin-billfrom').css('display', 'inline-block');
    jQuery('.loadin-check').css('display', 'none');
    jQuery('.loadin-cross').css('display', 'none');


    jQuery.ajax({
      type: "POST",
      dataType : "json",
      url: frontendajax.ajaxurl,
      data: {
          action : 'billno_check',
          bill_no : jQuery('.bill.bill_no').val(),
          bill_for : jQuery('.billno_action').val(),
          site_id : jQuery('.site_id').val(),
          financial_date : jQuery('.financial_date').val(),
      },
      success: function (data) {
        jQuery('.loadin-billfrom').css('display', 'none');
        if(data.success) {
          jQuery('.loadin-check').css('display', 'inline-block');
          jQuery('.loadin-cross').css('display', 'none');
        } else {
          jQuery('.loadin-check').css('display', 'none');
          jQuery('.loadin-cross').css('display', 'inline-block');
        }
      }
    });

  })


  jQuery('.delete_record').live('click', function(){
      var action = jQuery(this).attr('data-action');
      var bill_id = jQuery(this).attr('data-delete-id');
      var action_from = jQuery(this).attr('data-action-from');
      if(action_from == 'list') {
        var bill_txt = "Are you Sure to delete "+ jQuery(this).closest('tr').find('.bill_txt').text().trim()+"?";
      } else {
        var bill_txt = "Are you Sure to delete this data?";
      }


      jQuery( ".delete-box" ).dialog({
          resizable: false,
          height: "auto",
          width: 400,
          modal: true,
          title: "Delete",
          buttons: {
              Yes: function() {
                jQuery( this ).dialog( "close" );
                recordDeleteAjax( bill_id, action, action_from);
              },
              No: function() {
                jQuery( this ).dialog( "close" );
              }
          }
      });
      jQuery( ".delete-box .action-block" ).html(bill_txt);
  });


  jQuery('.print_record').live('click', function(){
      var action = jQuery(this).attr('data-action');
      var bill_id = jQuery(this).attr('data-print-id');
      var action_from = jQuery(this).attr('data-action-from');

      if(action_from == 'list') {
        var bill_txt = "Print "+ jQuery(this).closest('tr').find('.bill_txt').text().trim()+" With Headers ?";
        bill_txt = "<div style='text-align:center;'>"+bill_txt+"&nbsp;&nbsp;<input type='radio' name='headers_avail' value='yes' checked style='margin-top: -2px;'>Yes <input type='radio' name='headers_avail' value='no' style='margin-top: -2px;'>No</div>";
        
        if(action == 'print_statement') {
          var sd = jQuery('.statement_with_sd:checked').length;
          var date_to = jQuery('.statement_date').val();

          bill_txt += "<div style='text-align:center;'>With SD ?&nbsp;&nbsp;<input type='checkbox' class='with_sd' value='1' style='margin-top: -2px;' checked='"+sd+"'></div>";
          bill_txt += "<div style='text-align:center;'>Statement Date To :&nbsp;&nbsp;<input type='text' value='"+date_to+"' class='statement_date_to' style='height: 25px;width: 120px;'></div>";
        }

        var p_title = "Print";
      } else {
        var bill_txt = "Are you Sure to delete this data?";
        var p_title = "Delete";
      }

      jQuery( ".print-box" ).dialog({
          resizable: false,
          height: "auto",
          width: 400,
          modal: true,
          title: p_title,
          buttons: {
              Print: function() {

                var headers = jQuery('input[name=headers_avail]:checked').val();

                if(action == 'print_quotation') {
                  var print_url = print_page.quotation+'?quotation_no='+bill_id+'&headers='+headers;
                  var title = 'Quotation';
                }
                if(action == 'print_deposit') {
                  var print_url = print_page.deposit+'?deposit_id='+bill_id+'&headers='+headers;
                  var title = 'Deposit Challan';
                }
                if(action == 'print_delivery') {
                  var print_url = print_page.delivery+'?delivery_id='+bill_id+'&headers='+headers;
                  var title = 'Delivery Challan';
                }
                if(action == 'print_return') {
                  var print_url = print_page.return+'?return_id='+bill_id+'&headers='+headers;
                  var title = 'Meterial Return Receipt';
                }
                if(action == 'print_hiring') {
                  var print_url = print_page.hiring+'?bill_no='+bill_id+'&headers='+headers;
                  var title = 'Hiring Bill';
                }
                if(action == 'print_statement') {
                  var sd = jQuery('.with_sd:checked').length;
                  var date_to = jQuery('.statement_date_to').val();
                  var print_url = print_page.statement+'?statement_id='+bill_id+'&headers='+headers+'&sd='+sd+'&date_to='+date_to;
                  var title = 'Hiring Bill';
                }
                if(action == 'print_receipt') {
                  var print_url = print_page.receipt+'?bill_no='+bill_id+'&headers='+headers;
                  var title = 'Payment Receipt';
                }


                PrintInv(print_url, title);
                jQuery( this ).dialog( "close" );
              },
              Cancel: function() {
                jQuery( this ).dialog( "close" );
              }
          }
      });
      jQuery( ".print-box .action-block" ).html(bill_txt);
  });



  jQuery('.deposit-repeater1').repeater({
    defaultValues: {
      damage_charge : '0.00',
      damage_id : 0,
    },
    show: function () {
      var count = 1;
      jQuery('.deposit-repeater1 .repeterin').each(function(){
        jQuery(this).find('.rowno').text(count);
        count++;
      });
      jQuery(this).slideDown();
    },
    hide: function (deleteElement) {
        if(confirm('Are you sure you want to delete this element?')) {
          jQuery(this).slideUp(deleteElement);
          var count = 1;
          jQuery('.damage-repeater1 .repeterin').each(function(){ 
            jQuery(this).find('.rowno').text(count);
            count++;
          })
        }
    },
    ready: function (setIndexes) {
    }
  });





});



  function PrintInv(url, title) {
    var thePopup = window.open( url, "Customer Listing","scrollbars=yes,menubar=0,location=0" );
    thePopup.print(); 


/*      var mywindow = window.open(url,title,"scrollbars=yes,menubar=0,location=0,top=50,left=300,height=500,width=750");
      var is_chrome = Boolean(mywindow.chrome);





     if (is_chrome) {
       setTimeout(function() { // wait until all resources loaded 
          mywindow.document.close(); // necessary for IE >= 10
          mywindow.focus(); // necessary for IE >= 10
          mywindow.print(); // change window to winPrint
          mywindow.close(); // change window to winPrint
       }, 250);
     } else {
          mywindow.document.close(); // necessary for IE >= 10
          mywindow.focus(); // necessary for IE >= 10

          mywindow.print();
          mywindow.close();
     }

      return true;*/
  }


  function recordDeleteAjax(bill_id = '', action = '', action_from = 'list') {
    jQuery('#lightbox').css('display','block');
    jQuery.ajax({
      type: "POST",
      dataType : "json",
      url: frontendajax.ajaxurl,
      data: {
          action : 'delete_record',
          bill_id : bill_id,
          bill_action : action,
          action_from : action_from,
      },
      success: function (data) {
        clearPopup();
        jQuery('#lightbox').css('display','none');

        if(data.redirect != 0) { 
            setTimeout(function() {
                managePopupContent(data);
            }, 1000);
        } else {
          location.reload();
        }

        if(data.success == 0) {
            popItUp('Error', data.msg);
        } else {
            popItUp('Success', data.msg);
        }
      }
    });

  }

  /**
   * Decimal adjustment of a number.
   *
   * @param {String}  type  The type of adjustment.
   * @param {Number}  value The number.
   * @param {Integer} exp   The exponent (the 10 logarithm of the adjustment base).
   * @returns {Number} The adjusted value.
   */
  function decimalAdjust(type, value, exp) {
    // If the exp is undefined or zero...
    if (typeof exp === 'undefined' || +exp === 0) {
      return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // If the value is not a number or the exp is not an integer...
    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
      return NaN;
    }
    // If the value is negative...
    if (value < 0) {
      return -decimalAdjust(type, -value, exp);
    }
    // Shift
    value = value.toString().split('e');
    value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
  }

  // Decimal round
  if (!Math.round10) {
    Math.round10 = function(value, exp) {
      return decimalAdjust('round', value, exp);
    };
  }
  // Decimal floor
  if (!Math.floor10) {
    Math.floor10 = function(value, exp) {
      return decimalAdjust('floor', value, exp);
    };
  }
  // Decimal ceil
  if (!Math.ceil10) {
    Math.ceil10 = function(value, exp) {
      return decimalAdjust('ceil', value, exp);
    };
  }
})();



































function popItUp (title, content) {
	jQuery('#my-button').click();

	jQuery('.popup_header').html(title);
	jQuery('.popup_container').html(content);

}
function clearPopup() {
	jQuery('.popup_header').html('');
	jQuery('.popup_container').html('');
}

jQuery(document).ready(function(){
    jQuery('.stock_from, .stock_to, .bill_from, .bill_to, .customer_from, .customer_to').datepicker({dateFormat: "yy-mm-dd"});


    jQuery('.deposit_date').datetimepicker({dateFormat: "yy-mm-dd"});

	jQuery('#my-button').on('click', function(){
		jQuery('.popup_box').bPopup();
	});


    jQuery('.filter-section :input').on('change', function(){
        var filter_action   = jQuery('.filter_action').val();
        var container_class = '.'+filter_action;

        jQuery.ajax({
            type: "POST",
            url: frontendajax.ajaxurl,
            data: {
                action : filter_action,
                data : jQuery('.filter-section :input').serialize()
            },
            success: function (data) {
                if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
                replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
                replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
                    var obj = jQuery.parseJSON(data);
                    if(obj.success == 0) {
                        alert_popup('<span class="error_msg">Something Went Wrong! try again!</span>', 'Error');
                    }
                } else {
                    jQuery(container_class).html(data);
                }
            }
        });
    });
	




    jQuery('.bill-date .bill_from').on('change', function(){
      var date  = new Date( jQuery(this).val() );
      var year  = date.getFullYear();
      var month = date.getMonth(); // January
      var d     = new Date(year, month + 1, 0);

      jQuery('.bill-date .bill_to').val(dateToYMD(d)).change();
    });


    jQuery('.get_bill').on('click', function(){

      var bill_from = jQuery('.bill-date .bill_from').val();
      var bill_to = jQuery('.bill-date .bill_to').val();
      var hiring_url = admin_page.hiring;
      var master_id = '&id='+jQuery('.master_id_input').val();
      var bill_query = '&bill_from='+bill_from+'&bill_to='+bill_to;

      var redirect_url = hiring_url + master_id + bill_query;
      window.location = redirect_url;

    });


});

function dateToYMD(date) {
    var d = date.getDate();
    var m = date.getMonth() + 1;
    var y = date.getFullYear();
    return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
}



function slugify(text){
  return text.toString().toLowerCase()
    .replace(/\s+/g, '_')           // Replace spaces with -
    .replace(/[^\u0100-\uFFFF\w\-]/g,'_') // Remove all non-word chars ( fix for UTF-8 chars )
    .replace(/\-\-+/g, '_')         // Replace multiple - with single -
    .replace(/^-+/, '')             // Trim - from start of text
    .replace(/-+$/, '')            // Trim - from end of text
    .replace(/-+/g, '_');            // Trim - from end of text
}


function managePopupContent( data ) {
    window.location = data.redirect;
}





function populate_site_select_search(v = 'new', type = 'deposit') { 


  jQuery('.delivery_site_name').select2({
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
              action: 'get_deposit_site_list', // search term
              page: 1,
              search_key: params.term,
            };
          },
          processResults: function(data) {
            var results = [];
            return {
                results: jQuery.map(data.items, function(obj) {
                    return { id: obj.id, name:obj.name, site_name:obj.site_name, mobile: obj.phone_number, address:obj.site_address};
                })
            };
          },
          cache: true
      },
    initSelection: function (element, callback) {
        if(v == 'old') {
          callback({ id: jQuery(element).attr('data-dvalue'), name: jQuery(element).attr('data-name'),site_name:jQuery(element).attr('data-sitename'), mobile: jQuery(element).attr('data-mobile'), address: jQuery(element).attr('data-address') });
        } else {
          callback({ id: '', name: '', site_name : '', mobile: '', address : '' });
        }
    },

      templateResult: formatDepositState,
      templateSelection: formatDepositState1
  }).on("select2:select", function (e) {

    if(type == 'quotation') {
      window.location = admin_page.quotation+'&id='+e.params.data.id;
    }
    if(type == 'deposit') {
      window.location = admin_page.deposit+'&id='+e.params.data.id;
    }
    if(type == 'delivery') {
      window.location = admin_page.delivery+'&id='+e.params.data.id;
    }
    if(type == 'return') {
      window.location = admin_page.return+'&id='+e.params.data.id;
    }
    if(type == 'hiring') {
      window.location = admin_page.hiring+'&id='+e.params.data.id;
    }
    if(type == 'obc') {
      window.location = admin_page.obc+'&id='+e.params.data.id;
    }
    if(type == 'statement') {
      window.location = admin_page.statement+'&id='+e.params.data.id;
    }



  });


}


function formatDepositState (state) {
  if (!state.id) {
    return state.id;
  }
  var $state = jQuery(
    '<span> Master Id: ' +
      state.id+
    '</span> <br>'+
    '<span> Customer Name: ' +
      state.name+
    '</span> <br>'+
    '<span> Site : ' +
      state.site_name+
    '</span> <br>'+
    '<span> Address : '+
      state.address+'</span> <br>' +
    '<span> Phone : '+
      state.mobile+'</span>' 
  );
  return $state;
};

function formatDepositState1(state) {
  if (!state.id) {
    return state.id;
  }
  var $state = jQuery(
    '<span>' +
      state.site_name +
    '</span>'
  );
  return $state;
}



function isInt(n){
    return Number(n) === n && n % 1 === 0;
}

function isFloat(n){
    return Number(n) === n && n % 1 !== 0;
}






var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];




function inWords (num) {
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
    return str;
}

function inWordsFull(num) {
    var n_substr = num.toString().split('.');
    var rs = n_substr[0];
    var ps = n_substr[1];
    var con = '';
    var ps_txt = '', rs_txt = '';

    rs_txt = inWords(rs);

    if(ps && ps != '00' ) {
      con = ' and ';
      ps_txt = inWords(ps)+' Piasa';
    } 

    return rs_txt + con + ps_txt +' Only';

}


function splitRupee(rupee_txt = '') {
  var n_substr = rupee_txt.toString().split('.');
  return n_substr;
}


function moneyFormatIndia(x) {
  x=x.toString();
  var afterPoint = '';
  if(x.indexOf('.') > 0)
     afterPoint = x.substring(x.indexOf('.'),x.length);
  x = Math.floor(x);
  x=x.toString();
  var lastThree = x.substring(x.length-3);
  var otherNumbers = x.substring(0,x.length-3);
  if(otherNumbers != '')
      lastThree = ',' + lastThree;
  var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
  return res;
}

