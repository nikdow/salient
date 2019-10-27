<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post-content">
		
		<?php if( !is_single() ) { ?>
			
			<?php 
			$extra_class = '';
			if (!has_post_thumbnail()) $extra_class = 'no-img'; 
			?>
			
			<div class="post-meta <?php echo $extra_class; ?>">
				
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
			
			<?php if ( has_post_thumbnail() ) {
				
				 if( !is_single() ) {  echo '<a class="post-featured-img" href="' . get_permalink() . '">'; }
				 
				 echo get_the_post_thumbnail($post->ID, 'full', array('title' => ''));
				 
				 if( !is_single() ) {  echo'</a>'; }
				  
			} ?>
		
			<?php if( !is_single() ) { ?> <a href="<?php the_permalink(); ?>"> <?php } ?>
				
				<div class="status-inner">
					<h2 class="title"><?php the_content('<span class="continue-reading">'. __("Read More", NECTAR_THEME_NAME) . '</span>'); ?></h2>
			    	<span class="destination"> Status posted by <?php the_author(); ?></span>
			    	<span title="Status" class="icon"></span>
				</div><!--/link-inner-->
			
			<?php if( !is_single() ) { ?> </a> <?php } ?>
			
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