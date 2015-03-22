<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php if ( function_exists( 'colabs_title') ){ colabs_title(); }else{ echo get_bloginfo('name'); ?>&nbsp;<?php wp_title(); } ?></title>
<?php
	if ( function_exists( 'colabs_meta') ) colabs_meta();
	if ( function_exists( 'colabs_meta_head') )colabs_meta_head(); 
    global $colabs_options;    
?>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo get_template_directory_uri(); ?>/style-wp.css" rel="stylesheet" type="text/css" />
    
<?php 
    if ( function_exists( 'colabs_head') ) colabs_head();
    wp_head(); 
?>
</head>
<body>
    <div class="bg-container">
        &nbsp;
            <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'container_class' => 'top-menu', 'fallback_cb'=>'topmenu') );?>
			<?php colabs_dropdown_menu('container_class=top-menu&show_option_none=Navigate to&theme_location=main-menu&fallback_cb=colabs_dropdown_pages');?>
        <div class="container_16">
            <div class="grid_16">
                <div class="header">
                    <h2>
					<?php if ( $colabs_options['colabs_logo'] != '' ){ ?>
						<a href="<?php bloginfo('url'); ?>"><img src="<?php echo $colabs_options['colabs_logo']; ?>" alt="<?php bloginfo('name'); ?>" /></a>
					<?php } ?>
					</h2>
                    <p><?php bloginfo( 'description' ); ?></p>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div><!-- end bg-container -->
    