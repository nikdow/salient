<?php 

	
	add_action('add_meta_boxes', 'nectar_metabox_posts');
	function nectar_metabox_posts(){
		
		$wp_version = floatval(get_bloginfo('version'));
		
		if ( $wp_version < "3.6" ) { 

			#-----------------------------------------------------------------#
			# Gallery
			#-----------------------------------------------------------------# 
			$meta_box = array(
				'id' => 'nectar-metabox-post-gallery',
				'title' =>  __('Gallery Settings', NECTAR_THEME_NAME),
				'description' => __('Please use the sections that have appeared under the Featured Image block labeled "Second Slide, Third Slide..." etc to add images to your gallery.', NECTAR_THEME_NAME),
				'post_type' => 'post',
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(
		    		
				)
			);
			$callback = create_function( '$post,$meta_box', 'nectar_create_meta_box( $post, $meta_box["args"] );' );
			add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		} else {
			
		
			$meta_box = array(
				'id' => 'nectar-metabox-post-gallery',
				'title' =>  __('Gallery Configuration', NECTAR_THEME_NAME),
				'description' => 'Once you\'ve inserted a WordPress gallery using the "Add Media" button above, you can use the gallery slider checkbox below to transform your images into a slider.',
				'post_type' => 'post',
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(
					array(
							'name' =>  __('Gallery Slider', NECTAR_THEME_NAME),
							'desc' => __('Would you like to turn your gallery into a slider?', NECTAR_THEME_NAME),
							'id' => '_nectar_gallery_slider',
							'type' => 'checkbox',
		                    'std' => 1
						)
				)
			);
			$callback = create_function( '$post,$meta_box', 'nectar_create_meta_box( $post, $meta_box["args"] );' );
		    add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );

		}
		
		
		#-----------------------------------------------------------------#
		# Quote
		#-----------------------------------------------------------------# 
	    $meta_box = array(
			'id' => 'nectar-metabox-post-quote',
			'title' =>  __('Quote Settings', NECTAR_THEME_NAME),
			'description' => '',
			'post_type' => 'post',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array(
						'name' =>  __('Quote Content', NECTAR_THEME_NAME),
						'desc' => __('Please type the text for your quote here.', NECTAR_THEME_NAME),
						'id' => '_nectar_quote',
						'type' => 'textarea',
	                    'std' => ''
					)
			)
		);
	    add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		
		#-----------------------------------------------------------------#
		# Link
		#-----------------------------------------------------------------# 
		$meta_box = array(
			'id' => 'nectar-metabox-post-link',
			'title' =>  __('Link Settings', NECTAR_THEME_NAME),
			'description' => '',
			'post_type' => 'post',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array(
						'name' =>  __('Link URL', NECTAR_THEME_NAME),
						'desc' => __('Please input the URL for your link. I.e. http://www.themenectar.com', NECTAR_THEME_NAME),
						'id' => '_nectar_link',
						'type' => 'text',
						'std' => ''
					)
			)
		);
	    add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
	    
		#-----------------------------------------------------------------#
		# Video
		#-----------------------------------------------------------------# 
	    $meta_box = array(
			'id' => 'nectar-metabox-post-video',
			'title' => __('Video Settings', 'nectar'),
			'description' => '',
			'post_type' => 'post',
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
						'desc' => __('Please upload the .ogv video file  <br/><strong>You must include both formats.</strong>', NECTAR_THEME_NAME),
						'id' => '_nectar_video_ogv',
						'type' => 'media',
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
						'desc' => __('If the video is an embed rather than self hosted, enter in a Vimeo or Youtube embed code here. <strong> Embeds work worse with the parallax effect, but if you must use this, Vimeo is recommended. </strong> ', NECTAR_THEME_NAME),
						'id' => '_nectar_video_embed',
						'type' => 'textarea',
						'std' => ''
					)
			)
		);
		add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		
		#-----------------------------------------------------------------#
		# Audio
		#-----------------------------------------------------------------# 
		$meta_box = array(
			'id' => 'nectar-metabox-post-audio',
			'title' =>  __('Audio Settings', NECTAR_THEME_NAME),
			'description' => '',
			'post_type' => 'post',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array( 
					'name' => __('MP3 File URL', NECTAR_THEME_NAME),
					'desc' => __('Please enter in the URL to the .mp3 file', NECTAR_THEME_NAME),
					'id' => '_nectar_audio_mp3',
					'type' => 'text',
					'std' => ''
				),
				array( 
						'name' => __('OGA File URL', NECTAR_THEME_NAME),
						'desc' => __('Please enter in the URL to the .ogg or .oga file', NECTAR_THEME_NAME),
						'id' => '_nectar_audio_ogg',
						'type' => 'text',
						'std' => ''
					)
			)
		);
		add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
	}




?>