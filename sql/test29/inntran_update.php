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

if (isset($_POST['update'])) {
  $serialno = $_POST['serialno'];
  $trandate = $_POST['trandate'];
  $trancode = $_POST['trancode'];
  $tranqnty = $_POST['tranqnty'];
  $tranprce = $_POST['tranprce'];
  $trankind = $_POST['trankind'];

  $sql = "UPDATE inntran
          SET trandate = '$trandate',
              trancode = '$trancode',
              tranqnty = '$tranqnty',
              tranprce = '$tranprce',
              trankind = '$trankind'
          WHERE serialno = '$serialno'
          ";
  mysqli_query($db, $sql);
  $msg = '입고 수정 완료';
  $url = 'inntran_edit.php?page='.$page.'&where='.$where;
  sendMsg($msg, $url);
}

$sql = "SELECT * FROM itemmast";
$item = mysqli_query($db, $sql);

$sql = "SELECT * FROM inntran WHERE serialno='$serialno' ";
$res = mysqli_query($db, $sql);
$inn = mysqli_fetch_assoc($res);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>입고 수정</h3>
<hr>
<!-- contents -->
<div class="tbContents">
  <form method="post" action="" autocomplete="off">
    <input type="hidden" name="page" value="<?=$page?>">
    <input type="hidden" name="where" value="<?=$where?>">
    <input type="hidden" name="serialno" value="<?=$serialno?>">
  
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>입고일자</th>
      <td><input type="date" name= "trandate" value="<?=$inn['trandate']?>"
      required maxlength="10"></td>
    </tr>
    <tr>
      <th>입고제품</th>
      <td>
        <select name="trancode" style="width:100%;">
          <?php
            while ($a = mysqli_fetch_assoc($item)) {
              $selected = '';
              if ($inn['trancode'] == $a['itemcode']) {
                $selected = ' selected';
              }
              $itemName = $a['descript'].' ('.$a['itemspec'].')';
              echo '<option value="'.$a['itemcode'].'"'.
                   $selected.'>'.$itemName.'</option>';
            }
          ?>
        </select>
    </td>
    </tr>
    <tr>
      <th>입고수량</th>
      <td><input type="number" name= "tranqnty" value="<?=$inn['tranqnty']?>"
      required></td>
    </tr>
    <tr>
      <th>입고단가</th>
      <td><input type="number" name= "tranprce" value="<?=$inn['tranprce']?>"
      required></td>
    </tr>
    <tr>
      <th>입출구분</th>
      <td><input type="text" name= "trankind" value="<?=$inn['trankind']?>"
      required maxlength="1" readonly></td>
    </tr>
  </table>

  <div class="tbMenu">
    <input type="submit" name="update" value="입력">
    <input type="reset" value="취소">
    <input type="button" value="뒤로"
      onclick="location.href='inntran_edit.php?page=<?=$page?>&where=<?=$where?>'">
  </div>

  </form>
</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>