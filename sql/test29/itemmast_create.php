<?php
require_once 'includes/init.php';

if (isset($_REQUEST['create'])) {
  $sql = "DROP TABLE IF EXISTS itemmast";
  mysqli_query($db, $sql);

  $sql = "CREATE TABLE itemmast
          (
            itemcode CHAR(2) NOT NULL,
            descript CHAR(20),
            itemspec CHAR(20),
            itemkind CHAR(2),
            innprice INT,
            outprice INT,
            inventry INT,
            PRIMARY KEY(itemcode)
          )";
  mysqli_query($db, $sql);
  $msg = '제품마스터 테이블 생성 완료';
  $url = 'index.php';
  sendMsg($msg, $url);
}

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>제품마스터 생성</h3>
<hr>
<!-- contents -->
<span class="red">
<b>제품마스터 테이블을 생성하시겠습니까?</b>
</span>
<br><br>

<input type="button" value="Yes"
  onclick="location.href='itemmast_create.php?create=true'">
<input type="button" value="No"
  onclick="location.href='index.php'">

<!-- contents -->
<?php
  include 'includes/_footer.php';
?>