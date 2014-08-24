<?php get_header(); ?>

<div id="core" class="container"> 

	<div id="content" class="eightcol">
         
	<?php if (have_posts()) : ?>
    
    <div class="container" >
    
		<?php $post = $posts[0]; if (is_category()) { ?>
        
        	<h2 class="itemtitle"><?php single_cat_title(); ?> <?php _e('Category','themnific');?></h2>
            
        <?php  } elseif( is_tag() ) { ?>
        
        	<h2 class="itemtitle"><?php _e('Posts Tagged','themnific');?> &#8216;<?php single_tag_title(); ?>&#8217;</h2>
            
        <?php } ?>
        
     </div>   
    
     <ul class="medpost">
          
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
                    
   				<?php endwhile; ?>   <!-- end post -->
                    
	</ul><!-- end medpost -->
            
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