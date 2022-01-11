<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

if (isset($_POST['create'])) {
    $sql = 'DROP TABLE IF EXISTS supp';
    mysqli_query($db, $sql);

    $sql = 'CREATE TABLE supp
            (
              code CHAR(4) NOT NULL,
              name CHAR(40),
              numb CHAR(12),
              repr CHAR(20),
              type CHAR(40),
              prod CHAR(40),
              phon CHAR(13),
              PRIMARY KEY(code)
            )';
    // echo $sql;
    mysqli_query($db, $sql);

    $msg = '거래처 테이블 생성 완료';
    $pgm = 'test10.php';
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
<h3>테이블 생성</h3>
<hr>
<br>
거래처 테이블을 생성하겠습니까? <br><br>
<form method="post" action="test10_create.php">
    <input type="submit" value="예" name="create">
    <input type="button" value="아니오"
        onclick="location.href='test10.php'">
</form>

</body>
</html>