<?php 


/*-----------------------------------------------------------------------------------*/
/* Custom functions */
/*-----------------------------------------------------------------------------------*/


global $themnific_options;
$output = '';

// Add custom styling
add_action('wp_head','themnific_custom_styling');
function themnific_custom_styling() {
	
	// Get options
	$home = home_url();
	$home_theme  = get_template_directory_uri();
	
	$sec_body_color = get_option('themnific_custom_color');
	$thi_body_color = get_option('themnific_thi_body_color');
	$for_body_color = get_option('themnific_for_body_color');
	$ser_bg_color = get_option('themnific_ser_bg_color');
	$body_color = get_option('themnific_body_color');
	$text_color = get_option('themnific_text_color');
	$text_color_alter = get_option('themnific_text_color_alter');
	$body_color_sec = get_option('themnific_body_color_sec');
	$sec_text_color = get_option('themnific_sec_text_color');
	$thi_text_color = get_option('themnific_thi_text_color');
	$link = get_option('themnific_link_color');
	$link_alter = get_option('themnific_link_color_alter');
	$hover = get_option('themnific_link_hover_color');
	$sec_link = get_option('themnific_sec_link_color');
	$sec_hover = get_option('themnific_sec_link_hover_color');
	$thi_hover = get_option('themnific_thi_link_hover_color');
	$body_bg = get_option('themnific_body_bg');
	$body_bg_sec = get_option('themnific_body_bg_sec');
	$shadows = get_option('themnific_shadows_color');
	$shadows_sec = get_option('themnific_shadows_color_sec');
	$shadows_thi = get_option('themnific_shadows_color_thi');
	$border = get_option('themnific_border_color');
	$border_sec = get_option('themnific_border_color_sec');
	$elements_text = get_option('themnific_elements_text');
	    $custom_css = get_option('themnific_custom_css');
		
	// Add CSS to output
		if ($custom_css)
		$output .= $custom_css ;
		$output = '';
	
	if ($body_color)
		$output .= 'body{background-color:'.$body_color.'}' . "\n";
		$output .= '.item_full img{border-color:'.$body_color.' !important}' . "\n";
	if ($sec_body_color)
		$output .= '
		#navigation>ul>li,.meta_full span,.body2{background-color:'.$sec_body_color.'}' . "\n";
	if ($thi_body_color)
		$output .= '
		.body3,ul.medpost li.format-quote,#header,.nav-previous a:hover,.nav li ul,ul.social-menu li,.post-previous,.post-next,.searchformhead,.carousel_inn,.postinfo,#hometab,ul.tmnf_slideshow_thumbnails,ul.tmnf_slideshow_thumbnails li a img{background-color:'.$thi_body_color.'}' . "\n";
		$output .= '
		.item .item_inn:after,.Big .item_inn:after{border-color:transparent transparent'.$thi_body_color.'}' . "\n";
	if ($for_body_color)
		$output .= '.flex-caption,#serinfo-nav li.current,.wpcf7-submit,a#navtrigger,.flex-direction-nav .flex-next,.flex-direction-nav .flex-prev,span.ribbon,span.meta_alt,.imgwrap,.page-numbers.current,a.mainbutton,#submit,#comments .navigation a,.contact-form .submit,a.comment-reply-link,.searchSubmit,.scrollTo_top,.nav-previous a,#infscr-loading,.quote img,.aside img,.overrating,.ratingbar,.score{background-color:'.$for_body_color.'}' . "\n";
		$output .= '#main-nav>li>ul:after,#nav>li>ul:after{border-color: transparent transparent '.$for_body_color.' transparent}' . "\n";
		$output .= '#nav>li.current>a,#servicesbox li:hover h3 i,.section>.container>h2:after,#menu-main-menu>li.current-cat>a,#menu-main-menu>li.current_page_item>a,li.current-cat>a{color: black;}' . "\n";
	if ($text_color)
		$output.= 'body,.body1 {color:'.$text_color.'}' . "\n";	
	if ($ser_bg_color)
		$output .= '
		#footer,.item_inn{background-color:'.$ser_bg_color.'}' . "\n";
	if ($sec_text_color)
		$output .= '
		#footer,.item_inn{color:'.$sec_text_color.'}' . "\n";
		$output .= '
		#footer .threecol h2,.item_inn p.meta,.item_inn span.meta{color:'.$sec_text_color.' !important}' . "\n";
	if ($text_color_alter)
		$output .= '.ratingblock h2 span.score,.ratingbar,.nav-previous a,.quote p,.quote i,.ribbon_icon i,.scrollTo_top a i,span.meta_alt,.searchSubmit,#serinfo-nav li.current a,.flex-caption,a.mainbutton,#submit,#comments .navigation a,.tagssingle a,.contact-form .submit,.wpcf7-submit,a.comment-reply-link {color:'.$text_color_alter.' !important}' . "\n";
	if ($link)
		$output .= '.body1 a, a:link, a:visited,.nav>li>ul>li>a,#footer .carousel_inn a {color:'.$link.'}' . "\n";
	if ($link_alter)
		$output .= '.body3XXX a {color:'.$link_alter.'}' . "\n";
	if ($hover)
		$output .= '.entry a,a:hover,.body1 a:hover,#serinfo a:hover,.tagline a,a.slant {color:'.$hover.'}' . "\n";
	if ($sec_link)
		$output .= '
		#footer a,.item_inn a{color:'.$sec_link.'}' . "\n";
	if ($sec_hover)
		$output .= '
		.body2 a:hover,
		p.body2 a:hover
		{color:'.$sec_hover.'!important}' . "\n";
	if ($thi_hover)
		$output .= '
		.body3XXX a:hover
		{color:'.$thi_hover.'}' . "\n";
		
		

		
	if ($border)
		$output .= '#header,.hrline,.nav li ul,.tab-post,.com_post,.searchformhead,.searchform input.s,.ad300,.pagination,input, textarea,input checkbox,input radio,select, file{border-color:'.$border.' !important}' . "\n";	

	if ($border_sec)
		$output .= '#footer,.body2,#copyright,#footer .threecol,#footer h2,#footer a,#footer .tab-post,#footer .com_post {border-color:'.$border_sec.' !important}' . "\n";

	if ($shadows)
		$output .= '.xxx {text-shadow:0 1px 1px '.$shadows.'}' . "\n";
		
	if ($shadows_sec)
		$output .= '.xxx {text-shadow:0 1px 1px '.$shadows_sec.'}' . "\n";
		
	if ($shadows_thi)
		$output .= '.xxx {text-shadow:0 1px 1px '.$shadows_thi.'}' . "\n";




		// General Typography		
		$font_text = get_option('themnific_font_text');	
		$font_text_sec = get_option('themnific_font_text_sec');	
		
		$font_nav = get_option('themnific_font_nav');
		$font_h1 = get_option('themnific_font_h1');	
		$font_h2 = get_option('themnific_font_h2');	
		$font_h2_home = get_option('themnific_font_h2_home');
		$font_h3 = get_option('themnific_font_h3');	
		$font_h4 = get_option('themnific_font_h4');	
		$font_h5 = get_option('themnific_font_h5');	
		$font_h6 = get_option('themnific_font_h5');	
		
		
		$font_h2_tagline = get_option('themnific_font_h2_tagline');	
	
	
		if ( $font_text )
			$output .= 'body,input, textarea,input checkbox,input radio,select, file {font:'.$font_text["style"].' '.$font_text["size"].'px/1.7em '.stripslashes($font_text["face"]).';color:'.$font_text["color"].'}' . "\n";
			
		if ( $font_text_sec )
			$output .= '.body2 {font:'.$font_text_sec["style"].' '.$font_text_sec["size"].'px/2.2em '.stripslashes($font_text_sec["face"]).';color:'.$font_text_sec["color"].'}' . "\n";
			$output .= '.body2 h2,.body2 h3 {color:'.$font_text_sec["color"].'}' . "\n";

		if ( $font_h1 )
			$output .= 'h1 {font:'.$font_h1["style"].' '.$font_h1["size"].'px/1.1em '.stripslashes($font_h1["face"]).';color:'.$font_h1["color"].'}';
		if ( $font_h2 )
			$output .= 'h2 {font:'.$font_h2["style"].' '.$font_h2["size"].'px/1.2em '.stripslashes($font_h2["face"]).';color:'.$font_h2["color"].'}';
		if ( $font_h3 )
			$output .= 'h3 {font:'.$font_h3["style"].' '.$font_h3["size"].'px/1.5em '.stripslashes($font_h3["face"]).';color:'.$font_h3["color"].'}';
		if ( $font_h4 )
			$output .= 'h4,a.mainbutton {font:'.$font_h4["style"].' '.$font_h4["size"].'px/1.5em '.stripslashes($font_h4["face"]).';color:'.$font_h4["color"].'}';	
		if ( $font_h5 )
			$output .= 'h5 {font:'.$font_h5["style"].' '.$font_h5["size"].'px/1.5em '.stripslashes($font_h5["face"]).';color:'.$font_h5["color"].'}';	
		if ( $font_h6 )
			$output .= 'h6,p.meta,span.meta {font:'.$font_h6["style"].' '.$font_h6["size"].'px/1.5em '.stripslashes($font_h6["face"]).';color:'.$font_h6["color"].'}' . "\n";
			
		if ( $font_nav )
			$output .= '#main-nav>li>a,.meta_full span,.meta_full span a {font:'.$font_nav["style"].' '.$font_nav["size"].'px/1em '.stripslashes($font_nav["face"]).';color:'.$font_nav["color"].'}';	
			$output .= '#main-nav .loop h4 {font-size:'.$font_nav["size"].'px}';

		if ( $font_h2_home )
			$output .= '.item_inn h2,#footer .threecol h2,.nav-previous a, .quote p,.carousel_inn h2 {font:'.$font_h2_home["style"].' '.'17'.'px/1.2em '.stripslashes($font_h2_home["face"]).';color:'.$font_h2_home["color"].'}';
		
		
	// custom stuff	
		if ( $font_text )
			$output .= '.tab-post small a,.taggs a,.ei-slider-thumbs li a {color:'.$font_text["color"].'}' . "\n";	
	
	// Output styles
		if ($output <> '') {
			$output = "<!-- Themnific Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
	}
		
} 


// Add custom styling
add_action('themnific_head','themnific_mobile_styling');
function themnific_mobile_styling() {
	echo "<!-- Themnific CSS -->\n";
	
	// google fonts link generator
	get_template_part('/functions/admin-fonts');
} 
?>