<?php
/**
 * @package mitua
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	<div class="entry-meta">
    Updated on <?php the_modified_date(); ?>
	</div><!-- .entry-meta -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

  <div class="edit-link-container">
    <?php edit_post_link( __( 'Edit this Post', 'mitua' ), '<span class="edit-link">', '</span>' ); ?>
  </div>
</article><!-- #post-## -->
