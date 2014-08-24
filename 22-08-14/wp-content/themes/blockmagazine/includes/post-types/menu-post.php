<div>

  <?php if ( has_post_thumbnail()) : ?>
  
       <a href="<?php tmnf_permalink(); ?>" title="<?php echo short_title('...', 6); ?>" >
       
          <?php the_post_thumbnail( 'related',array('class' => "grayscale grayscale-fade")); ?>
          
       </a>
       
  <?php endif; ?>
      
  <h4><a href="<?php tmnf_permalink(); ?>" title="<?php the_title(); ?>"><?php echo short_title('...', 11); ?> <?php echo tmnf_icon() ?></a></h4>
  
  <?php tmnf_meta_small() ?>

</div>