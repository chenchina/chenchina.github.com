<?php

//Enable CoLabsSEO on these custom Post types
//$seo_post_types = array('post','page');
//define("SEOPOSTTYPES", serialize($seo_post_types));

//Global options setup
add_action('init','colabs_global_options');
function colabs_global_options(){
	// Populate CoLabsThemes option in array for use in theme
	global $colabs_options;
	$colabs_options = get_option('colabs_options');
}

add_action('admin_head','colabs_options');  
if (!function_exists('colabs_options')) {
function colabs_options(){
	
// VARIABLES
$themename = "Adam-Eve";
$manualurl = 'http://colorlabsproject.com';
$shortname = "colabs";

//Access the WordPress Categories via an Array
$colabs_categories = array();  
$colabs_categories_obj = get_categories('hide_empty=0');
foreach ($colabs_categories_obj as $colabs_cat) {
    $colabs_categories[$colabs_cat->cat_ID] = $colabs_cat->cat_name;}
//$categories_tmp = array_unshift($colabs_categories, "Select a category:");

//Access the WordPress Pages via an Array
$colabs_pages = array();
$colabs_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($colabs_pages_obj as $colabs_page) {
    $colabs_pages[$colabs_page->ID] = $colabs_page->post_name; }
//$colabs_pages_tmp = array_unshift($colabs_pages, "Select a page:");       

//Access the WordPress Author via an Array
$colabs_authors = array();
$colabs_authors_obj = get_users('orderby=nicename');    
foreach ($colabs_authors_obj as $colabs_author) {
    $colabs_authors[$colabs_author->ID] = $colabs_author->user_login; }
	
//Stylesheets Reader
$alt_stylesheet_path = TEMPLATEPATH . '/styles/';
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

//More Options
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");

$other_entries_10 = array("Select a number:","1","2","3","4","5","6","7","8","9","10");

$other_entries_4 = array("Select a number:","1","2","3","4");

// THIS IS THE DIFFERENT FIELDS
$options = array();

// General Settings
$options[] = array( "name" => "General Settings",
					"type" => "heading",
					"icon" => "general");
					

$options[] = array( "name" => "Custom Logo",
					"desc" => "Upload a logo for your theme, or specify an image URL directly. Best image size in 260x60 px",
					"id" => $shortname."_logo",
					"std" => trailingslashit( get_bloginfo('template_url') ) . "images/logo.png",
					"type" => "upload");

$options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16x16px ico image that will represent your website's favicon. Favicon/bookmark icon will be shown at the left of your blog's address in visitor's internet browsers.",
					"id" => $shortname."_custom_favicon",
					"std" => trailingslashit( get_bloginfo('template_url') ) . "images/favicon.png",
					"type" => "upload"); 
					
$options[] = array (  "id"  => $shortname."_sidebar_category",
					  "std"  => "Left",
					  "name" => "Archive/Category/Tag/Search Sidebar",
					  "type" => "radio",
					  "desc" => "Choose place for the sidebar at page.",
					  "options" => array(	"left" => "Left",
											"right" => "Right" ));
										

$options[] = array( "name" => "Enable/Disable Featured Slider",
					"desc" => "Enable Featured slider on front-page.",
					"id" => $shortname."_slider",
					"std" => "true",
					"type" => "checkbox");        

$options[] = array( "name" => "Custom Banner Icon",
					"desc" => "Upload a 45x39px (max: 52x45px) image that will represent your website's banner icon. This icon will be shown at the middle of your blog's banner image in visitor's internet browsers.",
					"id" => $shortname."_custom_bannericon",
					"std" => trailingslashit( get_bloginfo('template_url') ) . "images/love.png",
					"type" => "upload"); 
					
// Double Blog Options
$options[] = array( "name" => "1st Blog Settings",
					"type" => "heading",
					"icon" => "home");

$options[] = array( "name" => "First Author",
					"desc" => "Select 1st Author that will be displayed on left section of front-page.",
					"id" => $shortname."_author_left",
					"type" => "select2",
					"options" => $colabs_authors );

$options[] = array( "name" => "Slider Tag",
                    "desc" => "Add one or more tags that you would like to have displayed in the slider section on your homepage. For example, if you add 'tag1, tag3' here, then all posts tagged with either 'tag1' or 'tag3' will be shown in the slider.",
                    "id" => $shortname."_slider_tags1",
                    "std" => "tag, tag, tag",
                    "type" => "text");

$options[] = array( "name" => "Slider Entries",
                    "desc" => "Select the number of entries that should appear in the home page slider.",
                    "id" => $shortname."_slider_entries1",
                    "std" => "5",
                    "type" => "select",
                    "options" => $other_entries);
                    
$options[] = array( "name" => "Exclude Featured Posts",
					"desc" => "Exclude the slider posts from normal posts below slider.",
					"id" => $shortname."_slider_exclude1",
					"std" => "true",
					"type" => "checkbox");        

// Double Blog Options
$options[] = array( "name" => "2nd Blog Settings",
					"type" => "heading",
					"icon" => "home");

$options[] = array( "name" => "Second Author",
					"desc" => "Select 2nd Author that will be displayed on right section of front-page.",
					"id" => $shortname."_author_right",
					"type" => "select2",
					"options" => $colabs_authors );		

$options[] = array( "name" => "Slider Tag",
                    "desc" => "Add one or more tags that you would like to have displayed in the slider section on your homepage. For example, if you add 'tag1, tag3' here, then all posts tagged with either 'tag1' or 'tag3' will be shown in the slider.",
                    "id" => $shortname."_slider_tags2",
                    "std" => "tag, tag, tag",
                    "type" => "text");

$options[] = array( "name" => "Slider Entries",
                    "desc" => "Select the number of entries that should appear in the home page slider.",
                    "id" => $shortname."_slider_entries2",
                    "std" => "5",
                    "type" => "select",
                    "options" => $other_entries);
                    
$options[] = array( "name" => "Exclude Featured Posts",
					"desc" => "Exclude the slider posts from normal posts below slider.",
					"id" => $shortname."_slider_exclude2",
					"std" => "true",
					"type" => "checkbox");        

/* //Social Settings	 */				
  

$options[] = array( "name" => "Enable/Disable Social Share Button",
					"desc" => "Select which social share button you would like to enable on single post & pages.",
					"id" => $shortname."_single_share",
					"std" => array("fblike","twitter","google_plusone"),
					"type" => "multicheck2",
                    "class" => "",
					"options" => array(
                                    "fblike" => "Facebook Like Button",                                    
                                    "twitter" => "Twitter Share Button",
                                    "google_plusone" => "Google +1 Button",
                                )
                    ); 					

// Open Graph Settings
$options[] = array( "name" => "Open Graph Settings",
					"type" => "heading",
					"icon" => "graph");

$options[] = array( "name" => "Open Graph",
					"desc" => "Enable or disable Open Graph Meta tags.",
					"id" => $shortname."_og_enable",
					"type" => "select2",
                    "std" => "",
                    "class" => "collapsed",
					"options" => array("" => "Enable", "disable" => "Disable") );

$options[] = array( "name" => "Site Name",
					"desc" => "Open Graph Site Name ( og:site_name ).",
					"id" => $shortname."_og_sitename",
					"std" => "",
                    "class" => "hidden",
					"type" => "text");

$options[] = array( "name" => "Admin",
					"desc" => "Open Graph Admin ( fb:admins ).",
					"id" => $shortname."_og_admins",
					"std" => "",
                    "class" => "hidden",
					"type" => "text");

$options[] = array( "name" => "Image",
					"desc" => "You can put the url for your Open Graph Image ( og:image ).",
					"id" => $shortname."_og_img",
					"std" => "",
                    "class" => "hidden last",
					"type" => "text");

//Dynamic Images 					                   
$options[] = array( "name" => "Thumbnail Settings",
					"type" => "heading",
					"icon" => "image");
                    
$options[] = array( "name" => "WordPress Featured Image",
					"desc" => "Use WordPress Featured Image for post thumbnail.",
					"id" => $shortname."_post_image_support",
					"std" => "true",
					"class" => "collapsed",
					"type" => "checkbox");

$options[] = array( "name" => "WordPress Featured Image - Dynamic Resize",
					"desc" => "Resize post thumbnail dynamically using WordPress native functions (requires PHP 5.2+).",
					"id" => $shortname."_pis_resize",
					"std" => "true",
					"class" => "hidden",
					"type" => "checkbox");
                    
$options[] = array( "name" => "WordPress Featured Image - Hard Crop",
					"desc" => "Original image will be cropped to match the target aspect ratio.",
					"id" => $shortname."_pis_hard_crop",
					"std" => "true",
					"class" => "hidden last",
					"type" => "checkbox");
                    
$options[] = array( "name" => "TimThumb Image Resizer",
					"desc" => "Enable timthumb.php script which dynamically resizes images added thorugh post custom field.",
					"id" => $shortname."_resize",
					"std" => "true",
					"type" => "checkbox");
                    
$options[] = array( "name" => "Automatic Thumbnail",
					"desc" => "Generate post thumbnail from the first image uploaded in post (if there is no image specified through post custom field or WordPress Featured Image feature).",
					"id" => $shortname."_auto_img",
					"std" => "true",
					"type" => "checkbox");
                    
$options[] = array( "name" => "Thumbnail Image in RSS Feed",
					"desc" => "Add post thumbnail to RSS feed article.",
					"id" => $shortname."_rss_thumb",
					"std" => "false",
					"type" => "checkbox");

$options[] = array( "name" => "Thumbnail Image Dimensions",
					"desc" => "Enter an integer value i.e. 250 for the desired size which will be used when dynamically creating the images.",
					"id" => $shortname."_image_dimensions",
					"std" => "",
					"type" => array( 
									array(  'id' => $shortname. '_thumb_w',
											'type' => 'text',
											'std' => 100,
											'meta' => 'Width'),
									array(  'id' => $shortname. '_thumb_h',
											'type' => 'text',
											'std' => 100,
											'meta' => 'Height')
								  ));

// Analytics ID, RSS feed
$options[] = array( "name" => "Analytics ID, RSS feed",
					"type" => "heading",
					"icon" => "statistics");
                    
$options[] = array( "name" => "GoSquared Token",
					"desc" => "You can use <a href='http://www.gosquared.com/livestats/?ref=11674'>GoSquared</a> real-time web analytics. Enter your <strong>GoSquared Token</strong> here (ex. GSN-893821-D).",
					"id" => $shortname."_gosquared_id",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Google Analytics",
					"desc" => "Manage your website statistics with Google Analytics, put your Analytics Code here. ",
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");

$options[] = array( "name" => "Feedburner URL",
					"desc" => "Feedburner URL. This will replace RSS feed link. Start with http://.",
					"id" => $shortname."_feedlinkurl",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Feedburner Comments URL",
					"desc" => "Feedburner URL. This will replace RSS comment feed link. Start with http://.",
					"id" => $shortname."_feedlinkcomments",
					"std" => "",
					"type" => "text");

// Footer Settings
$options[] = array( "name" => "Footer Settings",
					"type" => "heading",
					"icon" => "footer");    

$options[] = array( "name" => "Enable / Disable Custom Credit (Right)",
					"desc" => "Activate to add custom credit on footer area.",
					"id" => $shortname."_footer_credit",
					"class" => "collapsed",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => "Footer Credit",
                    "desc" => "You can customize footer credit on footer area here.",
                    "id" => $shortname."_footer_credit_txt",
                    "std" => "",
					"class" => "hidden last",                    
                    "type" => "textarea");
/* //Quote Form */
$options[] = array( "name" => "Contact Form",
					"type" => "heading",
					"icon" => "general");    
$options[] = array( "name" => "Destination Email Address",
					"desc" => "All inquiries made by your visitors through the Contact Form page will be sent to this email address.",
					"id" => $shortname."_contactform_email",
					"std" => "",
					"type" => "text"); 


// Add extra options through function
if ( function_exists("colabs_options_add") )
	$options = colabs_options_add($options);

if ( get_option('colabs_template') != $options) update_option('colabs_template',$options);      
if ( get_option('colabs_themename') != $themename) update_option('colabs_themename',$themename);   
if ( get_option('colabs_shortname') != $shortname) update_option('colabs_shortname',$shortname);
if ( get_option('colabs_manual') != $manualurl) update_option('colabs_manual',$manualurl);


// CoLabs Metabox Options
// Start name with underscore to hide custom key from the user
$colabs_metaboxes = array();
$colabs_metabox_settings = array();
global $post;

    //Metabox Settings
    $colabs_metabox_settings['post'] = array(
                                'id' => 'colabsthemes-settings',
								'title' => 'ColorLabs' . __( ' Image/Video Settings', 'colabsthemes' ),
								'callback' => 'colabsthemes_metabox_create',
								'page' => 'post',
								'context' => 'normal',
								'priority' => 'high',
                                'callback_args' => ''
								);
                                    
    $colabs_metabox_settings['page'] = array();

if ( ( get_post_type() == 'post') || ( !get_post_type() ) ) {
	$colabs_metaboxes[] = array (  "name"  => $shortname."_single_top",
					            "std"  => "Image",
					            "label" => "Item to Show",
					            "type" => "radio",
					            "desc" => "Choose Image/Embed Code to appear at the single top.",
								"options" => array(	"none" => "None",
													"single_image" => "Image",
													"single_video" => "Embed" ));
	$colabs_metaboxes[] = array (	"name" => "image",
								"label" => "Post Custom Image",
								"type" => "upload",
                                "class" => "single_image",
								"desc" => "Upload an image or enter an URL.");
	
	$colabs_metaboxes[] = array (  "name"  => $shortname."_embed",
					            "std"  => "",
					            "label" => "Video Embed Code",
					            "type" => "textarea",
                                "class" => "single_video",
					            "desc" => "Enter the video embed code for your video (YouTube, Vimeo or similar)");
					            
} // End post

// Add extra metaboxes through function
if ( function_exists("colabs_metaboxes_add") ){
	$colabs_metaboxes = colabs_metaboxes_add($colabs_metaboxes);
    }
if ( get_option('colabs_custom_template') != $colabs_metaboxes){
    update_option('colabs_custom_template',$colabs_metaboxes);
    }
if ( get_option('colabs_metabox_settings') != $colabs_metabox_settings){
    update_option('colabs_metabox_settings',$colabs_metabox_settings);
    }
     
}
}



?>