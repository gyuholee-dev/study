<?php
// ini_set('display_errors', 0);
include 'include/head.inc';
// mysqli_report(MYSQLI_REPORT_OFF);

if (isset($_POST['insert'])) {
    $code = $_POST['code'];
    $name = $_POST['name'];
    $numb = $_POST['numb'];
    $repr = $_POST['repr'];
    $type = $_POST['type'];
    $prod = $_POST['prod'];
    $phon = $_POST['phon'];

    $sql = "INSERT INTO supp
            VALUES ('$code','$name','$numb','$repr','$type','$prod','$phon')";
    // echo $sql;
    mysqli_query($db, $sql);

    $msg = '거래처 입력 완료';
    $pgm = 'test10_insert.php';
    include 'include/sendmsg.inc';
}

$sql = 'SELECT MAX(code) FROM supp';
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);

$maxnum = '1111';
if (isset($a[0])) {
    $maxnum = $a[0]+1;
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>거래처 입력</h3>
<hr>
<br>

<table cellpadding="3" cellspacing="0" border="1">
<form method="post" action="test10_insert.php" autocomplete="off">

    <tr><th width="80">거래처번호</th>
    <td width="180" class="left">
        <input type="text" name="code" value="<?=$maxnum?>" size="1" 
        readonly required maxlength="4">
    </td></tr>

    <tr><th width="80">거래처명</th>
    <td width="180">
        <input type="text" name="name" size="18" 
        autofocus required maxlength="40"
        placeholder = "상호명">
    </td></tr>

    <tr><th width="80">사업자No</th>
    <td width="180">
        <input type="text" name="numb" size="18" 
        required maxlength="12"
        placeholder = "000-00-00000">
    </td></tr>

    <tr><th width="80">대표자</th>
    <td width="180">
        <input type="text" name="repr" size="18" 
        required maxlength="20"
        placeholder = "대표자명">
    </td></tr>

    <tr><th width="80">업태</th>
    <td width="180">
        <input type="text" name="type" size="18" 
        required maxlength="40"
        placeholder = "금융, 도소매, 서비스 등">
    </td></tr>

    <tr><th width="80">종목</th>
    <td width="180">
        <input type="text" name="prod" size="18" 
        required maxlength="40"
        placeholder = "대출, 예금, 잡화 등">
    </td></tr>

    <tr><th width="80">전화번호</th>
    <td width="180">
        <input type="text" name="phon" size="18" 
        required maxlength="13"
        placeholder = "010-0000-0000">
    </td></tr>

    <tr>
        <td colspan="2">
            <input type="submit" value="입력" name="insert">
            <input type="reset" value="취소">
            <input type="button" value="메뉴" 
                onclick="location.href='test10.php'">
        </td>
    </tr>
</form>
</table>

</body>
</html>