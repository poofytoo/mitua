$(document).ready(function() {
  var headerHeight = $('header').height();
  $(window).scroll(function() {
    if (!$('header').hasClass('scroll-header') && $(window).scrollTop() > headerHeight) {
      $('header').addClass('scroll-header');
    } else if ($('header').hasClass('scroll-header') && $(window).scrollTop() <= headerHeight) {
      $('header').removeClass('scroll-header');
    }
  })
});