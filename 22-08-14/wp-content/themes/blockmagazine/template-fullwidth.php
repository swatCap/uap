<?php
/*
Template Name: Full Width
*/
?>
<?php get_header(); ?>
    
    <div class="container"> 
            
        <h2 class="itemtitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    
    	<div class="entry entryfull">
            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <?php the_content(); ?>
            
            <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
            
            <?php endwhile; endif; ?>
            
       	</div>
        
    </div>
    
   	<div style="clear: both;"></div>
    
<?php get_footer(); ?>