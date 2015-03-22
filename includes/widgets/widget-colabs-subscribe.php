<?php
/*---------------------------------------------------------------------------------*/
/* Subscribe widget */
/*---------------------------------------------------------------------------------*/
class CoLabs_Subscribe extends WP_Widget {

   function CoLabs_Subscribe() {
	   $widget_ops = array('description' => 'Subscribe by Mail Widget.' );
       parent::WP_Widget(false, __('ColorLabs - Subscribe by Mail', 'colabsthemes'),$widget_ops);      
   }

   function widget($args, $instance) {  
    extract( $args );
   	$title = $instance['title'];
	$feedid = $instance['feedid'];
	$width = $instance['width'];
    $height = $instance['height'];
	?>
		<?php echo $before_widget; ?>
        <?php echo $before_title;?>
        <?php if ($title) { echo $title; }else{ _e('Email Subscription','colabsthemes'); } ?>
		<?php echo $after_title;  ?>
        
	   <form class="feedemail-form" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feedid; ?>', 'popupwindow', 'scrollbars=no,width=<?php echo $width; ?>,height=<?php echo $height; ?>');return true">
		<input type="text" class="feedemail-input" name="email" value="<?php _e('Your Email Here','colabsthemes'); ?>" onclick="this.focus();this.select();"/>
		<input type="hidden" value="<?php echo $feedid; ?>" name="uri"/>
		<input type="hidden" name="loc" value="en_US"/>
		<input type="submit" value="<?php _e('Signup','colabsthemes'); ?>" class="feedemail-button"/>
		<div><span class="feedemail-footer"><?php _e('Delivered by','colabsthemes'); ?> <a href="http://feedburner.google.com" target="_blank">FeedBurner</a></span></div>
	   </form>        
        
		<?php echo $after_widget; ?>   
   <?php
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {        
   
        $title = esc_attr($instance['title']);
        $feedid = esc_attr($instance['feedid']);
        $width = esc_attr($instance['width']);
		$height = esc_attr($instance['height']);
		
		if(empty($width)) $width = 300;
		if(empty($height)) $height = 220;
       ?>
       <p>
	   	   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
       </p>
	    <p>
	   	   <label for="<?php echo $this->get_field_id('feedid'); ?>"><?php _e('Feedburner ID :','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('feedid'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('feedid'); ?>" />
       </p>
         <p>
            <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Form Size:','colabsthemes'); ?></label>
            <input type="text" size="2" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $width; ?>" class="" id="<?php echo $this->get_field_id('width'); ?>" /> W
            <input type="text" size="2" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $height; ?>" class="" id="<?php echo $this->get_field_id('height'); ?>" /> H

        </p>       
      <?php
   }
} 

register_widget('CoLabs_Subscribe');


if(is_active_widget( null,null,'colabs_subscribe' ) == true) {
	add_action('wp_head','colabs_subscribe_css');
}

function colabs_subscribe_css(){
?>
<!-- CoLabs Subscribe Widget -->
<style type="text/css">
.feedemail-form{
	background-image:url("images/email-icon-28x50.png");
	background-repeat:no-repeat;
	background-position: 5px 7px;	
	border:1px dashed #8DC63F;
	padding:3px;
	text-align:center;
	padding-left:41px;
}

.feedemail-label{
	color: #8DC63F;
	font-family:Arial,Verdana,Helvetica,sans-serif;
	font-size:12px;
	font-weight:bold;
}

.feedemail-input{
	border: 1px solid #777; 
	color: #8DC63F;
	width: 140px;
	background-color: #444;
	width:140px;
	margin-top:5px;
	margin-bottom:3px;
}
.feedemail-input:hover{
	border: 1px solid #8DC63F; 
	background-color:#111;
}

.feedemail-button{
	background-color: #8DC63F;
	border:1px solid #8DC63F;
}

.feedemail-footer{
	font-size:9px;
	color:#8F8F8F;
}

.rss-widget
{
	background-image:url("images/feed-icon-28x28.png");
	background-repeat:no-repeat;
	background-position: 5px 5px;
	padding-left:41px;
	border:1px dashed darkorange;
	color:darkorange;
	padding-top:3px;
	padding-bottom:3px;
	padding-right:3px;
	margin-bottom:3px;
	text-align:center;
	height:32px;
	font-size:25px;
}
.rss-widget:hover
{
	border:1px solid darkorange;
	text-decoration:underline;
} 
</style>
<?php
}


?>