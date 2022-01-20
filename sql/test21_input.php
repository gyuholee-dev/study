<div class="tbContents">
<form method="post"action="<?=$id?>_<?=$action?>.php" autocomplete="off">
    <table class="<?=$action?>" cellpadding="3" cellspacing="0" border="1">
    <tr>
        <th><?=$nameSpace['numb_name']?></th>
        <td>
            <input type="hidden" name="serl" 
                value="<?=$preData['serl']?>">
            <select name="numb">
            <?php
                while ($a = mysqli_fetch_assoc($emplList)) {
                    echo '<option value="'.$a['numb'].'">'.$a['name'].'</option>';
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
        <th><?=$nameSpace['days']?></th>
        <td>
            <input type="number" name="days" 
                value="<?php if ($action=='update') echo $preData['days']?>"
                placeholder="<?=$preData['days']?>"
                required max="99">
        </td>
    </tr>
    <tr>
        <th><?=$nameSpace['plce']?></th>
        <td>
            <select name="plce">
            <?php
                while ($a = mysqli_fetch_assoc($plceList)) {
                    echo '<option value="'.$a['cod2'].'">'.
                          $a['name'].'</option>';
                }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <th><?=$nameSpace['purp']?></th>
        <td>
            <input type="text" name="purp" 
                value="<?php if ($action=='update') echo $preData['purp']?>"
                placeholder="<?=$preData['purp']?>"
                required maxlength="30">
        </td>
    </tr>
    <tr>
        <th><?=$nameSpace['tran']?></th>
        <td>
            <input type="number" name="tran" 
                value="<?php if ($action=='update') echo $preData['tran']?>"
                placeholder="<?=$preData['tran']?>"
                required max="10000000">
        </td>
    </tr>
    <tr>
        <th><?=$nameSpace['food']?></th>
        <td>
            <input type="number" name="food" 
                value="<?php if ($action=='update') echo $preData['food']?>"
                placeholder="<?=$preData['food']?>"
                required max="10000000">
        </td>
    </tr>
    <tr>
        <th><?=$nameSpace['etcs']?></th>
        <td>
            <input type="number" name="etcs" 
                value="<?php if ($action=='update') echo $preData['etcs']?>"
                placeholder="<?=$preData['etcs']?>"
                required max="10000000">
        </td>
    </tr>
    <tr>
        <th><?=$nameSpace['comp']?></th>
        <td>
            <label><input type="radio" name="comp" value="Y" checked>있음</label>
            <label><input type="radio" name="comp" value="Y">없음</label>
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