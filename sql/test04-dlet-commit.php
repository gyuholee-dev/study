<?php
ini_set('display_errors', 0);
include 'include/head.inc';

$dnum = $_REQUEST['dnum'];
$reply = $_REQUEST['reply'];

?>

<!DOCTYPE html>
<html lang='ko'>
<center>
<font face='맑은 고딕'>
<h3>장난감 자료 삭제</h3>
<hr>
<br><br>

<?=$dnum?> 레코드를 삭제하겠습니까?
<input type="button" value="Yes" 
    onclick='location.href="test04-dlet-commit.php?reply=y&dnum=<?=$dnum?>"'>
<input type="button" value="No" 
    onclick='location.href="test04-dlet.php"'>

<?php
    if ($reply == 'y') {
        $sql = "DELETE FROM toyy WHERE numb = '$dnum'";
        echo $sql;
        mysqli_query($db, $sql);

        $msg = $dnum.' 레코드 삭제 완료';
        $pgm = 'test04-dlet.php';
        include 'include/sendmsg.inc';
    }
?>

</html>