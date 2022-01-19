<?php
require 'include/global21.php';

$action = 'create';
$title = $tableName.' 생성';

if (isset($_REQUEST['reply']) && $_REQUEST['reply'] == 'y') {
    $sql = "DROP TABLE IF EXISTS $table";
    // echo $sql;
    mysqli_query($db, $sql);

    $sql = "CREATE TABLE $table
            (
              serl INT AUTO_INCREMENT,
              numb CHAR(4),
              date CHAR(10),
              days INT,
              plce CHAR(2),
              purp CHAR(30),
              tran INT,
              food INT,
              etcs INT,
              comp CHAR(1),
              PRIMARY KEY(serl)            
            )";
    // echo $sql;
    mysqli_query($db, $sql);

    $msg = $title.' 완료';
    $url = $id.'.php';
    sendMsg($msg, $url);
}

?>
<!-- html -->
<?php
    include $id.'_header.php';
?>
<h3><?=$title?></h3>
<hr>
<span class="red"><b><?=$tableName?> 테이블을 생성하시겠습니까?</b></span>
<br><br>
<input type="button" value="Yes" onclick="location.href='<?=$id?>_create.php?reply=y'">
<input type="button" value="No" onclick="location.href='<?=$id?>.php'">

<?php
    // include $id.'_menu.php';
?> 
<?php
    include $id.'_footer.php';
?>