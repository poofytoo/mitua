<?php
/**
 * The template for displaying all single posts.
 *
 * @package mitua
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		  <div class="content">
        <div class="row">
          <div class="medium-12 columns">
            <?php while ( have_posts() ) : the_post(); ?>
              <?php get_template_part( 'content', 'single' ); ?>
            <?php endwhile; // end of the loop. ?>
          </div>
        </div>
      </div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
