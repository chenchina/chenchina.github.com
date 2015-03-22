<div class="bg-container shadow">
        <div class="container_16 footer">
            <?php //colabs_custom_pagination(); ?>
            <div class="grid_4 prefix_6 suffix_6">
                <?php if (is_page()) { ?>
                    <div class="page-nav-null"></div>
                <?php } elseif (!is_single()) { ?>
                <div class="navigation">
                    <div class="navleft"><?php next_posts_link(' Older') ?></div>
                    <div class="navright"><?php previous_posts_link('Newer ') ?></div>
                    <div class="clear"></div>
                </div>
                <?php } else { ?>
                    <div class="navigation">
                    <div class="navleft"><?php previous_post_link('%link', 'Prev', TRUE); ?></div>
                    <div class="navright"><?php next_post_link('%link','Next', TRUE) ?></div>
                    <div class="clear"></div>
                </div>
                <?php } ?>
            </div><!-- end navigation grid -->
            
            <div class="grid_5 suffix_1 ">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Widget Footer 1') ) : ?>
                <div class="widget">
                    <h3>This is Footer 1 section</h3>
            		<p>You can add this section some widget by <a href="<?php echo admin_url( 'widgets.php' ); ?>">clicking here</a></p>
                </div>
                <?php endif; ?>
            </div>
            <div class="grid_5 suffix_1 alpha">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Widget Footer 2') ) : ?>
                <div class="widget">
                    <h3>This is Footer 2 section</h3>
            		<p>You can add this section some widget by <a href="<?php echo admin_url( 'widgets.php' ); ?>">clicking here</a></p>
                </div>
				
                <?php endif; ?>
            </div>
            <div class="grid_4">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Widget Footer 3') ) : ?>
                <div class="widget">
                    <h3>This is Footer 3 section</h3>
            		<p>You can add this section some widget by <a href="<?php echo admin_url( 'widgets.php' ); ?>">clicking here</a></p>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="clear"></div>
            <hr/>
            <?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container_class' => 'menu', 'fallback_cb'=>'footmenu') );?>
            <p class="copyr"><?php colabs_credit();?></p>
        </div>
    </div>
    <?php wp_footer(); ?>
</body>
</html>