<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

$sql = 'SELECT * FROM code';
$res = mysqli_query($db, $sql);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>코드 자료 수정</h3>    
<hr>
<br>

<table cellpadding="3" cellspacing="0" border="1">
    <tr>
        <td colspan="5">
        <input type="button" value="메뉴"
            onclick="location.href='test08.php'">
        </td>
    </tr>
    <tr>
        <th width="80" bgcolor="lightblue">코드-1</th>
        <th width="80" bgcolor="lightblue">코드-2</th>
        <th width="160" bgcolor="lightblue">코드내역</th>
        <th width="80" bgcolor="lightblue">사용여부</th>
        <th width="40" bgcolor="lightblue">수정</th>
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
            echo '<td></td>';
        } else {
            echo '<td>'.$a[0].'</td>';
            $sav = $a[0];
        }
        echo '<td>'.$a[1].'</td>';
        echo '<td>'.$a[2].'</td>';
        echo '<td>'.$tmp.'</td>';
        echo '<td>';
        echo '<a href="test08_update_set.php?ukey1='.$a[0].'&ukey2='.$a[1].'">수정</a>';
        echo '</td>';
        echo '</tr>';
    }
?>

</table>

</body>
</html>
</table>
