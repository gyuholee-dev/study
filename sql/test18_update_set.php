<?php
require 'include/global.php';

$items = $_REQUEST['items'];
$page = $_REQUEST['page'];
$sort = $_REQUEST['sort'];
$order = $_REQUEST['order'];

$numb = $_REQUEST['numb'];

if (isset($_POST['update'])) {
    $numb = $_POST['numb'];
    $name = $_POST['name'];
    $gend = $_POST['gend'];
    $dept = $_POST['dept'];
    $grad = $_POST['grad'];
    $entr = $_POST['entr'];
    $phon = $_POST['phon'];
    $bord = $_POST['bord'];

    $sql = "UPDATE empl
            SET name = '$name',
                gend = '$gend',
                dept = '$dept',
                grad = '$grad',
                entr = '$entr',
                phon = '$phon',
                bord = '$bord'
            WHERE numb = '$numb'";
    // echo $sql;
    mysqli_query($db, $sql);
    $msg = '인사명부 수정 완료';
    $url = 'test18_update.php'.getURLParam('numb');
    sendMsg($msg, $url);
} 

$deptList = getAllRecords('dept');
$sql = "SELECT * FROM code WHERE cod1 = '11' ORDER BY cod2 DESC";
$gradList = mysqli_query($db, $sql);


$sql = "SELECT * FROM empl WHERE numb ='$numb'";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_assoc($res);

$numb = $a['numb'];
$name = $a['name'];
$gend = $a['gend'];
$dept = $a['dept'];
$grad = $a['grad'];
$entr = $a['entr'];
$phon = $a['phon'];
$bord = $a['bord'];

?>
<!-- html -->
<?php
    include 'test18_header.php';
?>
<h3>인사명부 수정</h3>
<hr>

<div class="tbContents">
<form method="post"action="test18_update_set.php<?=getURLParam()?>" autocomplete="off">
    <table cellpadding="3" cellspacing="0" border="1">
    <tr>
        <th>사원번호</th>
        <td>
            <input type="text" name="numb" value="<?=$numb?>"
            required maxlength="4" readonly>
        </td>
    </tr>
    <tr>
        <th>성명</th>
        <td>
            <input type="text" name="name" value="<?=$name?>"
            required maxlength="15" placeholder="홍길동">
        </td>
    </tr>
    <tr>
        <th>성별</th>
        <td>
            <?php
                $checked = array('M' => '', 'F' => '');
                $checked[$gend] = 'checked';
            ?>
            <label><input type="radio" name="gend" value="M" <?=$checked['M']?>>남자</label>
            <label><input type="radio" name="gend" value="F" <?=$checked['F']?>>여자</label>
        </td>
    </tr>
    <tr>
        <th>소속</th>
        <td>
            <select name="dept">
            <?php
                foreach ($deptList as $key => $value) {
                    echo '<option value="'.$key.'"';
                    if ($key == $dept) echo ' selected';
                    echo '>'.$value[1].'</option>';
                }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <th>직위</th>
        <td>
            <select name="grad">
            <?php
                while ($a = mysqli_fetch_row($gradList)) {
                    echo '<option value="'.$a[1].'"';
                    if ($grad == $a[1]) echo ' selected';
                    echo '>'.$a[2].'</option>';
                }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <th>입사일</th>
        <td>
            <input type="date" name="entr" value="<?=$entr?>"
            required maxlength="10">
        </td>
    </tr>
    <tr>
        <th>연락처</th>
        <td>
            <input type="text" name="phon" value="<?=$phon?>"
            required maxlength="13" placeholder="010-1234-5678">
        </td>
    </tr>
    <tr>
        <th>재직여부</th>
        <td>
            <?php
                $checked = array('Y' => '', 'N' => '');
                $checked[$bord] = 'checked';
            ?>
            <label><input type="radio" name="bord" value="Y" <?=$checked['Y']?>>재직</label>
            <label><input type="radio" name="bord" value="N" <?=$checked['N']?>>퇴사</label>
        </td>
    </tr>
    </table>
    
    <div class="tbMenu">
        <input type="submit" name="update" value="입력">
        <input type="reset" value="취소">
        <input type="button" value="뒤로" onclick="location.href='test18_update.php<?=getURLParam('numb')?>'">
    </div>
</form>
</div>

<hr>
<?php
    include 'test18_menu.php';
?> 
<?php
    include 'test18_footer.php';
?>