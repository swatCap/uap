	<?php if(get_option('themnific_headeradscript')) { 
    
        echo '<div class="headad fr ';  if (get_option('themnific_ad_res_mode') == 'false' ); else echo 'resmode-No';   echo '">';
     
        echo get_option('themnific_headeradscript');
    
        echo '</div>';
    
    } elseif(get_option('themnific_headeradimg1')) { ?> 
    
        <div class="headad">
        
            <a href="<?php echo get_option('themnific_headeradurl1');?>"><img src="<?php echo get_option('themnific_headeradimg1');?>" alt="" /></a>
            
        </div>
        
    <?php } else {} ?>