<?php

    $tableExist = tableExist($table);

    $filename = explode('.', getThisFile())[0];

    $classes = array(
               'create' => '',
               'backup' => '',
               'insert' => '',
               'select' => '',
               'edit' => '',
               'update' => '',
               'delete' => ''
               );
    foreach ($classes as $key => $value) {
        if ($key == $filename) {
            $classes[$key] = 'class ="selected"';
        }
    }
    if ($classes['update'] || $classes['delete']) {
        $classes['edit'] = 'class ="selected"';
    }

    $urlParam = getURLParam($primeKey);

?>
<input type="button" value="조회"
    <?=$classes['select']?>
    onclick="location.href='select.php<?=$urlParam?>'"
    <?if(!$tableExist)echo' disabled';?>>

<input type="button" value="생성"
    <?=$classes['create']?>
    onclick="location.href='create.php<?=$urlParam?>'">

<input type="button" value="입력"
    <?=$classes['insert']?>
    onclick="location.href='insert.php<?=$urlParam?>'"
    <?if(!$tableExist)echo' disabled';?>>

<input type="button" value="편집"
    <?=$classes['edit']?>
    onclick="location.href='edit.php<?=$urlParam?>'"
    <?if(!$tableExist)echo' disabled';?>>
