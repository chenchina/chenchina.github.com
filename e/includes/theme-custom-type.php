<?php 
	/* Register Portfolio */
add_action('init', 'portfolio_register');

if(!function_exists('portfolio_register')){
function portfolio_register() {

    $labels = array(
    'name' => _x('Portfolios', 'post type general name'),
    'singular_name' => _x('Portfolio Item', 'post type singular name'),
    'add_new' => _x('Add New', 'Portfolio item'),
    'add_new_item' => __('Add New Portfolio'),
    'edit_item' => __('Edit Portfolio'),
    'new_item' => __('New Portfolio'),
    'view_item' => __('View Portfolio'),
    'search_items' => __('Search Portfolio'),
    'not_found' => __('Nothing found'),
    'not_found_in_trash' => __('Nothing found in Tras'),
    'parent_item_colon' => ''
    );

    $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/images/portfolio_icon.png',
    'rewrite' => false,
    'capability_type' => 'post',
    '_builtin' => false,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author','comments','excerpt','thumbnail')
    );

register_post_type( 'portfolio' , $args );
flush_rewrite_rules();
}
}
	
/* Register Taxonomy */
add_action( 'init', 'colabs_build_taxonomies', 0 );
function colabs_build_taxonomies(){
register_taxonomy("category_portfolio", array("portfolio"), array("hierarchical" => true, "label" => "Portfolio Categories", "singular_label" => "Portfolio Categories", "rewrite" => true));
}

/* Show list Portfolios */
add_action("manage_posts_custom_column",  "portfolio_custom_columns");
add_filter("manage_edit-portfolio_columns", "portfolio_edit_columns");

if(!function_exists('portfolio_edit_columns')){
function portfolio_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Title",
    "description" => "Descriptions",
    "year" => "Years Completed",
    "category_portfolio" => "Portfolio Categories",
  );
 
  return $columns;
}
}

if(!function_exists('portfolio_custom_columns')){
function portfolio_custom_columns($column){
  global $post;
 
  switch ($column) {
    case "description":
      the_excerpt();
      break;
    case "year":
      $custom = get_post_custom();
      echo $custom["year_completed"][0];
      break;
    case "category_portfolio":
      echo get_the_term_list($post->ID, 'category_portfolio', '', ', ','');
      break;
  }
}
}
?>