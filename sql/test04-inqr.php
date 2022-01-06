<?php
// ini_set('display_errors', 0);
include 'include/head.inc';
// mysqli_report(MYSQLI_REPORT_OFF);
$sql = 'SELECT * FROM toyy';
$res = mysqli_query($db, $sql);

?>

<!DOCTYPE html>
<html lang='ko'>

<center>
<font face='맑은 고딕'>
<h3>장난감 자료 조회</h3>
<hr>
<br>

<input type="button" value='메뉴' onclick='location.href="test04.php"'>
<br><br>

<table cellpadding=3 cellspacing=0 border=1>
    <tr>
        <th width=70 bgcolor='lightblue'>번호</th>
        <th width=130 bgcolor='lightblue'>장난감명</th>
        <th width=90 bgcolor='lightblue'>단가</th>
        <th width=90 bgcolor='lightblue'>수량</th>
        <th width=70 bgcolor='lightblue'>상태</th>
        <th width=70 bgcolor='lightblue'>구분</th>
    </tr>

<?php
    while ($a = mysqli_fetch_array($res)) {
        $dan = number_format($a[2]).' 원';
        $soo = number_format($a[3]).' 개';
        if ($a[5]=='T') {
            $knd = '오락용';
        } elseif ($a[5]=='E') {
            $knd = '교육용';
        }

        echo '<tr>';
        echo '<td align="center">'.$a[0].'</td>';
        echo '<td align="left">'.$a[1].'</td>';
        echo '<td align="right">'.$dan.'</td>';
        echo '<td align="right">'.$soo.'</td>';
        echo '<td align="center">'.$a[4].'</td>';
        echo '<td align="center">'.$knd.'</td>';
        echo '</tr>';
    }
?>


</table>


</html>