<?php
require_once 'init.php';

// 변수
$table = 'shopping';
$tableName = '온라인쇼핑몰';
$title = "<i class='xi-list-dot'></i> $tableName 생성";
$fileName = 'create.php';

if (isset($_POST['create'])) {
  $sql = "DROP TABLE IF EXISTS $table";
  mysqli_query($db, $sql);

  $sql = "CREATE TABLE shopping (
            seqn INT AUTO_INCREMENT,
            date CHAR(10),
            code CHAR(9),
            subj CHAR(12),
            prce INT,
            qnty INT,
            dcnt INT,
            cust CHAR(5),
            agee CHAR(2),
            gend CHAR(1),
            PRIMARY KEY (seqn)
          )";
  try {
    mysqli_query($db, $sql);
  } catch (mysqli_sql_exception $e) {
    exit($e);
  }
  
  $sql = "LOAD DATA INFILE 
          'C:/Workspaces/study/sql/test35/data/shopping.txt' 
          INTO TABLE shopping 
          FIELDS TERMINATED BY '^' 
          (date, code, subj, prce, qnty, dcnt, cust, agee, gend, @end)";
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