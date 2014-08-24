<?php get_header(); ?>

<div class="container"> 
    
    <?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    ?>
    
	<?php if (have_posts()) : ?>

			<div class="authorarchive">
            
        		<h2 class="itemtitle"><?php echo $curauth->nickname; ?></h2>
                  
                <?php echo get_avatar($curauth->user_email, 80 ); ?>
                
                <p style=" margin:0 0 5px 0;"><?php _e('Website: ','themnific');?><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></p>
                
                <p><?php _e('Bio: ','themnific');?><?php echo $curauth->user_description; ?></p>
                
            </div>
            
    		<div class="clearfix"></div>

			<h2 class="itemtitle" style="padding-top:20px;"><?php _e('Author Posts','themnific');?>: </h2>

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

                        <h1>Просим прощения, статей не нейдено.</h1>
                        
                        <?php get_search_form(); ?><br/>
                        
					<?php endif; ?>
   

<?php get_footer(); ?>