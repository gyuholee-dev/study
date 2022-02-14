<?php
require_once 'includes/init.php';

$action = 'edit';
$title = '수강생 편집';
$fileName = 'edit_student.php';

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
if (!isset($_REQUEST['subjcode'])) {
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


if (isset($_POST['update'])) {
  $listitems = count($_POST['studnumb']);

  $subjcode = $_POST['subjcode'];
  for ($i=0; $i < $listitems; $i++) {
    // $subjcode = $_POST['subjcode'][$i];
    $studnumb = $_POST['studnumb'][$i];
    $studname = $_POST['studname'][$i];
    $studgend = $_POST['studgend'][$i];
    $phonnumb = $_POST['phonnumb'][$i];
    $areaname = $_POST['areaname'][$i];

    // TODO: 삭제 및 추가


  }

}

$sql = "SELECT COUNT(*) FROM student ";
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];

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

  <form method="post">
    <table id="maintable" cellpadding="3" cellspacing="0">
      <tr>
        <!-- <th>코드</th> -->
        <!-- <th>과정명</th> -->
        <th>학번</th>
        <th>성명</th>
        <th>성별</th>
        <th>연락처</th>
        <th>거주지</th>
      </tr>
        <style>
          tr.unused {
            background-color: rgba(0,0,0,0.1);
          }
        </style>
      <script>
          function expandRow() {
            lastNumb = lastNumb+1;
            var target = document.getElementById('tr_end');
            var html = '<tr>';
            html += '<td>'+
                    '<input value="'+lastNumb+'" '+
                    'type="text" name="studnumb[]" size="1" readonly>'+
                    '</td>';
            html += '<td>'+
                    '<input value="" type="text" name="studname[]" size="6" maxlength="10">'+
                    '</td>';
            html += '<td>'+
                    '<label><input type="radio" name="studgend['+cnt+']" value="M">남</label>'+
                    '<label><input type="radio" name="studgend['+cnt+']" value="F">여</label>'+
                    '</td>';
            html += '<td>'+
                    '<input value="" type="text" name="phonnumb[]" size="10" maxlength="13">'+
                    '</td>';
            html += '<td>'+
                    '<input value="" type="text" name="areaname[]" size="20" maxlength="20">'+
                    '</td>';
            html += '</tr>';
            
            const template = document.createElement('template');
            template.innerHTML = html;
            document.getElementById('maintable').childNodes[1]
              .insertBefore(template.content.firstChild, target);
            // console.log(lastNumb);
            cnt = cnt+1;
          }

          function deleteRow() {
            var parent = document.getElementById('maintable').childNodes[1];
            var count = parent.childElementCount;
            // console.log(parent);
            // console.log(parent.childNodes[count]);
            // console.log(parent.childNodes[count].className);
            if (parent.childNodes[count].className == 'unused') {
              return false;
            } else {
              parent.childNodes[count].remove();
            }
          }
        </script>
      <?php
        $lastNumb = 11;
        $cnt = 0;
        while ($a = mysqli_fetch_assoc($res)){
          echo '<tr>';
          // 학번
          echo '<td>';
          echo '<input value="'.$a['studnumb'].'" '.
                'type="text" name="studnumb[]" size="1" '.
                'maxlength="2" required readonly>';
          echo '</td>';
          // 성명
          echo '<td>';
          echo '<input value="'.$a['studname'].'" '.
                'type="text" name="studname[]" size="6" '.
                'maxlength="10" required>';
          echo '</td>';
          // 성별
          echo '<td>';
          $checked = ['M'=>'','F'=>''];
          $checked[$a['studgend']] = ' checked';
          echo '<label><input type="radio" '.
                'name="studgend['.$cnt.']" value="M"'.$checked['M'].'>';
          echo '남</label>';
          echo '<label><input type="radio" '.
                'name="studgend['.$cnt.']" value="F"'.$checked['F'].'>';
          echo '여</label>';
          echo '</td>';
          // 연락처
          echo '<td>';
          echo '<input value="'.$a['phonnumb'].'" '.
                'type="text" name="phonnumb[]" size="10" '.
                'maxlength="13">';
          echo '</td>';
          // 거주지
          echo '<td>';
          echo '<input value="'.$a['areaname'].'" '.
                'type="text" name="areaname[]" size="20" '.
                'maxlength="20">';
          echo '</td>';

          echo '</tr>';
          $cnt++;
          $lastNumb = $a['studnumb'];
        }

        echo '<tr id="tr_end">';
        echo '</tr>';

        echo '<tr id="expand">';
        echo '<td><a href="#tr_end" onclick="expandRow()">추가</a></td>';
        // echo '<td colspan="8"></td>';
        // echo '<td>+</td>';
        echo '<td colspan="4" class="right">';
        echo "<script>var lastNumb=$lastNumb; var cnt=$cnt;</script>";
        // echo "</td><td>";
        echo '<a href="#tr_end" onclick="deleteRow()">삭제</a>';
        echo '</td>';
        echo '</tr>';

      ?>
    </table>

    <div class="tbMenu">
      <input type="hidden" name="subjcode" value="<?=$subjcode?>">
      <input type="submit" name="update" value="입력">
      <input type="button" value="리셋"
        onclick="location.href='edit_student.php?subjcode=<?=$subjcode?>'">
      <input type="button" value="메뉴"
        onclick="location.href='index.php'">
    </div>

  </form>


</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>

