<?php
require_once 'includes/global.php';
require_once 'includes/functions.php';

$items = 5;
$page = 1;
$start = 0;

if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}

$start = ($page-1)*$items;

$sql = "SELECT COUNT(*) FROM rent
        WHERE stat = 'R'";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
$pages = ceil($a[0]/$items);

$sql = "SELECT rent.*, 
        toyy.name AS toyy_name,
        cust.name AS cust_name,
        cust.phon AS cust_phon,
        cust.addr AS cust_addr,
        code.name AS cust_jobb
        FROM rent
        JOIN toyy ON rent.toyy = toyy.numb
        JOIN cust ON rent.cust = cust.numb
        JOIN code ON code.cod1 = '16' 
                  AND cust.jobb = code.cod2
        WHERE rent.stat = 'R' 
        ";
$sql = $sql."LIMIT $start, $items";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>미반납 고객 현황</h3>
<hr>

<div class="tbContents">
  <div class="tbMenu">
      <table class="inner" width="100%">
        <tr>
          <td class="right">
            <input type="button" name="" value="메뉴" 
              onclick="location.href='start.php'">
          </td>
        </tr>
      </table>
  </div>

<table cellpading="3" cellspacing="1">
  <tr>
    <th>No.</th>
    <th>대여일자</th>
    <th>장난감명</th>
    <th>고객명</th>
    <th>직업</th>
    <th>전화번호</th>
    <th>주소</th>
  </tr>
  <?php
    while ($a = mysqli_fetch_assoc($res)) {
      echo '<tr>';
      echo '<td>'.$a['seqn'].'</td>';
      echo '<td>'.$a['date'].'</td>';
      echo '<td>'.$a['toyy_name'].'</td>';
      echo '<td>'.$a['cust_name'].'</td>';
      echo '<td>'.$a['cust_jobb'].'</td>';
      echo '<td>'.$a['cust_phon'].'</td>';
      echo '<td>'.$a['cust_addr'].'</td>';
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
          echo '[<a href="view_3.php'.
               '?page='.$i.'">'.$i.'</a>]';
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