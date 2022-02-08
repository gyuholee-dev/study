<?php
require_once 'includes/init.php';

$items = 5;
$page = 1;
$rows = 0;
$start = 0;
$pageCount = 1;
$year = 'all';
$month = 'all';
$whereSql = '';

// $sql = "SELECT MAX(trandate) FROM inntran ";
// $res = mysqli_query($db, $sql);
// $maxdate = mysqli_fetch_row($res)[0];
// $maxdate = explode("-", $maxdate);
// $year = $maxdate[0];
// $month = $maxdate[1];
// $whereSql = "WHERE SUBSTR(trandate, 1, 7) LIKE '$year-$month' ";

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

$sql = "SELECT COUNT(DISTINCT(trandate)) FROM inntran ";
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

$total_qnty = 0;
$total_innprce = 0;
$sql = "SELECT 
        SUM(tranqnty) AS total_qnty,
        SUM(tranqnty*tranprce) AS total_innprce
        FROM inntran 
        ";
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_assoc($res);
$total_qnty = $a['total_qnty'];
$total_innprce = $a['total_innprce'];

$sql = "SELECT 
        trandate,
        SUM(tranqnty) AS qnty,
        SUM(tranqnty*tranprce) AS innprce
        FROM inntran 
        ";
$sql = $sql.$whereSql;
$sql = $sql."GROUP BY trandate ";
$sql = $sql."ORDER BY trandate DESC ";
$sql = $sql."LIMIT $start, $items ";
// echo $sql;
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>입고 조회</h3>
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
        onclick="location.href='view_inntran_days.php'">
        <input type="button" value="메뉴"
        onclick="location.href='index.php'">
      </td>
    </table>
  </div>

  <table cellpadding="3" cellspacing="0" width="400px">
    <style>
      td.skip {
        padding:0 10px;
        line-height:18px;
      }
      td.red {
        color: red;
        font-weight:bold;
      }
    </style>
    <tr>
      <th>입고일자</th>
      <th>입고수량</th>
      <th>입고총액</th>
      <th>상세조회</th>
    </tr>
    <?php
      if ($rows > 0) {
        
        if ($page != 1 && $pageCount > 1) {
          echo '<tr>';
          echo '<td colspan="4" class="skip">&#x22ef;</td>';
          echo '</tr>';
        }
        while ($a = mysqli_fetch_assoc($res)) {
          $innprce = number_format($a['innprce']).'원';
          $detailUrl = 'view_inntran_detail.php'.
                       '?trandate='.$a['trandate'].'&page='.$page.
                       '&year='.$year.'&month='.$month;
          $detailUrl = '<a href="'.$detailUrl.'">Link</a>';
          echo '<tr>';
          echo '<td>'.$a['trandate'].'</td>';
          echo '<td>'.$a['qnty'].'</td>';
          echo '<td class="right">'.$innprce.'</td>';
          echo '<td>'.$detailUrl.'</td>';
          echo '</tr>';
        }
        if ($page != $pageCount && $pageCount > 1) {
          echo '<tr>';
          echo '<td colspan="4" class="skip">&#x22ef;</td>';
          echo '</tr>';
        }

        $total_innprce = number_format($total_innprce).'원';
        echo '<tr>';
        echo '<td>합계</td>';
        echo '<td class="red">'.$total_qnty.'</td>';
        echo '<td class="right red">'.$total_innprce.'</td>';
        echo '<td>-</td>';
        echo '</tr>';
      
      } else {
        echo '<tr>';
        echo '<td colspan="4">목록이 없습니다.</td>';
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
        echo '<a href="view_inntran_days.php?page=1'.
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
            echo '[<a href="view_inntran_days.php?page='.$i.
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
        echo '<a href="view_inntran_days.php?page='.$pageCount.
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