<?php
require_once 'includes/init.php';

$page = 1;
$where = 'all';
$serialno = 11;

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['where'])) {
  $where = $_REQUEST['where'];
}
if (isset($_REQUEST['serialno'])) {
  $serialno = $_REQUEST['serialno'];
}

if (isset($_POST['delete'])) {
  $serialno = $_POST['serialno'];
  $sql = "DELETE FROM inntran
          WHERE serialno = '$serialno'";
  mysqli_query($db, $sql);
  $msg = '레코드 삭제 완료';
  $url = 'inntran_edit.php?page='.$page.'&where='.$where;
  sendMsg($msg, $url);
}

$sql = "SELECT inntran.*, 
        itemmast.descript AS item_name,
        itemmast.itemspec AS item_spec
        FROM inntran 
        JOIN itemmast ON inntran.trancode = itemmast.itemcode
        WHERE serialno = '$serialno'
        ";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>입고 삭제</h3>
<hr>
<!-- contents -->
<div class="tbContents">

  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>입고일자</th>
      <th>입고제품</th>
      <th>입고수량</th>
      <th>입고단가</th>
      <th>입출구분</th>
    </tr>
    <?php
      while ($a = mysqli_fetch_assoc($res)) {
        $trancode = $a['item_name'].' ('.$a['item_spec'].')';
        $tranprce = number_format($a['tranprce']).'원';
        echo '<tr>';
        echo '<td>'.$a['trandate'].'</td>';
        echo '<td class="left">'.$trancode.'</td>';
        echo '<td class="right">'.$a['tranqnty'].'</td>';
        echo '<td class="right">'.$tranprce.'</td>';
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
  <input type="hidden" name="where" value="<?=$where?>">
  <input type="hidden" name="serialno" value="<?=$serialno?>">
  <input type="submit" name="delete" value="Yes">
  <input type="button" value="No"
    onclick="location.href='inntran_edit.php?page=<?=$page?>&where=<?=$where?>'">
</form>

<!-- contents -->
<?php
  include 'includes/_footer.php';
?>