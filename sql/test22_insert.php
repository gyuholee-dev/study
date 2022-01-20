<?php
require 'include/global22.php';

$action = 'insert';
$title = $tableName.' 입력';

$sql = "SELECT numb, name FROM empl ORDER BY name";
$emplList = mysqli_query($db, $sql);

$sql = "SELECT cod2, name FROM code WHERE cod1 = '15'";
$codeList = mysqli_query($db, $sql);

if (isset($_POST['insert'])) {
    $seqn = $_POST['seqn'];
    $empl = $_POST['empl'];
    $date = $_POST['date'];
    $kind = $_POST['kind'];
    $code = $_POST['code'];
    $resn = $_POST['resn'];
    $remk = $_POST['remk'];

    $sql = "INSERT INTO $table(empl, date, kind, code, resn, remk)
            VALUES('$empl', '$date', '$kind', '$code', '$resn', '$remk')";
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
$sql = "SELECT MAX($primeKey) FROM $table";
$res = mysqli_query($db, $sql);
$maxNumb = mysqli_fetch_row($res)[0];
$sql = "SELECT * FROM $table WHERE $primeKey ='$maxNumb'";
$res = mysqli_query($db, $sql);

while ($a = mysqli_fetch_assoc($res)) {
    foreach ($a as $key => $value) {
        $preData[$key] = $value;
    }
}
$preData['date'] = date('Y-m-d');

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