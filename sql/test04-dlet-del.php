<?php
ini_set('display_errors', 0);
include 'include/head.inc';

$dnumb = $_REQUEST['dnumb'];
$reply = $_REQUEST['reply'];

?>

<!DOCTYPE html>
<html lang='ko'>
<center>
<font face='맑은 고딕'>
<h3>장난감 자료 삭제</h3>
<hr>
<br><br>

<?=$dnumb?> 레코드를 삭제하겠습니까?
<input type="button" value="Yes" 
    onclick='location.href="test04-dlet-del.php?reply=y&dnumb=<?=$dnumb?>"'>
<input type="button" value="No" 
    onclick='location.href="test04-dlet.php"'>

<?php
    if ($reply == 'y') {
        $sql = "DELETE FROM toyy WHERE numb = '$dnumb'";
        echo $sql;
        mysqli_query($db, $sql);

        $msg = $dnumb.' 레코드 삭제 완료';
        $pgm = 'test04-dlet.php';
        include 'include/sendmsg.inc';
    }
?>

</html>