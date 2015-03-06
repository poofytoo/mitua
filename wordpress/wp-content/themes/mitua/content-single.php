<?php
/**
 * @package mitua
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php mitua_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
	</div><!-- .entry-content -->
	
	<footer class="entry-footer">
		<!-- <?php mitua_entry_footer(); ?> -->
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
