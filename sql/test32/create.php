<?php
require_once 'includes/init.php';

if (isset($_POST['create'])) {
  $sql = "DROP TABLE IF EXISTS fixasset";
  mysqli_query($db, $sql);

  $sql = "CREATE TABLE fixasset (
            asstnumb CHAR(3) NOT NULL,
            asstname CHAR(20),
            asstdate CHAR(10),
            asstprce INT,
            asstqnty INT,
            asstdept CHAR(2),
            asststat CHAR(1),
            dusedate CHAR(10),
            duseresn CHAR(20),
            PRIMARY KEY (asstnumb)
          )";
  mysqli_query($db, $sql);

  $sql = "LOAD DATA INFILE 'C:/Workspaces/study/sql/test32/data/fixasset.txt'
          INTO TABLE fixasset
          FIELDS TERMINATED BY '^'";
  mysqli_query($db, $sql);

  $msg = "고정자산 테이블 생성 완료";
  $url = "index.php";
  sendMsg($msg, $url);
}

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>고정자산 생성</h3>
<hr>
<!-- contents -->
<div class="tbContents">
  <strong class="red">
    고정자산을 생성하겠습니까?
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
  include 'includes/_footer.php';
?>
