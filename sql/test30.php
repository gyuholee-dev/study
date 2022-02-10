<?php
include 'include/head.inc';
ini_set('display_errors', 0);

/*
CREATE TABLE counter 
(
  today CHAR(10) NOT NULL,
  prest INT,
  accum INT,
  PRIMARY KEY(today)
);
*/

$today = DATE('Y-m-d');

if ($_COOKIE['cooktest'] != '1') {
  setcookie('cooktest', '1', time()+1, '/');
  // counter 테이블 읽는다
  $sql = "SELECT * FROM counter";
  $res = mysqli_query($db, $sql);
  $a = mysqli_fetch_row($res);
  
  //날짜가 같으면 금일+1, 누적+1
  //날짜가 틀리면 update 날짜, 1, 누적+1
  if ($a[0] == $today) { 
    $sql = "UPDATE counter 
            SET prest = prest+1,
                accum = accum+1
            ";
  } else { 
    $sql = "UPDATE counter 
            SET today = '$today',
                prest = 1,
                accum = accum+1
            ";
  }
  mysqli_query($db, $sql);

}

// counter 테이블 읽어서 당일, 누적 숫자 출력
$sql = "SELECT * from counter";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_assoc($res);

?>
<html lang="ko">
<head>
  <style>
    #output {
      border: 1px solid #00d8ff;
      text-align: center;
      width: 150px;
    }
    #output div {
      height: 25px;
    }
    #output .head {
      background: #00d8ff;
    }
  </style>
</head>
<body>
  <div id="output">
    <div class="head">금일/누적 방문자</div>
    <div><?=$a['prest']?> / <?=$a['accum']?></div>
  </div>

</body>
</html>