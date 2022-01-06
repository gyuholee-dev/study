<?php
// ini_set('display_errors', 0);
include 'include/head.inc';
// mysqli_report(MYSQLI_REPORT_OFF);

if (isset($_REQUEST['reply'])) {
    $reply = $_REQUEST['reply'];
    if ($reply == 'y') {
        $sql = 'DROP TABLE IF EXISTS carr';
        mysqli_query($db, $sql);

        $sql = 'CREATE TABLE carr
                (
                  numb INT AUTO_INCREMENT,
                  date CHAR(10),
                  cont CHAR(60),
                  cost INT,
                  plce CHAR(30),
                  kind CHAR(1),
                  PRIMARY KEY(numb)
                )';
        mysqli_query($db, $sql);


        $msg = '테이블 생성 완료';
        $pgm = 'test06.php';
        include 'include/sendmsg.inc';
    }
}

?>

<!DOCTYPE html>
<html lang='ko'>
<center>
<font face='맑은 고딕'>
<h3>차계부 테이블 생성</h3>
<hr>
<br><br>

테이블을 새로 생성하시겠습니까? 
<input type='button' value='Yes'
    onclick=location.href="test06_create.php?reply=y">
<input type='button' value='No'
    onclick=location.href="test06.php">

</html>