<?php
require_once 'includes/init.php';

$action = 'edit';
$title = '개설과정 편집';
$fileName = 'edit_subject.php';

$items = 20;
if (isset($_REQUEST['items'])) {
  $items = $_REQUEST['items'];
}

// $subjcode = '11';
$whereSql = '';

$subjectList = array();
$sql = "SELECT subjcode, subjname, usestate 
        FROM subject ";
// $sql .= "ORDER BY subjname ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  // $subjcode = $a['subjcode'];
  $subjectList[$a['subjcode']] = [
    'subjname' => $a['subjname'],
    'usestate' => $a['usestate']
  ];
}

// if (isset($_REQUEST['subjcode'])) {
//   $subjcode = $_REQUEST['subjcode'];
// }
// $whereSql = "WHERE subjcode = '$subjcode' ";

$sql = "SELECT * FROM subject ";
$sql = $sql.$whereSql;
// $sql = $sql."LIMIT $start, $items ";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>
<div class="tbContents">

  <div class="tbMenu">
    <table class="inner" width="100%">
      <td class="left">
      </td>
      <td class="right">
        <input type="button" value="메뉴"
        onclick="location.href='index.php'">
      </td>
    </table>
  </div>

  <table cellpadding="3" cellspacing="0">
    <tr>
      <th>코드</th>
      <th>과정명</th>
      <th>강의대상</th>
      <th>개강일자</th>
      <th>모집정원</th>
      <th>교사명</th>
      <th>수강료</th>
      <th>진행여부</th>
    </tr>
      <style>
        tr.unused {
          background-color: rgba(0,0,0,0.1);
        }
      </style>
    <?php
      $lastCode = 11;
      $cnt = 0;
      while ($a = mysqli_fetch_assoc($res)) {
        echo ($a['usestate']=='N')? '<tr class="unused">' : '<tr>';
        // 코드
        echo '<td>';
        echo '<input value="'.$a['subjcode'].'" '.
              'type="text" name="subjcode[]" size="1" '.
              'readonly required>';
        echo '</td>';
        // 과정명
        echo '<td>';
        echo '<input value="'.$a['subjname'].'" '.
              'type="text" name="subjname[]" size="6" '.
              'maxlength="20" required>';
        echo '</td>';
        // 강의대상
        echo '<td>';
        $checked = [1=>'',2=>'',3=>''];
        $checked[$a['subjkind']] = ' checked';
        echo '<label><input type="radio" '.
              'name="subjkind['.$cnt.']" value="1"'.$checked[1].'>';
        echo '초</label>';
        echo '<label><input type="radio" '.
              'name="subjkind['.$cnt.']" value="2"'.$checked[2].'>';
        echo '중</label>';
        echo '<label><input type="radio" '.
              'name="subjkind['.$cnt.']" value="3"'.$checked[3].'>';
        echo '고</label>';
        echo '</td>';
        // 개강일자
        echo '<td>';
        echo '<input value="'.$a['opendate'].'" '.
              'type="date" name="opendate[]" '.
              'required>';
        echo '</td>';
        // 모집정원
        echo '<td>';
        echo '<input value="'.$a['noperson'].'" '.
              'type="number" name="noperson[]" '.
              'style="width:45px" '.
              'required>';
        echo '</td>';
        // 교사명
        echo '<td>';
        echo '<input value="'.$a['teacname'].'" '.
              'type="text" name="teacname[]" size="6" '.
              'maxlength="10" required>';
        echo '</td>';
        // 수강료
        echo '<td>';
        echo '<input value="'.$a['amtprice'].'" '.
              'type="number" name="amtprice[]" '.
              'style="width:80px" '.
              'required>';
        echo '</td>';
        // 진행여부
        echo '<td>';
        $checked = ['Y'=>'','N'=>''];
        $checked[$a['usestate']] = ' checked';
        echo '<label><input type="radio" '.
              'name="usestate['.$cnt.']" value="Y"'.$checked['Y'].'>';
        echo '진행중</label>';
        echo '<label><input type="radio" '.
              'name="usestate['.$cnt.']" value="N"'.$checked['N'].'>';
        echo '종료</label>';
        echo '</td>';

        echo '</tr>';
        $cnt++;
        $lastCode = $a['subjcode'];
      }

      echo '<tr>';
      echo '<td></td>';
      // echo '<td>';
      // echo '<input value="'.($lastCode+1).'" '.
      //       'type="text" name="subjcode[]" size="1" '.
      //       'readonly required>';
      // echo '</td>';
      echo '<td colspan="8"></td>';
      echo '<td>+</td>';
      echo '</tr>';

    ?>

  </table>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>