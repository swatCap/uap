<?php get_header();  

tmnf_count_views(get_the_ID());

$sidebar_opt = get_post_meta($post->ID, 'tmnf_sidebar', true);

if (get_option('themnific_post_nextprev_dis') == 'true' );
else get_template_part('/includes/mag-nextprev');
	
?>

<div id="core" class="container <?php echo $sidebar_opt ?>">
    
    <div <?php post_class(); ?>  itemscope itemprop="blogPost" itemtype="http://schema.org/Article"> 
    
        <div id="content" class="eightcol">
        
                <?php get_template_part('single-content' ); ?>
                
        </div><!-- #homecontent -->
        
        <?php if($sidebar_opt == 'None'){ } else { get_sidebar();} ?>
    
    </div>

</div><!-- #core -->
    
<?php get_footer(); ?>