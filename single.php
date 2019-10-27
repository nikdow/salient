<?php get_header(); ?>

<div class="container-wrap">
	
	<div class="container main-content">
		
		<?php if(get_post_format() != 'quote' && get_post_format() != 'status' && get_post_format() != 'aside') { ?>
			
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
				<div class="row">
					<div class="col span_12 section-title blog-title">
						<h1><?php wp_title("",true); ?></h1>
						

						
						<div id="single-meta" data-sharing="<?php echo ( !empty($options['blog_social']) && $options['blog_social'] == 1 ) ? '1' : '0'; ?>">
							<ul>

								<?php if( empty($options['blog_social']) || $options['blog_social'] == 0 ) { ?>
									   	
									   	<li>
									   		<?php echo '<span class="n-shortcode">'.nectar_love('return').'</span>'; ?>
									   	</li>
										<li>
											<?php the_time('F d, Y'); ?>
										</li>
								
								<?php } ?>
	
							</ul>
							
							<?php if( !empty($options['blog_social']) && $options['blog_social'] == 1 ) { 
								   
								   echo '<div class="nectar-social">';
								   
								   echo '<span class="n-shortcode">'.nectar_love('return').'</span>';
								   
									//facebook
									if(!empty($options['blog-facebook-sharing']) && $options['blog-facebook-sharing'] == 1) { 
										echo "<a class='facebook-share nectar-sharing' href='#' title='Share this'> <i class='icon-facebook'></i> <span class='count'></span></a>";
									}
									//twitter
									if(!empty($options['blog-twitter-sharing']) && $options['blog-twitter-sharing'] == 1) {
										echo "<a class='twitter-share nectar-sharing' href='#' title='Tweet this'> <i class='icon-twitter'></i> <span class='count'></span></a>";
									}
									//pinterest
									if(!empty($options['blog-pinterest-sharing']) && $options['blog-pinterest-sharing'] == 1) {
										echo "<a class='pinterest-share nectar-sharing' href='#' title='Pin this'> <i class='icon-pinterest'></i> <span class='count'></span></a>";
									}
									
								  echo '</div>';

						 		}
							?>
							
						</div><!--/single-meta-->
					</div><!--/section-title-->
				</div><!--/row-->
				
			<?php endwhile; endif; ?>
			
		<?php } ?>
			
		<div class="row">
			
			<?php $options = get_option('salient'); 
			$blog_type = $options['blog_type']; 
			
			if($blog_type == 'std-blog-fullwidth'){
				echo '<div id="post-area" class="col span_12 col_last">';
			} else {
				echo '<div id="post-area" class="col span_9">';
			}
			
				 if(have_posts()) : while(have_posts()) : the_post(); 
					
					
					$wp_version = floatval(get_bloginfo('version'));
		
					if ( $wp_version < "3.6" ) {
						//old post formats before they got built into the core
						 get_template_part( 'includes/post-templates-pre-3-6/entry', get_post_format() ); 
					} else {
						//WP 3.6+ post formats
						 get_template_part( 'includes/post-templates/entry', get_post_format() ); 
					} 
	
				 endwhile; endif; 
				
				 wp_link_pages(); 
				
				    $options = get_option('salient');
					if( !empty($options['author_bio']) && $options['author_bio'] == true ){ 
						$grav_size = 80;
					?>
						
						<div id="author-bio">
							<?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), $grav_size ); }?>
							<div id="author-info">
								<h3>About <?php the_author(); ?></h3>
								<p><?php the_author_meta('description'); ?></p>
							</div>
							
							<div class="clear"></div>
							
						</div>
						
				<?php } ?>
				
				<div class="comments-section">
	   			   <?php comments_template(); ?>
				 </div>   
				 
			</div><!--/span_9-->
			
			<?php if($blog_type != 'std-blog-fullwidth') { ?>
				
				<div id="sidebar" class="col span_3 col_last">
					<?php get_sidebar(); ?>
				</div><!--/sidebar-->
				
			<?php } ?>
			
		</div><!--/row-->
		
	</div><!--/container-->

</div><!--/container-wrap-->
	
<?php get_footer(); ?>