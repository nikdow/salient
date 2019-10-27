<?php 
add_action('add_meta_boxes', 'nectar_metabox_page');
function nectar_metabox_page(){
    
	#-----------------------------------------------------------------#
	# Header Settings
	#-----------------------------------------------------------------#
    $meta_box = array(
		'id' => 'nectar-metabox-page-header',
		'title' => __('Page Header Settings', NECTAR_THEME_NAME),
		'description' => __('Here you can configure how your page header will appear. <br/> For a full width background image behind your header text, simply upload the image below. To have a standard header just fill out the fields below and don\'t upload an image.', NECTAR_THEME_NAME),
		'post_type' => 'page',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
					'name' => __('Page Header Image', NECTAR_THEME_NAME),
					'desc' => __('The image should be between 1600px - 2000px wide and have a minimum height of 475px for best results. Click "Browse" to upload and then "Insert into Post".', NECTAR_THEME_NAME),
					'id' => '_nectar_header_bg',
					'type' => 'file',
					'std' => ''
				),
			array(
					'name' =>  __('Parallax Header?', NECTAR_THEME_NAME),
					'desc' => __('If you would like your header to have a parallax scroll effect check this box.', NECTAR_THEME_NAME),
					'id' => '_nectar_header_parallax',
					'type' => 'checkbox',
	                'std' => 1
				),	
			array( 
					'name' => __('Page Header Height', NECTAR_THEME_NAME),
					'desc' => __('How tall do you want your header? <br/>Don\'t include "px" in the string. e.g. 350 <br/><strong>This only applies when you are using an image.</strong>', NECTAR_THEME_NAME),
					'id' => '_nectar_header_bg_height',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Page Header Title', NECTAR_THEME_NAME),
					'desc' => __('Enter in the page header title', NECTAR_THEME_NAME),
					'id' => '_nectar_header_title',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Page Header Subtitle', NECTAR_THEME_NAME),
					'desc' => __('Enter in the page header subtitle', NECTAR_THEME_NAME),
					'id' => '_nectar_header_subtitle',
					'type' => 'text',
					'std' => ''
				)
			/*array( 
					'name' => __('Text Alignment', NECTAR_THEME_NAME),
					'desc' => __('Choose how you would like your header text to be aligned', NECTAR_THEME_NAME),
					'id' => '_nectar_page_header_alignment',
					'type' => 'choice_below',
					'options' => array(
						'left' => 'Left',
						'center' => 'Center',
						'right' => 'Right'
					),
					'std' => 'left'
				),*/
		)
	);
	$callback = create_function( '$post,$meta_box', 'nectar_create_meta_box( $post, $meta_box["args"] );' );
	add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
	
	
	#-----------------------------------------------------------------#
	# Portfolio Display Settings
	#-----------------------------------------------------------------#
	$portfolio_types = get_terms('project-type');

	$types_options = array("all" => "All");
	
	foreach ($portfolio_types as $type) {
		$types_options[$type->slug] = $type->name;
	}
			
    $meta_box = array(
		'id' => 'nectar-metabox-portfolio-display',
		'title' => __('Portfolio Display Settings', NECTAR_THEME_NAME),
		'description' => __('Here you can configure which categories will display in your portfolio.', NECTAR_THEME_NAME),
		'post_type' => 'page',
		'context' => 'side',
		'priority' => 'core',
		'fields' => array(
			array( 
					'name' => 'Portfolio Categories',
					'desc' => '',
					'id' => 'nectar-metabox-portfolio-display',
					'type' => 'multi-select',
					'options' => $types_options,
					'std' => 'all'
				),
			array( 
					'name' => 'Display Sortable',
					'desc' => 'Should these portfolio items be sortable?',
					'id' => 'nectar-metabox-portfolio-display-sortable',
					'type' => 'checkbox',
					'std' => '1'
				)
		)
	);
	$callback = create_function( '$post,$meta_box', 'nectar_create_meta_box( $post, $meta_box["args"] );' );
	add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
	
	
}


?>