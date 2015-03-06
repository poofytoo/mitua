<?php
/**
 * The template for displaying all single posts.
 *
 * @package mitua
 */

get_header(); ?>

  <?php while ( have_posts() ) : the_post(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

    <?php if ( has_post_thumbnail() ) {
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
    ?>
      <div class="feature feature-post">
        <div class="feature-background" style="background-image:url('<?php echo $url; ?>');">
        </div>
      </div>
    <?php } ?>

		  <div class="post-content">
        <div class="row">
          <div class="medium-12 columns">
            <?php get_template_part( 'content', 'single' ); ?>
          </div>
        </div>
        <div class="row all-posts">
          <div class="medium 12 columns">
            <a class="more-link" href="/wordpress/post-archives/">See Older Posts</a>
          </div>
        </div>
      </div>
		</main><!-- #main -->
	</div><!-- #primary -->

  <?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>
