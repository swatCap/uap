<div class="postinfo">    

<?php 
	

	// breadcrumbs
	if (get_option('themnific_post_breadcrumbs_dis') == 'true' );
	else { ?>
        <span class="bread">
        <?php tmnf_breadcrumbs()?>
        </span> 
        <div class="hrline"></div><?php }
	
	// author
	if (get_option('themnific_post_author_dis') == 'true' );
	else
	get_template_part('/includes/mag-authorinfo');
	echo '';



	// related
	if (get_option('themnific_post_related_dis') == 'true' );
	else 
	get_template_part('/includes/mag-relatedposts');

	
?>
            
</div>

<div class="clearfix"></div>
 			
            

                        
