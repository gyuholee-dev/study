<?php
require_once 'includes/init.php';

if (isset($_REQUEST['create'])) {
  $sql = "DROP TABLE IF EXISTS inntran";
  mysqli_query($db, $sql);

  $sql = "CREATE TABLE inntran
          (
            serialno INT AUTO_INCREMENT,
            trandate CHAR(10),
            trancode CHAR(2),
            tranqnty INT,
            tranprce INT,
            trankind CHAR(1),
            PRIMARY KEY(serialno)
          )";
  mysqli_query($db, $sql);
  $msg = '제품입고 테이블 생성 완료';
  $url = 'index.php';
  sendMsg($msg, $url);
}

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>제품입고 생성</h3>
<hr>
<!-- contents -->
<span class="red">
<b>제품입고 테이블을 생성하시겠습니까?</b>
</span>
<br><br>

<input type="button" value="Yes"
  onclick="location.href='inntran_create.php?create=true'">
<input type="button" value="No"
  onclick="location.href='index.php'">

<!-- contents -->
<?php
  include 'includes/_footer.php';
?>