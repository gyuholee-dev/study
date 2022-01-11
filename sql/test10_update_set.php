<?php
// ini_set('display_errors', 0);
include 'include/head.inc';
// mysqli_report(MYSQLI_REPORT_OFF);

$code = $_REQUEST['code'];
$items = $_REQUEST['items'];
$page = $_REQUEST['page'];

if (isset($_POST['update'])) {
    $code = $_POST['code'];
    $name = $_POST['name'];
    $numb = $_POST['numb'];
    $repr = $_POST['repr'];
    $type = $_POST['type'];
    $prod = $_POST['prod'];
    $phon = $_POST['phon'];

    $sql = "UPDATE supp
            SET name = '$name',
                numb = '$numb',
                repr = '$repr',
                type = '$type',
                prod = '$prod',
                phon = '$phon'
            WHERE code = '$code'";
    // echo $sql;
    mysqli_query($db, $sql);
    $msg = '거래처 수정 완료';
    $pgm = "test10_update.php?items=$items&page=$page";
    include 'include/sendmsg.inc';
    
} else {
    $sql = "SELECT * FROM supp WHERE code='$code'";
    $res = mysqli_query($db, $sql);
    $a = mysqli_fetch_assoc($res);
    
    $code = $a['code'];
    $name = $a['name'];
    $numb = $a['numb'];
    $repr = $a['repr'];
    $type = $a['type'];
    $prod = $a['prod'];
    $phon = $a['phon'];   
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" type="text/css" href="include/test.css">
</head>
<body>
<center>
<h3>거래처 수정</h3>
<hr>
<br>

<table cellpadding="3" cellspacing="0" border="1">
<form method="post" action="test10_update_set.php" autocomplete="off">

    <tr><th width="80">거래처번호</th>
    <td width="180" class="left">
        <input type="text" name="code" value="<?=$code?>" size="1" 
        readonly required maxlength="4">
        <input type="hidden" name="items" value="<?=$items?>">
        <input type="hidden" name="page" value="<?=$page?>">
    </td></tr>

    <tr><th width="80">거래처명</th>
    <td width="180">
        <input type="text" name="name" size="18" 
        autofocus required maxlength="40"
        value = "<?=$name?>">
    </td></tr>

    <tr><th width="80">사업자No</th>
    <td width="180">
        <input type="text" name="numb" size="18" 
        required maxlength="12"
        value = "<?=$numb?>">
    </td></tr>

    <tr><th width="80">대표자</th>
    <td width="180">
        <input type="text" name="repr" size="18" 
        required maxlength="20"
        value = "<?=$repr?>">
    </td></tr>

    <tr><th width="80">업태</th>
    <td width="180">
        <input type="text" name="type" size="18" 
        required maxlength="40"
        value = "<?=$type?>">
    </td></tr>

    <tr><th width="80">종목</th>
    <td width="180">
        <input type="text" name="prod" size="18" 
        required maxlength="40"
        value = "<?=$prod?>">
    </td></tr>

    <tr><th width="80">전화번호</th>
    <td width="180">
        <input type="text" name="phon" size="18" 
        required maxlength="13"
        value = "<?=$phon?>">
    </td></tr>

    <tr>
        <td colspan="2">
            <input type="submit" value="입력" name="update">
            <input type="reset" value="취소">
            <input type="button" value="이전" 
                onclick="location.href='test10_update.php?items=<?=$items?>&page=<?=$page?>'">
        </td>
    </tr>
</form>
</table>

</body>
</html>