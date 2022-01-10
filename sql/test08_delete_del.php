<?php
ini_set('display_errors', 0);
include 'include/head.inc';

$dkey1 = $_REQUEST['dkey1'];
$dkey2 = $_REQUEST['dkey2'];
$reply = $_REQUEST['reply'];

if (isset($reply) && $reply == 'y') {
    $sql = 'DELETE FROM code';
    $sql = $sql." WHERE cod1='$dkey1' and cod2='$dkey2'";
    // echo $sql;
    mysqli_query($db, $sql);

    $msg = '코드 자료 삭제 완료';
    $pgm = 'test08_delete.php';
    include 'include/sendmsg.inc';
}

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>코드 자료 삭제</h3>    
<hr>
<br><br>
코드 자료를 삭제하겠습니까?
<input type="button" value="Yes"
    onclick="location.href='test08_delete_del.php?reply=y&dkey1=<?=$dkey1?>&dkey2=<?=$dkey2?>'">
<input type="button" value="No"
    onclick="location.href='test08_delete.php'">

</body>
</html>