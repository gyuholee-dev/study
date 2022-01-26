<?php
//// 대여, 반납 상세 현황
// 구분(radio) 고객no순 장난감no순
// 고객명 장난감명 대여일자 상태 반납일자
require_once 'includes/global.php';
require_once 'includes/functions.php';

$items = 12;
$page = 1;
$start = 0;
$order = 'cust';

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['order'])) {
  $order = $_REQUEST['order'];
}

$start = ($page-1)*$items;

$sql = "SELECT COUNT(*) FROM rent";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$pages = ceil($a[0]/$items);

$sql = "SELECT rent.*, 
        cust.name AS cust_name, 
        toyy.name AS toyy_name 
        FROM rent 
        JOIN cust ON rent.cust = cust.numb 
        JOIN toyy ON rent.toyy = toyy.numb 
       ";
if ($order == 'cust') {
  $sql = $sql."ORDER BY rent.cust ASC ";
} elseif ($order == 'toyy') {
  $sql = $sql."ORDER BY rent.toyy ASC ";
}
$sql = $sql."LIMIT $start, $items";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>대여,반납 상세 현황</h3>
<hr>

<div class="tbContents">
<div class="tbMenu">
    <script>
      function changeView() {
        var form = document.getElementById('tbmenu');
        form.submit();
      }
    </script>

    <form id="tbmenu" method="get" action="">
      <?php
        $checked = ['',''];
        if ($order == 'cust') $checked[0] = 'checked';
        if ($order == 'toyy') $checked[1] = 'checked';
      ?>
      <table class="inner" width="100%">
        <tr><td class="left">
          <label>
            <input type="radio" name="order" 
              style="width:auto;" value="cust" 
              onchange="changeView()" <?=$checked[0]?>>
              고객순
          </label>
          <label>
            <input type="radio" name="order" 
              style="width:auto;" value="toyy" 
              onchange="changeView()" <?=$checked[1]?>>
              장난감순
          </label>
        </td><td class="right">
          <!-- <input type="hidden" name="page" value="<?=$page?>"> -->
          <!-- <input type="submit" name="" value="조회"> -->
          <input type="button" name="" value="메뉴" 
            onclick="location.href='start.php'">
        </td></tr>
      </table>
    </form>

  </div>

  <table cellpading="3" cellspacing="1">
    <tr>
      <?php
        if ($order == 'cust') {
          echo "<th>고객명</th>";
          echo "<th>장난감명</th>";
        } elseif ($order == 'toyy') {
          echo "<th>장난감명</th>";
          echo "<th>고객명</th>";
        }
      ?>
      <th>대여일자</th>
      <th>상태</th>
      <th>반납일자</th>
    </tr>

    <style>
      tr.red td {
        color: red;
        font-weight: bold;
      }
    </style>

    <?php
      $savCust = '';
      $savToyy = '';
      while ($a = mysqli_fetch_assoc($res)) {
        $class = '';
        $cust = $a['cust_name'];
        $toyy = $a['toyy_name'];

        if ($order == 'cust') {
          if ($cust == $savCust) {
            $cust = '';
          } else {
            $savCust = $cust;
          }
        } elseif ($order == 'toyy') {
          if ($toyy == $savToyy) {
            $toyy = '';
          } else {
            $savToyy = $toyy;
          }
        }

        if ($a['stat'] == 'R') {
          $class = 'red';
          $stat = '대여중';
        } elseif ($a['stat'] == 'B') {
          $stat = '반납';
        }

        echo '<tr class="'.$class.'">';
        if ($order == 'cust') {
          echo '<td class="fc '.$a['cust'].'">'.$cust.'</td>';
          echo '<td>'.$toyy.'</td>';
        } elseif ($order == 'toyy') {
          echo '<td class="fc '.$a['toyy'].'">'.$toyy.'</td>';
          echo '<td>'.$cust.'</td>';
        } 
        echo '<td>'.$a['date'].'</td>';
        echo '<td>'.$stat.'</td>';
        echo '<td>'.$a['retn'].'</td>';
        echo '</tr>';
      }
    ?>
  </table>

  <div class="tbMenu">
    <?php
      for ($i=1; $i<=$pages; $i++) {
        echo '<span class="page">';
        if ($i == $page) {
          echo "<b>$i</b>";
        } else {
          echo '[<a href="view_4.php?order='.$order.
               '&page='.$i.'">'.$i.'</a>]';
        }
        echo '</span>';
      }
    ?>
  </div>

</div>

<!-- <img src="../images/cording_cat.gif" style="width:400px;"> -->
<?php
  // include $id.'includes/_menu.php';
?> 
<?php
  include 'includes/_footer.php';
?>