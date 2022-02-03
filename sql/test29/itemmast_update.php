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

if (isset($_POST['update'])) {
  $itemcode = $_POST['itemcode'];
  $descript = $_POST['descript'];
  $itemspec = $_POST['itemspec'];
  $itemkind = $_POST['itemkind'];
  $innprice = $_POST['innprice'];
  $outprice = $_POST['outprice'];
  $inventry = $_POST['inventry'];

  $sql = "UPDATE itemmast
          SET descript = '$descript',
              itemspec = '$itemspec',
              itemkind = '$itemkind',
              innprice = '$innprice',
              outprice = '$outprice',
              inventry = '$inventry'
          WHERE itemcode = '$itemcode'
          ";
  mysqli_query($db, $sql);
  $msg = '제품 수정 완료';
  $url = 'itemmast_edit.php?page='.$page;
  sendMsg($msg, $url);
}

$sql = "SELECT * FROM code WHERE cod1='17'";
$kind = mysqli_query($db, $sql);

$sql = "SELECT * FROM itemmast WHERE itemcode='$itemcode' ";
$res = mysqli_query($db, $sql);
$item = mysqli_fetch_assoc($res);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>제품 수정</h3>
<hr>
<!-- contents -->
<div class="tbContents">
  <form method="post" action="" autocomplete="off">
    <input type="hidden" name="page" value="<?=$page?>">
  
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>제품코드</th>
      <td><input type="text" name= "itemcode" value="<?=$item['itemcode']?>"
      required maxlength="2" readonly></td>
    </tr>
    <tr>
      <th>제품명</th>
      <td><input type="text" name= "descript" value="<?=$item['descript']?>"
      required maxlength="20"></td>
    </tr>
    <tr>
      <th>제품규격</th>
      <td><input type="text" name= "itemspec" value="<?=$item['itemspec']?>"
      required maxlength="20"></td>
    </tr>
    <tr>
      <th>제품구분</th>
      <td>
        <select name="itemkind" style="width:100%;">
          <?php
            while ($a = mysqli_fetch_assoc($kind)) {
              $selected = '';
              if ($item['itemkind'] == $a['cod2']) {
                $selected = ' selected';
              }
              echo '<option value="'.$a['cod2'].'"'.
                   $selected.'>'.$a['name'].'</option>';
            }
          ?>
        </select>
    </td>
    </tr>
    <tr>
      <th>입고단가</th>
      <td><input type="number" name= "innprice" value="<?=$item['innprice']?>"
      required></td>
    </tr>
    <tr>
      <th>출고단가</th>
      <td><input type="number" name= "outprice" value="<?=$item['outprice']?>"
      required></td>
    </tr>
    <tr>
      <th>재고량</th>
      <td><input type="number" name= "inventry" value="<?=$item['inventry']?>"
      required></td>
    </tr>
  </table>

  <div class="tbMenu">
    <input type="submit" name="update" value="입력">
    <input type="reset" value="취소">
    <input type="button" value="뒤로"
      onclick="location.href='itemmast_edit.php?page=<?=$page?>'">
  </div>

  </form>
</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>