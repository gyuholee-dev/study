<?php
require_once 'init.php';

if (isset($_POST['create'])) {
  $sql = "DROP TABLE IF EXISTS requestt";
  mysqli_query($db, $sql);

  $sql = "CREATE TABLE requestt (
            sequence INT AUTO_INCREMENT,
            reqrdate CHAR(10),
            reqrnumb CHAR(3),
            reqrqnty INT,
            reqrpers CHAR(10),
            ordrdate CHAR(10),
            ordrsupp CHAR(4),
            dueedate CHAR(10),
            PRIMARY KEY (sequence)
          )";
  mysqli_query($db, $sql);

  // $sql = "LOAD DATA INFILE 'C:/Workspaces/study/sql/test32/data/requestt.txt'
  //         INTO TABLE requestt
  //         FIELDS TERMINATED BY '^'";
  // mysqli_query($db, $sql);

  $msg = "구매요청 테이블 생성 완료";
  $url = "index.php";
  sendMsg($msg, $url);
}

?>
<!-- html -->
<?php
  include $htmlHeader;
?>
<h2 class="title">구매요청 생성</h2>
<!-- <hr> -->
<!-- contents -->
<div class="tbContents">
  <strong class="red" style="font-size:125%">
    구매요청 테이블을 생성하겠습니까?
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
