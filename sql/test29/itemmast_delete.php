<?php
require_once 'includes/init.php';

$page = 1;
$itemcode = '11';

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['itemcode'])) {
  $itemcode = $_REQUEST['itemcode'];
}

if (isset($_POST['delete'])) {
  $itemcode = $_POST['itemcode'];
  $sql = "DELETE FROM itemmast
          WHERE itemcode = '$itemcode'";
  mysqli_query($db, $sql);
  $msg = '레코드 삭제 완료';
  $url = 'itemmast_edit.php?page='.$page;
  sendMsg($msg, $url);
}

$kindList = array();
$sql = "SELECT * FROM code WHERE cod1='17'";
$kind = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($kind)) {
  $kindList[$a['cod2']] = $a['name'];
}

$sql = "SELECT * FROM itemmast WHERE itemcode='$itemcode' ";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>제품 삭제</h3>
<hr>
<!-- contents -->
<div class="tbContents">

  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>제품코드</th>
      <th>제품명</th>
      <th>제품규격</th>
      <th>제품구분</th>
      <th>입고단가</th>
      <th>출고단가</th>
      <th>재고량</th>
    </tr>
    <?php
      while ($a = mysqli_fetch_assoc($res)) {
        $itemkind = $a['itemkind'];
        if (count($kindList) !== 0) {
          $itemkind = $kindList[$a['itemkind']];
        }
        echo '<tr>';
        echo '<td>'.$a['itemcode'].'</td>';
        echo '<td>'.$a['descript'].'</td>';
        echo '<td>'.$a['itemspec'].'</td>';
        echo '<td>'.$itemkind.'</td>';
        echo '<td>'.$a['innprice'].'</td>';
        echo '<td>'.$a['outprice'].'</td>';
        echo '<td>'.$a['inventry'].'</td>';
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
  <input type="hidden" name="itemcode" value="<?=$itemcode?>">
  <input type="submit" name="delete" value="Yes">
  <input type="button" value="No"
    onclick="location.href='itemmast_edit.php?page=<?=$page?>'">
</form>

<!-- contents -->
<?php
  include 'includes/_footer.php';
?>