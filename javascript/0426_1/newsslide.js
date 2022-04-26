$(document).ready(function(){

    // 뉴스
    const $news = $('#newsslide .news a');
    const newsCnt = $news.length;
    const newsHeight = $('#newsslide .news').height();
    const margin = 0;
    const delay = 5000;
    let repeat;
    let ci = 2; // 현재 가운데 뉴스 인덱스

    // 버튼

    // newsslide
    const $newsslide = $('#newsslide');

    // -------------------------------------------------------

    function slide() {
        for (let i = 0; i < newsCnt; i++) {
            let $t = $($news[i]);
            let d = i - ci;
            if (d < 0-Math.floor(newsCnt/2)) {
                d += newsCnt;
            } else if (d > Math.floor(newsCnt/2)) {
                d -= newsCnt;
            }
            let pos = (d * newsHeight) + (d * margin);
            $t.css({
                'transform': `translateY(${pos}px)`,
                'z-index': 0-Math.abs(d)
            });
        }
    }

    function play(to = true) {
        if (to == true) {
            clearInterval(repeat);
            repeat = setInterval(function(){
                ci++;
                if (ci >= newsCnt) {
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
            ci = newsCnt - 1;
        }
        replay();
    }

    function next () {
        ci++;
        if (ci >= newsCnt) {
            ci = 0;
        }
        replay();
    }

    // -------------------------------------------------------

    // 슬라이드 시작
    slide();
    play(true);

    // newsslide 호버
    $newsslide.on('mouseenter', function(){
        play(false);
    });
    $newsslide.on('mouseleave', function(){
        play(true);
    });

});