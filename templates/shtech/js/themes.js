'use strict'
jQuery(document).ready(function($) {
//липкое меню
/*var objToStick = $("#header"); //Получаем нужный объект
  var topOfObjToStick = $(objToStick).offset().top; //Получаем начальное расположение нашего блока
  $(window).scroll(function () {
      var windowScroll = $(window).scrollTop(); //Получаем величину, показывающую на сколько прокручено окно
      if (windowScroll > topOfObjToStick) { // Если прокрутили больше, чем расстояние до блока, то приклеиваем его
          $(objToStick).addClass('fixed-top');
      } else {
           $(objToStick).removeClass("fixed-top");
      };
  });*/


//отступ от шапки
var objToStick = $("#header").height();
$('.showing, .breadcrumb').css('margin-top', (objToStick) + 'px');
$('.navbar-brand').not('.logo-home').css('height', (objToStick) + 'px');
// $('#header .navbar-brand').not('.logo-home').css('height', (objToStick) + 'px');

//открытие ссылки события 
if ($('#events .link')) {
  var hash = window.location.hash;
  $(hash).collapse('show');
}


$('#main').click(function () {
     $('#catalogNavbar').collapse('hide');
});

});