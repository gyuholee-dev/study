<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

$sql = "SELECT * FROM supp";
$sup = mysqli_query($db, $sql);

if (isset($_GET['day'])) {
    $day = $_GET['day'];
} else {
    $day = DATE('Y-m-d');
}

if (isset($_POST['insert'])) {
    $date = $_POST['date'];
    $item = $_POST['item'];
    $prce = $_POST['prce'];
    $qntt = $_POST['qntt'];
    $supp = $_POST['supp'];

    $sql = "INSERT INTO sale(date, item, prce, qntt, supp)
            VALUES('$date', '$item', '$prce', '$qntt', '$supp')";
    // echo $sql;
    mysqli_query($db, $sql);
    $msg = '레코드 입력 완료';
    $pgm = 'test12_insert.php?day='.$date;
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
<h3>판매 자료 입력</h3>
<hr>
<br>

<table cellpadding="3" cellspacing="0" border="1">
    <form method="post" action="test12_insert.php" autocomplete="off">
    <!-- <tr>
        <th width="80">순번</th>
        <td>
            <input type="text" name="numb"
            required>
        </td>
    </tr> -->
    <tr>
        <th width="80">판매일</th>
        <td class="left">
            <input type="text" name="date" value="<?=$day?>" size="6"
            required maxlength="10" autofocus>
        </td>
    </tr>
    <tr>
        <th width="80">판매품목</th>
        <td>
            <input type="text" name="item" size="16"
            required maxlength="40">
        </td>
    </tr>
    <tr>
        <th width="80">단가</th>
        <td class="left">
            <input type="number" name="prce" style="width: 140px; text-align: right;"
            required max="1000000"> 원
        </td>
    </tr>
    <tr>
        <th width="80">수량</th>
        <td class="left">
            <input type="number" name="qntt" style="width: 140px; text-align: right;"
            required max="1000"> 개
        </td>
    </tr>
    <tr>
        <th width="80">판매처</th>
        <td>
            <!-- <input type="text" name="supp"
            required maxlength="4"> -->
            <select name="supp">
                <!-- <option value="1111">신한은행</option> -->
                <?php
                    while ($a = mysqli_fetch_row($sup)) {
                        echo '<option value="'.$a[0].'">'.$a[1].'</option>';
                        echo "\n";
                    }
                ?>
            </select>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <input type="submit" value="입력" name="insert">
            <input type="reset" value="취소">
            <input type="button" value="메뉴"
            onclick="location.href='test12.php'">
        </td>
    </tr>
    </form>

    <!-- <tr>
    <td colspan="2">
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="upfile">
        <input type="submit" value="업로드">
    </form>
    </td>
    </tr> -->

</table>

</body>
</html>