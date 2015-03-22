<?php get_header(); ?>
    <div class="container_16">
        <?php include(TEMPLATEPATH . '/includes/ribbon.php'); ?>
        
        <div class="clear"></div>
        <div class="<?php if ($author==$adam){echo 'box-post-left';}else{echo 'box-post-right';}?>">
	     <?php if (($author!=$adam)&& (!is_mobile())){get_sidebar();} ?>
            <div class="grid_12">
                    
		<?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php $post_author_id= $post->post_author;?>
                        <div id="post-<?php the_ID(); ?>" class="post <?php if($post_author_id==$adam){echo 'post-adam';}else{echo 'post-eve';}?>"> 
                            
                            <h2><a href="<?php the_permalink() ?>" ><?php the_title(); ?></a></h2>
                            <p class="post-by">Posted by : <?php the_author(); ?> | <?php the_time('F j, Y'); ?></p>
                            <?php the_content('<p class="read-more">Continue Reading..</p>'); ?>
                            <div class="clear"></div>
                            <div class="multipage"><?php wp_link_pages(); ?></div>
                            <?php the_tags(); ?>
                            <?php edit_post_link('Edit', '', '  '); ?>
                        </div>
                <?php endwhile; ?>
                    
                    <?php comments_template( '', true ); ?>
                <?php else : ?>
                    <p>No Data</p>
                <?php endif; ?>
                
                
            </div>
            
           <?php if (($author==$adam)||(is_mobile())){get_sidebar();} ?>
            
            
            
            <div class="clear"></div>
            <div class="<?php if ($author==$adam){echo 'line';}else{echo 'line-left';}?>"></div>
        </div>
    </div><!-- end container -->
    
    
    <?php get_footer(); ?>