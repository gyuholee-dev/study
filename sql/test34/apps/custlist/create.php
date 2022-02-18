<?php
require_once 'init.php';

// 변수
$table = 'custlist';
$tableName = '한국유통';
$title = "$tableName 생성";
$fileName = 'create.php';

if (isset($_POST['create'])) {
  $sql = "DROP TABLE IF EXISTS $table";
  mysqli_query($db, $sql);

  $sql = "CREATE TABLE custlist (
            code CHAR(5) NOT NULL,
            comp CHAR(20),
            pers CHAR(10),
            posn CHAR(10),
            addr CHAR(40),
            cont CHAR(8),
            PRIMARY KEY (code)
          )";
  try {
    mysqli_query($db, $sql);
  } catch (mysqli_sql_exception $e) {
    exit($e);
  }

  $sql = "LOAD DATA INFILE 
          'C:/Workspaces/study/sql/test34/data/custlist.txt' 
          INTO TABLE custlist 
          FIELDS TERMINATED BY '^' 
          (code, comp, pers, posn, addr, cont, @end)";
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