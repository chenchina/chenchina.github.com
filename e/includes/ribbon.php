<?php 
/**
 * Makes a custom Ribbon image for displaying on index, templates, archive, single, pages
 * 
 * @package WordPress
 * @subpackage AdamEve
 * @since AdamEve 1.0
 */

if(is_singular()){ //single, page, attachment 

    global $colabs_options, $post; 
	$author=$post->post_author;
	$adam=get_option('colabs_author_left');
?>

    <div class="<?php if ($author==$adam){echo 'ribbon-left';}else{echo 'ribbon-right';}?>">
        <div class="<?php if ($author==$adam){echo 'icon-ribbon-left';}else{echo 'icon-ribbon-right';}?>"><img src="<?php echo $colabs_options['colabs_custom_bannericon']; ?>" /></div>
    </div>
    
<?php }else{ ?>

    <div class="ribbon">
        <div class="icon-ribbon"><img src="<?php echo $colabs_options['colabs_custom_bannericon']; ?>" alt="icon love" /></div>
    </div><!-- end ribbon -->
    
<?php } ?>