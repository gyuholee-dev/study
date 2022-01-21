<?php
require_once 'includes/global.php';
require_once 'includes/functions.php';
require_once 'toyy_init.php';

$action = 'insert';
$title = $tableName.' 입력';

if (isset($_POST['insert'])) {
    $sql = makeInsertSql();
    mysqli_query($db, $sql);
    $msg = "$tableName 테이블 입력 완료";
    $url = "toyy_insert.php";
    sendMsg($msg, $url);
}

$preData = array();
foreach ($nameSpace as $key => $value) {
    $preData[$key] = '';
}

$preData['numb'] = 11;
$preData['date'] = date('Y-m-d');

if (tableExist($table) == true) {
    $sql = "SELECT * FROM $table";
    $res = mysqli_query($db, $sql);
    
}

?>
<!-- html -->
<?php
    include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>

<div class="tbContents">
<form method="post" action="" autocomplete="off">
    <table class="<?=$action?>" cellpadding="3" cellspacing="0" border="1">
        <tr>
            <th><?=$nameSpace['numb']?></th>
            <td>
                <input type="text" name="numb" value="<?=$preData['numb']?>" readonly>
            </td>
        </tr>
        <tr>
            <th><?=$nameSpace['name']?></th>
            <td>
                <input type="text" name="name" value="">
            </td>
        </tr>
        <tr>
            <th><?=$nameSpace['stat']?></th>
            <td>
                <!-- <input type="text" name="stat" value=""> -->
                <label><input type="radio" name="stat" value="H" checked>보유</label>
                <label><input type="radio" name="stat" value="R">대여</label>
            </td>
        </tr>
        <tr>
            <th><?=$nameSpace['rent']?></th>
            <td>
                <input type="number" name="rent" value="">
            </td>
        </tr>
        <tr>
            <th><?=$nameSpace['date']?></th>
            <td>
                <input type="date" name="date" value="<?=$preData['date']?>">
            </td>
        </tr>
        <tr>
            <th><?=$nameSpace['ammt']?></th>
            <td>
                <input type="number" name="ammt" value="">
            </td>
        </tr>
    </table>

    <div class="tbMenu">
        <input type="submit" name="insert" value="입력">
        <input type="reset" value="취소">
        <input type="button" value="메뉴" onclick="location.href='start.php'">
    </div>

</form>
</div>

<?php
    include 'includes/_footer.php';
?>