<?php
require_once 'includes/global.php';
require_once 'includes/functions.php';

$items = 6;
$page = 1;
$month = 'all';

// $sql = "SELECT SUBSTR(date, 1, 7) FROM rent
//         GROUP BY SUBSTR(date, 1, 7) ORDER BY date DESC";
$sql = "SELECT DISTINCT(SUBSTR(date, 1, 7)) FROM rent
        ORDER BY date DESC";
$mon = mysqli_query($db, $sql);

if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}
if (isset($_REQUEST['month'])) {
    $month = $_REQUEST['month'];
}

$start = ($page-1)*$items;
// if ($page == 1) {
//     $items = $items - 1;
// } else {
//     $start = $start - 1;
// }

$sql = "SELECT COUNT(*) FROM toyy";
// if ($month != 'all') {
//     $sql = $sql." WHERE date LIKE '$month%'";
// }
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$pages = ceil($a[0]/$items);

$sql = "SELECT * FROM toyy ";
// if ($month != 'all') {
//     $sql = $sql."WHERE date LIKE '$month%' ";
// }
$sql = $sql."ORDER BY numb DESC ";
$sql = $sql.'LIMIT '.$start.', '.$items;

// echo $sql;
$toy = mysqli_query($db, $sql);

// while ($a = mysqli_fetch_row($toy)) {
//     $a = $a + 1;
// }

?>
<!-- html -->
<?php
    include 'includes/_header.php';
?>
<h3>장난감별 월간 수입 현황</h3>
<hr>

<div class="tbContents">
<div class="tbMenu">
    <script>
        function changeView() {
            var form = document.getElementById('tbmenu');
            form.submit();
        }
    </script>
    <form id="tbmenu" method="get" action="">
        <table class="inner" width="100%">
            <tr><td class="left">
                <label>대여년월
                <select name="month" style="width:auto;" onchange="changeView()">
                    <option value="all">전체</option>
                    <?php
                        while ($a = mysqli_fetch_row($mon)) {
                            echo '<option value="'.$a[0].'"';
                            if ($month == $a[0]) {
                                echo ' selected';
                            }
                            echo '>'.$a[0].'</option>';
                        }
                    ?>
                </select></label>
            </td><td class="right">
                <!-- <input type="hidden" name="page" value="<?=$page?>"> -->
                <!-- <input type="submit" name="" value="조회"> -->
                <input type="button" name="" value="메뉴" 
                    onclick="location.href='start.php'">
            </td></tr>
        </table>
    </form>

</div>
<table cellpading="3" cellspacing="1">

    <tr>
        <th>번호</th>
        <th>장난감명</th>
        <th>구입일자</th>
        <th>구입금액</th>
        <th>대여료</th>
        <th>대여횟수</th>
        <th>대여수익</th>

    </tr>
    
    <style>
        tr.red td {
            color: red;
            font-weight: bold;
        }
    </style>
    
    <?php
        $sum1 = 0; // 장난감 갯수
        $sum3 = 0; // 구입금액 합계
        $sum5 = 0; // 대여횟수 합계
        $sum6 = 0; // 대여수입 합계

        $sql = "SELECT * FROM toyy ";
        $toys = mysqli_query($db, $sql);
        while ($a = mysqli_fetch_row($toys)) {
            $sql = "SELECT COUNT(*) from rent
                    WHERE toyy = '$a[0]' ";
            if ($month != 'all') {
                $sql = $sql."AND date LIKE '$month%' ";
            }
            $res = mysqli_query($db, $sql);
            $rentCount = mysqli_fetch_row($res)[0];
            $revenue = $a[3]*$rentCount;

            $sum1 = $sum1 + 1;
            $sum3 = $sum3 + $a[5];
            $sum5 = $sum5 + $rentCount;
            $sum6 = $sum6 + $revenue; 
        }
        if ($page == 1) {
            echo '<tr class="red">';
            echo "<td>합계</td>";
            echo "<td>$sum1</td>";
            echo "<td></td>";
            echo "<td class='right'>".number_format($sum3)."원</td>";
            echo "<td></td>";
            echo "<td>$sum5</td>";
            echo "<td class='right'>".number_format($sum6)."원</td>";
            echo '</tr>';
        }
    ?>

    <?php
        while ($a = mysqli_fetch_row($toy)) {
            $rent = number_format($a[3]).'원';
            $ammt = number_format($a[5]).'원';
            $rentCount = 0;
            $revenue = 0;
            $sql = "SELECT COUNT(*) from rent
                    WHERE toyy = '$a[0]' ";
            if ($month != 'all') {
                $sql = $sql."AND date LIKE '$month%' ";
            }
            $res = mysqli_query($db, $sql);
            $rentCount = mysqli_fetch_row($res)[0];
            $revenue = number_format($a[3]*$rentCount).'원';

            echo '<tr>';
            echo "<td>$a[0]</td>";
            echo "<td>$a[1]</td>";
            echo "<td>$a[4]</td>";
            echo "<td class='right'>$ammt</td>";
            echo "<td class='right'>$rent</td>";
            echo "<td>$rentCount</td>";
            echo "<td class='right'>$revenue</td>";

            echo '</tr>';
        }

    ?>
</table>
<div class="tbMenu">
    <?php
        for ($i=1; $i<=$pages; $i++) {
            echo '<span class="page">';
            if ($i == $page) {
                echo "<b>$i</b>";
            } else {
                echo '[<a href="view_1.php?month='.$month.'&page='.$i.'">'.$i.'</a>]';
            }
            echo '</span>';
        }
    ?>
</div>
</div>


<?php
    // include $id.'includes/_menu.php';
?> 
<?php
    include 'includes/_footer.php';
?>