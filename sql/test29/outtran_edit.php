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

$sql = "SELECT COUNT(*) FROM outtran";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$pageCount = ceil($a[0]/$items);

$itemList = array();
$sql = "SELECT * FROM itemmast";
$item = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($item)) {
  $itemList[$a['itemcode']] = $a['descript'].' ('.$a['itemspec'].')';
}

$manList = array();
$sql = "SELECT * FROM salesman";
$man = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($man)) {
  $manList[$a['salecode']] = $a['salename'];
}

$sql = "SELECT * FROM outtran ";
$sql = $sql."ORDER BY serialno DESC ";
$sql = $sql."LIMIT $start, $items ";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>출고 관리</h3>
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
      <th>출고일자</th>
      <th>판매원코드</th>
      <th>출고제품</th>
      <th>출고수량</th>
      <th>출고단가</th>
      <th>입출구분</th>
      <th>수정</th>
      <th>삭제</th>
    </tr>
    <?php
      while ($a = mysqli_fetch_assoc($res)) {
        $salecode = $manList[$a['salecode']];
        $trancode = $itemList[$a['trancode']];
        $updateUrl = 'outtran_update.php?page='.$page.
                     '&serialno='.$a['serialno'];
        $updateLink = '<a href="'.$updateUrl.'">수정</a>';
        $deleteUrl = 'outtran_delete.php?page='.$page.
                     '&serialno='.$a['serialno'];
        $deleteLink = '<a href="'.$deleteUrl.'">삭제</a>';
        echo '<tr>';
        echo '<td>'.$a['trandate'].'</td>';
        echo '<td>'.$salecode.'</td>';
        echo '<td>'.$trancode.'</td>';
        echo '<td>'.$a['tranqnty'].'</td>';
        echo '<td>'.$a['tranprce'].'</td>';
        echo '<td>'.$a['trankind'].'</td>';
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

      echo '<span class="page">';
      if ($page == 1) {
        echo '<<';
      } else {
        echo '<a href="outtran_edit.php?page=1"><<</a>';
      }
      echo '</span>';

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
          echo '[<a href="outtran_edit.php?page='.$i.'">'.$i.'</a>]';
        }
        echo '</span>';
      }

      echo '<span class="page">';
      if ($page == $pageCount) {
        echo '>>';
      } else {
        echo '<a href="outtran_edit.php?page='.$pageCount.'">>></a>';
      }
      echo '</span>';

    ?>
  </div>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>