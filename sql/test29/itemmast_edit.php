<?php
require_once 'includes/init.php';

$items = 10;
$page = 1;
$start = 0;
$pageCount = 1;
if (isset($_REQUEST['items'])) {
  $items = $_REQUEST['items'];
}
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}

$start = ($page-1)*$items;

$sql = "SELECT COUNT(*) FROM itemmast";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$pageCount = ceil($a[0]/$items);


$sql = "SELECT * FROM itemmast ";

$sql = $sql."LIMIT $start, $items ";
$res = mysqli_query($db, $sql);

$kindList = array();
$sql = "SELECT * FROM code WHERE cod1='17'";
$kinds = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($kinds)) {
  $kindList[$a['cod2']] = $a['name'];
}

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>제품 관리</h3>
<hr>
<!-- contents -->
<div class="tbContents">
  
  <div class="tbMenu">
    <table class="inner" width="100%">
      <td class="left">

      </td>
      <td class="right">
        <input type="button" value="메뉴"
        onclick="location.href='index.php'">
      </td>
    </table>
  </div>

  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>제품코드</th>
      <th>제품명</th>
      <th>제품규격</th>
      <th>제품구분</th>
      <th>입고단가</th>
      <th>출고단가</th>
      <th>재고량</th>
      <th>수정</th>
      <th>삭제</th>
    </tr>
    <?php
      while ($a = mysqli_fetch_assoc($res)) {
        $itemkind = $kindList[$a['itemkind']];
        $updateUrl = 'itemmast_update.php?page='.$page.
                     '&itemcode='.$a['itemcode'];
        $updateLink = '<a href="'.$updateUrl.'">수정</a>';
        $deleteUrl = 'itemmast_delete.php?page='.$page.
                     '&itemcode='.$a['itemcode'];
        $deleteLink = '<a href="'.$deleteUrl.'">삭제</a>';
        echo '<tr>';
        echo '<td>'.$a['itemcode'].'</td>';
        echo '<td>'.$a['descript'].'</td>';
        echo '<td>'.$a['itemspec'].'</td>';
        echo '<td>'.$itemkind.'</td>';
        echo '<td>'.$a['innprice'].'</td>';
        echo '<td>'.$a['outprice'].'</td>';
        echo '<td>'.$a['inventry'].'</td>';
        echo '<td>'.$updateLink.'</td>';
        echo '<td>'.$deleteLink.'</td>';
        echo '</tr>';
      }
    ?>
  </table>

  <div class="tbMenu">
    <?php
      $listMin = 1;
      $listMax = 9;
      for ($i=1; $i<=$pageCount; $i++) {
        if ($pageCount > 9) {
          if ($page > $pageCount-8) {
            if ($page > $pageCount-5) {
              $listMin = $pageCount-8;
              $listMax = $pageCount;
            } else {
              $listMin = $page-4;
              $listMax = $page+4;
            }
          } elseif ($page > 5) {
            $listMin = $page-4;
            $listMax = $page+4;
          }
        }
        if ($i < $listMin || $i > $listMax) {
          continue;
        }
        echo '<span class="page">';
        if ($i == $page) {
          echo "<b>$i</b>";
        } else {
          echo '[<a href="itemmast_edit.php?page='.$i.'">'.$i.'</a>]';
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