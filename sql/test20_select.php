<?php
require 'include/global.php';

$items = 10;
$page = 1;
$pages = 10;
$start = 0;
$sort = 'seqn';
$order = 'desc';
$where = '';

if (isset($_REQUEST['items'])) {
    $items = $_REQUEST['items'];
}
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}

$sql = "SELECT COUNT(*) FROM educ";
$whereSql = '';
if (isset($_REQUEST['where']) && $_REQUEST['where'] != '') {
    $where = $_REQUEST['where'];
    $whereSql = " WHERE educ = '$where'";
}
$sql = $sql.$whereSql;

$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$pages = ceil($a[0]/$items);
$start = ($page-1)*$items;

// echo '$items: '.$items.'<br>';
// echo '$page: '.$page.'<br>';
// echo '$pages: '.$pages.'<br>';
// echo '$start: '.$start.'<br>';

$deptList = getAllRecords('dept');
$gradList = array();
$educList = array();

$sql = "SELECT cod2, name FROM code WHERE cod1 = '11'";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_row($res)) {
    foreach ($a as $key => $value) {
        $gradList[$a[0]] = $a[1];
    }
}
$sql = "SELECT DISTINCT(educ) FROM educ";
$res = mysqli_query($db, $sql);
for ($i=0; $i < mysqli_num_rows($res) ; $i++) { 
    $educList[$i] = mysqli_fetch_row($res)[0];
}

// $sql = "SELECT * FROM educ 
//         ORDER BY numb DESC 
//         LIMIT $start, $items";

$sql = "SELECT educ.*, empl.name AS numb_name, code.name AS plce_name FROM educ
        JOIN empl ON educ.numb = empl.numb
        JOIN code ON educ.plce = code.cod2 AND code.cod1 = '13'";

$sortSql = ' ORDER BY seqn';
if (isset($_REQUEST['sort'])) {
    $sort = $_REQUEST['sort'];
    $sortSql = ' ORDER BY '.$_REQUEST['sort'];
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

$sql = $sql.$whereSql.$sortSql.$orderSql.$limitSql;
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
    include 'test20_header.php';
?>
<h3>교육 조회</h3>
<hr>

<div class="tbContents">
    <div class="tbMenu">
        <table class="inner" width="100%">
        <tr><td class="left">
        <form method="get" action="test20_select.php">

            <label>항목수 <input type="number" max=99 name="items" value="<?=$items?>"
            style="width: 40px;"></label>
            
            <label style="margin-left:10px;">선택 <select name="where" style="width: 160px;">
                <?php                    
                    echo '<option value="">전체</option>';
                    foreach ($educList as $key => $value) {
                        echo '<option value="'.$value.'"';
                        if ($where == $value) echo ' selected';
                        echo '>'.$value.'</option>';
                    }
                ?>
            </select></label>

            <label style="margin-left:10px;">정렬 <select name="sort" style="width: 110px;">
                <?php
                    $sortOp = array('seqn'=>'','numb_name'=>'','date'=>'','hour'=>'','educ'=>'','kind'=>'','auth'=>'','plce'=>'');
                    $sortOp[$sort] = 'selected';
                ?>
                <option value="seqn" <?=$sortOp['seqn']?>>등록순서</option>
                <option value="numb_name" <?=$sortOp['numb_name']?>>사원명</option>
                <option value="date" <?=$sortOp['date']?>>교육일자</option>
                <option value="hour" <?=$sortOp['hour']?>>교육시간</option>
                <option value="educ" <?=$sortOp['educ']?>>교육명</option>
                <option value="kind" <?=$sortOp['kind']?>>교육구분</option>
                <option value="auth" <?=$sortOp['auth']?>>시행기관</option>
                <option value="plce" <?=$sortOp['plce']?>>교육장소</option>
            </select></label>

            <?php
                $orderOp = array('asc'=>'', 'desc'=>'');
                $orderOp[$order] = 'checked';
            ?>
            <label><input type="radio" name="order" value="asc" <?=$orderOp['asc']?>>정</label>
            <label><input type="radio" name="order" value="desc" <?=$orderOp['desc']?>>역</label>
            <?php // echo '<input type="hidden" name="page" value="'.$page.'">'; ?>
            <input type="submit" value="입력">

        </form>
        </td><td class="right">
            <input type="button" value="초기화"
            onclick="location.href='test20_select.php'">
        </td></tr>
        </table>
    </div>

    <table cellpadding="3" cellspacing="0" border="1">
        <tr>
            <th width="60">사원명</th>
            <th width="95">교육일자</th>
            <th width="75">교육시간</th>
            <th width="130">교육명</th>
            <th width="75">교육구분</th>
            <th width="108">시행기관</th>
            <th width="75">교육장소</th>
        </tr>
    <?php
        while ($a = mysqli_fetch_assoc($res)) {
            if ($a['kind'] == 'D') { $kind = '의무'; } 
            elseif ($a['kind'] == 'F') {  $kind = '선택'; }

            echo '<tr>';
            echo '<td>'.$a['numb_name'].'</td>';
            echo '<td>'.$a['date'].'</td>';
            echo '<td>'.$a['hour'].'</td>';
            echo '<td>'.$a['educ'].'</td>';
            echo '<td>'.$kind.'</td>';
            echo '<td>'.$a['auth'].'</td>';
            echo '<td>'.$a['plce_name'].'</td>';
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
                echo '[<a href="test20_select.php?items='.$items.'&page='.$i.
                     '&where='.$where.'&sort='.$sort.'&order='.$order.'">'.$i.'</a>]';
            }
            echo '</span>';
        }
    
    ?>
    </div>

</div>

<hr>
<?php
    include 'test20_menu.php';
?> 
<?php
    include 'test20_footer.php';
?>