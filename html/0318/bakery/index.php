<?php
// DB
$host = 'localhost';
$user = 'gyuholee';
$pass = 'guho1978';
$db = mysqli_connect($host, $user, $pass);
mysqli_select_db($db, 'gyuholee');

// 변수 선언
$sitetitle = 'DD베이커리';
$logo = '';
$topmenu = '';
$mainmenu = '';
$imgs = '';
$welcome = '';
$notice = '';
$partner = '';
$link = '';
$privacy = '';
$company = '';
$postscript = '';

$ad01 = '';
$ad02 = '';

// 페이지
$page = '';
$page = isset($_REQUEST['page'])?$_REQUEST['page']:'';
$sitetitle .= isset($_REQUEST['page'])?' : '.$_REQUEST['page']:'';

// 슬라이드 딜레이
$slidedelay = 3500;


// 로고
$logo = "
  <a href='index.php'>
    <img src='images/logo/logo.png'>
  </a>
";

// 탑메뉴
$topmenu = "
  <a href='#login'>로그인</a>
  <a href='#register'>회원가입</a>
";

// 메인메뉴
$menulist = array(
  'DD소개' => [
    '인사말',
    '연혁',
    '오시는길'
  ],
  '빵만들기' => [
    '제빵강좌',
    '제과강좌',
    '레시피'
  ],
  '커뮤니티' => [
    '공지사항',
    '자유게시판',
    '질문과답변'
  ]
);
foreach ($menulist as $key => $value) {
  $active = ($key==$page)?'active':'';
  $mainmenu .= "
    <li> 
      <a class='$active' href='?page=$key'>$key</a>
      <ul class='submenu'>
  ";
  foreach ($value as $val) {
    $mainmenu .= "
      <li><a href='?page=$key'>$val</a></li>
    ";
  }
  $mainmenu .= "
      </ul>
    </li>
  ";
}

// 이미지슬라이드
$imglist = array(
  [
    'title'=>'Title',
    'path'=>'images/slide/images(1).jpg',
    'desc'=>'Description'
  ],
  [
    'title'=>'Title',
    'path'=>'images/slide/images(2).jpg',
    'desc'=>'Description'
  ],
  [
    'title'=>'Title',
    'path'=>'images/slide/images(3).jpg',
    'desc'=>'Description'
  ],
  [
    'title'=>'Title',
    'path'=>'images/slide/images(4).jpg',
    'desc'=>'Description'
  ],
  [
    'title'=>'Title',
    'path'=>'images/slide/images(5).jpg',
    'desc'=>'Description'
  ],
);
foreach ($imglist as $key => $value) {
  $class = !($key > 0)?'img':'img hide';
  $imgs .= "
    <div class='$class'>
      <img src='$value[path]'>
      <!--<div class='title'><i>$value[title]</i></div>-->
    </div>
  ";
}

// 웰컴메시지
$welcome = "
  <h1>베이커리 카페</h1>
  <p>세상에 하나뿐인 베이커리</p>
";

// 공지사항
$sql = "SELECT * FROM notice
          ORDER BY num DESC
          LIMIT 0, 5";
$res = mysqli_query($db, $sql);

$notice .= "
  <div class='title'>공지사항</div>
  <table>
    <tr>
      <th>no.</th>
      <th>제목</th>
      <th>작성일</th>
    </tr>
";
while ($a = mysqli_fetch_assoc($res)) {
  $num = $a['num'];
  $title = $a['title'];
  $writer = $a['writer'];
  $wdate = $a['wdate'];
  $content = $a['content'];
  $hit = $a['hit'];
  $notice .= "
    <tr>
      <td>$num</td>
      <td>$title</td>
      <td>$wdate</td>
    </tr>
  ";
}
$notice .= "
  </table>
  <div class='hr'></div>
";

// 파트너
$partner = "
  <div class='title'>파트너</div>
  <div class='partner'>
    <a href='#'><img src='images/partner/partner.jpg'></a>
    <a href='#'><img src='images/partner/partner_up.png'></a>
  </div>
";

// 링크
$linklist = array(
  [
    'title'=>'레시피',
    'path'=>'images/icons/icon1.png'
  ],
  [
    'title'=>'새소식',
    'path'=>'images/icons/icon2.png'
  ],
  [
    'title'=>'안전관리',
    'path'=>'images/icons/icon3.png'
  ]
);
$link .= "
  <div class='title'>링크</div>
  <div class='links'>
";
foreach ($linklist as $lk) {
  $link .="
    <a href='#'>
      <img src='$lk[path]'>
      <span>$lk[title]</span>
    </a>
  ";
}
$link .= "
  </div>
";

// 프라이버시
$privacy = "<span><a href='#'>이용약관</a> | <a href='#'>개인정보 보호</a></span>";

// 컴패니
$company = "
  <span>
    (주) 디디베이커리<br>
    주소: 서울특별시 서초구 논현동 222-22<br>
    대표자: 김창수 | 개인정보책임자: 윤진서<br>
    고객센터: 1588-9000 | contact@ddbakery.com
  </span> 
";

// 포스트스크립트
$postscript = "
  <script>
    imgSlide($slidedelay);
  </script>
";

// 광고
$ad01 = "
  <div class='ad top'>
    <img src='images/bakery-ad-flyer.png'>
  </div>
";
$ad02 = "
  <div class='ad middle'>
    <img src='images/bakery-ad-flyer.png'>
  </div>
";


//------------------------ 랜더링 ------------------------

$content_values = array( 
  '{sitetitle}' => $sitetitle,
  '{logo}' => $logo,
  '{topmenu}' => $topmenu,
  '{mainmenu}' => $mainmenu,
  '{imgs}' => $imgs,
  '{welcome}' => $welcome,
  '{notice}' => $notice,
  '{partner}' => $partner,
  '{link}' => $link,
  '{privacy}' => $privacy,
  '{company}' => $company,
  '{postscript}' => $postscript,
  '{ad01}' => $ad01,
  '{ad02}' => $ad02,
);

$html = file_get_contents('template.html');
$html = strtr($html, $content_values);
echo $html;
