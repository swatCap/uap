<?php get_header(); ?>

<div class="container">

			<h2 class="itemtitle"><?php _e('Results for','themnific');?> "<?php echo $s; ?>"</h2>

		<?php if (have_posts()) : ?>

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
                    
						<!-- Not Found Handling -->
                        
                        <div class="hrlineB"></div>
                        
                        <h4><?php _e('Просим прощения, статей не нейдено.','themnific');?></h4>
                        
           				<h4><?php _e('Возможно, Вы найдете что-то интересное здесь','themnific');?></h4>
                        
						<?php get_template_part('/includes/uni-404-content');?>
                        
                        
					<?php endif; ?>
   

<?php get_footer(); ?>