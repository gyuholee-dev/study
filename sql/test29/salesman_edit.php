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

$sql = "SELECT COUNT(*) FROM salesman";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$pageCount = ceil($a[0]/$items);


$sql = "SELECT * FROM salesman ";

$sql = $sql."LIMIT $start, $items ";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>판매원 관리</h3>
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
      <th>판매원코드</th>
      <th>판매원명</th>
      <th>성별</th>
      <th>입점일자</th>
      <th>판매지역</th>
      <th>수정</th>
      <th>삭제</th>
    </tr>
    <?php
      while ($a = mysqli_fetch_assoc($res)) {
        if ($a['salegend'] == 'M') {
          $salegend = '남';
        } elseif ($a['salegend'] == 'F') {
          $salegend = '여';
        }
        $updateUrl = 'inntran_update.php?page='.$page.
                     '&salecode='.$a['salecode'];
        $updateLink = '<a href="'.$updateUrl.'">수정</a>';
        $deleteUrl = 'inntran_delete.php?page='.$page.
                     '&salecode='.$a['salecode'];
        $deleteLink = '<a href="'.$deleteUrl.'">삭제</a>';
        echo '<tr>';
        echo '<td>'.$a['salecode'].'</td>';
        echo '<td>'.$a['salename'].'</td>';
        echo '<td>'.$salegend.'</td>';
        echo '<td>'.$a['innndate'].'</td>';
        echo '<td>'.$a['salearea'].'</td>';
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
          echo '[<a href="salesman_edit.php?page='.$i.'">'.$i.'</a>]';
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