<?php
require_once 'includes/init.php';
ini_set('display_errors', 0);

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

if (isset($_POST['update'])) {
  // $action = $_POST['action'];
  $listitems = count($_POST['subjcode']);
  // echo $listitems;

  for ($i=0; $i < $listitems; $i++) {
    $subjcode = $_POST['subjcode'][$i];
    $subjname = $_POST['subjname'][$i];
    $subjkind = $_POST['subjkind'][$i];
    $opendate = $_POST['opendate'][$i];
    $noperson = $_POST['noperson'][$i];
    $teacname = $_POST['teacname'][$i];
    $amtprice = $_POST['amtprice'][$i];
    $usestate = $_POST['usestate'][$i];

    // 삭제 조건
    if ($subjname=='') continue;

    // TODO: 삭제 및 추가

    // if ($i == $listitems-1) {
    //   echo $subjcode;
    // }

  }

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
  <form method="post">

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

    <table id="maintable" cellpadding="3" cellspacing="0">
      <tr>
        <th>코드</th>
        <th>과정명</th>
        <th>강의대상</th>
        <th>개강일자</th>
        <th>모집정원</th>
        <th>교사명</th>
        <th>수강료</th>
        <th>진행</th>
      </tr>
        <style>
          tr.unused {
            background-color: rgba(0,0,0,0.1);
          }
        </style>
        <script>
          function expandRow() {
            lastCode = lastCode+1;
            var target = document.getElementById('tr_end');
            var html = '<tr>';
            html += '<td>'+
                    '<input value="'+lastCode+'" '+
                    'type="text" name="subjcode[]" size="1" readonly>'+
                    '</td>';
            html += '<td>'+
                    '<input value="" type="text" name="subjname[]" size="6" maxlength="20">'+
                    '</td>';
            html += '<td>'+
                    '<label><input type="radio" name="subjkind['+cnt+']" value="1">초</label>'+
                    '<label><input type="radio" name="subjkind['+cnt+']" value="2">중</label>'+
                    '<label><input type="radio" name="subjkind['+cnt+']" value="3">고</label>'+
                    '</td>';
            html += '<td>'+
                    '<input value="" type="date" name="opendate[]">'+
                    '</td>';
            html += '<td>'+
                    '<input value="" type="number" name="noperson[]" style="width:45px">'+
                    '</td>';
            html += '<td>'+
                    '<input value="" type="text" name="teacname[]" size="6" maxlength="10">'+
                    '</td>';
            html += '<td>'+
                    '<input value="" type="number" name="amtprice[]" style="width:80px">'+
                    '</td>';
            // html += '<td>'+
            //         '<label><input type="radio" name="usestate['+cnt+']" value="Y" checked>진행중</label>'+
            //         '<label><input type="radio" name="usestate['+cnt+']" value="N">종료</label>'+
            //         '</td>';
            html += '<td>'+
                    '진행중<input type="hidden" name="usestate[]" value="Y">'+
                    '</td>';
            html += '</tr>';
            
            const template = document.createElement('template');
            template.innerHTML = html;
            document.getElementById('maintable').childNodes[1]
              .insertBefore(template.content.firstChild, target);
            // console.log(lastCode);
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
        $lastCode = 11;
        $cnt = 0;
        while ($a = mysqli_fetch_assoc($res)) {
          $readonly = '';
          $onclick = '';
          // echo ($a['usestate']=='N')? '<tr class="unused">' : '<tr>';
          if ($a['usestate']=='N') {
            $readonly = ' readonly';
            $onclick = ' onclick="return(false);"';
            echo '<tr class="unused">';
          } else {
            echo '<tr>';
          }
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
                'maxlength="20" required'.$readonly.'>';
          echo '</td>';
          // 강의대상
          echo '<td>';
          $checked = [1=>'',2=>'',3=>''];
          $checked[$a['subjkind']] = ' checked';
          echo '<label><input type="radio" '.
                'name="subjkind['.$cnt.']" value="1"'.$checked[1].$onclick.'>';
          echo '초</label>';
          echo '<label><input type="radio" '.
                'name="subjkind['.$cnt.']" value="2"'.$checked[2].$onclick.'>';
          echo '중</label>';
          echo '<label><input type="radio" '.
                'name="subjkind['.$cnt.']" value="3"'.$checked[3].$onclick.'>';
          echo '고</label>';
          echo '</td>';
          // 개강일자
          echo '<td>';
          echo '<input value="'.$a['opendate'].'" '.
                'type="date" name="opendate[]" '.
                'required'.$readonly.'>';
          echo '</td>';
          // 모집정원
          echo '<td>';
          echo '<input value="'.$a['noperson'].'" '.
                'type="number" name="noperson[]" '.
                'style="width:45px" '.
                'required'.$readonly.'>';
          echo '</td>';
          // 교사명
          echo '<td>';
          echo '<input value="'.$a['teacname'].'" '.
                'type="text" name="teacname[]" size="6" '.
                'maxlength="10" required'.$readonly.'>';
          echo '</td>';
          // 수강료
          echo '<td>';
          echo '<input value="'.$a['amtprice'].'" '.
                'type="number" name="amtprice[]" '.
                'style="width:80px" '.
                'required'.$readonly.'>';
          echo '</td>';
          // 진행여부
          // echo '<td>';
          // $checked = ['Y'=>'','N'=>''];
          // $checked[$a['usestate']] = ' checked';
          // echo '<label><input type="radio" '.
          //       'name="usestate['.$cnt.']" value="Y"'.$checked['Y'].$onclick.'>';
          // echo '진행중</label>';
          // echo '<label><input type="radio" '.
          //       'name="usestate['.$cnt.']" value="N"'.$checked['N'].$onclick.'>';
          // echo '종료</label>';
          // echo '</td>';
          echo '<td>';
          $usestate = ['Y'=>'진행중','N'=>'종료'];
          echo $usestate[$a['usestate']];
          echo '<input type="hidden" name="usestate[]" value="'.$a['usestate'].'">';
          echo '</td>';

          echo '</tr>';
          $cnt++;
          $lastCode = $a['subjcode'];
        }

        echo '<tr id="tr_end">';
        echo '</tr>';

        echo '<tr id="expand">';
        echo '<td><a href="#tr_end" onclick="expandRow()">추가</a></td>';
        // echo '<td colspan="8"></td>';
        // echo '<td>+</td>';
        echo '<td colspan="6">';
        echo "<script>var lastCode=$lastCode; var cnt=$cnt;</script>";
        echo "</td><td>";
        echo '<div class="right"><a href="#tr_end" onclick="deleteRow()">삭제</a></div>';
        echo '</td>';
        echo '</tr>';

      ?>
    </table>

    <div class="tbMenu">
      <!-- <input type="hidden" name="action" value="update"> -->
      <input type="submit" name="update" value="입력">
      <!-- <input type="reset" value="취소"> -->
      <input type="button" value="리셋"
        onclick="location.href='edit_subject.php'">
      <input type="button" value="메뉴"
        onclick="location.href='index.php'">
    </div>
  
  </form>

</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>