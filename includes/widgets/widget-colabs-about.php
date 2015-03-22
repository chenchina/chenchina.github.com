<?php
/*---------------------------------------------------------------------------------*/
/* About widget */
/*---------------------------------------------------------------------------------*/
class CoLabs_About extends WP_Widget {

   function CoLabs_About() {
	   $widget_ops = array('description' => 'About Page.' );
       parent::WP_Widget(false, __('ColorLabs - About Page', 'colabsthemes'),$widget_ops);      
   }

   function widget($args, $instance) {  
    extract( $args );

	$page = $instance['page'];
	?>
		<?php echo $before_widget; ?>
        
        <?php 
		wp_reset_query();
		query_posts('page_id='.$page);
		while ( have_posts() ) : the_post();
		?>
		<div class="page-widget">
		<?php 
		echo $before_title;
		?>
		<?php the_title();?>
		<?php  echo $after_title;?>
		<?php colabs_custom_excerpt(40,'');	?>
		<p><a class="more" href="<?php the_permalink();?>">View more</a></p>
		</div>
		<?php
		
		endwhile;
		?>
		<?php echo $after_widget; ?>   
   <?php
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {        
   

	   $page = esc_attr($instance['page']);

       ?>

	    <p>
	   	   <label for="<?php echo $this->get_field_id('page'); ?>"><?php _e('Page:','colabsthemes'); ?></label>
		   <select name="<?php echo $this->get_field_name('page'); ?>">
			<?php
			$colabs_pages = array();
			$colabs_pages_obj = get_pages('sort_column=post_parent,menu_order');    
			
			foreach ($colabs_pages_obj as $colabs_page) {
			//$colabs_pages[$colabs_page->ID] = $colabs_page->post_name; 
			if ($page==$colabs_page->ID)$selected='selected="true"';
			echo '<option value="'.$colabs_page->ID.'" '.$selected.'>'.$colabs_page->post_name.'</option>';
			}
			?>
			</select>
	       
       </p>
      <?php
   }
} 

register_widget('CoLabs_About');
?>