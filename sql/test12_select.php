<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

$items = 6;
$page = 1;
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}


$sql = "SELECT COUNT(*) FROM sale";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$pageCount = ceil($a[0]/$items);

$start = ($page-1) * $items;
// $sql = "SELECT * FROM supp
$sql = "SELECT a.*, b.name FROM sale a
        JOIN supp b ON a.supp = b.code
        ORDER BY a.date DESC
        LIMIT $start, $items";
$res = mysqli_query($db, $sql);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>판매 자료 조회</h3>
<hr>
<br>

<table cellpadding="3" cellspacing="0" border="1">
    <tr>
        <td colspan="6">
            <input type="button" value="메뉴" 
            onclick="location.href='test12.php'">
        </td>
    </tr>
    <tr>
        <!-- <th>순번</th> -->
        <th width="100">판매일</th>
        <th width="80">판매품목</th>
        <th width="60">단가</th>
        <th width="60">수량</th>
        <th width="80">금액</th>
        <th width="140">거래처명</th>
    </tr>
    <?php
        $sav = '';
        while ($a = mysqli_fetch_row($res)) {
            $ammt = number_format($a[3] * $a[4]).'원';
            $prce = number_format($a[3]).'원';
            echo '<tr>';

            if ($sav != $a[1]) {
                echo '<td>'.$a[1].'</td>';
                $sav = $a[1];
            } else {
                echo '<td></td>';
            }
            
            echo '<td class="left">'.$a[2].'</td>';
            echo '<td class="right">'.$prce.'</td>';
            echo '<td class="right">'.$a[4].'</td>';
            echo '<td class="right">'.$ammt.'</td>';
            echo '<td class="left">'.$a[6].'</td>';
            echo '</tr>';
        }
    ?>
    <tr>
        <td colspan="6">
        <?php
            for ($i=1; $i <= $pageCount; $i++) { 
                echo '<span class="page">';
                if ($i == $page) {
                    echo "<b>$i</b>";
                } else {
                    echo '[<a href="test12_select.php?page='.$i.'">'.$i.'</a>]';
                }
                echo '</span>';
            }
        ?>
        </td>
    </tr>
</table>

</body>
</html>
