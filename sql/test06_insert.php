<?php
// ini_set('display_errors', 0);
include 'include/head.inc';
// mysqli_report(MYSQLI_REPORT_OFF);

$today = DATE('Y-m-d');

if (isset($_POST['insert'])) {

    $date = $_POST['date'];
    $cont = $_POST['cont'];
    $cost = $_POST['cost'];
    $plce = $_POST['plce'];
    $kind = $_POST['kind'];

    $sql = "INSERT INTO carr (date, cont, cost, plce, kind)
            VALUES ('$date', '$cont', '$cost', '$plce', '$kind')";
    mysqli_query($db, $sql);

    $msg = '입력 완료';
    $pgm = 'test06_insert.php';
    include 'include/sendmsg.inc';
}

?>
<!DOCTYPE html>
<html lang='ko'>

<center>
<font face='맑은 고딕'>
<h3>차계부 자료 입력</h3>
<hr>
<br><br>

<table cellpadding=3 cellspacing=0 border=1>
<form method='post' autocomplete='off' action='test06_insert.php'>
    <!-- <tr>
        <td colspan=2 align='center'>
            <input type='button' value='돌아가기'
                onclick='location.href="test06.php"'>
        </td>
    </tr> -->
    <tr>
        <th width=80 bgcolor='lightblue'>발생일자</th>
        <td>
            <input type='text' name='date' 
            size=7 maxlength=10 autofocus 
            required style="background-color: #ffdada;"
            value='<?=$today?>'>
        </td>
    </tr>
    <tr>
        <th width=80 bgcolor='lightblue'>발생내역</th>
        <td>
            <input type='text' name='cont' size=20 
            required style="background-color: #ffdada;">
        </td>
    </tr>
    <tr>
        <th width=80 bgcolor='lightblue'>비용</th>
        <td>
            <input type='text' name='cost' size=17> 원
        </td>
    </tr>
    <tr>
        <th width=80 bgcolor='lightblue'>발생장소</th>
        <td>
            <input type='text' name='plce' size=20>
        </td>
    </tr>
    <tr>
        <th width=80 bgcolor='lightblue'>비용구분</th>
        <td>
            <select name='kind'>
                <option value='R'>수리,교체</option>
                <option value='T' selected>도로,주유비</option>
                <option value='I'>보험,배상</option>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan=2 align='center'>
            <input type="submit" name='insert' value='입력'>
            <input type="reset" value='취소'>
            <input type="button" value='이전'
            onclick='location.href="test06.php"'>
        </td>
    </tr>

</form>
</table>