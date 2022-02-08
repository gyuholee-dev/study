<?php
require_once 'includes/init.php';

// $items = 10;
// $page = 1;
// $rows = 0;
// $start = 0;
// $pageCount = 1;

$page = 1;
$year = 'all';
$month = 'all';
$trandate = '';

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
if (isset($_REQUEST['year'])) {
  $year = $_REQUEST['year'];
}
if (isset($_REQUEST['month'])) {
  $month = $_REQUEST['month'];
}
if (isset($_REQUEST['trandate'])) {
  $trandate = $_REQUEST['trandate'];
}

$sql = "SELECT inntran.*, 
        itemmast.descript AS item_name,
        itemmast.itemspec AS item_spec,
        itemmast.inventry AS item_invn
        FROM inntran 
        JOIN itemmast ON inntran.trancode = itemmast.itemcode
        ";
$sql = $sql."WHERE trandate='$trandate' ";
$sql = $sql."ORDER BY serialno DESC ";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>입고 상세</h3>
<hr>
<!-- contents -->
<div class="tbContents">

<div class="tbMenu">
    <table class="inner" width="100%">
      <td class="left">
      </td>
      <td class="right">
        <input type="button" value="뒤로"
        onclick="location.href='view_inntran_days.php<?php
          echo '?page='.$page.'&year='.$year.'&month='.$month;
        ?>'">
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
    </tr>
    <?php
      while ($a = mysqli_fetch_assoc($res)) {
        $tranname = $a['item_name'].' ('.$a['item_spec'].')';
        $tranprce = number_format($a['tranprce']).'원';
        $tranqnty = $a['tranqnty'];
        $trancode = $a['trancode'];
        echo '<tr>';
        echo '<td>'.$a['trandate'].'</td>';
        echo '<td class="left">'.$tranname.'</td>';
        echo '<td class="right">'.$tranqnty.'</td>';
        echo '<td class="right">'.$a['item_invn'].'</td>';
        echo '<td class="right">'.$tranprce.'</td>';
        // echo '<td>'.$a['trankind'].'</td>';
        echo '</tr>';
      }
    ?>
  </table>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>