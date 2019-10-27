jQuery(document).ready(function ($) {
	
	if($('h3:contains("Typography")').length > 0 ){
		
		//create the dropdown relationships
		
		
		//if regular font
		
		
		//if google map
		
		
		var google_font_weights = {
			'Arvo, serif'                     :  ['400', '700'],
	        'Copse, sans-serif'               :  ['400'],
	        'Droid Sans, sans-serif'          :  ['400', '700'],
	        'Droid Serif, serif'              :  ['400', '400-italic', '700'],
	        'Lobster, cursive'                :  ['400'],
	        'Nobile, sans-serif'              :  ['400', '400-italic', '700'],
	        'Open Sans, sans-serif'           :  ['300', '400', '400-italic', '600', '700'],
	        'Open Sans Condensed, sans-serif' :  ['300', '700'],
	        'Oswald, sans-serif'              :  ['300','400','700'],
	        'Pacifico, cursive'               :  ['400'],
	        'Rokkitt, serif'                  :  ['400', '700'],
	        'PT Sans, sans-serif'             :  ['400', '400-italic', '700'],
	        'Quattrocento, serif'             :  ['400', '700'],
	        'Raleway, cursive'                :  ['300', '400', '600', '700'],
	        'Ubuntu, sans-serif'              :  ['300', '400', '400-italic', '700'],
	        'Yanone Kaffeesatz, sans-serif'   :  ['300', '400', '700']
		}
		
		var os_font_weights = ['400', '400-italic', '700'];
		

		$('.typography-table .font-family select').change(function(){
			
			var $available_weights;
			
			//has a google font or os font been selected?
			if( typeof google_font_weights[$(this).val()] != 'undefined' ){
				$available_weights = google_font_weights[ $(this).val() ];
			}
			else{
				$available_weights = os_font_weights;
			}
			

			//unhide all
			$(this).closest('tr').next('tr').next('tr').find('select option').show();
			
			//loop through each option
			$(this).closest('tr').next('tr').next('tr').find('select option').each(function(i){
	
				if( i != 0 && $available_weights.indexOf($(this).val()) == -1){
					$(this).hide();
				}
				
			});
			
			//auto select first option in visible list
			$(this).closest('tr').next('tr').next('tr').find('select option').attr('selected','');
			$(this).closest('tr').next('tr').next('tr').find('select option:visible:first').attr('selected','selected');
			
			
		});//change event
		
		
		
		
		//on load only show the corresponding weights
		$('.typography-table .font-family select').each(function(){
			
			var $available_weights;
			
			//has a google font or os font been selected?
			if( typeof google_font_weights[$(this).val()] != 'undefined' ){
				$available_weights = google_font_weights[ $(this).val() ];
			}
			else{
				$available_weights = os_font_weights;
			}
			
			
			//unhide all
			$(this).closest('tr').next('tr').next('tr').find('select option').show();
			
			//loop through each option
			$(this).closest('tr').next('tr').next('tr').find('select option').each(function(i){
	
				if( i != 0 && $available_weights.indexOf($(this).val()) == -1){
					$(this).hide();
				}
				
			});
			
			
		});
		
		
	}//if typography h3
	
})
