<?php
require 'include/global.php';

if (isset($_REQUEST['reply']) && $_REQUEST['reply'] == 'y') {
    $sql = "DROP TABLE IF EXISTS empl";
    mysqli_query($db, $sql);

    $sql = "CREATE TABLE empl
            (
              numb CHAR(4) NOT NULL,
              name CHAR(15), 
              gend CHAR(1),
              dept CHAR(2),
              grad CHAR(2),
              entr CHAR(10),
              phon CHAR(13),
              bord CHAR(1),
              PRIMARY KEY(numb)
            )";
    mysqli_query($db, $sql);

    $msg = '인사명부 테이블 생성 완료';
    $url = 'test18.php';
    sendMsg($msg, $url);
}

?>
<!-- html -->
<?php
    include 'test18_header.php';
?>
<h3>인사명부 생성</h3>
<hr>
<span class="red"><b>인사명부 테이블을 생성하시겠습니까?</b></span>
<br><br>
<input type="button" value="Yes" onclick="location.href='test18_create.php?reply=y'">
<input type="button" value="No" onclick="location.href='test18.php'">


<?php
    include 'test18_footer.php';
?>