$(document).ready(function(){

    // 이미지
    const $imgs = $('#imgslide>.imgs>.item');
    const imgCnt = $imgs.length;
    const imgWidth = $imgs.children('img')[0].clientWidth;
    const margin = 20;
    const delay = 2500;
    let repeat;
    let ci = Math.floor(Math.random() * imgCnt-1); // 현재 가운데 이미지 랜덤

    // 버튼
    const $navs = $('#imgslide .buttons.nav>button');
    const $play = $('#imgslide .buttons.page>button.play');
    const $dots = $('#imgslide .buttons.page>button.dot');

    // imgslide
    const $imgslide = $('#imgslide');

    // -------------------------------------------------------

    function slide() {
        for (let i = 0; i < imgCnt; i++) {
            let $img = $($imgs[i]);
            let d = i - ci;
            if (d < 0-Math.floor(imgCnt/2)) {
                d += imgCnt;
            } else if (d > Math.floor(imgCnt/2)) {
                d -= imgCnt;
            }
            let pos = (d * imgWidth) + (d * margin);
            $img.css({
                'transform': `translateX(${pos}px)`,
                'z-index': (0-Math.abs(d))+2
            });
        }
        $($dots[ci]).addClass('active');
        $($dots[ci]).siblings().removeClass('active');
    }

    function play(to = true) {
        if (to == true) {
            $play.removeClass('stop');
            clearInterval(repeat);
            repeat = setInterval(function(){
                ci++;
                if (ci >= imgCnt) {
                    ci = 0;
                }
                slide();
            }, delay);
        } else {
            $play.addClass('stop');
            clearInterval(repeat);
        }
    }

    function replay() {
        play(false);
        slide();
        setTimeout(function(){
            play(true);
        }, delay);
    }

    function prev () {
        ci--;
        if (ci < 0) {
            ci = imgCnt - 1;
        }
        replay();
    }

    function next () {
        ci++;
        if (ci >= imgCnt) {
            ci = 0;
        }
        replay();
    }

    // -------------------------------------------------------

    // 슬라이드 시작
    slide();
    play(true);

    // 버튼 이전 다음
    $navs.on('click', function(){
        let $this = $(this);
        if ($this.hasClass('prev')) {
            prev();
        } else if ($this.hasClass('next')) {
            next();
        }
    });
    // 버튼 재생 정지
    $play.on('click', function(){
        let $this = $(this);
        if ($this.hasClass('stop')) {
            play(true);
        } else {
            play(false);
        }
    });
    // 버튼 도트
    $dots.on('click', function(){
        let $this = $(this);
        let idx = $this.index()-1;
        ci = idx;
        replay();
    });
    // imgslide 호버
    // $imgslide.on('mouseenter', function(){
    //     play(false);
    // });
    // $imgslide.on('mouseleave', function(){
    //     play(true);
    // });

});