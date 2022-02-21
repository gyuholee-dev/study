<?php
require_once 'init.php';

// 변수
$table = 'insurance';
$tableName = '보험가입';
$title = "<i class='xi-list-dot'></i> $tableName 생성";
$fileName = 'create.php';

if (isset($_POST['create'])) {
  $sql = "DROP TABLE IF EXISTS $table";
  mysqli_query($db, $sql);

  $sql = "CREATE TABLE insurance (
            numb CHAR(2) NOT NULL,
            name CHAR(10),
            rnum CHAR(14),
            gend CHAR(1),
            sinc CHAR(10),
            cont CHAR(12),
            prem INT,
            area CHAR(2),
            PRIMARY KEY (numb)
          )";
  try {
    mysqli_query($db, $sql);
  } catch (mysqli_sql_exception $e) {
    exit($e);
  }
 
  $sql = "LOAD DATA INFILE 
          'C:/Workspaces/study/sql/test35/data/insurance.txt' 
          INTO TABLE insurance 
          FIELDS TERMINATED BY '^' 
          (numb, name, rnum, gend, sinc, cont, prem, area, @end)";
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