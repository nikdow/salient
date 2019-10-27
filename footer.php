<?php 

$options = get_option('salient'); 
global $post;
$cta_link = ( !empty($options['cta-btn-link']) ) ? $options['cta-btn-link'] : '#';

$exclude_pages = (!empty($options['exclude_cta_pages'])) ? $options['exclude_cta_pages'] : array(); 
if(!empty($options['cta-text']) && current_page_url() != $cta_link && !in_array($post->ID, $exclude_pages)) { ?>
	
<div id="call-to-action">
	<div class="container">
		<div class="triangle"></div>
		<span> <?php echo $options['cta-text']; ?> </span>
		<a href="<?php echo $cta_link ?>"><?php if(!empty($options['cta-btn'])) echo $options['cta-btn']; ?> </a>
	</div>
</div>

<?php } ?>

<div id="footer-outer">
	
	<?php if( !empty($options['enable-main-footer-area']) && $options['enable-main-footer-area'] == 1) { ?>
		
	<div id="footer-widgets">
		
		<div class="container">
			
			<div class="row">
				
				<div class="col span_3">
					
				      <!-- Footer widget area 1 -->
		              <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 1') ) : else : ?>	
		              	  <div class="widget">		
						  	 <h4 class="widgettitle">Widget Area 1</h4>
						 	 <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at ultricies lacus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce porta, odio eget gravida laoreet, felis enim rutrum massa, sit amet aliquet mi lacus id eros. Suspendisse aliquet.</p>
				     	  </div>
				     <?php endif; ?>
				</div><!--/span_3-->
				
				<div class="col span_3">
					 <!-- Footer widget area 2 -->
		             <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 2') ) : else : ?>	
		                  <div class="widget">			
						 	 <h4 class="widgettitle">Widget Area 2</h4>
						 	 <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at ultricies lacus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce porta, odio eget gravida laoreet, felis enim rutrum massa, sit amet aliquet mi lacus id eros. Suspendisse aliquet.</p>
				     	  </div>
				     <?php endif; ?>
				     
				</div><!--/span_3-->
				
				<div class="col span_3">
					 <!-- Footer widget area 3 -->
		              <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 3') ) : else : ?>		
		              	  <div class="widget">			
						  	<h4 class="widgettitle">Widget Area 3</h4>
						  	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at ultricies lacus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce porta, odio eget gravida laoreet, felis enim rutrum massa, sit amet aliquet mi lacus id eros. Suspendisse aliquet.</p>
						  </div>		   
				     <?php endif; ?>
				     
				</div><!--/span_3-->
				
				<div class="col span_3 col_last">
					 <!-- Footer widget area 4 -->
		              <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 4') ) : else : ?>	
		              	<div class="widget">		
						    <h4>Widget Area 4</h4>
						    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at ultricies lacus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce porta, odio eget gravida laoreet, felis enim rutrum massa, sit amet aliquet mi lacus id eros. Suspendisse aliquet.</p>
						 </div><!--/widget-->	
				     <?php endif; ?>
				     
				</div><!--/span_3-->
				
			</div><!--/row-->
			
		</div><!--/container-->
	
	</div><!--/footer-widgets-->
	
	<?php } //endif for enable main footer area?>
		
		<div class="row" id="copyright">
			
			<div class="container">
				
				<div class="col span_5">
					<p>&copy; <?php echo date('Y') . ' ' . get_bloginfo('name'); ?>. <?php if(!empty($options['footer-copyright-text'])) echo $options['footer-copyright-text']; ?> </p>
				</div><!--/span_6-->
				
				<div class="col span_7 col_last">
					<ul id="social">
						<?php  if(!empty($options['use-twitter-icon']) && $options['use-twitter-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['twitter-url']; ?>"><i class="icon-twitter"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-facebook-icon']) && $options['use-facebook-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['facebook-url']; ?>"><i class="icon-facebook"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-vimeo-icon']) && $options['use-vimeo-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['vimeo-url']; ?>" class="vimeo">vimeo </a></li> <?php } ?>
						<?php  if(!empty($options['use-pinterest-icon']) && $options['use-pinterest-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['pinterest-url']; ?>"><i class="icon-pinterest"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-linkedin-icon']) && $options['use-linkedin-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['linkedin-url']; ?>"><i class="icon-linkedin"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-youtube-icon']) && $options['use-youtube-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['youtube-url']; ?>"><i class="icon-youtube"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-tumblr-icon']) && $options['use-tumblr-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['tumblr-url']; ?>"><i class="icon-tumblr"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-dribbble-icon']) && $options['use-dribbble-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['dribbble-url']; ?>"><i class="icon-dribbble"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-rss-icon']) && $options['use-rss-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo (!empty($options['rss-url'])) ? $options['rss-url'] : get_bloginfo('rss_url'); ?>"><i class="icon-rss"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-github-icon']) && $options['use-github-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['github-url']; ?>"><i class="icon-github-alt"></i></a></li> <?php } ?>
						<?php  if(!empty($options['use-behance-icon']) && $options['use-behance-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['behance-url']; ?>" class="behance">behance </a></li> <?php } ?>
						<?php  if(!empty($options['use-google-plus-icon']) && $options['use-google-plus-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['google-plus-url']; ?>"><i class="icon-google-plus"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-instagram-icon']) && $options['use-instagram-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['instagram-url']; ?>"><i class="icon-instagram"></i></a></li> <?php } ?>
						<?php  if(!empty($options['use-stackexchange-icon']) && $options['use-stackexchange-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['stackexchange-url']; ?>"><i class="icon-stackexchange"></i></a></li> <?php } ?>
					</ul>
				</div><!--/span_6-->
			
			</div><!--/container-->
			
		</div><!--/row-->
		
	
</div><!--/footer-outer-->

<?php if(!empty($options['boxed_layout']) && $options['boxed_layout'] == '1') { echo '</div>'; } ?>

<?php if(!empty($options['back-to-top']) && $options['back-to-top'] == 1) { ?>
	<a id="to-top"><i class="icon-angle-up"></i></a>
<?php } ?>

<?php if(!empty($options['google-analytics'])) echo $options['google-analytics']; ?> 

<?php wp_footer(); ?>	



</body>
</html>