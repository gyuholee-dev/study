<?php
require 'include/global21.php';

$action = 'delete';
$title = $tableName.' 삭제';

if (isset($_POST['delete'])) {
    $target = $_POST[$primeKey];

    $sql = "DELETE FROM $table
            WHERE $primeKey='$target'";
    // echo $sql;
    mysqli_query($db, $sql);

    $msg = $title.' 완료';
    $url = $id.'_edit.php'.getURLParam($primeKey);
    sendMsg($msg, $url);
}

include $id.'_start.php';
?>
<!-- html -->
<?php
    include $id.'_header.php';
?>
<!-- tbcontents -->
<?php
    include $id.'_tbcontents.php';
?>
<!-- tbcontents -->
<?php

?>
    <span class="red"><b><?=trim($whereSql)?> 레코드를 삭제하시겠습니까?</b></span>
    <br><br>
    <form method="post" action="<?=$id?>_delete.php<?=getURLParam($primeKey)?>">
        <input type="hidden" name="<?=$primeKey?>" value="<?=$target?>">
        <input type="submit" name="delete" value="예">
        <input type="button" value="아니오" 
        onclick="location.href='<?=$id?>_edit.php<?=getURLParam($primeKey)?>'">
    </form>
    <br>
<hr>
<?php
    include $id.'_menu.php';
?> 
<?php
    include $id.'_footer.php';
?>