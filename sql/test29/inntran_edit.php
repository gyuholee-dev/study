<?php
require_once 'includes/init.php';

$items = 10;
$page = 1;
$start = 0;
$pageCount = 1;
$where = 'all';
$whereSql = '';

if (isset($_REQUEST['items'])) {
  $items = $_REQUEST['items'];
}
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['where'])) {
  $where = $_REQUEST['where'];
  if ($where != 'all') {
    $whereSql = "WHERE trancode = '$where' ";
  }
}

$start = ($page-1)*$items;

$sql = "SELECT COUNT(*) FROM inntran ";
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$pageCount = ceil($a[0]/$items);

$sql = "SELECT DISTINCT(SUBSTR(trandate, 1, 4)) AS year FROM inntran ";
$year = mysqli_query($db, $sql);

$sql = "SELECT * FROM itemmast";
$item = mysqli_query($db, $sql);

$sql = "SELECT inntran.*, 
        itemmast.descript AS item_name,
        itemmast.itemspec AS item_spec
        FROM inntran 
        JOIN itemmast ON inntran.trancode = itemmast.itemcode
        ";
$sql = $sql.$whereSql;
$sql = $sql."ORDER BY serialno DESC ";
$sql = $sql."LIMIT $start, $items ";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>입고 관리</h3>
<hr>
<!-- contents -->
<div class="tbContents">

  <script>
    function changeView() {
      var form = document.getElementById('tbmenu');
      form.submit();
    }
  </script>
  
  <div class="tbMenu">
    <table class="inner" width="100%">
      <td class="left">
        <form method="get" action="" id="tbmenu">
          <label for="year">년도</label>
          <select name="year" id="year" onchange="changeView()">
            <option value="all">전체</option>
          <?php
            while ($a = mysqli_fetch_assoc($year)) {
              $selected = '';
              if ($year == $a['year']) {
                $selected = ' selected';
              }
              echo '<option value="'.$a['year'].'"'.
              $selected.'>'.$a['year'].'</option>';
            }
          ?>
          </select>
        </form>
      </td>
      <td class="right">
        <input type="button" value="초기화"
        onclick="location.href='inntran_edit.php'">
        <input type="button" value="메뉴"
        onclick="location.href='index.php'">
      </td>
    </table>
  </div>

  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>입고일자</th>
      <th>입고제품</th>
      <th>입고수량</th>
      <th>입고단가</th>
      <th>입출구분</th>
      <th>수정</th>
      <th>삭제</th>
    </tr>
    <?php
      while ($a = mysqli_fetch_assoc($res)) {
        $trancode = $a['item_name'].' ('.$a['item_spec'].')';
        $tranprce = number_format($a['tranprce']).'원';
        $updateUrl = 'inntran_update.php?page='.$page.
                     '&where='.$where.
                     '&serialno='.$a['serialno'];
        $updateLink = '<a href="'.$updateUrl.'">수정</a>';
        $deleteUrl = 'inntran_delete.php?page='.$page.
                     '&where='.$where.
                     '&serialno='.$a['serialno'];
        $deleteLink = '<a href="'.$deleteUrl.'">삭제</a>';
        echo '<tr>';
        echo '<td>'.$a['trandate'].'</td>';
        echo '<td class="left">'.$trancode.'</td>';
        echo '<td class="right">'.$a['tranqnty'].'</td>';
        echo '<td class="right">'.$tranprce.'</td>';
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
        echo '<a href="inntran_edit.php?page=1&where='.$where.'"><<</a>';
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
          echo '[<a href="inntran_edit.php?page='.$i.'&where='.$where.'">'.$i.'</a>]';
        }
        echo '</span>';
      }

      echo '<span class="page">';
      if ($page == $pageCount) {
        echo '>>';
      } else {
        echo '<a href="inntran_edit.php?page='.$pageCount.'&where='.$where.'">>></a>';
      }
      echo '</span>';

    ?>
  </div>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>