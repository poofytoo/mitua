<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package mitua
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		// THIS PAGE IS A SINGLE POST I THINK

			<?php while ( have_posts() ) : the_post(); ?>

				<?php 

				get_template_part( 'content', 'page' ); 

				?>

				<?php
					// NOTE: No page should ever have comments on the UA site.
					/*
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					*/
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
