<?php

add_action('init','themnific_options');  
function themnific_options(){
	
// VARIABLES
$themename = "Block Magazine";
$shortname = "themnific";

// Populate option in array for use in theme 
global $themnific_options; 
$themnific_options = get_option('themnific_options');

$GLOBALS['template_path'] = get_template_directory_uri();;

//Access the WordPress Categories via an Array
$themnific_categories = array();  
$themnific_categories_obj = get_categories('hide_empty=0');
foreach ($themnific_categories_obj as $themnific_cat) {
    $themnific_categories[$themnific_cat->cat_ID] = $themnific_cat->cat_name;}
$categories_tmp = array_unshift($themnific_categories, "Select a category:");    
       
//Access the WordPress Pages via an Array
$themnific_pages = array();
$themnific_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($themnific_pages_obj as $themnific_page) {
    $themnific_pages[$themnific_page->ID] = $themnific_page->post_name; }
$themnific_pages_tmp = array_unshift($themnific_pages, "Select a page:");       

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

// Image Links to Options
$options_image_link_to = array("image" => "The Image","post" => "The Post"); 

//Testing 
$options_select = array("one","two","three","four","five"); 
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 


//Stylesheets Reader
$alt_stylesheet_path = get_template_directory() . '/styles/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}
// Set the Options Array
$bgurl =  get_template_directory_uri() . '/functions/images/bg';
//More Options
$all_uploads_path =  home_url() . '/wp-content/uploads/';
$all_uploads = get_option('themnific_uploads');
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

// THIS IS THE DIFFERENT FIELDS
$options = array();   

$options[] = array( "name" => "General Settings",
                    "type" => "heading");

$options[] = array( "name" => "Main Logo",
					"desc" => "Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)<br/>
					You need to use bigger logo, eg. theme demo uses 425x80px,",
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload");  

$options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload"); 
                                               
$options[] = array( "name" => "Tracking Code",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");  
					

		
// general layout

$options[] = array( "name" => "General Layout",
					"type" => "heading");   
					
$options[] = array( "name" => "Carousel Position",
					"desc" => "Choose where you want to display carousel.",
					"id" => $shortname."_carousel_position",
					"type" => "select2",
					"options" => array(
					"pos1" => "Above Header", 
					"pos2" => "Below Header",
					"pos3" => "In Footer",
					"pos4" => "Disable Carousel",
					) );
					
$options[] = array( "name" => "Carousel - Featured Category",
					"desc" => "Select a category for carousel.",
					"id" => $shortname."_carousel_cat",
					"std" => "Select a category:",
					"type" => "select",
					"options" => $themnific_categories);
					
$options[] = array("name" => "Carousel - Number of posts",
					"desc" => "",
					"id" => $shortname."_carousel_postnumber",
					"std" => "15",
					"type" => "text");

$options[] = array( "name" => "Replace native gallery [gallery] with slider",
                    "desc" => "Tick to enable classic grid gallery as slider.",
                    "id" => $shortname."_slider_gallery",
                    "std" => "true",
                    "type" => "checkbox");

$options[] = array( "name" => "Disable Footer Widget Section",
					"desc" => "Check to disable widgets in footer",
					"id" => $shortname."_widget_dis",
					"std" => "false",
					"type" => "checkbox"); 
					
					
// primary styling

$options[] = array( "name" => " Primary Styling",
					"type" => "heading");
			
$options[] = array( "name" => "General Text Font Style",
					"desc" => "Select the typography used as general text. <br />* semi-safe font <br />*** Google Webfonts.",
					"id" => $shortname."_font_text",
					"std" => array('size' => '13','face' => 'Droid Sans','style' => '400','color' => '#666'),
					"type" => "typography"); 
					
					
$options[] = array( "name" =>  "Body Background Color",
					"desc" => "Pick a custom color for body background color",
					"id" => "themnific_body_color",
					"std" => "#f5f5f5",
					"type" => "color");
					
$options[] = array( "name" =>  "Alternative Background Color",
					"desc" => "Pick a custom color for background color (Similar to 'Body Background Color' !!!)",
					"id" => "themnific_thi_body_color",
					"std" => "#fff",
					"type" => "color");	

					
$options[] = array( "name" =>  "Link Color",
					"desc" => "Pick a custom color for links.",
					"id" => "themnific_link_color",
					"std" => "#333",
					"type" => "color");     

$options[] = array( "name" =>  "Hover Color",
					"desc" => "Pick a custom color for links (hover).",
					"id" => "themnific_link_hover_color",
					"std" => "#FF8400",
					"type" => "color");  
					
$options[] = array( "name" =>  "Borders",
					"desc" => "Pick a custom color for body borders.",
					"id" => "themnific_border_color",
					"std" => "#e3e3e3",
					"type" => "color"); 
				
	
// secondary styling	
	
$options[] = array( "name" => "Secondary Styling",
					"type" => "heading");

$options[] = array( "name" =>  "Elements Color",
					"desc" => "Pick a custom color for background in 'Elements (Labels, Ribbons etc.),",
					"id" => "themnific_for_body_color",
					"std" => "#FFCC00",
					"type" => "color");	
 

$options[] = array( "name" =>  "Elements Text Color",
					"desc" => "Pick a custom color for texts and links in 'Elements',",
					"id" => "themnific_text_color_alter",
					"std" => "#000",
					"type" => "color");	
					
$options[] = array( "name" =>  "Footer & Post Label Background Color",
					"desc" => "Pick a custom color for background in footer and in homepage posts",
					"id" => $shortname."_ser_bg_color",
					"std" => "#333",
					"type" => "color");

$options[] = array( "name" =>  "Footer & Post Label Text Color",
					"desc" => "Pick a custom color for links (hover) in footer and in homepage posts.",
					"id" => $shortname."_sec_text_color",
					"std" => "#ccc",
					"type" => "color");  
     
					
$options[] = array( "name" =>  "Footer & Post Label Link Color",
					"desc" => "Pick a custom color for links in footer and in homepage posts.",
					"id" => $shortname."_sec_link_color",
					"std" => "#fff",
					"type" => "color");
					
$options[] = array( "name" =>  "Footer Borders",
					"desc" => "Pick a custom color for footer borders. e.g. #fff",
					"id" => "themnific_border_color_sec",
					"std" => "#444",
					"type" => "color"); 
					

// other styling	
	
$options[] = array( "name" => "Other Styling",
					"type" => "heading");
					

$options[] = array( "name" => "Navigation Font Style",
					"desc" => "Select the typography for Main navigation. <br />* semi-safe font <br />*** Google Webfonts.",
					"id" => $shortname."_font_nav",
					"std" => array('size' => '12','face' => 'Open Sans','style' => '600','color' => '#222'),
					"type" => "typography");  							
 
$options[] = array( "name" => "Navigation Background Color",
					"desc" => "Pick a custom color for Main navigation background",
					"id" => "themnific_custom_color",
					"std" => "#FFCC00",
					"type" => "color");

$options[] = array( "name" => "Desaturate Images",
                    "desc" => "Enable or disable desatureted images.",
                    "id" => $shortname."_desaturate",
                    "std" => "true",
                    "type" => "checkbox");

$options[] = array( "name" => "Show Uppercase Fonts",
                    "desc" => "You can disable general Uppercase style here.",
                    "id" => $shortname."_upper",
                    "std" => "true",
                    "type" => "checkbox"); 
					

// typography

$options[] = array( "name" => "Headings Typography",
					"type" => "heading");    


$options[] = array( "name" => "H1 Font Style",
					"desc" => "Select the typography you want for heading H1. <br />* semi-safe font <br />*** Google Webfonts.",
					"id" => $shortname."_font_h1",
					"std" => array('size' => '45','face' => 'Raleway','style' => '800','color' => '#000000'),
					"type" => "typography");  

$options[] = array( "name" => "H2 Style - Homepage",
					"desc" => "Select the typography you want for heading H2. <br />* semi-safe font <br />*** Google Webfonts.",
					"id" => $shortname."_font_h2_home",
					"std" => array('size' => '12','face' => 'Raleway','style' => '600','color' => '#000000'),
					"type" => "typography");  

$options[] = array( "name" => "H2 Font Style",
					"desc" => "Select the typography you want for heading H2. <br />* semi-safe font <br />*** Google Webfon.",
					"id" => $shortname."_font_h2",
					"std" => array('size' => '40','face' => 'Raleway','style' => '700','color' => '#000000'),
					"type" => "typography");  

$options[] = array( "name" => "H3 Font Style",
					"desc" => "Select the typography you want for heading H3 <br />* semi-safe font <br />*** Google Webfonts.",
					"id" => $shortname."_font_h3",
					"std" => array('size' => '24','face' => 'Open Sans','style' => '600','color' => '#4a4a4a'),
					"type" => "typography"); 

$options[] = array( "name" => "H4 & Main Buttons Font Style",
					"desc" => "Select the typography you want for heading H4. <br />* semi-safe font <br />*** Google Webfonts.",
					"id" => $shortname."_font_h4",
					"std" => array('size' => '14','face' => 'Raleway','style' => '600','color' => '#000000'),
					"type" => "typography");  
					
$options[] = array( "name" => "H5, H6 Font Style & Meta",
					"desc" => "Select the typography you want for heading H5 and H6. <br />* semi-safe font <br />*** Google Webfonts.",
					"id" => $shortname."_font_h5",
					"std" => array('size' => '11','face' => 'Open Sans','style' => '600','color' => '#4a4a4a'),
					"type" => "typography"); 


// post settings

$options[] = array( "name" => "Post Settings",
					"type" => "heading");    
			

$options[] = array( "name" => "Disable Featured Image",
					"desc" => "Check to disable featured image in single post",
					"id" => $shortname."_post_image_dis",
					"std" => "false",
					"type" => "checkbox");
					
$options[] = array( "name" => "Disable Author Info",
					"desc" => "Check to disable author section in single post",
					"id" => $shortname."_post_author_dis",
					"std" => "false",
					"type" => "checkbox");
					
$options[] = array( "name" => "Disable Post Breadcrumbs",
					"desc" => "Check to disable breadcrumbs section in single post",
					"id" => $shortname."_post_breadcrumbs_dis",
					"std" => "false",
					"type" => "checkbox");
					
$options[] = array( "name" => "Disable Next/Previous Post Section",
					"desc" => "Check to disable Next/Previous post in single post",
					"id" => $shortname."_post_nextprev_dis",
					"std" => "false",
					"type" => "checkbox");
					
$options[] = array( "name" => "Disable Related Posts",
					"desc" => "Check to disable related posts section in single post",
					"id" => $shortname."_post_related_dis",
					"std" => "false",
					"type" => "checkbox");

		
// social networks	

$options[] = array( "name" => "Social Networks",
    				"type" => "heading");
			

$options[] = array( "name" => "Rss Feed",
					"desc" => "",
					"id" => $shortname."_socials_rss",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Facebook",
					"desc" => "",
					"id" => $shortname."_socials_fa",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Twitter",
					"desc" => "",
					"id" => $shortname."_socials_tw",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Google+",
					"desc" => "",
					"id" => $shortname."_socials_googleplus",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Pinterest",
					"desc" => "",
					"id" => $shortname."_socials_pinterest",
					"std" => "",
					"type" => "text");
					

$options[] = array( "name" => "Instagram",
					"desc" => "",
					"id" => $shortname."_socials_instagram",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "You Tube",
					"desc" => "",
					"id" => $shortname."_socials_yo",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Vimeo",
					"desc" => "",
					"id" => $shortname."_socials_vi",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Tumblr",
					"desc" => "",
					"id" => $shortname."_socials_tu",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "500px",
					"desc" => "",
					"id" => $shortname."_socials_500px",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Flickr",
					"desc" => "",
					"id" => $shortname."_socials_fl",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "LinkedIn",
					"desc" => "",
					"id" => $shortname."_socials_li",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Foursquare",
					"desc" => "",
					"id" => $shortname."_socials_foursquare",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Dribbble",
					"desc" => "",
					"id" => $shortname."_socials_dribbble",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Skype",
					"desc" => "",
					"id" => $shortname."_socials_sk",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Stumbleupon",
					"desc" => "",
					"id" => $shortname."_socials_stumbleupon",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Github",
					"desc" => "",
					"id" => $shortname."_socials_github",
					"std" => "",
					"type" => "text");



					
// footer
$options[] = array( "name" => "Footer",
                    "type" => "heading");
					
$options[] = array( "name" => "Enable Custom Footer (Left)",
					"desc" => "Activate to add the custom text below to the theme footer.",
					"id" => $shortname."_footer_left",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => "Custom Text (Left)",
					"desc" => "Custom HTML and Text that will appear in the footer of your theme.",
					"id" => $shortname."_footer_left_text",
					"std" => "<p></p>",
					"type" => "textarea");
	
						
$options[] = array( "name" => "Enable Custom Footer (Right)",
					"desc" => "Activate to add the custom text below to the theme footer.",
					"id" => $shortname."_footer_right",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => "Custom Text (Right)",
					"desc" => "Custom HTML and Text that will appear in the footer of your theme.",
					"id" => $shortname."_footer_right_text",
					"std" => "<p></p>",
					"type" => "textarea");
					
// ads					
					
$options[] = array( "name" => "Static Ads",
					"type" => "heading");  

$options[] = array("name" => "Header Script Code",
					"desc" => "Enter your code here.",
					"id" => $shortname."_headeradscript",
					"std" => "",
					"type" => "textarea");  
					

$options[] = array("name" => "Header Image URL",
					"desc" => "Enter your image url here (728x90px).",
					"id" => $shortname."_headeradimg1",
					"std" => "",
					"type" => "text");   
	   
$options[] = array("name" => "Header Link URL",
					"desc" => "Enter link url here.",
					"id" => $shortname."_headeradurl1",
					"std" => "#",
					"type" => "text");
					
					

$options[] = array("name" => "Post Script Code",
					"desc" => "Enter your code here.",
					"id" => $shortname."_postscript",
					"std" => "",
					"type" => "textarea");  

$options[] = array("name" => "Post Image URL",
					"desc" => "Enter your image url here (728x90px).",
					"id" => $shortname."_postsimg1",
					"std" => "",
					"type" => "text");   
	   
$options[] = array("name" => "Post Link URL",
					"desc" => "Enter link url here.",
					"id" => $shortname."_postsurl1",
					"std" => "#",
					"type" => "text");


							                        
update_option('themnific_template',$options);      
update_option('themnific_themename',$themename);   
update_option('themnific_shortname',$shortname);

                                     
// Themnific Metabox Options
$themnific_metaboxes = array();

$themnific_metaboxes[] = array (	"name" => "image",
							"label" => "Image",
							"type" => "upload",
							"desc" => "Upload file here...");							
    
update_option('themnific_custom_template',$themnific_metaboxes);      

}

?>