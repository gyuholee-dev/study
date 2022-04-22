$(document).ready(function(){

  $imgs = $('#imgslide>.imgs>img');
  
  let cnt = 1;
  let timer = setInterval(function(){
    if (cnt === $imgs.length) {
      cnt = 0;
    }

    let fcnt = cnt+1;
    if (fcnt === $imgs.length) {
      fcnt = 0;
    }

    let bcnt = cnt-2;
    if (bcnt < 0) {
      bcnt = $imgs.length+bcnt;
    }

    for (var i = 0; i < $imgs.length; i++) {
      $img = $($imgs[i]);
      if (i === cnt) {
        $img.addClass('show');
        $img.removeClass('hide');
      } else if (i === bcnt) {
        $img.addClass('hide');
        $img.removeClass('show');
        $img.css('z-index', -1);
      } else if (i === fcnt) {
        $img.css('z-index', 1);
      } else {
        $img.css('z-index', 0);
      }
    }
    cnt++;
  }, 3000);




});