<?php
require_once 'includes/init.php';

$rows = 0;
$date = date('Y-m-d');

if (isset($_REQUEST['date'])) {
  $date = $_REQUEST['date'];
}

$sql = "SELECT COUNT(*) FROM itemmast";
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];

if (isset($_POST['insert'])) {
  $date = $_POST['date'];
  $sql = "DELETE FROM inntran WHERE trandate = '$date'";
  // echo $sql.'<br>';
  mysqli_query($db, $sql);

  for ($i=0; $i < $rows; $i++) { 
    $serialno = $_POST['serialno'][$i];
    $trandate = $_POST['trandate'][$i];
    $trancode = $_POST['trancode'][$i];
    $tranqnty = $_POST['tranqnty'][$i];
    $tranqnty_origin = $_POST['tranqnty_origin'][$i];
    $tranprce = $_POST['tranprce'][$i];
    // $trankind = $_POST['trankind'][$i];
    $trankind = 'I';

    $sql = "SELECT * FROM itemmast 
    WHERE itemcode = '$trancode'";
    $res = mysqli_query($db, $sql);
    $a = mysqli_fetch_assoc($res);
    $inventry = $a['inventry'];

    if ($tranqnty != '' && $tranqnty > 0) {

      if ($tranqnty_origin != '') {
        $inventry = $inventry + ($tranqnty-$tranqnty_origin);
      } else {
        $inventry = $inventry + $tranqnty;
      }
  
      $sql = "INSERT INTO inntran 
              (trandate, trancode, tranqnty, 
              tranprce, trankind)
              VALUES (
                '$trandate',
                '$trancode',
                '$tranqnty',
                '$tranprce',
                '$trankind'
              )";
      // echo $sql.'<br>';
      mysqli_query($db, $sql);
  
      $sql = "UPDATE itemmast
              SET inventry = '$inventry'
              WHERE itemcode = '$trancode'";
      // echo $sql.'<br>';
      mysqli_query($db, $sql);

    } elseif ($tranqnty_origin != '') {

      $inventry = $a['inventry'] - $tranqnty_origin;

      // $sql = "DELETE FROM inntran
      // WHERE serialno = '$serialno'";
      // echo $sql.'<br>';

      $sql = "UPDATE itemmast
      SET inventry = '$inventry'
      WHERE itemcode = '$trancode'";
      // echo $sql.'<br>';
      mysqli_query($db, $sql);

    }
  }
  $msg = '입고 수정 완료';
  $url = 'inntran_insertB.php?date='.$date;
  sendMsg($msg, $url);
  
}

$sql = "SELECT
        itemmast.*,
        inntran.*
        FROM itemmast 
        LEFT JOIN inntran 
        ON itemmast.itemcode = inntran.trancode
        AND trandate = '$date'
        ";
// $sql = $sql.$whereSql;
$sql = $sql."ORDER BY itemcode DESC ";
// $sql = $sql."LIMIT $start, $items ";
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
          <label for="date">입고일자</label>
          <input type="date" name="date" id="date" style="width:150px" 
          value="<?=$date?>" onchange="changeView()">
        </form>
      </td>
      <td class="right">
        <input type="button" value="초기화"
        onclick="location.href='inntran_insertB.php'">
        <!-- <input type="button" value="메뉴"
        onclick="location.href='index.php'"> -->
      </td>
    </table>
  </div>


  <form method="post">
    <table cellpadding="3" cellspacing="0">
      <tr>
        <th>코드</th>
        <th>입고제품</th>
        <th>재고</th>
        <th>입고단가</th>
        <th>입고</th>
      </tr>
      <?php
        while ($a = mysqli_fetch_assoc($res)) {
          $trandate = $a['trandate'];
          if ($trandate == '') $trandate = $date;
          $tranname = $a['descript'].' ('.$a['itemspec'].')';
          echo '<tr>';
          // 코드
          echo '<td>'.$a['itemcode'].'</td>';
          // 입고제품
          echo '<td class="left">'.$tranname.'</td>';
          // 재고
          echo '<td>'.$a['inventry'].'</td>';
          // 단가
          echo '<td>'.$a['innprice'].'</td>';
          // 입고
          echo '<td>'.
              '<input type="number" name= "tranqnty[]" '.
              'value="'.$a['tranqnty'].'" '.
              'style="width:80px;">'.
              '</td>';
          // 히든
          echo '<input type="hidden" name="serialno[]" value="'.$a['serialno'].'">';
          echo '<input type="hidden" name="trandate[]" value="'.$trandate.'">';
          echo '<input type="hidden" name="trancode[]" value="'.$a['itemcode'].'">';
          echo '<input type="hidden" name="tranqnty_origin[]" value="'.$a['tranqnty'].'">';
          echo '<input type="hidden" name="tranprce[]" value="'.$a['innprice'].'">';
          // echo '<input type="hidden" name="trankind[]" value="'.$a['trankind'].'">';
          echo '</tr>';
        }
      ?>
    </table>
    
    <div class="tbMenu">
      <input type="hidden" name="date" value="<?=$date?>">
      <input type="submit" name="insert" value="입력">
      <input type="reset" value="취소">
      <input type="button" value="메뉴"
        onclick="location.href='index.php'">
    </div>

    </form>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>