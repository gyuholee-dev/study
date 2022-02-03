<?php
require_once 'includes/init.php';

$page = 1;
$salecode = '11';

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['salecode'])) {
  $salecode = $_REQUEST['salecode'];
}

if (isset($_POST['update'])) {
  $salecode = $_POST['salecode'];
  $salename = $_POST['salename'];
  $salegend = $_POST['salegend'];
  $innndate = $_POST['innndate'];
  $salearea = $_POST['salearea'];

  $sql = "UPDATE salesman
          SET salename = '$salename',
              salegend = '$salegend',
              innndate = '$innndate',
              salearea = '$salearea'
          WHERE salecode = '$salecode'
          ";
  mysqli_query($db, $sql);
  $msg = '판매원 수정 완료';
  $url = 'salesman_edit.php?page='.$page;
  sendMsg($msg, $url);
}

$sql = "SELECT * FROM salesman WHERE salecode='$salecode' ";
$res = mysqli_query($db, $sql);
$man = mysqli_fetch_assoc($res);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>판매원 수정</h3>
<hr>
<!-- contents -->
<div class="tbContents">
  <form method="post" action="" autocomplete="off">
    <input type="hidden" name="page" value="<?=$page?>">
  
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>판매원코드</th>
      <td><input type="text" name= "salecode" value="<?=$man['salecode']?>"
      required maxlength="2" readonly></td>
    </tr>
    <tr>
      <th>판매원명</th>
      <td><input type="text" name= "salename" value="<?=$man['salename']?>"
      required maxlength="10"></td>
    </tr>
    <tr>
      <th>성별</th>
      <td>
        <?php
          $checked = ['M'=>'', 'F'=>''];
          $checked[$man['salegend']] = ' checked';
        ?>
        <label><input type="radio" name="salegend" value="M"<?=$checked['M']?>>남</label>
        <label><input type="radio" name="salegend" value="F"<?=$checked['F']?>>여</label>
      </td>
    </tr>
    <tr>
      <th>입점일자</th>
      <td><input type="date" name= "innndate" value="<?=$man['innndate']?>"
      required maxlength="10"></td>
    </tr>
    <tr>
      <th>판매지역</th>
      <td><input type="text" name= "salearea" value="<?=$man['salearea']?>"
      required maxlength="20"></td>
    </tr>
  </table>

  <div class="tbMenu">
    <input type="submit" name="update" value="입력">
    <input type="reset" value="취소">
    <input type="button" value="뒤로"
      onclick="location.href='salesman_edit.php?page=<?=$page?>'">
  </div>

  </form>
</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>