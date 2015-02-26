<?php
/**
 * The Front Page
 *
 * @package mitua
 */

get_header(); ?>

<div class="footer">
 This is the front page
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); 
        if ( has_post_thumbnail() ) {
          echo "has image";
          the_post_thumbnail();
        } else {
          echo "no image";
        }

        get_template_part( 'content', 'single' ); 
        return;
        ?>

      <?php endwhile; ?>
    <?php else : ?>

      <?php get_template_part( 'content', 'none' ); ?>
    <?php endif; ?>

</div>

<?php get_footer(); ?>
