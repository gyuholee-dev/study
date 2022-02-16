<?php
require_once 'init.php';

$fileName = 'edit.php';
$action = 'update';
$title = '구매요청 편집';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if ($action == 'insert') {
  $title = '구매요청 추가';
} elseif ($action == 'delete') {
  $title = '구매요청 삭제';
} elseif ($action == 'register') {
  $title = '구매요청 등록';
}

// 페이지 및 분류 처리
$page = 1;
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
$stat = 'all';
if (isset($_REQUEST['stat'])) {
  $stat = $_REQUEST['stat'];
}
$urlParam = "&page=$page&stat=$stat";

// 수정, 추가, 삭제, 등록 처리
if (isset($_POST['confirm'])) {

  $action = $_POST['action'];
  if ($action == 'delete') {
    $sequence = $_POST['sequence'];
  } else {
    $sequence = $_POST['sequence'];
    $reqrdate = $_POST['reqrdate'];
    $reqrnumb = $_POST['reqrnumb'];
    $reqrqnty = $_POST['reqrqnty'];
    $reqrpers = $_POST['reqrpers'];
    $ordrdate = $_POST['ordrdate'];
    $ordrsupp = $_POST['ordrsupp'];
    $dueedate = $_POST['dueedate'];
  }

  if ($action == 'update') {
    $sql = "UPDATE requestt
            SET
            reqrdate = '$reqrdate',
            reqrnumb = '$reqrnumb',
            reqrqnty = '$reqrqnty',
            reqrpers = '$reqrpers',
            ordrdate = '$ordrdate',
            ordrsupp = '$ordrsupp',
            dueedate = '$dueedate'
            WHERE sequence = '$sequence'
            ";
    // echo $sql;
    $msg = "구매요청 수정 완료";

  } elseif ($action == 'insert' || $action == 'register') {
    $sql = "INSERT INTO requestt (
              reqrdate,
              reqrnumb,
              reqrqnty,
              reqrpers,
              ordrdate,
              ordrsupp,
              dueedate
            )
            VALUES (
              '$reqrdate',
              '$reqrnumb',
              '$reqrqnty',
              '$reqrpers',
              '$ordrdate',
              '$ordrsupp',
              '$dueedate'
            )";
    // echo $sql;
    $msg = "구매요청 등록 완료";

  } elseif ($action == 'delete') {
    $sql = "DELETE FROM requestt WHERE sequence = '$sequence'";
    // echo $sql;
    $msg = "구매요청 삭제 완료";

  }

  try {
    mysqli_query($db, $sql);
  } catch (mysqli_sql_exception $e) {
    exit($e);
  }

  if ($action == 'insert' || $action == 'register') {
    $url = "edit.php?action=$action";
    if (isset($_REQUEST['page']) && isset($_REQUEST['stat'])) {
      $url .= $urlParam;
    }
  } else {
    $url = "view.php?action=manage$urlParam";
  }
  echo "<script> alert('$msg'); location.href='$url'; </script>";

}


// 레코드 갯수 검사
$sql = "SELECT COUNT(*) FROM requestt";
$res = mysqli_query($db, $sql);
$reqCnt = mysqli_fetch_row($res)[0];

// 시퀀스 처리
$sequence = 1;
if (isset($_REQUEST['sequence'])) {
  $sequence = $_REQUEST['sequence'];
}

$assetList = array();
$sql = "SELECT * FROM fixasset ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  if ($a['asstprce'] < 100000) continue;
  $assetList[$a['asstnumb']] = $a['asstname'];
}

$suppList = array();
$sql = "SELECT * FROM supp ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  $suppList[$a['code']] = $a['name'];
}

// 기본값 처리
$a = array();
if ($reqCnt == 0 || $action == 'insert' || $action == 'register') {
  $a['sequence'] = $sequence;
  $a['reqrdate'] = date('Y-m-d');
  $a['reqrnumb'] = '';
  $a['reqrqnty'] = '';
  $a['reqrpers'] = '';
  $a['ordrdate'] = '';
  $a['ordrsupp'] = '';
  $a['dueedate'] = '';
} else {
  $sql = "SELECT * FROM requestt ";
  $sql .= " WHERE sequence = '$sequence' ";
  $res = mysqli_query($db, $sql);
  $a = mysqli_fetch_assoc($res);
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
    
    <div id="tableWrap">
    <?echo$action=='delete'?'<div class="boxwrap">':''?>
    <?echo$action=='delete'?'<div class="dimm disabled"></div>':''?>
    <table cellpading="3" cellspacing="1">
      <?php
      
        $assetOptions = '';
        foreach ($assetList as $numb => $name) {
          $asstName = "($numb) $name";
          $selected = '';
          if ($numb == $a['reqrnumb']) $selected = 'selected';
          $assetOptions .=
          "<option value='$numb' $selected>$asstName</option>";
        }

        $suppOptions = '';
        foreach ($suppList as $code => $name) {
          $suppName = "($code) $name";
          $selected = '';
          if ($code == $a['ordrsupp']) $selected = 'selected';
          $suppOptions .=
          "<option value='$code' $selected>$suppName</option>";
        }

        echo "<input type='hidden' name='sequence' value='$sequence'>";

        echo "
          <tr><th>요청일자</th><td>
          <input type='date' name='reqrdate' 
          value='$a[reqrdate]' 
          maxlength='10' required>
          </td></tr>
        ";
        echo "
          <tr><th>요청자산</th><td>
          <select name='reqrnumb' 
          style='width:100%'  
          required>
          <option></option>$assetOptions
          </select>
          </td></tr>
        ";
        echo "
          <tr><th>요청수량</th><td>
          <input type='number' name='reqrqnty' 
          value='$a[reqrqnty]' 
          max='10000' required>
          </td></tr>
        ";
        echo "
          <tr><th>요청자</th><td>
          <input type='text' name='reqrpers' 
          value='$a[reqrpers]' 
          maxlength='10' required>
          </td></tr>
        ";
        echo "
          <tr><th>주문일자</th><td>
          <input type='date' name='ordrdate' 
          value='$a[ordrdate]' 
          maxlength='10'>
          </td></tr>
        ";
        echo "
          <tr><th>거래업체</th><td>
          <select name='ordrsupp' 
          style='width:100%'>
          <option></option>$suppOptions
          </select>
          </td></tr>
        ";
        echo "
          <tr><th>납기기한</th><td>
          <input type='date' name='dueedate' 
          value='$a[ordrdate]' 
          maxlength='10'>
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

     if (isset($_REQUEST['page']) && isset($_REQUEST['stat'])) {
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