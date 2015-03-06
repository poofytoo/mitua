<?php
/**
 * @package mitua
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	<div class="entry-meta">
		<?php mitua_posted_on(); ?>
	</div><!-- .entry-meta -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
	
	<footer class="entry-footer">
		<!-- <?php mitua_entry_footer(); ?> -->
	</footer><!-- .entry-footer -->
	
</article><!-- #post-## -->
