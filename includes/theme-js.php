<?php
if (!is_admin()) add_action( 'wp_print_scripts', 'colabsthemes_add_javascript' );

if (!function_exists('colabsthemes_add_javascript')) {

	function colabsthemes_add_javascript () {
		
        wp_enqueue_script('jquery');	
		
		wp_enqueue_script( 'jqadameve', trailingslashit( get_template_directory_uri() ) . 'includes/js/jquery.js', array('jquery') );
		wp_enqueue_script( 'sooperfish', trailingslashit( get_template_directory_uri() ) . 'includes/js/jquery.sooperfish.js', array('jquery') );
		wp_enqueue_script( 'easyslider', trailingslashit( get_template_directory_uri() ) . 'includes/js/easySlider1.7.js', array('jquery') );
		wp_enqueue_script( 'adameve', trailingslashit( get_template_directory_uri() ) . 'includes/js/adam-eve.js', array('jquery') );

		/* We add some JavaScript to pages with the comment form to support sites with threaded comments (when in use). */        
        	if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
        
	} /* // End colabsthemes_add_javascript() */
	
} /* // End IF Statement */
?>