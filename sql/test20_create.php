<?php
require 'include/global.php';

if (isset($_REQUEST['reply']) && $_REQUEST['reply'] == 'y') {
    $sql = "DROP TABLE IF EXISTS educ";
    mysqli_query($db, $sql);

    $sql = "CREATE TABLE educ
            (
              seqn INT AUTO_INCREMENT,
              numb CHAR(4),
              date CHAR(10),
              hour INT,
              educ CHAR(30),
              kind CHAR(1),
              auth CHAR(30),
              plce CHAR(2),
              PRIMARY KEY(seqn)
            )";
    // echo $sql;
    mysqli_query($db, $sql);

    $msg = '교육 테이블 생성 완료';
    $url = 'test20.php';
    sendMsg($msg, $url);
}

?>
<!-- html -->
<?php
    include 'test20_header.php';
?>
<h3>교육 생성</h3>
<hr>
<span class="red"><b>교육 테이블을 생성하시겠습니까?</b></span>
<br><br>
<input type="button" value="Yes" onclick="location.href='test20_create.php?reply=y'">
<input type="button" value="No" onclick="location.href='test20.php'">


<?php
    include 'test20_footer.php';
?>