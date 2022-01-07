<?php
// ini_set('display_errors', 0);
include 'include/head.inc';
// mysqli_report(MYSQLI_REPORT_OFF);

$sql = "SELECT * FROM carr ORDER BY date DESC";
$res = mysqli_query($db, $sql);
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
<h3>차계부 수정</h3>
<hr>
<br><br>

<table cellpadding=3 cellspacing=0 border=1>
    <tr>
        <td colspan=7 align="center">
            <input type="button" value="메뉴" onclick="location.href='test06.php'">
        </td>
    </tr>

    <tr>
        <th width=50 bgcolor="lightblue">번호</th>
        <th width=90 bgcolor="lightblue">발생일자</th>
        <th width=150 bgcolor="lightblue">발생내역</th>
        <th width=90 bgcolor="lightblue">비용</th>
        <th width=120 bgcolor="lightblue">발생장소</th>
        <th width=70 bgcolor="lightblue">구분</th>
        <th width=70 bgcolor="lightblue">수정</th>
    </tr>
<?php
    $num = 0;
    $savedDate = '';
    while ($a = mysqli_fetch_array($res)) {
        $cost = number_format($a[3]);
        if ($a[5] == 'R') {
            $kind = '수리교체';
        } elseif ($a[5] == 'T') {
            $kind = '도로비등';
        } elseif ($a[5] == 'I') {
            $kind = '보험배상';
        }
        
        echo '<tr>';
        if ($savedDate == $a[1]) {
            echo '<td align="center"></td>';
            echo '<td align="center"></td>';
        } else {
            $num++;
            echo '<td align="center">'.$num.'</td>';
            echo '<td align="center">'.$a[1].'</td>';
            $savedDate = $a[1];
        }

        echo '<td align="left">'.$a[2].'</td>';
        echo '<td align="right">'.$cost.'</td>';
        echo '<td align="left">'.$a[4].'</td>';
        echo '<td align="center">'.$kind.'</td>';
        echo '<td align="center">';
        echo '<a href="test06_update_set.php?numb='.$a[0].'">수정</a>';
        echo '</td>';
        echo '</tr>';
    }


?>


</table>




</html>