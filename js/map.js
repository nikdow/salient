Object.keys = Object.keys || function(o) { 
    var result = []; 
    for(var name in o) { 
        if (o.hasOwnProperty(name)) 
          result.push(name); 
    } 
    return result; 
};

jQuery(document).ready(function($){
	
	//map margin if page header
	if( $('#page-header-bg:not("[data-parallax=1]")').length > 0 ) { $('#contact-map').css('margin-top', 0);  $('.container-wrap').css('padding-top', 0);} 
	if( $('#page-header-bg[data-parallax=1]').length > 0 ) $('#contact-map').css('margin-top', '-30px');
	
    var zoomLevel = parseFloat($('#contact-map').attr('data-zoom-level'));
    var centerlat = parseFloat($('#contact-map').attr('data-center-lat'));
	var centerlng = parseFloat($('#contact-map').attr('data-center-lng'));
	var markerImg = $('#contact-map').attr('data-marker-img');
	var enableZoom = $('#contact-map').attr('data-enable-zoom');
	var enableAnimation = $('#contact-map').attr('data-enable-animation');
	var animationDelay = 0; 
	
	if( isNaN(zoomLevel) ) { zoomLevel = 12;}
	if( isNaN(centerlat) ) { centerlat = 51.47;}
	if( isNaN(centerlng) ) { centerlng = -0.268199;}
	if( typeof enableAnimation != 'undefined' && enableAnimation == 1 && $(window).width() > 690) { animationDelay = 180; enableAnimation = google.maps.Animation.BOUNCE } else { enableAnimation = null; }

    var latLng = new google.maps.LatLng(centerlat,centerlng);
    
    
	var mapOptions = {
      center: latLng,
      zoom: zoomLevel,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      scrollwheel: false,
      panControl: false,
	  zoomControl: enableZoom,	  
	  zoomControlOptions: {
        style: google.maps.ZoomControlStyle.LARGE,
        position: google.maps.ControlPosition.LEFT_CENTER
   	  },
	  mapTypeControl: false,
	  scaleControl: false,
	  streetViewControl: false
	  
    };
	
	var map = new google.maps.Map(document.getElementById("contact-map"), mapOptions);
	
	var infoWindows = [];
	
	google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
		
		//don't start the animation until the marker image is loaded if there is one
		if(markerImg.length > 0) {
			var markerImgLoad = new Image();
			markerImgLoad.src = markerImg;
			
			$(markerImgLoad).load(function(){
				 setMarkers(map);
			});
		}
		else {
			setMarkers(map);
		}
    });
    
    
    function setMarkers(map) {
		for (var i = 1; i <= Object.keys(map_data).length; i++) {  
			
			(function(i) {
				setTimeout(function() {
				
			      var marker = new google.maps.Marker({
			      	position: new google.maps.LatLng(map_data[i].lat, map_data[i].lng),
			        map: map,
					infoWindowIndex : i - 1,
					animation: enableAnimation,
					icon: markerImg,
					optimized: false
			      });
				  
				  setTimeout(function(){marker.setAnimation(null);},200);
				  
			      //infowindows 
			      var infowindow = new google.maps.InfoWindow({
			   	    content: map_data[i].mapinfo,
			    	maxWidth: 300
				  });
				  
				  infoWindows.push(infowindow);
			      
			      google.maps.event.addListener(marker, 'click', (function(marker, i) {
			        return function() {
			        	infoWindows[this.infoWindowIndex].open(map, this);
			        }
			        
			      })(marker, i));
		     	
		         }, i * animationDelay);
		         
		         
		     }(i));
		     

		 }//end for loop
	}//setMarker
	
});
