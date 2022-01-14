<?php
require 'include/global.php';

$items = 7;
$page = 1;
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}
if (isset($_REQUEST['items'])) {
    $items = $_REQUEST['items'];
}

$cnt = getCountRecords('ordr');
$pages = ceil($cnt/$items);

$start = ($page-1)*$items;
$sql = "SELECT * FROM ordr
        ORDER BY numb DESC
        LIMIT $start, $items";
$res = mysqli_query($db, $sql);

$deptList = getAllRecords('dept');

?>
<!-- html -->
<?php
    include 'test16_header.html';
?>
<h3>주문요구서 조회</h3>
<hr>

<div class="tbContents">

    <div class="tbMenu">
        <table class="inner" width="100%">
        <tr><td class="left">
        <form method="get" action="test16_select.php">
            <label>항목수 <input type="number" max=99 name="items" value="<?=$items?>"
            style="width: 40px;" autofocus></label>
            <input type="hidden" name="page" value="<?=$page?>">
            <input type="submit" value="입력">
        </form>
        </td><td class="right">
            <input type="button" value="메뉴"
            onclick="location.href='test16_select.php'">
        </td></tr>
        </table>
    </div>

    <table cellpadding="3" cellspacing="0" border="1" align="center">
        <tr>
            <th width="60">순번</th>
            <th width="140">물품명</th>
            <th width="70">종류</th>
            <th width="120">요청일자</th>
            <th width="95">단가</th>
            <th width="53">수량</th>
            <th width="115">금액</th>
            <th width="70">부서</th>
            <th width="70">상태</th>
        </tr>
        <tr>
    <?php
        while ($a = mysqli_fetch_assoc($res)) {
            if ($a['kind']=='S') {
                $kind = '소모품';
            } elseif ($a['kind']=='B') {
                $kind = '비품';
            }
            if ($a['stat']=='R') {
                $stat = '요청중';
            } elseif ($a['stat']=='O') {
                $stat = '주문중';
            }
            
            $prce = number_format($a['prce']).'원';
            $ammt = number_format($a['prce']*$a['qntt']).'원';
            $dept = $deptList[$a['dept']][1];
            
            echo '<tr>';
            echo '<td>'.$a['numb'].'</td>';
            echo '<td>'.$a['item'].'</td>';
            echo '<td>'.$kind.'</td>';
            echo '<td>'.$a['date'].'</td>';
            echo '<td class="right">'.$prce.'</td>';
            echo '<td class="right">'.$a['qntt'].'</td>';
            echo '<td class="right">'.$ammt.'</td>';
            echo '<td>'.$dept.'</td>';
            echo '<td>'.$stat.'</td>';
            echo '</tr>';
        }
    ?>
        </tr>
    </table>

    <div class="tbMenu">
    <?php
        for ($i=1; $i <= $pages; $i++) {
            echo '<span class="page">'; 
            if ($i == $page) {
                echo '<b>'.$i.'</b>';
            } else {
                echo '[<a href="test16_select.php'.
                     '?items='.$items.'&page='.$i.
                     '">'.$i.'</a>]';
            }
            echo '</span>';
        }
    ?>
    </div>

</div>

<hr>
<?php
    include 'test16_menu.html';
?> 
<?php
    include 'test16_footer.html';
?>