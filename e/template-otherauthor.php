<?php
/*
Template Name: Other Author Post List
*/
?>
<?php get_header(); ?>
    <div class="container_16">
		<?php 
		$adam=get_option('colabs_author_left');
		$eve=get_option('colabs_author_right');
		$sidebarcat=get_option('colabs_sidebar_category');
		if ($sidebarcat=='')$sidebarcat='left';
		?>
        <div class="ribbon">
            <div class="icon-ribbon"><img src="<?php bloginfo( 'template_directory' ); ?>/images/love.png" alt="icon love" /></div>
        </div>
        
        
        
        <div class="clear"></div>
        <div class="<?php if ($sidebarcat=='right'){echo 'box-post-left';}else{echo 'box-post-right';}?> box-post-default">
	    <?php if ($sidebarcat=='left'){get_sidebar();} ?>
            <div class="grid_12">
                    
                <?php 
				wp_reset_query();
				global $wpdb;
				$query = new WP_Query( 'author=-10' );
				$excludeauthor = "SELECT $wpdb->posts.* FROM $wpdb->posts WHERE post_author<>12 AND post_author<>10 AND post_type='post' AND post_status='publish'";
				$posts = $wpdb->get_results($excludeauthor)
				//query_posts('author=-12&author=-10&showposts=20'); ?>
		<?php if($posts){ ?>
                    <?php foreach($posts as $post){
					setup_postdata($post);	
					?>
					<?php $post_author_id= $post->post_author;?>
                        <div id="post-<?php the_ID(); ?>" class="post <?php if($post_author_id==$adam){echo 'post-adam';}elseif ($post_author_id==$eve){echo 'post-eve';}else{echo 'post-default';}?>"> 
                            <ul class="post-cat"><li><?php the_category('</li><li>'); ?></li></ul>
                            <div class="clear"></div>						
                            <div class="comment1"><?php comments_popup_link('0 ', '1 ','% ', '', 'off'); ?></div>
                            <h2><a href="<?php the_permalink() ?>" ><?php the_title(); ?></a></h2>
                            <p class="post-by">Posted by : <?php the_author(); ?> | <?php the_time('F j, Y'); ?></p>
                            <?php colabs_custom_excerpt(); ?>
                            <div class="clear"></div>
                            <div class="multipage"><?php wp_link_pages(); ?></div>
                            <?php the_tags(); ?>
                            <?php edit_post_link('Edit', '', '  '); ?>
                        </div>
                <?php } ?>
                    
                    
                <?php }else { ?>
                    <p>No Data</p>
                <?php } ?>
                
                
            </div>
            
            <?php if ($sidebarcat=='right'){get_sidebar();} ?>
            
            
            
            <div class="clear"></div>
            <div class="<?php if ($sidebarcat=='right'){echo 'line';}else{echo 'line-left';}?>"></div>
        </div>
    </div><!-- end container -->
    
    
    <?php get_footer(); ?>