<div class="tbMenu">
        <table class="inner" width="100%">
        <tr><td class="left">
        <form method="get" action="<?=$file?>">

            <label>항목수 <input type="number" max=99 name="items" value="<?=$items?>"
            style="width: 40px;"></label>
            
            <label style="margin-left:10px;">선택 <select name="where" style="width: 160px;">
                <?php                    
                    echo '<option value="">전체</option>';
                    foreach ($educList as $key => $value) {
                        echo '<option value="'.$value.'"';
                        if ($where == $value) echo ' selected';
                        echo '>'.$value.'</option>';
                    }
                ?>
            </select></label>

            <label style="margin-left:10px;">정렬 <select name="sort" style="width: 110px;">
                <?php
                    $sortOp = array('seqn'=>'','numb_name'=>'','date'=>'','hour'=>'','educ'=>'','kind'=>'','auth'=>'','plce'=>'');
                    $sortOp[$sort] = 'selected';
                ?>
                <option value="seqn" <?=$sortOp['seqn']?>>등록순서</option>
                <option value="numb_name" <?=$sortOp['numb_name']?>>사원명</option>
                <option value="date" <?=$sortOp['date']?>>교육일자</option>
                <option value="hour" <?=$sortOp['hour']?>>교육시간</option>
                <option value="educ" <?=$sortOp['educ']?>>교육명</option>
                <option value="kind" <?=$sortOp['kind']?>>교육구분</option>
                <option value="auth" <?=$sortOp['auth']?>>시행기관</option>
                <option value="plce" <?=$sortOp['plce']?>>교육장소</option>
            </select></label>

            <?php
                $orderOp = array('asc'=>'', 'desc'=>'');
                $orderOp[$order] = 'checked';
            ?>
            <label><input type="radio" name="order" value="asc" <?=$orderOp['asc']?>>정</label>
            <label><input type="radio" name="order" value="desc" <?=$orderOp['desc']?>>역</label>
            <?php // echo '<input type="hidden" name="page" value="'.$page.'">'; ?>
            <input type="submit" value="입력">

        </form>
        </td><td class="right">
            <input type="button" value="초기화"
            onclick="location.href='<?=$file?>'">
        </td></tr>
        </table>
    </div>