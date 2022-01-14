<?php
require 'include/global.php';

$numb = $_REQUEST['numb'];
$page = $_REQUEST['page'];
$items = $_REQUEST['items'];

$replyUrl = 'test16_update_set.php?reply=y'.
'&numb='.$numb.'&items='.$items.'&page='.$page;
$backUrl = 'test16_update.php?items='.$items.'&page='.$page;

if (isset($_REQUEST['update'])) {
    $numb = $_POST['numb'];
    $item = $_POST['item'];
    $kind = $_POST['kind'];
    $date = $_POST['date'];
    $prce = $_POST['prce'];
    $qntt = $_POST['qntt'];
    $dept = $_POST['dept'];
    $stat = $_POST['stat'];

    $sql = "UPDATE ordr
            SET numb = '$numb',
                item = '$item',
                kind = '$kind',
                date = '$date',
                prce = '$prce',
                qntt = '$qntt',
                dept = '$dept',
                stat = '$stat'
            WHERE numb = '$numb'";
    echo $sql;
    
    // $sql = "DELETE FROM ordr
    //         WHERE numb = '$numb'";
    // // echo $sql;
    // mysqli_query($db, $sql);

    // $msg = '주문요구서 테이블 수정 완료';
    // $url = $backUrl;
    // sendMsg($msg, $url);
}

$sql = "SELECT * FROM ordr
        WHERE numb = '$numb'";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_assoc($res);

$deptList = getAllRecords('dept');

?>
<!-- html -->
<?php
    include 'test16_header.html';
?>
<h3>주문요구서 수정</h3>
<hr>

<div class="tbContents">
<form method="post" action="test16_update_set.php" autocomplete="off">
    <table cellpadding="3" cellspacing="0" border="1" align="center">
        <tr>
            <th>순번</th>
            <td>
                <input type="text" name="numb" value="<?=$a['numb']?>"
                required maxlength="3" readonly>
                <input type="hidden" name="items" value="<?=$items?>">
                <input type="hidden" name="page" value="<?=$page?>">
            </td>
        </tr>
        <tr>
            <th>물품명</th>
            <td>
                <input type="text" name="item" value="<?=$a['item']?>"
                required maxlength="40">
            </td>
        </tr>
        <tr>
            <th>종류</th>
            <td>
                <?php
                    $checked = array('','');
                    if ($a['kind'] == 'S') { $checked[0] = 'checked'; }
                    elseif ($a['kind'] == 'B') { $checked[1] = 'checked'; };
                ?>
                <label><input type="radio" name="kind" value="S" <?=$checked[0]?>>소모품</label>
                <label><input type="radio" name="kind" value="B" <?=$checked[1]?>>비품</label>
            </td>
        </tr>
        <tr>
            <th>요청일자</th>
            <td>
                <input type="text" name="date" value="<?=$a['date']?>"
                required maxlength="10">
            </td>
        </tr>
        <tr>
            <th>단가</th>
            <td>
                <input type="number" name="prce" value="<?=$a['prce']?>" 
                required max="10000000">
            </td>
        </tr>
        <tr>
            <th>수량</th>
            <td>
                <input type="number" name="qntt" value="<?=$a['qntt']?>" 
                required max="1000">
            </td>
        </tr>
        <tr>
            <th>부서</th>
            <td>
            <select name="dept">
                <?php
                    foreach ($deptList as $key => $value) {
                        $selected = '';
                        if ($a['dept'] == $key) { $selected = 'selected'; }
                        echo '<option value="'.$key.'" '.$selected.'>'.$value[1].'</option>';
                    }
                ?>
            </select>
            </td>
        </tr>
        <tr>
            <th>상태</th>
            <td>
                <?php
                    $checked = array('','');
                    if ($a['stat'] == 'R') { $checked[0] = 'checked'; }
                    elseif ($a['stat'] == 'O') { $checked[1] = 'checked'; };
                ?>
                <label><input type="radio" name="stat" value="R" <?=$checked[0]?>>요청중</label>
                <label><input type="radio" name="stat" value="O" <?=$checked[1]?>>주문중</label>
            </td>
        </tr>
    </table>
    <div class="tbMenu">
        <input type="submit" name="update" value="입력">
        <input type="reset" value="취소">
        <input type="button" value="이전" onclick="location.href='<?=$backUrl?>'">
    </div>
    </form>
</div>
<?php
    // include 'test16_footer.html';
?>
