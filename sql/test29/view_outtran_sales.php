<?php
require_once 'includes/init.php';

$items = 5;
$page = 1;
$rows = 0;
$start = 0;
$pageCount = 1;
$yearmonth = 'all';
$salecode = 'all';
$whereSql = '';

$ymList = array();
$sql = "SELECT 
        DISTINCT(SUBSTR(trandate, 1, 7)) AS yearmonth 
        FROM outtran ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($ymList, $a['yearmonth']);
  $yearmonth = $a['yearmonth'];
}

if (isset($_REQUEST['items'])) {
  $items = $_REQUEST['items'];
}
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['yearmonth'])) {
  $yearmonth = $_REQUEST['yearmonth'];
}
if (isset($_REQUEST['salecode'])) {
  $salecode = $_REQUEST['salecode'];
}

if ($yearmonth != 'all') {
  $whereSql = "WHERE SUBSTR(trandate, 1, 7) LIKE '$yearmonth%' ";
}
if ($yearmonth != 'all' && $salecode != 'all') {
  $whereSql = $whereSql."AND salecode = '$salecode' ";
} elseif ($salecode != 'all') {
  $whereSql = "WHERE salecode = '$salecode' ";
}

$start = ($page-1)*$items;

$sql = "SELECT 
        DISTINCT(salecode), 
        SUBSTR(trandate, 1, 7) 
        FROM outtran ";
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);
// $rows = mysqli_fetch_row($res)[0];
$rows = mysqli_num_rows($res);
$pageCount = ceil($rows/$items);

$total_qnty = 0;
$total_outprce = 0;
$sql = "SELECT 
        SUM(tranqnty) AS total_qnty,
        SUM(tranqnty*tranprce) AS total_outprce
        FROM inntran 
        ";
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_assoc($res);
$total_qnty = $a['total_qnty'];
$total_outprce = $a['total_outprce'];

$sql = "SELECT 
        DISTINCT(salesman.salecode),
        SUBSTR(trandate, 1, 7) AS yearmonth,
        SUM(tranqnty) AS qnty,
        SUM(tranqnty*tranprce) AS outprce,
        salesman.salename AS salename
        FROM outtran 
        JOIN salesman ON outtran.salecode = salesman.salecode
        ";
$sql = $sql.$whereSql;
$sql = $sql."GROUP BY yearmonth, salecode ";
$sql = $sql."ORDER BY yearmonth DESC, salecode ASC ";
$sql = $sql."LIMIT $start, $items ";
// echo $sql;
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>출고 조회</h3>
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
          <label for="yearmonth">출고년월</label>
          <select name="yearmonth" id="yearmonth" onchange="changeView()">
            <!-- <option value="all">전체</option> -->
            <?php
              foreach ($ymList as $ym) {
                $selected = '';
                if ($yearmonth == $ym) {
                  $selected = ' selected';
                }
                echo '<option value="'.$ym.'"'.
                $selected.'>'.$ym.'</option>';
              }
            ?>
          </select>
        </form>
      </td>
      <td class="right">
        <input type="button" value="초기화"
        onclick="location.href='view_outtran_sales.php'">
        <input type="button" value="메뉴"
        onclick="location.href='index.php'">
      </td>
    </table>
  </div>


  <table cellpadding="3" cellspacing="0" width="400px">
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
      <th>판매원</th>
      <th>출고수량</th>
      <th>출고총액</th>
      <th>상세조회</th>
    </tr>
    <?php
      if ($rows > 0) {
        if ($page != 1 && $pageCount > 1) {
          echo '<tr>';
          echo '<td colspan="5" class="skip">&#x22ef;</td>';
          echo '</tr>';
        }
        while ($a = mysqli_fetch_assoc($res)) {
          $outprce = number_format($a['outprce']).'원';
          $detailUrl = 'view_outtran_detailC.php?page='.$page.
                       '&yearmonth='.$yearmonth.'&salecode='.$a['salecode'];
          $detailUrl = '<a href="'.$detailUrl.'">Link</a>';
          echo '<tr>';
          if ($yearmonth=='all') {
            echo '<td>'.$a['yearmonth'].'</td>';
          }
          echo '<td>'.$a['salename'].'</td>';
          echo '<td>'.$a['qnty'].'</td>';
          echo '<td class="right">'.$outprce.'</td>';
          echo '<td>'.$detailUrl.'</td>';
          echo '</tr>';
        }
        if ($page != $pageCount && $pageCount > 1) {
          echo '<tr>';
          echo '<td colspan="5" class="skip">&#x22ef;</td>';
          echo '</tr>';
        }

        $total_outprce = number_format($total_outprce).'원';
        echo '<tr>';
        echo '<td>합계</td>';
        echo '<td class="red">'.$total_qnty.'</td>';
        echo '<td class="right red">'.$total_outprce.'</td>';
        echo '<td>-</td>';
        echo '</tr>';

      } else {
        echo '<tr>';
        echo '<td colspan="5">목록이 없습니다.</td>';
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
        echo '<a href="view_outtran_sales.php?page=1'.
             '&yearmonth='.$yearmonth.'&salecode='.$salecode.'"><<</a>';
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
            echo '[<a href="view_outtran_sales.php?page='.$i.
                 '&yearmonth='.$yearmonth.'&salecode='.$salecode.'">'.$i.'</a>]';
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
        echo '<a href="view_outtran_sales.php?page='.$pageCount.
             '&yearmonth='.$yearmonth.'&salecode='.$salecode.'">>></a>';
      }
      echo '</span>';

    ?>
  </div>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>