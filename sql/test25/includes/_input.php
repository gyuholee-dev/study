<div class="tbContents">
<form method="post" action="" autocomplete="off">
    <table class="<?=$action?>" cellpadding="3" cellspacing="0" border="1">
    <?php
        foreach ($tableData as $key => $value) {
            if (count($value['input']) == 0) continue;
            echo '<tr>';
            echo '<th>'.$nameSpace[$key].'</th>';
            echo '<td>';    
            foreach ($value['input'] as $k => $val) {
                if (isset($val['label'])) {
                    echo '<label>';
                }
                echo '<input ';
                echo 'type="'.$val['type'].'" ';
                echo 'name="'.$key.'" ';

                if ($action == 'update' || $key == $primeKey || isDate($preData[$key])) {
                    if (isset($val['value'])) {
                        echo 'value="'.$val['value'].'" ';
                    } else {
                        echo 'value="'.$preData[$key].'" ';
                    }
                } else {
                    echo 'placeholder="'.$preData[$key].'" ';
                }
                
                if ($val['type'] == 'text') {
                    echo 'maxlength="'.$value['length'].'" ';
                }
                if ($val['type'] == 'radio') {
                    if ($preData[$key] == $val['value']) {
                        echo 'checked ';
                    } elseif ($k == 0) {
                        echo 'checked ';
                    }
                }
                if (isset($val['attr'])) {
                    echo $val['attr'].' ';
                }
                echo '>';
                if (isset($val['label'])) {
                    echo $val['label'];
                    echo '</label>';
                }
            }
            echo '</td>';
            echo '</tr>';
        }
    ?>   
    </table>

    <div class="tbMenu">
        <input type="submit" name="insert" value="입력">
        <input type="reset" value="취소">
        <input type="button" value="메뉴" onclick="location.href='start.php'">
    </div>

</form>
</div>