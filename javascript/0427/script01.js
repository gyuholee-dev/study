$(document).ready(function(){

    // 팝업창1 체크
    if ($.cookie('nopopup1') == 'y') {
        $('#pop01').hide();
    } else {
        $('#pop01').show();
    }

    // 팝업창2 체크
    if ($.cookie('nopopup2') == 'y') {
        $('#pop02').hide();
    } else {
        $('#pop02').show();
    }


    // 팝업창1 닫기
    $('#close01').click(function(){
        if (document.frmPopup.pop01.checked) {
            $.cookie('nopopup1', 'y', { expires: 1 });
        }
        $('#pop01').hide();
    });

    // 팝업창2 닫기
    $('#close02').click(function(){
        if (document.frmPopup.pop02.checked) {
            $.cookie('nopopup2', 'y', { expires: 1 });
        }
        $('#pop02').hide();
    });


});