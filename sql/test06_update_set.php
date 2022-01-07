<?php
ini_set('display_errors', 0);
include 'include/head.inc';
// mysqli_report(MYSQLI_REPORT_OFF);

$numb = $_REQUEST['numb'];
$sql = "SELECT * FROM carr WHERE numb='$numb'";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_array($res);

if (isset($_POST['set'])) {
    $numb = $_POST['numb'];
    $date = $_POST['date'];
    $cont = $_POST['cont'];
    $date = $_POST['date'];
    $cost = $_POST['cost'];
    $plce = $_POST['plce'];
    $kind = $_POST['kind'];

    $sql = "UPDATE carr 
            SET date = '$date',
                cont = '$cont',
                cost = '$cost',
                plce = '$plce',
                kind = '$kind'
            WHERE numb = '$numb'";
    // echo $sql;
    mysqli_query($db, $sql);
    $msg = '레코드 수정 완료';
    $pgm = 'test06_update.php';
    include 'include/sendmsg.inc';
}
?>

<!DOCTYPE html>
<html lang='ko'>
<head>
    <style>
        th, td {
            padding: 3px 10px;
        }
    </style>
</head>
<center>
<font face='맑은 고딕'>
<h3>차계부 자료 수정</h3>
<hr>
<br><br>

<table cellpadding="3" cellspacing="0" border="1">
<form method="post" autocomplete='off' action="test06_update_set.php">
    <tr>
        <th width="80" bgcolor="lightblue">발생일자</th>
        <td width="180">
            <input type="text" name="date" size="7" autofocus value="<?=$a[1]?>" maxlength='10'
            required style="background-color: #ffdada;">
            <input type="hidden" name='numb' value='<?=$numb?>'>
        </td>
    </tr>
    <tr>
        <th width="80" bgcolor="lightblue">발생내역</th>
        <td width="180">
            <input type="text" name="cont" size="20" autofocus value="<?=$a[2]?>"
            required style="background-color: #ffdada;">
        </td>
    </tr>
    <tr>
        <th width="80" bgcolor="lightblue">비용</th>
        <td width="180">
            <input type="text" name="cost" size="20" autofocus value="<?=$a[3]?>">
        </td>
    </tr>
    <tr>
        <th width="80" bgcolor="lightblue">발생장소</th>
        <td width="180">
            <input type="text" name="plce" size="20" autofocus value="<?=$a[4]?>">
        </td>
    </tr>
    <tr>
        <th width="80" bgcolor="lightblue">비용구분</th>
        <td width="180">
            <select name="kind">
            <?php
                $kind = $a[5];
                if ($kind == 'T') {
                    echo '<option value="T" selected>도로비등</option>';
                } else {
                    echo '<option value="T">도로비등</option>';
                }
                
                if ($kind == 'R') {
                    echo '<option value="R" selected>수리교체</option>';
                } else {
                    echo '<option value="R">수리교체</option>';
                }
                
                if ($kind == 'I') {
                    echo '<option value="I" selected>보험배상</option>';
                } else {
                    echo '<option value="I">보험배상</option>';
                }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="submit" name="set" value="수정">
            <input type="reset" value="취소">
            <input type="button" value="이전" onclick="location.href='test06_update.php'">
        </td>
    </tr>

</form>
</table>


</html>