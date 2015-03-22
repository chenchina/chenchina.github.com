<?php
/**
 * The template for displaying slider content in the slider.php template
 *
 * @package WordPress
 * @subpackage AdamEve
 * @since AdamEve 1.0
 */
?>
<?php
    foreach ( $slides as $post ) {
	
    setup_postdata( $post );
			
	if ( !colabs_image( 'return=true' ) ) continue; // Skip post if it doesn't have an image
			
	// Mark this post as having been shown.
	$shownposts[$count] = $post->ID;
    ?>
        <li id="slide-<?php the_ID(); ?>" class="slide-count-<?php echo $count+1; ?>">
            <?php colabs_image('key=image&width=452&height=202&class=slide-image'); ?>
            <div class="title">
            <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
            <span class="post-date"><?php the_date( get_option( 'date_format' ) ); ?></span><!--/.post-date-->
            </div>                    
        </li>
    <?php
        $count++;
    } // End FOREACH Loop
?>