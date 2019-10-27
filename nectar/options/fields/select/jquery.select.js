jQuery(document).ready(function ($) {
	
	//None of this is shifty, I don't know what you're talking about.
	$('h3:contains("Typography")').parent().find('h3').next('div').after('<table class="the-toggle">');
	
	var $clone = $('h3:contains("Typography")').parent().find('table').find('tr:first-child').clone();
	$('h3:contains("Typography")').parent().find('table').find('tr:first-child').remove();
	
	$clone.find('tr.font-family').removeClass();
	$('.the-toggle').html($clone);
	
	$('h3:contains("Typography")').parent().find('table:not(".the-toggle")').addClass('typography-table');
	$('h3:contains("Typography")').parent().find('table:not(".the-toggle")').find('tr').addClass('font-option');
	$('h3:contains("Typography")').parent().find('table:not(".the-toggle")').find('tr:nth-child(3n+1), tr:nth-child(1)').removeClass('font-option').addClass('font-family');

	//$('h3:contains("Typography")').parent().find('table').find('tr:first-child').addClass('the-toggle');
	

	
});
