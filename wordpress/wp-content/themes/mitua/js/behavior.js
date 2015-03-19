$(function() {
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
  });

  $(window).resize(function() {
    recalculateWindow();
  })

  function recalculateWindow() {
    if ($(window).width() <= 642) {
      // $('header').find('ul').find('a').attr("href", "javascript:void(0)")
    } else {

    }
  }
  $(document).ready(function() {
    $('#menu-main-menu > .menu-item-has-children > a').click(function(event) {
      event.preventDefault();
      var submenu = $(this).parent().children('.sub-menu');
      if (submenu.hasClass('open')) {
        submenu.slideUp().removeClass('open');
      } else {
       submenu.slideDown();
       submenu.addClass('open');
      }
      
    })
  })

  recalculateWindow();
});