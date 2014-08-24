           <?php
				$large_image =  wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'fullsize', false, '' ); 
				$large_image = $large_image[0]; 
				$another_image_1 = get_post_meta($post->ID, 'themnific_image_1_url', true);
				$video_input = get_post_meta($post->ID, 'themnific_video_url', true);
				$post_size = get_post_meta($post->ID, 'tmnf_size-shape', true);
            ?>
            
            <div class="item_full">
                
                <a href="<?php tmnf_permalink(); ?>">
                    
                    <?php the_post_thumbnail( 'Vertical',array('class' => "grayscale grayscale-fade"));?>
                
                </a>
    
                <div class="item_inn tranz">
            
            		<?php echo tmnf_ribbon() ?>
        
                    <h2><a href="<?php tmnf_permalink(); ?>"><?php echo short_title('...', 14); ?></a></h2>
                    
                    <p class="teaser"><?php tmnf_meta_date();  echo themnific_excerpt( get_the_excerpt(), '80'); ?>...</p>
                
                </div>
        
            </div>