<?php
require_once 'includes/init.php';

$table = 'grop';
$action = 'select';
$title = $tableName.' 조회';

$items = 4;
$page = 1;
$pageCount = 1;
$start = 0;

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
$sql = "SELECT COUNT(*) FROM grop";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$pageCount = ceil($a[0]/$items);

$start = ($page-1)*$items;
$sql = "SELECT * FROM grop
        LIMIT $start, $items";
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
    <input type="button" value="메뉴" 
      onclick="location.href='start.php'">
  </div>
  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>No.</th>
      <th>그룹명</th>
      <th>이미지</th>
      <th>소속사</th>
      <th>데뷔</th>
      <th>멤버</th>
    </tr>
    <?php
      while ($a = mysqli_fetch_row($res)) {
        $image = '<img src="images/'.$a[1].'.png"'. 
                 'style="width:200px;">';
        $image = '<a href="images/'.$a[1].'.png">'.$image.'</a>';
        $link = '<a href="member_select.php?code='.
                 $a[0].'&page='.$page.'">보기</a>';
        echo '<tr>';
        echo '<td>'.$a[0].'</td>';
        echo '<td>'.$a[1].'</td>';
        echo '<td>'.$image.'</td>';
        echo '<td>'.$a[2].'</td>';
        echo '<td>'.$a[3].'</td>';
        echo '<td>'.$link.'</td>';
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
          echo '[<a href="group_select.php?page='.$i.'">'.$i.'</a>]';
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