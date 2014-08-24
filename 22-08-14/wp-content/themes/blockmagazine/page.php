<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="core" class="container">

	<div id="content" class="eightcol">
    
		<div <?php post_class(); ?>>
        
        	<h1 class="post entry-title" itemprop="headline"><?php the_title(); ?></a></h1>
    
    		<div class="hrlineB"><span></span></div>


                    <div class="entry">
                    <?php the_content(); ?>
                        <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:','themnific') . '</span>', 'after' => '</div>' ) ); ?>
                        <?php the_tags( '<p class="tagssingle">','',  '</p>'); ?>
                    </div>       
                        
				<div style="clear: both;"></div>  
                   
                <p class="meta sserif">
                
                  	<i class="icon-time"></i> <?php _e('on','themnific');?>  <?php the_time('F j'); ?> | 
                  	<i class="icon-edit"></i> <?php _e('by','themnific');?> <?php the_author_posts_link(); ?>
                
                </p>

                  
                   	<?php comments_template(); ?>

            </div>



	<?php endwhile; else: ?>

		<p><?php _e('Sorry, no posts matched your criteria','themnific');?>.</p>

	<?php endif; ?>

                <div style="clear: both;"></div>

	</div><!-- #content -->

    <div id="sidebar"  class="fourcol">
           <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Sidebar") ) : ?>
           <?php endif; ?>
    </div><!-- #sidebar -->
        
</div>

<?php get_footer(); ?>