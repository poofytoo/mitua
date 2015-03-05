<?php
/**
 * The Front Page
 *
 * @package mitua
 */
$url = "";
get_header(); ?>

<?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); 
        if ( has_post_thumbnail() ) {
          $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
        } else {
          // Default URL Goes here
          $url = '';
        }

        break;
      ?>
      <?php endwhile; ?>
    <?php else : ?>
      <?php //get_template_part( 'content', 'none' ); ?>
    <?php endif; ?>

<div class="row feature">
  <div class="feature-background" style="background-image:url('<?php echo $url; ?>');">
  </div>
  <div class="large-12 columns feature-text-container">
    <div class="feature-text">
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
      <a class="more-link" href="<?php the_permalink() ?>">read more</a>
    </div>
  </div>
</div>

<div class="who-we-are">
  <div class="row">
  <div class="large-2 columns text-graphic-container">
    <div class="text-graphic">
    </div>
    &nbsp;
  </div>
  <div class="large-6 columns text-desc">
    <h3>Who We Are</h3>
    <p>The UA is a group of undergraduate students elected to represent the MIT student body and all its facets.</p>
  </div>
  <div class="large-4 columns">
    <a class="more-link" href="">Meet the 2015 UA</a>
  </div>
</div>

<div class="twitter">
  <div class="row">
    <div class="large-4 columns">

    </div>
    <div class="large-8 columns text-desc">
      Our Public Relations Chair, Connie Huang, dishing out ice cream at the UGC-UA Toscanini's Study Break! #UA #UGC #MIT
    </div>
  </div>
</div>

<div class="footer">

</div>

<?php get_footer(); ?>
