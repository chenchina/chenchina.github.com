<?php get_header(); ?>
    <div class="container_16">
		<?php 
		$adam=get_option('colabs_author_left');
		$eve=get_option('colabs_author_right');
		$sidebarcat=get_option('colabs_sidebar_category');
		if ($sidebarcat=='')$sidebarcat='left';
		?>
        <?php include(TEMPLATEPATH . '/includes/ribbon.php'); ?>
        
        <div class="clear"></div>
        <div class="<?php if ($sidebarcat=='right'){echo 'box-post-left';}else{echo 'box-post-right';}?> box-post-default">
	    <?php if ($sidebarcat=='left'){get_sidebar();} ?>
            <div <?php post_class( 'grid_12' ); ?>>
                    
		<?php if (have_posts()) : ?>
        
        <h2><?php _e( 'Search Result','colabsthemes'); ?> <?php _e( 'for','colabsthemes'); ?> "<?php the_search_query() ?>"</h2>
        
                    <?php while (have_posts()) : the_post(); ?>
					<?php $post_author_id= $post->post_author;?>
                        <div id="post-<?php the_ID(); ?>" class="post <?php if($post_author_id==$adam){echo 'post-adam';}elseif($post_author_id==$eve){echo 'post-eve';}else{echo 'post-default';}?>"> 
                            <ul class="post-cat"><li><?php the_category('</li><li>'); ?></li></ul>
                            <div class="clear"></div>						
                            <div class="comment1"><?php comments_popup_link('0 ', '1 ','% ', '', 'off'); ?></div>
                            <h2><a href="<?php the_permalink() ?>" ><?php the_title(); ?></a></h2>
                            <p class="post-by">Posted by : <?php the_author_posts_link(); ?> | <?php the_time('F j, Y'); ?></p>
                            <?php colabs_custom_excerpt(); ?>
                            <div class="clear"></div>
                            <div class="multipage"><?php wp_link_pages(); ?></div>
                            <?php the_tags(); ?>
                            <?php edit_post_link('Edit', '', '  '); ?>
							<a class="button" href="<?php the_permalink();?>"><span><?php _e('Continue Reading');?></span></a>
                        </div>
                <?php endwhile; ?>
                    
                    <?php comments_template( '', true ); ?>
                <?php else : ?>
                    <p>No search result found for your criteria.</p>
                <?php endif; ?>
                
                
            </div>
            
            <?php if ($sidebarcat=='right'){get_sidebar();} ?>
            
            
            
            <div class="clear"></div>
            <div class="<?php if ($sidebarcat=='right'){echo 'line';}else{echo 'line-left';}?>"></div>
        </div>
    </div><!-- end container -->
    
    
    <?php get_footer(); ?>