<?php
require_once 'includes/init.php';

$action = 'insert';
$title = $tableName.' 입력';

if (isset($_POST['insert'])) {
  $sql = makeInsertSql();
  mysqli_query($db, $sql);
  $msg = "$tableName 테이블 입력 완료";
  $url = "$action.php";
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