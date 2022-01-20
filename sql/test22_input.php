<div class="tbContents">
<form method="post"action="<?=$id?>_<?=$action?>.php" autocomplete="off">
    <table class="sub <?=$action?>" cellpadding="3" cellspacing="0" border="1">
    <tr>
        <th><?=$nameSpace['empl_name']?></th>
        <td>
            <input type="hidden" name="seqn" 
                value="<?=$preData['seqn']?>">
            <select name="empl">
            <?php
                while ($a = mysqli_fetch_assoc($emplList)) {
                    $selected = '';
                    if ($preData['empl'] == $a['numb']) $selected = ' selected';
                    echo '<option value="'.$a['numb'].'"'.$selected.'>'.$a['name'].'</option>';
                }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <th><?=$nameSpace['date']?></th>
        <td>
            <input type="date" name="date" 
                value="<?=$preData['date']?>"
                required maxlength="10">
        </td>
    </tr>
    <tr>
        <th><?=$nameSpace['kind']?></th>
        <td>
            <script>
                // TODO: 반복문으로 변경해야 함.
                function changeCode(value) {
                    var select = document.getElementById('codeList');
                    var optionR = select.getElementsByClassName('R'); 
                    var optionP = select.getElementsByClassName('P'); 
                    console.log(optionR);
                    console.log(optionP);
                    if (value == 'R') {
                        optionR.style.display = '';
                        optionP.style.display = 'none';
                    } else if (value == 'P') {
                        optionR.style.display = 'none';
                        optionP.style.display = '';
                    }
                }
            </script>
            <?php
                $checked = array('R'=>'', 'P'=>'');
                $checked[$preData['kind']] = ' checked';
            ?>
            <label><input type="radio" name="kind" value="R"
                <?=$checked['R']?> onchange="changeCode('R')">포상</label>
            <label><input type="radio" name="kind" value="P"
                <?=$checked['P']?> onchange="changeCode('P')">징계</label>
        </td>
    </tr>
    <tr>
        <th><?=$nameSpace['code_name']?></th>
        <td>
            <select name="code" id="codeList">
            <?php
                while ($a = mysqli_fetch_assoc($codeList)) {
                    $class = '';
                    $selected = '';
                    if ($a['cod2'] >= 11 && $a['cod2'] <= 14) $class = 'R';
                    elseif ($a['cod2'] >= 15 && $a['cod2'] <= 19) $class = 'P';
                    if ($preData['code'] == $a['cod2']) $selected = ' selected';
                    echo '<option class="'.$class.'" value="'.$a['cod2'].'"'.$selected.'>'.
                          $a['name'].'</option>';
                }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <th><?=$nameSpace['resn']?></th>
        <td>
            <input type="text" name="resn" 
                value="<?php if ($action=='update') echo $preData['resn']?>"
                placeholder="<?=$preData['resn']?>"
                required maxlength="40">
        </td>
    </tr>
    <tr>
        <th><?=$nameSpace['remk']?></th>
        <td>
            <input type="text" name="remk" 
                value="<?php if ($action=='update') echo $preData['remk']?>"
                placeholder="<?=$preData['remk']?>"
                required maxlength="40">
        </td>
    </tr>

    </table>
    
    <div class="tbMenu">
        <input type="submit" name="<?=$action?>" 
            value="<?if($action=='update') echo'수정'; else echo'입력';?>">
        <input type="reset" value="취소">
        <?php if ($action == 'update') { ?>
            <input type="button" value="뒤로"
            onclick="location.href='<?=$id?>_edit.php<?=getURLParam($primeKey)?>'">
        <?php } else { ?>
            <input type="button" value="메뉴" 
            onclick="location.href='<?=$id?>_select.php<?=getURLParam($primeKey)?>'">
        <?php } ?>
    </div>
</form>
</div>