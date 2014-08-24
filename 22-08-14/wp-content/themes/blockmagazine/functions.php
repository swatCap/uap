<?php

/*-----------------------------------------------------------------------------------
- Default
----------------------------------------------------------------------------------- */

add_action( 'after_setup_theme', 'tmnf_theme_setup' );

function tmnf_theme_setup() {
	global $content_width;

	/* Set the $content_width for things such as video embeds. */
	if ( !isset( $content_width ) )
		$content_width = 960;

	/* Add theme support for automatic feed links. */
	add_editor_style();
	add_theme_support( 'post-formats', array( 'video','audio', 'gallery', 'image', 'quote', 'link','aside' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'woocommerce' );

	/* Add theme support for post thumbnails (featured images). */
	if (function_exists('add_theme_support')) {		
		add_theme_support('post-thumbnails');
		add_image_size('Normal', 302, 251, true ); //(cropped)
		add_image_size('Big', 614, 511, true ); //(cropped)
		add_image_size('Vertical', 302, 511, true ); //(cropped)
		add_image_size('Horizontal', 614, 251, true ); //(cropped)
		add_image_size('standard', 820, 510, true ); //(cropped)
		add_image_size('blog', 387, 320, true ); //(cropped)
		add_image_size('related', 250, 190, true ); //(cropped)
		add_image_size('tabs', 120, 105, true ); //(cropped)
	}
	
	function thumb_url(){
	$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2100,2100 ));
	return $src[0];
	}

	/* Add your nav menus function to the 'init' action hook. */
	add_action( 'init', 'tmnf_register_menus' );

	/* Add your sidebars function to the 'widgets_init' action hook. */
	add_action( 'widgets_init', 'tmnf_register_sidebars' );
}

function tmnf_register_menus() {
	register_nav_menus(array(
			'main-menu' => "Top Menu",
			'magazine-menu' => "Magazine Menu",
			'bottom-menu' => "Footer Menu"
	));
}

function tmnf_register_sidebars() {
	
	register_sidebar(array('name' => 'Sidebar','description' => 'Sidebar widget section (displayed on posts, pages and archives)','before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget">','after_title' => '</h2>'));
	
	//footer widgets
	register_sidebar(array('name' => 'Footer 1','description' => 'Widget section in footer - left','before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget">','after_title' => '</h2>'));
	register_sidebar(array('name' => 'Footer 2','description' => 'Widget section in footer - center/left','before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget">','after_title' => '</h2>'));
	register_sidebar(array('name' => 'Footer 3','description' => 'Widget section in footer - center/right','before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget">','after_title' => '</h2>'));
	register_sidebar(array('name' => 'Footer 4','description' => 'Widget section in footer - right','before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget">','after_title' => '</h2>'));
	
}

	
/*-----------------------------------------------------------------------------------
- Framework - Please refrain from editing this section 
----------------------------------------------------------------------------------- */

// Set path to Framework and theme specific functions
$functions_path = get_template_directory() . '/functions/';

// Theme specific functionality
require_once ($functions_path . 'theme-options.php'); 					// Options panel settings and custom settings
require_once ($functions_path . 'theme-actions.php');					// Theme actions & user defined hooks
require_once ($functions_path . 'admin-setup.php');						// Options panel variables and functions
require_once ($functions_path . 'admin-functions.php');					// Custom functions and plugins
require_once ($functions_path . 'admin-interface.php');					// Admin Interfaces
require_once ($functions_path . 'admin-shortcodes.php' );				// Shortcodes
require_once ($functions_path . 'admin-shortcode-generator.php' ); 		// Shortcode generator 

if (get_option('themnific_slider_gallery') <> "false") {require_once ($functions_path . 'theme-gallery.php'); } // Replace [gallery] shortcode with slider

//Add Custom Post Types
require_once ($functions_path . 'posttypes/post-metabox.php'); 			// custom meta box

	
/*-----------------------------------------------------------------------------------
- Enqueues scripts and styles for front end
----------------------------------------------------------------------------------- */ 

function tmnf_enqueue_style() {
	
	// Main stylesheet
	wp_enqueue_style( 'default_style', get_stylesheet_uri());
	
	// prettyPhoto css
	wp_enqueue_style('prettyPhoto', get_template_directory_uri() .	'/styles/prettyPhoto.css');
	
	// Shortcodes stylesheet
	wp_enqueue_style( 'shortcodes', get_template_directory_uri() . '/functions/css/shortcodes.css' );
	
	// Font Social Media css			
	wp_enqueue_style('fontello', get_template_directory_uri() .	'/styles/fontello.css');
	
	// Font Awesome css	
	wp_enqueue_style('font-awesome.min', get_template_directory_uri() .	'/styles/font-awesome.min.css');
	
	// Desaturate css
	if (get_option('themnific_desaturate') <> "false") { 	
		wp_register_style('desaturate', get_stylesheet_directory_uri() .	'/styles/desaturate.css');
			wp_enqueue_style( 'desaturate');
	}
		
	// Custom stylesheet
	wp_enqueue_style('style-custom', get_stylesheet_directory_uri() .	'/style-custom.css');
	
	
}
add_action( 'wp_enqueue_scripts', 'tmnf_enqueue_style' );




// themnific custom css + chnage the order of how the sytlesheets are loaded, and overrides WooCommerce styles.
function tmnf_custom_order() {
	
	// place wooCommerce styles before our main stlesheet
	if ( class_exists('woocommerce') ) {
		wp_dequeue_style( 'woocommerce_frontend_styles' );
		wp_enqueue_style('woocommerce_frontend_styles', plugins_url() .'/woocommerce/assets/css/woocommerce.css');
	}
	
	//wp_enqueue_style('woo-custom', get_stylesheet_directory_uri().	'/styles/woo-custom.css');
	wp_enqueue_style('mobile', get_stylesheet_directory_uri().'/style-mobile.css');
}
add_action('wp_enqueue_scripts', 'tmnf_custom_order');


function tmnf_enqueue_script() {

		// Load Common scripts	
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery.hoverIntent.minified', get_template_directory_uri().'/js/jquery.hoverIntent.minified.js','','', true);
		wp_enqueue_script('prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js','','', true);
		wp_enqueue_script('superfish', get_template_directory_uri().'/js/superfish.js','','', true);
		wp_enqueue_script('jquery.hoverIntent.minified', get_template_directory_uri().'/js/jquery.hoverIntent.minified.js','','', true);
		wp_enqueue_script('ownScript', get_template_directory_uri() .'/js/ownScript.js','','', true);
		
		// Load homepage slider scripts		
		$type_slider = get_option('themnific_carousel_position'); 
    	if($type_slider == 'pos4'){} else {
			wp_enqueue_script('jquery.flexslider-min', get_template_directory_uri() .'/js/jquery.flexslider-min.js','','', true);
			wp_enqueue_script('jquery.flexslider.start.carousel', get_template_directory_uri() .'/js/jquery.flexslider.start.carousel.js','','', true);
		};
		// Load layout scripts
		if (is_home()||is_front_page()||is_archive()||is_search()||is_page_template('homepage.php')) {
			wp_enqueue_script('jquery.isotope.min', get_template_directory_uri() . '/js/jquery.isotope.min.js','','', true);
			wp_enqueue_script('jquery.infinitescroll', get_template_directory_uri() .'/js/jquery.infinitescroll.js','','', true);
			wp_enqueue_script('jquery.isotope.start.infinite', get_template_directory_uri() . '/js/jquery.isotope.start.infinite.js','','', true);
		}
		
		// Singular comment script		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

}
	
add_action('wp_enqueue_scripts', 'tmnf_enqueue_script');

/*-----------------------------------------------------------------------------------
- Loads all the .php files found in /admin/widgets/ directory
----------------------------------------------------------------------------------- */

	$preview_template = _preview_theme_template_filter();

	if(!empty($preview_template)){
		$widgets_dir = WP_CONTENT_DIR . "/themes/".$preview_template."/functions/widgets/";
	} else {
    	$widgets_dir = WP_CONTENT_DIR . "/themes/".get_option('template')."/functions/widgets/";
    }
    
    if (@is_dir($widgets_dir)) {
		$widgets_dh = opendir($widgets_dir);
		while (($widgets_file = readdir($widgets_dh)) !== false) {
  	
			if(strpos($widgets_file,'.php') && $widgets_file != "widget-blank.php") {
				include_once($widgets_dir . $widgets_file);
			
			}
		}
		closedir($widgets_dh);
	}

	
/*-----------------------------------------------------------------------------------
- Other theme functions
----------------------------------------------------------------------------------- */

// Use shortcodes in text widgets.
add_filter('widget_text', 'do_shortcode');

// Make theme available for translation
load_theme_textdomain( 'themnific', get_template_directory() . '/lang' );

// Shorten post title
function short_title($after = '', $length) {
	$mytitle = explode(' ', get_the_title(), $length);
	if (count($mytitle)>=$length) {
		array_pop($mytitle);
		$mytitle = implode(" ",$mytitle). $after;
	} else {
		$mytitle = implode(" ",$mytitle);
	}
	return $mytitle;
}

// icons - font awesome
function tmnf_icon() {
	
	if(has_post_format('audio')) {return '<i class="fa fa-music"></i>';
	}elseif(has_post_format('gallery')) {return '<i class="fa fa-picture-o"></i>';	
	}elseif(has_post_format('link')) {return '<i class="fa fa-sign-out"></i>';			
	}elseif(has_post_format('quote')) {return '<i class="fa fa-quote-right"></i>';	
	} else {'';}	
	
}

function tmnf_icon_spec() {
	if(has_post_format('link')) {return '<i class="fa fa-sign-out"></i>';	
	} else {'';}
}

// icons ribbons - font awesome
function tmnf_ribbon() {
	if(has_post_format('video')) {return '<span class="ribbon video-ribbon"></span><span class="ribbon_icon"><i class="fa fa-play-circle"></i></span>';
	}elseif(has_post_format('audio')) {return '<span class="ribbon audio-ribbon"></span><span class="ribbon_icon"><i class="fa fa-microphone"></i></span>';
	}elseif(has_post_format('gallery')) {return '<span class="ribbon gallery-ribbon"></span><span class="ribbon_icon"><i class="fa fa-picture-o"></i></span>';
	}elseif(has_post_format('link')) {return '<span class="ribbon link-ribbon"></span><span class="ribbon_icon"><i class="fa fa-link"></i></span>';
	}elseif(has_post_format('image')) {return '<span class="ribbon image-ribbon"></span><span class="ribbon_icon"><i class="fa fa-camera"></i></span>';
	}elseif(has_post_format('quote')) {return '<span class="ribbon quote-ribbon"></span><span class="ribbon_icon"><i class="fa fa-quote-right"></i></span>';
	} else {}	
	
}



// link format
function tmnf_permalink() {
	$linkformat = get_post_meta(get_the_ID(), 'tmnf_linkss', true);
	if($linkformat) echo $linkformat; else the_permalink();
}

// ratings

function tmnf_rating() {
	$rinter = get_post_meta(get_the_ID(), 'tmnf_rating_main', true);
	if ($rinter > 0) {
	return  $rinter .'<span>&#37;</span>';}
}

function tmnf_rating_plus() {
	$rinter = get_post_meta(get_the_ID(), 'tmnf_rating_main', true);
	if ($rinter > 0) {
	return  $rinter .'<span>&#37;</span>';}
}

function tmnf_ratingbar() {
	$rinter = get_post_meta(get_the_ID(), 'tmnf_rating_main', true);
	if ($rinter > 0) {
	return  '<span class="ratingbar">
				<span class="overrating" style="width:'.$rinter .'%"></span>
				<span class="overratingnr">'. $rinter .'<br/><span>&#37;</span></span>
			</span>';}
}

function tmnf_ratings() {
	$rinter = get_post_meta(get_the_ID(), 'tmnf_rating_main', true);
	if ($rinter >= 94 && $rinter <= 100) {return '	<span class="rating_star">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
													</span>';}
													
	if ($rinter >= 85 && $rinter < 94) {return '	<span class="rating_star">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-half-o"></i>
													</span>';}
													
	if ($rinter >= 75 && $rinter < 84) {return '	<span class="rating_star">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
													</span>';}
													
	if ($rinter >= 65 && $rinter < 74) {return '	<span class="rating_star">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-half-o"></i>
														<i class="fa fa-star-o"></i>
													</span>';}
													
	if ($rinter >= 55 && $rinter < 64) {return '	<span class="rating_star">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</span>';}
													
	if ($rinter >= 45 && $rinter < 54) {return '	<span class="rating_star">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-half-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</span>';}

	if ($rinter >= 35 && $rinter < 44) {return '	<span class="rating_star">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</span>';}

	if ($rinter >= 25 && $rinter < 34) {return '	<span class="rating_star">
														<i class="fa fa-star"></i>
														<i class="fa fa-star-half-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</span>';}

	if ($rinter >= 15 && $rinter < 24) {return '	<span class="rating_star">
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</span>';}

	if ($rinter > 0 && $rinter < 14) {return '	<span class="rating_star">
														<i class="fa fa-star-half-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</span>';}

	if ($rinter = 0 ) {return '';}											
}


function tmnf_rating_cat() {
	$rcat = get_post_meta(get_the_ID(), 'tmnf_rating_category', true);
	$rcatcustom = get_post_meta(get_the_ID(), 'tmnf_rating_category_own', true);
	
		if($rcatcustom){
			return '<span class="nr customcat">'. $rcatcustom .'</span>';
		}elseif($rcat){
			return '<span class="nr '. $rcat .'">'. $rcat .'</span>';
		} else { }  
			
}


// new excerpt function

function tmnf_excerpt($length_callback='', $more_callback='') {
    global $post;
    if(function_exists($length_callback)){
    add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
    add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
    }



// Old Shorten Excerpt text for use in theme
function themnific_excerpt($text, $chars = 1620) {
	$text = $text." ";
	$text = substr($text,0,$chars);
	$text = substr($text,0,strrpos($text,' '));
	$text = $text."";
	return $text;
}

function trim_excerpt($text) {
     $text = str_replace('[', '', $text);
     $text = str_replace(']', '', $text);
     return $text;
    }
add_filter('get_the_excerpt', 'trim_excerpt');





// automatically add prettyPhoto rel attributes to embedded images
function gallery_prettyPhoto ($content) {
	return str_replace("<a", "<a rel='prettyPhoto[gallery]'", $content);
}

function insert_prettyPhoto_rel($content) {
	$pattern = '/<a(.*?)href="(.*?).(bmp|gif|jpeg|jpg|png)"(.*?)>/i';
  	$replacement = '<a$1href="$2.$3" rel=\'prettyPhoto\'$4>';
	$content = preg_replace( $pattern, $replacement, $content );
	return $content;
}
add_filter( 'the_content', 'insert_prettyPhoto_rel' );
add_filter( 'wp_get_attachment_link', 'gallery_prettyPhoto');


// function to display number of posts.
function tmnf_post_views($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count.'';
}

// function to count views.
function tmnf_count_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


// Add it to a column in WP-Admin
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('Просмотры', 'themnific');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
	if($column_name === 'post_views'){
        echo tmnf_post_views(get_the_ID());
    }
}



// pagination
function tmnf_pagination( $args = array() ) {
global $wp_rewrite, $wp_query;

/* If there's not more than one page, return nothing. */
if ( 1 >= $wp_query->max_num_pages )
return;

/* Get the current page. */
$current = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );

/* Get the max number of pages. */
$max_num_pages = intval( $wp_query->max_num_pages );

/* Get the pagination base. */
$pagination_base = $wp_rewrite->pagination_base;

/* Set up some default arguments for the paginate_links() function. */
$defaults = array(
'base' => add_query_arg( 'paged', '%#%' ),
'format' => '',
'total' => $max_num_pages,
'current' => $current,
'prev_next' => true,
//'prev_text' => __( '&laquo; Previous' ), // This is the WordPress default.
//'next_text' => __( 'Next &raquo;' ), // This is the WordPress default.
'show_all' => false,
'end_size' => 1,
'mid_size' => 1,
'add_fragment' => '',
'type' => 'plain',

// Begin loop_pagination() arguments.
'before' => '<nav class="pagination loop-pagination">',
'after' => '</nav>',
'echo' => true,
);

/* Add the $base argument to the array if the user is using permalinks. */
if ( $wp_rewrite->using_permalinks() && !is_search() )
$defaults['base'] = user_trailingslashit( trailingslashit( get_pagenum_link() ) . "{$pagination_base}/%#%" );

/* Allow developers to overwrite the arguments with a filter. */
$args = apply_filters( 'loop_pagination_args', $args );

/* Merge the arguments input with the defaults. */
$args = wp_parse_args( $args, $defaults );

/* Don't allow the user to set this to an array. */
if ( 'array' == $args['type'] )
$args['type'] = 'plain';

/* Get the paginated links. */
$page_links = paginate_links( $args );

/* Remove 'page/1' from the entire output since it's not needed. */
$page_links = preg_replace(
array(
"#(href=['\"].*?){$pagination_base}/1(['\"])#", // 'page/1'
"#(href=['\"].*?){$pagination_base}/1/(['\"])#", // 'page/1/'
"#(href=['\"].*?)\?paged=1(['\"])#", // '?paged=1'
"#(href=['\"].*?)&\#038;paged=1(['\"])#" // '&#038;paged=1'
),
'$1$2',
$page_links
);

/* Wrap the paginated links with the $before and $after elements. */
$page_links = $args['before'] . $page_links . $args['after'];

/* Allow devs to completely overwrite the output. */
$page_links = apply_filters( 'loop_pagination', $page_links );

/* Return the paginated links for use in themes. */
if ( $args['echo'] )
echo $page_links;
else
return $page_links;
}



//Breadcrumbs
function tmnf_breadcrumbs() {
	if (!is_home()) {
		echo '<a href="'. home_url().'">';
		echo '<i class="fa fa-home"></i> ';
		echo "</a> &raquo; ";
		if (is_category() || is_single()) {
		the_category(', ');
		if (is_single()) {
		echo " &raquo; ";
	echo short_title('...', 16);
	}
	} elseif (is_page()) {
	echo the_title();}
	}
}


function attachment_toolbox($size = thumbnail) {
	if($images = get_children(array(
		'post_parent'    => get_the_ID(),
		'post_type'      => 'attachment',
		'numberposts'    => -1, // show all
		'post_status'    => null,
		'post_mime_type' => 'image',
	))) {
		foreach($images as $image) {
			$attimg   = wp_get_attachment_image($image->ID,$size);
			$atturl   = wp_get_attachment_url($image->ID);
			$attlink  = get_attachment_link($image->ID);
			$postlink = get_permalink($image->post_parent);
			$atttitle = apply_filters('the_title',$image->post_title);

			echo '<p><strong>wp_get_attachment_image()</strong><br />'.$attimg.'</p>';
			echo '<p><strong>wp_get_attachment_url()</strong><br />'.$atturl.'</p>';
		}
	}
}

// allow contributor uploads
if ( current_user_can('contributor') && !current_user_can('upload_files') )
	add_action('admin_init', 'tmnf_allow_contributor_uploads');

function tmnf_allow_contributor_uploads() {
	$contributor = get_role('contributor');
	$contributor->add_cap('upload_files');
}

//Featured image in RSS feeds
function tmnf_image_in_rss($content)
{
    global $post;
    if (has_post_thumbnail($post->ID))
    {
        $content = get_the_post_thumbnail($post->ID, 'small', array('style' => 'margin-bottom:10px;')) . $content;
    }
    return $content;
}
add_filter('the_excerpt_rss', 'tmnf_image_in_rss');
add_filter('the_content_feed', 'tmnf_image_in_rss');


// meta sections
function tmnf_meta_small() {
	?>    
	<p class="meta">
		<?php the_time(get_option('date_format')); ?>  &bull; 
        <!-- <span class="views"><?php _e('Просмотры','themnific');?>: <?php echo tmnf_post_views(get_the_ID()); ?></span> -->
    <?php
}

function tmnf_meta_date() {
	?>    
	<span class="meta"> 
        <?php the_time(get_option('date_format')); ?>  &bull; </span>
    <?php
}

function tmnf_meta_date_alt() {
	?>    
	<span class="meta meta_alt"> 
        <?php the_time(get_option('date_format')); ?></span>
    <?php
}

function tmnf_meta() { ?>   
	<p class="meta">
		<?php the_time(get_option('date_format')); ?> &bull; 
		<?php the_category(', ') ?>  &bull;
         <span class="views"><?php _e('Просмотры','themnific');?>: <?php echo tmnf_post_views(get_the_ID()); ?></span> 
    </p>
<?php }

function tmnf_meta_full() { ?>    
	<p class="meta meta_full">
		<span><i class="fa fa-clock-o"></i> <?php the_time(get_option('date_format')); ?></span>
      	<span><i class="fa fa-comment-o"></i> <?php comments_popup_link( __('Комментарии (0)', 'themnific'), __('Комментарии (1)', 'themnific'), __('Комментарии (%)', 'themnific')); ?></span>
        <!-- <span class="views"><i class="fa fa-signal"></i> <?php _e('Просмотры','themnific');?>: <?php echo tmnf_post_views(get_the_ID()); ?></span> -->
		<span><i class="fa fa-file-o"></i> <?php the_category(', ') ?></span>
    </p>
<?php
}

function tmnf_meta_more() {
	?>    
	<p class="meta_more">
    		<a href="<?php tmnf_link() ?>"><?php _e('Читать','themnific');?></a>
    </p>
    <?php
}

// get featured image on posts screen  
function tmnf_get_featured_image($post_ID) {  
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);  
    if ($post_thumbnail_id) {  
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');  
        return $post_thumbnail_img[0];  
    }  
} 
    // ADD NEW COLUMN  
    function tmnf_columns_head($defaults) {  
        $defaults['featured_image'] = 'Featured Image';  
        return $defaults;  
    }  
    // SHOW THE FEATURED IMAGE  
    function tmnf_columns_content($column_name, $post_ID) {  
        if ($column_name == 'featured_image') {  
            $post_featured_image = tmnf_get_featured_image($post_ID);  
            if ($post_featured_image) {  
                echo '<img style=" width:100px;" src="' . $post_featured_image . '" />';  
            }  
        }  
    }  
add_filter('manage_posts_columns', 'tmnf_columns_head');  
add_action('manage_posts_custom_column', 'tmnf_columns_content', 10, 2); 


//////////
//WooCommerce
//////////



// Override theme default specification for product # per row
function loop_columns() {
return 5; // 5 products per row
}
add_filter('loop_shop_columns', 'loop_columns', 999);


// woocommerce images

//Hook in on activation
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'tmnf_woocommerce_image_dimensions', 1 );
 
// Define image sizes
function tmnf_woocommerce_image_dimensions() {
$catalog = array(
'width' => '184',	// px
'height'	=> '184',	// px
'crop'	=> 1 // true
);
 
// Woo Image sizes
update_option( 'shop_catalog_image_size', $catalog ); // Product category thumbs
}


// limit related na upsells posts

	function woo_related_products_limit() {
	global $product;
	$related = '';
	$args = array(
	'post_type' => 'product',
	'no_found_rows' => 1,
	'posts_per_page' => 1,
	'ignore_sticky_posts' => 1,
	'post__in' => $related,
	'post__not_in' => array($product->id)
	);
	return $args;
	}
	add_filter( 'woocommerce_related_products_args', 'woo_related_products_limit' );
	
	
	
	// first remove the action defined in woocommerce-hooks.php
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	 
	// modeled off of the woocommerce_upsell_display() function in woocommerce-template.php
	// change $columns to desired number of columns
	function my_woocommerce_upsell_display( $posts_per_page = '-1', $columns = 1, $orderby = 'rand' ) {
	woocommerce_get_template( 'single-product/up-sells.php', array(
	'posts_per_page' => $posts_per_page,
	'orderby' => $orderby,
	'columns' => $columns
	) );
	}
	// re-add the action for display
	add_action( 'woocommerce_after_single_product_summary', 'my_woocommerce_upsell_display', 15 );
	
	

// Walker menu
class tmnf_description_walker extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) 
      {
           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names ) . '"';

           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

           $prepend = '';
           $append = '';
           $description  = ! empty( $item->description ) ? '<div class="sub">'.esc_attr( $item->description ).'</div>' : '';

           if($depth != 0)
           {
                     $description = $append = $prepend = "";
           }

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= '</a>';
            $item_output .= $description.$args->link_after;
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
}

add_filter('wp_nav_menu', 'do_menu_shortcodes');
function do_menu_shortcodes( $menu ){
        return do_shortcode( $menu );
} 



?>