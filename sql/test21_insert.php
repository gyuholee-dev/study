<?php
require 'include/global21.php';

$action = 'insert';
$title = $tableName.' 입력';

$sql = "SELECT numb, name FROM empl ORDER BY name";
$emplList = mysqli_query($db, $sql);

$sql = "SELECT cod2, name FROM code WHERE cod1 = '13'";
$plceList = mysqli_query($db, $sql);

if (isset($_POST['insert'])) {
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

    $sql = "INSERT INTO $table(numb, date, days, plce, purp, tran, food, etcs, comp)
            VALUES('$numb','$date','$days','$plce','$purp','$tran','$food','$etcs','$comp')";
    // echo $sql;
    mysqli_query($db, $sql);

    $msg = $title.' 완료';
    $url = $id.'_insert.php'.getURLParam($primeKey);
    sendMsg($msg, $url);
}

$preData = array();
foreach ($nameSpace as $key => $value) {
    $preData[$key] = '';
}
$sql = "SELECT MAX(serl) FROM $table";
$res = mysqli_query($db, $sql);
$maxSerl = mysqli_fetch_row($res)[0];
$sql = "SELECT * FROM $table WHERE serl ='$maxSerl'";
$res = mysqli_query($db, $sql);

while ($a = mysqli_fetch_assoc($res)) {
    foreach ($a as $key => $value) {
        $preData[$key] = $value;
    }
}
$preData['date'] = date('Y-m-d');
// $preData['serl'] = 0;

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