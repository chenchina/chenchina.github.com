<?php get_header(); global $colabs_options; ?>
    <div class="container_16">
        <?php include(TEMPLATEPATH . '/includes/ribbon.php'); ?>
        
		<?php if ($colabs_options['colabs_slider'] == "true" AND ( is_home() OR is_front_page() ) ) { ?>
				<!-- SLIDER POSTS -->
                <div class="grid_16">
				<?php include(TEMPLATEPATH . '/includes/slider.php'); ?>
                </div>
		<?php } ?>
        
        <div class="clear"></div>
        <div class="box-post">
            <div class="grid_6">
                <?php get_template_part('loop','home-left'); ?>
            </div>
            
            <?php get_sidebar(); wp_reset_query();?>
            
            <div class="grid_6 omega">
                <?php get_template_part('loop','home-right'); ?>
            </div>
            
            <div class="clear"></div>
        </div>
    </div><!-- end container -->
    
    
    <?php get_footer(); ?>