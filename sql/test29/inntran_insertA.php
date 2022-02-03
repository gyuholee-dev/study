<?php
require_once 'includes/init.php';

$trandate = date('Y-m-d');

if (isset($_POST['insert'])) {
  $trandate = $_POST['trandate'];
  $trancode = $_POST['trancode'];
  $tranqnty = $_POST['tranqnty'];
  $tranprce = $_POST['tranprce'];
  $trankind = $_POST['trankind'];

  $sql = "INSERT INTO salesman 
          (trandate, trancode, tranqnty, tranprce, trankind)
          VALUES (
            '$trandate',
            '$trancode',
            '$tranqnty',
            '$tranprce',
            '$trankind'
          )";
  mysqli_query($db, $sql);
  $msg = '입고 등록 완료';
  $url = 'salesman_insertA.php';
  sendMsg($msg, $url);
}

$sql = "SELECT * FROM itemmast";
$items = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>입고 등록</h3>
<hr>
<!-- contents -->
<div class="tbContents">
  <form method="post "action="" autocomplete="off">
  
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>입고일자</th>
      <td><input type="date" name= "trandate" value="<?=$trandate?>"
      required maxlength="10"></td>
    </tr>
    <tr>
      <th>입고제품</th>
      <td>
        <!-- <input type="text" name= "trancode" value=""> -->
        <select name="trancode" style="width:100%;">
          <?php
            while ($a = mysqli_fetch_assoc($items)) {
              $milkName = $a['descript'].' ('.$a['itemspec'].')';
              echo '<option value="'.
              $a['itemcode'].'">'.$milkName.'</option>';
            }
          ?>
        </select>
    </td>
    </tr>
    <tr>
      <th>입고수량</th>
      <td><input type="number" name= "tranqnty" value=""
      required></td>
    </tr>
    <tr>
      <th>입고단가</th>
      <td><input type="number" name= "tranprce" value=""
      required></td>
    </tr>
    <tr>
      <th>입출구분</th>
      <td><input type="text" name= "trankind" value="I"
      required maxlength="1"></td>
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