<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Guide</title>
  <link rel="stylesheet" href="style.css">
  <script type="text/javascript" src="script.js"></script>
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
          <a href="login.php">LOGIN</a>
          <a href="signup.php">SIGNUP</a>
          <a href="idpw.php">ID/PW</a>
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


    <div id="content">
      
      <div class="box" style="height:auto">
        <div class="title signup">회원가입</div>

        <form method="post" name="frm1" action="signup_ok.php">
          <table class="input">
            <tr>
              <th>이름</th>
              <td><input type="text" name="name"></td>
            </tr>
            <tr>
              <th>이메일</th>
              <td>
                <input type="text" name="email1">
                <select name="email2">
                  <option value="naver.com">naver.com</option>
                  <option value="gmail.com">gmail.com</option>
                  <option value="daum.net">daum.net</option>
                </select>
              </td>
            </tr>
            <tr>
              <th>아이디</th>
              <td>
                <input type="text" name="id">
                <input type="button" class="btn" value="중복확인" onclick="checkId()">
              </td>
            </tr>
            <tr>
              <th>비밀번호</th>
              <td><input type="password" name="pw1"></td>
            </tr>
            <tr>
              <th>비밀번호 확인</th>
              <td><input type="password" name="pw2"></td>
            </tr>
            <tr>
              <th>성별</th>
              <td>
                <label><input type="radio" name="gender" value="남성" checked>남성</label>
                <label><input type="radio" name="gender" value="여성">여성</label>
              </td>
            </tr>
            <tr>
              <th>취미</th>
              <td>
                <label><input type="checkbox" name="hobby1" value="여행">여행</label>
                <label><input type="checkbox" name="hobby2" value="등산">등산</label>
                <label><input type="checkbox" name="hobby3" value="낚시">낚시</label>
                <label><input type="checkbox" name="hobby4" value="영화">영화</label>
                <label><input type="checkbox" name="hobby5" value="음악">음악</label>
              </td>
            </tr>
            <tr>
              <th>최종학력</th>
              <td>
                <select name="grade">
                  <option value="대학원졸">대학원졸</option>
                  <option value="대졸">대졸</option>
                  <option value="초대졸">초대졸</option>
                  <option value="고졸">고졸</option>
                  <option value="중졸">중졸</option>
                </select>
              </td>
            </tr>
            <tr>
              <th>남기는 말</th>
              <td><textarea name="comment" rows="10"></textarea></td>
            </tr>
          </table>

          <div class="buttons" style="text-align:center;">
            <input type="hidden" name="idcheked" value="false">
            <input type="button" class="btn" value="회원가입" onclick="send()">
            <input type="reset" class="btn" value="재작성">
          </div>

        </form>

        <div class="hr"></div>
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

  <script>
    function checkId() {
      if (frm1.id.value=='') {
        alert('아이디를 입력하세요');
        frm1.id.focus();
        return false;
      }
      window.open(
        'member_idcheck.php?id='+frm1.id.value, 
        'popup', 'width=400, height=150'
      );
    }

    function send() {
      if (frm1.name.value=='') {
        alert('이름을 입력하세요');
        frm1.name.focus();
        return false;
      }
      if (frm1.email1.value=='') {
        alert('이메일을 입력하세요');
        frm1.email1.focus();
        return false;
      }
      if (frm1.id.value=='') {
        alert('아이디를 입력하세요');
        frm1.id.focus();
        return false;
      }
      if (frm1.idcheked.value != 'true') {
        alert('아이디 중복체크를 해주세요');
        frm1.id.focus();
        return false;
      }
      if (frm1.pw1.value=='') {
        alert('비밀번호를 입력하세요');
        frm1.pw1.focus();
        return false;
      }
      if (frm1.pw2.value=='') {
        alert('비밀번호를 확인해 주세요');
        frm1.pw2.focus();
        return false;
      }
      if (frm1.pw1.value != frm1.pw2.value) {
        alert('비밀번호가 다릅니다');
        frm1.pw1.value = '';
        frm1.pw2.value = '';
        frm1.pw1.focus();
        return false;
      }
      
      document.frm1.submit();
    }
  
  </script>

</body>

</html>