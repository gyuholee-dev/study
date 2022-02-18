<?php
require_once 'init.php';

// 변수
$table = 'dealamnt';
$tableName = '효성상사';
$title = "$tableName 생성";
$fileName = 'create.php';

if (isset($_POST['create'])) {
  $sql = "DROP TABLE IF EXISTS $table";
  mysqli_query($db, $sql);

  $sql = "CREATE TABLE dealamnt (
            code CHAR(5) NOT NULL,
            comp CHAR(20),
            kind CHAR(10),
            qt_1 INT,
            qt_2 INT,
            qt_3 INT,
            qt_4 INT,
            PRIMARY KEY (code)
          )";
  try {
    mysqli_query($db, $sql);
  } catch (mysqli_sql_exception $e) {
    exit($e);
  }

  $sql = "LOAD DATA INFILE 
          'C:/Workspaces/study/sql/test34/data/dealamnt.txt' 
          INTO TABLE dealamnt 
          FIELDS TERMINATED BY '^' 
          (code, comp, kind, qt_1, qt_2, qt_3, qt_4, @end)";
  try {
    mysqli_query($db, $sql);
  } catch (mysqli_sql_exception $e) {
    exit($e);
  }

  $msg = "$tableName 테이블 생성 완료";
  $url = "index.php";
  sendMsg($msg, $url);
}

?>
<!-- html -->
<?php
  include $htmlHeader;
?>
<h2 class="title"><?=$title?></h2>
<!-- contents -->
<div class="tbContents">
  <strong class="red" style="font-size:125%">
    <?=$tableName?> 테이블을 생성하겠습니까?
  </strong>
  <br>
  <br>
  <form method="post">
    <input type="submit" name="create" value="Yes">
    <input type="button" value="No"
    onclick="location.href='index.php'">
  </form>
</div>
<!-- contents -->
<?php
  include $htmlFooter;
?>