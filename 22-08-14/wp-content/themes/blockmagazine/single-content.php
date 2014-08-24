<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
<?php 
	$video_input = get_post_meta($post->ID, 'tmnf_video', true);
	$audio_input = get_post_meta($post->ID, 'tmnf_audio', true);
	$rating = get_post_meta($post->ID, 'tmnf_rating_main', true);
	$sidebar_opt = get_post_meta($post->ID, 'tmnf_sidebar', true);
	$single_featured = get_post_meta($post->ID, 'tmnf_single_featured', true);
?>

<?php 	
if($sidebar_opt == 'None'){ } else {

	if(has_post_format('video')){
			echo ($video_input);
	}elseif(has_post_format('audio')){
			echo ($audio_input);
	}elseif(has_post_format('gallery')){
		if ($single_featured == 'Yes')  {
		   the_post_thumbnail('standard',array('itemprop' => 'image','class' => 'standard'));  
		} else;	
	} else {
		if (get_option('themnific_post_image_dis') == 'true' );
		else
		   the_post_thumbnail('standard',array('itemprop' => 'image','class' => 'standard'));  
	}
}?>

<div class="clearfix"></div>

<?php tmnf_meta_full() ?>

<h1 class="post entry-title" itemprop="headline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

<div class="entry" itemprop="text">
      
    <?php 
	
		the_content(); 
	
		if($rating) { get_template_part( '/includes/mag-rating' );  } else { };
		
		wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:','themnific') . '</span>', 'after' => '</div>' ) );
		
		the_tags( '<p>' . __( 'Теги: ','themnific') . '', ', ', '</p>');
	
	?>
    
    <div class="clearfix"></div>
    
</div><!-- end .entry -->

	<?php 
		
		get_template_part('/includes/mag-postad');
	
		get_template_part('single-info');
		
		comments_template(); 
		
	?>

<?php endwhile; else: ?>

	<p><?php _e('Sorry, no posts matched your criteria','themnific');?>.</p>

<?php endif; ?>