<div class="grid_4 sidebar">
    <?php 
		global $post; 
		$author=$post->post_author;
		$adam=get_option('colabs_author_left');
        $eve=get_option('colabs_author_right');
		if ($author==$adam){
			$sidebar='adam';
		}else if ($author==$eve){
			$sidebar='eve';
		}else{
            $sidebar='home';
        }
		wp_reset_query();
		if(is_home() || is_category() ||is_page_template('template-otherauthor.php')){
			$sidebar='home';
		}
        
        colabs_sidebar($sidebar);

        wp_reset_query();?>
        
</div>