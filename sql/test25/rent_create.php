<?php
require_once 'rent_init.php';

$action = 'create';
$title = $tableName.' 생성';

$tableExist = false;
$tableReset = false;

$create = false;
$backup = false;
$restore = false;
$clear = false;
$sep = '^';
$file = '../text/'.$table.'.txt';

if (tableExist($table) == true) {
    $tableExist = true;
}

if (isset($_POST['tableReset'])) {
    $tableReset = true;

} elseif (isset($_POST['create'])) {
    $create = true;

} elseif (isset($_POST['backup'])) {
    if (isset($_POST['sep'])) {
        $sep = $_POST['sep'];
    }
    $file = $_POST['file'];
    $backup = true;

} elseif (isset($_POST['restore'])) {
    if (isset($_POST['clear'])) {
        $clear = $_POST['clear'];
    }
    if (isset($_POST['sep'])) {
        $sep = $_POST['sep'];
    }
    $file = $_POST['file'];
    if (file_exists($file)) {
        $restore = true;
    }

}

if ($create == true) {
    $sql = "DROP TABLE IF EXISTS $table";
    mysqli_query($db, $sql);

    $sql = makeCreateSql();
    mysqli_query($db, $sql);

    $msg = "$tableName 테이블 생성 완료";
    $url = "$id\_$action.php";
    sendMsg($msg, $url);
}

?>
<!-- html -->
<?php
    include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr><br>
<?php
    include 'includes/_backup.php';
?>
<br> 
<hr>
<?php
    // include 'includes/_menu.php';
?> 
<?php
    include 'includes/_footer.php';
?>