<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

if (isset($_REQUEST['reply'])) {
    $reply = $_REQUEST['reply'];
    if ($reply == 'y') {
        $sql = 'DROP TABLE IF EXISTS code';
        mysqli_query($db, $sql);

        $sql = 'CREATE TABLE code
                (
                  cod1 CHAR(2) NOT NULL,
                  cod2 CHAR(2) NOT NULL,
                  name CHAR(60),
                  used CHAR(1),
                  PRIMARY KEY (cod1, cod2)
                )';
        mysqli_query($db, $sql);

        $msg = '코드 테이블 생성 완료';
        $pgm = 'test08.php';
        include 'include/sendmsg.inc';
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<font face="맑은 고딕">
<center>
<h3>코드 테이블 생성</h3>
<hr>
<br><br>

코드 테이블을 새로 생성하겠습니까?
<input type="button" value="Yes"
    onclick="location.href='test08_create.php?reply=y'">
<input type="button" value="No"
    onclick="location.href='test08.php'">

</body>
</html>
