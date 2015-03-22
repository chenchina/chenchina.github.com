<?php 

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Excerpt
- Page navigation
- CoLabsTabs - Popular Posts
- CoLabsTabs - Latest Posts
- CoLabsTabs - Latest Comments
- Post Meta
- Dynamic Titles
- WordPress 3.0 New Features Support
- using_ie - Check IE
- post-thumbnail - WP 3.0 post thumbnails compatibility
- automatic-feed-links Features
- colabs_share - Twitter, FB & Google +1
- colabs_link - Alternate Link & RSS URL
- Open Graph Meta Function
- Search Form
- CoLabs- Flickr
- colabs_googlemap - Google Maps Function
- CoLabs - Add User Meta
- Post Meta
- CoLabs - Footer Credit
- CoLabs - List Comment
- Responsive Caption


-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* SET GLOBAL CoLabs VARIABLES
/*-----------------------------------------------------------------------------------*/

// Slider Tags
	$GLOBALS['slide_tags_array'] = array();
// Duplicate posts 
	$GLOBALS['shownposts'] = array();

/*-----------------------------------------------------------------------------------*/
/* Excerpt
/*-----------------------------------------------------------------------------------*/

//Add excerpt on pages
if(function_exists('add_post_type_support'))
add_post_type_support('page', 'excerpt');

/** Excerpt character limit */
/* Excerpt length */
function colabs_excerpt_length($length) {
if( get_option('colabs_excerpt_length') != '' ){
        return get_option('colabs_excerpt_length');
    }else{
        return 45;
    }
}
add_filter('excerpt_length', 'colabs_excerpt_length');

/** Remove [..] in excerpt */
function colabs_trim_excerpt($text) {
  return rtrim($text,'[...]');
}
add_filter('get_the_excerpt', 'colabs_trim_excerpt');

/** Add excerpt more */
function colabs_excerpt_more($more) {
    global $post;
	//return '<span class="more"><a href="'. get_permalink($post->ID) . '">'. __( 'Read more', 'colabsthemes' ) . '&hellip;</a></span>';
}
add_filter('excerpt_more', 'colabs_excerpt_more');

// Shorten Excerpt text for use in theme
function colabs_excerpt($text, $chars = 120) {
	$text = $text." ";
	$text = substr($text,0,$chars);
	$text = substr($text,0,strrpos($text,' '));
	$text = $text."...";
	return $text;
}



// get_the_excerpt filter
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_trim_excerpt');

function custom_trim_excerpt($text) { // Fakes an excerpt if needed
global $post;
	if ( '' == $text ) {
		$text = get_the_content('');

		$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		$text = strip_tags($text);
		$excerpt_length = apply_filters('excerpt_length', 45);
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words) > $excerpt_length) {
			array_pop($words);
            $excerpt_more = apply_filters('excerpt_more', '...');
			array_push($words, '...');
            array_push($words, $excerpt_more);
			$text = implode(' ', $words);
		}
	}
	return $text;
}
//Custom Excerpt Function
function colabs_custom_excerpt($limit,$more) {
	global $post;
	if ($limit=='')$limit=35;
	$print_excerpt .= '<p>';
	$output = $post->post_excerpt;
	if ($output!=''){
	$print_excerpt .= $output;
	}else{
	$content = get_the_content('');
	$content = strip_shortcodes( $content );
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	$content = strip_tags($content);	
	$excerpt = explode(' ',$content, $limit);
	array_pop($excerpt);
	$print_excerpt .= implode(" ",$excerpt).$more;
	}
	$excerpt .= '</p>';
	echo $print_excerpt;
}
/*-----------------------------------------------------------------------------------*/
/* Breadcrumbs */
/*-----------------------------------------------------------------------------------*/
if(!function_exists('colabs_breadcrumb')){
function colabs_breadcrumb() {
     
  $delimiter = '&raquo;';
  $home = 'Home'; // text for the 'Home' link
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    //echo '<div id="crumbs">';
 
    global $post;
    $homeLink = get_bloginfo('url');
    echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
    if ( is_category() || is_tax() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . single_cat_title('', false) . $after;
	
	} elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_search() ) {
      echo $before . 'Search results for "' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . 'Articles posted by ' . $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
      echo $before . 'Error 404' . $after;
    } 
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    //echo '</div>';
 
  }
}}

/*End of Breadcrumbs*/

/*-----------------------------------------------------------------------------------*/
/* Page navigation */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('colabs_pagenav')) {
	function colabs_pagenav() {   
	    
			 if ( get_next_posts_link() || get_previous_posts_link() ) { ?>

                <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&laquo;</span> Previous Entries', 'colabsthemes' ) ); ?></div>
                <div class="nav-next"><?php previous_posts_link( __( 'Next Entries <span class="meta-nav">&raquo;</span>', 'colabsthemes' ) ); ?></div>

			<?php } ?>

		<?php 
	}
}

if (!function_exists('colabs_postnav')) {
	function colabs_postnav() {
		?>
    <div class="navigation">
        <div class="navleft fl"><?php next_post_link('%link','&laquo; Prev') ;?></div>
		<div class="navcenter gohome"><a href="<?php echo get_option('home');?>">Back to home</a></div>
        <div class="navright fr"><?php previous_post_link('%link','Next &raquo;'); ?></div>
        
    </div><!--/.navigation-->
		<?php 
	}
}


if (!function_exists('colabs_custom_pagination')) {
function colabs_custom_pagination($pages = '', $range = 2)
{
     $showitems = ($range * 2)+1;
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }
	 
 
     if(1 != $pages)
     {
         echo "<div id='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a class='link-button' href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a class='link-button' href='".get_pagenum_link($paged - 1)."'>Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='link-button current'>".$i."</span>":"<a class='link-button' href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a class='link-button' href='".get_pagenum_link($paged + 1)."'>Next</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a class='link-button' href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}
}
/*-----------------------------------------------------------------------------------*/
/* CoLabsTabs - Popular Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('colabs_404')) {
	function colabs_404(){

        echo "<p>It seems that page you were looking for doesn't exist.Try searching the site.</p>";
   
	}
}
/*-----------------------------------------------------------------------------------*/
/* CoLabsTabs - Popular Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('colabs_tabs_popular')) {
	function colabs_tabs_popular( $posts = 5, $size = 35 ) {
		global $post;
		$popular = get_posts('caller_get_posts=1&orderby=comment_count&showposts='.$posts);
		foreach($popular as $post) :
			setup_postdata($post);
	?>
	<li>
		<?php if ($size <> 0) colabs_image('height='.$size.'&width='.$size.'&class=thumbnail&single=true'); ?>
		<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
		<span class="meta"><?php the_time( get_option( 'date_format' ) ); ?></span>
		<div class="fix"></div>
	</li>
	<?php endforeach;
	}
}

/*-----------------------------------------------------------------------------------*/
/* CoLabsTabs - Latest Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('colabs_tabs_latest')) {
	function colabs_tabs_latest( $posts = 5, $size = 35 ) {
		global $post;
		$latest = get_posts('caller_get_posts=1&showposts='. $posts .'&orderby=post_date&order=desc');
		foreach($latest as $post) :
			setup_postdata($post);
	?>
	<li>
		<?php if ($size <> 0) colabs_image('height='.$size.'&width='.$size.'&class=thumbnail&single=true'); ?>
		<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
		<span class="meta"><?php the_time( get_option( 'date_format' ) ); ?></span>
		<div class="fix"></div>
	</li>
	<?php endforeach; 
	}
}

/*-----------------------------------------------------------------------------------*/
/* CoLabsTabs - Latest Comments */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('colabs_tabs_comments')) {
	function colabs_tabs_comments( $posts = 5, $size = 35 ) {
		global $wpdb;
		$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
		comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved,
		comment_type,comment_author_url,
		SUBSTRING(comment_content,1,50) AS com_excerpt
		FROM $wpdb->comments
		LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
		$wpdb->posts.ID)
		WHERE comment_approved = '1' AND comment_type = '' AND
		post_password = ''
		ORDER BY comment_date_gmt DESC LIMIT ".$posts;
		
		$comments = $wpdb->get_results($sql);
		
		foreach ($comments as $comment) {
		?>
		<li>
			<?php echo get_avatar( $comment, $size ); ?>
		
			<a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php _e('on ', 'colabsthemes'); ?> <?php echo $comment->post_title; ?>">
                <span class="author"><?php echo strip_tags($comment->comment_author); ?></span></a>: <span class="comment"><?php echo strip_tags($comment->com_excerpt); ?>...</span>
			
			<div class="fix"></div>
		</li>
		<?php 
		}
	}
}



/*-----------------------------------------------------------------------------------*/
/* Dynamic Titles */
/*-----------------------------------------------------------------------------------*/
// This sets your <title> depending on what page you're on, for better formatting and for SEO

function dynamictitles() {
	
	if ( is_single() ) {
      wp_title('');
     
 
} else if ( is_page() || is_paged() ) {
      
      echo (''.__('Archive for','colabsthemes').'');
 
} else if ( is_author() ) {
     
      wp_title(''.__('Author','colabsthemes').'');	  
	  
} else if ( is_category() ) {
      
      wp_title(''.__('Category for','colabsthemes').'');
      

} else if ( is_tag() ) {
      
      wp_title(''.__('Tag archive for','colabsthemes').'');

} else if ( is_archive() ) {
      
      echo (''.__('Archive for','colabsthemes').'');
     

} else if ( is_search() ) {
      
      echo (''.__('Search Results','colabsthemes').'');
 
} else if ( is_404() ) {
      
      echo (''.__('404 Error (Page Not Found)','colabsthemes').'');
	  
} else if ( is_home() ) {
      bloginfo('name');
      echo (' | ');
      bloginfo('description');
 
} else {
      bloginfo('name');
      echo (' | ');
      echo (''.$blog_longd.'');
}
}

/*-----------------------------------------------------------------------------------*/
/* WordPress 3.0 New Features Support */
/*-----------------------------------------------------------------------------------*/

if ( function_exists('register_nav_menus') ) {
	add_theme_support( 'nav-menus' );
    register_nav_menus( array(
        'main-menu' => __( 'Top Menu','colabsthemes' ),
		'footer-menu' => __( 'Footer Menu','colabsthemes' ),
));    
}

/* CallBack functions for menus in case of earlier than 3.0 Wordpress version or if no menu is set yet*/
function topmenu(){ ?>
  <div class="top-menu"><ul>
    <li><a href="<?php bloginfo( 'wpurl' ); ?>/wp-admin/nav-menus.php">Click to add menu</a></li>
  </ul></div>
<?php }
function footmenu(){ ?>
  <div class="menu"><ul>
    <li><a href="<?php bloginfo( 'wpurl' ); ?>/wp-admin/nav-menus.php">Click to add menu</a></li>
  </ul></div>
<?php }
/*-----------------------------------------------------------------------------------*/
/* using_ie - Check IE */
/*-----------------------------------------------------------------------------------*/
//check IE
function using_ie()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;    
}

/*-----------------------------------------------------------------------------------*/
/*  WP 3.0 post thumbnails compatibility */
/*-----------------------------------------------------------------------------------*/
if(function_exists( 'add_theme_support')){
	//if(get_option( 'colabs_post_image_support') == 'true'){
    if( get_option('colabs_post_image_support') ){
        add_theme_support( 'post-thumbnails' );		
		// set height, width and crop if dynamic resize functionality isn't enabled
		if ( get_option( 'colabs_pis_resize') <> "true" ) {
			$hard_crop = get_option( 'colabs_pis_hard_crop' );
			if($hard_crop == 'true') {$hard_crop = true; } else { $hard_crop = false;} 
			add_image_size( 'slider-thumb', 452, 202, $hard_crop);
			add_image_size( 'index-thumb1', 327, 150, $hard_crop);
			add_image_size( 'index-thumb2', 131, 92, $hard_crop);
			add_image_size( 'sidebar-thumb', 170, 170, $hard_crop);
			add_image_size( 'widget-thumb1', 210, 130, $hard_crop);
			add_image_size( 'widget-thumb2', 280, 154, $hard_crop);
			add_image_size( 'single-thumb', 690, 9999, $hard_crop);
			add_image_size( 'full-thumb', 930, 9999, $hard_crop);
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/*  automatic-feed-links Features  */
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'add_theme_support' ) && get_option('colabs_feedlinkurl') == '' ) {
add_theme_support( 'automatic-feed-links' );
}

/*-----------------------------------------------------------------------------------*/
/*  colabs_share - Twitter, FB & Google +1    */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'colabs_share' ) ) {
function colabs_share() {
    
$return = '';


$colabs_share_twitter = get_option('colabs_single_share_twitter');
$colabs_share_fblike = get_option('colabs_single_share_fblike');
$colabs_share_fb = get_option('colabs_single_share_fb');
$colabs_share_google_plusone = get_option('colabs_single_share_google_plusone');


    //Share Button Functions 
    global $colabs_options;
    $url = get_permalink();
    $share = '';
    
    //Twitter Share Button
    if(function_exists('colabs_shortcode_twitter') && $colabs_share_twitter == "true"){
        $tweet_args = array(  'url' => $url,
   							'style' => 'vertical',
   							'source' => ( $colabs_options['colabs_twitter_username'] )? $colabs_options['colabs_twitter_username'] : '',
   							'text' => '',
   							'related' => '',
   							'lang' => '',
   							'float' => 'left'
                        );

        $share .= colabs_shortcode_twitter($tweet_args);
    }
    
    //Facebook Like Button
    if(function_exists('colabs_shortcode_fblike') && $colabs_share_fblike == "true"){
    $fblike_args = 
    array(	
        'float' => 'left',
        'url' => '',
        'style' => 'box_count',
        'showfaces' => 'false',
        'width' => '62',
        'height' => '',
        'verb' => 'like',
        'colorscheme' => 'light',
        'font' => 'arial'
        );
        $share .= colabs_shortcode_fblike($fblike_args);    
    }
        
    //Google +1 Share Button
    if( function_exists('colabs_shortcode_google_plusone') && $colabs_share_google_plusone == "true"){
        $google_args = array(
						'size' => 'tall',
						'language' => '',
						'count' => '',
						'href' => $url,
						'callback' => '',
						'float' => 'left'
					);        

        $share .= colabs_shortcode_google_plusone($google_args);       
    }
    
    $return .= '<div class="clear"></div><div class="social_share clearfloat">'.$share.'</div><div class="clear"></div>';
    
    return $return;
}
}
/*-----------------------------------------------------------------------------------*/
/* colabs_link - Alternate Link & RSS URL */
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_head', 'colabs_link' );
if (!function_exists('colabs_link')) {
function colabs_link(){ 
?>	
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( get_option('colabs_feedlinkurl') ) { echo get_option('colabs_feedlinkurl'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<?php 
}}

/*-----------------------------------------------------------------------------------*/
/*  Open Graph Meta Function    */
/*-----------------------------------------------------------------------------------*/
function colabs_meta_head(){
    do_action( 'colabs_meta' );
}
add_action( 'colabs_meta', 'og_meta' );  

if (!function_exists('og_meta')) {
function og_meta(){ ?>
	<?php if ( is_home() && get_option( 'colabs_og_enable' ) == '' ) { ?>
	<meta property="og:title" content="<?php echo bloginfo('name');; ?>" />
	<meta property="og:type" content="author" />
	<meta property="og:url" content="<?php echo get_option('home'); ?>" />
	<meta property="og:image" content="<?php echo get_option('colabs_og_img'); ?>"/>
	<meta property="og:site_name" content="<?php echo get_option('colabs_og_sitename'); ?>" />
	<meta property="fb:admins" content="<?php echo get_option('colabs_og_admins'); ?>" />
	<meta property="og:description" content="<?php echo get_option('blogdescription '); ?>" />
	<?php } ?>
	
	<?php if ( ( is_page() || is_single() ) && get_option( 'colabs_og_enable' ) == '' ) { ?>
	<meta property="og:title" content="<?php the_title(); ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="<?php echo get_post_meta($post->ID, 'yourls_shorturl', true) ?>" />
	<meta property="og:image" content="<?php $values = get_post_custom_values("Image"); ?><?php echo get_option('home'); ?>/<?php echo $values[0]; ?>"/>
	<meta property="og:site_name" content="<?php echo get_option('colabs_og_sitename'); ?>" />
	<meta property="fb:admins" content="<?php echo get_option('colabs_og_admins'); ?>" />
	<?php } ?>
    
    <meta name="viewport" content="width=1024,maximum-scale=1.0" />
<?php
}}
	
/*-----------------------------------------------------------------------------------*/	
/* Search Form*/
/*-----------------------------------------------------------------------------------*/
function custom_search( $form ) {

    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'custom_search' );

/*-----------------------------------------------------------------------------------*/
/* CoLabs- Flickr */
/*-----------------------------------------------------------------------------------*/    

require_once ($includes_path . 'theme-flickr.php');

if(!function_exists('getmyflickr')){
function getmyflickr($account,$count){

$flickr_url= 'http://api.flickr.com/services/feeds/photos_public.gne?id=';

$flickr_url.= $account ;

$flickr_url.= '&display=latest&lang=en-us&format=rss_200';

$flickr = new FlickrImages( $flickr_url );

	$title = $flickr->getTitle();

	$url = $flickr->getProfileLink();

	$images = $flickr->getImages();

	$i=1;$j=1;	

	

	$output = '<div class="flickr"><ul >';

	foreach( $images as $img ) {

		if ($i<=$count){

		$output .= '<li>';

		$output .= '<a href="' . $img[ 'link' ] . '">';

		$output .=  $img[ 'thumb' ] ;

		$output .= '</a></li>';

		}

		$i++;$j++;

	}

	$output .= '</ul></div>';

	echo $output;



}}

/*-----------------------------------------------------------------------------------*/
/*  colabs_googlemap - Google Maps Function   */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('colabs_googlemap')) {
function colabs_googlemap($latlong, $address, $zoom, $type, $content, $directionsto) {
	
	if (!$latlong) {$latlong = '0';}
	if (!$zoom) {$zoom = 12;} // 1-19
	if (!$type) {$type = 'ROADMAP';} // ROADMAP, SATELLITE, HYBRID, TERRAIN
	if (!$content) {$content = '';}
	if (!$address) {$address = '';}
	
	$content = str_replace('&lt;', '<', $content);
	$content = str_replace('&gt;', '>', $content);
	$content = mysql_escape_string($content);
	if ($directionsto) { $directionsForm = "<form method=\"get\" action=\"http://maps.google.com/maps\"><input type=\"hidden\" name=\"daddr\" value=\"".$directionsto."\" /><input type=\"text\" class=\"text\" name=\"saddr\" /><input type=\"submit\" class=\"submit\" value=\"Directions\" /></form>"; }

	if ($latlong!='0') {	
		return "
		<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>
		<script type='text/javascript'>
			function makeMap() {
				var latlng = new google.maps.LatLng(".$latlong.");
				
				var myOptions = {
					zoom: ".$zoom.",
					center: latlng,
					mapTypeControl: true,
					mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
					navigationControl: true,
					navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
					mapTypeId: google.maps.MapTypeId.".$type."
				};
				var map = new google.maps.Map(document.getElementById('colabsgoogle'), myOptions);
				
				var contentString = '<div class=\"infoWindow\">".$content.$directionsForm."</div>';
				var infowindow = new google.maps.InfoWindow({
					content: contentString
				});
				
				var marker = new google.maps.Marker({
					position: latlng,
					map: map,
					title: ''
				});
				
				google.maps.event.addListener(marker, 'click', function() {
				  infowindow.open(map,marker);
				});
			}
			window.onload = makeMap;
		</script>
		
		<div id='colabsgoogle' class='mapbox'></div>
		";
	}else{
		return "
		<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>
		<script>
		/* <![CDATA[ */
		function setMapAddress(address)
		{
			var geocoder = new google.maps.Geocoder();

			geocoder.geocode( { address : address }, function( results, status ) {
				if( status == google.maps.GeocoderStatus.OK ) {
					var latlng = results[0].geometry.location;
					var options = {
						zoom: 15,
						center: latlng,
						mapTypeId: google.maps.MapTypeId.ROADMAP, 
						streetViewControl: true
					};

					var mymap = new google.maps.Map( document.getElementById( 'colabsgoogle' ), options );
					
					var marker = new google.maps.Marker({
					map: mymap, 
					position: results[0].geometry.location
				});
					
				}
			} );
		}

		setMapAddress( '".$address."');

		/* ]]> */
		</script>
		<div id='colabsgoogle' class='mapbox'></div>
		";
	}
}} 

/*-----------------------------------------------------------------------------------*/
/* CoLabs - Add User Meta */
/*-----------------------------------------------------------------------------------*/ 
function new_user_meta( $contactmethods ) {

$contactmethods['twitter'] = 'Twitter';

$contactmethods['facebook'] = 'Facebook';

return $contactmethods;
}
//add_filter('user_contactmethods','new_user_meta',10,1);

/*-----------------------------------------------------------------------------------*/
/* Post Meta */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('colabs_post_meta')) {
	function colabs_post_meta( ) {
?>
   <div class="post-meta">
    <div class="meta-date">
   
        <?php the_time(); ?>
     
    </div>
    <div class="meta-author">Posted by
      <?php the_author_posts_link(); ?>
	  <div class="author-description">
	  <?php 
	  $email = get_the_author_email();
	  echo get_avatar($email,45);?>
	  <p><?php the_author_meta( 'description' ); ?></p>
	  </div>
    </div>
	<?php 
	$category = get_the_category(); 
	if ($category[0]->cat_name!=''){?>
	<div class="meta-topic">
	<?php the_category(', '); ?>
	</div>
	<?php } ?>
	<?php 
	$tags = get_the_tags();
	foreach ($tags as $tag){
	$havetag[]=$tag->name;
	}
	if($havetag[0]!=''){
	?>
    <div class="meta-topic">
      <?php the_tags('', ', ', ''); ?>
    </div>
	<?php }?>
    <div class="meta-comments">
		<a href="<?php comments_link(); ?>">
      <?php comments_number( 'Add Comment', '1 Comment', '% Comments' ); ?>
      </a>
	</div>
	  
  
	</div>
<?php 
	}
}

/*-----------------------------------------------------------------------------------*/
/* CoLabs - Footer Credit */
/*-----------------------------------------------------------------------------------*/
if(!function_exists('colabs_credit')){
function colabs_credit(){
global $themename, $colabs_options;
if( $colabs_options['colabs_footer_credit'] != 'true' ){ ?>
            Copyright &copy; 2011 <a href="http://colorlabsproject.com/themes/<?php echo get_option('colabs_themename'); ?>/" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">Adam & Eve</a> by <a href="http://colorlabsproject.com/" title="Colorlabs">ColorLabs</a>. All rights reserved.
<?php }else{ echo stripslashes( $colabs_options['colabs_footer_credit_txt'] ); } 
}}

/*-----------------------------------------------------------------------------------*/
/* CoLabs - List Comment */
/*-----------------------------------------------------------------------------------*/
if(!function_exists('list_comments')){
function list_comments($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;
?>

	<li <?php comment_class(); ?>>
		<div id="comment-<?php comment_ID(); ?>">
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyeleven' ); ?></em>
				<br />
			<?php endif; ?>

			<?php comment_text() ?>

			<div class="comment-author">
				<?php echo get_comment_author_link(); ?>
				<small>on</small>
				<span class="meta"><?php printf( __( '%1$s', 'modernizm' ), get_comment_date() ) ?>				
				<?php comment_reply_link( array_merge( $args, array(
					'reply_text' => __( 'Reply', 'modernizm' ),
					'depth' => $depth,
					'max_depth' => $args['max_depth']
				) ) ); ?>
			</div>
		</div>
  
<?php }}
/*-----------------------------------------------------------------------------------*/
/* responsive image caption */
/*-----------------------------------------------------------------------------------*/
add_filter('img_caption_shortcode', 'colabs_caption',10,3);
function colabs_caption($val, $attr, $content = null)
{
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> '',
		'width'	=> '',
		'caption' => ''
	), $attr));
		return '<div class="wp-caption ' . esc_attr($align) . '">' . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}
/*-----------------------------------------------------------------------------------*/
/*  is_mobile - Check Mobile Version */
/*-----------------------------------------------------------------------------------*/
if(!function_exists('is_mobile')){
function is_mobile(){
	$regex_match="/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";
	$regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";
	$regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";	
	$regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";
	$regex_match.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";
	$regex_match.=")/i";		
	return isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']) or preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']));
}}

/*-----------------------------------------------------------------------------------*/
/* Custom Dropdown Menu */
/*-----------------------------------------------------------------------------------*/
class dropdown_walker extends Walker {
	var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
	var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "&nbsp;&nbsp;", $depth ) : '';
		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
		$value = ' value="'. esc_attr( $item->url        ).'" ';
		$output .= '<option' . $id . $value . $class_names .'>' . $indent;
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	function end_el(&$output, $item, $depth) {
		$output .= "</option>\n";
	}
}
if(!function_exists('colabs_dropdown_menu')){
function colabs_dropdown_menu( $args = array() ) {
	static $menu_id_slugs = array();
	$defaults = array( 'menu' => '', 'container' => '', 'container_class' => '', 'container_id' => '', 'menu_class' => 'menu', 'menu_id' => '',
	'echo' => true, 'fallback_cb' => 'wp_page_menu', 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '', 'items_wrap' => '<select id="%1$s" class="%2$s select">%3$s</select>','depth' => 0, 'walker' => '', 'theme_location' => '', 'show_option_none' => '' );
	$args = wp_parse_args( $args, $defaults );
	$args = apply_filters( 'wp_nav_menu_args', $args );
	$args = (object) $args;
	// Get the nav menu based on the requested menu
	$menu = wp_get_nav_menu_object( $args->menu );
	// Get the nav menu based on the theme_location
	if ( ! $menu && $args->theme_location && ( $locations = get_nav_menu_locations() ) && isset( $locations[ $args->theme_location ] ) )
		$menu = wp_get_nav_menu_object( $locations[ $args->theme_location ] );
	// get the first menu that has items if we still can't find a menu
	if ( ! $menu && !$args->theme_location ) {
		$menus = wp_get_nav_menus();
		foreach ( $menus as $menu_maybe ) {
			if ( $menu_items = wp_get_nav_menu_items($menu_maybe->term_id) ) {
				$menu = $menu_maybe;
				break;
			}
		}
	}
	// If the menu exists, get its items.
	if ( $menu && ! is_wp_error($menu) && !isset($menu_items) )
		$menu_items = wp_get_nav_menu_items( $menu->term_id );
	// If no menu was found or if the menu has no items and no location was requested, call the fallback_cb if it exists
	if ( ( !$menu || is_wp_error($menu) || ( isset($menu_items) && empty($menu_items) && !$args->theme_location ) )
		&& $args->fallback_cb && is_callable( $args->fallback_cb ) )
			return call_user_func( $args->fallback_cb, (array) $args );
	// If no fallback function was specified and the menu doesn't exists, bail.
	if ( !$menu || is_wp_error($menu) )
		return false;
	$nav_menu = $items = '';
	$show_container = false;
	if ( $args->container ) {
		$allowed_tags = apply_filters( 'wp_nav_menu_container_allowedtags', array( 'div', 'nav' ) );
		if ( in_array( $args->container, $allowed_tags ) ) {
			$show_container = true;
			$class = $args->container_class ? ' class="' . esc_attr( $args->container_class ) . '"' : ' class="menu-'. $menu->slug .'-container"';
			$id = $args->container_id ? ' id="' . esc_attr( $args->container_id ) . '"' : '';
			$nav_menu .= '<'. $args->container . $id . $class . '>';
		}
	}
	// Set up the $menu_item variables
	_wp_menu_item_classes_by_context( $menu_items );
	$sorted_menu_items = array();
	foreach ( (array) $menu_items as $key => $menu_item )
		$sorted_menu_items[$menu_item->menu_order] = $menu_item;
	unset($menu_items);
	$sorted_menu_items = apply_filters( 'wp_nav_menu_objects', $sorted_menu_items, $args );
	if ( $args->show_option_none )
			$items .= "\t<option value=\"-1\">".$args->show_option_none."</option>\n";
	$items .= walk_nav_menu_tree2( $sorted_menu_items, $args->depth, $args );
	unset($sorted_menu_items);
	// Attributes
	if ( ! empty( $args->menu_id ) ) {
		$wrap_id = $args->menu_id;
	} else {
		$wrap_id = 'menu-' . $menu->slug;
		while ( in_array( $wrap_id, $menu_id_slugs ) ) {
			if ( preg_match( '#-(\d+)$#', $wrap_id, $matches ) )
				$wrap_id = preg_replace('#-(\d+)$#', '-' . ++$matches[1], $wrap_id );
			else
				$wrap_id = $wrap_id . '-1';
		}
	}
	$menu_id_slugs[] = $wrap_id;
	$wrap_class = $args->menu_class ? $args->menu_class : '';
	// Allow plugins to hook into the menu to add their own <li>'s
	$items = apply_filters( 'wp_nav_menu_items', $items, $args );
	$items = apply_filters( "wp_nav_menu_{$menu->slug}_items", $items, $args );
	$nav_menu .= sprintf( $args->items_wrap, esc_attr( $wrap_id ), esc_attr( $wrap_class ), $items );
	unset( $items );
	if ( $show_container )
		$nav_menu .= '</' . $args->container . '>';
	$nav_menu = apply_filters( 'wp_nav_menu', $nav_menu, $args );
	if ( $args->echo )
		echo $nav_menu;
	else
		return $nav_menu;
}}
function walk_nav_menu_tree2( $items, $depth, $r ) {
	$walker = ( empty($r->walker) ) ? new dropdown_walker : $r->walker;
	$args = array( $items, $depth, $r );
	return call_user_func_array( array(&$walker, 'walk'), $args );
}
function colabs_dropdown_pages($args = '') {
	$defaults = array(
		'depth' => 0, 'child_of' => 0,
		'selected' => 0, 'echo' => 1,
		'name' => 'page_id', 'id' => '',
		'show_option_none' => '', 'show_option_no_change' => '',
		'option_none_value' => '',
		'class' => 'page-dropdown-menu'
	);
	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );
	$pages = get_pages($r);
	$output = '';
	$name = esc_attr($name);
	$class = esc_attr($class);
	// Back-compat with old system where both id and name were based on $name argument
	if ( empty($id) )
		$id = $name;
	if ( ! empty($pages) ) {
		$output = "<select name=\"$name\" id=\"$id\" class=\"$class\">\n";
		if ( $show_option_no_change )
			$output .= "\t<option value=\"-1\">$show_option_no_change</option>";
		if ( $show_option_none )
			$output .= "\t<option value=\"-1\">$show_option_none</option>\n";
		$output .= walk_page_dropdown_tree($pages, $depth, $r);
		$output .= "</select>\n";
	}
	$output = apply_filters('colabs_dropdown_pages', $output);
	if ( $echo )
		echo $output;
	return $output;
}
?>