<?php 
/*template name: Contact*/
get_header(); ?>


<?php nectar_page_header($post->ID);  ?>

<?php 
$options = get_option('salient'); 

$map_data = null;
$count = 0;

for($i = 1; $i <= 10; $i++){
	if(!empty($options['map-point-'.$i]) && $options['map-point-'.$i] != 0 ) {
		$count++;
		$map_data[$count]['lat'] = $options['latitude'.$i];
		$map_data[$count]['lng'] = $options['longitude'.$i];
		$map_data[$count]['mapinfo'] = $options['map-info'.$i];
	}	
}

function json_map_data() {
	global $map_data; 
	return $map_data;
}

wp_localize_script( 'nectarMap', 'map_data', json_map_data() );

?>

<div class="container-wrap">

	<div class="container main-content">
		
		<div class="row">
	
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
				
				<?php the_content(); ?>
	
			<?php endwhile; endif; ?>
				
	
		</div><!--/row-->
		
	</div><!--/container-->

</div>
<?php get_footer(); ?>