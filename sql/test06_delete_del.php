<?php
ini_set('display_errors', 0);
include 'include/head.inc';
// mysqli_report(MYSQLI_REPORT_OFF);

$numb = $_REQUEST['numb'];
$reply = $_REQUEST['reply'];

// echo "numb = $numb ";
// echo "reply = $reply ";

if ($reply == 'y') {
    $sql = "DELETE FROM carr WHERE numb = '$numb'";
    mysqli_query($db, $sql);

    $msg = '레코드 삭제 완료';
    $pgm = 'test06_delete.php';
    include 'include/sendmsg.inc';
}
?>

<!DOCTYPE html>
<html lang='ko'>
<head>
    <style>
        th, td {
            padding: 3px 10px;
        }
    </style>
</head>
<center>
<font face='맑은 고딕'>
<h3>차계부 자료 삭제</h3>
<hr>
<br><br>

레코드를 삭제하겠습니까?
<input type="button" value="Yes" 
    onclick='location.href="test06_delete_del.php?reply=y&numb=<?=$numb?>"'>
<input type="button" value="No" 
    onclick='location.href="test06_delete.php"'>