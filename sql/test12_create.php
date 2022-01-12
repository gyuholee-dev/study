<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

// $reply = $_REQUEST['reply'];
if (isset($_REQUEST['reply']) && $_REQUEST['reply'] == 'y') {
    $sql = 'DROP TABLE IF EXISTS sale';
    mysqli_query($db, $sql);

    $sql = "CREATE TABLE sale
            (
              numb INT AUTO_INCREMENT,
              date CHAR(10),
              item CHAR(40),
              prce INT,
              qntt INT,
              supp CHAR(4),
              PRIMARY KEY(numb)
            )";
    mysqli_query($db, $sql);

    $msg = '테이블 생성 완료';
    $pgm = 'test12.php';
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
<h3>판매 자료 관리</h3>
<hr>
<br>
<span class="red">테이블을 생성하시겠습니까?</span><br><br>
<input type="button" value="Yes"
    onclick="location.href='test12_create.php?reply=y'">
<input type="button" value="No"
    onclick="location.href='test12.php'">

</body>
</html>