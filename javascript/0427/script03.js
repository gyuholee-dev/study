// 스크롤 버튼 활성화
$(window).scroll(function() {
    if ($(this).scrollTop() > 0) {
        $('.top').fadeIn();
    } else {
        $('.top').fadeOut();
    }
});


$(document).ready(function() {

    // 스크롤 탑
    $('.top').click(function() {
        $('html, body').animate({scrollTop: 0}, 500);
    });

});

