<?php get_header(); ?>
         
	<?php if (have_posts()) : ?>
    
    <div class="container" >
    
		<?php $post = $posts[0]; if (is_category()) { ?>
        
        	<h2 class="itemtitle"><?php single_cat_title(); ?> <?php _e('','themnific');?></h2>
            
        <?php  } elseif( is_tag() ) { ?>
        
        	<h2 class="itemtitle"><?php _e('Posts Tagged','themnific');?> &#8216;<?php single_tag_title(); ?>&#8217;</h2>
            
        <?php } ?>
        
     </div>   
    
     <div class="isotope js-isotope" >
          
    			<?php while (have_posts()) : the_post(); ?>
                                              		
            		  	<?php $post_size = get_post_meta($post->ID, 'tmnf_size-shape', true); ?>
                        
                        <?php if(has_post_format('aside'))  {
                            echo get_template_part( '/includes/post-types/aside' );
							}elseif(has_post_format('quote')){
								echo get_template_part( '/includes/post-types/quote' );
								} else { ?>
                        
                       			<div class="all item <?php echo $post_size ?>">
                        
									<?php if($post_size == 'Big'){
                                        get_template_part('/includes/post-types/home-big');
                                        }elseif($post_size == 'Vertical'){
                                        get_template_part('/includes/post-types/home-vertical');
                                        }elseif($post_size == 'Horizontal'){
                                        get_template_part('/includes/post-types/home-horizontal');
                                        } else {
                                        get_template_part('/includes/post-types/home-square');
                                    }?>
                            
                        		</div>
                        
                        <?php }?>
                    
   				<?php endwhile; ?>   <!-- end post -->
                    
	</div><!-- end isotope -->
            
    <div class="clearfix"></div>

    <div class="nav-previous"><?php next_posts_link( __( 'Загрузить еще...', 'themnific') ); ?></div>

					<?php else : ?>

                        <h1 style="text-align: center;">Просим прощения, статей не нейдено.</h1>
                        
                        <!--<?php get_search_form(); ?> --><br/>
                        
					<?php endif; ?>
   

<?php get_footer(); ?>