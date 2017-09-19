jQuery(document).ready(function () { 
	populate_site_select_search('old', 'obc');

	jQuery('.amt_update .rupee-words').text( inWordsFull(jQuery('.cheque_amt').val()) );

	jQuery('.cheque_amt').on('change keyup', function () {
		jQuery('.rupee-words').text( inWordsFull(jQuery(this).val()) );
	});
	
	
	jQuery('.received_by').on('click', function(){
		var received_by = jQuery('.received_by:checked').val();
		if( received_by == 'cheque') {
			jQuery('[name="cheque_no"]').focus();
			var tmpStr = 'Chq.No ';
			jQuery('[name="cheque_no"]').val('');
			jQuery('[name="cheque_no"]').val(tmpStr);
		}

		if(received_by == 'cash') {
			jQuery('[name="cheque_no"]').focus();
			var tmpStr = 'Ref.No ';
			jQuery('[name="cheque_no"]').val('');
			jQuery('[name="cheque_no"]').val(tmpStr);
		}

		if(received_by == 'neft') {
			jQuery('[name="cheque_no"]').focus();
			var tmpStr = 'NEFT';
			jQuery('[name="cheque_no"]').val('');
			jQuery('[name="cheque_no"]').val(tmpStr);
		}

	});
});