function swipe(list, direction) {
    const $list = $(list);
    const listWidth = 1240; // 고정값
    const $items = $list.find('.items');
    const itemsWidth = $items.width();
    const itemCnt = $list.find('.item').length;
    let ci = Number($list.attr('data'));
    let pos = 0;

    let groupCnt = [];
    if (itemCnt%5 == 0) {
        for (let i = 0; i < itemCnt/5; i++) {
            groupCnt.push(5);
        }
    }
    if (itemCnt%5 != 0) {
        for (let i = 0; i < (itemCnt-(itemCnt%5))/5; i++) {
            groupCnt.push(5);
        }
        groupCnt.push(itemCnt%5);
    }

    // console.log(ci);
    if (direction == 'prev') {
        if (ci == 0) {
            return false;
        }
        ci--;
        pos = 0-((ci * listWidth) + (ci * 10));
        $items.css({
            'transform': `translateX(${pos}px)`
        });

    } else if (direction == 'next') {
        if (ci+1 >= itemCnt/5) {
            return false;
        }
        ci++;
        pos = 0-((ci * listWidth) + (ci * 10));
        $items.css({
            'transform': `translateX(${pos}px)`
        });
    }
    
    if (ci == 0) {
        $list.find('.prev').addClass('disabled');
    } else if (ci == itemCnt - 1) {
        $list.find('.next').addClass('disabled');
    } else if (ci > 0) {
        $list.find('.prev').removeClass('disabled');
    } else if (ci < itemCnt - 1) {
        $list.find('.next').removeClass('disabled');
    }

    $list.attr('data', ci);
    
}

// 리스트 랜더링 후 실행
listReady.then(()=>{

    const $dramaList = $('section.dramalist');
    const $navs = $('section.dramalist .buttons.nav>button');

    $navs.on('click', function() {
        let list = '#' + $(this).attr('data');
        let direction = $(this).prop('classList')[1];
        swipe(list, direction);
    });

});