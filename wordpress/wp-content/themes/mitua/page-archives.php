<?php
/**
 * Template Name: Archives
 *
 * @package mitua
 */

get_header(); ?>
  <div class="post-archives post-content">
    <div class="row">
      <div class="medium-12 columns">
        <div id="primary" class="content-area">
          <main id="main" class="site-main" role="main">
          
          <?php
          $args = array( 'posts_per_page' => 10 );
          $lastposts = get_posts( $args );
          foreach ( $lastposts as $post ) :
            setup_postdata( $post ); ?>
            <div class="single-post">
              <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
              <?php the_content(); ?>
              <div class="posted-on">
                Updated on <?php the_modified_date(); ?>
              </div>
            </div>
          <?php endforeach; 
          wp_reset_postdata(); ?>

          </main><!-- #main -->
        </div><!-- #primary -->
      </div>
    </div>
  </div>

<?php get_footer(); ?>
