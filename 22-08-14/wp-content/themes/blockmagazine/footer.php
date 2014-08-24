<div id="footer">

	<div class="container container_alt">

		<?php 
            $type_slider = get_option('themnific_carousel_position'); 
            if($type_slider == 'pos3'){
              get_template_part('/includes/sliders/carousel' );
            } else {};
        ?>  
    
        <?php if (get_option('themnific_widget_dis') <> "true") { 
    
    	get_template_part('/includes/uni-bottombox');
    
    	} ?>
        
        <div class="clearfix"></div>

        <div id="copyright">
        
            <div class="fl">
            
				<?php if(get_option('themnific_footer_left') == 'true'){
                    
                    echo stripslashes(get_option('themnific_footer_left_text'));
                    
                } else { 
				
				if ( function_exists('has_nav_menu') && has_nav_menu('bottom-menu') ) {wp_nav_menu( array( 'depth' => 1, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_class' => 'bottom-menu', 'menu_id' => '' , 'theme_location' => 'bottom-menu') );} } ?>
                    
            </div>
        
            <div class="fr">
            
				<?php if(get_option('themnific_footer_right') == 'true'){
                    
                    echo stripslashes(get_option('themnific_footer_right_text'));
                    
                } else { ?>
                
                    <p>
                    	&copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?> | 
						<?php _e('Основатели - Александр Дихтярук, Святослав Лобач -','Александр Дихтярук, Святослав Лобач');?> <a href="http://www.autoprobeg.org.ua">Первый Всеукриинский Автомотопробег</a>. 
						<?php _e('Укравтопортал','Ukrautoportal');?> <a href="http://ukrautoportal.com">Ukrautoportal</a>
                    </p>
                    
                <?php } ?>
                
            </div>
                  
        </div> 
    
	</div>
        
</div><!-- /#footer  -->
    
<div class="scrollTo_top" style="display: block">

    <a title="Scroll to top" href="#">
    
    	<i class="fa fa-angle-up"></i> 
        
    </a>
    
</div>

<?php themnific_foot(); ?>
<?php wp_footer(); ?>

</body>
</html>