<?php
/**
 * The template for displaying all single posts.
 *
 * @package mitua
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		// THIS PAGE IS THE SINGLE BLOGGIDTY POST I THINK

		<?php while ( have_posts() ) : the_post(); ?>

			<?php 


				get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
