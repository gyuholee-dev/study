<?php
require_once 'includes/init.php';

$table = 'girl';
$action = 'insert';
$title = $tableName.' 등록';

$code = '11';
$line = 10;
if (isset($_REQUEST['code'])) {
  $code = $_REQUEST['code'];
}
if (isset($_REQUEST['line'])) {
  $line = $_REQUEST['line'];
}

$sql = "SELECT * FROM grop";
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
  <form method="post"action="member_insert_set.php">

  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>그룹</th>
      <td width="120">
        <select name="code" style="width:100%;">
          <?php
            while ($a = mysqli_fetch_row($res)) {
              echo '<option value="'.$a[0].'"';
              if ($a[0] == $code) {
                echo ' selected';
              }
              echo '>'.$a[1].'</option>';
            }
          ?>
        </select>
      </td>
      <th>멤버수</th>
      <td>
        <input type="number" name="line" 
          style="width:45px;"
          min="1" max="99" value="<?=$line?>">
      </td>
    </tr>

  </table>
  <div class="tbMenu">
    <input type="submit" name="set" value="입력">
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