<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package mitua
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style/foundation/css/foundation.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style/main.css" media="screen" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
    <div class="row navbar">
      <div class="large-12 columns">
        <div class="row">
          Logo and Search
        </div>
        <div class="row">
  	     <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
        </div>
      </div>
    </div>
  </header><!-- #masthead -->

	<div id="content" class="site-content">
