<?php
require_once 'includes/init.php';

if (isset($_REQUEST['create'])) {
  $sql = "DROP TABLE IF EXISTS salesman";
  mysqli_query($db, $sql);

  $sql = "CREATE TABLE salesman
          (
            salecode CHAR(2) NOT NULL,
            salename CHAR(10),
            salegend CHAR(1),
            innndate CHAR(10),
            salearea CHAR(20),
            PRIMARY KEY(salecode)
          )";
  mysqli_query($db, $sql);
  $msg = '판매원마스터 테이블 생성 완료';
  $url = 'index.php';
  sendMsg($msg, $url);
}

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>판매원마스터 생성</h3>
<hr>
<!-- contents -->
<span class="red">
<b>판매원마스터 테이블을 생성하시겠습니까?</b>
</span>
<br><br>

<input type="button" value="Yes"
  onclick="location.href='salesman_create.php?create=true'">
<input type="button" value="No"
  onclick="location.href='index.php'">

<!-- contents -->
<?php
  include 'includes/_footer.php';
?>