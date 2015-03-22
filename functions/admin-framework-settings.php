<?php
/*-----------------------------------------------------------------------------------*/
/* Framework Settings page - colabsthemes_framework_settings_page */
/*-----------------------------------------------------------------------------------*/

function colabsthemes_framework_settings_page(){

    $themename =  get_option( 'colabs_themename' );
    $manualurl =  get_option( 'colabs_manual' );
	$shortname =  'framework_colabs';

    //Framework Version in Backend Head
    $colabs_framework_version = get_option( 'colabs_framework_version' );

    //Version in Backend Head
    $theme_data = get_theme_data( get_template_directory() . '/style.css' );
    $local_version = $theme_data['Version'];

    //GET themes update RSS feed and do magic
	include_once(ABSPATH . WPINC . '/feed.php' );

	$pos = strpos($manualurl, 'documentation' );
	$theme_slug = str_replace( "/", "", substr($manualurl, ($pos + 13))); //13 for the word documentation

    //add filter to make the rss read cache clear every 4 hours
    add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 14400;' ) );

	$framework_options = array();

	$framework_options[] = array( 	"name" => "Admin Settings",
									"icon" => "general",
									"type" => "heading" );

	$framework_options[] = array( 	"name" => "Super User (username)",
									"desc" => "Enter your <strong>username</strong> to hide the Framework Settings and Update Framework from other users. Can be reset from the <a href='".home_url()."/wp-admin/options.php'>WP options page</a> under <em>framework_colabs_super_user</em>.",
									"id" => $shortname."_super_user",
									"std" => "",
									"class" => "text",
									"type" => "text" );

	$framework_options[] = array( 	"name" => "Disable SEO Menu Item",
									"desc" => "Disable the <strong>SEO</strong> menu item in the theme menu.",
									"id" => $shortname."_seo_disable",
									"std" => "false",
									"type" => "checkbox" );

	$framework_options[] = array( 	"name" => "Disable Layout Menu Item",
									"desc" => "Disable the <strong>Layout</strong> menu item in the theme menu.",
									"id" => $shortname."_layout_disable",
									"std" => "false",
									"type" => "checkbox" );
                                    
	$framework_options[] = array( 	"name" => "Disable Custom File Editor Menu Item",
									"desc" => "Disable the <strong>Custom File Editor</strong> menu item in the theme menu.",
									"id" => $shortname."_editor_disable",
									"std" => "false",
									"type" => "checkbox" );
                                    
	$framework_options[] = array( 	"name" => "Disable Sidebar Manager Menu Item",
									"desc" => "Disable the <strong>Sidebar Manager</strong> menu item in the theme menu.",
									"id" => $shortname."_sbm_disable",
									"std" => "",
									"type" => "checkbox" );

	$framework_options[] = array( 	"name" => "Disable Import/Export Menu Item",
									"desc" => "Disable the <strong>Import/Export</strong> menu item in the theme menu.",
									"id" => $shortname."_backupmenu_disable",
									"std" => "false",
									"type" => "checkbox" );
/*
	$framework_options[] = array( 	"name" => "Disable Buy Themes Menu Item",
									"desc" => "Disable the <strong>Buy Themes</strong> menu item in the theme menu.",
									"id" => $shortname."_buy_themes_disable",
									"std" => "",
									"type" => "checkbox" );

	$framework_options[] = array( 	"name" => "Enable Custom Navigation",
									"desc" => "Enable the old <strong>Custom Navigation</strong> menu item. Try to use <a href='".home_url()."/wp-admin/nav-menus.php'>WP Menus</a> instead, as this function is outdated.",
									"id" => $shortname."_colabsnav",
									"std" => "",
									"type" => "checkbox" );
*/
	$framework_options[] = array( 	"name" => "Theme Update Notification",
									"desc" => "This will enable notices on your theme options page that there is an update available for your theme.",
									"id" => $shortname."_theme_version_checker",
									"std" => "false",
									"type" => "checkbox" );

	$framework_options[] = array( 	"name" => "Theme Settings",
									"icon" => "general",
									"type" => "heading" );

	$framework_options[] = array( 	"name" => "Remove Generator Meta Tags",
									"desc" => "This disables the output of generator meta tags in the HEAD section of your site.",
									"id" => $shortname."_disable_generator",
									"std" => "false",
									"type" => "checkbox" );

	$framework_options[] = array( 	"name" => "Image Placeholder",
									"desc" => "Set a default image placeholder for your thumbnails. Use this if you want a default image to be shown if you haven't added a custom image to your post.",
									"id" => $shortname."_default_image",
									"std" => "",
									"type" => "upload" );

	$framework_options[] = array( 	"name" => "Disable Shortcodes Stylesheet",
									"desc" => "This disables the output of shortcodes.css in the HEAD section of your site.",
									"id" => $shortname."_disable_shortcodes",
									"std" => "false",
									"type" => "checkbox" );

	$framework_options[] = array( 	"name" => "Output \"Tracking Code\" Option in Header",
									"desc" => "This will output the <strong>Tracking Code</strong> option in your header instead of the footer of your website.",
									"id" => $shortname."_move_tracking_code",
									"std" => "false",
									"type" => "checkbox" );

	$framework_options[] = array( 	"name" => "Branding",
									"icon" => "misc",
									"type" => "heading" );

	$framework_options[] = array( 	"name" => "Options panel header",
									"desc" => "Change the header image for the ColorLabs Backend.",
									"id" => $shortname."_backend_header_image",
									"std" => "",
									"type" => "upload" );

	$framework_options[] = array( 	"name" => "Options panel icon",
									"desc" => "Change the icon image for the WordPress backend sidebar.",
									"id" => $shortname."_backend_icon",
									"std" => "",
									"type" => "upload" );

	$framework_options[] = array( 	"name" => "WordPress login logo",
									"desc" => "Change the logo image for the WordPress login page.",
									"id" => $shortname."_custom_login_logo",
									"std" => "",
									"type" => "upload" );
/*
	$framework_options[] = array( 	"name" => "Font Stacks (Beta)",
									"icon" => "typography",
									"type" => "heading" );

	$framework_options[] = array( 	"name" => "Font Stack Builder",
									"desc" => "Use the font stack builder to add your own custom font stacks to your theme.
									To create a new stack, fill in the name and a CSS ready font stack.
									Once you have added a stack you can select it from the font menu on any of the
									Typography settings in your theme options.",
									"id" => $shortname."_font_stack",
									"std" => "Added Font Stacks",
									"type" => "string_builder" );
*/

	global $wp_version;

	if ( $wp_version >= '3.1' ) {

	$framework_options[] = array( 	"name" => "Admin Bar",
									"icon" => "header",
									"type" => "heading" );

	$framework_options[] = array( 	"name" => "Disable WordPress Admin Bar",
									"desc" => "Disable the WordPress Admin Bar.",
									"id" => $shortname."_admin_bar_disable",
									"std" => "false",
									"type" => "checkbox" );

	$framework_options[] = array( 	"name" => "Enable the ColorLabs Framework Admin Bar enhancements",
									"desc" => "Enable several ColorLabs Framework-specific enhancements to the WordPress Admin Bar, such as custom navigation items for 'Theme Options'.",
									"id" => $shortname."_admin_bar_enhancements",
									"std" => "true",
									"type" => "checkbox" );

	}

    update_option( 'colabs_framework_template', $framework_options );

	?>

    <div class="wrap colabs_container">
        <form action="" enctype="multipart/form-data" id="colabsform" method="post">
        <?php
	    	// Add nonce for added security.
	    	if ( function_exists( 'wp_nonce_field' ) ) { wp_nonce_field( 'colabsframework-framework-options-update' ); } // End IF Statement

	    	$colabs_nonce = '';

	    	if ( function_exists( 'wp_create_nonce' ) ) { $colabs_nonce = wp_create_nonce( 'colabsframework-framework-options-update' ); } // End IF Statement

	    	if ( $colabs_nonce == '' ) {} else {

	    ?>
	    	<input type="hidden" name="_ajax_nonce" value="<?php echo $colabs_nonce; ?>" />
	    <?php

	    	} // End IF Statement
	    ?>
            <div class="themever left">
                <div id="icon-colabs" class="icon32"><br /></div>
                <h2><?php echo $themename; ?> <?php echo $local_version; ?>&nbsp;<?php _e( 'Framework Settings' ) //your admin panel title ?></h2>
            </div>
            <div class="logocolabs right">
                <a href="http://colorlabsproject.com" title="Visit Our Website"><img src="<?php echo get_template_directory_uri(); ?>/functions/images/colorlabs.png" /></a>
            </div>
            <div class="clear"></div>
            <div id="colabs-popup-save" class="colabs-save-popup"><div class="colabs-save-save">Options Updated</div></div>
            <div id="colabs-popup-reset" class="colabs-save-popup"><div class="colabs-save-reset">Options Reset</div></div>
            <div style="width:100%;padding-top:15px;">
            <div id="support-links" class="left">
                <ul>
				    <li class="docs"><a title="Theme Documentation" href="<?php echo $manualurl; ?>/documentation/<?php echo strtolower( str_replace( " ","",$themename ) ); ?>" target="_blank" >View Documentation</a></li>
                    <span>&#124;</span>
				    <li class="forum"><a href="http://colorlabsproject.com/resolve/" target="_blank">Submit a Support Ticket</a></li>
				    <span>&#124;</span>
                    <li class="idea"><a href="http://ideas.colorlabsproject.com/" target="_blank">Suggest a Feature</a></li>
                </ul>
            </div>
            <div class="save_bar_top right">
                <img style="display:none" src="<?php echo get_template_directory_uri(); ?>/functions/images/ajax-loading.gif" class="ajax-loading-img ajax-loading-img-top left" alt="Working..." />        
                <input type="submit" value="Save All Changes" class="button submit-button button-primary" />
            </div>
            </div>
            <div class="clear"></div>            
            <?php $return = colabsthemes_machine($framework_options); ?>
            <div id="main">
                <div id="colabs-nav">
                    <ul>
                        <?php echo $return[1]; ?>
                    </ul>
                </div>
                <div id="content">
   				<?php echo $return[0]; ?>
                </div>
                <div class="clear"></div>

            </div>
            <div class="save_bar_down right">
            <img style="display:none" src="<?php echo get_template_directory_uri(); ?>/functions/images/ajax-loading.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
            <input type="submit" value="Save All Changes" class="button submit-button button-primary" />            
            </form>

            <form action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" method="post" style="display:inline" id="colabsform-reset">
            <?php
		    	// Add nonce for added security.
		    	if ( function_exists( 'wp_nonce_field' ) ) { wp_nonce_field( 'colabsframework-framework-options-reset' ); } // End IF Statement

		    	$colabs_nonce = '';

		    	if ( function_exists( 'wp_create_nonce' ) ) { $colabs_nonce = wp_create_nonce( 'colabsframework-framework-options-reset' ); } // End IF Statement

		    	if ( $colabs_nonce == '' ) {} else {

		    ?>
		    	<input type="hidden" name="_ajax_nonce" value="<?php echo $colabs_nonce; ?>" />
		    <?php

		    	} // End IF Statement
		    ?>
            <span class="submit-footer-reset">
<!--             <input name="reset" type="submit" value="Reset Options" class="button submit-button reset-button" onclick="return confirm( 'Click OK to reset. Any settings will be lost!' );" /> -->
            <input type="hidden" name="colabs_save" value="reset" />
            </span>
        	</form>


            </div>

    <div style="clear:both;"></div>
    </div><!--wrap-->

<?php } ?>