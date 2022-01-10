<?php
// ini_set('display_errors', 0);
include 'include/head.inc';

if (isset($_REQUEST['cod1'])) {
    $cod1 = $_REQUEST['cod1'];
}

if (isset($_POST['insert'])) {
    $cod1 = $_POST['cod1'];
    $cod2 = $_POST['cod2'];
    $name = $_POST['name'];
    $used = $_POST['used'];

    $sql = "INSERT INTO code
            VALUES('$cod1', '$cod2', '$name', '$used')";
    // echo $sql;
    mysqli_query($db, $sql);

    $msg = '코드 자료 등록 완료';
    $pgm = 'test08_insert.php?cod1='.$cod1;
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
<h3>코드 자료 등록</h3>
<hr>
<br>

<table cellpadding="3" cellspacing="0" border="1">
<form method="post" autocomplete="off" action="test08_insert.php">
    <tr>
        <th width="80">코드-1</th>
        <td width="150" class="left">
            <input type="text" name="cod1" size="1" maxlength="2" 
            required autofocus
            <?php if (isset($cod1)) { echo "value=$cod1"; } ?> >
        </td>
    </tr>
    <tr>
        <th width="80">코드-2</th>
        <td width="150" class="left">
            <input type="text" name="cod2" size="1" maxlength="2" required>
        </td>
    </tr>
    <tr>
        <th width="80">코드 이름</th>
        <td width="150">
            <input type="text" name="name" size="18" required>
        </td>
    </tr>
    <tr>
        <th width="80">사용여부</th>
        <td width="150">
            <input type="radio" name="used" value="Y" checked>사용중
            <input type="radio" name="used" value="N">미사용
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="submit" name="insert" value="등록">
            <input type="reset" value="취소">
            <input type="button" value="메뉴"
                onclick="location.href='test08.php'">
        </td>
    </tr>

</form>
</table>

</body>
</html>