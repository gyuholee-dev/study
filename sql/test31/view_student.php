<?php
require_once 'includes/init.php';

$action = 'view';
$title = '수강생 현황';
$fileName = 'view_student.php';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if ($action == 'manage') {
  $title = '수강생 관리';
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
$sql = "SELECT COUNT(*) FROM student ";
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);

$sql = "SELECT * FROM student ";
$sql = $sql.$whereSql;
$sql = $sql."LIMIT $start, $items ";
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

  <?php
    $tableW = 600;
    if ($action == 'manage') $tableW = 700;
  ?>
  <table cellpadding="3" cellspacing="0" width="<?=$tableW?>px">
    <tr>
      <!-- <th>코드</th> -->
      <!-- <th>과정명</th> -->
      <th>학번</th>
      <th>성명</th>
      <th>성별</th>
      <th>연락처</th>
      <th>거주지</th>
      <?php
        if ($action == 'manage') {
          echo '<th>수정</th>';
          echo '<th>삭제</th>';
        }
      ?>
    </tr>
    <?php
      while ($a = mysqli_fetch_assoc($res)){
        $studgend = '';
        if ($a['studgend'] == 'M') {
          $studgend = '남';
        } elseif ($a['studgend'] == 'F') {
          $studgend = '여';
        }
        echo '<tr>';
        // echo '<td>'.$a['subjcode'].'</td>';
        // echo '<td>'.$subjectList[$a['subjcode']].'</td>';
        echo '<td>'.$a['studnumb'].'</td>';
        echo '<td>'.$a['studname'].'</td>';
        echo '<td>'.$studgend.'</td>';
        echo '<td>'.$a['phonnumb'].'</td>';
        echo '<td>'.$a['areaname'].'</td>';
        if ($action == 'manage') {
          $updateUrl = 'manage_student.php?action=update'.
                       '&subjcode='.$a['subjcode'].'&studnumb='.$a['studnumb'];
          $deleteUrl = 'manage_student.php?action=delete'.
                       '&subjcode='.$a['subjcode'].'&studnumb='.$a['studnumb'];
          if ($subjectList[$subjcode]['usestate'] == 'Y') {
            echo '<td>'.'<a href="'.$updateUrl.'">수정</a>'.'</td>';
            echo '<td>'.'<a href="'.$deleteUrl.'">삭제</a>'.'</td>';
          } else {
            echo '<td>-</td>';
            echo '<td>-</td>';
          }
        }
        echo '</tr>';
      }
    ?>

  </table>


</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>