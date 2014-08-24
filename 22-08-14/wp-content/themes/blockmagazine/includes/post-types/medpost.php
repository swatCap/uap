<li <?php post_class(); ?>>
<?php echo tmnf_ribbon() ?>

	<?php
    $video_input = get_post_meta($post->ID, 'tmnf_video', true);
	$audio_input = get_post_meta($post->ID, 'tmnf_audio', true);
	?>

	<?php 	if(has_post_format('video')){
                    echo ($video_input);
            }elseif(has_post_format('audio')){
                    echo ($audio_input);
            } else {
                    if ( has_post_thumbnail()); ?>
                    
                        <a href="<?php tmnf_permalink(); ?>">  
  
                             <?php the_post_thumbnail('blog',array('class' => "grayscale grayscale-fade")); ?>
      
                        </a>  
                        
    <?php }?>
            
            <div class="clarfix"></div>

            <h2><a href="<?php tmnf_permalink(); ?>"><?php echo short_title('...', 14); ?></a></h2>
            
            <?php tmnf_meta() ?>   
            
            <p class="teaser"><?php echo themnific_excerpt( get_the_excerpt(), '220'); ?>...</p>
                
            <a class="mainbutton" href="<?php the_permalink(); ?>"><?php _e('Read More','themnific');?> &#187;</a>
                  
</li>