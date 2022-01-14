<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

$items = $_REQUEST['items'];
$page = $_REQUEST['page'];
$numb = $_REQUEST['numb'];

// $sql = "SELECT * FROM asst
//         WHERE numb ='$numb'";

$sql = "SELECT a.*, b.name FROM asst a
        JOIN dept b ON a.dept = b.code
        WHERE numb = '$numb'";
$res = mysqli_query($db, $sql);

if (isset($_REQUEST['reply']) && $_REQUEST['reply'] == 'y') {
    $sql = "DELETE FROM asst
            WHERE numb = '$numb'";
    // echo $sql;
    mysqli_query($db, $sql);
    $msg = '고정자산 삭제 완료';
    $pgm = 'test14_delete.php?items='.$items.'&page='.$page;
    include 'include/sendmsg.inc';
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>고정자산 삭제</h3>
<hr>
<br>

<table cellpadding="3" cellspacing="0" border="1">
    <tr>
        <th width="86">자산번호</th>
        <th width="120">자산명</th>
        <th width="86">자산위치</th>
        <th width="100">단가</th>
        <th width="60">수량</th>
        <th width="120">구입금액</th>
        <th width="106">구입일자</th>
    </tr>
    <?php
        while ($a = mysqli_fetch_row($res)) {
            $prce = number_format($a[3]).'원';
            $ammt = number_format($a[3] * $a[4]).'원';
            echo '<tr>';
            echo '<td>'.$a[0].'</td>';
            echo '<td>'.$a[1].'</td>';
            echo '<td>'.$a[6].'</td>';
            echo '<td class="right">'.$prce.'</td>';
            echo '<td class="right">'.$a[4].'</td>';
            echo '<td class="right">'.$ammt.'</td>';
            echo '<td>'.$a[5].'</td>';
            echo '</tr>';
        }
    ?>
</table>
<br>

<span class="red"><b>자산을 삭제하겠습니까?</b></span>
<br><br>
<input type="button" value="Yes"
onclick="location.href='test14_delete_del.php?reply=y&numb=<?=$numb?>&items=<?=$items?>&page=<?=$page?>'">
<input type="button" value="No"
onclick="location.href='test14_delete.php?items=<?=$items?>&page=<?=$page?>'">


</body>
</html>