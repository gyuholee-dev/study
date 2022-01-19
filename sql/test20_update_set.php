<?php
require 'include/global.php';

// param
$mode = 'UPDATE';
$title = '교육 수정';
$file = 'test20_update_set.php';
$table = 'educ';
$target = 'seqn';

$items = $_REQUEST['items'];
$page = $_REQUEST['page'];
$where = $_REQUEST['where'];
$sort = $_REQUEST['sort'];
$order = $_REQUEST['order'];

$targetVal = $_REQUEST[$target];

$urlParam = 'items='.$items.'&page='.$page.'&where='.$where.'&sort='.$sort.'&order='.$order;
$backUrl = 'test20_update.php?'.$urlParam;

if (isset($_POST['update'])) {

    // $seqn = $_POST['seqn'];
    $numb = $_POST['numb'];
    $date = $_POST['date'];
    $hour = $_POST['hour'];
    $educ = $_POST['educ'];
    $kind = $_POST['kind'];
    $auth = $_POST['auth'];
    $plce = $_POST['plce'];
    $targetVal = $_REQUEST[$target];

    $sql = "UPDATE $table
            SET numb = '$numb',
                date = '$date',
                hour = '$hour',
                educ = '$educ',
                kind = '$kind',
                auth = '$auth',
                plce = '$plce'
            WHERE $target = '$targetVal'";
    echo $sql.'<br>';
    mysqli_query($db, $sql);
    $msg = '교육 수정 완료';
    $url = $backUrl;
    sendMsg($msg, $url);
}

// $sql ="SELECT MAX(seqn) FROM educ";
// $res = mysqli_query($db, $sql);
// $maxSeqn = mysqli_fetch_row($res)[0];

$sql = "SELECT * FROM educ WHERE $target='$targetVal'";
$res = mysqli_query($db, $sql);
$preData = array();
while ($a = mysqli_fetch_assoc($res)) {
    foreach ($a as $key => $value) {
        $preData[$key] = $value;
    }
}

// $deptList = getAllRecords('dept');
$sql = "SELECT * FROM code WHERE cod1 = '13'";
$plceList = mysqli_query($db, $sql);
$sql = "SELECT numb, name FROM empl ORDER BY name";
$numbList = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
    include 'test20_header.php';
?>
<h3><?=$title?></h3>
<hr>

<div class="tbContents">
<form method="post"action="<?=$file?>" autocomplete="off">
    <table class="<?=$mode?>" cellpadding="3" cellspacing="0" border="1">
    <tr>
        <th>교육명</th>
        <td>
            <input type="text" name="educ" value="<?=$preData['educ']?>"
            required maxlength="30" placeholder="<?=$preData['educ']?>">
            <input type="hidden" name="items" value="<?=$items?>">
            <input type="hidden" name="page" value="<?=$page?>">
            <input type="hidden" name="where" value="<?=$where?>">
            <input type="hidden" name="sort" value="<?=$sort?>">
            <input type="hidden" name="order" value="<?=$order?>">
            <input type="hidden" name="<?=$target?>" value="<?=$targetVal?>">
        </td>
    </tr>
    <tr>
        <th>교육일자</th>
        <td>
            <input type="date" name="date" value="<?=$preData['date']?>"
            required maxlength="10">
        </td>
    </tr>
    <tr>
        <th>교육시간</th>
        <td>
            <input type="number" name="hour" value="<?=$preData['hour']?>"
            required max="99" placeholder="<?=$preData['hour']?>">
        </td>
    </tr>
    <tr>
        <th>교육구분</th>
        <td>
            <?php
                $checked = array('D'=>'', 'F'=>'');
                $checked[$preData['kind']] = 'checked';
            ?>
            <label><input type="radio" name="kind" value="D" <?=$checked['D']?>>의무</label>
            <label><input type="radio" name="kind" value="F" <?=$checked['F']?>>선택</label>
        </td>
    </tr>
    <tr>
        <th>시행기관</th>
        <td>
            <input type="text" name="auth" value="<?=$preData['auth']?>"
            required maxlength="30" placeholder="<?=$preData['auth']?>">
        </td>
    </tr>
    <tr>
        <th>교육장소</th>
        <td>
            <select name="plce">
            <?php
                while ($a = mysqli_fetch_row($plceList)) {
                    echo '<option value="'.$a[1].'"';
                    if ($preData['plce'] == $a[1]) echo ' selected';
                    echo '>'.$a[2].'</option>';
                }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <th>사원명</th>
        <td>
            <select name="numb">
            <?php
                while ($a = mysqli_fetch_row($numbList)) {
                    echo '<option value="'.$a[0].'"';
                    if ($preData['numb'] == $a[0]) echo ' selected';
                    echo '>'.$a[1].'</option>';
                }
            ?>
            </select>
        </td>
    </tr>

    </table>
    
    <div class="tbMenu">
        <input type="submit" name="update" value="입력">
        <input type="reset" value="취소">
        <input type="button" value="뒤로" onclick="location.href='<?=$backUrl?>'">
    </div>
</form>
</div>

<hr>
<?php
    include 'test20_menu.php';
?> 
<?php
    include 'test20_footer.php';
?>