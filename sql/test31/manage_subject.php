<?php
require_once 'includes/init.php';

$action = 'update';
$title = '개설과정 수정';
$fileName = 'manage_subject.php';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if ($action == 'delete') {
  $title = '개설과정 삭제';
} elseif ($action == 'insert') {
  $title = '개설과정 추가';
}

$subjcode = '11';
$whereSql = '';
if (isset($_REQUEST['subjcode'])) {
  $subjcode = $_REQUEST['subjcode'];
} elseif ($action != 'insert') {
  echo "잘못된 접근입니다";
  return false;
}
if ($action == 'insert') {
  $sql = "SELECT MAX(subjcode) FROM subject";
  $res = mysqli_query($db, $sql);
  $subjcode = mysqli_fetch_row($res)[0];
}


if ($subjcode != '') {
  $whereSql = "WHERE subjcode = '$subjcode' ";
}


if (isset($_POST['confirm'])) {
  $action = $_POST['action'];

  $subjcode = $_POST['subjcode'];
  $subjname = $_POST['subjname'];
  $subjkind = $_POST['subjkind'];
  $opendate = $_POST['opendate'];
  $noperson = $_POST['noperson'];
  $teacname = $_POST['teacname'];
  $amtprice = $_POST['amtprice'];
  $usestate = $_POST['usestate'];
  
  if ($action == 'update') {
    $sql = "UPDATE subject 
            SET 
            subjname = '$subjname',
            subjkind = '$subjkind',
            opendate = '$opendate',
            noperson = '$noperson',
            teacname = '$teacname',
            amtprice = '$amtprice',
            usestate = '$usestate'
            WHERE subjcode = '$subjcode'
            ";
    echo $sql;

  } elseif ($action == 'insert') {
    $sql = "INSERT INTO subject 
            VALUES (
              '$subjcode',
              '$subjname',
              '$subjkind',
              '$opendate',
              '$noperson',
              '$teacname',
              '$amtprice',
              '$usestate'
            )
            ";
    echo $sql;

  } elseif ($action == 'delete') {
    $sql = "DELETE FROM subject
            WHERE subjcode = '$subjcode'";
    echo $sql;

  }

}

$sql = "SELECT * FROM subject ";
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>
<div class="tbContents">
  <form method="post">
  <?echo$action=='delete'?'<div class="boxwrap">':''?>
  <?echo$action=='delete'?'<div class="dimm disabled"></div>':''?>
  <table cellpadding="3" cellspacing="0">
    <?php
      while ($a = mysqli_fetch_assoc($res)) {
        if ($action == 'insert') {
          $a = [
            'subjcode' => $subjcode+1,
            'subjname' => '',
            'subjname' => '',
            'subjkind' => '1',
            'opendate' => date('Y-m-d'),
            'noperson' => '',
            'teacname' => '',
            'amtprice' => '',
            'usestate' => 'Y',
          ];
        }
        echo '<tr>';
        echo '<th>코드</th>';
        echo '<td>';
        echo '<input value="'.$a['subjcode'].'" '.
              'type="text" name="subjcode" '.
              'readonly required>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>과정명</th>';
        echo '<td>';
        echo '<input value="'.$a['subjname'].'" '.
              'type="text" name="subjname" '.
              'maxlength="20" required>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>강의대상</th>';
        echo '<td>';
        // echo '<input value="'.$a['subjkind'].'" '.
        //       'type="text" name="subjkind" '.
        //       'maxlength="20" required>';
        $checked = [1=>'',2=>'',3=>''];
        $checked[$a['subjkind']] = ' checked';
        echo '<label><input type="radio" '.
              'name="subjkind" value="1"'.$checked[1].'>';
        echo '초등</label>';
        echo '<label><input type="radio" '.
              'name="subjkind" value="2"'.$checked[2].'>';
        echo '중등</label>';
        echo '<label><input type="radio" '.
              'name="subjkind" value="3"'.$checked[3].'>';
        echo '고등</label>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>개강일자</th>';
        echo '<td>';
        echo '<input value="'.$a['opendate'].'" '.
              'type="date" name="opendate" '.
              'required>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>모집인원</th>';
        echo '<td>';
        echo '<input value="'.$a['noperson'].'" '.
              'type="number" name="noperson" '.
              'required>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>담당교사</th>';
        echo '<td>';
        echo '<input value="'.$a['teacname'].'" '.
              'type="text" name="teacname" '.
              'maxlength="10" required>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>수강료</th>';
        echo '<td>';
        echo '<input value="'.$a['amtprice'].'" '.
              'type="number" name="amtprice" '.
              'required>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>진행여부</th>';
        echo '<td>';
        // echo '<input value="'.$a['usestate'].'" '.
        //       'type="text" name="usestate" '.
        //       'required>';
        $checked = ['Y'=>'','N'=>''];
        $checked[$a['usestate']] = ' checked';
        echo '<label><input type="radio" '.
              'name="usestate" value="Y"'.$checked['Y'].'>';
        echo '진행중</label>';
        echo '<label><input type="radio" '.
              'name="usestate" value="N"'.$checked['N'].'>';
        echo '종료</label>';
        echo '</td>';
        echo '</tr>';

      }
    ?>
  </table>
  <?echo$action=='delete'?'</div>':''?>

  <div class="tbMenu">
    <input type="hidden" name="action" value="<?=$action?>">
    <!-- <input type="hidden" name="subjcode" value="<?=$subjcode?>"> -->
    <? if ($action=='update' || $action=='insert') { ?>
      <input type="submit" name="confirm" value="입력">
      <input type="reset" value="취소">
      <input type="button" value="뒤로"
        onclick="location.href='view_subject.php?action=manage'">
    <? } elseif ($action=='delete') { ?>
      <strong class="red" style="margin-right:10px">
      삭제하겠습니까?
      </strong>
      <input type="submit" name="confirm" value="확인">
      <input type="button" value="뒤로"
        onclick="location.href='view_subject.php?action=manage'">
    <? } ?>
  </div>

  </form>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>