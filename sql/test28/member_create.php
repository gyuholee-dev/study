<?php
require_once 'includes/init.php';

$table = 'girl';
$action = 'create';
$title = $tableName.' 생성';

if (isset($_REQUEST['create'])) {
  $sql = "DROP TABLE IF EXISTS girl";
  mysqli_query($db, $sql);

  $sql = "CREATE TABLE girl
          (
            code CHAR(2) NOT NULL,
            numb CHAR(2) NOT NULL,
            name CHAR(12),
            plce CHAR(2),
            date CHAR(10),
            PRIMARY KEY(code, numb)
          )";
  mysqli_query($db, $sql);
  $msg = '걸그룹 멤버 테이블 생성 완료';
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
<b>걸그룹 멤버 테이블을 생성하시겠습니까?</b>
</span>
<br><br>

<input type="button" value="Yes"
  onclick="location.href='member_create.php?create=true'">
<input type="button" value="Yes"
  onclick="location.href='start.php'">

<!-- contents -->
<?php
  include 'includes/_footer.php';
?>