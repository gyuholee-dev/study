$(document).ready(function(){

    var sp = screen.width/2-300;
    var imgs=4;
    var now=0;
    var play;
    var mode = true;
    var prevIndex;

    function start() {
        $('#btn_play').css('display','block');
        // $('#btn_stop').css('display','none');
        let $img = $('.imgs>img');
        $img.eq(0).css({'left':-1220+sp});
        $img.eq(1).css({'left':-610+sp});
        $img.eq(2).css({'left':0+sp});
        $img.eq(3).css({'left':610+sp});
        $img.eq(4).css({'left':1220+sp});
        $('#btn_dot').children().eq(0).css('background-color','purple');
        play = setInterval(function(){
            slide();
        },2000);
    }

    function stop() {
        clearInterval(play);
        mode=false;
        $('#btn_play').css('display','none');
        $('#btn_stop').css('display','block');
    }

    function restart() {
        play = setInterval(function(){
            slide();
        },2000);
        $('#btn_play').css('display','block');
        $('#btn_stop').css('display','none');
    }

    function slide() {
        prevIndex = now;
        if (now==imgs) {
            now=0;
        } else {
            now++;
        }
        currSlide(now);
    }

    function currSlide(p) {
        let $img = $('.imgs>img');
        if (p==1) {
            $img.eq(1).css({'left':-1220+sp});
            $img.eq(2).css({'left':-610+sp});
            $img.eq(3).css({'left':0+sp});
            $img.eq(4).css({'left':610+sp});
            $img.eq(0).css({'left':1220+sp});
            $('#btn_dot').children().eq(prevIndex).css('background-color','#aaa');
            $('#btn_dot').children().eq(1).css('background-color','purple');
        } else if (p==2) {
            $img.eq(2).css({'left':-1220+sp});
            $img.eq(3).css({'left':-610+sp});
            $img.eq(4).css({'left':0+sp});
            $img.eq(0).css({'left':610+sp});
            $img.eq(1).css({'left':1220+sp});
            $('#btn_dot').children().eq(prevIndex).css('background-color','#aaa');
            $('#btn_dot').children().eq(2).css('background-color','purple');
        } else if (p==3) {
            $img.eq(3).css({'left':-1220+sp});
            $img.eq(4).css({'left':-610+sp});
            $img.eq(0).css({'left':0+sp});
            $img.eq(1).css({'left':610+sp});
            $img.eq(2).css({'left':1220+sp});
            $('#btn_dot').children().eq(prevIndex).css('background-color','#aaa');
            $('#btn_dot').children().eq(3).css('background-color','purple');
        } else if (p==4) {
            $img.eq(4).css({'left':-1220+sp});
            $img.eq(0).css({'left':-610+sp});
            $img.eq(1).css({'left':0+sp});
            $img.eq(2).css({'left':610+sp});
            $img.eq(3).css({'left':1220+sp});
            $('#btn_dot').children().eq(prevIndex).css('background-color','#aaa');
            $('#btn_dot').children().eq(4).css('background-color','purple');
        } else {
            $img.eq(0).css({'left':-1220+sp});
            $img.eq(1).css({'left':-610+sp});
            $img.eq(2).css({'left':0+sp});
            $img.eq(3).css({'left':610+sp});
            $img.eq(4).css({'left':1220+sp});
            $('#btn_dot').children().eq(prevIndex).css('background-color','#aaa');
            $('#btn_dot').children().eq(0).css('background-color','purple');
        }
    }

    function setSlide() {
        clearInterval(play);
        currSlide(now);
        if (mode==true) {
            play = setInterval(function(){
                slide();
            },2000);
        }
        prevIndex = now;
    }


    $('#btn_play').click(function(){
        stop();
    });
    $('#btn_stop').click(function(){
        restart();
    });
    $('#btn_dot .dot').click(function(){
        now = $(btn).index();
        setSlide();
    });
    $('#btn_prev').click(function(){
        if (now==0) {
            now=imgs;
        }
        now--;
        setSlide();
    });
    $('#btn_next').click(function(){
        if (now==imgs) {
            now=0;
        }
        now++;
        setSlide();
    });

    start();
});