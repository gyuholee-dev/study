<?php
require_once 'includes/init.php';

$table = 'girl';
$action = 'insert';
$title = $tableName.' 등록';

$line = 10;
// $code = '11';

if (isset($_REQUEST['set'])) {
  $code = $_REQUEST['code'];
}
if (isset($_REQUEST['line'])) {
  $line = $_REQUEST['line'];
}

if (isset($_POST['insert'])) {
  $code = $_POST['code'];
  $sql = "DELETE FROM girl
          WHERE code = '$code'";
  mysqli_query($db, $sql);

  for ($i=0; $i < $line; $i++) { 
    $numb[$i] = $_POST['numb'][$i];
    $name[$i] = $_POST['name'][$i];
    $plce[$i] = $_POST['plce'][$i];
    $date[$i] = $_POST['date'][$i];

    if ($name[$i] != '') {
      $sql = "INSERT INTO girl
              VALUES('$code', '$numb[$i]', '$name[$i]', '$plce[$i]', '$date[$i]')";
      mysqli_query($db, $sql);
    }
  }
  $msg = '멤버 레코드 등록 완료';
  $url = 'member_insert_set.php?set=true&code='.$code.'&line='.$line;
  sendMsg($msg, $url);
}

$sql = "SELECT * FROM grop
        WHERE code = '$code'";
$res = mysqli_query($db, $sql);
$grop = mysqli_fetch_row($res);
if ($grop == null) {
  $grop = ['',''];
}

$sql = "SELECT * FROM code
        WHERE cod1 = '13'";
$plce = mysqli_query($db, $sql);

$sql = "SELECT * FROM girl
        WHERE code = '$code'";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>
<!-- contents -->
<div class="tbContents">
  <form method="post" action="" autocomplete="off">
    <input type='hidden' name='code' value='<?=$code?>'>
    <input type='hidden' name='line' value='<?=$line?>'>
    <div class="tbMenu">
      <b>걸그룹 (<?=$grop[0]?>) <?=$grop[1]?></b>
    </div>
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>순번</th>
      <th>멤버명</th>
      <th>출신지역</th>
      <th>생년월일</th>
    </tr>
    <?php
      for ($i=0; $i < $line; $i++) { 
        $no = $i+11;
        $a = mysqli_fetch_row($res);
        if ($a === null) {
          $a = array('', '', '', '', '');
        }
        echo "
          <tr>
            <td>$no
              <input type='hidden' name='numb[]' 
              value='$no' size='1'>
            </td>
            <td>
              <input type='text' name='name[]'
              value='$a[2]' size='4' autofocus> 
            </td>
          ";
        echo '<td><select name="plce[]">';
        echo '<option hidden></option>';
        mysqli_data_seek($plce, 0);
        while ($b = mysqli_fetch_row($plce)) {
          echo '<option value="'.$b[1].'"';
          if ($b[1] == $a[3]) {
            echo ' selected';
          }
          echo '>'.$b[2].'</option>';
        }
        echo '</select></td>';
        echo "
            <td>
              <input type='date' name='date[]'
              value='$a[4]'> 
            </td>
          </tr>
          ";
      }
    ?>

  </table>

  <div class="tbMenu">
    <input type="submit" name="insert" value="입력">
    <input type="reset" value="취소">
    <input type="button" value="이전"
      onclick="location.href='member_insert.php?code=<?=$code?>&line=<?=$line?>'">
    <input type="button" value="메뉴"
      onclick="location.href='start.php'">
  </div>

  </form>
</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>