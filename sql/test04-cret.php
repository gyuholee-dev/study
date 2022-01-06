<?php
// ini_set('display_errors', 0);
include 'include/head.inc';
?>

<!DOCTYPE html>
<html lang='ko'>
<center>
<font face='맑은 고딕'>
<h3>장난감 자료 삭제</h3>
<hr>
<br><br>

<?php
if (isset($_REQUEST['reply'])) {
    $reply = $_REQUEST['reply'];
    if ($reply == 'y') {
        $sql = 'DROP TABLE IF EXISTS toyy';
        mysqli_query($db, $sql);
        
        $sql = 'CREATE TABLE toyy
                (
                    numb CHAR(4) NOT NULL,
                    name CHAR(60),
                    prce INT,
                    qntt INT,
                    stat CHAR(6),
                    kind CHAR(1),
                    PRIMARY KEY(numb)
                )';
        mysqli_query($db, $sql);
        // echo 'toyy 테이블 생성 완료 <br>';
        $msg = '테이블 생성 완료';
        $pgm = 'test04.php';
        include 'include/sendmsg.inc';
    }
} else {
    echo '테이블을 새로 생성하겠습니까?';
    echo ' ';
    echo '<input type="button" value="Yes" 
        onclick=location.href="test04-cret.php?reply=y">';
    echo ' ';
    echo '<input type="button" value="No" 
        onclick=location.href="test04.php">';
}
?>

</html>