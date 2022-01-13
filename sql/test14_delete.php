<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

$page = 1;
$items = 7;
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}
if (isset($_REQUEST['items'])) {
    $items = $_REQUEST['items'];
}

$sql = 'SELECT COUNT(*) FROM asst';
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);

$pageCount = ceil($a[0]/$items);
$start = ($page-1) * $items;

// echo '$page: '.$page.'<br>';
// echo '$items: '.$items.'<br>';
// echo '$pageCount: '.$pageCount.'<br>';

$deptList = array();
$sql = "SELECT * FROM dept";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_row($res)) {
    $deptList[$a[0]] = $a[1];
}

$sql = "SELECT * FROM asst
        ORDER BY numb DESC
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
<h3>고정자산 삭제</h3>
<hr>

<table cellpadding="3" cellspacing="0" border="1">
    <tr>
        <td colspan="8">
            <table class="inner" width="100%">
            <tr><td class="left">
            <form method="get" action="test14_delete.php">
                항목수 <input type="number" max=99 name="items" value="<?=$items?>"
                style="width: 40px;">
                <input type="hidden" name="page" value="<?=$page?>">
                <input type="submit" value="입력">
            </form>
            </td><td class="right">
                <input type="button" value="메뉴"
                onclick="location.href='test14.php'">
            </td></tr>
            </table>
        </td>
    </tr>
    <tr>
        <th width="86">자산번호</th>
        <th width="120">자산명</th>
        <th width="86">자산위치</th>
        <th width="100">단가</th>
        <th width="60">수량</th>
        <th width="120">구입금액</th>
        <th width="106">구입일자</th>
        <th width="60">삭제</th>
    </tr>
    <?php
        while ($a = mysqli_fetch_row($res)) {
            $prce = number_format($a[3]).'원';
            $ammt = number_format($a[3] * $a[4]).'원';
            echo '<tr>';
            echo '<td>'.$a[0].'</td>';
            echo '<td>'.$a[1].'</td>';
            echo '<td>'.$deptList[$a[2]].'</td>';
            echo '<td class="right">'.$prce.'</td>';
            echo '<td class="right">'.$a[4].'</td>';
            echo '<td class="right">'.$ammt.'</td>';
            echo '<td>'.$a[5].'</td>';
            echo '<td>'.'<a href="test14_delete_del.php?numb='.$a[0].'&items='.$items.'&page='.$page.'">삭제</a>'.'</td>';
            echo '</tr>';
        }
    ?>
    <tr>
        <td colspan="8">
        <?php
            for ($i=1; $i <= $pageCount; $i++) {
                echo '<span class="page">';
                if ($i == $page) {
                    echo '<b>'.$i.'</b>';
                } else {
                    echo '[<a href="test14_delete.php?items='.$items.'&page='.$i.'">'.$i.'</a>]';
                }
                echo '</span>';
            }
        ?>
        </td>
    </tr>
</table>

<br> 
<hr><br>
<?php
    include 'test14_menu.html';
?> 

</body>
</html>