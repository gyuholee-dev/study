<?php
require_once 'includes/init.php';

$action = 'insert';
$title = $tableName.' 등록';

$studs = 0;
$studcnt = 10;
$numb = 1;
$cous = '111';

$studList = array();


if (isset($_REQUEST['studcnt'])) {
  $studcnt = $_REQUEST['studcnt'];
}
if (isset($_REQUEST['cous'])) {
  $cous = $_REQUEST['cous'];
}

if (isset($_POST['insert'])) {
  // print_r($_POST);
  $cous = $_POST['cous'];
  for ($i=0; $i < $studcnt; $i++) {
    $numb = $_POST['numb'][$i];
    $name = $_POST['name'][$i];
    $phon = $_POST['phon'][$i];
    $jobb = $_POST['jobb'][$i];

    // 레코드 존재 체크
    $sql = "SELECT * FROM stud WHERE numb='$numb'";
    $res = mysqli_query($db, $sql);

    if (mysqli_num_rows($res) != 0) { // 존재할 경우
      // TODO: 업데이트 또는 딜리트
      $sql = "UPDATE stud SET
              name = '$name',
              phon = '$phon',
              jobb = '$jobb'
              WHERE numb = '$numb'
              ";
      mysqli_query($db, $sql);
      
    } else { // 존재하지 않을 경우
      // 인서트
      $sql = "INSERT INTO stud 
              VALUES ('$cous', '$numb', '$name', '$phon', '$jobb')";
      // echo $sql.'<br>';
      mysqli_query($db, $sql);
    }
  }
  // $msg = '데이터 입력 완료';
  // $url = 'insert.php';
  // sendMsg($msg, $url);
}

$sql = "SELECT * FROM stud
WHERE cous = '$cous'";
$res = mysqli_query($db, $sql);
$studs = mysqli_num_rows($res);

if (getCountRecords('stud') > 0) {
  // $sql = "SELECT MIN(numb) FROM stud 
  //         WHERE cous = '$cous'";
  // $res = mysqli_query($db, $sql);
  // $numb = mysqli_fetch_row($res)[0];

  if ($studs > $studcnt) {
    $studcnt = $studs;
  }

  $i = 0;
  while ($a = mysqli_fetch_assoc($res)) {
    $studList[$i] = array();
    foreach ($a as $key => $value) {
      $studList[$i][$key] = $value;
    }
    $i++;
  }
  // print_r($studList);
}

$sql = "SELECT * FROM lect";
$lect = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
    include 'includes/_header.php';
?>
<h3><?=$title?></h3>
<hr>
<!-- Contents -->

<div class="tbContents">
  
  <div class="tbMenu">

    <script>
      function changeView(value) {
        // var form = document.getElementById('tbinput');
        // var input = form.getElementsByTagName('input');
        // console.log(input);
        // console.log(input[1].name);
        // console.log(input[1].value);
        
        var form = document.getElementById('tbmenu');
        form.submit();
      }
    </script>

    <table class="inner" width="100%">
      <form id="tbmenu" method="get">
        <tr>
          <td class="left">

            <label>과정선택 
              <select name="cous" onchange="changeView()">
              <?php
                while ($a = mysqli_fetch_row($lect)) {
                  if ($cous == $a[0]) {
                    echo '<option value='.$a[0].' selected>'.
                          $a[1].'</option>';
                  } else {
                    echo '<option value='.$a[0].'>'.
                          $a[1].'</option>';
                  }
                }
              ?>
              </select>
            </label>

          </td>
          <td class="right">

            <label>수강생수 
              <input type="number" min="<?=$studs?>" max="99"
                name="studcnt" value="<?=$studcnt?>"
                style="width: 50px;" onchange="changeView()">
            </label>

          </td>
        </tr>
      </form>
    </table>
  </div>
  
  <form id="tbinput" method="post" autocomplete="off">
    <input type="hidden" name="cous" value="<?=$cous?>">

    <table cellpadding="3" cellspacing="0">
      <tr>
        <th>학번</th>
        <th>성명</th>
        <th>연락처</th>
        <th>직업</th>
      </tr>

      <?php
        $cnt = 0;
        if ($studs > 0) {
          for ($i=0; $i<$studs; $i++) {
            echo '<tr>';
            echo '<td>'.$studList[$i]['numb'].
                 '<input type="hidden" name="numb"'. 
                 'value="'.$studList[$i]['numb'].'"</td>';
            echo '<td><input name="name['.$i.']"'.
                 'value="'.$studList[$i]['name'].'"'.
                 'size="10" type="text" maxlength="10"></td>';
            echo '<td><input name="phon['.$i.']"'.
                 'value="'.$studList[$i]['phon'].'"'.
                 'size="10" type="text" maxlength="13"></td>';
            echo '<td><input name="jobb['.$i.']"'.
                 'value="'.$studList[$i]['jobb'].'"'.
                 'size="10" type="text" maxlength="10"></td>';
            echo '</tr>';
            $cnt = $i+1;
            $numb = (int)$studList[$i]['numb']+1;
          }
        }

        for ($i=$cnt; $i<$studcnt; $i++) {
          $n = numStr($numb,2);
          echo '<tr>';
          echo '<td>'.$n.
               '<input type="hidden" name="numb"'. 
               'value="'.$n.'"</td>';
          echo '<td><input name="name['.$i.']"'.
               'size="10" type="text" maxlength="10"></td>';
          echo '<td><input name="phon['.$i.']"'.
               'size="10" type="text" maxlength="13"></td>';
          echo '<td><input name="jobb['.$i.']"'.
               'size="10" type="text" maxlength="10"></td>';
          echo '</tr>';
          $numb = $numb+1;
        }
        
      ?>

    </table>
  
    <div class="tbMenu">
        <input type="submit" name="insert" value="입력">
        <input type="reset" value="취소">
        <input type="button" value="초기화" onclick="location.href='insert.php'">
    </div>

  </form>
</div>

<!-- Contents -->
<?php
    // include 'includes/_menu.php';
?> 
<?php
    include 'includes/_footer.php';
?>