<?php 
 
function options_typography_get_os_fonts() {
    // OS Font Defaults
    $os_faces = array(
        'Arial, sans-serif' => 'Arial',
        'Cambria, Georgia, serif' => 'Cambria',
        'Copse, sans-serif' => 'Copse',
        'Garamond, Times New Roman, Times, serif' => 'Garamond',
        'Georgia, serif' => 'Georgia',
        'Helvetica, sans-serif' => 'Helvetica',
        'Tahoma, Geneva, sans-serif' => 'Tahoma'
    );
    return $os_faces;
}

function options_typography_get_google_fonts() {
    // Google Font Defaults
    $google_faces = array(
        'Arvo, serif' => 'Arvo',
        'Copse, sans-serif' => 'Copse',
        'Droid Sans, sans-serif' => 'Droid Sans',
        'Droid Serif, serif' => 'Droid Serif',
        'Lobster, cursive' => 'Lobster',
        'Nobile, sans-serif' => 'Nobile',
        'Open Sans, sans-serif' => 'Open Sans',
        'Open Sans Condensed, sans-serif' => 'Open Sans Condensed',
        'Oswald, sans-serif' => 'Oswald',
        'Pacifico, cursive' => 'Pacifico',
        'Rokkitt, serif' => 'Rokkit',
        'PT Sans, sans-serif' => 'PT Sans',
        'Quattrocento, serif' => 'Quattrocento',
        'Raleway, cursive' => 'Raleway',
        'Ubuntu, sans-serif' => 'Ubuntu',
        'Yanone Kaffeesatz, sans-serif' => 'Yanone Kaffeesatz'
    );
    return $google_faces;
}


function font_sizes() {
	$sizes = range( 9, 60 );
	$sizes = apply_filters( 'of_recognized_font_sizes', $sizes );
	$sizes = array_map( null, $sizes );
	
	$sizes = array_merge(array('-'=>'Font Size'),$sizes);
	return $sizes;
}

function font_styles() {
	$styles = array(
	    '-'      => __( 'Font Styles', NECTAR_THEME_NAME ),
	    '300'      => __( 'Book', NECTAR_THEME_NAME ),
		'400'      => __( 'Normal', NECTAR_THEME_NAME ),
		'400-italic'    => __( 'Italic', NECTAR_THEME_NAME ),
		'600' => __( 'Semi-Bold', NECTAR_THEME_NAME ),
		'700'      => __( 'Bold', NECTAR_THEME_NAME )
		);
	return apply_filters( 'font_styles', $styles );
}

$typography_options = array(
	'sizes' => font_sizes(),
	'styles' => font_styles()
);

$sizes = $typography_options['sizes'];
$styles = $typography_options['styles'];


$font_sizes = null;
$font_styles = null;

$count = 0;
foreach ( $sizes as $size ) {
	$count++;
	
	($count == 1) ? $font_sizes['-'] = $size : $font_sizes[$size.'px'] = $size . 'px';

}

foreach ( $styles as $weight => $style) {
	$font_styles[$weight] = $style;
}



$typography_mixed_fonts = array_merge( options_typography_get_os_fonts() , options_typography_get_google_fonts() );
asort($typography_mixed_fonts);

$typography_mixed_fonts = array_merge(array('-'=>'Font Family'),$typography_mixed_fonts); 
 



//processing 
$options = get_option('salient'); 

if ( !function_exists( 'options_typography_google_fonts' ) ) {
	function options_typography_google_fonts() {
		
		$all_google_fonts = array_keys( options_typography_get_google_fonts() );
		
		global $options;
		
		$body = $options['body_font'];
		$navigation = $options['navigation_font'];
		$navigation_dropdown = $options['navigation_dropdown_font'];
		$home_slider_caption = $options['home_slider_caption_font'];
		$standard_header = $options['standard_h_font'];
		$sidebar_carousel_footer_header = $options['sidebar_footer_h_font'];
		$team_member_names = $options['team_member_h_font'];
		
		//$google_mixed = of_get_option('google_mixed', false);
		//$google_mixed_2 = of_get_option('google_mixed_2', 'Arvo, serif');

		// Get the font face for each option and put it in an array
		$selected_fonts = array(
			$body , 
			$navigation , 
			$navigation_dropdown , 
			$home_slider_caption , 
			$standard_header  , 
			$sidebar_carousel_footer_header , 
			$team_member_names 
		);
		
		$locations = array(
			'body_font' , 
			'navigation_font' , 
			'navigation_dropdown_font' , 
			'home_slider_caption_font' , 
			'standard_h_font'  , 
			'sidebar_footer_h_font' , 
			'team_member_h_font'
		);
		
		// Remove any duplicates in the list
		//$selected_fonts = array_unique($selected_fonts);
		// Check each of the unique fonts against the defined Google fonts
		// If it is a Google font, go ahead and call the function to enqueue it
		$count = 0;
		foreach ( $selected_fonts as $font) {
			if ( in_array( $font, $all_google_fonts ) ) {
				options_typography_enqueue_google_font($font,$locations[$count]);
			}
			
			$count++;
		}
	}
}

if(!empty($options['use-custom-fonts']) && $options['use-custom-fonts'] == 1){
	add_action( 'wp_enqueue_scripts', 'options_typography_google_fonts' );	
}



function options_typography_enqueue_google_font($font, $location) {
	

	$font = explode(',', $font);
	$font = $font[0];

	$font = str_replace(" ", "+", $font);
	
	global $options;
	
	//handle font styles
	
	$enqueued_fonts_with_weight[] = '';
	$enqueued_fonts[] = '';
	
	if(!empty($options[$location.'_style']) ) {
		
		$weight = null;
		if($options[$location.'_style'] == '-') 
			$weight = '400';
		else 
			$weight = $options[$location.'_style'];

		
		if(!in_array($font.'-'.$weight, $enqueued_fonts_with_weight)){
			//latin chars?
			if(!empty($options['include-latin-chars']) && $options['include-latin-chars'] == 1 ) {
				wp_enqueue_style( "options_typography_$font-$weight", "https://fonts.googleapis.com/css?family=$font:$weight&subset=latin,latin-ext", false, null, 'all' );
			}
			else {
				wp_enqueue_style( "options_typography_$font-$weight", "https://fonts.googleapis.com/css?family=$font:$weight", false, null, 'all' );
			}
		}// in array check
		$enqueued_fonts_with_weight[] = $font.'-'.$weight;
	}

	//else {
		
	//	if(!in_array($font, $enqueued_fonts)){
	//		wp_enqueue_style( "options_typography_$font", "http://fonts.googleapis.com/css?family=$font", false, null, 'all' );
	//	}
	//	$enqueued_fonts[] = $font;
		
	//}

}

?>