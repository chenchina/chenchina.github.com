<?php

// Register widgetized areas

if (!function_exists('the_widgets_init')) {
	function the_widgets_init() {
	    if ( !function_exists('register_sidebars') )
	        return;
    //Sidebar
  register_sidebar(array(
    'name' => 'Sidebar Home',
    'id' => 'home',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3> ',
  ));
  register_sidebar(array(
    'name' => 'Sidebar Adam',
    'id' => 'adam',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3> ',
  ));
  register_sidebar(array(
    'name' => 'Sidebar Eve',
    'id' => 'eve',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3> ',
  ));
  register_sidebar(array(
    'name' => 'Widget Footer 1',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3> ',
  ));
  register_sidebar(array(
    'name' => 'Widget Footer 2',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3> ',
  ));
  register_sidebar(array(
    'name' => 'Widget Footer 3',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3> ',
  ));


    }
}

add_action( 'init', 'the_widgets_init' );


    
?>