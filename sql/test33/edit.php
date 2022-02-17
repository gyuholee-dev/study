<?php
require_once 'init.php';

// 변수
$action = 'update';
$table = 'dailyreport';
$tableName = '일일업무일지';
$title = "$tableName 수정";
$fileName = 'edit.php';

// action 처리
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if ($action == 'insert') {
  $title = "$tableName 등록";
} elseif ($action == 'delete') {
  $title = "$tableName 삭제";
}

// 페이지 변수
$page = 1;
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}

// 카테고리 변수
$date = 'all';
$name = 'all';
if (isset($_REQUEST['date'])) {
  $date = $_REQUEST['date'];
}
if (isset($_REQUEST['name'])) {
  $name = $_REQUEST['name'];
}

// url 기본 파라메터
$urlParam = "&page=$page&date=$date&name=$name";

// 수정, 추가, 삭제, 등록 처리
if (isset($_POST['confirm'])) {

  $action = $_POST['action'];
  if ($action == 'delete') {
    $seqn = $_POST['seqn'];
  } else {
    $seqn = $_POST['seqn'];
    $yymd = $_POST['yymd'];
    $empl = $_POST['empl'];
    $innn = $_POST['innn'];
    $outt = $_POST['outt'];
    $kind = $_POST['kind'];
    $todw = $_POST['todw'];
    $nxdw = $_POST['nxdw'];

    $innn = str_replace(':', '', $innn);
    $outt = str_replace(':', '', $outt);
  }

  if ($action == 'update') {
    $sql = "UPDATE dailyreport
            SET
            yymd = '$yymd',
            empl = '$empl',
            innn = '$innn',
            outt = '$outt',
            kind = '$kind',
            todw = '$todw',
            nxdw = '$nxdw'
            WHERE seqn = '$seqn'
            ";
    // echo $sql;
    $msg = "$tableName 수정 완료";

  } elseif ($action == 'insert' || $action == 'register') {
    $sql = "INSERT INTO dailyreport 
            (yymd, empl, innn, outt, kind, todw, nxdw)
            VALUES 
            ('$yymd','$empl','$innn','$outt','$kind','$todw','$nxdw')";
    // echo $sql;
    $msg = "$tableName 등록 완료";

  } elseif ($action == 'delete') {
    $sql = "DELETE FROM dailyreport WHERE seqn = '$seqn'";
    // echo $sql;
    $msg = "$tableName 삭제 완료";

  }

  // echo $sql;

  try {
    mysqli_query($db, $sql);
  } catch (mysqli_sql_exception $e) {
    exit($e);
  }

  if ($action == 'insert') {
    $url = "edit.php?action=insert&pdate=$yymd";
    if (isset($_REQUEST['page'])) {
      $url .= $urlParam;
    }
  } else {
    $url = "view.php?action=manage$urlParam";
  }
  echo "<script> alert('$msg'); location.href='$url'; </script>";


}

// 레코드 갯수 검사
$sql = "SELECT COUNT(*) FROM dailyreport";
$res = mysqli_query($db, $sql);
$reqCnt = mysqli_fetch_row($res)[0];

// 시퀀스 처리
$seqn = 1;
if (isset($_REQUEST['seqn'])) {
  $seqn = $_REQUEST['seqn'];
}

// pdate 처리
$pdate = date('Y-m-d');
if (isset($_REQUEST['pdate'])) {
  $pdate = $_REQUEST['pdate'];
}

// 이름 리스트
$nameList = array();
$sql = "SELECT DISTINCT(empl) AS name
        from dailyreport ORDER BY name ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($nameList, $a['name']);
}

// 기본값 처리
$data = array();
if ($reqCnt == 0 || $action == 'insert') {
  $data['seqn'] = $seqn;
  $data['yymd'] = $pdate;
  $data['empl'] = '';
  $data['innn'] = '0900';
  $data['outt'] = '1800';
  $data['kind'] = '관리';
  $data['todw'] = '';
  $data['nxdw'] = '';
} else {
  $sql = "SELECT * FROM dailyreport ";
  $sql .= " WHERE seqn = '$seqn' ";
  $res = mysqli_query($db, $sql);
  $data = mysqli_fetch_assoc($res);
}


?>
<!-- html -->
<?php
  include $htmlHeader;
?>
<h2 class="title"><?=$title?></h2>
<!-- <hr> -->
<!-- contents -->
<div class="tbContents">
  <form method="post">
    <input type='hidden' name='page' value='<?=$page?>'>
    <input type='hidden' name='date' value='<?=$date?>'>
    <input type='hidden' name='name' value='<?=$name?>'>
    
    <div id="tableWrap">
    <?echo$action=='delete'?'<div class="boxwrap">':''?>
    <?echo$action=='delete'?'<div class="dimm disabled"></div>':''?>
    <table cellpading="3" cellspacing="1">
    <?php
      // 데이터 가공
      $options = '<option></option>';
      foreach($nameList as $key => $value) {
        $selected = ($data['empl'] == $value)?'selected':'';
        $options .= "<option value='$value' $selected>$value</option>";
      }

      $data['innn'] = date('H:i', strtotime($data['innn']));
      $data['outt'] = date('H:i', strtotime($data['outt']));
      $checked = ['관리'=>'', '영업'=>''];
      $checked[$data['kind']] = 'checked';

      echo "
        <input type='hidden' name='seqn' value='$data[seqn]'>

        <tr><th>업무일자</th>
        <td width='200'>
          <input value='$data[yymd]'
          type='date' name='yymd' required>
        </td></tr>
        <tr><th>사원명</th>
        <td>
          <select name='empl' style='width:100%'>$options</select>
        </td></tr>
        <tr><th>업무구분</th>
        <td>
          <label>
          <input value='관리' $checked[관리]
          type='radio' name='kind' required>
          관리</label>
          <label>
          <input value='관리' $checked[영업]
          type='radio' name='kind' required>
          영업</label>
        </td></tr>
        <tr><th>시작시간</th>
        <td>
          <input value='$data[innn]'
          type='time' name='innn' required>
        </td></tr>
        <tr><th>종료시간</th>
        <td>
          <input value='$data[outt]'
          type='time' name='outt' required>
        </td></tr>
        <tr><th>금일업무</th>
        <td>
          <textarea name='todw'
          style='height:auto'>$data[todw]</textarea>
        </td></tr>
        <tr><th>익일업무</th>
        <td>
          <textarea name='nxdw'
          style='height:auto'>$data[nxdw]</textarea>
        </td></tr>
      ";

    ?>
    </table>
    <?echo$action=='delete'?'</div>':''?>
    </div>

    <div class="tbMenu">
      <?php
        echo "<input type='hidden' name='action' value='$action'>";

        if ($action=='delete') {
          echo "
            <strong class='red' style='margin-right:10px; font-size:125%;'>
            삭제하겠습니까?</strong> 
            <input type='submit' name='confirm' value='확인'> ";
        } else {
          echo "
            <input type='submit' class='active' name='confirm' value='입력'> 
            <input type='reset' value='취소'> ";
        }

      if (isset($_REQUEST['page'])) {
        echo "
          <input type='button' value='뒤로'
          onclick='location.href=\"view.php?action=manage$urlParam\"'>
        ";
        } else {
          echo "
            <input type='button' value='메뉴'
            onclick='location.href=\"index.php\"'>
          ";
        }

      ?>
    </div>
  
  </form>
</div>
<!-- contents -->
<?php
  include $htmlFooter;
?>