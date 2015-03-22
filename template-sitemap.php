<?php
/*
Template Name: Sitemap
*/
?>
<?php get_header(); global $colabs_options; ?>

<div class="container_16">
  <?php include(TEMPLATEPATH . '/includes/ribbon.php'); ?>
  <div class="clear"></div>
  <div <?php post_class();?>>
    <?php //if ( !is_mobile() ){ get_sidebar(); } ?>
    <div class="grid_16">
      <h1 class="page_head">
        <?php the_title(); ?>
      </h1>
      <div class="grid_8 alpha">
        <div class="sidebox">
          <h3>Pages :</h3>
          <ul >
            <?php wp_list_pages('title_li='); ?>
          </ul>
        </div>
        <div class="sidebox">
          <h3>Categories :</h3>
          <ul>
            <?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?>
          </ul>
        </div>
      </div>
      <!--column_l #end  -->
      
      <div class="grid_8 omega">
        <div class="sidebox">
          <h3>Monthly Archives :</h3>
          <ul>
            <?php wp_get_archives('type=monthly'); ?>
          </ul>
        </div>
        <div class="sidebox">
          <h3>RSS Feed :</h3>
          <ul>
            <li><a href="<?php bloginfo('rdf_url'); ?>" title="RDF/RSS 1.0 feed"><acronym title="Resource Description Framework">RDF</acronym>/<acronym title="Really Simple Syndication">RSS</acronym> 1.0 feed</a></li>
            <li><a href="<?php bloginfo('rss_url'); ?>" title="RSS 0.92 feed"><acronym title="Really Simple Syndication">RSS</acronym> 0.92 feed</a></li>
            <li><a href="<?php bloginfo('rss2_url'); ?>" title="RSS 2.0 feed"><acronym title="Really Simple Syndication">RSS</acronym> 2.0 feed</a></li>
            <li><a href="<?php bloginfo('atom_url'); ?>" title="Atom feed">Atom feed</a></li>
          </ul>
        </div>
      </div>
      <!--column_r #end  -->
      
      <div class="clear"></div>
    </div>
    <!--/.grid_16-->
    <div class="clear"></div>
    <div class="grid_16">
      <h2>Latest Post by Authors:</h2>
      <?php 
        $authors = array();
        $authors[] = $colabs_options['colabs_author_left'];
        $authors[] = $colabs_options['colabs_author_right'];
        
        foreach ( $authors as $author ){
        ?>
      <div class="grid_8 alpha">
        <div class="sidebox">
          <h3>
            <?php the_author_meta('display_name',$author); ?>
          </h3>
          <ul>
            <?php $archive_query = new WP_Query( 'showposts=30&author='.$author );
                    while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
            <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
              <?php the_title(); ?>
              </a>
              <?php comments_number('(0)', '(1)', '(%)'); ?>
            </li>
            <?php endwhile; ?>
          </ul>
        </div>
      </div>
      <!--/.grid_8 alpha-->
      <?php } // End FOREACH Loop ?>
    </div>
    <!--/.grid_16--> 
    
  </div>
  <!--/.box-post-right--> 
  
</div>
<!--/.container_16-->

<?php get_footer(); ?>
