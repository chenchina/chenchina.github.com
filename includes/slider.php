<?php
/*-----------------------------------------------------------------------------------

FILE INFORMATION

Description: CoLabsThemes slider component.

TABLE OF CONTENTS

- Slider Query
- 1st Slider XHTML.
- 1st Reset Global Variables.
- 2nd Slider XHTML.
- 2nd Reset Global Variables.

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------
  Slider Query.
-----------------------------------------------------------------------------------*/

if (!function_exists('slider_query')){
function slider_query($num){
    
	global $colabs_options, $wp_query, $post;
	
	$count = 0;
	$colabs_slider_tags = '';
	$number_to_show = 4;
	$slides = array();
	$shownposts = array();
	
	// Set the number of slides to show.
	if ( array_key_exists( 'colabs_slider_entries'.$num, $colabs_options ) && is_numeric( $colabs_options['colabs_slider_entries'.$num] ) ) {
	
		$number_to_show = $colabs_options['colabs_slider_entries'.$num];
	
	} // End IF Statement
	
	if ( array_key_exists( 'colabs_slider_tags'.$num, $colabs_options ) ) {
	
		$colabs_slider_tags = $colabs_options['colabs_slider_tags'.$num];
		
		if ( $colabs_slider_tags == '' ) {} else {
		
			$tag_array = array(); // The array to hold the IDs of the tags we want to check in.
	    	
			$slide_tags_array = explode( ',', $colabs_slider_tags ); // Tags to be shown
			
			foreach ( $slide_tags_array as $s ) {
			
				// Check that the tag exists.
				$tag = get_term_by( 'name', trim($s), 'post_tag', ARRAY_A );
				
				if ( array_key_exists( 'term_id', $tag ) && $tag['term_id'] > 0 ) {
				
					$tag_array[] = $tag['term_id'];
				
				} // End IF Statement
			
			} // End FOREACH Loop
		
			// If we have tag IDs, run the code.
			if ( count( $tag_array ) ) {
			
				// Preserve the original query for the page being loaded.
				$original_query = $wp_query;
				$original_post = $post;
				
				// Run the query to get the slides.
				$slides = query_posts(array('tag__in' => $tag_array, 'showposts' => $number_to_show ) );
			
			} // End IF Statement
		
		} // End IF Statement
	
	} // End IF Statement
	
    return $slides;
    
}}

   
/*-----------------------------------------------------------------------------------
  1st Slider XHTML.
-----------------------------------------------------------------------------------*/
    
    //init query
    $slides = slider_query('1');

	if ( count( $slides ) ) {
?>
<div class="grid_8 alpha re">
	<div id="slider" class="slide1">
		<ul>
		<?php
            include(TEMPLATEPATH . '/includes/loop-slider.php');
		?>
		</ul>
		<div class="clear"></div><!--/.clear-->
	</div><!--/.slide-->

</div><!--/.grid_8 alpha re-->
<?php
	} else {
	
		if ( $colabs_slider_tags == '' ) {
		
			echo do_shortcode('[box type="info"]Please setup tag(s) in your options panel that are used in posts.[/box]');
			
		} else {

			echo do_shortcode('[box type="info"]No posts with your specified tag(s) were found[/box]');
			
		} // End IF Statement   

	} // End IF Statement

/*-----------------------------------------------------------------------------------
  1st Reset Global Variables.
-----------------------------------------------------------------------------------*/	
	
	$post = $original_post;
	
	if ( get_option('colabs_exclude1') <> $shownposts ) { update_option("colabs_exclude1", $shownposts); } // End IF Statement
?>

<?php wp_reset_query(); ?>

<?php

/*-----------------------------------------------------------------------------------
  2nd Slider XHTML.
-----------------------------------------------------------------------------------*/

    //init query
    $slides = slider_query('2');

	if ( count( $slides ) ) {
?>
<div class="grid_8 omega re">
	<div id="slider2" class="slide2">
		<ul>
		<?php
            include(TEMPLATEPATH . '/includes/loop-slider.php');
		?>
		</ul>
		<div class="clear"></div><!--/.clear-->
	</div><!--/.slide-->

</div><!--/.grid_8 alpha re-->
<?php
	} else {
	
		if ( $colabs_slider_tags == '' ) {
		
			echo do_shortcode('[box type="info"]Please setup tag(s) in your options panel that are used in posts.[/box]');
			
		} else {

			echo do_shortcode('[box type="info"]No posts with your specified tag(s) were found[/box]');
			
		} // End IF Statement   

	} // End IF Statement

/*-----------------------------------------------------------------------------------
  2nd Reset Global Variables.
-----------------------------------------------------------------------------------*/	
	
	$post = $original_post;
	
	if ( get_option('colabs_exclude2') <> $shownposts ) { update_option("colabs_exclude2", $shownposts); } // End IF Statement
?>

<?php wp_reset_query(); ?>