<?php
    // echo $_SERVER['REQUEST_URI'];
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
        if ('test18_'.$key.'.php' == $thisFile) {
            $classes[$key] = 'class ="selected"';
        }
    }

    $urlParam = getURLParam();

?>
<input type="button" value="생성"
    <?=$classes['create']?>
    onclick="location.href='test18_create.php<?=$urlParam?>'">
<input type="button" value="백업"
    <?=$classes['backup']?>
    onclick="location.href='test18_backup.php<?=$urlParam?>'">
<input type="button" value="입력"
    <?=$classes['insert']?>
    onclick="location.href='test18_insert.php<?=$urlParam?>'">
<input type="button" value="조회"
    <?=$classes['select']?>
    onclick="location.href='test18_select.php<?=$urlParam?>'">
<input type="button" value="수정"
    <?=$classes['update']?>
    onclick="location.href='test18_update.php<?=$urlParam?>'">
<input type="button" value="삭제"
    <?=$classes['delete']?>
    onclick="location.href='test18_delete.php<?=$urlParam?>'">