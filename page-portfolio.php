<?php 
/*template name: Portfolio */
get_header(); 

$options = get_option('salient');  

$cols = (!empty($options['main_portfolio_layout'])) ? $options['main_portfolio_layout'] : '3' ;
$span_num = (!empty($cols) && $cols == '3') ? '4' : '3';
$project_style = (!empty($options['main_portfolio_project_style'])) ? $options['main_portfolio_project_style'] : '1' ;
?>

<script>
	jQuery(document).ready(function($){
	
	    var $container = $('#portfolio');
	    
	    //load with opacity if fade in is off
	    if($('#portfolio').attr('data-fade') != 1) { $('#portfolio.portfolio-items .col.span_<?php echo $span_num; ?>').css('opacity',1); }
	    
	    //else show the loading gif
	    else { $('.container.main-content').before('<span id="portfolio-loading"><span>'); }
	    
	    var $element = $container;
		if($container.find('img').length == 0) $element = $('body');

		imagesLoaded($element,function(instance){
			
	    	// initialize isotope
			$container.isotope({
			  itemSelector : '.element',
			  filter: '*',
			  layoutMode: 'fitRows'
			});
			
			//fade in
			if($('#portfolio').attr('data-fade') == 1) {
				
				//fadeout the loading animation
				$('#portfolio-loading').stop(true,true).fadeOut(300);
				
				//fadeIn items one by one
				$('#portfolio.portfolio-items .col.span_<?php echo $span_num; ?>').css('opacity',0);
				$('#portfolio.portfolio-items .col.span_<?php echo $span_num; ?>').each(function(i){
					$(this).delay(i*150).animate({'opacity':1},350);
				});
				
			}

	    });
		
		// filter items when filter link is clicked
		$('#portfolio-filters ul li a').click(function(){
		  var selector = $(this).attr('data-filter');
		  $container.isotope({ filter: selector });
		  
		  //active classes
		  $('#portfolio-filters ul li a').removeClass('active');
		  $(this).addClass('active');
		  
		  return false;
		});
		
		$('#portfolio-filters > a').click(function(){
			return false;
		});
		
		$(window).smartresize(function(){
		  $container.isotope({
		   
		  });
		});
		

		//more padding if using header bg on 4 col
		if( $('#page-header-bg').length > 0 && <?php echo $cols; ?> == 4) { $('.container-wrap').css('padding-top','3.3em'); }
				
	});
</script>

<?php nectar_page_header($post->ID); ?>

<div class="container-wrap">
	
	<div class="container" data-col-num="cols-<?php echo $cols; ?>">
	
		
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			
			<div class="container main-content">
				<div class="row">	
					<?php the_content(); ?>
				</div>
			</div>
	
		<?php endwhile; endif;
	
		
		if(!post_password_required()) { ?>
			
			
		<div id="portfolio" class="row portfolio-items" data-fade="<?php echo (!empty($options['portfolio_fade_in']) && $options['portfolio_fade_in'] == 1) ? '1' : '0'; ?>">
			<?php 
			
			$posts_per_page = '-1';
			if(!empty($options['portfolio_pagination']) && $options['portfolio_pagination'] == '1') {
				$posts_per_page = (!empty($options['portfolio_pagination_number'])) ? $options['portfolio_pagination_number'] : '-1';
			}
			
			//get categories 
			global $post;
			$categories = get_post_meta($post->ID, 'nectar-metabox-portfolio-display', true);
			
			$project_categories = null;
			$category_count = 0;
			
			if(!empty($categories)) {
		
				foreach($categories as $key => $slug){
					if($category_count == 0){
						$project_categories .= $slug;
					} else {
						$project_categories .= ', '.$slug;  
					}
					$category_count++;
					
				}
			
			}
			
			//incase only all was selected
			if($project_categories == 'all') {
				$project_categories = null;
			}
			
			$portfolio = array(
				'posts_per_page' => $posts_per_page,
				'post_type' => 'portfolio',
				'project-type'=> $project_categories,
				'paged'=> $paged
			);
			
			$wp_query = new WP_Query($portfolio);
			
			if(have_posts()) : while(have_posts()) : the_post(); ?>
				
				<?php 
					
				   $terms = get_the_terms($post->id,"project-type");
				   $project_cats = NULL;
				   
				   if ( !empty($terms) ){
				     foreach ( $terms as $term ) {
				       $project_cats .= strtolower($term->slug) . ' ';
				     }
				   }
	
				?>
				
				<div class="col span_<?php echo $span_num; ?> element <?php echo $project_cats; ?>" data-project-cat="<?php echo $project_cats; ?>">
					
					<?php //porject style 1
						
						if($project_style == '1') { ?>
							
						<div class="work-item">
							 
							<?php
			 
							//custom thumbnail
							$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
							
							if( !empty($custom_thumbnail) ){
								echo '<img class="custom-thumbnail" src="'.$custom_thumbnail.'" alt="'. get_the_title() .'" />';
							}
							else {
								
								if ( has_post_thumbnail() ) {
									 echo get_the_post_thumbnail($post->ID, 'portfolio-thumb', array('title' => '')); 
								} 
								//no image added
								else {
									 echo '<img src="'.get_template_directory_uri().'/img/no-portfolio-item-small.jpg" alt="no image added yet." />';
								 }   
								
							} ?>
							
							<div class="work-info-bg"></div>
							<div class="work-info"> 
								
								<div class="vert-center">
									<?php 
									
									$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  							
									$video_embed = get_post_meta($post->ID, '_nectar_video_embed', true);
									$video_m4v = get_post_meta($post->ID, '_nectar_video_m4v', true);
									$wp_version = floatval(get_bloginfo('version'));
									//video 
								    if( !empty($video_embed) || !empty($video_m4v) ) {
		
									    if( !empty( $video_embed) && $wp_version < "3.6") {
									    	
									    	echo '<a href="#video-popup-'.$post->ID.'" class="pp">'.__("Watch Video", NECTAR_THEME_NAME).'</a> ';
											echo '<div id="video-popup-'.$post->ID.'">';
									        echo '<div class="video-wrap">' . stripslashes(htmlspecialchars_decode($video_embed)) . '</div>';
											echo '</div>';
									    } 
									    
									    else {
											 echo '<a href="'.get_template_directory_uri(). '/includes/portfolio-functions/video.php?post-id=' .$post->ID.'&iframe=true&width=854" class="pp" >'.__("Watch Video", NECTAR_THEME_NAME).'</a> ';	 
									     }
			
							        } 
									
									//image
								    else {
								       echo '<a href="'. $featured_image[0].'" class="pp">'.__("View Larger", NECTAR_THEME_NAME).'</a> ';
								    }
									
								    echo '<a href="' . get_permalink() . '">'.__("More Details", NECTAR_THEME_NAME).'</a>'; ?>
								    
								</div><!--/vert-center-->
							</div>
						</div><!--work-item-->
						
						<div class="work-meta">
							<h4 class="title"><?php the_title(); ?></h4>
							
							<?php 
								if(!empty($options['portfolio_date']) && $options['portfolio_date'] == 1) the_time('F d, Y');
							?>
		
						</div>
						<div class="nectar-love-wrap">
							<?php if( function_exists('nectar_love') ) nectar_love(); ?>
						</div><!--/nectar-love-wrap-->	
					
					<?php } //project style 1 
					
					
					//project style 2
					else { ?>
						
						<div class="work-item style-2">
							
							<?php
							//custom thumbnail
							$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
							
							if( !empty($custom_thumbnail) ){
								echo '<img class="custom-thumbnail" src="'.$custom_thumbnail.'" alt="'. get_the_title() .'" />';
							}
							else {
								
								if ( has_post_thumbnail() ) {
									 echo get_the_post_thumbnail($post->ID, 'portfolio-thumb', array('title' => '')); 
								} 
								
								//no image added
								else {
									 echo '<img src="'.get_template_directory_uri().'/img/no-portfolio-item-small.jpg" alt="no image added yet." />';
								}   
								
							} ?>
			
							<div class="work-info-bg"></div>
							<div class="work-info">
								
								<i class="icon-salient-plus"></i> 
								
								<a href="<?php echo get_permalink(); ?>"></a>
	
								<div class="vert-center"><h3><?php echo get_the_title(); ?></h3> <p><?php if(!empty($options['portfolio_date']) && $options['portfolio_date'] == 1) the_time('F d, Y'); ?></p></div><!--/vert-center-->
								
							</div>
						</div><!--work-item-->
						
					<?php } //project style 2 ?>
				
				</div><!--/col-->
				
			<?php endwhile; endif; ?>
		</div><!--/portfolio-->
	
		
		<?php 
		 if( !empty($options['portfolio_extra_pagination']) && $options['portfolio_extra_pagination'] == '1' ){
		 	
				    global $wp_query, $wp_rewrite;  
			 
	                $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1; 
				    $total_pages = $wp_query->max_num_pages;  
					
					$permalink_structure = get_option('permalink_structure');
				    $format = empty( $permalink_structure ) ? '&paged=%#%' : 'page/%#%/';  
				    if ($total_pages > 1){  
				      
					  echo '<div id="pagination">';
					   
				      echo paginate_links(array(  
				          'base' => get_pagenum_link(1) .'%_%', 
	    			      'format' => $format,
				          'current' => $current,  
				          'total' => $total_pages,  
				        )); 
						
					  echo  '</div>'; 
						
				    }  
			}
			//regular pagination
			else{
				
				if( get_next_posts_link() || get_previous_posts_link() ) { 
					echo '<div id="pagination">
					      <div class="prev">'.get_previous_posts_link('&laquo; Previous Entries').'</div>
					      <div class="next">'.get_next_posts_link('Next Entries &raquo;','').'</div>
				          </div>';
				
		        }
			}  
		
		}//password protection ?>
		
	</div><!--/container-->

</div><!--/container-wrap-->

<?php get_footer(); ?>