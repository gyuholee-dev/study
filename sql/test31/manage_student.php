<?php
require_once 'includes/init.php';

$action = 'update';
$title = '수강생 수정';
$fileName = 'manage_student.php';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if ($action == 'delete') {
  $title = '수강생 삭제';
}

$subjcode = '11';
$studnumb = '11';
$whereSql = '';
if (isset($_REQUEST['subjcode'])) {
  $subjcode = $_REQUEST['subjcode'];
}
if (isset($_REQUEST['studnumb'])) {
  $studnumb = $_REQUEST['studnumb'];
}

$whereSql = "WHERE subjcode = '$subjcode' 
             AND studnumb = '$studnumb' ";

if (isset($_POST['confirm'])) {
  $action = $_POST['action'];

  $subjcode = $_POST['subjcode'];
  $studnumb = $_POST['studnumb'];
  $studname = $_POST['studname'];
  $studgend = $_POST['studgend'];
  $phonnumb = $_POST['phonnumb'];
  $areaname = $_POST['areaname'];

  
  if ($action == 'update') {
    $sql = "UPDATE student
            SET
            studname = '$studname',
            studgend = '$studgend',
            phonnumb = '$phonnumb',
            areaname = '$areaname'
            WHERE subjcode = '$subjcode'
            AND studnumb = '$studnumb'
            ";
    echo $sql;

  } elseif ($action == 'insert') {
    $sql = "INSERT INTO student
            VALUES (
              '$subjcode',
              '$studnumb',
              '$studname',
              '$studgend',
              '$phonnumb',
              '$areaname',
            )
            ";
    echo $sql;

  } elseif ($action == 'delete') {
    $sql = "DELETE FROM student
            WHERE subjcode = '$subjcode'
            AND studnumb = '$studnumb'
            ";
    echo $sql;

  }

}

$sql = "SELECT * FROM student ";
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
        echo '<tr>';
        echo '<th>코드</th>';
        echo '<td>';
        echo '<input value="'.$a['subjcode'].'" '.
              'type="text" name="subjcode" '.
              'readonly required>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>학번</th>';
        echo '<td>';
        echo '<input value="'.$a['studnumb'].'" '.
              'type="text" name="studnumb" '.
              'readonly required>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>성명</th>';
        echo '<td>';
        echo '<input value="'.$a['studname'].'" '.
              'type="text" name="studname" '.
              'maxlength="10" required>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>성별</th>';
        echo '<td>';
        // echo '<input value="'.$a['studgend'].'" '.
        //       'type="text" name="studgend" '.
        //       'maxlength="10" required>';
        $checked = ['M'=>'','F'=>''];
        $checked[$a['studgend']] = ' checked';
        echo '<label><input type="radio" '.
              'name="studgend" value="M"'.$checked['M'].'>';
        echo '남</label>';
        echo '<label><input type="radio" '.
              'name="studgend" value="F"'.$checked['F'].'>';
        echo '여</label>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>연락처</th>';
        echo '<td>';
        echo '<input value="'.$a['phonnumb'].'" '.
              'type="text" name="phonnumb" '.
              'maxlength="13">';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>거주지</th>';
        echo '<td>';
        echo '<input value="'.$a['areaname'].'" '.
              'type="text" name="areaname" '.
              'maxlength="30">';
        echo '</td>';
        echo '</tr>';

      }
    ?>
  </table>
  <?echo$action=='delete'?'</div>':''?>

  <div class="tbMenu">
    <input type="hidden" name="action" value="<?=$action?>">
    <input type="hidden" name="subjcode" value="<?=$subjcode?>">
    <? if ($action=='update') { ?>
      <input type="submit" name="confirm" value="입력">
      <input type="reset" value="취소">
      <input type="button" value="뒤로"
        onclick="location.href='view_student.php?action=manage'">
    <? } elseif ($action=='delete') { ?>
      <strong class="red" style="margin-right:10px">
      삭제하겠습니까?
      </strong>
      <input type="submit" name="confirm" value="확인">
      <input type="button" value="뒤로"
        onclick="location.href='view_student.php?action=manage'">
    <? } ?>
  </div>

</form>

</div>
<!-- contents -->
<?php
include 'includes/_footer.php';
?>