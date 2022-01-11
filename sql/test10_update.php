<?php
// ini_set('display_errors', 0);
include 'include/head.inc';
// mysqli_report(MYSQLI_REPORT_OFF);

$items = 5;
$page = 1;
if (isset($_GET['items'])) {
    $items = $_GET['items'];
}
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

$sql = 'SELECT COUNT(*) FROM supp';
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$itemCount = $a[0];
$pageCount = ceil($itemCount / $items);

$sql = 'SELECT * FROM supp LIMIT '.($page-1)*$items.', '.$items;
$res = mysqli_query($db, $sql);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>거래처 수정</h3>
<hr>
<br>
<?php
// echo "items: $items";
// echo '<br>';
// echo "page: $page";
// echo '<br>';
// echo "itemCount: $itemCount";
// echo '<br>';
// echo "pageCount: $pageCount";
// echo '<br>';
// echo $sql;
// echo '<br>';
?>

<table cellpadding="3" cellspacing="0" border="1">
    <tr>
        <td colspan="6" style="padding: 8px;">
            <table class="inner" width="100%" border="0">
                <form method="get" action="test10_update.php">
                    <tr><td class="left">
                    항목수
                    <input type="number" name="items" value="<?=$items?>" style="width: 35px;" max="99">
                    <input type="hidden" name="page" value="<?=$page?>">
                    <input type="submit" value="입력">
                    </td><td class="right">
                    <input type="button" value="메뉴"
                    onclick="location.href='test10.php'">
                </td></tr>
                </form>
            </table>
        </td>
    </tr>
    <tr>
        <th width="60">코드</th>
        <th width="120">거래처명</th>
        <th width="120">사업자No</th>
        <th width="80">대표자</th>
        <!-- <th width="80">업태</th> -->
        <!-- <th width="180">종목</th> -->
        <th width="150">전화번호</th>
        <th width="60">수정</th>
    </tr>
    <?php
        while ($a = mysqli_fetch_row($res)) {
            echo '<tr>';
            echo '<td>'.$a[0].'</td>';
            echo '<td>'.$a[1].'</td>';
            echo '<td>'.$a[2].'</td>';
            echo '<td>'.$a[3].'</td>';
            // echo '<td>'.$a[4].'</td>';
            // echo '<td>'.$a[5].'</td>';
            echo '<td>'.$a[6].'</td>';
            // echo '<td>'.'수정'.'</td>';
            echo '<td><a href="test10_update_set.php?code='.$a[0].'&items='.$items.'&page='.$page.'">수정</td>';
            echo '</tr>';
        }
    ?>
    <tr>
        <td colspan="6" style="padding: 8px;">
        <?php
            $i = 1;
            while ($i < $pageCount+1) {
                echo '<span class="page">';
                if ($i == $page) {
                    echo "<b>$page</b>";
                } else {
                    echo '[<a href="test10_update.php?items='.$items.'&page='.$i.'">'.$i.'</a>]';
                }
                echo '</span>';
                $i++;
            }
        ?>
        </td>
    </tr>
</table>


</body>
</html>