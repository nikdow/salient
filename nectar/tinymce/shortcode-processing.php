<?php

#-----------------------------------------------------------------#
# Columns
#-----------------------------------------------------------------# 

//half columns 
function nectar_one_half( $atts, $content = null ) {
    extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_6' . $column_classes . '">'. $box_border . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'nectar_one_half');

function nectar_one_half_last( $atts, $content = null ) {
    extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_6 col_last' . $column_classes . '">' . $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_half_last', 'nectar_one_half_last');



//one third columns
function nectar_one_third( $atts, $content = null ) {
	extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_4' . $column_classes . '">'. $box_border . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'nectar_one_third');

function nectar_one_third_last( $atts, $content = null ) {
    extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_4 col_last' . $column_classes . '">'. $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_third_last', 'nectar_one_third_last');

function nectar_two_thirds( $atts, $content = null ) {
    extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_8' . $column_classes . '">'. $box_border . do_shortcode($content) . '</div>';
}
add_shortcode('two_thirds', 'nectar_two_thirds');

function nectar_two_thirds_last( $atts, $content = null ) {
    extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_8 col_last' . $column_classes . '">'. $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('two_thirds_last', 'nectar_two_thirds_last');



//one fourth columns
function nectar_one_fourth( $atts, $content = null ) {
    extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_3' . $column_classes . '">'. $box_border . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'nectar_one_fourth');

function nectar_one_fourth_last( $atts, $content = null ) {
    extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_3 col_last' . $column_classes . '">'. $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_fourth_last', 'nectar_one_fourth_last');

function nectar_three_fourths( $atts, $content = null ) {
    extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_9' . $column_classes . '">'. $box_border . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourths', 'nectar_three_fourths');

function nectar_three_fourths_last( $atts, $content = null ) {
    extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_9 col_last' . $column_classes . '">'. $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('three_fourths_last', 'nectar_three_fourths_last');



//one sixth columns
function nectar_one_sixth( $atts, $content = null ) {
    extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_2' . $column_classes . '">'. $box_border . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'nectar_one_sixth');

function nectar_one_sixth_last( $atts, $content = null ) {
    extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_2 col_last' . $column_classes . '">'. $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_sixth_last', 'nectar_one_sixth_last');

function nectar_five_sixths( $atts, $content = null ) {
    extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_10' . $column_classes . '">'. $box_border . do_shortcode($content) . '</div>';
}
add_shortcode('five_sixths', 'nectar_five_sixths');

function nectar_five_sixths_last( $atts, $content = null ) {
    extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_10 col_last' . $column_classes . '">'. $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('five_sixths_last', 'nectar_five_sixths_last');



function nectar_one_whole( $atts, $content = null ) {
    extract(shortcode_atts(array("boxed" => 'false', "centered_text" => 'false'), $atts));
	$column_classes = null;
	$box_border = null;
	if($boxed == 'true')  { $column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; }
	if($centered_text == 'true') $column_classes .= ' centered-text';
    return '<div class="col span_12' . $column_classes . '">'. $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_whole', 'nectar_one_whole');

#-----------------------------------------------------------------#
# Elements
#-----------------------------------------------------------------# 

//full width section
function nectar_full_width_section($atts, $content = null) {
   	extract(shortcode_atts(array("top_padding" => "40", "bottom_padding" => "40", 'image_url'=> '', 'bg_pos'=> '', 'background_color'=> '', 'bg_repeat' => '', 'text_color' => 'light', 'parallax_bg' => '', 'class' => ''), $atts));
		
	$style = null;
	$etxra_class = null;
	
	if(!empty($image_url)) {
		$style .= 'background-image: url('. $image_url. '); ';
		$style .= 'background-position: '. $bg_pos .'; ';
		
		//for pattern bgs
		if(strtolower($bg_repeat) == 'repeat'){
			$style .= 'background-repeat: '. strtolower($bg_repeat) .'; ';
			$etxra_class = 'no-cover';
		} else {
			$style .= 'background-repeat: '. strtolower($bg_repeat) .'; ';
			$etxra_class = null;
		}
	}
	
	if(!empty($background_color)) {
		$style .= 'background-color: '. $background_color.'; ';
	}
	
	if(strtolower($parallax_bg) == 'true'){
		$parallax_class = 'parallax_section';
	} else {
		$parallax_class = null;
	}
	
	$style .= 'padding-top: '. $top_padding .'px; ';
	$style .= 'padding-bottom: '. $bottom_padding .'px; ';
	 
    return'
	<div id="'.uniqid("fws_").'" class="full-width-section '.$parallax_class . ' ' . $class . ' ' . $etxra_class.' " style="'.$style.'">
    <div class="col span_12 '.strtolower($text_color).'">'.do_shortcode($content).'</div></div>';
}
add_shortcode('full_width_section', 'nectar_full_width_section');


//image with animation
function nectar_image_with_animation($atts, $content = null) { 
    extract(shortcode_atts(array("animation" => 'Fade In From Left', "delay" => '0', "image_url" => '', 'alt' => ''), $atts));
	
	$parsed_animation = str_replace(" ","-",$animation);
	(!empty($alt)) ? $alt_tag = $alt : $alt_tag = null;
    return'<img class="img-with-animation" data-delay="'.$delay.'" data-animation="'.strtolower($parsed_animation).'" src="'.$image_url.'" alt="'.$alt_tag.'" />';
}
add_shortcode('image_with_animation', 'nectar_image_with_animation');


//testimonial slider
function nectar_testimonial_slider($atts, $content = null) { 
    extract(shortcode_atts(array("autorotate"=>''), $atts));
	
	
    return '<div class="col span_12 testimonial_slider" data-autorotate="'.$autorotate.'"><div class="slides">'.do_shortcode($content).'</div></div>';
}
add_shortcode('testimonial_slider', 'nectar_testimonial_slider');

//testimonial 
function nectar_testimonial($atts, $content = null) { 
    extract(shortcode_atts(array("name" => '', "quote" => ''), $atts));
	
    return '<blockquote><p>"'.$quote.'"</p>'. '<span>&minus; '.$name.'</span></blockquote>';
}
add_shortcode('testimonial', 'nectar_testimonial');



//heading
function nectar_heading($atts, $content = null) { 
    extract(shortcode_atts(array("title" => 'Title', "subtitle" => 'Subtitle'), $atts));
	$subtitle_holder = null;
	
	if($subtitle != 'Subtitle') $subtitle_holder = '<p>'.$subtitle.'</p>';
    return'
    <div class="col span_12 section-title text-align-center extra-padding">
		<h2>'.$content.'</h2>'. $subtitle_holder .'</div><div class="clear"></div>';
}
add_shortcode('heading', 'nectar_heading');



//divider
function nectar_divider($atts, $content = null) {  
    extract(shortcode_atts(array("line" => 'false', "custom_height" => '', "line_type" => 'No Line'), $atts));
	
	if($line_type == 'Small Thick Line' || $line_type == 'Small Line' ){
		$divider = '<div class="divider-small-border"></div>';
	} else if($line_type == 'Full Width Line'){
		$divider = '<div class="divider-border"></div>';
	} else {
		$height = (!empty($custom_height)) ? 'style="height: '.intval($custom_height).'px;"' : null;
		$divider = '<div '.$height.' class="divider"></div>';
	}
	//old option
	if($line == 'true') $divider = '<div class="divider-border"></div>';
    return $divider;
}
add_shortcode('divider', 'nectar_divider');



//milestone
function nectar_milestone($atts, $content = null) {  
    extract(shortcode_atts(array("subject" => '', 'number' => '0', 'color' => 'Default'), $atts));
	
	$number_markup = '<div class="number '.strtolower($color).'">'.$number.'</div>';
	$subject_markup = '<div class="subject">'.$subject.'</div>';
	
    return '<div class="nectar-milestone"> '.$number_markup.' '.$subject_markup.' </div>';
}
add_shortcode('milestone', 'nectar_milestone');

//button
function nectar_button($atts, $content = null) {  
    extract(shortcode_atts(array("size" => 'small', "url" => '#', 'color' => 'Accent-Color', "text" => 'Button Text', 'open_new_tab' => '0'), $atts));
	
	$target = ($open_new_tab == 'true') ? 'target="_blank"' : null;
	switch ($size) {
		case 'small' :
			$button_open_tag = '<a class="nectar-button small '. strtolower($color) .'"'. $target;
			break;
		case 'medium' :
			$button_open_tag = '<a class="nectar-button medium ' . strtolower($color) .'"'. $target;
			break;
		case 'large' :
			$button_open_tag = '<a class="nectar-button large '. strtolower($color) .'"'. $target;
			break;	
	}
    return $button_open_tag . ' href="' . $url . '">' . $text . '</a>';
}
add_shortcode('button', 'nectar_button');



//icon
function nectar_icon($atts, $content = null) {
	extract(shortcode_atts(array("size" => 'large', 'color' => 'Accent-Color', 'image' => 'icon-circle'), $atts)); 
	
	if($size == 'large-2') {
		$size_class = 'icon-3x alt-style';
	} 
	else if($size == 'large') {
		$size_class = 'icon-3x';
	} 
	else if($size == 'tiny') {
		$size_class = 'icon-tiny';
	}
	else {
		$size_class = 'icon-normal'; 
	}
	
	($size == 'large') ? $border = '<i class="circle-border"></i>' : $border = ''; 
    return '<i class="'. $size_class . ' ' . $image . ' ' . strtolower($color) .'">' . $border . '</i>';
}
add_shortcode('icon', 'nectar_icon');



//bar graph
function nectar_bar_graph($atts, $content = null) {  
    return '<ul class="bar_graph">'.  do_shortcode($content) .'</ul>';
}
add_shortcode('bar_graph', 'nectar_bar_graph');


function nectar_bar($atts, $content = null) {
	extract(shortcode_atts(array("title" => 'Title', "percent" => '1', 'color' => 'Accent-Color', 'id' => ''), $atts));  
	$bar = '
	<li>
		<p>' . $title . '</p>
		<div class="bar-wrap"><span class="'.strtolower($color).'" data-width="' . $percent . '"> <strong>' . $percent . '%</strong> </span></div>
	</li>';
    return $bar;
}
add_shortcode('bar', 'nectar_bar');



//Team Member
function nectar_team_member($atts, $content = null) {
	
    extract(shortcode_atts(array("description" => 'Description', 'color' => 'Accent-Color', 'name' => 'Name', 'job_position' => 'Job Position', 'image_url' => '', 'social' => ''), $atts));
		
	$html = null;
			
	$html .= '<div class="team-member">';
	if(!empty($image_url)){
		$html .= '<img alt="'.$name.'" src="' . $image_url .'" title="' . $name . '" />';
	}
	else {
		$html .= '<img alt="'.$name.'" src="' . NECTAR_FRAMEWORK_DIRECTORY . 'assets/img/team-member-default.jpg" title="' . $name . '" />';
	}
	$html .= '<h3 class="light">' . $name . '</h3> <div class="position">' . $job_position . '</div>';
	$html .= '<p class="description">' . $description . '</p>';
	
	if (!empty($social)) {
		
         $social_arr = explode(",", $social);
		 
		 $html .= '<ul class="social '.strtolower($color).'">';
         for ($i = 0 ; $i < count($social_arr) ; $i = $i + 2) {
         		
				$target = null;
         	    $url_host = parse_url($social_arr[$i + 1], PHP_URL_HOST);
			    $base_url_host = parse_url(get_template_directory_uri(), PHP_URL_HOST);
			    if($url_host != $base_url_host || empty($url_host)) {
			    	$target = 'target="_blank"';
			    }
				
               $html .=  "<li><a ".$target." href='" . $social_arr[$i + 1] . "'>" . $social_arr[$i] . "</a></li>";   
         }
		 $html .= '</ul>';
     }
	
	$html .= '</div>';
	
	return str_replace("\r\n", '', $html);
	 
}
add_shortcode('team_member', 'nectar_team_member');



//carousel
function nectar_carousel($atts, $content = null) {  
    extract(shortcode_atts(array("carousel_title" => 'Title', "scroll_speed" => 'medium', 'easing' => 'easeInExpo'), $atts));
	
	$carousel_html = null;
	$carousel_html .= '
	<div class="carousel-wrap">
	<div class="carousel-heading">
		<h2 class="uppercase">'. $carousel_title .'</h2>
		<a class="carousel-prev" href="#"><i class="icon-angle-left"></i></a>
		<a class="carousel-next" href="#"><i class="icon-angle-right"></i></a>
	</div>
	</span><ul class="row carousel" data-scroll-speed="' . $scroll_speed . '" data-easing="' . $easing . '">';
	
    return $carousel_html . do_shortcode($content) . '</ul></div>';
}
add_shortcode('carousel', 'nectar_carousel');

function nectar_carousel_item($atts, $content = null) {  
    return '<li class="col span_4">' . do_shortcode($content) . '</li>';
}
add_shortcode('item', 'nectar_carousel_item');



//clients
function nectar_clients($atts, $content = null) {  
    extract(shortcode_atts(array("carousel" => "false", "fade_in_animation" => "false", "columns" => '4'), $atts));
	
	$opening = null;
	$closing = null;
	$column_class = null;
	
	switch ($columns) {
		case '2' :
			$column_class = 'two-cols';
			break;
		case '3' :
			$column_class = 'three-cols';
			break;
		case '4' :
			$column_class = 'four-cols';
			break;	
		case '5' :
			$column_class = 'five-cols';
			break;
		case '6' :
			$column_class = 'six-cols';
			break;
	}
	
	($fade_in_animation == "true") ? $animation = 'fade-in-animation' : $animation = null ;
	
	if($carousel == "true"){
		$opening .= '<div class="carousel-wrap"><div class="row carousel clients '.$column_class.' ' .$animation.'" data-max="'.$columns.'">';
		$closing .= '</div></div>';
	}
	else{
		$opening .= '<div class="clients no-carousel '.$column_class.' ' .$animation.'">';
		$closing .= '</div>';
	}
	
    return $opening . do_shortcode($content) . $closing;
}
add_shortcode('clients', 'nectar_clients');

function nectar_client($atts, $content = null) {
	extract(shortcode_atts(array("image" => "", "url" => '#', "alt" => ""), $atts));
	$client_content = null;
	
	(!empty($alt)) ? $alt_tag = $alt : $alt_tag = 'client';
	if(!empty($url) && $url != 'none'){
		$client_content = '<div><a href="'.$url.'" target="_blank"><img src="'.$image.'" alt="'.$alt_tag.'" /></a></div>';
	}  
	else {
		$client_content = '<div><img src="'.$image.'" alt="'.$alt_tag.'" /></div>';
	}
    return $client_content;
}
add_shortcode('client', 'nectar_client');




//pricing tables
function nectar_pricing_table($atts, $content = null) {  
    extract(shortcode_atts(array("columns" => '4'), $atts));
	$column_class = null;
	
	switch ($columns) {
		case '2' :
			$column_class = 'two-cols';
			break;
		case '3' :
			$column_class = 'three-cols';
			break;
		case '4' :
			$column_class = 'four-cols';
			break;	
		case '5' :
			$column_class = 'five-cols';
			break;
	}
	
    return '<div class="row pricing-table '.$column_class.'">' . do_shortcode($content) . '</div>';
}
add_shortcode('pricing_table', 'nectar_pricing_table');

function nectar_pricing_column($atts, $content = null) {
	extract(shortcode_atts(array("title"=>'Column title', "highlight" => 'false', "highlight_reason" => 'Most Popular', 'color' => 'Accent-Color', "price" => "99", "currency_symbol" => '$', "interval" => 'Per Month'), $atts));
	
	$highlight_class = null;
	$hightlight_reason_html = null;
	
	if($highlight == 'true') {
		$highlight_class = 'highlight ' . strtolower($color); 
		$hightlight_reason_html = '<span class="highlight-reason">'.$highlight_reason.'</span>';
	}
	
    return '<div class="pricing-column '.$highlight_class.'">
  			<h3>'.$title. $hightlight_reason_html .'</h3>
            <div class="pricing-column-content">
				<h4> <span class="dollar-sign">'.$currency_symbol.'</span> '.$price.' </h4>
				<span class="interval">'.$interval.'</span>' . do_shortcode($content) . '</div></div>';
}
add_shortcode('pricing_column', 'nectar_pricing_column');



//tabbed sections
function nectar_tabs($atts, $content = null) {
    $GLOBALS['tab_count'] = 0;
	do_shortcode( $content );
	
	if( is_array( $GLOBALS['tabs'] ) ){
		
		foreach( $GLOBALS['tabs'] as $tab ){
			$tabs[] = '<li><a href="#'.$tab['id'].'">'.$tab['title'].'</a></li>';
			$panes[] = '<div id="'.$tab['id'].'">'.$tab['content'].'</div>';
		}
		
		$return = '<div class="tabbed"><ul>'.implode( "\n", $tabs ).'</ul><div class="clear"></div>'.implode( "\n", $panes )."</div>\n";
	}
	return $return;
}

add_shortcode('tabbed_section', 'nectar_tabs');


function nectar_tab( $atts, $content ){
	extract(shortcode_atts(array( 'title' => '%d', 'id' => '%d'), $atts));
	
	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array(
		'title' => sprintf( $title, $GLOBALS['tab_count'] ),
		'content' =>  do_shortcode($content),
		'id' =>  $id );
	
	$GLOBALS['tab_count']++;
}
add_shortcode( 'tab', 'nectar_tab' );


//toggle panel - accordion chosen
function nectar_toggles($atts, $content = null) { 
	extract(shortcode_atts(array("accordion" => 'false'), $atts));  
	
	($accordion == 'true') ? $accordion_class = 'accordion': $accordion_class = null ;
    return '<div class="toggles '.$accordion_class.'">' . do_shortcode($content) . '</div>'; 
}
add_shortcode('toggles', 'nectar_toggles');

//toggle
function nectar_toggle($atts, $content = null) {
	extract(shortcode_atts(array("title" => 'Title'), $atts));  
    return '<div class="toggle"><h3><a href="#"><i class="icon-plus-sign"></i>'. $title .'</a></h3><div>' . do_shortcode($content) . '</div></div>';
}
add_shortcode('toggle', 'nectar_toggle');



 



#-----------------------------------------------------------------#
# Nectar Slider 
#-----------------------------------------------------------------# 
function nectar_slider_processing($atts, $content = null) {
	
	extract(shortcode_atts(array("arrow_navigation" => 'false', "autorotate"=> '', "bullet_navigation" => 'false', "parallax" => 'false', "full_width" => '', "slider_height" => '', "desktop_swipe" => 'false', "location" => ''), $atts));  
    
	$slider_config = array(
	  'slider_height' => $slider_height,
	  'full_width' => $full_width,
	  'autorotate' => $autorotate,
	  'arrow_navigation' => $arrow_navigation,
	  'bullet_navigation' => $bullet_navigation,
	  'desktop_swipe' => $desktop_swipe,
	  'parallax' => $parallax,
	  'location' => $location
	);
	 
	return do_shortcode(nectar_slider_display($slider_config));
}

add_shortcode('nectar_slider', 'nectar_slider_processing');



#-----------------------------------------------------------------#
# Social Buttons
#-----------------------------------------------------------------# 
function nectar_social_buttons($atts, $content = null) {
	extract(shortcode_atts(array("nectar_love" => 'false', "facebook" => 'false', "twitter" => 'false', "google_plus" => 'false', "nectar-love" => 'false', "pinterest" => 'false'), $atts));  
    
	$buttons = '<div class="nectar-social">';
	
    if($nectar_love == 'true'){
		$buttons .= '<span class="n-shortcode">'.nectar_love('return').'</span>';
    }
	
	if($facebook == 'true'){
    	$buttons .= "<a class='facebook-share nectar-sharing' href='#' title='Share this'> <i class='icon-facebook'></i> <span class='count'></span></a>";
    }
	
	if($twitter == 'true'){
    	$buttons .= "<a class='twitter-share nectar-sharing' href='#' title='Tweet this'> <i class='icon-twitter'></i> <span class='count'></span></a>";
    }
	
	if($pinterest == 'true'){
    	$buttons .= "<a class='pinterest-share nectar-sharing' href='#' title='Pin this'> <i class='icon-pinterest'></i> <span class='count'></span></a>";
    }
	
	if($google_plus == 'true'){
    	$buttons .= "<a class='google-plus-share nectar-sharing' href='#' title='Share this'> <i class='icon-google-plus'></i> <span class='count'></span></a>";
    }
	
	$buttons .= '</div>';
	
    return $buttons;
}
add_shortcode('social_buttons', 'nectar_social_buttons');


#-----------------------------------------------------------------#
# Recent Posts/Work 
#-----------------------------------------------------------------# 

//Recent Posts
function nectar_recent_posts($atts, $content = null) {
	extract(shortcode_atts(array("title_labels" => 'false', 'category' => 'all'), $atts));  
	
	global $post;  
	global $options;
	
	$posts_page_id = get_option('page_for_posts');
	$posts_page = get_page($posts_page_id);
	$posts_page_title = $posts_page->post_title;
	$posts_page_link = get_page_uri($posts_page_id);
	
	$title_label_output = null;
	$recent_posts_title_text = (!empty($options['recent-posts-title'])) ? $options['recent-posts-title'] :'Recent Posts';		
	$recent_posts_link_text = (!empty($options['recent-posts-link'])) ? $options['recent-posts-link'] :'View All Posts';		
	
	//incase only all was selected
	if($category == 'all') {
		$category = null;
	}
	
	($title_labels == 'true') ? $title_label_output = '<h2 class="uppercase recent-posts-title">'.$recent_posts_title_text.'<a href="'. $posts_page_link.'" class="button"> / '. $recent_posts_link_text .'</a></h2>' : $title_label_output = null;
	$recent_posts_content = 
				
			$title_label_output .'
			<div class="row blog-recent">';
				
	
			    $recentBlogPosts = array(
			      'showposts' => 4,
			      'ignore_sticky_posts' => 1,
			      'category_name' => $category,
			      'tax_query' => array(
		              array( 'taxonomy' => 'post_format',
		                  'field' => 'slug',
		                  'terms' => array('post-format-link','post-format-quote'),
		                  'operator' => 'NOT IN'
		                  )
		              )
			    );
				query_posts($recentBlogPosts);
				if(have_posts()) : while(have_posts()) : the_post(); 
				
				$recent_posts_content .= '<div class="col span_3">'; 

					
					if ( has_post_thumbnail() ) { $recent_posts_content .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail($post->ID, 'blog', array('title' => '')) . '</a>'; }
						

					$recent_posts_content .= '<div class="post-header">
						<h3 class="title"><a href="'. get_permalink() .'">'.get_the_title().'</a></h3>';
						
						
					$recent_posts_content .= '</div><!--/post-header-->
					
					'.get_the_excerpt().'
					
				</div><!--/span_3-->';
				
				endwhile; endif; 
				wp_reset_query();
				
			$recent_posts_content .= '</div><!--/blog-recent-->';

	
    return $recent_posts_content;
	

}
add_shortcode('recent_posts', 'nectar_recent_posts');


 
//recent projects
function nectar_recent_projects($atts, $content = null) {
	extract(shortcode_atts(array("title_labels" => 'false', 'number_to_display' => '6','full_width' => 'false', 'category' => 'all'), $atts));   
	
	global $post; 
	global $options;
	global $nectar_love; 
	
	$options = get_option('salient');
	
	$title_label_output = null;
	$recent_projects_title_text = (!empty($options['carousel-title'])) ? $options['carousel-title'] : 'Recent Work';		
	$recent_projects_link_text = (!empty($options['carousel-link'])) ? $options['carousel-link'] : 'View All Work';		
	
	$full_width_carousel = ($full_width == 'true') ? 'true': 'false';
	
	$portfolio_link = get_portfolio_page_link(get_the_ID()); 
	if(!empty($options['main-portfolio-link'])) $portfolio_link = $options['main-portfolio-link'];
			
	//incase only all was selected
	if($category == 'all') {
		$category = null;
	}
	
	$projects_to_display = (intval($number_to_display) < 2) ? '6' : $number_to_display; 
	
	($title_labels == 'true') ? $title_label_output = '<h2 class="uppercase">'.$recent_projects_title_text.'<a href="'. $portfolio_link.'" class="button"> / '. $recent_projects_link_text .'</a></h2>' : $title_label_output = null;

				$portfolio = array(
					'posts_per_page' => $projects_to_display,
					'post_type' => 'portfolio',
					'project-type'=> $category
				);
				query_posts($portfolio); ?>
				
				
				<?php if(have_posts()) { 

					$recent_projects_content = '<div class="carousel-wrap recent-work-carousel" data-full-width="'.$full_width_carousel.'">
					
					<div class="carousel-heading">'.$title_label_output .'
						<a class="carousel-prev" href="#"><i class="icon-angle-left"></i></a>
				    	<a class="carousel-next" href="#"><i class="icon-angle-right"></i></a>
					</div>

					<ul class="row portfolio-items text-align-center carousel" data-scroll-speed="800" data-easing="easeInOutQuart">';
				 } 
				
				//standard layout
				if($full_width_carousel == 'false'){
					
					if(have_posts()) : while(have_posts()) : the_post();
					
						$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  
						$video_embed = get_post_meta($post->ID, '_nectar_video_embed', true);
						$video_m4v = get_post_meta($post->ID, '_nectar_video_m4v', true);
						$media = null;
						$date = null;
						$love = $nectar_love->add_love(); 
						$wp_version = floatval(get_bloginfo('version'));
						
						//video 
					    if( !empty($video_embed) || !empty($video_m4v) ) {
		
						    if( !empty( $video_embed ) && $wp_version < "3.6" ) { 
						    	
						    	$media .= '<a href="#video-popup-'.$post->ID.'" class="pp">'.__("Watch Video", NECTAR_THEME_NAME).' </a> ';
								$media .= '<div id="video-popup-'.$post->ID.'">';
						        $media .= '<div class="video-wrap">' . stripslashes(htmlspecialchars_decode($video_embed)) . '</div>';
								$media .= '</div>';
						    } 
						    
						    else {
								 $media .= '<a href="'.get_template_directory_uri(). '/includes/portfolio-functions/video.php?post-id=' .$post->ID.'&iframe=true&width=854" class="pp" >'.__("Watch Video", NECTAR_THEME_NAME).'</a> ';	 
						     }
		
				        } 
						
						//image
					    else {
					       $media .= '<a href="'. $featured_image[0].'" class="pp">'.__("View Larger", NECTAR_THEME_NAME).'</a> ';
					    }
						
						if(!empty($options['portfolio_date']) && $options['portfolio_date'] == 1) $date = get_the_time('F d, Y');
									
						$project_img = '<img src="'.get_template_directory_uri().'/img/no-portfolio-item-small.jpg" alt="no image added yet." />';
						if ( has_post_thumbnail() ) { $project_img = get_the_post_thumbnail($post->ID, 'portfolio-thumb', array('title' => '')); } 
						
						//custom thumbnail
						$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
						
						if( !empty($custom_thumbnail) ){
							$project_img = '<img class="custom-thumbnail" src="'.$custom_thumbnail.'" alt="'. get_the_title() .'" />';
						}
						
						
						$recent_projects_content .='<li class="col span_4">
							
							<div class="work-item">' . $project_img . '
			
								<div class="work-info-bg"></div>
								<div class="work-info">
									
									<div class="vert-center">' . $media . '
			
									<a href="' . get_permalink() . '">'.__("More Details", NECTAR_THEME_NAME).'</a>
		
									</div><!--/vert-center-->
									
								</div>
							</div><!--work-item-->
							
							<div class="work-meta">
								<h4 class="title"> '. get_the_title() .'</h4>
								'.$date.'
							</div><div class="nectar-love-wrap">
							
							'.$love.'</div>
							
							<div class="clear"></div>
							
						</li><!--/span_4-->';
					
					endwhile; endif; 
				
				} 
				
				//full width listings
				else {
					
					if(have_posts()) : while(have_posts()) : the_post();
					
						$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  
						$video_embed = get_post_meta($post->ID, '_nectar_video_embed', true);
						$video_m4v = get_post_meta($post->ID, '_nectar_video_m4v', true);
						$media = null;
						$date = null;
						$love = $nectar_love->add_love(); 
						$wp_version = floatval(get_bloginfo('version'));


						if(!empty($options['portfolio_date']) && $options['portfolio_date'] == 1) $date = get_the_time('F d, Y');
									
						$project_img = '<img src="'.get_template_directory_uri().'/img/no-portfolio-item-small.jpg" alt="no image added yet." />';
						if ( has_post_thumbnail() ) { $project_img = get_the_post_thumbnail($post->ID, 'portfolio-thumb', array('title' => '')); } 
						
						//custom thumbnail
						$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
						
						if( !empty($custom_thumbnail) ){
							$project_img = '<img class="custom-thumbnail" src="'.$custom_thumbnail.'" alt="'. get_the_title() .'" />';
						}
						
						
						$recent_projects_content .='<li class="col span_4">
							
							<div class="work-item">' . $project_img . '
			
								<div class="work-info-bg"></div>
								<div class="work-info">
									
									<i class="icon-salient-plus"></i> 
									
									<a href="' . get_permalink() . '"></a>

									<div class="vert-center"><h3>' . get_the_title() . '</h3> <p>' . $date.'</p></div><!--/vert-center-->
									
								</div>
							</div><!--work-item-->

						</li><!--/span_4-->';
					
					endwhile; endif; 
					
					
				}//full width
			
			if(have_posts()) { 
			 $recent_projects_content .= '</ul><!--/carousel--></div><!--/carousel-wrap-->';
			}

		wp_reset_query();


	
    return $recent_projects_content; 
	

}
add_shortcode('recent_projects', 'nectar_recent_projects');
 


$wp_version = floatval(get_bloginfo('version'));
 
//old video player	
if ( $wp_version < "3.6" ) {
		 
	//video
	function nectar_shortcode_video($atts, $content = null) {
		extract(shortcode_atts(array("title" => 'Title', 'm4v_url' => null, 'ogv_url' => null, 'image_url' => null, 'm4v' => null, 'ogv' => null, 'poster' => null), $atts));  
		$video_markup = null;
		
		$id = rand(); 
		$id = $id*rand(1,50);
	
		$video_m4v = null; 
		$video_ogv = null;
		$video_image = null;
		
		if (!empty($m4v_url)) { $video_m4v = $m4v_url; }
		if (!empty($m4v)) { $video_m4v = $m4v; }
		
		if (!empty($ogv_url)) { $video_ogv = $ogv_url; }
		if (!empty($ogv)) { $video_ogv = $ogv; }
		
		if (!empty($image_url)) { $video_image = $image_url; }
		if (!empty($poster)) { $video_image = $poster; } 

		if (empty($image_url) && empty($preview)) {
			$image_url = get_template_directory_uri().'/img/no-video-img.png'; 
		}

		$video_markup .= '<script type="text/javascript">
	    	jQuery(document).ready(function($){
			
	    		if( $().jPlayer ) {
	    			$("#jquery_jplayer_'.$id.'").jPlayer({
	    				ready: function () {
	    					$(this).jPlayer("setMedia", {
	    						m4v: "'.$video_m4v.'",
	    						ogv: "'. $video_ogv .'",
	    						poster: "'. $video_image .'"
	    					});
	    				},
	    				size: {
				          width: "100%",
				          height: "auto"
				        },
	    				swfPath: "'. get_template_directory_uri() .'/js",
	    				cssSelectorAncestor: "#jp_interface_'.$id.'",
	    				supplied: "m4v, ogv, all"
	    			});
	    		}
	    	});
	    </script>
	
	    <div id="jquery_jplayer_'.$id.'" class="jp-jplayer jp-jplayer-video"></div>
	
	    <div class="jp-video-container">
	        <div class="jp-video">
	            <div id="jp_interface_'.$id.'" class="jp-interface">
	                <ul class="jp-controls">
	                	<li><div class="seperator-first"></div></li>
	                    <li><div class="seperator-second"></div></li>
	                    <li><a href="#" class="jp-play" tabindex="1">play</a></li>
	                    <li><a href="#" class="jp-pause" tabindex="1">pause</a></li> 
	                    <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
	                    <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
	                </ul>
	                <div class="jp-progress">
	                    <div class="jp-seek-bar">
	                        <div class="jp-play-bar"></div>
	                    </div>
	                </div>
	                <div class="jp-volume-bar-container">
	                    <div class="jp-volume-bar">
	                        <div class="jp-volume-bar-value"></div>
	                    </div>
	                </div>
	            </div>
	
	        </div>
	    </div>';
		
		return $video_markup;
	
	}
	
	add_shortcode('video', 'nectar_shortcode_video');

}
 

 
//old audio player	 
if ( $wp_version < "3.6" ) {

	function nectar_shortcode_audio($atts, $content = null) {
		extract(shortcode_atts(array("title" => 'Title', 'mp3_url' => null, 'oga_url' => null, 'mp3' => null, 'ogg' => null), $atts));  
		$audio_markup = null;
		
		$id = rand();
		$id = $id*rand(1,50);
		
		$audio_mp3 = null;
		$audio_oga = null;
		
		if (!empty($mp3_url)) { $audio_mp3 = $m4v_url; }
		if (!empty($mp3)) { $audio_mp3 = $mp3; }
		
		if (!empty($oga_url)) { $audio_oga = $ogv_url; }
		if (!empty($ogg)) { $audio_oga = $ogg; }

		$audio_markup .= '<script type="text/javascript">
			
	    			jQuery(document).ready(function($){
		
	    				if( $().jPlayer ) {
	    					$("#jquery_jplayer_'.$id.'").jPlayer({
	    						ready: function () {
	    							$(this).jPlayer("setMedia", {
	    								mp3: "'.$audio_mp3.'",
	    								oga: "'.$audio_oga.'",
	    							});
	    						},
	    						swfPath: "'. get_template_directory_uri().' /js",
	    						cssSelectorAncestor: "#jp_interface_'.$id.'",
	    						supplied: "oga, mp3, all"
	    					});
						
	    				}
	    			});
	    		</script>
				
				<div class="audio-wrap">
					
		    	    <div id="jquery_jplayer_'.$id.'" class="jp-jplayer jp-jplayer-audio"></div>
		
		            <div class="jp-audio-container">
		                <div class="jp-audio">
		                    <div id="jp_interface_'.$id.'" class="jp-interface">
		                        <ul class="jp-controls">
		                            <li><a href="#" class="jp-play" tabindex="1">play</a></li>
		                            <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
		                            <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
		                            <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
		                        </ul>
		                        <div class="jp-progress">
		                            <div class="jp-seek-bar">
		                                <div class="jp-play-bar"></div>
		                            </div>
		                        </div>
		                        <div class="jp-volume-bar-container">
		                            <div class="jp-volume-bar">
		                                <div class="jp-volume-bar-value"></div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
	            </div>';
	
	
	return $audio_markup;
	 
	}	
	
	add_shortcode('audio', 'nectar_shortcode_audio');

}

?>