<?php
require 'include/global.php';

$today = DATE('Y-m-d');
if (isset($_GET['today'])) {
    $today = $_GET['today'];
}

$deptList = getAllRecords('dept');

$maxNumb = '111';
$sql = "SELECT MAX(numb) FROM ordr";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
if ($a[0] > $maxNumb) {
    $maxNumb = $a[0]+1;
}

if (isset($_POST['insert'])) {
    $numb = $_POST['numb'];
    $item = $_POST['item'];
    $kind = $_POST['kind'];
    $date = $_POST['date'];
    $prce = $_POST['prce'];
    $qntt = $_POST['qntt'];
    $dept = $_POST['dept'];
    $stat = $_POST['stat'];

    $sql = "INSERT INTO ordr
            VALUES ('$numb', '$item', '$kind', '$date', '$prce', '$qntt', '$dept', '$stat')";
    mysqli_query($db, $sql);

    $msg = "주문요구서 입력 완료";
    $url = "test16_insert.php?today=$date";
    sendMsg($msg, $url);
}

?>
<!-- html -->
<?php
    include 'test16_header.html';
?>
<h3>주문요구서 입력</h3>
<hr>

<div class="tbContents">
    <form method="post" action="test16_insert.php" autocomplete="off">
    <table cellpadding="3" cellspacing="0" border="1" align="center">
        <tr>
            <th>순번</th>
            <td>
                <input type="text" name="numb" value="<?=$maxNumb?>"
                required maxlength="3" readonly>
            </td>
        </tr>
        <tr>
            <th>물품명</th>
            <td>
                <input type="text" name="item" value=""
                required maxlength="40">
            </td>
        </tr>
        <tr>
            <th>종류</th>
            <td>
                <label><input type="radio" name="kind" value="S" checked>소모품</label>
                <label><input type="radio" name="kind" value="B">비품</label>
            </td>
        </tr>
        <tr>
            <th>요청일자</th>
            <td>
                <input type="text" name="date" value="<?=$today?>"
                required maxlength="10">
            </td>
        </tr>
        <tr>
            <th>단가</th>
            <td>
                <input type="number" name="prce" value="" 
                required max="10000000">
            </td>
        </tr>
        <tr>
            <th>수량</th>
            <td>
                <input type="number" name="qntt" value="" 
                required max="1000">
            </td>
        </tr>
        <tr>
            <th>부서</th>
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
            <th>상태</th>
            <td>
                <label><input type="radio" name="stat" value="R" checked>요청중</label>
                <label><input type="radio" name="stat" value="O">주문중</label>
            </td>
        </tr>
    </table>
    <div class="tbMenu">
        <input type="submit" name="insert" value="입력">
        <input type="reset" value="취소">
        <input type="button" value="메뉴" onclick="location.href='test16_select.php'">
    </div>
    </form>
</div>

<hr>
<?php
    include 'test16_menu.html';
?> 
<?php
    include 'test16_footer.html';
?>