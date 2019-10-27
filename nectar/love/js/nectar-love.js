jQuery(document).ready(function($){
	
	//-----------------------------------------------------------------
	// NectarLove
	//-----------------------------------------------------------------
	
	$('body').on('click','.nectar-love', function() {
		
			var $loveLink = $(this);
			var $id = $(this).attr('id');
			
			if($loveLink.hasClass('loved')) return false;
	
			var $dataToPass = {
				action: 'nectar-love', 
				loves_id: $id 
			}
			
			$.post(nectarLove.ajaxurl, $dataToPass, function(data){
				$loveLink.find('span').html(data);
				$loveLink.addClass('loved').attr('title','You already love this!');
				$loveLink.find('span').css({'opacity': 1,'width':'auto'});
			});
		
			return false;
	});
	
	
});