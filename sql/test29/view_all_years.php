<?php
require_once 'includes/init.php';

$items = 5;
$page = 1;
$rows = 0;
$start = 0;
$pageCount = 1;
$year = 'all';
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
  }
}

$start = ($page-1)*$items;

/* $sqlA = "SELECT 
         inntran.trandate AS alldate
         FROM inntran 
         LEFT JOIN outtran ON inntran.trandate = outtran.trandate
         GROUP BY alldate 
         ";
$sqlB = "SELECT 
         outtran.trandate AS alldate
         FROM outtran 
         LEFT JOIN inntran ON outtran.trandate = inntran.trandate 
         GROUP BY alldate 
         ";
$sql = "($sqlA) UNION ($sqlB)"; 
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_num_rows($res);
$pageCount = ceil($rows/$items); */

$inn_years = array();
$sql = "SELECT 
        DISTINCT(SUBSTR(trandate, 1, 4)) AS year 
        FROM inntran ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($inn_years, $a['year']);
}
$out_years = array();
$sql = "SELECT 
        DISTINCT(SUBSTR(trandate, 1, 4)) AS year 
        FROM outtran ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($out_years, $a['year']);
}
$years = array_unique(array_merge($inn_years, $out_years));


// SUBSTR(alldate, 1, 7)
/* $sqlA = "SELECT 
         SUBSTR(inntran.trandate, 1, 7) AS alldate,
         SUM(inntran.tranqnty) AS inn_qnty,
         SUM(inntran.tranqnty*inntran.tranprce) AS inn_prce,
         SUM(outtran.tranqnty) AS out_qnty,
         SUM(outtran.tranqnty*outtran.tranprce) AS out_prce
         FROM inntran 
         LEFT JOIN outtran ON inntran.trandate = outtran.trandate
         GROUP BY alldate 
         ";
$sqlB = "SELECT 
         SUBSTR(outtran.trandate, 1, 7) AS alldate,
         SUM(inntran.tranqnty) AS inn_qnty,
         SUM(inntran.tranqnty*inntran.tranprce) AS inn_prce,
         SUM(outtran.tranqnty) AS out_qnty,
         SUM(outtran.tranqnty*outtran.tranprce) AS out_prce
         FROM outtran 
         LEFT JOIN inntran ON outtran.trandate = inntran.trandate 
         GROUP BY alldate 
         ";

$sql = "($sqlA) UNION ($sqlB)"; 
$sql = $sql.$whereSql;
$sql = $sql."ORDER BY alldate DESC ";
$sql = $sql."LIMIT $start, $items ";
echo $sql;
$res = mysqli_query($db, $sql); */

$tranList = array();
$sql = "SELECT 
        SUBSTR(trandate, 1, 7) AS inn_date,
        SUM(tranqnty) AS inn_qnty,
        SUM(tranprce) AS inn_prce
        FROM inntran
        ";
$sql = $sql.$whereSql;
$sql = $sql."GROUP BY trandate ";
$sql = $sql."ORDER BY trandate DESC ";
// $sql = $sql."LIMIT $start, $items ";
echo $sql;
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  foreach ($a as $key => $value) {
    if ($key == 'inn_date') continue;
    $tranList[$a['inn_date']][$key] = $value;
    $tranList[$a['inn_date']]['out_qnty'] = 0;
    $tranList[$a['inn_date']]['out_prce'] = 0;
  }
}

$sql = "SELECT 
        SUBSTR(trandate, 1, 7) AS out_date,
        SUM(tranqnty) AS out_qnty,
        SUM(tranprce) AS out_prce
        FROM outtran
        ";
$sql = $sql.$whereSql;
$sql = $sql."GROUP BY trandate ";
$sql = $sql."ORDER BY trandate DESC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  foreach ($a as $key => $value) {
    if ($key == 'out_date') continue;
    $tranList[$a['out_date']][$key] = $value;
    if (!isset($tranList[$a['out_date']]['inn_qnty'])) {
      $tranList[$a['out_date']]['inn_qnty'] = 0;
    }
    if (!isset($tranList[$a['out_date']]['inn_prce'])) {
      $tranList[$a['out_date']]['inn_prce'] = 0;
    }
  }
}
krsort($tranList);

// print_r($tranList);
// foreach ($tranList as $key => $value) {
//   echo $key.'<br>';
// }
$rows = count($tranList);
$pageCount = ceil($rows/$items);


?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>입출고 현황</h3>
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
        </form>
      </td>
      <td class="right">
        <input type="button" value="초기화"
        onclick="location.href='view_all_years.php'">
        <input type="button" value="메뉴"
        onclick="location.href='index.php'">
      </td>
    </table>
  </div>

  <table cellpadding="3" cellspacing="0" width="600px">
    <style>
      td.skip {
        padding:0 10px;
        line-height:14px;
      }
      td.red {
        color: red;
        font-weight:bold;
      }
    </style>
    <tr>
      <th rowspan="2">년도</th>
      <th rowspan="2">월</th>
      <th colspan="2">입고</th>
      <th colspan="2">출고</th>
      <th rowspan="2">수익</th>
    </tr>
    <tr>
      <th>수량</th>
      <th>금액</th>
      <th>수량</th>
      <th>금액</th>
    </tr>
    <?php
      /* if ($rows > 0) {

        if ($page != 1 && $pageCount > 1) {
          echo '<tr>';
          echo '<td colspan="7" class="skip">&#x22ef;</td>';
          echo '</tr>';
        }
        while ($a = mysqli_fetch_assoc($res)) {
          $alldate = explode('-', $a['alldate']);
          $y = $alldate[0];
          $m = $alldate[1];
          $inn_qnty = $a['inn_qnty'];
          $inn_prce = $a['inn_prce'];
          $out_qnty = $a['out_qnty'];
          $out_prce = $a['out_prce'];
          if (!$inn_qnty) $inn_qnty = 0;
          if (!$inn_prce) $inn_prce = 0;
          if (!$out_qnty) $out_qnty = 0;
          if (!$out_prce) $out_prce = 0;
          $inn_qnty = $inn_qnty.'개';
          $inn_prce = number_format($inn_prce).'원';
          $out_qnty = $out_qnty.'개';
          $out_prce = number_format($out_prce).'원';
          $revenue =  $a['out_prce'] - $a['inn_prce'];
          $revenue = number_format($revenue).'원';
          echo '<tr>';
          echo '<td>'.$y.'</td>';
          echo '<td>'.$m.'</td>';
          echo '<td class="right">'.$inn_qnty.'</td>';
          echo '<td class="right">'.$inn_prce.'</td>';
          echo '<td class="right">'.$out_qnty.'</td>';
          echo '<td class="right">'.$out_prce.'</td>';
          echo '<td class="right">'.$revenue.'</td>';
          echo '</tr>';
        }
        if ($page != $pageCount && $pageCount > 1) {
          echo '<tr>';
          echo '<td colspan="7" class="skip">&#x22ef;</td>';
          echo '</tr>';
        }

      } else {
        echo '<tr>';
        echo '<td colspan="7">목록이 없습니다.</td>';
        echo '</tr>';
      } */

      foreach ($tranList as $k => $val) {
        // if ($key != $year) { continue; }
        $alldate = explode('-', $k);
        $y = $alldate[0];
        $m = $alldate[1];
        $inn_qnty = $val['inn_qnty'];
        $inn_prce = $val['inn_prce'];
        $out_qnty = $val['out_qnty'];
        $out_prce = $val['out_prce'];
        if (!$inn_qnty) $inn_qnty = 0;
        if (!$inn_prce) $inn_prce = 0;
        if (!$out_qnty) $out_qnty = 0;
        if (!$out_prce) $out_prce = 0;
        $inn_qnty = $inn_qnty.'개';
        $inn_prce = number_format($inn_prce).'원';
        $out_qnty = $out_qnty.'개';
        $out_prce = number_format($out_prce).'원';
        $revenue =  $val['out_prce'] - $val['inn_prce'];
        $revenue = number_format($revenue).'원';
        echo '<tr>';
        echo '<td>'.$y.'</td>';
        echo '<td>'.$m.'</td>';
        echo '<td class="right">'.$inn_qnty.'</td>';
        echo '<td class="right">'.$inn_prce.'</td>';
        echo '<td class="right">'.$out_qnty.'</td>';
        echo '<td class="right">'.$out_prce.'</td>';
        echo '<td class="right">'.$revenue.'</td>';
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
        echo '<a href="view_all_years.php?page=1'.
             '&year='.$year.'"><<</a>';
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
            echo '[<a href="view_all_years.php?page='.$i.
                 '&year='.$year.'">'.$i.'</a>]';
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
        echo '<a href="view_all_years.php?page='.$pageCount.
             '&year='.$year.'">>></a>';
      }
      echo '</span>';

    ?>
  </div>


</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>