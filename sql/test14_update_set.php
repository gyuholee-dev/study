<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

$items = $_REQUEST['items'];
$page = $_REQUEST['page'];
$numb = $_REQUEST['numb'];

$deptList = array();
$sql = "SELECT * FROM dept";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_row($res)) {
    $deptList[$a[0]] = $a[1];
}

$sql = "SELECT * FROM asst
        WHERE numb = '$numb'";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_assoc($res);


if (isset($_POST['update'])) {
    $numb = $_POST['numb'];
    $name = $_POST['name'];
    $dept = $_POST['dept'];
    $prce = $_POST['prce'];
    $qntt = $_POST['qntt'];
    $date = $_POST['date'];

    $sql = "UPDATE asst
            SET name = '$name',
                dept = '$dept',
                prce = '$prce',
                qntt = '$qntt',
                date = '$date'
            WHERE numb = '$numb'";
    // echo $sql;
    mysqli_query($db, $sql);
    $msg = '고정자산 수정 완료';
    $pgm = 'test14_update.php?items='.$items.'&page='.$page;
    include 'include/sendmsg.inc';
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>고정자산 수정</h3>
<hr>
<br>

<table cellpadding="3" cellspacing="0" border="1">
<form method="post" action="test14_update_set.php" autocomplete="off">
    <tr>
        <th width="80">자산번호</th>
        <td>
            <input name="numb" type="text" value="<?=$a['numb']?>"
            required maxlength="4" readonly>
            <input type="hidden" name="items" value="<?=$items?>">
            <input type="hidden" name="page" value="<?=$page?>">
        </td>
    </tr>
    <tr>
        <th width="80">자산명</th>
        <td>
            <input name="name" type="text" value="<?=$a['name']?>"
            required maxlength="50" autofocus>
        </td>
    </tr>
    <tr>
        <th width="80">자산위치</th>
        <td>
            <select name="dept">
            <?php
                /* while ($b = mysqli_fetch_row($dres)) {
                    echo "<option value='$b[0]'>$b[1]</option>";
                } */
                foreach ($deptList as $key => $value) {
                    if ($key == $a['dept']) {
                        echo "<option value='$key' selected>$value</option>";
                    } else {
                        echo "<option value='$key'>$value</option>";
                    }
                }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <th width="80">단가</th>
        <td>
            <input name="prce" type="number" value="<?=$a['prce']?>"
            required max="1000000">
        </td>
    </tr>
    <tr>
        <th width="80">수량</th>
        <td>
            <input name="qntt" type="number" value="<?=$a['qntt']?>"
            required max="1000">
        </td>
    </tr>
    <tr>
        <th width="80">구입일자</th>
        <td>
            <input name="date" type="text" value="<?=$a['date']?>"
            required maxlength="10">
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <input type="submit" value="입력" name="update">
            <input type="reset" value="취소">
            <input type="button" value="이전"
            onclick="location.href='test14_update.php?items=<?=$items?>&page=<?=$page?>'">
        </td>
    </tr>

</form>
</table>


</body>
</html>