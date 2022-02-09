<?php
require_once 'includes/init.php';

$items = 5;
$cpage = 1;
$rows = 0;
$start = 0;
$pageCount = 1;
$whereSql = '';

if (isset($_REQUEST['items'])) {
  $items = $_REQUEST['items'];
}
if (isset($_REQUEST['cpage'])) {
  $cpage = $_REQUEST['cpage'];
}

$start = ($cpage-1)*$items;

$page = 1;
$yearmonth = 'all';
$salecode = 'all';

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['yearmonth'])) {
  $yearmonth = $_REQUEST['yearmonth'];
}
if (isset($_REQUEST['salecode'])) {
  $salecode = $_REQUEST['salecode'];
}

$whereSql = "WHERE SUBSTR(trandate, 1, 7) LIKE '$yearmonth%' 
             AND outtran.salecode='$salecode' ";

$sql = "SELECT COUNT(*) FROM outtran ";
$sql = $sql.$whereSql;
// echo $sql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);

$total_qnty = 0;
$total_prce = 0;
$total_outprce = 0;
$sql = "SELECT 
        SUM(tranqnty) AS total_qnty,
        SUM(tranprce) AS total_prce,
        SUM(tranqnty*tranprce) AS total_outprce
        FROM outtran 
        ";
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_assoc($res);
$total_qnty = $a['total_qnty'];
$total_prce = $a['total_prce'];
$total_outprce = $a['total_outprce'];

$sql = "SELECT 
        outtran.*,
        salesman.salename AS salename,
        itemmast.descript AS item_name,
        itemmast.itemspec AS item_spec,
        itemmast.inventry AS item_invn
        FROM outtran 
        JOIN salesman ON outtran.salecode = salesman.salecode
        LEFT JOIN itemmast ON outtran.trancode = itemmast.itemcode
        ";
$sql = $sql.$whereSql;
$sql = $sql."ORDER BY serialno DESC ";
$sql = $sql."LIMIT $start, $items ";
// echo $sql;
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>출고 상세</h3>
<hr>
<!-- contents -->
<div class="tbContents">

<div class="tbMenu">
    <table class="inner" width="100%">
      <td class="left">
        <label>출고년월: <?=$yearmonth?></label>
      </td>
      <td class="right">
        <input type="button" value="뒤로"
        onclick="location.href='view_outtran_sales.php<?php
          echo '?page='.$page.'&yearmonth='.$yearmonth;
        ?>'">
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
      <th>판매원</th>
      <th>출고일자</th>
      <th>출고제품</th>
      <th>출고</th>
      <th>단가</th>
      <th>총액</th>
    </tr>
    <?php

      if ($cpage != 1 && $pageCount > 1) {
        echo '<tr>';
        echo '<td colspan="5" class="skip">&#x22ef;</td>';
        echo '</tr>';
      }

      $t = 0;
      while ($a = mysqli_fetch_assoc($res)) {
        $tranname = $a['item_name'].' ('.$a['item_spec'].')';
        $tranprce = number_format($a['tranprce']).'원';
        $totalprce = number_format($a['tranqnty']*$a['tranprce']).'원';
        echo '<tr>';
        if ($t == 0) {
          echo '<td rowspan="'.mysqli_num_rows($res).'">'.$a['salename'].'</td>';
        }
        echo '<td>'.$a['trandate'].'</td>';
        echo '<td>'.$tranname.'</td>';
        echo '<td>'.$a['tranqnty'].'</td>';
        echo '<td class="right">'.$tranprce.'</td>';
        echo '<td class="right">'.$totalprce.'</td>';
        echo '</tr>';
        $t++;
      }

      if ($cpage != $pageCount && $pageCount > 1) {
        echo '<tr>';
        echo '<td colspan="5" class="skip">&#x22ef;</td>';
        echo '</tr>';
      }

      $total_prce = number_format($total_prce).'원';
      $total_outprce = number_format($total_outprce).'원';
      echo '<tr>';
      echo '<td>합계</td>';
      echo '<td>-</td>';
      echo '<td>-</td>';
      echo '<td class="red">'.$total_qnty.'</td>';
      echo '<td class="right red">'.$total_prce.'</td>';
      echo '<td class="right red">'.$total_outprce.'</td>';
      echo '</tr>';

    ?>
  </table>

  <div class="tbMenu">
    <?php
      $listMin = 1;
      $listMax = 9;

      echo '<span class="page">';
      if ($cpage == 1) {
        echo '<<';
      } else {
        echo '<a href="view_outtran_detailC.php?'.
             '?cpage='.'1'.'&salecode='.$salecode.
             '&page='.$page.'&yearmonth='.$yearmonth.'"><<</a>';
      }
      echo '</span>';
      
      if ($rows > 0) {
        if ($pageCount > 9) {
          if ($cpage > $pageCount-8) {
            if ($cpage - 4 < 1) {
              $listMin = 1;
              $listMax = 9;
            } elseif ($cpage > $pageCount-5) {
              $listMin = $pageCount-8;
              $listMax = $pageCount;
            } else {
              $listMin = $cpage-4;
              $listMax = $cpage+4;
            }
          } elseif ($cpage > 5) {
            $listMin = $cpage-4;
            $listMax = $cpage+4;
          }
        }
        for ($i=1; $i<=$pageCount; $i++) {
          if ($i < $listMin || $i > $listMax) {
            continue;
          }
          echo '<span class="page">';
          if ($i == $cpage) {
            echo "<b>$i</b>";
          } else {
            echo '[<a href="view_outtran_detailC.php'.
                 '?cpage='.$i.'&salecode='.$salecode.
                 '&page='.$page.'&yearmonth='.$yearmonth.'">'.$i.'</a>]';
          }
          echo '</span>';
        }
      } else {
        echo '<span class="page">';
        echo "<b>1</b>";
        echo '</span>';
      }

      echo '<span class="page">';
      if ($cpage == $pageCount) {
        echo '>>';
      } else {
        echo '<a href="view_outtran_detailC.php'.
             '?cpage='.$pageCount.'&salecode='.$salecode.
             '&page='.$page.'&yearmonth='.$yearmonth.'">>></a>';
      }
      echo '</span>';

    ?>
  </div>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>