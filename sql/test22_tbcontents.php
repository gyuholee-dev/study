<h3><?=$title?></h3>
<hr>
<div class="tbContents">
    <?php
        if ($action != 'delete') {
            include $id.'_tbmenu.php';
        } 
    ?>
    <table class="main <?=$action?>">
    <?php
        echo '<tr>';
        // echo '<th>'.$nameSpace['seqn'].'</th>';
        // echo '<th>'.$nameSpace['empl'].'</th>';
        echo '<th width="60">'.$nameSpace['empl_name'].'</th>';
        echo '<th width="110">'.$nameSpace['date'].'</th>';
        echo '<th width="50">'.$nameSpace['kind'].'</th>';
        // echo '<th>'.$nameSpace['code'].'</th>';
        echo '<th width="120">'.$nameSpace['code_name'].'</th>';
        echo '<th width="120">'.$nameSpace['resn'].'</th>';
        echo '<th width="120">'.$nameSpace['remk'].'</th>';
        if ($action == 'edit') {
            echo '<th width="50">수정</th>';
            echo '<th width="50">삭제</th>';
        }
        echo '</tr>';
        if ($rowCount > 0) {
            while ($a = mysqli_fetch_assoc($res)) {
                if ($a['kind'] == 'R') $kind = '포상';
                elseif ($a['kind'] == 'P') $kind = '징계';

                $urlParam = $primeKey.'='.$a[$primeKey];
                $urlParam = getURLParam(false, $urlParam);
                $updateUrl = $id.'_update.php'.$urlParam;
                $deleteUrl = $id.'_delete.php'.$urlParam;

                echo '<tr>';
                // echo '<td>'.$a['empl'].'</td>';
                echo '<td>'.$a['empl_name'].'</td>';
                echo '<td>'.$a['date'].'</td>';
                echo '<td>'.$kind.'</td>';
                // echo '<td>'.$a['code'].'</td>';
                echo '<td>'.$a['code_name'].'</td>';
                echo '<td>'.$a['resn'].'</td>';
                echo '<td>'.$a['remk'].'</td>';
                if ($action == 'edit') {
                    echo '<td><a href="'.$updateUrl.'">수정</a></td>';
                    echo '<td><a href="'.$deleteUrl.'">삭제</a></td>';
                }
                echo '</tr>';
            }
        } else {
            $conspan = 5;
            echo '<tr>';
            echo "<td>$whereName</td>";
            echo "<td colspan=\"$conspan\">결과가 없습니다</td>";
            if ($action == 'edit') {
                echo '<td>-</td>';
                echo '<td>-</td>';
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