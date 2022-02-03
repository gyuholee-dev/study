<?php
require_once 'includes/init.php';

$page = 1;
$serialno = 11;

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['serialno'])) {
  $serialno = $_REQUEST['serialno'];
}

if (isset($_POST['delete'])) {
  $serialno = $_POST['serialno'];
  $sql = "DELETE FROM outtran
          WHERE serialno = '$serialno'";
  mysqli_query($db, $sql);
  $msg = '레코드 삭제 완료';
  $url = 'outtran_edit.php?page='.$page;
  sendMsg($msg, $url);
}

$itemList = array();
$sql = "SELECT * FROM itemmast";
$item = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($item)) {
  $itemList[$a['itemcode']] = $a['descript'].' ('.$a['itemspec'].')';
}

$manList = array();
$sql = "SELECT * FROM salesman";
$man = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($man)) {
  $manList[$a['salecode']] = $a['salename'];
}

$sql = "SELECT * FROM outtran WHERE serialno = '$serialno'";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>출고 삭제</h3>
<hr>
<!-- contents -->
<div class="tbContents">
  
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>출고일자</th>
      <th>판매원코드</th>
      <th>출고제품</th>
      <th>출고수량</th>
      <th>출고단가</th>
      <th>입출구분</th>
    </tr>
    <?php
      while ($a = mysqli_fetch_assoc($res)) {
        $salecode = $manList[$a['salecode']];
        $trancode = $itemList[$a['trancode']];
        echo '<tr>';
        echo '<td>'.$a['trandate'].'</td>';
        echo '<td>'.$salecode.'</td>';
        echo '<td>'.$trancode.'</td>';
        echo '<td>'.$a['tranqnty'].'</td>';
        echo '<td>'.$a['tranprce'].'</td>';
        echo '<td>'.$a['trankind'].'</td>';
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
  <input type="hidden" name="serialno" value="<?=$serialno?>">
  <input type="submit" name="delete" value="Yes">
  <input type="button" value="No"
    onclick="location.href='outtran_edit.php?page=<?=$page?>'">
</form>

<!-- contents -->
<?php
  include 'includes/_footer.php';
?>