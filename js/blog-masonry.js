jQuery(document).ready(function($){
	
	var $container = $('#post-area')
	
	if($container.hasClass('masonry')) { 
		$container.find('article').addClass('masonry-blog-item');
		$container.find('article').prepend('<span class="bottom-line"></span>');
		
		//move the meta to the bottom
		$container.find('article').each(function(){
			
			var $metaClone = $(this).find('.post-meta').clone();

			$(this).find('.post-meta').remove();

			$(this).find('.content-inner').after($metaClone);
			
		});
	}
	
	var $cols = 3;
	var $element = $container;
	
	if($container.find('img').length == 0) $element = $('body');

	imagesLoaded($element,function(instance){
		
		if($('body').hasClass('mobile') || $('#post-area').hasClass('span_9')) {
			$cols = 2;
		}
		
		$container.isotope({
		   itemSelector: 'article',
		   masonry: { columnWidth: $('#post-area').width() / $cols }
		});
		
		$container.animate({'opacity': 1},1300);
				
	});
	
	$(window).resize(function(){
		if($('body').hasClass('mobile') || $('#post-area').hasClass('span_9')) {
		   $cols = 2;
	   } else {
	   	   $cols = 3;
	   }
	});
	
	$(window).smartresize(function(){
	   $container.isotope({
	      masonry: { columnWidth: $('#post-area').width() / $cols}
	   });
	});

	
});