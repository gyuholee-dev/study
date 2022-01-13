<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

if (isset($_REQUEST['reply']) && $_REQUEST['reply'] == 'y') {
    $sql = "DROP TABLE IF EXISTS asst";
    mysqli_query($db, $sql);

    $sql = "CREATE TABLE asst
            (
              numb CHAR(4) NOT NULL,
              name CHAR(50),
              dept CHAR(2),
              prce INT,
              qntt INT,
              date CHAR(10),
              PRIMARY KEY(numb)
            )";
    // echo $sql;
    
    mysqli_query($db, $sql);
    $msg = '고정자산 테이블 생성 완료';
    $pgm = 'test14.php';
    include 'include/sendmsg.inc';
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>고정자산 생성</h3>
<hr>
<br>

<span class="red"><b>고정자산 테이블을 생성하시겠습니까?</b></span>
<br><br>
<input type="button" value="Yes"
    onclick="location.href='test14_create.php?reply=y'">
<input type="button" value="No"
    onclick="location.href='test14.php'">

</body>
</html>
