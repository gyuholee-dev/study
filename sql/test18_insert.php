<?php
require 'include/global.php';

$maxNumb = '1111';
$today = DATE('Y-m-d');

if (isset($_POST['insert'])) {
    $today = $_POST['entr'];

    $numb = $_POST['numb'];
    $name = $_POST['name'];
    $gend = $_POST['gend'];
    $dept = $_POST['dept'];
    $grad = $_POST['grad'];
    $entr = $_POST['entr'];
    $phon = $_POST['phon'];
    $bord = $_POST['bord'];

    $sql = "INSERT INTO empl
            VALUES ('$numb', '$name', '$gend', '$dept', '$grad', '$entr', '$phon', '$bord')";
    // echo $sql;
    mysqli_query($db, $sql);

    $msg = '인사명부 입력 완료';
    $url = 'test18_insert.php';
    sendMsg($msg, $url);
}

$sql ="SELECT MAX(numb) FROM empl";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
if (isset($a[0])) {
    $maxNumb = $a[0]+1;
}

$deptList = getAllRecords('dept');

// $gradList = getAllRecords('code');
// print_r($gradList);
$sql = "SELECT * FROM code WHERE cod1 = '11' ORDER BY cod2 DESC";
$gradList = mysqli_query($db, $sql);


?>
<!-- html -->
<?php
    include 'test18_header.php';
?>
<h3>인사명부 입력</h3>
<hr>

<div class="tbContents">
<form method="post"action="test18_insert.php" autocomplete="off">
    <table cellpadding="3" cellspacing="0" border="1">
    <tr>
        <th>사원번호</th>
        <td>
            <input type="text" name="numb" value="<?=$maxNumb?>"
            required maxlength="4" readonly>
        </td>
    </tr>
    <tr>
        <th>성명</th>
        <td>
            <input type="text" name="name" value=""
            required maxlength="15" placeholder="홍길동">
        </td>
    </tr>
    <tr>
        <th>성별</th>
        <td>
            <!-- <input type="text" name="gend" value=""
            required maxlength="15"> -->
            <label><input type="radio" name="gend" value="M" checked>남자</label>
            <label><input type="radio" name="gend" value="F">여자</label>
        </td>
    </tr>
    <tr>
        <th>소속</th>
        <td>
            <select name="dept">
            <?php
                foreach ($deptList as $key => $value) {
                    echo '<option value="'.$key.'">'.$value[1].'</option>';
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
                    echo '<option value="'.$a[1].'">'.$a[2].'</option>';
                }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <th>입사일</th>
        <td>
            <input type="date" name="entr" value="<?=$today?>"
            required maxlength="10">
        </td>
    </tr>
    <tr>
        <th>연락처</th>
        <td>
            <input type="text" name="phon" value=""
            required maxlength="13" placeholder="010-1234-5678">
        </td>
    </tr>
    <tr>
        <th>재직여부</th>
        <td>
            <!-- <input type="text" name="name" value=""
            required maxlength="15"> -->
            <label><input type="radio" name="bord" value="Y" checked>재직</label>
            <label><input type="radio" name="bord" value="N">퇴사</label>
        </td>
    </tr>
    </table>
    
    <div class="tbMenu">
        <input type="submit" name="insert" value="입력">
        <input type="reset" value="취소">
        <input type="button" value="메뉴" onclick="location.href='test18_select.php<?=getURLParam()?>'">
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