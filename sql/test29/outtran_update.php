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
  $trandate = $_POST['trandate'];
  $salecode = $_POST['salecode'];
  $trancode = $_POST['trancode'];
  $tranqnty = $_POST['tranqnty'];
  $tranqnty_origin = $_POST['tranqnty_origin'];
  // $tranprce = $_POST['tranprce'];
  // $trankind = $_POST['trankind'];
  $trankind = 'O';

  $sql = "SELECT * FROM itemmast 
          WHERE itemcode = '$trancode'";
  $res = mysqli_query($db, $sql);
  $a = mysqli_fetch_assoc($res);
  $tranprce = $a['outprice'];
  $inventry = $a['inventry'] - ($tranqnty-$tranqnty_origin);

  $sql = "UPDATE outtran
          SET trandate = '$trandate',
              salecode = '$salecode',
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

  $msg = '출고 수정 완료';
  $url = 'outtran_edit.php?page='.$page.'&year='.$year.'&month='.$month;
  sendMsg($msg, $url);
}

// $sql = "SELECT * FROM itemmast";
// $item = mysqli_query($db, $sql);

$sql = "SELECT * FROM salesman";
$man = mysqli_query($db, $sql);

$sql = "SELECT outtran.*, 
        salesman.salename AS man_name,
        itemmast.descript AS item_name,
        itemmast.itemspec AS item_spec,
        itemmast.inventry AS item_invn
        FROM outtran 
        JOIN salesman ON outtran.salecode = salesman.salecode
        JOIN itemmast ON outtran.trancode = itemmast.itemcode
        WHERE serialno = '$serialno'
        ";
$res = mysqli_query($db, $sql);
$out = mysqli_fetch_assoc($res);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>출고 수정</h3>
<hr>
<!-- contents -->
<div class="tbContents">
  <form method="post" action="" autocomplete="off">
    <input type="hidden" name="page" value="<?=$page?>">
    <input type="hidden" name="year" value="<?=$year?>">
    <input type="hidden" name="month" value="<?=$month?>">
    <input type="hidden" name="serialno" value="<?=$serialno?>">
    <input type="hidden" name="tranqnty_origin" value="<?=$out['tranqnty']?>">
  
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>출고일자</th>
      <td><input type="date" name= "trandate" value="<?=$out['trandate']?>"
      required maxlength="10"></td>
    </tr>
    <tr>
      <th>판매원</th>
      <td>
        <select name="salecode" style="width:100%;">
          <?php
            while ($a = mysqli_fetch_assoc($man)) {
              $selected = '';
              if ($out['salecode'] == $a['salecode']) {
                $selected = ' selected';
              }
              echo '<option value="'.$a['salecode'].'"'.
                   $selected.'>'.$a['salename'].'</option>';
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <th>출고제품</th>
      <td>
        <?php
          $tranname = $out['item_name'].' ('.$out['item_spec'].')';
          echo '<input type="text" value="'.$tranname.'" readonly>';
          echo '<input type="hidden" name="trancode" value="'.$out['trancode'].'">';
        ?>
      </td>
    </tr>
    <tr>
      <th>출고수량</th>
      <td><input type="number" name= "tranqnty" value="<?=$out['tranqnty']?>"
      required></td>
    </tr>
  </table>

  <div class="tbMenu">
    <input type="submit" name="update" value="입력">
    <input type="reset" value="취소">
    <input type="button" value="뒤로"
      onclick="location.href='<?
       echo 'outtran_edit.php?page='.$page.'&year='.$year.'&month='.$month;
      ?>'">
  </div>

  </form>
</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>