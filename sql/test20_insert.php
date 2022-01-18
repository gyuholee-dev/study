<?php
require 'include/global.php';

$today = DATE('Y-m-d');

if (isset($_POST['insert'])) {
    $today = $_POST['date'];

    // $seqn = $_POST['seqn'];
    $numbs = $_POST['numb'];
    $date = $_POST['date'];
    $hour = $_POST['hour'];
    $educ = $_POST['educ'];
    $kind = $_POST['kind'];
    $auth = $_POST['auth'];
    $plce = $_POST['plce'];

    foreach ($numbs as $numb => $value) {
        if ($value == 'on') {
            $sql = "INSERT INTO educ (numb, date, hour, educ, kind, auth, plce)
                    VALUES ('$numb', '$date', '$hour', '$educ', '$kind', '$auth', '$plce')";
            // echo $sql.'<br>';
            mysqli_query($db, $sql);
        }
    }
    $msg = '교육 입력 완료';
    $url = 'test20_insert.php';
    sendMsg($msg, $url);
}

$sql ="SELECT MAX(seqn) FROM educ";
$res = mysqli_query($db, $sql);
$maxSeqn = mysqli_fetch_row($res)[0];

$sql = "SELECT * FROM educ WHERE seqn = '$maxSeqn'";
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
<h3>교육 입력</h3>
<hr>

<div class="tbContents">
<form method="post"action="test20_insert.php" autocomplete="off">
    <table cellpadding="3" cellspacing="0" border="1">
    <!-- <tr>
        <th>사원명</th>
        <td>
            <select name="numb">
            <?php
                // while ($a = mysqli_fetch_row($numbList)) {
                //     echo '<option value="'.$a[0].'">'.$a[1].'</option>';
                // }
            ?>
            </select>
        </td>
    </tr> -->
    <tr>
        <th>교육명</th>
        <td>
            <input type="text" name="educ" value=""
            required maxlength="30" placeholder="<?=$preData['educ']?>">
        </td>
    </tr>
    <tr>
        <th>교육일자</th>
        <td>
            <input type="date" name="date" value="<?=$today?>"
            required maxlength="10">
        </td>
    </tr>
    <tr>
        <th>교육시간</th>
        <td>
            <input type="number" name="hour" value=""
            required max="99" placeholder="<?=$preData['hour']?>">
        </td>
    </tr>
    <tr>
        <th>교육구분</th>
        <td>
            <label><input type="radio" name="kind" value="D" checked>의무</label>
            <label><input type="radio" name="kind" value="F">선택</label>
        </td>
    </tr>
    <tr>
        <th>시행기관</th>
        <td>
            <input type="text" name="auth" value=""
            required maxlength="30" placeholder="<?=$preData['auth']?>">
        </td>
    </tr>
    <tr>
        <th>교육장소</th>
        <td>
            <select name="plce">
            <?php
                while ($a = mysqli_fetch_row($plceList)) {
                    echo '<option value="'.$a[1].'">'.$a[2].'</option>';
                }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <th>대상사원</th>
        <td width="205" class="left">
            <!-- <input type="text" id="numbChecked" name="numbChecked" value="" required style="opacity:0;"> -->
            <?php
                $i = 1;
                while ($a = mysqli_fetch_row($numbList)) {
                    echo '<label class="light">';
                    // echo '<input type="checkbox" name="numb['.$i.']" value="'.$a[0].'"';
                    echo '<input type="checkbox" name="numb['.$a[0].']"';
                    // if ($i == 1) echo ' checked';
                    echo '>';
                    echo $a[1];
                    echo '</label>';
                    if ($i%3 == 0) echo '<br>';
                    $i++;
                }
            ?>
        </td>
    </tr>

    </table>
    
    <div class="tbMenu">
        <input type="submit" name="insert" value="입력">
        <input type="reset" value="취소">
        <input type="button" value="메뉴" onclick="location.href='test20_select.php<?=getURLParam()?>'">
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