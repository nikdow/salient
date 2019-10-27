<article class="post video">
	
	<div class="post-content">
		
		<?php if( !is_single() ) { ?>
				
			<div class="post-meta">
				
				<?php $options = get_option('salient'); 
				$blog_type = $options['blog_type']; ?>
				
				<div class="date">
					<?php if($blog_type == 'masonry-blog-sidebar' || $blog_type == 'masonry-blog-fullwidth') {
						echo the_time('F d, Y');
					}
					else { ?>
					
						<span class="month"><?php the_time('M'); ?></span>
						<span class="day"><?php the_time('d'); ?></span>
						<?php $options = get_option('salient'); 
						if(!empty($options['display_full_date']) && $options['display_full_date'] == 1) {
							echo '<span class="year">'. get_the_time('Y') .'</span>';
						}
					} ?>
				</div><!--/date-->
				
				<div class="nectar-love-wrap">
					<?php if( function_exists('nectar_love') ) nectar_love(); ?>
				</div><!--/nectar-love-wrap-->	
							
			</div><!--/post-meta-->
			
		<?php } ?>
		
		<div class="content-inner">
				
			<?php  
				  $video_embed = get_post_meta($post->ID, '_nectar_video_embed', true);
				  $video_m4v = get_post_meta($post->ID, '_nectar_video_m4v', true);
				  $video_ogv = get_post_meta($post->ID, '_nectar_video_ogv', true); 
				  $video_poster = get_post_meta($post->ID, '_nectar_video_poster', true); 
				  
				  if( !empty($video_embed) || !empty($video_m4v) ){

		             $wp_version = floatval(get_bloginfo('version'));
								
					//video embed
					if( !empty( $video_embed ) ) {
						
			             echo '<div class="video">' . do_shortcode($video_embed) . '</div>';
						
			        } 
			        //self hosted video pre 3-6
			        else if( !empty($video_m4v) && $wp_version < "3.6") {
			        	
			        	 echo '<div class="video">'; 
			            	 nectar_video($post->ID); 
						 echo '</div>'; 
						 
			        } 
			        //self hosted video post 3-6
			        else if($wp_version >= "3.6"){
		
			        	if(!empty($video_m4v) || !empty($video_ogv)) {
			        		
							$video_output = '[video ';
							
							if(!empty($video_m4v)) { $video_output .= 'mp4="'. $video_m4v .'" '; }
							if(!empty($video_ogv)) { $video_output .= 'ogv="'. $video_ogv .'"'; }
							
							$video_output .= ' poster="'.$video_poster.'"]';
							
			        		echo '<div class="video">' . do_shortcode($video_output) . '</div>';	
			        	}
			        }
					
				 }
	             
	        ?>
	        
	        <?php if( !is_single() ) { ?> 
				<div class="post-header">
					<h2 class="title"><?php if( !is_single() ) { ?> <a href="<?php the_permalink(); ?>"><?php } ?><?php the_title(); ?><?php if( !is_single() ) {?> </a> <?php } ?></h2>	
				</div><!--/post-header-->
			<?php 
			
				//if no excerpt is set
				global $post;
				if(empty( $post->post_excerpt )) {
					the_content('<span class="continue-reading">'. __("Read More", NECTAR_THEME_NAME) . '</span>');
				}
				
				//excerpt
				else {
					echo '<div class="excerpt">';
						the_excerpt();
					echo '</div>';
					echo '<a class="more-link" href="' . get_permalink() . '"><span class="continue-reading">Read More</span></a>';
				}
				
				?>
			
			<?php } ?>
			
		   
			<?php 
			if(is_single()){
				//on the single post page display the content
				the_content('<span class="continue-reading">'. __("Read More", NECTAR_THEME_NAME) . '</span>');
			} ?>
			
			<?php $options = get_option('salient');
				if( $options['display_tags'] == true ){
					 
					if( is_single() && has_tag() ) {
					
						echo '<div class="post-tags"><h4>Tags: </h4>'; 
						the_tags('','','');
						echo '<div class="clear"></div></div> ';
						
					}
				}
			?>
			
		</div><!--/content-inner-->
		
	</div><!--/post-content-->
		
</article><!--/article-->