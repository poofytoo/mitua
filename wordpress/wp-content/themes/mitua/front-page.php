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

<?php
  function firstSentence($content) {
    if(preg_match('/[.?!]/', $content, $matches, PREG_OFFSET_CAPTURE)) {
        $index = $matches[0][1];
        return substr($content, 0, $index + 1);
    } else {
        return $content;
    }
  }
?>

<div class="feature">
  <div class="feature-background" style="background-image:url('<?php echo $url; ?>');">
  </div>
  <div class="row">
    <div class="large-12 columns feature-text-container">
      <div class="feature-text">
        <h1><?php the_title(); ?></h1>
        <p><?php echo firstSentence(get_the_content()); ?></p>
        <a class="more-link" href="<?php the_permalink() ?>">read more</a>
      </div>
    </div>
  </div>
</div>

<div class="who-we-are">
  <div class="row">
    <div class="medium-1 columns text-graphic-container">
      <div class="text-graphic">
      </div>
      &nbsp;
    </div>
    <div class="medium-6 columns text-desc">
      <h3>Who We Are</h3>
      <p>The UA is a group of undergraduate students elected to represent the MIT student body and all its facets.</p>
    </div>
    <div class="medium-4 columns text-link-container">
      <a class="more-link" href="">Meet the 2015 UA</a>
    </div>
  </div>
</div>

<div class="twitter">
  <div class="row">
    <div class="medium-2 columns">
      &nbsp;
    </div>
    <div class="medium-8 columns text-desc">
      Our Public Relations Chair, Connie Huang, dishing out ice cream at the UGC-UA Toscanini's Study Break! #UA #UGC #MIT
    </div>
    <div class="medium-2 columns twitter-icon-column">
      <div class="twitter-icon-container">
        <div class="twitter-icon">
        </div>
        <div class="twitter-link">
          <a href="http://twitter.com">@mitUA</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="footer">

</div>

<?php get_footer(); ?>
