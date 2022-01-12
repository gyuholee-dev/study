<?php
ini_set('display_errors', 0);
include 'include/head.inc';

$numb = $_REQUEST['numb'];
$page = $_REQUEST['page'];

// echo '$numb: '.$numb.'<br>';
// echo '$page: '.$page.'<br>';

if (isset($_REQUEST['reply'])) {
    $sql = "DELETE FROM sale
            WHERE numb = '$numb'";
    // echo '$sql: '.$sql;
    mysqli_query($db, $sql);
    $msg = '자료 삭제 완료';
    $pgm = "test12_delete.php?page=$page";
    include 'include/sendmsg.inc';
} else {
    $sql = "SELECT a.*, b.name FROM sale a
            JOIN supp b ON a.supp = b.code
            WHERE a.numb = '$numb'";
    $res = mysqli_query($db, $sql);
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>판매 자료 삭제</h3>
<hr>
<?php
if (!isset($_REQUEST['reply'])) {
    echo '<br>';
    echo '<table cellpadding="3" cellspacing="0" border="1">';
    echo '<tr>';
    echo '<th class="red" width="100">판매일</th>
          <th class="red" width="80">판매품목</th>
          <th class="red" width="60">단가</th>
          <th class="red" width="60">수량</th>
          <th class="red" width="80">금액</th>
          <th class="red" width="140">판매처</th>';
    echo '</tr>';
    while ($a = mysqli_fetch_row($res)) {
        $ammt = number_format($a[3] * $a[4]).'원';
        $prce = number_format($a[3]).'원';
        echo '<tr>';
        echo '<td>'.$a[1].'</td>';
        echo '<td class="left">'.$a[2].'</td>';
        echo '<td class="right">'.$prce.'</td>';
        echo '<td class="right">'.$a[4].'</td>';
        echo '<td class="right">'.$ammt.'</td>';
        echo '<td class="left">'.$a[6].'</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>
<br>
<span class="red">
    <span class="large">&#9888</span> 판매 자료를 삭제하겠습니까?
</span>
<br>
<br>
<input type="button" value="Yes" 
onclick="location.href='test12_delete_del.php?reply=y&numb=<?=$numb?>&page=<?=$page?>'">
<input type="button" value="No" 
onclick="location.href='test12_delete.php?page=<?=$page?>'">

</body>
</html>