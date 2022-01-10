<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

$kind = 1;
$sql = 'SELECT * FROM code';
if (isset($_POST['inqr'])) {
    $kind = $_POST['kind'];
    if ($kind == '1') {
        $sql = 'SELECT * FROM code';
    } elseif ($kind == '2') {
        $sql = $sql." WHERE cod1 = '11'";
    } elseif ($kind == '3') {
        $sql = $sql." WHERE cod1 = '12'";
    } elseif ($kind == '4') {
        $sql = $sql." WHERE cod1 = '13'";
    }
}
$res = mysqli_query($db, $sql);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>코드 자료 조회</h3>
<hr>
<br>

<form name="select" method="post" action="test08_select.php">
<table cellpadding="3" cellspacing="0" border="1">
    <tr>
        <td colspan="4" align="center">조회구분
            <?php
                $checked = array('','','','');
                $checked[$kind-1] = 'checked';
            ?>
            <input type="radio" name="kind" value="1" <?=$checked[0]?>>전체
            <input type="radio" name="kind" value="2" <?=$checked[1]?>>직위
            <input type="radio" name="kind" value="3" <?=$checked[2]?>>단위
            <input type="radio" name="kind" value="4" <?=$checked[3]?>>지역&nbsp;&nbsp;
            <input type="submit" name="inqr" value="조회">&nbsp;
            <!-- <input type="button" value="메뉴"
                onclick="location.href='test08.php'"> -->
        </td>
    </tr>
    <tr>
        <th width="80" bgcolor="lightblue">코드-1</th>
        <th width="80" bgcolor="lightblue">코드-2</th>
        <th width="160" bgcolor="lightblue">코드내역</th>
        <th width="80" bgcolor="lightblue">사용여부</th>
    </tr>
<?php
    $sav = '';
    while ($a = mysqli_fetch_array($res)) {
        if ($a[3] == 'Y') {
            $tmp = '사용중';
        } elseif ($a[3] == 'N') {
            $tmp = '미사용';
        }

        echo '<tr>';
        if ($a[0] == $sav) {
            echo '<td align="center"></td>';
        } else {
            echo '<td align="center">'.$a[0].'</td>';
            $sav = $a[0];
        }
        echo '<td align="center">'.$a[1].'</td>';
        echo '<td align="center">'.$a[2].'</td>';
        echo '<td align="center">'.$tmp.'</td>';
        echo '</tr>';
    }
?>
    <tr>
        <td colspan="4">
        <input type="button" value="메뉴"
            onclick="location.href='test08.php'">
        </td>
    </tr>
</table>
</form>
</body>
</html>