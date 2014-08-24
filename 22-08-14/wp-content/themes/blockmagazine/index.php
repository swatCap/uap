<?php get_header(); ?>   

	<div class="isotope js-isotope" >

                	<?php
						if ( get_query_var('paged') ) {
							$paged = get_query_var('paged');
						} else if ( get_query_var('page') ) {
							$paged = get_query_var('page');
						} else {
							$paged = 1;
						}
						query_posts( array( 'post_type' => 'post', 'paged' => $paged ) );
					?>
					<?php if (have_posts()) : ?>
                                        
                    <?php while (have_posts()) : the_post(); ?>
                    
					<?php 
                      // Get The Taxonomy 'Filter' Categories
                      
                      $terms = get_the_terms( $post->ID, 'categories' );						
                        if ( $terms && ! is_wp_error( $terms ) ) : 
             
                            $links = array();
             
                            foreach ( $terms as $term ) {
                                $links[] = $term->slug;
                            }
             
                            $tax_links = join( " ", str_replace(' ', '-', $links));          
                            $tax = strtolower($tax_links);
                        else :	
                        $tax = '';					
                        endif; 
                    ?>
            
           				<?php $post_size = get_post_meta($post->ID, 'tmnf_size-shape', true); ?>
                        
                        <?php if(has_post_format('aside'))  {
                            echo get_template_part( '/includes/post-types/aside' );
							}elseif(has_post_format('quote')){
								echo get_template_part( '/includes/post-types/quote' );
								} else { ?>
                        
                       			<div class="all item <?php echo $tax ?> <?php echo $post_size ?>">
                        
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
                            
					<?php endwhile; ?><!-- end post -->
                    
	</div><!-- end isotope -->
            
    <div class="clearfix"></div>

    <div class="nav-previous"><?php next_posts_link( __( 'Загрузить еще...', 'themnific') ); ?></div>

    <?php else : ?>

        <h1>Просим прощения, статей не нейдено.</h1>
        
        <?php get_search_form(); ?><br/>
        
    <?php endif; ?>
        
<?php get_footer(); ?>