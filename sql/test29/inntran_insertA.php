<?php
require_once 'includes/init.php';

$trandate = date('Y-m-d');

if (isset($_POST['insert'])) {
  $trandate = $_POST['trandate'];
  $trancode = $_POST['trancode'];
  $tranqnty = $_POST['tranqnty'];
  // $tranprce = $_POST['tranprce'];
  // $trankind = $_POST['trankind'];
  $trankind = 'I';

  $sql = "SELECT * FROM itemmast 
          WHERE itemcode = '$trancode'";
  $res = mysqli_query($db, $sql);
  $a = mysqli_fetch_assoc($res);
  $tranprce = $a['innprice'];
  $inventry = $a['inventry'] + $_POST['tranqnty'];

  $sql = "INSERT INTO inntran 
          (trandate, trancode, tranqnty, 
          tranprce, trankind)
          VALUES (
            '$trandate',
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

  $msg = '입고 등록 완료';
  $url = 'inntran_insertA.php';
  sendMsg($msg, $url);
}

$sql = "SELECT * FROM itemmast";
$item = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>입고 등록</h3>
<hr>
<!-- contents -->
<div class="tbContents">

  <script type="text/javascript">
    function data_check(form) {
      if (form.trancode.value.length != 2 ) {
        alert('입고제품을 선택하시오');
        form.trancode.focus();
        return false;
      }
      // if (isNaN(form.tranqnty.value)) {
      //   alert('입고수량은 숫자로 입력하시오');
      //   form.tranqnty.focus();
      //   return false;
      // }
    }
  </script>

  <form method="post" action="" autocomplete="off" 
    onsubmit="return data_check(this)">
  
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>입고일자</th>
      <td><input type="date" name= "trandate" value="<?=$trandate?>"
      required maxlength="10"></td>
    </tr>
    <tr>
      <th>입고제품</th>
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
      <th>입고수량</th>
      <td><input type="number" name= "tranqnty" value=""
      required></td>
    </tr>
    <!-- <tr>
      <th>입고단가</th>
      <td><input type="number" name= "tranprce" value=""
      required></td>
    </tr> -->
    <!-- <tr>
      <th>입출구분</th>
      <td><input type="text" name= "trankind" value="I"
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