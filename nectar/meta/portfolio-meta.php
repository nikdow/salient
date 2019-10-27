<?php


#-----------------------------------------------------------------#
# Create the Portfolio meta boxes
#-----------------------------------------------------------------# 

add_action('add_meta_boxes', 'nectar_metabox_portfolio');
function nectar_metabox_portfolio(){
    
	
	$wp_version = floatval(get_bloginfo('version'));
	
	#-----------------------------------------------------------------#
	# Project Configuration
	#-----------------------------------------------------------------# 
	if ( $wp_version < "3.6" ) {
		$meta_box = array(
			'id' => 'nectar-metabox-custom-thummbnail',
			'title' =>  __('Project Configuration', NECTAR_THEME_NAME),
			'description' => __('', NECTAR_THEME_NAME),
			'post_type' => 'portfolio',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
	    		array( 
					'name' => __('Custom Thumbnail Image', NECTAR_THEME_NAME),
					'desc' => __('If you would like to have a separate thumbnail for your portfolio item, upload it here. If left blank, a cropped version of your featured image will be automatically used instead. The recommended dimensions are 600px by 403px.', NECTAR_THEME_NAME),
					'id' => '_nectar_portfolio_custom_thumbnail',
					'type' => 'file',
					'std' => ''
				)
			)
		);
	} 
	
	else {
		
		$meta_box = array(
			'id' => 'nectar-metabox-project-configuration',
			'title' =>  __('Project Configuration', NECTAR_THEME_NAME),
			'description' => __('', NECTAR_THEME_NAME),
			'post_type' => 'portfolio',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array( 
						'name' => __('Full Width Portfolio Item Layout', NECTAR_THEME_NAME),
						'desc' => __('This will remove the sidebar and allow you to use fullwidth sections and sliders', NECTAR_THEME_NAME),
						'id' => '_nectar_portfolio_item_layout',
						'type' => 'choice_below',
						'options' => array(
							'disabled' => 'Disabled',
							'enabled' => 'Enabled'
						),
						'std' => 'disabled'
				),
	    		array( 
					'name' => __('Custom Thumbnail Image', NECTAR_THEME_NAME),
					'desc' => __('If you would like to have a separate thumbnail for your portfolio item, upload it here. If left blank, a cropped version of your featured image will be automatically used instead. The recommended dimensions are 600px by 403px.', NECTAR_THEME_NAME),
					'id' => '_nectar_portfolio_custom_thumbnail',
					'type' => 'file',
					'std' => ''
				),
				array(
					'name' =>  __('Hide Featured Image/Video on Single Project Page?', NECTAR_THEME_NAME),
					'desc' => __('You can choose to hide your featured image/video from automatically displaying on the top of the main project page.', NECTAR_THEME_NAME),
					'id' => '_nectar_hide_featured',
					'type' => 'checkbox',
	                'std' => 1
				),
				array(
					'name' =>  __('Gallery Slider', NECTAR_THEME_NAME),
					'desc' => __('This will turn all default WordPress galleries attached to this post into a simple slider.', NECTAR_THEME_NAME),
					'id' => '_nectar_gallery_slider',
					'type' => 'checkbox',
	                'std' => 1
				)
			)
		);

	}//endif

	$callback = create_function( '$post,$meta_box', 'nectar_create_meta_box( $post, $meta_box["args"] );' );
	add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
	
		
	#-----------------------------------------------------------------#
	# Extra Content
	#-----------------------------------------------------------------# 
	$meta_box = array(
		'id' => 'nectar-metabox-portfolio-extra',
		'title' =>  __('Extra Content', NECTAR_THEME_NAME),
		'description' => __('Please use this section to place any extra content you would like to appear in the main content area under your portfolio item.', NECTAR_THEME_NAME),
		'post_type' => 'portfolio',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
    		array( 
				'name' => '',
				'desc' => '',
				'id' => '_nectar_portfolio_extra_content',
				'type' => 'editor',
				'std' => ''
			),
		)
	);
	

	add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
	
	
  

    #-----------------------------------------------------------------#
	# Video 
	#-----------------------------------------------------------------#
		
	
    $meta_box = array( 
		'id' => 'nectar-metabox-portfolio-video',
		'title' => __('Video Settings', NECTAR_THEME_NAME),
		'description' => __('If you have a video, please fill out the fields below.', NECTAR_THEME_NAME),
		'post_type' => 'portfolio',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
					'name' => __('M4V File URL', NECTAR_THEME_NAME),
					'desc' => __('Please upload the .m4v video file. <br/><strong>You must include both formats.</strong>', NECTAR_THEME_NAME),
					'id' => '_nectar_video_m4v',
					'type' => 'media',
					'std' => ''
				),
			array( 
					'name' => __('OGV File URL', NECTAR_THEME_NAME),
					'desc' => __('Please upload the .ogv video file. <br/><strong>You must include both formats.</strong>', NECTAR_THEME_NAME),
					'id' => '_nectar_video_ogv',
					'type' => 'media',
					'std' => ''
				),
			array( 
					'name' => __('Video Height', NECTAR_THEME_NAME),
					'desc' => __('This only needs to be filled out if your self hosted video is not in a 16:9 aspect ratio. Enter your height based on an 845px width. This is used to calculate the iframe height for the "Watch Video" link. <br/> <strong>Don\'t include "px" in the string. e.g. 480</strong>', NECTAR_THEME_NAME),
					'id' => '_nectar_video_height',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Preview Image', NECTAR_THEME_NAME),
					'desc' => __('Image should be at least 680px wide. Click the "Upload" button to begin uploading your image, followed by "Select File" once you have made your selection. Only applies to self hosted videos.', NECTAR_THEME_NAME),
					'id' => '_nectar_video_poster',
					'type' => 'file',
					'std' => ''
				),
			array(
					'name' => __('Embedded Code', NECTAR_THEME_NAME),
					'desc' => __('If the video is an embed rather than self hosted, enter in a Youtube or Vimeo embed code here. The width should be a minimum of 670px with any height.', NECTAR_THEME_NAME),
					'id' => '_nectar_video_embed',
					'type' => 'textarea',
					'std' => ''
				)
		)
	);


	add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );


}