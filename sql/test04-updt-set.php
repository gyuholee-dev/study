<?php
ini_set('display_errors', 0);
include 'include/head.inc';

$unumb = $_REQUEST['unumb'];
$reply = $_REQUEST['reply'];

$sql = "SELECT * FROM toyy WHERE numb = '$unumb'";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_array($res);

if (isset($_POST['updt'])) {
    $numb = $_POST['numb'];
    $name = $_POST['name'];
    $prce = $_POST['prce'];
    $qntt = $_POST['qntt'];
    $stat = $_POST['stat'];
    $kind = $_POST['kind'];

    $sql = "UPDATE toyy
            SET name = '$name',
                prce = '$prce',
                qntt = '$qntt',
                stat = '$stat',
                kind = '$kind'
            WHERE numb = '$numb'";
    // echo $sql;
    mysqli_query($db, $sql);
    $msg = $numb.' 레코드 수정 완료';
    $pgm = 'test04-updt.php';
    include 'include/sendmsg.inc';
}


?>

<!DOCTYPE html>
<html lang='ko'>
<center>
<font face='맑은 고딕'>
<h3>장난감 자료 수정</h3>
<hr>
<br><br>

<form method='post' autocomplete='off' action='test04-updt-set.php'>
    <table cellpadding=3 cellspacing=0 border=1>
        <tr>
            <th width=80 bgcolor='lightblue'>번호</th>
            <td width=180>
                <input type='text' name='numb' size='1' value='<?=$a[0]?>' readonly>
                <input type="hidden" name='unumb' value='<?=$unumb?>'>
            </td>
        </tr>
        <tr>
            <th width=80 bgcolor='lightblue'>장난감명</th>
            <td width=180>
                <input type='text' name='name' size='20' value='<?=$a[1]?>' autofocus>
            </td>
        </tr>
        <tr>
            <th width=80 bgcolor='lightblue'>단가</th>
            <td width=180>
                <input type='text' name='prce' size='15' value='<?=$a[2]?>' maxlength='6'> 원
            </td>
        </tr>
        <tr>
            <th width=80 bgcolor='lightblue'>수량</th>
            <td width=180>
                <input type='text' name='qntt' size='15' value='<?=$a[3]?>' maxlength='4'> 개
            </td>
        </tr>
        <tr>
            <th width=80 bgcolor='lightblue'>상태</th>
            <td width=180>
                <?php
                    if ($a[4]=='보유') {
                        echo "<input type='radio' name='stat' value='보유' checked>보유";
                        echo "<input type='radio' name='stat' value='대여'>대여";
                    } elseif ($a[4]=='대여') {
                        echo "<input type='radio' name='stat' value='보유'>보유";
                        echo "<input type='radio' name='stat' value='대여' checked>대여";
                    }
                ?>
            </td>
        </tr>
        <tr>
            <th width=80 bgcolor='lightblue'>구분</th>
            <td width=180>
                <?php
                    if ($a[5]=='T') {
                        echo "<input type='radio' name='kind' value='T' checked>오락용";
                        echo "<input type='radio' name='kind' value='E'>교육용";
                    } elseif ($a[5]=='E') {
                        echo "<input type='radio' name='kind' value='T'>오락용";
                        echo "<input type='radio' name='kind' value='E' checked>교육용";
                    }
                ?>
            </td>
        </tr>

        <tr>
            <td colspan=2 align='center'>
                <input type='submit' value='수정' name='updt'>
                <input type='reset' value='취소'>
                <input type='button' value='이전' 
                    onclick='location.href="test04-updt.php"'>
            </td>
        </tr>

    </table>
</form>

</html>