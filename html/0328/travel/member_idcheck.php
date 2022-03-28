<?php
  $host = "localhost";
  $user = "root";
  $pass = "";
  $db = mysqli_connect($host, $user, $pass);
  mysqli_select_db($db, "testdb");

  $id = $_GET['id'];
  $sql = "SELECT id FROM member WHERE id = '$id' ";
  $res = mysqli_query($db, $sql);
  $cnt = mysqli_num_rows($res);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ID CHECK</title>
</head>
<body>
  <div>
    <?php
      if ($cnt == 0) {
        echo "
          <b>사용가능한 아이디입니다</b>
          <a href='javascript:send_ok()'>
            <font color='orange'>사용하기</font>
          </a>
        ";
      } else {
        echo "
          <b>사용중인 아이디입니다</b>
          <a href='javascript:send_fail()'>
            <font color='orange'>새로작성</font>
          </a>
        ";
      }
    ?>
  </div>

  <script>
    function send_ok() {
      opener.document.frm1.pw1.focus();
      opener.document.frm1.idcheked.value=true;
      self.close();
    }
    function send_fail() {
      opener.document.frm1.id.value='';
      opener.document.frm1.id.focus();
      self.close();
    }
  </script>

</body>
</html>