<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="utf-8" />
<title><?php global $page, $paged; wp_title( '|', true, 'right' ); bloginfo( 'name' ); $site_description = get_bloginfo( 'description', 'display' ); echo " | $site_description"; if ( $paged >= 2 || $page >= 2 ) echo ' | ' . sprintf( __( 'Page %s','themnific'), max( $paged, $page ) ); ?></title>

<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php themnific_head(); ?>

<?php wp_head(); ?>

</head>

     
<body <?php if (get_option('themnific_upper') == 'false' ){ body_class( );} else body_class('upper' ) ?>>

<?php 
	$type_slider = get_option('themnific_carousel_position'); 
	if($type_slider == 'pos1'){
		echo '<div class="container container_alt"><div class="head_fix">';
	  	get_template_part('/includes/sliders/carousel' );
	  	echo '</div></div>';
	} else {};
?> 


    
<a id="navtrigger-sec" href="#"><?php _e('MENU','themnific');?></a>

<div id="topnav" class="container container_alt"> 
        
        <div class="clearfix"></div>

		<?php get_template_part('/includes/uni-navigation'); ?>

		<?php get_template_part('/includes/uni-searchformhead'); ?>
        
</div>

<div class="clearfix"></div>

<div id="header">

	<div class="container container_alt"> 
    
        <h1 style="margin-right: 100px;">
        
            <?php if(get_option('themnific_logo')) { ?>
                            
                <a class="logo" href="<?php echo home_url(); ?>/">
                
                    <img src="<?php echo esc_url(get_option('themnific_logo'));?>" alt="<?php bloginfo('name'); ?>"/>
                        
                </a>
                    
            <?php } 
                    
                else { ?> <a href="<?php echo home_url(); ?>/"><?php bloginfo('name');?></a>
                    
            <?php } ?>	
        
        </h1>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Реклама ukrautoprobeg - logo -->
<div style="display:inline-block;width:730px;height:110px; overflow:hidden;">
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px; margin-top: 20px;"
     data-ad-client="ca-pub-1753231692490827"
     data-ad-slot="9022898393"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

</div>
    	<?php get_template_part('/includes/mag-headad');  ?>
            
	</div>
    
    <a id="navtrigger" href="#"><?php _e('MENU','themnific');?></a>
    
    <nav id="navigation"> 
    
    	<?php get_template_part('/includes/mag-navigation'); ?>
    
    </nav>
            
</div>

<div class="clearfix"></div>

<?php 
	$type_slider = get_option('themnific_carousel_position'); 
	if($type_slider == 'pos2'){
		echo '<div class="container container_alt" ><div class="blog_fix">';
		get_template_part('/includes/sliders/carousel' );
		echo '</div></div>';
	} else {};
?> 