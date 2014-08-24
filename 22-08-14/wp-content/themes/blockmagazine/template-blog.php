<?php
/*
Template Name: Blog
*/
?>
<?php get_header(); ?>

<div id="core" class="container"> 

	<div id="content" class="eightcol">

          <ul class="medpost">

                	<?php
						$temp = $wp_query;
						$limit = get_option('posts_per_page');
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						$wp_query= null;
						$wp_query = new WP_Query();
						$wp_query->query('showposts=' . $limit . '&paged=' . $paged);
						$wp_query->is_home = false;
					?>
					<?php if (have_posts()) : ?>
                                        
                    <?php while (have_posts()) : the_post(); ?>
            
						<?php if(has_post_format('aside'))  {
							echo '<li>';
                            echo get_template_part( '/includes/post-types/aside' );
							echo '</li>';
                        }elseif(has_post_format('quote')){
							echo '<li>';
                            echo get_template_part( '/includes/post-types/quote' );
							echo '</li>';
                            } else {
                            echo get_template_part( '/includes/post-types/medpost' );
                        }?>
                            
					<?php endwhile; ?><!-- end post -->
                    
           	</ul><!-- end latest posts section-->
            
            <div style="clear: both;"></div>

            <div class="pagination"><?php tmnf_pagination('&laquo;', '&raquo;'); ?></div>

            <?php else : ?>

                <h1>Sorry, no posts matched your criteria.</h1>
                
                <?php get_search_form(); ?><br/>
                
            <?php endif; ?>

    </div><!-- end #content-->
    
    <div id="sidebar"  class="fourcol">
           <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Sidebar") ) : ?>
           <?php endif; ?>
    </div><!-- #sidebar -->
        
</div>

<?php get_footer(); ?>