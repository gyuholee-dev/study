<?php
require_once 'includes/init.php';

$trandate = date('Y-m-d');

if (isset($_POST['insert'])) {
  $trandate = $_POST['trandate'];
  $salecode = $_POST['salecode'];
  $trancode = $_POST['trancode'];
  $tranqnty = $_POST['tranqnty'];
  // $tranprce = $_POST['tranprce'];
  // $trankind = $_POST['trankind'];
  $trankind = 'O';

  $sql = "SELECT * FROM itemmast 
          WHERE itemcode = '$trancode'";
  $res = mysqli_query($db, $sql);
  $a = mysqli_fetch_assoc($res);
  $tranprce = $a['outprice'];
  $inventry = $a['inventry'] - $_POST['tranqnty'];

  $sql = "INSERT INTO outtran 
          (trandate, salecode, trancode, 
          tranqnty, tranprce, trankind)
          VALUES (
            '$trandate',
            '$salecode',
            '$trancode',
            '$tranqnty',
            '$tranprce',
            '$trankind'
          )";
  // echo $sql.'<br>';
  mysqli_query($db, $sql);
  
  $sql = "UPDATE itemmast
          SET inventry = '$inventry'
          WHERE itemcode = '$trancode'";
  // echo $sql.'<br>';
  mysqli_query($db, $sql);

  mysqli_query($db, $sql);
  $msg = '출고 등록 완료';
  $url = 'outtran_insertA.php';
  sendMsg($msg, $url);
}

$sql = "SELECT * FROM itemmast";
$item = mysqli_query($db, $sql);

$sql = "SELECT * FROM salesman";
$man = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>출고 등록</h3>
<hr>
<!-- contents -->
<div class="tbContents">
  <form method="post" action="" autocomplete="off">
  
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>출고일자</th>
      <td><input type="date" name= "trandate" value="<?=$trandate?>"
      required maxlength="10"></td>
    </tr>
    <tr>
      <th>판매원</th>
      <td>
        <select name="salecode" style="width:100%;" required>
          <option></option>
          <?php
            while ($a = mysqli_fetch_assoc($man)) {
              echo '<option value="'.
                   $a['salecode'].'">'.$a['salename'].'</option>';
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <th>출고제품</th>
      <td>
        <select name="trancode" style="width:100%;" required>
          <option></option>
          <?php
            while ($a = mysqli_fetch_assoc($item)) {
              $itemName = $a['descript'].' ('.$a['itemspec'].')';
              echo '<option value="'.
                   $a['itemcode'].'">'.$itemName.'</option>';
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <th>출고수량</th>
      <td><input type="number" name= "tranqnty" value=""
      required></td>
    </tr>
    <!-- <tr>
      <th>출고단가</th>
      <td><input type="number" name= "tranprce" value=""
      required></td>
    </tr> -->
    <!-- <tr>
      <th>입출구분</th>
      <td><input type="text" name= "trankind" value="O"
      required maxlength="1" readonly></td>
    </tr> -->
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