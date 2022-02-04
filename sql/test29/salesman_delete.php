<?php
require_once 'includes/init.php';

$page = 1;
$salecode = '11';

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['salecode'])) {
  $salecode = $_REQUEST['salecode'];
}

if (isset($_POST['delete'])) {
  $salecode = $_POST['salecode'];
  $sql = "DELETE FROM salesman
          WHERE salecode = '$salecode'";
  mysqli_query($db, $sql);
  $msg = '레코드 삭제 완료';
  $url = 'salesman_edit.php?page='.$page;
  sendMsg($msg, $url);
}

$sql = "SELECT * FROM salesman WHERE salecode = '$salecode'";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>판매원 삭제</h3>
<hr>
<!-- contents -->
<div class="tbContents">

  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>판매원코드</th>
      <th>판매원명</th>
      <th>성별</th>
      <th>입점일자</th>
      <th>판매지역</th>
    </tr>
    <?php
      while ($a = mysqli_fetch_assoc($res)) {
        if ($a['salegend'] == 'M') {
          $salegend = '남';
        } elseif ($a['salegend'] == 'F') {
          $salegend = '여';
        }
        echo '<tr>';
        echo '<td>'.$a['salecode'].'</td>';
        echo '<td>'.$a['salename'].'</td>';
        echo '<td>'.$salegend.'</td>';
        echo '<td>'.$a['innndate'].'</td>';
        echo '<td class="left">'.$a['salearea'].'</td>';
        echo '</tr>';
      }
    ?>
  </table>

</div>

<br>
<span class="red">
<b>레코드를 삭제하시겠습니까?</b>
</span>
<br><br>

<form method="post" action="">
  <input type="hidden" name="page" value="<?=$page?>">
  <input type="hidden" name="salecode" value="<?=$salecode?>">
  <input type="submit" name="delete" value="Yes">
  <input type="button" value="No"
    onclick="location.href='salesman_edit.php?page=<?=$page?>'">
</form>

<!-- contents -->
<?php
  include 'includes/_footer.php';
?>