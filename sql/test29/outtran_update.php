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

if (isset($_POST['update'])) {
  $trandate = $_POST['trandate'];
  $salecode = $_POST['salecode'];
  $trancode = $_POST['trancode'];
  $tranqnty = $_POST['tranqnty'];
  $tranprce = $_POST['tranprce'];
  $trankind = $_POST['trankind'];

  $sql = "UPDATE outtran
          SET trandate = '$trandate',
              salecode = '$salecode',
              trancode = '$trancode',
              tranqnty = '$tranqnty',
              tranprce = '$tranprce',
              trankind = '$trankind'
          WHERE serialno = '$serialno'
          ";
  mysqli_query($db, $sql);
  $msg = '출고 수정 완료';
  $url = 'outtran_edit.php?page='.$page;
  sendMsg($msg, $url);
}

$sql = "SELECT * FROM itemmast";
$item = mysqli_query($db, $sql);

$sql = "SELECT * FROM salesman";
$man = mysqli_query($db, $sql);

$sql = "SELECT * FROM outtran WHERE serialno='$serialno' ";
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
    <input type="hidden" name="serialno" value="<?=$serialno?>">
  
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
        <select name="trancode" style="width:100%;">
          <?php
            while ($a = mysqli_fetch_assoc($item)) {
              $selected = '';
              if ($out['trancode'] == $a['itemcode']) {
                $selected = ' selected';
              }
              $milkName = $a['descript'].' ('.$a['itemspec'].')';
              echo '<option value="'.$a['itemcode'].'"'.
                   $selected.'>'.$milkName.'</option>';
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <th>출고수량</th>
      <td><input type="number" name= "tranqnty" value="<?=$out['tranqnty']?>"
      required></td>
    </tr>
    <tr>
      <th>출고단가</th>
      <td><input type="number" name= "tranprce" value="<?=$out['tranprce']?>"
      required></td>
    </tr>
    <tr>
      <th>입출구분</th>
      <td><input type="text" name= "trankind" value="<?=$out['trankind']?>"
      required maxlength="1" readonly></td>
    </tr>
  </table>

  <div class="tbMenu">
    <input type="submit" name="update" value="입력">
    <input type="reset" value="취소">
    <input type="button" value="뒤로"
      onclick="location.href='outtran_edit.php?page=<?=$page?>'">
  </div>

  </form>
</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>