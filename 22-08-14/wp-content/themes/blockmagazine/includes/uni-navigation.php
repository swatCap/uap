<?php
if ( function_exists('has_nav_menu') && has_nav_menu('main-menu') ) {
	wp_nav_menu( array( 'depth' => 3, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_class' => 'nav', 'menu_id' => '' , 'theme_location' => 'main-menu' ) );
} else {

	get_template_part('/includes/uni-social');  

} ?>

	  