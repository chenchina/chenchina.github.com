<?php
/*---------------------------------------------------------------------------------*/
/* Social widget */
/*---------------------------------------------------------------------------------*/
class CoLabs_Social extends WP_Widget {

   function CoLabs_Social() {
	   $widget_ops = array('description' => 'Social widget.' );
       parent::WP_Widget(false, __('ColorLabs - Social', 'colabsthemes'),$widget_ops);      
   }

   function widget($args, $instance) {  
    extract( $args );
   	$title = apply_filters('widget_title', $instance['title'] );
	$facebook = $instance['facebook'];
	$twitter = $instance['twitter'];
	$rss = $instance['rss'];
	$linkedin = $instance['linkedin'];
	$youtube = $instance['youtube'];
	?>
		<?php echo $before_widget; ?>
        <?php if ($title) { echo $before_title . $title . $after_title; } ?>
        <ul class="widget-social">
			<?php if($facebook!=''){?>
			<li class="facebook"><a href="<?php echo $facebook;?>" target="_blank">Facebook</a></li>
			<?php }?>
			<?php if($twitter!=''){?>
			<li class="twitter"><a href="<?php echo $twitter;?>" target="_blank">Twitter</a></li>
			<?php }?>
			<li class="rss"><a href="<?php if ($rss!=''){echo $rss;}else{bloginfo('rss2_url');}?>"target="_blank">RSS</a></li>
			<?php if($linkedin!=''){?>
			<li class="linkedin"><a href="<?php echo $linkedin;?>" target="_blank">Linked in</a></li>
			<?php }?>
			<?php if($youtube!=''){?>
			<li class="youtube"><a href="<?php echo $youtube;?>" target="_blank">Youtube</a></li>
			<?php }?>
		</ul>
		<?php echo $after_widget; ?>   
   <?php
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {        
   
		$title = esc_attr($instance['title']);
		$facebook = esc_attr($instance['facebook']);
		$twitter = esc_attr($instance['twitter']);
		$rss = esc_attr($instance['rss']);
		$linkedin = esc_attr($instance['linkedin']);
		$youtube = esc_attr($instance['youtube']);
		
       ?>
	   <p>
	   	   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
       </p>
       <p>
	   	   <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook:','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('facebook'); ?>"  value="<?php echo $facebook; ?>" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" />
       </p>
	   
	   <p>
	   	   <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter:','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('twitter'); ?>"  value="<?php echo $twitter; ?>" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" />
       </p>
	   <p>
	   	   <label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('RSS:','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('rss'); ?>"  value="<?php echo $rss; ?>" class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" />
       </p>
	   <p>
	   	   <label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin:','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('linkedin'); ?>"  value="<?php echo $linkedin; ?>" class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" />
       </p>
	   <p>
	   	   <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('Youtube:','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('youtube'); ?>"  value="<?php echo $youtube; ?>" class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" />
       </p>
	   
      <?php
   }
} 

register_widget('CoLabs_Social');
?>