<?php
// ------------------- //
// -- 작성자: 이규호 -- //
// ------------------- //

// 1번문제
echo "<b>1. (100 ~ 200) 사이의 모든 정수들의 합계값을 출력</b><br>";
$start = 100;
$end = 200;
$result = 0;
for ($i=$start; $i <= $end; $i++) { 
  $result += $i;
}
echo "합계: $result";
echo "<br><br>";

// 2번문제
echo "<b>2. (10 ~ 100) 사이에 있는 4의 배수의 합계를 출력</b><br>";
$start = 10;
$end = 100;
$result = 0;
for ($i=$start; $i <= $end; $i++) { 
  if ($i%4 == 0) {
    $result += $i; 
  }
}
echo "합계: $result";
echo "<br><br>";

// 3번문제
echo "<b>3. (1 ~ 1000) 사이의 5의 배수 카운트 및 합계 출력</b><br>";
$start = 1;
$end = 1000;
$count = 0;
$result = 0;
for ($i=$start; $i <= $end; $i++) { 
  if ($i%5 == 0) {
    $count++;
    $result += $i; 
  }
}
echo "카운트: $count 합계: $result";
echo "<br><br>";

// 4번문제
echo "<b>4. 구구단 2~9 단 중에서 3의 배수가 되는 구구단만 출력</b><br>";
$start = 2;
$end = 9;
for ($i=$start; $i <= $end; $i++) { 
  if ($i%3 == 0) {
    echo "구구단 $i 단<br>";
    for ($n=1; $n<=9; $n++) { 
      $res = $i * $n;
      echo "$i X $n = $res";
      echo "<br>";
    }
  }
}
echo "<br>";

// -------------------------------------------------------------------
// DB
$host = "localhost";
$user = "root";
$pass = "";
$db = mysqli_connect($host, $user, $pass);
mysqli_select_db($db, "mydb");

// 테이블 드랍
$sql = "DROP TABLE IF EXISTS asst";
mysqli_query($db, $sql);


// 5번문제
echo "<b>5. 테이블 생성 프로그램 작성</b></br>";
$sql = "CREATE TABLE asst (
          numb CHAR(3) NOT NULL,
          name CHAR(10),
          prce INT,
          qnty INT,
          PRIMARY KEY (numb)
        )";
mysqli_query($db, $sql);
echo $sql;
echo "<br><br>";

// 6번문제
echo "<b>6. 데이터 3건 입력</b></br>";
$sql = "INSERT INTO asst 
        VALUES('111', '에어컨', '500000', '2')";
mysqli_query($db, $sql);
echo "$sql<br>";
$sql = "INSERT INTO asst 
        VALUES('112', '컴퓨터', '300000', '5')";
mysqli_query($db, $sql);
echo "$sql<br>";
$sql = "INSERT INTO asst 
        VALUES('113', '모니터', '100000', '5')";

mysqli_query($db, $sql);
echo "$sql<br>";
echo "<br>";

// 7번문제
echo "<b>7. 입력한 데이터 중에서 품번이 112 인 레코드의 단가를 350000 으로 수정</b></br>";
$sql = "UPDATE asst 
        SET prce = '350000'
        WHERE numb = '112' ";
mysqli_query($db, $sql);
echo "$sql<br>";
echo "<br>";

// 8번문제
echo "<b>8. 테이블 내의 모든 데이터를 아래와 같이 출력</br>
     품번(111) 품명(에어컨) 단가(500,000) 수량(2)</b><br>";
$sql = "SELECT * FROM asst";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_array($res)) {
  $a[2] = number_format($a[2]);
  echo "품번($a[0]) 품명($a[1]) 단가($a[2]) 수량($a[3])<br>";
}
echo "<br>";

// 9번문제
echo "<b>9. 다음 변수에서 문자열 'HTML' 을 찾아서 'HTML5' 로 바꿔 출력</b></br>";
$str ="HTML&PHP&HTML&PERL";
// $result = str_replace('HTML', 'HTML5', $str);
$search = 'HTML';
$replace = 'HTML5';
$result = '';
$len = strlen($str);
$slen = strlen($search);
for ($i=0; $i < $len;) {
  $t = substr($str, $i, $slen);
  if ($t == $search) {
    $result .= $replace;
    $i += $slen;
  } else {
    $result .= substr($str, $i, 1);
    $i++;
  }
}
echo "문자열: $str <br>";
echo "결과: $result <br>";
echo "<br>";

// 10번문제
echo "<b>10. 다음 변수에서 문자열 'PHP' 가 몇개 있는지 찾아서 출력</b></br>";
$str ="PHP^PNP^PHP^PPP^";
// $count = substr_count($str, 'PHP');
$search = 'PHP';
$count = 0;
$len = strlen($str);
$slen = strlen($search);
for ($i=0; $i < $len; $i++) {
  $t = substr($str, $i, $slen);
  if ($t == $search) {
      $count += 1;
  }
}
echo "문자열: $str <br>";
echo "결과: $count 개<br>";
