$('.menu>li').mouseover(function(){
  console.log('mouseover');
  $(this).children('ul').stop().slideDown();
});

$('.menu>li').mouseleave(function(){
  console.log('mouseleave');
  $(this).children('ul').stop().slideUp();
});