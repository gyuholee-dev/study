$(document).ready(function(){

    // 이미지
    const $imgs = $('#imgslide .imgs img');
    const imgCnt = $imgs.length;
    const imgWidth = $imgs[0].width;
    const margin = 15;
    const delay = 2500;
    let repeat;
    let ci = 2; // 현재 가운데 이미지 인덱스

    // 버튼
    const $navs = $('#imgslide .btn.nav>button');
    const $dots = $('#imgslide .btn.page>button');

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
            clearInterval(repeat);
            repeat = setInterval(function(){
                ci++;
                if (ci >= imgCnt) {
                    ci = 0;
                }
                slide();
            }, delay);
        } else {
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
    // 버튼 도트
    $dots.on('click', function(){
        let $this = $(this);
        let idx = $this.index();
        ci = idx;
        replay();
    });
    // imgslide 호버
    $imgslide.on('mouseenter', function(){
        play(false);
    });
    $imgslide.on('mouseleave', function(){
        play(true);
    });

});