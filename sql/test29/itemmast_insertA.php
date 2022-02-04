<?php
require_once 'includes/init.php';

$itemcode = '11';
$sql = "SELECT MAX(itemcode) FROM itemmast";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
if ($a[0] !== null) {
  $itemcode = $a[0]+1;
}

if (isset($_POST['insert'])) {
  $itemcode = $_POST['itemcode'];
  $descript = $_POST['descript'];
  $itemspec = $_POST['itemspec'];
  $itemkind = $_POST['itemkind'];
  $innprice = $_POST['innprice'];
  $outprice = $_POST['outprice'];
  $inventry = $_POST['inventry'];

  $sql = "INSERT INTO itemmast
          (itemcode, descript, itemspec, 
          itemkind, innprice, outprice, inventry)
          VALUES (
            '$itemcode',
            '$descript',
            '$itemspec',
            '$itemkind',
            '$innprice',
            '$outprice',
            '$inventry'
          )";
  mysqli_query($db, $sql);
  $msg = '제품 등록 완료';
  $url = 'itemmast_insertA.php';
  sendMsg($msg, $url);
}

$sql = "SELECT * FROM code WHERE cod1='17'";
$kind = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>제품 등록</h3>
<hr>
<!-- contents -->
<div class="tbContents">
  <form method="post" action="" autocomplete="off">
  
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>제품코드</th>
      <td><input type="text" name= "itemcode" value="<?=$itemcode?>"
      required maxlength="2"></td>
    </tr>
    <tr>
      <th>제품명</th>
      <td><input type="text" name= "descript" value=""
      required maxlength="20"></td>
    </tr>
    <tr>
      <th>제품규격</th>
      <td><input type="text" name= "itemspec" value=""
      required maxlength="20"></td>
    </tr>
    <tr>
      <th>제품구분</th>
      <td>
        <select name="itemkind" style="width:100%;">
          <?php
            while ($a = mysqli_fetch_assoc($kind)) {
              echo '<option value="'.
              $a['cod2'].'">'.$a['name'].'</option>';
            }
          ?>
        </select>
    </td>
    </tr>
    <tr>
      <th>입고단가</th>
      <td><input type="number" name= "innprice" value=""
      required></td>
    </tr>
    <tr>
      <th>출고단가</th>
      <td><input type="number" name= "outprice" value=""
      required></td>
    </tr>
    <tr>
      <th>재고량</th>
      <td><input type="number" name= "inventry" value=""
      required></td>
    </tr>
  </table>

  <div class="tbMenu">
    <input type="submit" name="insert" value="입력">
    <input type="reset" value="취소">
    <input type="button" value="메뉴"
      onclick="location.href='index.php'">
  </div>

  </form>
</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>