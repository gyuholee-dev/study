<?php
require 'include/global.php';

// param
$mode = 'RECORD';
$title = '교육 삭제';
$file = 'test20_delete_del.php';
$table = 'educ';
$target = 'seqn';

$items = $_REQUEST['items'];
$page = $_REQUEST['page'];
$where = $_REQUEST['where'];
$sort = $_REQUEST['sort'];
$order = $_REQUEST['order'];

$targetVal = $_REQUEST[$target];

$urlParam = 'items='.$items.'&page='.$page.'&where='.$where.'&sort='.$sort.'&order='.$order;
$replyUrl = $file.'?reply=y&'.$target.'='.$targetVal.'&'.$urlParam;
$backUrl = 'test20_delete.php?'.$urlParam;

if (isset($_REQUEST['reply']) && $_REQUEST['reply'] == 'y') {
    $sql = "DELETE FROM $table WHERE $target='$targetVal'";
    // echo '$sql: '.$sql;
    mysqli_query($db, $sql);
    $msg = '인사명부 테이블 삭제 완료';
    $url = $backUrl;
    sendMsg($msg, $url);
}

// start
include 'test20_start.php';
?>
<!-- html -->
<?php
    include 'test20_header.php';
    include 'test20_contents.php';
?>
<!-- <h3><?=$title?></h3> -->
<!-- <hr> -->

<span class="red"><b>교육 레코드를 삭제하시겠습니까?</b></span>
<br><br>
<input type="button" value="Yes" onclick="location.href='<?=$replyUrl?>'">
<input type="button" value="No" onclick="location.href='<?=$backUrl?>'">

<?php
    // include 'test20_menu.php';
?> 
<?php
    include 'test20_footer.php';
?>