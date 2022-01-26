<?php
require_once 'includes/global.php';
require_once 'includes/functions.php';

$items = 5;
$page = 1;
$start = 0;
$order = 'N';

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['order'])) {
  $order = $_REQUEST['order'];
}

$start = ($page-1)*$items;

$sql = "SELECT COUNT(*) FROM cust";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$pages = ceil($a[0]/$items);

$sql = "SELECT cust.*,
        code.name AS jobb_name 
        FROM cust 
        JOIN code ON code.cod1 = '16' 
                  AND cust.jobb = code.cod2 
        ";

if ($order == 'N') {
  $sql = $sql."ORDER BY cust.numb DESC ";
} elseif ($order == 'C') {
  $sql = $sql."ORDER BY cust.name ASC ";
}
$sql = $sql."LIMIT $start, $items";
$cust = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>고객별 수익 현황</h3>
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
        if ($order == 'N') $checked[0] = 'checked';
        if ($order == 'C') $checked[1] = 'checked';
      ?>
      <table class="inner" width="100%">
        <tr><td class="left">
          <label>
            <input type="radio" name="order" 
            style="width:auto;" value="N" 
            onchange="changeView()" <?=$checked[0]?>>
            고객번호순
          </label>
          <label>
            <input type="radio" name="order" 
            style="width:auto;" value="C" 
            onchange="changeView()" <?=$checked[1]?>>
            고객명순
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
    <th>No.</th>
    <th>고객명</th>
    <th>직업</th>
    <th>전화번호</th>
    <th>최초방문일</th>
    <th>최근방문일</th>
    <th>대여횟수</th>
    <th>대여수익</th>
  </tr>
  <?php
    while ($a = mysqli_fetch_row($cust)) {
      $sql = "SELECT MIN(date), MAX(date) FROM rent
              WHERE cust = '$a[0]'";
      $res = mysqli_query($db, $sql);
      $d = mysqli_fetch_row($res);

      $sql = "SELECT COUNT(rent.toyy), SUM(toyy.rent) FROM rent
              JOIN toyy ON rent.toyy = toyy.numb
              WHERE rent.cust = '$a[0]'";
      $res = mysqli_query($db, $sql);
      $s = mysqli_fetch_row($res);

      echo '<tr>';
      echo '<td>'.$a[0].'</td>';
      echo '<td>'.$a[1].'</td>';
      echo '<td>'.$a[5].'</td>';
      echo '<td>'.$a[2].'</td>';
      echo '<td>'.$d[0].'</td>';
      echo '<td>'.$d[1].'</td>';
      echo '<td>'.$s[0].'</td>';
      echo '<td class="right">'.
            number_format($s[1]).'원</td>';
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
          echo '[<a href="view_2.php?order='.$order.
               '&page='.$i.'">'.$i.'</a>]';
        }
        echo '</span>';
      }
    ?>
  </div>

</div>


<?php
  // include $id.'includes/_menu.php';
?> 
<?php
  include 'includes/_footer.php';
?>