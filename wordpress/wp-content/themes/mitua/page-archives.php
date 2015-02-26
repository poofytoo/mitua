<?php
/**
 * Template Name: Archives
 *
 * @package mitua
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    // This page will be like a blog. bloggity
    
    <?php
    $args = array( 'posts_per_page' => 10 );
    $lastposts = get_posts( $args );
    foreach ( $lastposts as $post ) :
      setup_postdata( $post ); ?>
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <?php the_content(); ?>
    <?php endforeach; 
    wp_reset_postdata(); ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php get_footer(); ?>
