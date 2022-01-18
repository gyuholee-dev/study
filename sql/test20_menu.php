<?php
    $flleName = 'test20';
    $thisFile = getThisFile();

    $classes = array(
            'create' => '',
            'backup' => '',
            'insert' => '',
            'select' => '',
            'update' => '',
            'delete' => ''
            );
    foreach ($classes as $key => $value) {
        if ($flleName.'_'.$key.'.php' == $thisFile) {
            $classes[$key] = 'class ="selected"';
        } elseif ($flleName.'_'.$key.'_set.php' == $thisFile) {
            $classes[$key] = 'class ="selected"';
        }
    }

    $urlParam = getURLParam('numb');

?>
<input type="button" value="생성"
    <?=$classes['create']?>
    onclick="location.href='<?=$flleName?>_create.php<?=$urlParam?>'">
<input type="button" value="백업"
    <?=$classes['backup']?>
    onclick="location.href='<?=$flleName?>_backup.php<?=$urlParam?>'">
<input type="button" value="입력"
    <?=$classes['insert']?>
    onclick="location.href='<?=$flleName?>_insert.php<?=$urlParam?>'">
<input type="button" value="조회"
    <?=$classes['select']?>
    onclick="location.href='<?=$flleName?>_select.php<?=$urlParam?>'">
<input type="button" value="수정"
    <?=$classes['update']?>
    onclick="location.href='<?=$flleName?>_update.php<?=$urlParam?>'">
<input type="button" value="삭제"
    <?=$classes['delete']?>
    onclick="location.href='<?=$flleName?>_delete.php<?=$urlParam?>'">