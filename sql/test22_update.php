<?php
require 'include/global22.php';

$action = 'update';
$title = $tableName.' 수정';

$target = $_REQUEST[$primeKey];

$sql = "SELECT numb, name FROM empl ORDER BY name";
$emplList = mysqli_query($db, $sql);

$sql = "SELECT cod2, name FROM code WHERE cod1 = '15'";
$codeList = mysqli_query($db, $sql);

if (isset($_POST['update'])) {
    $seqn = $_POST['seqn'];
    $empl = $_POST['empl'];
    $date = $_POST['date'];
    $kind = $_POST['kind'];
    $code = $_POST['code'];
    $resn = $_POST['resn'];
    $remk = $_POST['remk'];

    $sql = "UPDATE $table
            SET empl = '$empl',
                date = '$date',
                kind = '$kind',
                code = '$code',
                resn = '$resn',
                remk = '$remk'
            WHERE $primeKey='$target'";
    // echo $sql;
    mysqli_query($db, $sql);

    $msg = $title.' 완료';
    $url = $id.'_edit.php'.getURLParam($primeKey);
    sendMsg($msg, $url);
}

$preData = array();
foreach ($nameSpace as $key => $value) {
    $preData[$key] = '';
}
$sql = "SELECT * FROM $table WHERE $primeKey='$target'";
$res = mysqli_query($db, $sql);

while ($a = mysqli_fetch_assoc($res)) {
    foreach ($a as $key => $value) {
        $preData[$key] = $value;
    }
}

?>
<!-- html -->
<?php
    include $id.'_header.php';
?>
<h3><?=$title?></h3>
<hr>
<?php
    include $id.'_input.php';
?> 
<hr>
<?php
    include $id.'_menu.php';
?> 
<?php
    include $id.'_footer.php';
?>