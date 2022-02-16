<?php
require_once 'init.php';

$fileName = 'edit.php';
$action = 'update';
$title = '고정자산 편집';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if ($action == 'insert') {
  $title = '고정자산 추가';
} elseif ($action == 'delete') {
  $title = '고정자산 삭제';
} elseif ($action == 'register') {
  $title = '고정자산 등록';
} elseif ($action == 'dispose') {
  $title = '고정자산 폐기';
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

// 수정, 추가, 삭제, 등록, 폐기 처리
if (isset($_POST['confirm'])) {
  $action = $_POST['action'];

  if ($action == 'update') {
    $asstnumb = $_POST['asstnumb'];
    $asstname = $_POST['asstname'];
    $asstdate = $_POST['asstdate'];
    $asstprce = $_POST['asstprce'];
    $asstqnty = $_POST['asstqnty'];
    $asstdept = $_POST['asstdept'];
    $asststat = $_POST['asststat'];
    $dusedate = $_POST['dusedate'];
    $duseresn = $_POST['duseresn'];

    $sql = "UPDATE fixasset
            SET
            asstname = '$asstname',
            asstdate = '$asstdate',
            asstprce = '$asstprce',
            asstqnty = '$asstqnty',
            asstdept = '$asstdept',
            asststat = '$asststat',
            dusedate = '$dusedate',
            duseresn = '$duseresn'
            WHERE asstnumb = '$asstnumb'
            ";
    // echo $sql;
    $msg = "고정자산 수정 완료";

  } elseif ($action == 'insert' || $action == 'register') {
    $asstnumb = $_POST['asstnumb'];
    $asstname = $_POST['asstname'];
    $asstdate = $_POST['asstdate'];
    $asstprce = $_POST['asstprce'];
    $asstqnty = $_POST['asstqnty'];
    $asstdept = $_POST['asstdept'];
    $asststat = $_POST['asststat'];
    $dusedate = $_POST['dusedate'];
    $duseresn = $_POST['duseresn'];

    $sql = "INSERT INTO fixasset 
            VALUES (
            '$asstnumb',
            '$asstname',
            '$asstdate',
            '$asstprce',
            '$asstqnty',
            '$asstdept',
            '$asststat',
            '$dusedate',
            '$duseresn'
            )";
    // echo $sql;
    $msg = "고정자산 등록 완료";

  } elseif ($action == 'delete') {
    $asstnumb = $_POST['asstnumb'];
    
    $sql = "DELETE FROM fixasset WHERE asstnumb = '$asstnumb'";
    echo $sql;
    $msg = "고정자산 삭제 완료";

  } elseif ($action == 'dispose') {
    $asstnumb = $_POST['asstnumb'];
    $asststat = $_POST['asststat'];
    $dusedate = $_POST['dusedate'];
    $duseresn = $_POST['duseresn'];
    $sql = "UPDATE fixasset
            SET
            asststat = '$asststat',
            dusedate = '$dusedate',
            duseresn = '$duseresn'
            WHERE asstnumb = '$asstnumb'
            ";
    // echo $sql;
    $msg = "고정자산 폐기 완료";

  }

  try {
    mysqli_query($db, $sql);
  } catch (mysqli_sql_exception $e) {
    exit($e);
  }

  if ($action == 'insert' || $action == 'register' || $action == 'dispose') {
    // $url = 'index.php';
    $url = "edit.php?action=$action";
    if (isset($_REQUEST['page']) && isset($_REQUEST['stat'])) {
      $url .= "&page=$page&stat=$stat";
    }
  } else {
    $url = "view.php?action=manage&page=$page&stat=$stat";
  }
  echo "<script> alert('$msg'); location.href='$url'; </script>";

}

// 셀렉트 처리
$asstnumb = '';
if (isset($_REQUEST['asstnumb'])) {
  $asstnumb = $_REQUEST['asstnumb'];
} else {
  $sql = "SELECT MAX(asstnumb) FROM fixasset";
  $res = mysqli_query($db, $sql);
  $asstnumb = mysqli_fetch_row($res)[0];
}

$deptList = array();
$sql = "SELECT * FROM dept ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  $deptList[$a['code']] = $a['name'];
}

if ($action == 'dispose') {
  $assetList = array();
  $sql = "SELECT * FROM fixasset ";
  $res = mysqli_query($db, $sql);
  while ($a = mysqli_fetch_assoc($res)) {
    if ($a['asststat'] == 'N') continue;
    $assetList[$a['asstnumb']] = $a['asstname'];
  }
} else {
  $sql = "SELECT * FROM fixasset ";
  $sql .= " WHERE asstnumb = '$asstnumb' ";
  $res = mysqli_query($db, $sql);
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

      if ($action != 'dispose') {

        while ($a = mysqli_fetch_assoc($res)) {
          if ($action == 'insert' || $action == 'register') {
            $a['asstnumb'] = $asstnumb+1;
            $a['asstname'] = '';
            $a['asstdate'] = date('Y-m-d');
            $a['asstprce'] = '';
            $a['asstqnty'] = '';
            $a['asstdept'] = '';
            $a['asststat'] = 'Y';
            $a['dusedate'] = '';
            $a['duseresn'] = '';
          }

          echo "
            <tr><th>자산번호</th><td>
            <input type='text' name='asstnumb' 
            value='$a[asstnumb]' 
            maxlength='3' required readonly>
            </td></tr>
          ";
          echo "
            <tr><th>자산명</th><td>
            <input type='text' name='asstname' 
            value='$a[asstname]' 
            maxlength='20' required>
            </td></tr>
          ";
          echo "
            <tr><th>구입일자</th><td>
            <input type='date' name='asstdate' 
            value='$a[asstdate]' 
            maxlength='10' required>
            </td></tr>
          ";
          echo "
            <tr><th>구입단가</th><td>
            <input type='number' name='asstprce' 
            value='$a[asstprce]' 
            max='100000000' required>
            </td></tr>
          ";
          echo "
            <tr><th>구입수량</th><td>
            <input type='number' name='asstqnty' 
            value='$a[asstqnty]' 
            max='10000' required>
            </td></tr>
          ";
          $options = '';
          foreach ($deptList as $code => $name) {
            $selected = '';
            if ($code == $a['asstdept']) $selected = 'selected';
            $options .=
            "<option value='$code' $selected>$name</option>";
          }
          echo "
            <tr><th>설치부서</th><td>
            <select name='asstdept' 
            style='width:100%'  
            required>
            <option></option>$options
            </select>
            </td></tr>
          ";

          if ($action == 'update' || $action == 'insert' || $action == 'delete') {
            $checked = ['Y'=>'', 'N'=>''];
            $checked[$a['asststat']] = 'checked';
            echo "
              <tr><th>사용여부</th><td>
              <label><input type='radio' name='asststat' 
              value='Y' $checked[Y]>사용</label>
              <label><input type='radio' name='asststat' 
              value='N' $checked[N]>폐기</label>
              </td></tr>
            ";
            echo "
              <tr><th>폐기일자</th><td>
              <input type='date' name='dusedate' 
              value='$a[dusedate]' 
              maxlength='10'>
              </td></tr>
            ";
            echo "
              <tr><th>폐기사유</th><td>
              <input type='text' name='duseresn' 
              value='$a[duseresn]' 
              maxlength='20'>
              </td></tr>
            ";
          } elseif ($action == 'register') {
            echo "
              <input type=hidden name=asststat value=$a[asststat]>
              <input type=hidden name=dusedate value=$a[dusedate]>
              <input type=hidden name=duseresn value=$a[duseresn]>
            ";
          }
          
        }

      } elseif ($action == 'dispose') {

        $options = '';
        foreach ($assetList as $numb => $name) {
          $selected = '';
          // if ($code == $a['asstdept']) $selected = 'selected';
          $options .= "<option value='$numb' $selected>($numb) $name</option>";
        }
        echo "
          <tr><th>자산명</th><td>
          <select name='asstnumb' 
          style='width:100%'  
          required>
          <option></option>$options
          </select>
          </td></tr>
        ";
        $checked = ['Y'=>'', 'N'=>''];
        $checked['N'] = 'checked';
        echo "
          <tr><th>폐기여부</th><td>
          <label><input type='radio' name='asststat' 
          value='Y' $checked[Y]
          onclick='return(false)' 
          >사용</label>
          <label><input type='radio' name='asststat' 
          value='N' $checked[N]
          onclick='return(false)' 
          >폐기</label>
          </td></tr>
        ";
        echo "
          <tr><th>폐기일자</th><td>
          <input type='date' name='dusedate' 
          value='".date('Y-m-d')."' 
          maxlength='10'>
          </td></tr>
        ";
        echo "
          <tr><th>폐기사유</th><td>
          <input type='text' name='duseresn' 
          value='' 
          maxlength='20' required>
          </td></tr>
        ";

      }
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
        onclick='location.href=\"view.php?action=manage&page=$page&stat=$stat\"'>
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