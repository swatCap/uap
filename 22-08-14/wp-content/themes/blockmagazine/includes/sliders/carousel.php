	<?php 
        $top_carousel = get_cat_ID(get_option('themnific_carousel_cat'));
        $top_carousel_posts_nr = get_option('themnific_carousel_postnumber');
        $my_query = new WP_Query('showposts='.$top_carousel_posts_nr.'&cat='. $top_carousel .'');	 
        if ($my_query->have_posts()) :
    ?>

            <div class="flexwrap">
            
                <div class="flexcarousel flexslider loading">
                
                    <ul class="slides">
                    <?php while ($my_query->have_posts()) : $my_query->the_post();$do_not_duplicate = $post->ID; ?>	
        				<li>
						<?php get_template_part('/includes/post-types/home-carousel' ); ?>
        				</li>
                    <?php  endwhile; ?>
                    </ul>
                    
                </div>
                    
            </div>
        <?php endif; ?>
        <?php wp_reset_query(); ?>