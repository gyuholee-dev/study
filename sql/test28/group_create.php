<?php
require_once 'includes/init.php';

$table = 'grop';
$action = 'create';
$title = $tableName.' 생성';

if (isset($_REQUEST['create'])) {
  $sql = "DROP TABLE IF EXISTS grop";
  mysqli_query($db, $sql);

  $sql = "CREATE TABLE grop
          (
            code CHAR(2) NOT NULL,
            name CHAR(12),
            comp CHAR(20),
            date CHAR(10),
            PRIMARY KEY(code)
          )";
  mysqli_query($db, $sql);
  $msg = '걸그룹 테이블 생성 완료';
  $url = 'start.php';
  sendMsg($msg, $url);
}

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>
<!-- contents -->
<span class="red">
<b>걸그룹 테이블을 생성하시겠습니까?</b>
</span>
<br><br>

<input type="button" value="Yes"
  onclick="location.href='group_create.php?create=true'">
<input type="button" value="Yes"
  onclick="location.href='start.php'">

<!-- contents -->
<?php
  include 'includes/_footer.php';
?>