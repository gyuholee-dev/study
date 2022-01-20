<?php
require 'include/global21.php';

$action = 'update';
$title = $tableName.' 수정';

$target = $_REQUEST[$primeKey];

$sql = "SELECT numb, name FROM empl ORDER BY name";
$emplList = mysqli_query($db, $sql);

$sql = "SELECT cod2, name FROM code WHERE cod1 = '13'";
$plceList = mysqli_query($db, $sql);

if (isset($_POST['update'])) {
    $serl = $_POST['serl'];
    $numb = $_POST['numb'];
    $date = $_POST['date'];
    $days = $_POST['days'];
    $plce = $_POST['plce'];
    $purp = $_POST['purp'];
    $tran = $_POST['tran'];
    $food = $_POST['food'];
    $etcs = $_POST['etcs'];
    $comp = $_POST['comp'];

    $sql = "UPDATE $table
            SET numb = '$numb',
                date = '$date',
                days = '$days',
                plce = '$plce',
                purp = '$purp',
                tran = '$tran',
                food = '$food',
                etcs = '$etcs',
                comp = '$comp'
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