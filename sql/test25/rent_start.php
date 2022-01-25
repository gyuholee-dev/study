<?php
require_once 'rent_init.php';

$action = 'insert';
// $title = $tableName.' 입력';
$title = '대여 등록';

$passes = array('retn', 'stat');

if (isset($_POST['insert'])) {
    // $sql = makeInsertSql();

    // $seqn = $_POST['seqn'];
    $date = $_POST['date'];
    $cust = $_POST['cust'];
    $toyy = $_POST['toyy'];
    // $stat = $_POST['stat'];
    // $retn = $_POST['retn'];

    $sql = "INSERT INTO rent(date, cust, toyy, stat, retn)
            VALUES('$date', '$cust', '$toyy', 'R', '')" ;
    Mysqli_Query($db, $sql) ;

    $sql = "UPDATE toyy 
            SET stat = 'R'
            WHERE numb = '$toyy'";
    Mysqli_Query($db, $sql);

    $msg = "$title 완료";
    $url = "start.php";
    sendMsg($msg, $url);
}

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
<?php
    include 'includes/_footer.php';
?>