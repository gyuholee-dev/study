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

$sql = "SELECT itemmast.*, 
        code.name AS kind_name
        FROM itemmast 
        JOIN code ON itemmast.itemkind = code.cod2
                  AND code.cod1 = '17'
        WHERE itemcode='$itemcode' 
        ";
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
        $innprice = number_format($a['innprice']).'원';
        $outprice = number_format($a['outprice']).'원';
        echo '<tr>';
        echo '<td>'.$a['itemcode'].'</td>';
        echo '<td class="left">'.$a['descript'].'</td>';
        echo '<td>'.$a['itemspec'].'</td>';
        echo '<td class="left">'.$a['kind_name'].'</td>';
        echo '<td class="right">'.$innprice.'</td>';
        echo '<td class="right">'.$outprice.'</td>';
        echo '<td class="right">'.$a['inventry'].'</td>';
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