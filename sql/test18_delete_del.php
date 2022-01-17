<?php
require 'include/global.php';

$items = $_REQUEST['items'];
$page = $_REQUEST['page'];
$sort = $_REQUEST['sort'];
$order = $_REQUEST['order'];

$numb = $_REQUEST['numb'];

$replyUrl = 'test18_delete_del.php?reply=y'.
            '&numb='.$numb.'&items='.$items.'&page='.$page.
            '&sort='.$sort.'&order='.$order;
$backUrl = 'test18_delete.php?items='.$items.'&page='.$page.
            '&sort='.$sort.'&order='.$order;


if (isset($_REQUEST['reply']) && $_REQUEST['reply'] == 'y') {
    $sql = "DELETE FROM empl WHERE numb='$numb'";
    // echo '$sql: '.$sql;
    mysqli_query($db, $sql);
    $msg = '인사명부 테이블 삭제 완료';
    $url = $backUrl;
    sendMsg($msg, $url);
}

// $sql = "SELECT * FROM empl WHERE numb='$numb'";

$sql = "SELECT empl.*, dept.name AS dept_name, code.name AS grad_name FROM empl
        JOIN dept ON empl.dept = dept.code
        JOIN code ON empl.grad = code.cod2 AND code.cod1 = '11'";

$sql = $sql." WHERE numb='$numb'";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
    include 'test18_header.php';
?>
<h3>인사명부 삭제</h3>
<hr>

<div class="tbContents">
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
</div>
<br>

<span class="red"><b>인사명부 테이블을 삭제하시겠습니까?</b></span>
<br><br>
<input type="button" value="Yes" onclick="location.href='<?=$replyUrl?>'">
<input type="button" value="No" onclick="location.href='<?=$backUrl?>'">

<?php
    // include 'test18_menu.php';
?> 
<?php
    include 'test18_footer.php';
?>