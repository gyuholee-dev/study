<?php
  // DB
  $host = 'localhost';
  $user = 'gyuholee';
  $pass = 'guho1978';
  $db = mysqli_connect($host, $user, $pass);
  mysqli_select_db($db, 'gyuholee');

  $sql = "SELECT * FROM notice
          ORDER BY num DESC
          LIMIT 0, 5";
  $res = mysqli_query($db, $sql);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TRAVEL</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="container">

  <div id="header">
    <div class="logo">
      <a href="index.html">
        <img src="logo/logo.png">
      </a>
    </div>
    <div class="menu">
      <div class="topmenu">
        <a href="#">LOGIN</a>
        <a href="#">SIGNUP</a>
      </div>
      <!-- <div class="bottommenu">
        <a href="#">여행가이드</a>
        <a href="#">국내여행</a>
        <a href="#">해외여행</a>
        <a href="#">커뮤니티</a>
      </div> -->
      <ul class="bottommenu">
        <li><a href="#">여행가이드</a>
          <ul class="submenu">
            <li><a href="#">인사말</a></li>
            <li><a href="#">연혁</a></li>
          </ul>
        </li>
        <li><a href="#">국내여행</a>
          <ul class="submenu">
            <li><a href="#">경기/강원</a></li>
            <li><a href="#">경상도</a></li>
            <li><a href="#">충청도</a></li>
            <li><a href="#">전라도</a></li>
            <li><a href="#">제주도</a></li>
          </ul>
        </li>
        <li><a href="#">해외여행</a>
          <ul class="submenu">
            <li><a href="#">동남아시아</a></li>
            <li><a href="#">유럽</a></li>
            <li><a href="#">남태평양</a></li>
            <li><a href="#">오세아니아</a></li>
            <li><a href="#">북중미</a></li>
          </ul>
        </li>
        <li><a href="#">커뮤니티</a>
          <ul class="submenu">
            <li><a href="#">공지사항</a></li>
            <li><a href="#">자유게시판</a></li>
            <li><a href="#">질문과답변</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>

  <div id="imgslide">
    <div class="imgs">
      <div class="img">
        <img src="images/slide/images(1).jpg">
        <div class="title"><i>MAIA Luxury Resort & Spa Hotel</i></div>
      </div>
      <div class="img hide">
        <img src="images/slide/images(2).jpg">
        <div class="title"><i>2 Day Cappadocia Tour from Istanbul</i></div>
      </div>
      <div class="img hide">
        <img src="images/slide/images(3).jpg">
        <div class="title"><i>Maldives Dinner on the Beach</i></div>
      </div>
      <div class="img hide">
        <img src="images/slide/images(4).jpg">
        <div class="title"><i>Andaman and Nicobar Beaches</i></div>
      </div>
      <div class="img hide">
        <img src="images/slide/images(5).jpg">
        <div class="title"><i>Sun Valley Skiing & Snowboarding Resort</i></div>
      </div>
    </div>
    <div class="welcome">
      <i>여행가이드에 오신것을 환영합니다.</i>
    </div>
  </div>

  <script>
      var i = 0;
      var hi = 0;
      carousel();

      function carousel() {
        var x = document.querySelectorAll('#imgslide>.imgs>.img');
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
        x[bi].style.zIndex = 0;
        if (i+1 == x.length) {
          i = 0;
        } else {
          i++;
        }
        setTimeout(carousel, 2000);
      }
  </script>

  <div id="content">

    <div class="box" style="height:415px">
      <div class="title">국내여행지</div>
      <iframe style="width:100%;height:100%;max-width:600px;margin:0 auto;"
      src="https://www.youtube.com/embed/aa1EIaYC3t8" title="YouTube video player" 
      frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>

    <div class="box half">
      <div class="title">공지사항</div>
      <table>
        <tr>
          <th>no</th>
          <th>제목</th>
          <th>작성일</th>
        </tr>
        <?php
          while ($a = mysqli_fetch_assoc($res)) {
            $num = $a['num'];
            $title = $a['title'];
            $writer = $a['writer'];
            $wdate = $a['wdate'];
            $content = $a['content'];
            $hit = $a['hit'];
            echo "
              <tr>
                <td>$num</td>
                <td>$title</td>
                <td>$wdate</td>
              </tr>
            ";
          }
        ?>
      </table>
      <div class="hr"></div>
    </div>

    <div class="box half">
      <div class="title">커뮤니티</div>
      <table>
        <tr>
          <th>제목</th>
          <th>작성일</th>
        </tr>
        <tr>
          <td>해운대 리조트 8월 예약 문의</td>
          <td>2022.03.08</td>
        </tr>
        <tr>
          <td>해운대 리조트 8월 예약 문의</td>
          <td>2022.03.08</td>
        </tr>
        <tr>
          <td>해운대 리조트 8월 예약 문의</td>
          <td>2022.03.08</td>
        </tr>
        <tr>
          <td>해운대 리조트 8월 예약 문의</td>
          <td>2022.03.08</td>
        </tr>
        <tr>
          <td>해운대 리조트 8월 예약 문의</td>
          <td>2022.03.08</td>
        </tr>
      </table>
      <div class="hr"></div>
    </div>

    <div class="box half">
      <div class="title">정보나눔</div>
      <a href="#"><img src="images/partner/info.png"></a>
    </div>

    <div class="box half">
      <div class="title">링크</div>
      <div class="links">
        <a href="#">
          <img src="images/icons/new.png">
          <span>새소식</span>
        </a>
        <a href="#">
          <img src="images/icons/manual.png">
          <span>여행매뉴얼</span>
        </a>
        <a href="#">
          <img src="images/icons/music.png">
          <span>여행음악</span>
        </a>
      </div>
    </div>

    <div class="box half" style="height:320px">
      <div class="title">인터뷰</div>
      <iframe style="width:100%;height:100%"
      src="https://www.youtube.com/embed/Ug_6r6bndIo" title="YouTube video player" 
      frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>

    <div class="box half" style="height:320px">
      <div class="title">오시는길</div>
      
        <div style="width: 100%;" id="daumRoughmapContainer1646977929522" class="root_daum_roughmap root_daum_roughmap_landing">
          <script charset="UTF-8" class="daum_roughmap_loader_script" 
          src="https://ssl.daumcdn.net/dmaps/map_js_init/roughmapLoader.js"></script>
          
          <script charset="UTF-8">
            new daum.roughmap.Lander({
              "timestamp" : "1646977929522",
              "key" : "29fh7",
              // "mapWidth" : "640",
              // "mapHeight" : "360"
            }).render();
          </script>
        </div>

    </div>

  </div>
  
  <div id="footer">
    <div class="left">
      <span><a href="#">이용약관</a> | <a href="#">개인정보 보호</a></span>
    </div>
    <div class="right">
      <span>
        (주) 여행을 사랑하는 사람들<br>
        주소: 부산광역시 해운대구 우동 정릉빌딩 504<br>
        대표자: 홍길동 | 개인정보책임자: 유관순<br>
        고객센터: 1588-9000
      </span>
    </div>
  </div>

</div>
</body>
</html>