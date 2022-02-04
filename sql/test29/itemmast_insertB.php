<?php
require_once 'includes/init.php';

$itemcode = 11;
$listitems = 15;

if (isset($_POST['insert'])) {

  $sql = "DELETE FROM itemmast";
  mysqli_query($db, $sql);

  for ($i=0; $i < $listitems; $i++) {
    $itemcode = $_POST['itemcode'][$i];
    $descript = $_POST['descript'][$i];
    $itemspec = $_POST['itemspec'][$i];
    $itemkind = $_POST['itemkind'][$i];
    $innprice = $_POST['innprice'][$i];
    $outprice = $_POST['outprice'][$i];
    $inventry = $_POST['inventry'][$i];

    // 삭제 조건
    if ($descript=='') continue;

    $sql = "INSERT INTO itemmast
            (itemcode, descript, itemspec, 
            itemkind, innprice, outprice, inventry)
            VALUES (
              '$itemcode',
              '$descript',
              '$itemspec',
              '$itemkind',
              '$innprice',
              '$outprice',
              '$inventry'
            )";
    // echo $sql.'<br>';
    mysqli_query($db, $sql);
  }
  $msg = '제품 등록 완료';
  $url = 'itemmast_insertB.php';
  sendMsg($msg, $url);
}

$sql = "SELECT COUNT(*) FROM itemmast";
$res = mysqli_query($db, $sql);
$a = mysqli_fetch_row($res);
if ($a[0] > $listitems) {
  $listitems = $a[0]+1;
}

$kindList = array();
$sql = "SELECT * FROM code WHERE cod1='17'";
$kind = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($kind)) {
  $kindList[$a['cod2']] = $a['name'];
}

$sql = "SELECT itemmast.*, 
        code.name AS kind_name
        FROM itemmast 
        JOIN code ON itemmast.itemkind = code.cod2
                  AND code.cod1 = '17' 
        ";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3>제품 등록</h3>
<hr>
<!-- contents -->
<div class="tbContents">

  <script>
    // function removeRow(num) {
    //   var target = document.getElementById('tr_'+num);
    //   target.remove();
    // }

    // function createRow(num) {
    //   var target = document.getElementById('tr_end');
    //   var html = '<tr><td colspan="8">추가추가</td></tr>';
    //   const template = document.createElement('template');
    //   template.innerHTML = html;
    //   document.getElementById('maintable').childNodes[1].insertBefore(template.content.firstChild, target);

    // }
  </script>

  <form method="post" action="">
  <table id="maintable" cellpadding="3" cellspacing="0">
    <tr>
      <th>코드</th>
      <th>제품명</th>
      <th>제품규격</th>
      <th>제품구분</th>
      <th>입고단가</th>
      <th>출고단가</th>
      <th>재고량</th>
      <!-- <th>삭제</th> -->
    </tr>
    <?php
      $cnt = 0;
      while ($a = mysqli_fetch_assoc($res)) {
        echo '<tr id="tr_'.$cnt.'">';
        echo '<td>'.
             '<input type="hidden" '.
             'name="itemcode[]" value="'.$a['itemcode'].'">'.
             $a['itemcode'].
             '</td>';
        echo '<td>'.
             '<input type="text" style="width:120px" '.
             'name="descript[]" value="'.$a['descript'].'" '.
             'maxlength="20">'.
             '</td>';
        echo '<td>'.
             '<input type="text" style="width:60px" '.
             'name="itemspec[]" value="'.$a['itemspec'].'" '.
             'maxlength="20">'.
             '</td>';
        // 
        echo '<td>'.
             '<select name="itemkind[]">';
        echo '<option value=""></option>';
                foreach ($kindList as $key => $value) {
                  echo '<option value="'.$key.'"';
                  if ($key == $a['itemkind']) {
                    echo ' selected';
                  }
                  echo '>'.$value.'</option>';
                }
        echo '</select>'.
             '</td>';
        // 
        echo '<td>'.
             '<input type="number" style="width:80px" '.
             'name="innprice[]" value="'.$a['innprice'].'" '.
             '>'.
             '</td>';
        echo '<td>'.
             '<input type="number" style="width:80px" '.
             'name="outprice[]" value="'.$a['outprice'].'" '.
             '>'.
             '</td>';
        echo '<td>'.
             '<input type="number" style="width:60px" '.
             'name="inventry[]" value="'.$a['inventry'].'" '.
             '>'.
             '</td>';
        // echo '<td>'.
        //      '<input type="button" value="삭제" '.
        //      'onclick="removeRow('.$cnt.')"';
        //      '>'.
        //      '</td>';
        echo '</tr>';
        $cnt++;
        $itemcode = $a['itemcode'];
      }

      for ($i=$cnt; $i < $listitems; $i++) {
        $itemcode++; 
        echo '<tr id="tr_'.$i.'">';
        echo '<td>'.
             '<input type="hidden" '.
             'name="itemcode[]" value="'.$itemcode.'">'.
             $itemcode.
             '</td>';
        echo '<td>'.
             '<input type="text" style="width:120px" '.
             'name="descript[]" value="" '.
             'maxlength="20">'.
             '</td>';
        echo '<td>'.
             '<input type="text" style="width:60px" '.
             'name="itemspec[]" value="" '.
             'maxlength="20">'.
             '</td>';
        // 
        echo '<td>'.
             '<select name="itemkind[]">';
                echo '<option value=""></option>';
                foreach ($kindList as $key => $value) {
                  echo '<option value="'.$key.'"';
                  echo '>'.$value.'</option>';
                }
        echo '</select>'.
             '</td>';
        // 
        echo '<td>'.
             '<input type="number" style="width:80px" '.
             'name="innprice[]" value="" '.
             '>'.
             '</td>';
        echo '<td>'.
             '<input type="number" style="width:80px" '.
             'name="outprice[]" value="" '.
             '>'.
             '</td>';
        echo '<td>'.
             '<input type="number" style="width:60px" '.
             'name="inventry[]" value="" '.
             '>'.
             '</td>';
        //
        // echo '<td>';
        // if ($i < $listitems-1) {
        //   echo '<input type="button" value="삭제" '.
        //        'onclick="removeRow('.$i.')">';
        // } else {
        //   echo '<input type="button" value="추가" '.
        //        'onclick="createRow('.$i.')">';
        // }
        // echo '</td>';
        //
        echo '</tr>';
      }
      echo '<tr id="tr_end"></tr>';

    ?>
  </table>

  <div class="tbMenu">
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