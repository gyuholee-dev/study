<?php
require 'include/global.php';

$items = 5;
$page = 1;
$pages = 10;
$start = 0;
$sort = 'numb';
$order = 'desc';

if (isset($_REQUEST['items'])) {
    $items = $_REQUEST['items'];
}
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}

$sql = "SELECT COUNT(*) FROM empl";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$pages = ceil($a[0]/$items);
$start = ($page-1)*$items;

// echo '$items: '.$items.'<br>';
// echo '$page: '.$page.'<br>';
// echo '$pages: '.$pages.'<br>';
// echo '$start: '.$start.'<br>';

$deptList = getAllRecords('dept');
// $gradList = getAllRecords('code', false);
$gradList = array();
$sql = "SELECT cod2, name FROM code WHERE cod1 = '11'";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_row($res)) {
    foreach ($a as $key => $value) {
        $gradList[$a[0]] = $a[1];
    }
}

// $sql = "SELECT * FROM empl 
//         ORDER BY numb DESC 
//         LIMIT $start, $items";
$sql = "SELECT empl.*, dept.name AS dept_name, code.name AS grad_name FROM empl
        JOIN dept ON empl.dept = dept.code
        JOIN code ON empl.grad = code.cod2 AND code.cod1 = '11'";

$sortSql = ' ORDER BY numb';
if (isset($_REQUEST['sort'])) {
    $sort = $_REQUEST['sort'];
    $sortSql = ' ORDER BY empl.'.$_REQUEST['sort'];
}
$orderSql = ' DESC';
if (isset($_REQUEST['order'])) {
    $order = $_REQUEST['order'];
    if ($_REQUEST['order'] == 'asc') {
        $orderSql = ' ASC';
    } elseif ($_REQUEST['order'] == 'desc') {
        $orderSql = ' DESC';
    }
}
$limitSql = " LIMIT $start, $items";

$sql = $sql.$sortSql.$orderSql.$limitSql;
$res = mysqli_query($db, $sql);


?>
<!-- html -->
<?php
    include 'test18_header.php';
?>
<h3>인사명부 조회</h3>
<hr>

<div class="tbContents">
    <div class="tbMenu">
        <table class="inner" width="100%">
        <tr><td class="left">
        <form method="get" action="test18_select.php">
            <label>항목수 <input type="number" max=99 name="items" value="<?=$items?>"
            style="width: 40px;" autofocus></label>
            <label>정렬 <select name="sort" style="width: 100px;">
                <?php
                    $sortOp = array('numb'=>'','name'=>'','gend'=>'','dept'=>'','grad'=>'','entr'=>'','phon'=>'','bord'=>'');
                    $sortOp[$sort] = 'selected';
                ?>
                <option value="numb" <?=$sortOp['numb']?>>사번</option>
                <option value="name" <?=$sortOp['name']?>>성명</option>
                <option value="gend" <?=$sortOp['gend']?>>성별</option>
                <option value="dept" <?=$sortOp['dept']?>>소속</option>
                <option value="grad" <?=$sortOp['grad']?>>직위</option>
                <option value="entr" <?=$sortOp['entr']?>>입사일</option>
                <option value="phon" <?=$sortOp['phon']?>>연락처</option>
                <option value="bord" <?=$sortOp['bord']?>>재직여부</option>
            </select></label>
            <?php
                $orderOp = array('asc'=>'', 'desc'=>'');
                $orderOp[$order] = 'checked';
            ?>
            <label><input type="radio" name="order" value="asc" <?=$orderOp['asc']?>>정</label>
            <label><input type="radio" name="order" value="desc" <?=$orderOp['desc']?>>역</label>
            <input type="hidden" name="page" value="<?=$page?>">
            <input type="submit" value="입력">
        </form>
        </td><td class="right">
            <input type="button" value="초기화"
            onclick="location.href='test18_select.php'">
        </td></tr>
        </table>
    </div>

    <table cellpadding="3" cellspacing="0" border="1">
        <tr>
            <th width="60">사번</th>
            <th width="86">성명</th>
            <th width="60">성별</th>
            <th width="86">소속</th>
            <th width="56">직위</th>
            <th width="106">입사일</th>
            <th width="132">연락처</th>
            <th width="56">재직</th>
        </tr>
    <?php
        while ($a = mysqli_fetch_assoc($res)) {
            if ($a['gend'] == 'M') { $gend = '남자'; } 
            elseif ($a['gend'] == 'F') {  $gend = '여자'; }
            // $dept = $deptList[$a['dept']][1];
            // $grad = $gradList[$a['grad']];
            if ($a['bord'] == 'Y') { $bord = '재직'; } 
            elseif ($a['bord'] == 'N') {  $bord = '퇴사'; }

            echo '<tr>';
            echo '<td>'.$a['numb'].'</td>';
            echo '<td>'.$a['name'].'</td>';
            echo '<td>'.$gend.'</td>';
            // echo '<td>'.$dept.'</td>';
            // echo '<td>'.$grad.'</td>';
            echo '<td>'.$a['dept_name'].'</td>';
            echo '<td>'.$a['grad_name'].'</td>';
            echo '<td>'.$a['entr'].'</td>';
            echo '<td>'.$a['phon'].'</td>';
            echo '<td>'.$bord.'</td>';
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
                echo '[<a href="test18_select.php?items='.$items.'&page='.$i.
                     '&sort='.$sort.'&order='.$order.'">'.$i.'</a>]';
            }
            echo '</span>';
        }
    
    ?>
    </div>

</div>

<hr>
<?php
    include 'test18_menu.php';
?> 
<?php
    include 'test18_footer.php';
?>