<?php
require_once 'includes/init.php';

$items = 10;
$page = 1;
$rows = 0;
$start = 0;
$pageCount = 1;
$year = 'all';
$month = 'all';
$whereSql = '';

if (isset($_REQUEST['items'])) {
  $items = $_REQUEST['items'];
}
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['year'])) {
  $year = $_REQUEST['year'];
  if ($year != 'all') {
    $whereSql = "WHERE SUBSTR(trandate, 1, 4) LIKE '$year%' ";
    $where = $year;
  }
}
if (isset($_REQUEST['month'])) {
  $month = $_REQUEST['month'];
  if ($year != 'all' && $month != 'all') {
    $whereSql = "WHERE SUBSTR(trandate, 1, 7) LIKE '$year-$month' ";
  } elseif ($month != 'all') {
    $whereSql = "WHERE SUBSTR(trandate, 6, 2) LIKE '$month' ";
  }
}

$start = ($page-1)*$items;

$sql = "SELECT COUNT(*) FROM outtran ";
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);

$sql = "SELECT 
        DISTINCT(SUBSTR(trandate, 1, 4)) AS year 
        FROM outtran ";
$years = mysqli_query($db, $sql);

$sql = "SELECT * FROM itemmast";
$item = mysqli_query($db, $sql);

$sql = "SELECT outtran.*, 
        salesman.salename AS man_name,
        itemmast.descript AS item_name,
        itemmast.itemspec AS item_spec
        FROM outtran 
        JOIN salesman ON outtran.salecode = salesman.salecode
        JOIN itemmast ON outtran.trancode = itemmast.itemcode
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
<h3>출고 관리</h3>
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
          <label for="year">년</label>
          <select name="year" id="year" onchange="changeView()">
            <option value="all">전체</option>
            <?php
              while ($a = mysqli_fetch_assoc($years)) {
                $selected = '';
                if ($year == $a['year']) {
                  $selected = ' selected';
                }
                echo '<option value="'.$a['year'].'"'.
                $selected.'>'.$a['year'].'년</option>';
              }
            ?>
          </select>
          <label for="month" style="margin-left:10px;">월</label>
          <select name="month" id="month" onchange="changeView()">
            <option value="all">전체</option>
            <?php
              for ($i=1; $i < 12; $i++) { 
                $mon = numStr($i, 2);
                $selected = '';
                if ($month == $mon) {
                  $selected = ' selected';
                }
                echo '<option value="'.$mon.'"'.
                $selected.'>'.$mon.'월</option>';
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
      if ($rows > 0) {
        while ($a = mysqli_fetch_assoc($res)) {
          $trancode = $a['item_name'].' ('.$a['item_spec'].')';
          $tranprce = number_format($a['tranprce']).'원';
          $updateUrl = 'outtran_update.php?page='.$page.
                      '&year='.$year.'&month='.$month.
                      '&serialno='.$a['serialno'];
          $updateLink = '<a href="'.$updateUrl.'">수정</a>';
          $deleteUrl = 'outtran_delete.php?page='.$page.
                      '&year='.$year.'&month='.$month.
                      '&serialno='.$a['serialno'];
          $deleteLink = '<a href="'.$deleteUrl.'">삭제</a>';
          echo '<tr>';
          echo '<td>'.$a['trandate'].'</td>';
          echo '<td>'.$a['man_name'].'</td>';
          echo '<td class="left">'.$trancode.'</td>';
          echo '<td class="right">'.$a['tranqnty'].'</td>';
          echo '<td class="right">'.$tranprce.'</td>';
          echo '<td>'.$a['trankind'].'</td>';
          echo '<td>'.$updateLink.'</td>';
          echo '<td>'.$deleteLink.'</td>';
          echo '</tr>';
        }
      } else {
        echo '<tr>';
        echo '<td colspan="5">목록이 없습니다.</td>';
        echo '<td>-</td>';
        echo '<td>-</td>';
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
        echo '<a href="outtran_edit.php?page=1"'.
             '&year='.$year.'&month='.$month.'"><<</a>';
      }
      echo '</span>';

      if ($rows > 0) {
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
            echo '[<a href="outtran_edit.php?page='.$i.
                '&year='.$year.'&month='.$month.'">'.$i.'</a>]';
          }
          echo '</span>';
        }
      } else {
        echo '<span class="page">';
        echo "<b>1</b>";
        echo '</span>';
      }

      echo '<span class="page">';
      if ($page == $pageCount) {
        echo '>>';
      } else {
        echo '<a href="outtran_edit.php?page='.$pageCount.
             '&year='.$year.'&month='.$month.'">>></a>';
      }
      echo '</span>';

    ?>
  </div>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>