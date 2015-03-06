<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package mitua
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'mitua' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<div class="edit-link-container">
		<?php edit_post_link( __( 'Edit this Page', 'mitua' ), '<span class="edit-link">', '</span>' ); ?>
	</div>
</article><!-- #post-## -->
