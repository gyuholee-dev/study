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
            <input type="number" max=99 name="items" value="<?=$items?>"
            style="width: 40px;" onchange="changeView()"></label>
        
        <label style="margin-left:10px;">선택 
        <select name="where" style="width: 120px;" onchange="changeView()">
            <?php
                echo '<option value="">전체</option>';
                $sql = "SELECT cod2 AS plce, name AS plce_name FROM code WHERE cod1 = '13'";
                $plceList = mysqli_query($db, $sql);
                while ($a = mysqli_fetch_assoc($plceList)) {
                    echo '<option value="'.$a['plce'].'"';
                    if ($where == $a['plce']) echo ' selected';
                    echo '>'.$a['plce_name'].'</option>';
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

                // echo '<option value="serl" '.$sortOp['serl'].'>'.$nameSpace['serl'].'</option>';
                // echo '<option value="numb" '.$sortOp['numb'].'>'.$nameSpace['numb'].'</option>';
                echo '<option value="numb_name" '.$sortOp['numb_name'].'>'.$nameSpace['numb_name'].'</option>';
                echo '<option value="date" '.$sortOp['date'].'>'.$nameSpace['date'].'</option>';
                echo '<option value="days" '.$sortOp['days'].'>'.$nameSpace['days'].'</option>';
                // echo '<option value="plce" '.$sortOp['plce'].'>'.$nameSpace['plce'].'</option>';
                echo '<option value="plce_name" '.$sortOp['plce_name'].'>'.$nameSpace['plce_name'].'</option>';
                echo '<option value="purp" '.$sortOp['purp'].'>'.$nameSpace['purp'].'</option>';
                echo '<option value="tran" '.$sortOp['tran'].'>'.$nameSpace['tran'].'</option>';
                echo '<option value="food" '.$sortOp['food'].'>'.$nameSpace['food'].'</option>';
                echo '<option value="etcs" '.$sortOp['etcs'].'>'.$nameSpace['etcs'].'</option>';
                echo '<option value="comp" '.$sortOp['comp'].'>'.$nameSpace['comp'].'</option>';
                echo '<option value="comp" '.$sortOp['comp'].'>'.$nameSpace['comp'].'</option>';
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