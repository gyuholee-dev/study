<?php
require_once 'includes/init.php';

$page = 1;
$serialno = 11;
$year = 'all';
$month = 'all';

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['year'])) {
  $year = $_REQUEST['year'];
}
if (isset($_REQUEST['month'])) {
  $month = $_REQUEST['month'];
}
if (isset($_REQUEST['serialno'])) {
  $serialno = $_REQUEST['serialno'];
}

if (isset($_POST['update'])) {
  $serialno = $_POST['serialno'];
  $trandate = $_POST['trandate'];
  $trancode = $_POST['trancode'];
  $tranqnty = $_POST['tranqnty'];
  $tranqnty_origin = $_POST['tranqnty_origin'];
  // $tranprce = $_POST['tranprce'];
  // $trankind = $_POST['trankind'];
  $trankind = 'I';

  $sql = "SELECT * FROM itemmast 
          WHERE itemcode = '$trancode'";
  $res = mysqli_query($db, $sql);
  $a = mysqli_fetch_assoc($res);
  $tranprce = $a['innprice'];
  $inventry = $a['inventry'] + ($tranqnty-$tranqnty_origin);

  $sql = "UPDATE inntran
          SET trandate = '$trandate',
              trancode = '$trancode',
              tranqnty = '$tranqnty',
              tranprce = '$tranprce',
              trankind = '$trankind'
          WHERE serialno = '$serialno'
          ";
  // echo $sql.'<br>';
  mysqli_query($db, $sql);

  $sql = "UPDATE itemmast
          SET inventry = '$inventry'
          WHERE itemcode = '$trancode'";
  // echo $sql.'<br>';
  mysqli_query($db, $sql);

  $msg = '입고 수정 완료';
  $url = 'inntran_edit.php?page='.$page.'&year='.$year.'&month='.$month;
  sendMsg($msg, $url);
}

$sql = "SELECT inntran.*, 
        itemmast.descript AS item_name,
        itemmast.itemspec AS item_spec,
        itemmast.inventry AS item_invn
        FROM inntran 
        JOIN itemmast ON inntran.trancode = itemmast.itemcode
        WHERE serialno = '$serialno'
        ";
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
    <input type="hidden" name="year" value="<?=$year?>">
    <input type="hidden" name="month" value="<?=$month?>">
    <input type="hidden" name="serialno" value="<?=$serialno?>">
    <input type="hidden" name="tranqnty_origin" value="<?=$inn['tranqnty']?>">
  
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>입고일자</th>
      <td><input type="date" name= "trandate" value="<?=$inn['trandate']?>"
      required maxlength="10"></td>
    </tr>
    <tr>
      <th>입고제품</th>
      <td>
        <?php
          $tranname = $inn['item_name'].' ('.$inn['item_spec'].')';
          echo '<input type="text" value="'.$tranname.'" readonly>';
          echo '<input type="hidden" name="trancode" value="'.$inn['trancode'].'">';
        ?>
    </td>
    </tr>
    <tr>
      <th>입고수량</th>
      <td><input type="number" name= "tranqnty" value="<?=$inn['tranqnty']?>"
      required></td>
    </tr>
  </table>

  <div class="tbMenu">
    <input type="submit" name="update" value="입력">
    <input type="reset" value="취소">
      <input type="button" value="뒤로"
      onclick="location.href='<?
        echo 'inntran_edit.php?page='.$page.'&year='.$year.'&month='.$month;
      ?>'">
  </div>

  </form>
</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>