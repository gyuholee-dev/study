<?php
// 변수 선언
$sitetitle = 'HS Hotel';
$logo = '';
$mainmenu = '';
$welcome = '';
$intro = '';
$story = '';
$membership = '';
$service = '';
$privacy = '';
$company = '';
$links = '';


// 페이지
$page = isset($_REQUEST['page'])?$_REQUEST['page']:'';
$sitetitle .= ($page!='')?' : '.$page:'';

// 로고
$logo = "
  <a href='index.php'>
    <!--<img src='images/logo.gif'>-->
    <h1>HS Hotel</h1>
    <span>Ambassador Busan</span>
  </a>
";

// 메인메뉴
$menulist = array(
  '호텔소개'=>[],
  '객실'=>[],
  '다이닝'=>[],
  '웨딩&연회'=>[],
);
$mainmenu .= "
  <li class='menu'>
    <a href='#'>&#9776;</a>
  </li>
";
foreach ($menulist as $key => $menu) {
  $str = $key;
  $key = str_replace('&', '_', $key);
  $active = ($key==$page)?'active':'';
  $mainmenu .= "
    <li class='$active'>
      <a href='?page=$key'>$str</a>
    </li>
  ";
}

// 웰컴
$welcome = "
  <h1>Enjoy All Day All Night</h1>
  <p>아름다운 부산의 풍경이 파노라마처럼 펼쳐지는 곳</p>
";

// 인트로
$introlist = array(
  [
    'title'=>'STANDARD ROOM',
    'image'=>'ing_rooms&dinins01.jpg',
    'description'=> '프랜치 감성의 아늑한 인테리어의 침실과 샤워부스를 갖춘 욕실로 구성된 객실'
  ],
  [
    'title'=>'DELUXE ROOM',
    'image'=>'ing_rooms&dinins02.jpg',
    'description'=> '아늑한 침실과 로멘틱한 욕조가 있는 욕실이 프렌치 패턴의 파티션으로 구분되어 있는 객실'
  ],
  [
    'title'=>'LOUNGE&BAR',
    'image'=>'ing_rooms&dinins03.jpg',
    'description'=> '하늘과 맞닿은 곳에서 로멘틱한 무드와 함께 특별한 칵테일과 레시피를 만나보세요.'
  ],
  [
    'title'=>'RESTAURANTS',
    'image'=>'ing_rooms&dinins04.jpg',
    'description'=> '로컬 식재료를 재해석하는 창의적인 쿼진이 새로운 미각의 즐거움을 선사합니다.'
  ],
);

$intro .= "
  <div class='title'>Rooms & Dining</div>
  <div class='box row scroll'>
";
foreach ($introlist as $key => $data) {
  $intro .= "
    <div class='article'>
      <a class='image' href='#intro'><img src='images/$data[image]'></a>
      <h1>$data[title]</h1>
      <p>$data[description]</p>
    </div>
  ";
}
$intro .= "
  </div>
";

// 스토리
$story .= "
  <div class='title'>Brand Story</div>
  <div class='box row'>
    <div class='box column half'>
      <h1><i>\"잊지못할 특별한 순간, 행복의 경험을 선물하다\"</i></h1>
      <p>
        머무르는 공간의 이야기가 풍부할수록 기억은 더 특별해집니다.
        일상에서 무뎌진 감정과 설렘을 다시 깨우는 HS HOTEL만의 이야기를 만나세요.
      </p>
      <a class='button' href='#story'>스토리 더보기</a>
    </div>
    <div class='box columns half'>
      <a class='image' href='#story'><img src='images/ing_brandstory01.jpg'></a>
    </div>
  </div>
";

// 멤버십
$membership = "
  <div class='box row half'>
    <div class='title'>Membership Guide</div>
    <a href='#links'>
      <img src='images/ico_membershipguide01.png'>
      <span>FITNESS</span>
    </a>
    <a href='#links'>
      <img src='images/ico_membershipguide02.png'>
      <span>GOLF CLUB</span>
    </a>
  </div>
  <div class='box row half'>
    <div class='title'>Other Service</div>
    <a href='#links'>
      <img src='images/ico_otherservice01.png'>
      <span>CS CENTER</span>
    </a>
    <a href='#links'>
      <img src='images/ico_otherservice02.png'>
      <span>EVENT</span>
    </a>
  </div>
";

// 프라이버시
$privacy = "
  <p>
    <a href='#footer'>고객센터</a> |
    <a href='#footer'>이용약관</a> |
    <a href='#footer'>개인정보보호</a>
  </p>
";

// 컴패니
$company = "
  <p>
    상호명: HS Hotel | 주소:부산광역시 해운대구 마린시티2로 12<br>
    TEL:0551-123-4567 | FAX:051-910-1234 | contact@hshotel.com<br>
    Copyright ⓒ HS Hotel All rights reserved.
  </p>
";

// 링크
$links = "
  <select class='links'>
    <option>하얏트 호텔</option>
    <option>블루 호텔</option>
    <option>그린 호텔</option>
  </select>
";



// ------------------------ 랜더링 ------------------------
$content_values = array( 
  '{sitetitle}' => $sitetitle,
  '{logo}' => $logo,
  '{mainmenu}' => $mainmenu,
  '{welcome}' => $welcome,
  '{intro}' => $intro,
  '{story}' => $story,
  '{membership}' => $membership,
  '{service}' => $service,
  '{privacy}' => $privacy,
  '{company}' => $company,
  '{links}' => $links
);


$html = file_get_contents('template.html');
$html = strtr($html, $content_values);
echo $html;