<?php
require 'include/global.php';

if (isset($_REQUEST['reply']) && $_REQUEST['reply'] == 'y') {
    $sql = "DROP TABLE IF EXISTS ordr";
    mysqli_query($db, $sql);
    $sql = "CREATE TABLE ordr
            (
              numb CHAR(3) NOT NULL,
              item CHAR(40),
              kind CHAR(1),
              date CHAR(10),
              prce INT,
              qntt INT,
              dept CHAR(2),
              stat CHAR(1),
              PRIMARY KEY(numb)
            )";
    mysqli_query($db, $sql);

    $msg = '주문요구서 테이블 생성 완료';
    $url = 'test16.php';
    sendMsg($msg, $url);
}
?>

<!-- html -->
<?php
    include 'test16_header.html';
?>
<h3>주문요구서 생성</h3>
<hr>
<span class="red"><b>주문요구서 테이블을 새로 생성하겠습니까?</b></span>
<br><br>
<input type="button" value="Yes" onclick="location.href='test16_create.php?reply=y'">
<input type="button" value="No" onclick="location.href='test16.php'">
<?php
    // include 'test16_footer.html';
?>