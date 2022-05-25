$('.menu>li').mouseover(function(){
  $(this).children('.submenu').stop().slideDown();
});
$('.menu>li').mouseleave(function(){
  $(this).children('.submenu').stop().slideUp();
});

var gmb = false;
$('.gmb_menu').click(function(){
  if (gmb == false) {
    $('nav').css('display','block');
    gmb = true;
  } else {
    $('nav').css('display','none');
    gmb = false;
  }

});