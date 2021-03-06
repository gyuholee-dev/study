<?php
require_once 'includes/init.php';

$action = 'update';
$title = '시험 수정';
$fileName = 'manage_student.php';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if ($action == 'delete') {
  $title = '시험 삭제';
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

  $serialno = $_POST['serialno'];
  $subjcode = $_POST['subjcode'];
  $studnumb = $_POST['studnumb'];
  $exam_1st = $_POST['exam_1st'];
  $exam_2nd = $_POST['exam_2nd'];
  $exam_3rd = $_POST['exam_3rd'];
  
  if ($action == 'update') {
    $sql = "UPDATE examines
            SET
            subjcode = '$subjcode',
            studnumb = '$studnumb',
            exam_1st = '$exam_1st',
            exam_2nd = '$exam_2nd',
            exam_3rd = '$exam_3rd'
            WHERE serialno = '$serialno'
            ";
    echo $sql;

  } elseif ($action == 'insert') {
    $sql = "INSERT INTO examines 
            (
              subjcode,
              studnumb,
              exam_1st,
              exam_2nd,
              exam_3rd
            )
            VALUES (
              '$subjcode',
              '$studnumb',
              '$exam_1st',
              '$exam_2nd',
              '$exam_3rd'
            )
            ";
    echo $sql;

  } elseif ($action == 'delete') {
    $sql = "DELETE FROM examines
            WHERE serialno = '$serialno'";
    echo $sql;

  }

}

$sql = "SELECT 
        examines.*,
        (
          SELECT studname
          FROM student
          WHERE subjcode = examines.subjcode
          AND studnumb = examines.studnumb
        ) AS studname,
        (
          SELECT subjname
          FROM subject
          WHERE subjcode = examines.subjcode
        ) AS subjname
        FROM examines ";
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
        $serialno = $a['serialno'];
        // echo '<tr>';
        // echo '<th>시리얼</th>';
        // echo '<td>';
        // echo '<input value="'.$a['serialno'].'" '.
        //       'type="text" name="serialno" '.
        //       'readonly required>';
        // echo '</td>';
        // echo '</tr>';

        echo '<tr>';
        echo '<th>코드</th>';
        echo '<td>';
        echo '<input value="'.$a['subjcode'].'" '.
              'type="text" name="subjcode" '.
              'readonly required>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>과정</th>';
        echo '<td>';
        echo '<input value="'.$a['subjname'].'" '.
              'type="text" name="subjname" '.
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
              'readonly required>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>1차시험</th>';
        echo '<td>';
        echo '<input value="'.$a['exam_1st'].'" '.
              'type="number" name="exam_1st" '.
              'required>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>2차시험</th>';
        echo '<td>';
        echo '<input value="'.$a['exam_2nd'].'" '.
              'type="number" name="exam_2nd" '.
              'required>';
        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<th>3차시험</th>';
        echo '<td>';
        echo '<input value="'.$a['exam_3rd'].'" '.
              'type="number" name="exam_3rd" '.
              'required>';
        echo '</td>';
        echo '</tr>';

      }
    ?>
  </table>
  <?echo$action=='delete'?'</div>':''?>
  
  <div class="tbMenu">
    <input type="hidden" name="action" value="<?=$action?>">
    <input type="hidden" name="serialno" value="<?=$serialno?>">
    <? if ($action=='update') { ?>
      <input type="submit" name="confirm" value="입력">
      <input type="reset" value="취소">
      <input type="button" value="뒤로"
        onclick="location.href='view_examines.php?action=manage'">
    <? } elseif ($action=='delete') { ?>
      <strong class="red" style="margin-right:10px">
      삭제하겠습니까?
      </strong>
      <input type="submit" name="confirm" value="확인">
      <input type="button" value="뒤로"
        onclick="location.href='view_examines.php?action=manage'">
    <? } ?>

  </form>

</div>
<!-- contents -->
<?php
include 'includes/_footer.php';
?>