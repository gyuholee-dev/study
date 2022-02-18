<?php
require_once 'init.php';

// 변수
$table = 'salelist';
$tableName = '거래처';
$title = "$tableName 생성";
$fileName = 'create.php';

if (isset($_POST['create'])) {
  $sql = "DROP TABLE IF EXISTS $table";
  mysqli_query($db, $sql);

  $sql = "CREATE TABLE salelist (
            seqn INT AUTO_INCREMENT,
            yymd CHAR(10),
            comp CHAR(20),
            prod CHAR(10),
            prce INT,
            qnty INT,
            PRIMARY KEY (seqn)
          )";
  try {
    mysqli_query($db, $sql);
  } catch (mysqli_sql_exception $e) {
    exit($e);
  }

  $sql = "LOAD DATA INFILE 
          'C:/Workspaces/study/sql/test34/data/salelist.txt' 
          INTO TABLE salelist 
          FIELDS TERMINATED BY '^' 
          (yymd, comp, prod, prce, qnty, @end);";
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