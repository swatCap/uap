<?php
if ( function_exists('has_nav_menu') && has_nav_menu('magazine-menu') ) {
	
	$walker = new tmnf_description_walker;
	wp_nav_menu( array( 'depth' => 3, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_class' => 'nav container container_alt', 'menu_id' => 'main-nav' , 'theme_location' => 'magazine-menu','walker' => $walker ) );
} else {
?>
    <ul id="main-nav" class="nav container container_alt">
    
        <?php wp_list_categories('sort_column=menu_order&depth=3&title_li=&'); ?>
        
    </ul>
<?php } ?>

	  