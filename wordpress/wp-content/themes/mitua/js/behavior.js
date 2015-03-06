$(document).ready(function() {
  var headerHeight = 99;
  $(window).scroll(function() {
    if ($(window).scrollTop() > headerHeight && !$('.site-header').hasClass('site-header-fixed')) {
      $('.site-content').addClass('site-content-padding');
      $('.site-header').addClass('site-header-fixed');
      if ($('#wpadminbar').length) {
        $('.site-header').addClass('site-header-admin');
      }

    } else if ($(window).scrollTop() < headerHeight && $('.site-header').hasClass('site-header-fixed')) {

      $('.site-content').removeClass('site-content-padding');
      $('.site-header').removeClass('site-header-fixed');
      if ($('#wpadminbar').length) {
        $('.site-header').removeClass('site-header-admin');
      }
    }
  })
});