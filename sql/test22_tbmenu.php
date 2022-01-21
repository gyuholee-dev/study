<div class="tbMenu">
    <script>
        function changeView() {
            var form = document.getElementById('tbmenu');
            form.submit();
        }
    </script>
    <table class="inner" width="100%">
    <tr><td class="left">
    <form id="tbmenu" method="get" action="<?=$id.'_'.$action.'.php'?>">

        <label>항목수 
            <input type="number" min="1" max="99" name="items" value="<?=$items?>"
            style="width: 40px;" onchange="changeView()"></label>
        
        <label style="margin-left:10px;">선택 
        <select name="where" style="width: 120px;" onchange="changeView()">
            <?php
                $whereName = '';
                echo '<option value="">전체</option>';
                $sql = "SELECT numb AS empl, name AS empl_name FROM empl ORDER BY name";
                $emplList = mysqli_query($db, $sql);
                while ($a = mysqli_fetch_assoc($emplList)) {
                    echo '<option value="'.$a['empl'].'"';
                    if ($where == $a['empl']) {
                        echo ' selected';
                        $whereName = $a['empl_name'];
                    }
                    echo '>'.$a['empl_name'].'</option>';
                }
            ?>
        </select></label>

        <label style="margin-left:10px;">정렬 
        <select name="sort" style="width: 140px;" onchange="changeView()">
            <?php
                $sortOp = array();
                foreach ($nameSpace as $key => $value) {
                    $sortOp[$key] = '';
                }
                $sortOp[$sort] = 'selected';

                // echo '<option value="seqn" '.$sortOp['seqn'].'>'.$nameSpace['seqn'].'</option>';
                // echo '<option value="empl" '.$sortOp['empl'].'>'.$nameSpace['empl'].'</option>';
                echo '<option value="empl_name" '.$sortOp['empl_name'].'>'.$nameSpace['empl_name'].'</option>';
                echo '<option value="date" '.$sortOp['date'].'>'.$nameSpace['date'].'</option>';
                echo '<option value="kind" '.$sortOp['kind'].'>'.$nameSpace['kind'].'</option>';
                echo '<option value="code" '.$sortOp['code'].'>'.$nameSpace['code_name'].'</option>';
                echo '<option value="resn" '.$sortOp['resn'].'>'.$nameSpace['resn'].'</option>';
                echo '<option value="remk" '.$sortOp['remk'].'>'.$nameSpace['remk'].'</option>';
            ?>
        </select></label>

        <?php
            $orderOp = array('asc'=>'', 'desc'=>'');
            $orderOp[$order] = 'checked';
        ?>
        <label><input type="radio" name="order" value="asc" 
               <?=$orderOp['asc']?> onchange="changeView()">정</label>
        <label><input type="radio" name="order" value="desc" 
               <?=$orderOp['desc']?> onchange="changeView()">역</label>
        <input type="submit" value="입력" style="display:none;">

    </form>
    </td><td class="right">
        <input type="button" value="초기화"
        onclick="location.href='<?=$id.'_'.$action.'.php'?>'">
    </td></tr>
    </table>
</div>