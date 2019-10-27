<?php 

function nectar_custom_css() {
	
	$options = get_option('salient');
	
	//boxed css
	if(!empty($options['boxed_layout']) && $options['boxed_layout'] == '1')  {
		
		$attachment = $options["background-attachment"];
		$position = $options["background-position"];
		$repeat = $options["background-repeat"];
		$background_color = $options["background-color"];
		
		echo '<style type="text/css">
		 body {
		 	background-image: url("'.$options["background_image"].'");
			background-position: '.$position.';
			background-repeat: '.$repeat.';
			background-color: '.$background_color.';
			background-attachment: '.$attachment.';';
			if(!empty($options["background-cover"]) && $options["background-cover"] == '1') {
				echo 'background-size: cover;
				-moz-background-size: cover;
				-webkit-background-size: cover;
				-o-background-size: cover;';
			}
			
		 echo '} 
		</style>';
	}
	
	//top nav
	
	$logo_height = (!empty($options['use-logo']) && !empty($options['logo-height'])) ? intval($options['logo-height']) : 30;
	$header_padding = (!empty($options['header-padding'])) ? intval($options['header-padding']) : 28;
	$nav_font_size = (!empty($options['use-custom-fonts']) && $options['use-custom-fonts'] == 1 && !empty($options['navigation_font_size'])) ? intval(substr($options['navigation_font_size'],0,-2)) + 10 : 20;
	$dd_indicator_height = (!empty($options['use-custom-fonts']) && $options['use-custom-fonts'] == 1 && !empty($options['navigation_font_size'])) ? intval(substr($options['navigation_font_size'],0,-2)) -1 : 20;
	
	$padding_top = ceil(($logo_height/2)) - ceil(($nav_font_size/2));
	$padding_bottom = (ceil(($logo_height/2)) - ceil(($nav_font_size/2))) + $header_padding;
	
	$search_padding_top = ceil(($logo_height/2)) - ceil(21/2) +1;
	$search_padding_bottom =  (ceil(($logo_height/2)) - ceil(21/2));
	
	$using_secondary = (!empty($options['header_layout'])) ? $options['header_layout'] : ' ';
	
	if($using_secondary == 'header_with_secondary'){
	 	$header_space = $logo_height + ($header_padding*2) + 34;
	}
	else {
	 	$header_space = $logo_height + ($header_padding*2);
	}
	 
	echo '<style type="text/css">
	  
	  #header-outer { padding-top: '.$header_padding.'px; }
	  
	  #header-outer #logo img { height: ' . $logo_height .'px; }

	  header#top nav > ul > li > a {
	  	padding-bottom: '. $padding_bottom .'px;
		padding-top: '. $padding_top .'px;
	  }
	  
	  header#top nav > ul li#search-btn {
	  	 padding-bottom: '. $search_padding_bottom .'px;
		 padding-top: '. $search_padding_top .'px;
	  }

	  header#top .sf-menu > li.sfHover > ul { top: '.$nav_font_size.'px; }

	 .sf-sub-indicator { height: '.$dd_indicator_height.'px; }

	 #header-space { height: '. $header_space .'px;}
	 
	 body[data-smooth-scrolling="1"] #full_width_portfolio .project-title.parallax-effect { top: '.$header_space.'px; }

	</style>';
	
	//custom css
	if(!empty($options["custom-css"])){
		echo '<style type="text/css">' . $options["custom-css"] . '</style>';
	} 

}

add_action('wp_head', 'nectar_custom_css');

?>