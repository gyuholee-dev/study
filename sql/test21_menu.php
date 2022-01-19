<?php
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
        if ($id.'_'.$key.'.php' == $thisFile) {
            $classes[$key] = 'class ="selected"';
        } elseif ($id.'_'.$key.'_set.php' == $thisFile) {
            $classes[$key] = 'class ="selected"';
        }
    }

    if (!isset($target) || $target == '') $target = false;
    $urlParam = getURLParam($target);

?>
<input type="button" value="생성"
    <?=$classes['create']?>
    onclick="location.href='<?=$id?>_create.php<?=$urlParam?>'">
<input type="button" value="백업"
    <?=$classes['backup']?>
    onclick="location.href='<?=$id?>_backup.php<?=$urlParam?>'">
<input type="button" value="입력"
    <?=$classes['insert']?>
    onclick="location.href='<?=$id?>_insert.php<?=$urlParam?>'">
<input type="button" value="조회"
    <?=$classes['select']?>
    onclick="location.href='<?=$id?>_select.php<?=$urlParam?>'">
<input type="button" value="수정"
    <?=$classes['update']?>
    onclick="location.href='<?=$id?>_update.php<?=$urlParam?>'">
<!-- <input type="button" value="삭제"
    <?=$classes['delete']?>
    onclick="location.href='<?=$id?>_delete.php<?=$urlParam?>'"> -->