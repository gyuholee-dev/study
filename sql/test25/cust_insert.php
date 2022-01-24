<?php
require_once 'cust_init.php';

$action = 'insert';
$title = $tableName.' 입력';

if (isset($_POST['insert'])) {
    $sql = makeInsertSql();
    mysqli_query($db, $sql);
    $msg = "$tableName 테이블 입력 완료";
    $url = "$id\_$action.php";
    sendMsg($msg, $url);
}

$jobbList = array();
$sql = "SELECT cod2 AS jobb, name AS jobb_name 
        FROM code WHERE cod1 = '16'";
$res = mysqli_query($db, $sql);


$preData = array();
foreach ($tableData as $key => $value) {
    $preData[$key] = $value['default'];
}

if (tableExist($table) == true) {
    $sql = "SELECT MAX($primeKey) FROM $table";
    $res = mysqli_query($db, $sql);
    $lastValue = mysqli_fetch_row($res)[0];
    $sql = "SELECT * FROM $table WHERE $primeKey ='$lastValue'";
    $res = mysqli_query($db, $sql);
    
    while ($a = mysqli_fetch_assoc($res)) {
        foreach ($a as $key => $value) {
            if ($key == $primeKey && is_numeric($value)) {
                $preData[$key] = $value + 1;
            } elseif (isDate($value)) {
                $preData[$key] = date('Y-m-d');
            } else {
                $preData[$key] = $value;
            }
        }
    }
}

?>
<!-- html -->
<?php
    include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>
<?php
    include 'includes/_input.php';
?>


<!-- <div class="tbContents">
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
            <th><?=$nameSpace['phon']?></th>
            <td>
                <input type="text" name="phon" value="">
            </td>
        </tr>
        <tr>
            <th><?=$nameSpace['addr']?></th>
            <td>
                <input type="text" name="addr" value="">
            </td>
        </tr>
        <tr>
            <th><?=$nameSpace['addr']?></th>
            <td>
                <input type="text" name="addr" value="">
            </td>
        </tr>
    </table>

    <div class="tbMenu">
        <input type="submit" name="insert" value="입력">
        <input type="reset" value="취소">
        <input type="button" value="메뉴" onclick="location.href='start.php'">
    </div>

</form>
</div> -->

<?php
    include 'includes/_footer.php';
?>