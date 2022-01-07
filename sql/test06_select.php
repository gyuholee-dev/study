<?php
// ini_set('display_errors', 0);
include 'include/head.inc';
// mysqli_report(MYSQLI_REPORT_OFF);

$sql = "SELECT * FROM carr";

if (isset($_POST['code'])) {
    $code = $_POST['code'];
} else {
    $code = 'D';
}
if ($code == 'D') {
    $sql = $sql.' ORDER BY date DESC';
} elseif ($code == 'C') {
    $sql = $sql.' ORDER BY cont ASC';
}
// echo $sql;
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
<h3>차계부 조회</h3>
<hr>
<br><br>

<table cellpadding=3 cellspacing=0 border=1>
    <form method='post' action="test06_select.php">
    <tr>
        <td colspan=5>조회 구분 :
            <?php
                if ($code == 'D') {
                    echo '<input type="radio" name="code" value="D" checked> 일자 역순';
                    echo '<input type="radio" name="code" value="C"> 내역순';
                } elseif ($code == 'C') {
                    echo '<input type="radio" name="code" value="D"> 일자 역순';
                    echo '<input type="radio" name="code" value="C" checked> 내역순';
                }
            ?>
            <input type="submit" value="조회">
            <input type="button" value="메뉴" onclick='location.href="test06.php"'>
        </td>
    </tr>
    </form>

    <tr>
        <th width=90 bgcolor='lightblue'>발생일자</th>
        <th width=150 bgcolor='lightblue'>발생내역</th>
        <th width=90 bgcolor='lightblue'>비용</th>
        <th width=120 bgcolor='lightblue'>발생장소</th>
        <th width=70 bgcolor='lightblue'>구분</th>
    </tr>
<?php
$dateSaved = array();
$savedNum = 0;
$savedDate = '';
$rowCount = 1;

while ($a = mysqli_fetch_array($res)) {
    if ($savedDate != $a[1]) {
        $savedNum = $a[0];
        $savedDate = $a[1];
        $rowCount = 1;
        $dateSaved[$savedNum] = $rowCount;
    } else {
        $rowCount++;
        $dateSaved[$savedNum] = $rowCount;
    }
}

// print_r($dateSaved);

$res = mysqli_query($db, $sql);
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
    // echo '<td align="center">'.$a[0].'</td>';
    if ($savedDate != $a[1]) {
        // echo '<td align="center">'.$a[1].'</td>';
        echo '<td align="center" rowspan="'.$dateSaved[$a[0]].'">'.$a[1].'</td>';
        $savedDate = $a[1];
        $rowCount = 1;
    } else {
        $rowCount++;
        // echo '<td align="center">'.$rowCount.'</td>';
    } 
    echo '<td align="left">'.$a[2].'</td>';
    echo '<td align="right">'.$cost.'</td>';
    echo '<td align="left">'.$a[4].'</td>';
    echo '<td align="center">'.$kind.'</td>';
    echo '</tr>';
}


?>

</table>