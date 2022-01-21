<?php
require_once 'includes/global.php';
require_once 'includes/functions.php';
require_once 'cust_init.php';

$action = 'insert';
$title = $tableName.' 입력';

if (isset($_POST['insert'])) {
    $numb = $_POST['numb'];
    $name = $_POST['name'];
    $stat = $_POST['stat'];
    $rent = $_POST['rent'];
    $date = $_POST['date'];
    $ammt = $_POST['ammt'];

    $sql = "INSERT INTO toyy
            VALUES ('$numb', '$name', '$stat', '$rent', '$date', '$ammt')";
    mysqli_query($db, $sql);
    $msg = "입력 완료";
    $url = "toyy_insert.php";
    sendMsg($msg, $url);
}

$jobbList = array();
$sql = "SELECT cod2 AS jobb, name AS jobb_name 
        FROM cust WHERE cod1 = '16'";
$res = mysqli_query($db, $sql);


$preData = array();
foreach ($nameSpace as $key => $value) {
    $preData[$key] = '';
}

$preData['numb'] = 11;
$preData['date'] = date('Y-m-d');

if (tableExist($table) == true) {
    
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
</div>

<?php
    include 'includes/_footer.php';
?>