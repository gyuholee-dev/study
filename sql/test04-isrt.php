<?php
// ini_set('display_errors', 0);
include 'include/head.inc';
// mysqli_report(MYSQLI_REPORT_OFF);

$sql = 'SELECT MAX(numb) FROM toyy';
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_array($res);

if ($a[0] != '') {
    $curno = $a[0]+1;
} else {
    $curno = '1111';
}

if (isset($_POST['isrt'])) {
    $numb = $_POST['numb'];
    $name = $_POST['name'];
    $prce = $_POST['prce'];
    $qntt = $_POST['qntt'];
    $stat = $_POST['stat'];
    $kind = $_POST['kind'];

    $sql = "INSERT INTO toyy
            VALUES('$numb', '$name', '$prce', '$qntt', '$stat', '$kind')";
    // echo $sql;
    mysqli_query($db, $sql);
    // echo '데이터 1건 입력 완료';
    // $curno = $_POST['numb']+1;
    echo "<script>
            alert('입력을 완료하였습니다');
            location.href='test04-isrt.php';
          </script>";
}

?>

<!DOCTYPE html>
<html lang='ko'>

<center>
<font face='맑은 고딕'>
<h3>장난감 자료 입력</h3>
<hr>
<br><br>

<form method='post' autocomplete='off' action='test04-isrt.php'>
    <table cellpadding=3 cellspacing=0 border=1>
        <tr>
            <th width=80>번호</th>
            <td width=180>
                <input type='text' name='numb' size='1' value='<?php echo $curno; ?>'>
            </td>
        </tr>
        <tr>
            <th width=80>장난감명</th>
            <td width=180>
                <input type='text' name='name' size='20' autofocus>
            </td>
        </tr>
        <tr>
            <th width=80>단가</th>
            <td width=180>
                <input type='text' name='prce' size='15' maxlength='6'> 원
            </td>
        </tr>
        <tr>
            <th width=80>수량</th>
            <td width=180>
                <input type='text' name='qntt' size='15' maxlength='4'> 개
            </td>
        </tr>
        <tr>
            <th width=80>상태</th>
            <td width=180>
                <input type='radio' name='stat' value='보유' checked>보유
                <input type='radio' name='stat' value='대여'>대여
            </td>
        </tr>
        <tr>
            <th width=80>구분</th>
            <td width=180>
                <input type='radio' name='kind' value='T' checked>오락용
                <input type='radio' name='kind' value='E'>교육용
            </td>
        </tr>
        <!-- <tr>
            <th width=80>통신사</th>
            <td width=180>
                <select name='tong'>
                    <option>KT</option>
                    <option>LGU+</option>
                    <option selected>SKT</option>
                </select>
            </td>
        </tr> -->
        <tr>
            <td colspan=2 align='center'>
                <input type='submit' value='입력' name='isrt'>
                <input type='reset' value='취소'>
                <input type='button' value='메인' 
                    onclick='location.href="test04.php"'>
            </td>
        </tr>

    </table>
    <!-- <input type='submit' value='입력' class='button'> -->
</form>






</html>