<?php
/**
 * The template for displaying right content in the home.php page template
 *
 * @package WordPress
 * @subpackage AdamEve
 * @since AdamEve 1.0
 */
?>
                <?php $exclude = ''; if (get_option('colabs_slider_exclude2') == "true") $exclude = get_option('colabs_exclude2'); ?>
                <?php 
                $eve=get_option('colabs_author_right');
				if($eve=='')$eve=1;
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array( 	
                    'author' => $eve,
                    'post__not_in' => $exclude,
					'paged' => $paged
                    );
				query_posts($args);
                ?>
		<?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div id="post-<?php the_ID(); ?>" <?php post_class('post-eve');?>> 
                            <ul class="post-cat"><li><?php the_category('</li><li>'); ?></li></ul>
                            <div class="clear"></div>
                            <div class="comment1"><?php comments_popup_link('0 ', '1 ','% ', '', 'off'); ?></div>
                            <h2><a href="<?php the_permalink() ?>" ><?php the_title(); ?></a></h2>
                            <p class="post-by">Posted by : <?php the_author_posts_link(); ?> | <?php the_time('F j, Y'); ?></p>
							<?php colabs_image('width=327&height=150&class=post-image&play=true');?>
                            <?php colabs_custom_excerpt(); ?>
                            <?php edit_post_link('Edit', '', '  '); ?>
							<a class="button" href="<?php the_permalink();?>"><span><?php _e('Continue Reading');?></span></a>
                        </div>
                <?php endwhile; ?>
                    
                <?php else : ?>
                    <p>No Data</p>
                <?php endif; ?>
                