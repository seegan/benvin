jQuery(document).ready(function () { 
	populate_site_select_search('old', 'statement');



	jQuery('[name=billing_date], .statement_with_sd').on('change', function(){
		var statement_url = admin_page.statement;
		var statement_date = jQuery('[name=billing_date]').val();
		var statement_id = jQuery('.statement_id').val();
		var with_sd = jQuery('.statement_with_sd:checkbox:checked').val();

		var redirect_url = statement_url + '&id='+statement_id+'&date_to='+statement_date+'&sd='+with_sd;
		window.location = redirect_url;
	});
});


