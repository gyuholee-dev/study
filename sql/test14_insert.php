<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

$today = DATE('Y-m-d');
if (isset($_REQUEST['today'])) {
    $today = $_REQUEST['today'];
}


$numMax = '1111';
$sql = "SELECT MAX(numb) FROM asst";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
if ($a[0] != $numMax) {
    $numMax = $a[0] + 1;
}

$sql = "SELECT * FROM dept";
$dres = mysqli_query($db, $sql);

if (isset($_POST['insert'])) {
    $numb = $_POST['numb'];
    $name = $_POST['name'];
    $dept = $_POST['dept'];
    $prce = $_POST['prce'];
    $qntt = $_POST['qntt'];
    $date = $_POST['date'];

    $sql = "INSERT INTO asst
            VALUES('$numb', '$name', '$dept', '$prce', '$qntt', '$date')";
    // echo $sql;
    mysqli_query($db, $sql);
    $msg = '레코드 입력 완료';
    $pgm = 'test14_insert.php?today='.$date;
    include 'include/sendmsg.inc';
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>고정자산 입력</h3>
<hr>
<br>

<table cellpadding="3" cellspacing="0" border="1">
<form method="post" action="test14_insert.php" autocomplete="off">
    <tr>
        <th width="80">자산번호</th>
        <td>
            <input name="numb" type="text" value="<?=$numMax?>"
            required maxlength="4" readonly>
        </td>
    </tr>
    <tr>
        <th width="80">자산명</th>
        <td>
            <input name="name" type="text"
            required maxlength="50" autofocus>
        </td>
    </tr>
    <tr>
        <th width="80">자산위치</th>
        <td>
            <select name="dept">
            <?php
                while ($b = mysqli_fetch_row($dres)) {
                    echo "<option value='$b[0]'>$b[1]</option>";
                }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <th width="80">단가</th>
        <td>
            <input name="prce" type="number"
            required max="1000000">
        </td>
    </tr>
    <tr>
        <th width="80">수량</th>
        <td>
            <input name="qntt" type="number"
            required max="1000">
        </td>
    </tr>
    <tr>
        <th width="80">구입일자</th>
        <td>
            <input name="date" type="text" value="<?=$today?>"
            required maxlength="10">
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <input type="submit" value="입력" name="insert">
            <input type="reset" value="취소">
            <input type="button" value="메뉴"
            onclick="location.href='test14.php'">
        </td>
    </tr>

</form>
</table>


</body>
</html>