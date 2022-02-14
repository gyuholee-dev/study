<?php
require_once 'includes/init.php';

$action = 'edit';
$title = '모의고사 편집';
$fileName = 'edit_examines.php';

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
    // $serialno = $_POST['serialno'][$i];
    // $subjcode = $_POST['subjcode'][$i];
    $studnumb = $_POST['studnumb'][$i];
    $exam_1st = $_POST['exam_1st'][$i];
    $exam_2nd = $_POST['exam_2nd'][$i];
    $exam_3rd = $_POST['exam_3rd'][$i];

    // TODO: 삭제 및 추가


  }

}


$examinesList = array();
$sql = "SELECT studnumb, studname 
        FROM student ";
$sql = $sql.$whereSql;
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  $examinesList[$a['studnumb']] = [
    'studname' => $a['studname']
  ];
}

$sql = "SELECT 
        *,
        (exam_1st+exam_2nd+exam_3rd) AS total_score,
        ((exam_1st+exam_2nd+exam_3rd)/3) AS average_score 
        FROM examines 
        ";
$sql = $sql.$whereSql;
$sql = $sql."ORDER BY total_score DESC ";
$res = mysqli_query($db, $sql);
if (mysqli_num_rows($res) > 0) {
  $r = 1;
  while ($a = mysqli_fetch_assoc($res)) {
    $examinesList[$a['studnumb']]['exam_1st'] = $a['exam_1st'];
    $examinesList[$a['studnumb']]['exam_2nd'] = $a['exam_2nd'];
    $examinesList[$a['studnumb']]['exam_3rd'] = $a['exam_3rd'];
    $examinesList[$a['studnumb']]['total_score'] = $a['total_score'];
    $examinesList[$a['studnumb']]['average_score'] = $a['average_score'];
    $examinesList[$a['studnumb']]['ranking'] = $r;
    $r++;
  }
} else {
  foreach ($examinesList as $key => $value) {
    $examinesList[$key]['exam_1st'] = 0;
    $examinesList[$key]['exam_2nd'] = 0;
    $examinesList[$key]['exam_3rd'] = 0;
    $examinesList[$key]['total_score'] = 0;
    $examinesList[$key]['average_score'] = 0;
    $examinesList[$key]['ranking'] = 0;
  }
}


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

    function calScore() {
      var parent = document.getElementById('maintable').childNodes[1];
      var data = parent.getElementsByClassName('input');
      var ranking = [];

      var c = 0;
      for (let index = 0; index < data.length; index++) {
        // const elem = data[index].querySelectorAll('input');
        var exam_1st = 0;
        var exam_2nd = 0;
        var exam_3rd = 0;

        var total_score_input;
        var average_score_input;

        var elem = data[index].querySelectorAll('input');
        // console.log(elem);
        for (let i = 0; i < elem.length; i++) {
          var input = elem[i];
          // console.log(input.name);
          if (input.name == 'exam_1st[]') {
            exam_1st = Number(input.value);
          } else if (input.name == 'exam_2nd[]') {
            exam_2nd = Number(input.value);
          } else if (input.name == 'exam_3rd[]') {
            exam_3rd = Number(input.value);
          } else if (input.name == 'total_score[]') {
            total_score_input = input;
          } else if (input.name == 'average_score[]') {
            average_score_input = input;
          } else if (input.name == 'ranking[]') {
            ranking[c] = input;
          }
        }
        var score = exam_1st+exam_2nd+exam_3rd;
        total_score_input.value = score;
        average_score_input.value = Math.round(score/3);
        ranking[c].score = total_score_input.value;
        c++;
      }
      ranking.sort((x,y)=>y.score-x.score)
      // console.log(ranking);
      for (let i = 0; i < ranking.length; i++) {
        ranking[i].value = i+1;
      }
    }

  </script>

  <div class="tbMenu">
    <table class="inner" width="100%">
      <td class="left">
        <form method="get" action="" id="tbmenu">
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
                if ($subj['usestate'] == 'N') {
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
    <table id="maintable" cellpadding="3" cellspacing="0" width="600px">
      <tr>
        <th>학번</th>
        <th>성명</th>
        <th>1차</th>
        <th>2차</th>
        <th>3차</th>
        <th>총점</th>
        <th>평균</th>
        <th>석차</th>
      </tr>
      <?php
        foreach ($examinesList as $key => $a) {
          $total_score = $a['total_score'];
          $average_score = round($a['average_score']);
          echo '<tr id="stud_'.$key.'" class="input">';
          // echo '<td>'.$key.'</td>';
          // echo '<td>'.$data['studname'].'</td>';
          // echo '<td>'.$data['exam_1st'].'</td>';
          // echo '<td>'.$data['exam_2nd'].'</td>';
          // echo '<td>'.$data['exam_3rd'].'</td>';
          // echo '<td>'.$total_score.'</td>';
          // echo '<td>'.$average_score.'</td>';
          // echo '<td>'.$data['ranking'].'</td>';

          // 학번
          echo '<td>';
          echo '<input value="'.$key.'" '.
                'type="text" name="studnumb[]" size="1" '.
                'readonly required>';
          echo '</td>';
          // 성명
          echo '<td>';
          echo '<input value="'.$a['studname'].'" '.
                'type="text" name="studname[]" size="6" '.
                'maxlength="20" required readonly>';
          echo '</td>';
          // 1차
          echo '<td>';
          echo '<input value="'.$a['exam_1st'].'" '.
                'type="number" name="exam_1st[]" '.
                'style="width:45px" '.
                'onchange="calScore()" '.
                'required>';
          echo '</td>';
          // 2차
          echo '<td>';
          echo '<input value="'.$a['exam_2nd'].'" '.
                'type="number" name="exam_2nd[]" '.
                'style="width:45px" '.
                'onchange="calScore()" '.
                'required>';
          echo '</td>';
          // 3차
          echo '<td>';
          echo '<input value="'.$a['exam_3rd'].'" '.
                'type="number" name="exam_3rd[]" '.
                'style="width:45px" '.
                'onchange="calScore()" '.
                'required>';
          echo '</td>';
          // 총점
          echo '<td>';
          echo '<input value="'.$total_score.'" '.
                'type="text" name="total_score[]" '.
                'style="width:45px" '.
                'readonly>';
          echo '</td>';
          // 평균
          echo '<td>';
          echo '<input value="'.$average_score.'" '.
                'type="text" name="average_score[]" '.
                'style="width:45px" '.
                'readonly>';
          echo '</td>';
          // 석차
          echo '<td>';
          echo '<input value="'.$a['ranking'].'" '.
                'type="text" name="ranking[]" '.
                'style="width:45px" '.
                'readonly>';
          echo '</td>';

          echo '</tr>';
        }
      ?>

    </table>

    <div class="tbMenu">
      <input type="hidden" name="subjcode" value="<?=$subjcode?>">
      <input type="submit" name="update" value="입력">
      <input type="button" value="리셋"
        onclick="location.href='edit_examines.php?subjcode=<?=$subjcode?>'">
      <input type="button" value="메뉴"
        onclick="location.href='index.php'">
    </div>


  </form>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>
