<?php
require_once 'includes/init.php';

$action = 'view';
$title = '모의고사 성적';
$fileName = 'view_examines.php';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if ($action == 'manage') {
  $title = '모의고사 관리';
}

$items = 99;
$page = 1;
$pageCount = 1;
$start = 0;
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}

$subjcode = '11';
$whereSql = '';

$subjectList = array();
$sql = "SELECT subjcode, subjname, usestate 
        FROM subject ";
// $sql .= "ORDER BY subjname ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  $subjectList[$a['subjcode']] = [
    'subjname' => $a['subjname'],
    'usestate' => $a['usestate']
  ];
}
if ($action == 'manage' || !isset($_REQUEST['subjcode'])) {
  foreach ($subjectList as $key => $value) {
    if ($value['usestate'] == 'Y') {
      $subjcode = $key;
      break;
    }
  }
}

if (isset($_REQUEST['subjcode'])) {
  $subjcode = $_REQUEST['subjcode'];
}
$whereSql = "WHERE subjcode = '$subjcode' ";

$start = ($page-1)*$items;
$sql = "SELECT COUNT(*) FROM examines ";
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);

$sql = "SELECT 
        examines.*,
        (
          SELECT studname
          FROM student
          WHERE subjcode = examines.subjcode
          AND studnumb = examines.studnumb
        ) AS studname,
        (exam_1st+exam_2nd+exam_3rd) AS total_score,
        ((exam_1st+exam_2nd+exam_3rd)/3) AS average_score
        FROM examines 
        ";
$sql = $sql.$whereSql;
$sql = $sql."ORDER BY total_score DESC ";
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
          <input type="hidden" name="action" value="<?=$action?>">
          <label for="subjcode">과목</label>
          <select name="subjcode" id="subjcode" onchange="changeView()">
            <!-- <option value="all">전체</option> -->
            <?php
              foreach ($subjectList as $code => $subj) {
                $usestate = ['Y'=>'진행중','N'=>'종료'];
                $subjname = $subj['subjname'].' ('.$usestate[$subj['usestate']].')';
                $selected = '';
                if ($subjcode == $code) {
                  $selected = ' selected';
                }
                $disabled = '';
                if ($action == 'manage' && $subj['usestate'] == 'N') {
                  $disabled = ' disabled';
                }
                echo '<option value="'.$code.'"'.
                $selected.$disabled.'>'.$subjname.'</option>';
              }
            ?>
          </select>
        </form>
      </td>
      <td class="right">
        <!-- <input type="button" value="초기화"
        onclick="location.href='<?=$fileName?>'"> -->
        <input type="button" value="메뉴"
        onclick="location.href='index.php'">
      </td>
    </table>
  </div>

  <table cellpadding="3" cellspacing="0" width="600px">
    <tr>
      <!-- <th>코드</th> -->
      <!-- <th>과정명</th> -->
      <th>성명</th>
      <th>석차</th>
      <th>1차</th>
      <th>2차</th>
      <th>3차</th>
      <th>총점</th>
      <th>평균</th>
      <?php
        if ($action == 'manage') {
          echo '<th>수정</th>';
          echo '<th>삭제</th>';
        }
      ?>
    </tr>
    
    <?php
      $rank = 1;
      while ($a = mysqli_fetch_assoc($res)) {
        $ranking = $rank.'등';
        $exam_1st = $a['exam_1st'].'점';
        $exam_2nd = $a['exam_2nd'].'점';
        $exam_3rd = $a['exam_3rd'].'점';
        $total_score = $a['total_score'].'점';
        $average_score = round($a['average_score']).'점';
        echo '<tr>';
        echo '<td>'.$a['studname'].'</td>';
        echo '<td>'.$ranking.'</td>';
        echo '<td>'.$exam_1st.'</td>';
        echo '<td>'.$exam_2nd.'</td>';
        echo '<td>'.$exam_3rd.'</td>';
        echo '<td>'.$total_score.'</td>';
        echo '<td>'.$average_score.'</td>';
        if ($action == 'manage') {
          $updateUrl = 'manage_examines.php?action=update'.
                       '&subjcode='.$a['subjcode'].'&studnumb='.$a['studnumb'];
          $deleteUrl = 'manage_examines.php?action=delete'.
                       '&subjcode='.$a['subjcode'].'&studnumb='.$a['studnumb'];
          echo '<td>'.'<a href="'.$updateUrl.'">수정</a>'.'</td>';
          echo '<td>'.'<a href="'.$deleteUrl.'">삭제</a>'.'</td>';
        }
        echo '</tr>';
        echo '</tr>';
        $rank++;
      }

    ?>
  </table>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>