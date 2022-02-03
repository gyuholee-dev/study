<?php
require_once 'includes/init.php';

$table = 'girl';
$action = 'select';
$title = $tableName.' 멤버 조회';

$code = 'all';
$items = 4;
$page = 1;
$pageCount = 1;
$start = 0;
$refpage = 1;

if (isset($_REQUEST['code'])) {
  $code = $_REQUEST['code'];
}
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['refpage'])) {
  $refpage = $_REQUEST['refpage'];
}

$sql = "SELECT COUNT(*) FROM girl ";
if ($code != 'all') {
  $sql = $sql."WHERE code = '$code' ";
}
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);

if ($code == 'all') {
  $pageCount = ceil($a[0]/$items);
} else {
  $items = $a[0];
  $page = 1;
  $pageCount = 1;
}

$start = ($page-1)*$items;
$sql = "SELECT * FROM grop";
$grop = mysqli_query($db, $sql);

$sql = "SELECT girl.*, 
               code.name AS plce_name, 
               grop.name AS code_name,
               grop.comp AS comp
        FROM girl 
        JOIN grop ON girl.code = grop.code
        JOIN code ON girl.plce = code.cod2
                  AND code.cod1 = '13' ";
if ($code != 'all') {
  $sql = $sql."WHERE girl.code = '$code' ";
}
$sql = $sql."LIMIT $start, $items ";
// echo $sql;
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
  <div class="tbMenu">
    <script>
      function changeView() {
        var form = document.getElementById('tbmenu');
        form.submit();
      }
    </script>
    <table class="inner" width="100%">
      <tr><td class="left">
      <form method="get" id="tbmenu">
        <label>그룹명
        <select name="code" onchange="changeView()">
          <option value="all">전체</option>
        <?php
          while ($a = mysqli_fetch_row($grop)) {
            echo '<option value="'.$a[0].'"';
            if ($a[0] == $code) {
              echo ' selected';
            }
            echo '>'.$a[1].'</option>';
          }
        ?>
        </select></label>
        <?php
          if (isset($_REQUEST['refpage'])) {
            echo '<input type="hidden" name="refpage" value="'.$refpage.'">';
          }
        ?>
      </form>
      </td><td class="right">
        <input type="button" value="초기화"
          onclick="location.href='member_select.php'">
        <?php
          if ($code != 'all' && isset($_REQUEST['refpage'])) {
            echo '<input type="button" value="이전"'.
                 'onclick="location.href=\'group_select.php'.
                 '?page='.$refpage.'\'">';
          } else {
            echo '<input type="button" value="메뉴"'.
                 'onclick="location.href=\'start.php\'">';
          }
        ?>
      </td></tr>
    </table>
  </div>
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>그룹명</th>
      <th>이미지</th>
      <th>소속사</th>
      <th>No.</th>
      <th>멤버명</th>
      <th>이미지</th>
      <th>출신지역</th>
      <th>생년월일</th>
    </tr>
    <?php
      while ($a = mysqli_fetch_assoc($res)) {
        $gropImgName = 'images/'.$a['code_name'].'.png';
        $gropImgTag = '<img src="'.$gropImgName.'" style="height:120px;">';
        $gropImgTag = '<a href="'.$gropImgName.'">'.$gropImgTag.'</a>';
        $girlImgName = 'images/'.$a['name'].'.png';
        $girlImgTag = '<img src="'.$girlImgName.'" style="height:120px;">';
        $girlImgTag = '<a href="'.$girlImgName.'">'.$girlImgTag.'</a>';
        echo '<tr>';
        echo '<td>'.$a['code_name'].'</td>';
        echo '<td>'.$gropImgTag.'</td>';
        echo '<td>'.$a['comp'].'</td>';
        echo '<td>'.$a['numb'].'</td>';
        echo '<td>'.$a['name'].'</td>';
        echo '<td>'.$girlImgTag.'</td>';
        echo '<td>'.$a['plce_name'].'</td>';
        echo '<td>'.$a['date'].'</td>';
        echo '</tr>';
      }
    ?>
  </table>

  <div class="tbMenu">
    <?php
      for ($i=1; $i<=$pageCount; $i++) {
        echo '<span class="page">';
        if ($i == $page) {
          echo "<b>$i</b>";
        } else {
          echo '[<a href="member_select.php?code='.$code.'&page='.$i.'">'.$i.'</a>]';
        }
        echo '</span>';
      }
    ?>
  </div>
</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>