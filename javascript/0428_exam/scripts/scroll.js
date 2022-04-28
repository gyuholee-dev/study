// 스크롤 버튼 활성화
$(window).scroll(function() {
    if ($(this).scrollTop() > 50) {
        $('.scrolltop').fadeIn();
    } else {
        $('.scrolltop').fadeOut();
    }
});


$(() => {

    // 스크롤 탑
    $('.scrolltop').click(function() {
        $('html, body').animate({scrollTop: 0}, 500);
    });

});

