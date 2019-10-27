<?php get_header(); ?>

<?php nectar_page_header(get_option('page_for_posts')); ?>

<div class="container-wrap">
		
	<div class="container main-content">
		
		<?php if(!is_home()) { ?>
			<div class="row">
				<div class="col span_12 section-title blog-title">
					<h1><?php wp_title("",true); ?></h1>
				</div>
			</div>
		<?php } ?>
		
		<div class="row">
			
			<?php $options = get_option('salient'); 
			
			$blog_type = $options['blog_type'];
			if($blog_type == null) $blog_type = 'std-blog-sidebar';
			
			$masonry_class = null;
			
			//enqueue masonry script if selected
			if($blog_type == 'masonry-blog-sidebar' || $blog_type == 'masonry-blog-fullwidth') {
				wp_enqueue_script('blogmasonry');
				$masonry_class = 'masonry';
			}
			
			if($blog_type == 'std-blog-sidebar' || $blog_type == 'masonry-blog-sidebar'){
				echo '<div id="post-area" class="col span_9 '.$masonry_class.'">';
			} else {
				echo '<div id="post-area" class="col span_12 col_last '.$masonry_class.'">';
			}
	
				if(have_posts()) : while(have_posts()) : the_post(); ?>
					
					<?php 
					$wp_version = floatval(get_bloginfo('version'));
		
					if ( $wp_version < "3.6" ) {
						//old post formats before they got built into the core
						 get_template_part( 'includes/post-templates-pre-3-6/entry', get_post_format() ); 
					} else {
						//WP 3.6+ post formats
						 get_template_part( 'includes/post-templates/entry', get_post_format() ); 
					} ?>
	
				<?php endwhile; endif; ?>
				
				<?php nectar_pagination(); ?>
				
			</div><!--/span_9-->
			
			<?php  if($blog_type == 'std-blog-sidebar' || $blog_type == 'masonry-blog-sidebar') { ?>
				<div id="sidebar" class="col span_3 col_last">
					<?php get_sidebar(); ?>
				</div><!--/span_3-->
			<?php } ?>
			
		</div><!--/row-->
		
	</div><!--/container-->

</div><!--/container-wrap-->
	
<?php get_footer(); ?>