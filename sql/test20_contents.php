<h3><?=$title?></h3>
<hr>

<div class="tbContents">
    <?php
        if ($mode != 'RECORD') {
            include 'test20_tbMenu.php';
        } 
    ?>
    <table class="<?=$mode?>" cellpadding="3" cellspacing="0" border="1">
        <tr>
            <th width="60">사원명</th>
            <th width="95">교육일자</th>
            <th width="75">교육시간</th>
            <th width="130">교육명</th>
            <th width="75">교육구분</th>
            <th width="108">시행기관</th>
            <th width="75">교육장소</th>
            <?php 
                if ($mode == 'DELETE') {
                    echo '<th width="60">삭제</th>';
                } elseif ($mode == 'UPDATE') {
                    echo '<th width="60">수정</th>';
                } 
            ?>
        </tr>
    <?php
        while ($a = mysqli_fetch_assoc($res)) {
            if ($a['kind'] == 'D') { $kind = '의무'; } 
            elseif ($a['kind'] == 'F') {  $kind = '선택'; }

            echo '<tr>';
            echo '<td>'.$a['numb_name'].'</td>';
            echo '<td>'.$a['date'].'</td>';
            echo '<td>'.$a['hour'].'</td>';
            echo '<td>'.$a['educ'].'</td>';
            echo '<td>'.$kind.'</td>';
            echo '<td>'.$a['auth'].'</td>';
            echo '<td>'.$a['plce_name'].'</td>';
            if ($mode == 'DELETE') {
                $fileName = explode('.', $file)[0];
                $toFile = $fileName.'_del.php';
                echo '<td>';
                echo '<a href="'.$toFile.'?'.$target.'='.$a['seqn'].'&items='.$items.'&page='.$page.
                     '&where='.$where.'&sort='.$sort.'&order='.$order.'">삭제</a>';
                echo '</td>';
            } elseif ($mode == 'UPDATE') {
                $fileName = explode('.', $file)[0];
                $toFile = $fileName.'_set.php';
                echo '<td>';
                echo '<a href="'.$toFile.'?'.$target.'='.$a['seqn'].'&items='.$items.'&page='.$page.
                     '&where='.$where.'&sort='.$sort.'&order='.$order.'">수정</a>';
                echo '</td>';

            }
            echo '</tr>';
        }
    ?>
    </table>
    
    <div class="tbMenu">
    <?php
        if ($mode != 'RECORD') {
            for ($i=1; $i<=$pages; $i++) {
                echo '<span class="page">';
                if ($i == $page) {
                    echo "<b>$i</b>";
                } else {
                    echo '[<a href="'.$file.'?items='.$items.'&page='.$i.
                        '&where='.$where.'&sort='.$sort.'&order='.$order.'">'.$i.'</a>]';
                }
                echo '</span>';
            }
        }
    ?>
    </div>

</div>
