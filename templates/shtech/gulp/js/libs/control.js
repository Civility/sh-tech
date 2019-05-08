'use strict'
jQuery(document).ready(function($) {
//slick jQuery
  function slickify(){
    $('#show').slick({
      autoplay: true,
      autoplaySpeed: 7000,
      arrows: true,
      dots: true,
      cssEase: 'linear',
      fade: true,
      infinite: true,
      lazyLoad: 'progressive',
      pauseOnHover: false,
      slidesToShow: 1,
      slidesToScroll: 1,
      speed: 700,
        prevArrow: '<button type="button" class="slick-prev">Предыдущая</button>',
        nextArrow: '<button type="button" class="slick-next">Следующая</button>',
      //   responsive: [
      //   {
      //     breakpoint: 960,
      //     settings: "unslick"
      //   }
      // ]
    });
  }
  slickify();
 $(window).resize(function(){
    var $windowWidth = $(window).width();
    if ($windowWidth > 960) {
        slickify();
    }
}); 
 // для открытия почты в модальном окне
   $('.popup-form').magnificPopup({
     type: 'inline',
     focus: '#FullName'
  });
   // в поле repeatable для слайд шоу
    $('.gallery').magnificPopup({
      delegate: 'a',
      type: 'image',
      tLoading: 'Загрузка изображения #%curr%...',
      mainClass: 'mfp-with-zoom',
      gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0, 1],
      },
      zoom: {
        enabled: true,
        duration: 300,
        easing: 'ease-in-out',
      }
    });
});