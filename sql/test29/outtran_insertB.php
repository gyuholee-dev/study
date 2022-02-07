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

}

$sql = "SELECT * FROM salesman";
$man = mysqli_query($db, $sql);

$sql = "SELECT
        itemmast.*,
        outtran.*
        FROM itemmast 
        LEFT JOIN outtran 
        ON itemmast.itemcode = outtran.trancode
        AND trandate = '$date'
        ";
$sql = $sql."ORDER BY itemcode DESC ";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>출고 관리</h3>
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
          <label for="date">출고일자</label>
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
        <th>판매원</th>
        <th>출고제품</th>
        <th>재고</th>
        <th>출고단가</th>
        <th>출고</th>
      </tr>
      <?php
        while ($a = mysqli_fetch_assoc($res)) {
          $trandate = $a['trandate'];
          if ($trandate == '') $trandate = $date;
          $tranname = $a['descript'].' ('.$a['itemspec'].')';
          echo '<tr>';
          // 코드
          echo '<td>'.$a['itemcode'].'</td>';
          // 판매원
          echo '<td>';
          echo '<select name="salecode" style="width:100%;">';
          echo '<option></option>';
            mysqli_data_seek($man, 0);
            while ($b = mysqli_fetch_assoc($man)) {
              $selected = '';
              if ($a['salecode'] == $b['salecode']) {
                $selected = ' selected';
              }
              echo '<option value="'.$a['salecode'].'"'.
                  $selected.'>'.$b['salename'].'</option>';
            }
          echo '</select>';
          echo '</td>';
          // 입고제품
          echo '<td class="left">'.$tranname.'</td>';
          // 재고
          echo '<td>'.$a['inventry'].'</td>';
          // 단가
          echo '<td>'.$a['outprice'].'</td>';
          // 출고
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
          echo '<input type="hidden" name="tranprce[]" value="'.$a['outprice'].'">';
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