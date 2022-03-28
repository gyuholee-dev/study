var i = 0;
var hi = 0;

function imgSlide(delay=2000) {
  var x = document.querySelectorAll('#imgslide>.imgs>.img');
  
  x[i].style.opacity = 1;
  x[i].className = 'img';
  x[i].style.zIndex = 1;
  hi = i-2;
  
  if (hi < 0) {
    hi = hi+x.length;
  }
  bi = i-1;
  if (bi < 0) {
    bi = bi+x.length;
  }
  
  x[hi].className = 'img hide';
  x[hi].style.opacity = 0;
  x[bi].style.zIndex = 0;

  if (i+1 == x.length) {
    i = 0;
  } else {
    i++;
  }
 
  setTimeout(() => {
    imgSlide(delay);
  }, delay);
}
