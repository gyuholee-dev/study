<?php
// ini_set('display_errors', 0);
include 'include/head.inc';
// mysqli_report(MYSQLI_REPORT_OFF);

$code = $_GET['code'];
$items = $_GET['items'];
$page = $_GET['page'];

$sql = "SELECT * FROM supp WHERE code='$code'";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$name = $a[1];

if (isset($_GET['reply']) && $_GET['reply'] == 'y') {
    $sql = "DELETE FROM supp WHERE code='$code'";
    echo $sql;
    mysqli_query($db, $sql);
    $msg = $name.' 거래처 삭제 완료';
    $pgm = 'test10_delete.php?items='.$items.'&page='.$page;
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
<h3>거래처 삭제</h3>
<hr>
<br>
<b><span class="red"><?=$name?> 거래처를 삭제하겠습니까?</span></b>
<br><br>
    <?php
        $url1 = 'test10_delete_del.php?reply=y&code='.$code;
        $url2 = 'test10_delete.php';
        $url3 = 'items='.$items.'&'.'page='.$page;
    ?>
    <input type="button" value="Yes"
        onclick="location.href='<?=$url1.'&'.$url3?>'">
    <input type="button" value="No" 
        onclick="location.href='<?=$url2.'?'.$url3?>'">
</body>
</html>