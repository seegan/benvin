jQuery(document).ready(function () { 
	populate_site_select_search('old', 'obc');

	jQuery('.amt_update .rupee-words').text( inWordsFull(jQuery('.cheque_amt').val()) );

	jQuery('.cheque_amt').on('change keyup', function () {
		jQuery('.rupee-words').text( inWordsFull(jQuery(this).val()) );
	});
	
  
});