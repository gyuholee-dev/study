<?php
require_once 'includes/init.php';

$salecode = 11;
$listitems = 12;

if (isset($_POST['insert'])) {

  $sql = "DELETE FROM salesman";
  mysqli_query($db, $sql);

  for ($i=0; $i < $listitems; $i++) {
    $salecode = $_POST['salecode'][$i];
    $salename = $_POST['salename'][$i];
    $salegend = $_POST['salegend'][$i];
    $innndate = $_POST['innndate'][$i];
    $salearea = $_POST['salearea'][$i];

    // 삭제 조건
    if ($salename=='') continue;

    $sql = "INSERT INTO salesman
            (salecode, salename, salegend, 
            innndate, salearea)
            VALUES (
              '$salecode',
              '$salename',
              '$salegend',
              '$innndate',
              '$salearea'
            )";
    // echo $sql.'<br>';
    mysqli_query($db, $sql);
  }
  $msg = '판매원 등록 완료';
  $url = 'salesman_insertB.php';
  sendMsg($msg, $url);
}

$sql = "SELECT COUNT(*) FROM salesman";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
if ($a[0] > $listitems) {
  $listitems = $a[0]+1;
}

$sql = "SELECT * FROM salesman ";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>판매원 등록</h3>
<hr>
<!-- contents -->
<div class="tbContents">

  <form method="post" action="">
  <table id="maintable" cellpadding="3" cellspacing="0">

    <tr>
      <th>코드</th>
      <th>판매원명</th>
      <th>성별</th>
      <th>입점일자</th>
      <th>판매지역</th>
    </tr>

    <?php
      $cnt = 0;
      while ($a = mysqli_fetch_assoc($res)) {
        $gend = array('M'=>'', 'F'=>'');
        $gend[$a['salegend']] = 'checked';
        echo '<tr>';
        echo '<td>'.
             '<input type="hidden" '.
             'name="salecode[]" value="'.$a['salecode'].'">'.
             $a['salecode'].
             '</td>';
        echo '<td>'.
             '<input type="text" style="width:80px" '.
             'name="salename[]" value="'.$a['salename'].'" '.
             'maxlength="10">'.
             '</td>';
        echo '<td>'.
             '<label><input type="radio" name="salegend['.$cnt.']" value="M" '.
             $gend['M'].'>남</label>'.
             '<label><input type="radio" name="salegend['.$cnt.']" value="F" '.
             $gend['F'].'>여</label>'.
             '</td>';
        echo '<td>'.
             '<input type="date" '.
             'name="innndate[]" value="'.$a['innndate'].'">'.
             '</td>';
        echo '<td>'.
             '<input type="text" style="width:120px" '.
             'name="salearea[]" value="'.$a['salearea'].'" '.
             'maxlength="20">'.
             '</td>';
        echo '</tr>';
        $cnt++;
        $salecode = $a['salecode'];
      }

      for ($i=$cnt; $i < $listitems; $i++) {
        $salecode++;
        echo '<tr>';
        echo '<td>'.
             '<input type="hidden" '.
             'name="salecode[]" value="'.$salecode.'">'.
             $salecode.
             '</td>';
        echo '<td>'.
             '<input type="text" style="width:80px" '.
             'name="salename[]" value="" '.
             'maxlength="10">'.
             '</td>';
        echo '<td>'.
             '<label><input type="radio" name="salegend['.$i.']" value="M" '.
             '>남</label>'.
             '<label><input type="radio" name="salegend['.$i.']" value="F" '.
             '>여</label>'.
             '</td>';
        echo '<td>'.
             '<input type="date" '.
             'name="innndate[]" value="">'.
             '</td>';
        echo '<td>'.
             '<input type="text" style="width:120px" '.
             'name="salearea[]" value="" '.
             'maxlength="20">'.
             '</td>';
        echo '</tr>';
      }
    ?>
  </table>

  <div class="tbMenu">
    <input type="submit" name="insert" value="입력">
    <input type="reset" value="취소">
    <input type="button" value="메뉴"
      onclick="location.href='index.php'">
  </div>

  </form>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>