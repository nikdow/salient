<?php
/*
Name: NectarLove
Description: Adds a "Love It" link to posts
Author: Phil Martinez | ThemeNectar
Author URI: http://themenectar.com
*/


class NectarLove {
	
	 function __construct()   {	
        add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
        add_action('wp_ajax_nectar-love', array(&$this, 'ajax'));
		add_action('wp_ajax_nopriv_nectar-love', array(&$this, 'ajax'));
	}
	
	function enqueue_scripts() {
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'nectar-love', get_template_directory_uri() . '/nectar/love/js/nectar-love.js', 'jquery', '1.0', TRUE );
		
		wp_localize_script( 'nectar-love', 'nectarLove', array(
			'ajaxurl' => admin_url('admin-ajax.php')
		));
	}
	
	function ajax($post_id) {
		
		//update
		if( isset($_POST['loves_id']) ) {
			$post_id = str_replace('nectar-love-', '', $_POST['loves_id']);
			echo $this->love_post($post_id, 'update');
		} 
		
		//get
		else {
			$post_id = str_replace('nectar-love-', '', $_POST['loves_id']);
			echo $this->love_post($post_id, 'get');
		}
		
		exit;
	}
	
	
	function love_post($post_id, $action = 'get') 
	{
		if(!is_numeric($post_id)) return;
	
		switch($action) {
		
			case 'get':
				$love_count = get_post_meta($post_id, '_nectar_love', true);
				if( !$love_count ){
					$love_count = 0;
					add_post_meta($post_id, '_nectar_love', $love_count, true);
				}
				
				return '<span class="nectar-love-count">'. $love_count .'</span>';
				break;
				
			case 'update':
				$love_count = get_post_meta($post_id, '_nectar_love', true);
				if( isset($_COOKIE['nectar_love_'. $post_id]) ) return $love_count;
				
				$love_count++;
				update_post_meta($post_id, '_nectar_love', $love_count);
				setcookie('nectar_love_'. $post_id, $post_id, time()*20, '/');
				
				return '<span class="nectar-love-count">'. $love_count .'</span>';
				break;
		
		}
	}


	function add_love() {
		global $post;

		$output = $this->love_post($post->ID);
  
  		$class = 'nectar-love';
  		$title = __('Love this', NECTAR_THEME_NAME);
		if( isset($_COOKIE['nectar_love_'. $post->ID]) ){
			$class = 'nectar-love loved';
			$title = __('You already love this!', NECTAR_THEME_NAME);
		}
		
		return '<a href="#" class="'. $class .'" id="nectar-love-'. $post->ID .'" title="'. $title .'"> <i class="icon-salient-heart"></i> '. $output .'</a>';
	}
	
}


global $nectar_love;
$nectar_love = new NectarLove();

// get the ball rollin' 
function nectar_love($return = '') {
	
	global $nectar_love;

	if($return == 'return') {
		return $nectar_love->add_love(); 
	} else {
		echo $nectar_love->add_love(); 
	}
	
}

?>
