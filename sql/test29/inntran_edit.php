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

$sql = "SELECT COUNT(*) FROM inntran ";
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);

$years = array();
$sql = "SELECT 
        DISTINCT(SUBSTR(trandate, 1, 4)) AS year 
        FROM inntran ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($years, $a['year']);
}

$months = array();
$sql = "SELECT 
        DISTINCT(SUBSTR(trandate, 6, 2)) AS month 
        FROM inntran ";
if ($year != 'all') {
  $sql = $sql."WHERE SUBSTR(trandate, 1, 4) LIKE '$year%' ";
}
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($months, $a['month']);
}

$sql = "SELECT * FROM itemmast";
$item = mysqli_query($db, $sql);

$sql = "SELECT inntran.*, 
        itemmast.descript AS item_name,
        itemmast.itemspec AS item_spec,
        itemmast.inventry AS item_invn
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
          <label for="year">년</label>
          <select name="year" id="year" onchange="changeView()">
            <option value="all">전체</option>
            <?php
              foreach ($years as $y) {
                $selected = '';
                if ($year == $y) {
                  $selected = ' selected';
                }
                echo '<option value="'.$y.'"'.
                $selected.'>'.$y.'년</option>';
              }
            ?>
          </select>
          <label for="month" style="margin-left:10px;">월</label>
          <select name="month" id="month" onchange="changeView()">
            <option value="all">전체</option>
            <?php
              for ($i=1; $i <= 12; $i++) { 
                $mon = numStr($i, 2);
                $selected = '';
                if ($month == $mon) {
                  $selected = ' selected';
                }
                $disabled = ' disabled';
                if (in_array($mon, $months)) {
                  $disabled = '';
                }
                echo '<option value="'.$mon.'"'.
                $selected.$disabled.'>'.$mon.'월</option>';
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
      <th>입고</th>
      <th>재고</th>
      <th>입고단가</th>
      <th>수정</th>
      <th>삭제</th>
    </tr>
    <?php
      if ($rows > 0) {
        $tables = array();
        $saved = '';
        $rowspan = 1;
        $si = 0;
        $i = 0;
        while ($a = mysqli_fetch_assoc($res)) {
          $t = array();
          $trancode = $a['item_name'].' ('.$a['item_spec'].')';
          $tranprce = number_format($a['tranprce']).'원';
          $updateUrl = 'inntran_update.php?page='.$page.
                      '&year='.$year.'&month='.$month.
                      '&serialno='.$a['serialno'];
          $updateLink = '<a href="'.$updateUrl.'">수정</a>';
          $deleteUrl = 'inntran_delete.php?page='.$page.
                      '&year='.$year.'&month='.$month.
                      '&serialno='.$a['serialno'];
          $deleteLink = '<a href="'.$deleteUrl.'">삭제</a>';
          array_push($t, '<tr>');
          if ($a['trandate'] != $saved) {
            $rowspan = 1;
            $saved = $a['trandate'];
            $si = $i;
            array_push($t, '<td rowspan="'.$rowspan.'">');
            array_push($t, $a['trandate']);
            array_push($t, '</td>');
          } else {
            $rowspan++;
            $tables[$si][1] = '<td rowspan="'.$rowspan.'">';
            array_push($t, '');
            array_push($t, '');
            array_push($t, '');
          }
          array_push($t, '<td class="left">'.$trancode.'</td>');
          array_push($t, '<td class="right">'.$a['tranqnty'].'</td>');
          array_push($t, '<td class="right">'.$a['item_invn'].'</td>');
          array_push($t, '<td class="right">'.$tranprce.'</td>');
          array_push($t, '<td>'.$updateLink.'</td>');
          array_push($t, '<td>'.$deleteLink.'</td>');
          array_push($t, '</tr>');
          array_push($tables, $t);
          $i++;
        }
        foreach ($tables as $value) {
          foreach ($value as $v) {
            echo $v;
          }
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
        echo '<a href="inntran_edit.php?page=1'.
             '&year='.$year.'&month='.$month.'"><<</a>';
      }
      echo '</span>';
      
      if ($rows > 0) {
        if ($pageCount > 9) {
          if ($page > $pageCount-8) {
            if ($page - 4 < 1) {
              $listMin = 1;
              $listMax = 9;
            } elseif ($page > $pageCount-5) {
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
        for ($i=1; $i<=$pageCount; $i++) {
          if ($i < $listMin || $i > $listMax) {
            continue;
          }
          echo '<span class="page">';
          if ($i == $page) {
            echo "<b>$i</b>";
          } else {
            echo '[<a href="inntran_edit.php?page='.$i.
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
        echo '<a href="inntran_edit.php?page='.$pageCount.
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