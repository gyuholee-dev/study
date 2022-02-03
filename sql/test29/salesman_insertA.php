<?php
require_once 'includes/init.php';

$salecode = '11';
$innndate = date('Y-m-d');

$sql = "SELECT MAX(salecode) FROM salesman";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
if ($a[0] !== null) {
  $salecode = $a[0]+1;
}

if (isset($_POST['insert'])) {
  $salecode = $_POST['salecode'];
  $salename = $_POST['salename'];
  $salegend = $_POST['salegend'];
  $innndate = $_POST['innndate'];
  $salearea = $_POST['salearea'];

  $sql = "INSERT INTO salesman
          (salecode, salename, salegend, innndate, salearea)
          VALUES (
            '$salecode',
            '$salename',
            '$salegend',
            '$innndate',
            '$salearea'
          )";
  mysqli_query($db, $sql);
  $msg = '판매원 등록 완료';
  $url = 'salesman_insertA.php';
  sendMsg($msg, $url);
}
?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>판매원 등록</h3>
<hr>
<!-- contents -->
<div class="tbContents">
  <form method="post "action="" autocomplete="off">
  
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>판매원코드</th>
      <td><input type="text" name= "salecode" value="<?=$salecode?>"
      required maxlength="2"></td>
    </tr>
    <tr>
      <th>판매원명</th>
      <td><input type="text" name= "salename" value=""
      required maxlength="10"></td>
    </tr>
    <tr>
      <th>성별</th>
      <td>
        <!-- <input type="text" name= "salegend" value=""> -->
        <label><input type="radio" name="salegend" value="M" checked>남</label>
        <label><input type="radio" name="salegend" value="F">여</label>
      </td>
    </tr>
    <tr>
      <th>입점일자</th>
      <td><input type="date" name= "innndate" value="<?=$innndate?>"
      required maxlength="10"></td>
    </tr>
    <tr>
      <th>판매지역</th>
      <td><input type="text" name= "salearea" value=""
      required maxlength="20"></td>
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