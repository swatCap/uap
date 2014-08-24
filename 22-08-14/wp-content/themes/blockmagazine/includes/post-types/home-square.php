           <?php $post_size = get_post_meta($post->ID, 'tmnf_size-shape', true);?>
            
            <div class="item_full tranz">
                
				<?php if ( has_post_thumbnail()){ ?>

                    <a href="<?php tmnf_permalink(); ?>" title="<?php the_title();?>" >
                    
                    	<?php the_post_thumbnail('Normal',array('class' => "grayscale grayscale-fade"));?>
    
                	</a>

                <?php } else {?> 

                    <a href="<?php tmnf_permalink(); ?>" title="<?php the_title();?>" >

						<img alt="" src="<?php echo get_template_directory_uri(); ?>/images/placeholder.png"/>
                    
                    </a>
                    
                <?php } ?> 
    
            	
	    <div class="item_inn tranz <?php if ( has_post_thumbnail()){ } else { echo 'permanent';}?>">
            
            		<?php echo tmnf_ribbon() ?>
        
                    <h2><?php tmnf_meta_date();?> <a href="<?php tmnf_permalink(); ?>"><?php echo short_title('...', 14); ?></a></h2>
                
                </div> 

         
            </div>