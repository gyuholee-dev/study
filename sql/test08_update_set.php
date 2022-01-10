<?php
ini_set('display_errors', 0);
include 'include/head.inc';

$ukey1 = $_REQUEST['ukey1'];
$ukey2 = $_REQUEST['ukey2'];

$sql = "SELECT * FROM code
        WHERE cod1='$ukey1' 
          AND cod2='$ukey2'";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_array($res);

if (isset($_POST['set'])) {
    $cod1 = $_POST['cod1'];
    $cod2 = $_POST['cod2'];
    $name = $_POST['name'];
    $used = $_POST['used'];

    $sql = "UPDATE code
            SET name = '$name',
                used = '$used'
            WHERE cod1='$cod1' 
              AND cod2='$cod2'";
    // echo $sql;
    mysqli_query($db, $sql);

    $msg = '코드 자료 수정 완료';
    $pgm = 'test08_update.php';
    include 'include/sendmsg.inc';
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<link rel="stylesheet" href="include/test.css">
</head>
<body>
<center>
<h3>코드 자료 수정</h3>
<hr>
<br>

<form method="post" autocomplete='off' action="test08_update_set.php">
<table cellpadding="3" cellspacing="0" border="1">
    <tr>
        <th width="80">코드-1</th>
        <td width="150" class="left">
            <input type="text" name="cod1" size="1" value="<?=$a[0]?>" required readonly>
        </td>
    </tr>
    <tr>
        <th>코드-2</th>
        <td class="left">
            <input type="text" name="cod2" size="1" value="<?=$a[1]?>" required readonly>
        </td>
    </tr>
    <tr>
        <th>코드 이름</th>
        <td>
            <input type="text" name="name" size="18" value="<?=$a[2]?>" required autofocus>
        </td>
    </tr>
    <tr>
        <th>사용여부</th>
        <td>
            <?php
                $checked = array('','');
                if ($a[3] == 'Y') { $checked[0] = 'checked'; }
                elseif ($a[3] == 'N') { $checked[1] = 'checked'; }
            ?>
            <input type="radio" name="used" value="Y" <?=$checked[0]?>>사용중
            <input type="radio" name="used" value="N" <?=$checked[1]?>>미사용
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="submit" name="set" value="수정">
            <input type="reset" value="취소">
            <input type="button" value="이전"
                onclick="location.href='test08_update.php'">
        </td>
    </tr>
</table>
</form>

</body>
</html>