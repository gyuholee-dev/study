<?php
ini_set('display_errors', 0);
include 'include/head.inc';

$numb = $_REQUEST['numb'];
$page = $_REQUEST['page'];

// echo '$numb: '.$numb.'<br>';
// echo '$page: '.$page.'<br>';

if (isset($_POST['update'])) {
    $numb = $_POST['numb'];
    $page = $_POST['page'];

    $date = $_POST['date'];
    $item = $_POST['item'];
    $prce = $_POST['prce'];
    $qntt = $_POST['qntt'];
    $supp = $_POST['supp'];

    $sql = "UPDATE sale
            SET date = '$date',
                item = '$item',
                prce = '$prce',
                qntt = '$qntt',
                supp = '$supp'
            WHERE numb = '$numb'";
    // echo '$sql: '.$sql;
    mysqli_query($db, $sql);
    $msg = '레코드 수정 완료';
    $pgm = 'test12_update.php?page='.$page;
    include 'include/sendmsg.inc';
}


$names = array();
$sql = "SELECT code, name FROM supp";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_row($res)) {
    $names[$a[0]] = $a[1];
}

$sql = "SELECT * FROM sale
        WHERE numb = '$numb'";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res)
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>판매 자료 수정</h3>
<hr>
<br>

<table cellpadding="3" cellspacing="0" border="1">
<form method="post" action="test12_update_set.php" autocomplete="off">
    <tr>
        <th width="80">판매일</th>
        <td class="left">
            <input type="text" name="date" size="6"
            value="<?=$a[1]?>"
            required maxlength="10" autofocus>
            <input type="hidden" name="numb" value="<?=$numb?>">
            <input type="hidden" name="page" value="<?=$page?>">
        </td>
    </tr>
    <tr>
        <th width="80">판매품목</th>
        <td>
            <input type="text" name="item" size="16"
            value="<?=$a[2]?>"
            required maxlength="40">
        </td>
    </tr>
    <tr>
        <th width="80">단가</th>
        <td class="left">
            <input type="number" name="prce" style="width: 140px; text-align: right;"
            value="<?=$a[3]?>"
            required max="1000000"> 원
        </td>
    </tr>
    <tr>
        <th width="80">수량</th>
        <td class="left">
            <input type="number" name="qntt" style="width: 140px; text-align: right;"
            value="<?=$a[4]?>"
            required max="1000"> 개
        </td>
    </tr>
    <tr>
        <th width="80">판매처</th>
        <td>
            <select name="supp">
            <?php
                foreach ($names as $key => $value) {
                    if ($key == $a[5]) {
                        echo '<option value="'.$key.'" selected>'.$value.'</option>';
                    } else {
                        echo '<option value="'.$key.'">'.$value.'</option>';
                    }
                    echo "\n";
                }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="submit" value="입력" name="update">
            <input type="reset" value="취소">
            <input type="button" value="이전"
            onclick="location.href='test12_update.php?page=<?=$page?>'">
        </td>
    </tr>
</form>
</table>

</body>
</html>