<?php
require_once 'includes/init.php';

$table = 'grop';
$action = 'insert';
$title = $tableName.' 등록';

$line = 9;

if (isset($_POST['insert'])) {
  $sql = "DELETE FROM grop";
  mysqli_query($db, $sql);

  for ($i=0; $i < $line; $i++) { 
    $code[$i] = $_POST['code'][$i];
    $name[$i] = $_POST['name'][$i];
    $comp[$i] = $_POST['comp'][$i];
    $date[$i] = $_POST['date'][$i];

    if ($name[$i] != '') {
      $sql = "INSERT INTO grop
              VALUES('$code[$i]', '$name[$i]', '$comp[$i]', '$date[$i]')";
      mysqli_query($db, $sql);
    }
  }
  $msg = '걸그룹 레코드 등록 완료';
  $url = 'start.php';
  sendMsg($msg, $url);
}

$sql = "SELECT * FROM grop";
$grop = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>
<!-- contents -->
<div class="tbContents">
  <form method="post" action="">
  <table cellpadding="3" cellspacing="0">
    
    <tr>
      <th>No.</th>
      <th>그룹명</th>
      <th>소속사</th>
      <th>데뷔</th>
    </tr>
    
    <!-- <tr>
      <td><input type="text" name="code" size="1"></td>
      <td><input type="text" name="name" size="4"></td>
      <td><input type="text" name="comp"></td>
      <td><input type="date" name="date"></td>
    </tr> -->

    <?php
      for ($i=0; $i < $line; $i++) { 
        $no = $i + 11;
        $a = mysqli_fetch_row($grop);
        if ($a === null) {
          $a = array('', '', '', '');
        }
        echo "
          <tr>
            <td>$no
              <input type='hidden' name='code[]' 
              value='$no' size='1'>
            </td>
            <td>
              <input type='text' name='name[]'
              value='$a[1]' size='4' autofocus> 
            </td>
            <td>
              <input type='text' name='comp[]'
              value='$a[2]'> 
            </td>
            <td>
              <input type='date' name='date[]'
              value='$a[3]'> 
            </td>
          </tr>
          ";
      }
    ?>

  </table>
  <div class="tbMenu">
    <input type="submit" name="insert" value="입력">
    <input type="reset" value="취소">
    <input type="button" value="메뉴"
      onclick="location.href='start.php'">

  </div>
  </form>
</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>