<?php 

function nectar_colors() {
	
	$options = get_option('salient'); 
	
	echo '<style type="text/css">
	
	body a { color: '.$options["accent-color"].'; }
	
	header#top nav ul li a:hover, header#top nav .sf-menu li.sfHover > a, header#top nav .sf-menu li.current-menu-item > a,
	header#top nav .sf-menu li.current_page_item > a .sf-sub-indicator i, header#top nav .sf-menu li.current_page_ancestor > a .sf-sub-indicator i,
	header#top nav ul li a:hover, header#top nav .sf-menu li.sfHover > a, header#top nav .sf-menu li.current_page_ancestor > a, header#top nav .sf-menu li.current-menu-ancestor > a, header#top nav .sf-menu li.current_page_item > a,
	body header#top nav .sf-menu li.current_page_item > a .sf-sub-indicator [class^="icon-"], header#top nav .sf-menu li.current_page_ancestor > a .sf-sub-indicator [class^="icon-"],
	header#top nav .sf-menu li.current-menu-ancestor > a, header#top nav .sf-menu li.current_page_item > a, .sf-menu li ul li.sfHover > a .sf-sub-indicator [class^="icon-"], 
	ul.sf-menu > li > a:hover > .sf-sub-indicator i, ul.sf-menu > li > a:active > .sf-sub-indicator i, ul.sf-menu > li.sfHover > a > .sf-sub-indicator i,
	.sf-menu ul li.current_page_item > a , .sf-menu ul li.current-menu-ancestor > a, .sf-menu ul li.current_page_ancestor > a, .sf-menu ul a:focus ,
	.sf-menu ul a:hover, .sf-menu ul a:active, .sf-menu ul li:hover > a, .sf-menu ul li.sfHover > a, .sf-menu li ul li a:hover, .sf-menu li ul li.sfHover > a,
	#footer-outer a:hover, .recent-posts .post-header a:hover, article.post .post-header a:hover, article.result a:hover,  article.post .post-header h2 a, .single article.post .post-meta a:hover,
	.comment-list .comment-meta a:hover, label span, .wpcf7-form p span, .icon-3x[class^="icon-"], .icon-3x[class*=" icon-"], .circle-border, article.result .title a, .home .blog-recent .span_3 .post-header a:hover,
	.home .blog-recent .span_3 .post-header h3 a, #single-below-header a:hover, header#top #logo:hover, .sf-menu > li.current_page_ancestor > a > .sf-sub-indicator [class^="icon-"], .sf-menu > li.current-menu-ancestor > a > .sf-sub-indicator [class^="icon-"],
	body #mobile-menu li.open > a [class^="icon-"], .pricing-column h3, .comment-author a:hover, .project-attrs li i, #footer-outer #copyright li a i:hover, .col:hover > [class^="icon-"].icon-3x.accent-color.alt-style, .col:hover > [class*=" icon-"].icon-3x.accent-color.alt-style,
	#header-outer .widget_shopping_cart .cart_list a, .woocommerce .star-rating, .woocommerce-page table.cart a.remove, .woocommerce form .form-row .required, .woocommerce-page form .form-row .required, body #header-secondary-outer #social a:hover i,
	.woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price, .nectar-milestone .number.accent-color, header#top nav > ul > li.megamenu > ul > li > a:hover, header#top nav > ul > li.megamenu > ul > li.sfHover > a, body #portfolio-nav a:hover i,
	span.accent-color, .nectar-love:hover i, .nectar-love.loved i, .portfolio-items .nectar-love:hover i, .portfolio-items .nectar-love.loved i, body .hovered .nectar-love i, header#top nav ul #search-btn a span:hover, #search-outer #search #close a span:hover
	{	
		color:'. $options["accent-color"].'!important;
	}
	
	.col:not(#post-area):not(.span_12):not(#sidebar):hover [class^="icon-"].icon-3x.accent-color.alt-style, body .col:not(#post-area):not(.span_12):not(#sidebar):hover a [class*=" icon-"].icon-3x.accent-color.alt-style {
		color:'. $options["accent-color"].'!important;
	}
	
	
	.orbit-wrapper div.slider-nav span.right, .orbit-wrapper div.slider-nav span.left, .flex-direction-nav a, .jp-play-bar,
	.jp-volume-bar-value, .jcarousel-prev:hover, .jcarousel-next:hover, .portfolio-items .work-info-bg, #portfolio-filters a, #portfolio-filters #sort-portfolio
	, .project-attrs li span, .progress li span, 
	#footer-outer #footer-widgets .col .tagcloud a:hover, #call-to-action .container a, #sidebar .widget .tagcloud a:hover, article.post .more-link span:hover,
	article.post.quote .post-content .quote-inner, article.post.link .post-content .link-inner, #pagination .next a:hover, #pagination .prev a:hover, 
	.comment-list .reply a:hover, input[type=submit]:hover, #footer-outer #copyright li a.vimeo:hover, #footer-outer #copyright li a.behance:hover,
	.toggle.open h3 a, .tabbed > ul li a.active-tab, [class*=" icon-"], .icon-normal, .bar_graph li span, .nectar-button, #footer-outer #footer-widgets .col input[type="submit"],
	.carousel-prev:hover, .carousel-next:hover, .blog-recent .more-link span:hover, .post-tags a:hover, .pricing-column.highlight h3, #to-top:hover, #to-top.dark:hover, #pagination a.page-numbers:hover,
	#pagination span.page-numbers.current, .single-portfolio .facebook-share a:hover, .single-portfolio .twitter-share a:hover, .single-portfolio .pinterest-share a:hover,  
	.single-post .facebook-share a:hover, .single-post .twitter-share a:hover, .single-post .pinterest-share a:hover, .mejs-controls .mejs-time-rail .mejs-time-current,
	.mejs-controls .mejs-volume-button .mejs-volume-slider .mejs-volume-current, .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current,
	article.post.quote .post-content .quote-inner, article.post.link .post-content .link-inner, article.format-status .post-content .status-inner, article.post.format-aside .aside-inner, 
	article.post.quote .content-inner .quote-inner .whole-link, body [class^="icon-"].icon-3x.alt-style.accent-color, body [class*=" icon-"].icon-3x.alt-style.accent-color, 
	#header-outer .widget_shopping_cart a.button, #header-outer a.cart-contents span, .woocommerce ul.products li.product .onsale, .woocommerce-page ul.products li.product .onsale, .woocommerce span.onsale, .woocommerce-page span.onsale, 
	.woocommerce .product-wrap .add_to_cart_button.added, .single-product .facebook-share a:hover, .single-product .twitter-share a:hover, .single-product .pinterest-share a:hover, .woocommerce-message, .woocommerce-error, .woocommerce-info, .woocommerce-page table.cart a.remove:hover,
	.woocommerce .chzn-container .chzn-results .highlighted, body #header-secondary-outer #social li a.behance:hover, body #header-secondary-outer #social li a.vimeo:hover, #sidebar .widget:hover [class^="icon-"],
	.woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce .container-wrap nav.woocommerce-pagination ul li:hover span, .woocommerce a.button:hover, .woocommerce-page a.button:hover, .woocommerce button.button:hover, .woocommerce-page button.button:hover, .woocommerce input.button:hover, 
	.woocommerce-page input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce-page #respond input#submit:hover, .woocommerce #content input.button:hover, .woocommerce-page #content input.button:hover, .woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active, 
	.woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-range, .woocommerce .widget_layered_nav_filters ul li a:hover, .woocommerce-page .widget_layered_nav_filters ul li a:hover, .swiper-slide .button.solid_color a
	{
		background-color:'.$options["accent-color"].'!important;
	}
	
	.col:hover > [class^="icon-"].icon-3x:not(.alt-style).accent-color, .col:hover > [class*=" icon-"].icon-3x:not(.alt-style).accent-color, 
	.col:not(#post-area):not(.span_12):not(#sidebar):hover [class^="icon-"].icon-3x:not(.alt-style).accent-color, .col:not(#post-area):not(.span_12):not(#sidebar):hover a [class*=" icon-"].icon-3x:not(.alt-style).accent-color {
		background-color:'.$options["accent-color"].'!important;
	}
	
	
	.tabbed > ul li a.active-tab, body .recent_projects_widget a:hover img, .recent_projects_widget a:hover img, #sidebar #flickr a:hover img, 
	#footer-outer #flickr a:hover img, #featured article .post-title a:hover, body #featured article .post-title a:hover, .woocommerce-page table.cart a.remove {
		border-color:'.$options["accent-color"].';
	}

	#header-outer a.cart-contents span:before { border-color: transparent '.$options["accent-color"].'; }
	
	.col:not(#post-area):not(.span_12):not(#sidebar):hover .circle-border, #sidebar .widget:hover .circle-border { border-color:'.$options["accent-color"].'; }

	.gallery a:hover img { border-color:'.$options["accent-color"].'!important; }';
	
	
	if(!empty($options['responsive']) && $options['responsive'] == 1) { 
		
		echo '@media only screen 
		and (min-width : 1px) and (max-width : 1000px) {
			
			body #featured article .post-title > a { background-color:'. $options["accent-color"].'; }
			
			body #featured article .post-title > a { border-color:'. $options["accent-color"].'; }
		}';
	
	} 
	
	
	if(!empty($options["extra-color-1"])) { 
		/*Extra Color 1*/
		echo '
		
		.nectar-button.extra-color-1 { background-color: '.$options["extra-color-1"].'!important; }
		
		.icon-3x[class^="icon-"].extra-color-1:not(.alt-style), .icon-3x[class*=" icon-"].extra-color-1:not(.alt-style) , .icon-3x[class*=" icon-"].extra-color-1:not(.alt-style)  .circle-border, .woocommerce-page table.cart a.remove, .nectar-milestone .number.extra-color-1, span.extra-color-1,
		.team-member ul.social.extra-color-1 li a, .stock.out-of-stock {
			color: '.$options["extra-color-1"].'!important;
		}
		
		.col:hover > [class^="icon-"].icon-3x.extra-color-1:not(.alt-style), .col:hover > [class*=" icon-"].icon-3x.extra-color-1:not(.alt-style),
		body .col:not(#post-area):not(.span_12):not(#sidebar):hover [class^="icon-"].icon-3x.extra-color-1:not(.alt-style), body .col:not(#post-area):not(#sidebar):not(.span_12):hover a [class*=" icon-"].icon-3x.extra-color-1:not(.alt-style), #sidebar .widget:hover [class^="icon-"].extra-color-1:not(.alt-style)
		{
			background-color: '.$options["extra-color-1"].'!important;
		}
		
		body [class^="icon-"].icon-3x.alt-style.extra-color-1, body [class*=" icon-"].icon-3x.alt-style.extra-color-1, [class*=" icon-"].extra-color-1.icon-normal, .bar_graph li span.extra-color-1, #header-outer .widget_shopping_cart a.button, .woocommerce ul.products li.product .onsale, .woocommerce-page ul.products li.product .onsale, .woocommerce span.onsale, .woocommerce-page span.onsale, .woocommerce-page table.cart a.remove:hover, .swiper-slide .button.solid_color a.extra-color-1 {
			background-color: '.$options["extra-color-1"].'!important;
		}
		
		.col:hover > [class^="icon-"].icon-3x.extra-color-1.alt-style, .col:hover > [class*=" icon-"].icon-3x.extra-color-1.alt-style,
		.col:not(#post-area):not(.span_12):not(#sidebar):hover [class^="icon-"].icon-3x.extra-color-1.alt-style, body .col:not(#post-area):not(.span_12):not(#sidebar):hover a [class*=" icon-"].icon-3x.extra-color-1.alt-style {
			color: '.$options["extra-color-1"].'!important;
		}
		
		.col:not(#post-area):not(.span_12):not(#sidebar):hover .extra-color-1 .circle-border, .woocommerce-page table.cart a.remove, #sidebar .widget:hover .extra-color-1 .circle-border { border-color:'.$options["extra-color-1"].'; }
		
		.pricing-column.highlight.extra-color-1 h3 { background-color:'.$options["extra-color-1"].'!important; }
		
		';
	}
	
	/*Extra Color 2*/
	if(!empty($options["extra-color-2"])) { 
		echo '
		
		.nectar-button.extra-color-2 { background-color: '.$options["extra-color-2"].'!important; }
			
		.icon-3x[class^="icon-"].extra-color-2:not(.alt-style), .icon-3x[class*=" icon-"].extra-color-2:not(.alt-style) , .icon-3x[class*=" icon-"].extra-color-2  .circle-border, .nectar-milestone .number.extra-color-2, span.extra-color-2, .team-member ul.social.extra-color-2 li a {
			color: '.$options["extra-color-2"].'!important;
		}
	
		.col:hover > [class^="icon-"].icon-3x.extra-color-2:not(.alt-style), .col:hover > [class*=" icon-"].icon-3x.extra-color-2:not(.alt-style),
		.col:not(#post-area):not(.span_12):not(#sidebar):hover [class^="icon-"].icon-3x.extra-color-2:not(.alt-style), .col:not(#post-area):not(.span_12):not(#sidebar):hover a [class*=" icon-"].icon-3x.extra-color-2:not(.alt-style), #sidebar .widget:hover [class^="icon-"].extra-color-2:not(.alt-style)
		{
			background-color: '.$options["extra-color-2"].'!important;
		}
		
		#header-outer a.cart-contents span:before { border-color: transparent '.$options["extra-color-2"].'; }
		#header-outer .widget_shopping_cart .cart_list a { color: '.$options["extra-color-2"].'!important; }
	
		body [class^="icon-"].icon-3x.alt-style.extra-color-2, body [class*=" icon-"].icon-3x.alt-style.extra-color-2, [class*=" icon-"].extra-color-2.icon-normal, .bar_graph li span.extra-color-2, #header-outer a.cart-contents span, .woocommerce .product-wrap .add_to_cart_button.added, .woocommerce-message, .woocommerce-error, .woocommerce-info, 
		.woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-range, .swiper-slide .button.solid_color a.extra-color-2 {
			background-color: '.$options["extra-color-2"].'!important;
		}
	
		.col:hover > [class^="icon-"].icon-3x.extra-color-2.alt-style, .col:hover > [class*=" icon-"].icon-3x.extra-color-2.alt-style,
		.col:not(#post-area):not(.span_12):not(#sidebar):hover [class^="icon-"].icon-3x.extra-color-2.alt-style, body .col:not(#post-area):not(.span_12):not(#sidebar):hover a [class*=" icon-"].icon-3x.extra-color-2.alt-style {
			color: '.$options["extra-color-2"].'!important;
		}
		
		.col:not(#post-area):not(.span_12):not(#sidebar):hover .extra-color-2 .circle-border, #sidebar .widget:hover .extra-color-2 .circle-border { border-color:'.$options["extra-color-2"].'; }
		
		.pricing-column.highlight.extra-color-2 h3 { background-color:'.$options["extra-color-2"].'!important; }
		';
	}
	
	
	/*Extra Color 3*/
	if(!empty($options["extra-color-3"])) { 
		echo '
		
		.nectar-button.extra-color-3 { background-color: '.$options["extra-color-3"].'!important; }
			
	    .icon-3x[class^="icon-"].extra-color-3:not(.alt-style) , .icon-3x[class*=" icon-"].extra-color-3:not(.alt-style) , .icon-3x[class*=" icon-"].extra-color-3  .circle-border, .nectar-milestone .number.extra-color-3, span.extra-color-3, .team-member ul.social.extra-color-3 li a {
			color: '.$options["extra-color-3"].'!important;
		}
	    .col:hover > [class^="icon-"].icon-3x.extra-color-3:not(.alt-style), .col:hover > [class*=" icon-"].icon-3x.extra-color-3:not(.alt-style),
		.col:not(#post-area):not(.span_12):not(#sidebar):hover [class^="icon-"].icon-3x.extra-color-3:not(.alt-style), .col:not(#post-area):not(.span_12):not(#sidebar):hover a [class*=" icon-"].icon-3x.extra-color-3:not(.alt-style), #sidebar .widget:hover [class^="icon-"].extra-color-3:not(.alt-style)
		{
			background-color: '.$options["extra-color-3"].'!important;
		}
		
		body [class^="icon-"].icon-3x.alt-style.extra-color-3, body [class*=" icon-"].icon-3x.alt-style.extra-color-3, [class*=" icon-"].extra-color-3.icon-normal, .bar_graph li span.extra-color-3, .swiper-slide .button.solid_color a.extra-color-3  {
			background-color: '.$options["extra-color-3"].'!important;
		}
	
		.col:hover > [class^="icon-"].icon-3x.extra-color-3.alt-style, .col:hover > [class*=" icon-"].icon-3x.extra-color-3.alt-style,
		.col:not(#post-area):not(.span_12):not(#sidebar):hover [class^="icon-"].icon-3x.extra-color-3.alt-style, body .col:not(#post-area):not(.span_12):not(#sidebar):hover a [class*=" icon-"].icon-3x.extra-color-3.alt-style {
			color: '.$options["extra-color-3"].'!important;
		}
		
		.col:not(#post-area):not(.span_12):not(#sidebar):hover .extra-color-3 .circle-border, #sidebar .widget:hover .extra-color-3 .circle-border { border-color:'.$options["extra-color-3"].'; }
		
		.pricing-column.highlight.extra-color-3 h3 { background-color:'.$options["extra-color-3"].'!important; }
		';
	}
	
	echo '</style>';

}

add_action('wp_head', 'nectar_colors');

?>