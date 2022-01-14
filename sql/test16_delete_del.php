<?php
require 'include/global.php';

$numb = $_REQUEST['numb'];
$page = $_REQUEST['page'];
$items = $_REQUEST['items'];

$replyUrl = 'test16_delete_del.php?reply=y'.
'&numb='.$numb.'&items='.$items.'&page='.$page;
$backUrl = 'test16_delete.php?items='.$items.'&page='.$page;

if (isset($_REQUEST['reply']) && $_REQUEST['reply'] == 'y') {
    $sql = "DELETE FROM ordr
            WHERE numb = '$numb'";
    // echo $sql;
    mysqli_query($db, $sql);

    $msg = '주문요구서 테이블 삭제 완료';
    $url = $backUrl;
    sendMsg($msg, $url);
}

$sql = "SELECT * FROM ordr
        WHERE numb = '$numb'";
$res = mysqli_query($db, $sql);
$deptList = getAllRecords('dept');

?>
<!-- html -->
<?php
    include 'test16_header.html';
?>
<h3>주문요구서 삭제</h3>
<hr>

<div class="tbContents">
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
    </table>
</div>
<br>
<span class="red"><b>주문요구서 테이블을 삭제하겠습니까?</b></span>
<br><br>
<input type="button" value="Yes" onclick="location.href='<?=$replyUrl?>'">
<input type="button" value="No" onclick="location.href='<?=$backUrl?>'">
<?php
    // include 'test16_footer.html';
?>