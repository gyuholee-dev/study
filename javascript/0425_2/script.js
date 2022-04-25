$(document).ready(function(){
    $('.prev').addClass('off');
    $('.imgs>img').eq(0).siblings().css('display','none');


    $('.prev').click(function(){
        if(!$('.imgs>img').first().is(':visible')) {
            $('.imgs>img:visible').hide().prev('img').fadeIn('slow');
            $('.next').removeClass('off');
        }
        if($('.imgs>img').first().is(':visible')) {
            $('.prev').addClass('off');
        }
    });
    $('.next').click(function(){
        if(!$('.imgs>img').last().is(':visible')) {
            $('.imgs>img:visible').hide().next('img').fadeIn('slow');
            $('.prev').removeClass('off');
        }
        if($('.imgs>img').last().is(':visible')) {
            $('.next').addClass('off');
        }
    });


});