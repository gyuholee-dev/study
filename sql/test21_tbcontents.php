<h3><?=$title?></h3>
<hr>
<div class="tbContents">
    <?php
        if ($action != 'delete') {
            include $id.'_tbmenu.php';
        } 
    ?>
    <table class="<?=$action?>" 
        cellpadding="3" cellspacing="0" border="1">
    <?php
        echo '<tr>';
        // echo '<th>'.$nameSpace['serl'].'</th>';
        // echo '<th>'.$nameSpace['numb'].'</th>';
        echo '<th width="60">'.$nameSpace['numb_name'].'</th>';
        echo '<th width="100">'.$nameSpace['date'].'</th>';
        echo '<th width="50">'.$nameSpace['days'].'</th>';
        // echo '<th>'.$nameSpace['plce'].'</th>';
        echo '<th width="60">'.$nameSpace['plce_name'].'</th>';
        echo '<th width="120">'.$nameSpace['purp'].'</th>';
        echo '<th width="80">'.$nameSpace['tran'].'</th>';
        echo '<th width="80">'.$nameSpace['food'].'</th>';
        echo '<th width="80">'.$nameSpace['etcs'].'</th>';
        echo '<th width="50">'.$nameSpace['comp'].'</th>';
        if ($action == 'edit') {
            echo '<th width="50">수정</th>';
            echo '<th width="50">삭제</th>';
        }
        echo '</tr>';

        while ($a = mysqli_fetch_assoc($res)) {
            $days = $a['days'].'일';
            $tran = number_format($a['tran']).'원';
            $food = number_format($a['food']).'원';
            $etcs = number_format($a['etcs']).'원';
            if ($a['comp'] == 'Y') $comp = '있음';
            elseif ($a['comp'] == 'N') $comp = '없음';

            $urlParam = $primeKey.'='.$a[$primeKey];
            $urlParam = getURLParam(false, $urlParam);
            $updateUrl = $id.'_update.php'.$urlParam;
            $deleteUrl = $id.'_delete.php'.$urlParam;

            echo '<tr>';
            // echo '<td>'.$a['numb'].'</td>';
            echo '<td>'.$a['numb_name'].'</td>';
            echo '<td>'.$a['date'].'</td>';
            echo '<td class="right">'.$days.'</td>';
            // echo '<td>'.$a['plce'].'</td>';
            echo '<td>'.$a['plce_name'].'</td>';
            echo '<td class="left">'.$a['purp'].'</td>';
            echo '<td class="right">'.$tran.'</td>';
            echo '<td class="right">'.$food.'</td>';
            echo '<td class="right">'.$etcs.'</td>';
            echo '<td>'.$comp.'</td>';
            if ($action == 'edit') {
                echo '<td><a href="'.$updateUrl.'">수정</a></td>';
                echo '<td><a href="'.$deleteUrl.'">삭제</a></td>';
            }
            echo '</tr>';

        }
    ?>   
    </table>

    <div class="tbMenu">
    <?php
        if ($action != 'delete') {
            for ($i=1; $i<=$pages; $i++) {
                echo '<span class="page">';
                if ($i == $page) {
                    echo "<b>$i</b>";
                } else {
                    echo '[<a href="'.$id.'_'.$action.'.php?items='.$items.'&page='.$i.
                        '&where='.$where.'&sort='.$sort.'&order='.$order.'">'.$i.'</a>]';
                }
                echo '</span>';
            }
        }
    ?>
    </div>
</div>