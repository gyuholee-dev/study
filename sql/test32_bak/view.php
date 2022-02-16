<?php
require_once 'includes/init.php';

$fileName = 'view.php';
$action = 'select';
$title = '고정자산 현황';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if ($action == 'manage') {
  $title = '고정자산 관리';
}

$stat = 'Y';
$whereSql = '';
if (isset($_REQUEST['stat'])) {
  $stat = $_REQUEST['stat'];
}
if ($stat != 'all') {
  $whereSql = "WHERE asststat = '$stat' ";
}

$items = 10;
$page = 1;
$pageCount = 1;
$start = 0;
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
$start = ($page-1)*$items;
$sql = "SELECT COUNT(*) FROM fixasset ";
$sql .= $whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);


$deptList = array();
$sql = "SELECT * FROM dept ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  $deptList[$a['code']] = $a['name'];
}

$sql = "SELECT * FROM fixasset ";
$sql .= $whereSql;
$sql .= "ORDER BY asstnumb DESC ";
$sql .= "LIMIT $start, $items ";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include 'includes/_header.php';
?>
<h2><?=$title?></h2>
<hr>
<!-- contents -->
<div class="tbContents">

  <style>
    td.unused {
      background-color: #dddddd;
    }
    tr.disposed td {
      background-color: #ffdddd;
    }
  </style>

  
  <div class="tbMenu">
    <script>
      function changeView() {
        var form = document.getElementById('tbmenu');
        form.submit();
      }
    </script>
    <table class="inner" width="100%">
      <tr>
        <td class="left">
          <form id="tbmenu" method="get">
            <input type="hidden" name="action" value="<?=$action?>">
          <?php
            $selected = ['Y'=>'', 'N'=>'', 'all'=>''];
            $selected[$stat] = 'selected';
            echo "
              <select name='stat' onchange='changeView()' style='width:120px;'>
                <option value='Y' $selected[Y]>사용중</option>
                <option value='N' $selected[N]>폐기</option>
                <option value='all' $selected[all]>전체</option>
              </select>
            ";
          ?>
          </form>
        </td>
        <td class="right">
          <input type="button" value="초기화" 
          onclick="location.href='<?=$fileName?>?action=<?=$action?>'">
          <input type="button" value="메뉴" 
          onclick="location.href='index.php'">
        </td>
      </tr>
    </table>
  </div>
  
  <div id="tableWrap">
  <table cellpading="3" cellspacing="1">
    <tr>
      <th>번호</th>
      <th>자산명</th>
      <?php
        if ($stat != 'N') {
          echo "
            <th>구입일자</th>
            <th>단가</th>
            <th>수량</th> 
          ";
        }
      ?>
      <th>부서</th>
      <?php
        if ($stat != 'Y') {
          echo "
            <th>폐기</th>
            <th>폐기일자</th>
            <th>폐기사유</th>  
          ";
        }
      ?>
      <?php
        if ($action == 'manage') {
          echo "
            <th>수정</th>
            <th>삭제</th>
          ";
        }
      ?>
    </tr>

    <?php
      while ($a = mysqli_fetch_assoc($res)) {
        $disposed = '';
        $unused = '';
        $asststat = '';
        if ($a['asststat']=='N') { 
          $asststat = '폐기';
          $disposed = 'disposed';
        } else {
          $unused = 'unused';
        }
        echo "<tr class='$disposed'>";
        $asstdept = $a['asstdept'];
        $asstprce = number_format($a['asstprce']).'원';
        // 번호, 자산명
        echo "
          <td>$a[asstnumb]</td>
          <td class='left'>$a[asstname]</td>
        ";
        // 구입일자, 단가, 수량
        if ($stat != 'N') {
          echo "
            <td>$a[asstdate]</td>
            <td class='right'>$asstprce</td>
            <td class='right'>$a[asstqnty]</td>
          ";
        }
        // 부서
        echo "<td>$deptList[$asstdept]</td>";
        // 폐기, 폐기일자, 폐기사유
        if ($stat != 'Y') {
          echo "
            <td class='$unused'>$asststat</td>
            <td class='$unused'>$a[dusedate]</td>
            <td class='left $unused'>$a[duseresn]</td>
          ";
        }
        // 수정, 삭제
        if ($action == 'manage') {
          $updateUrl = "
            edit.php?action=update
            &page=$page&stat=$stat
            &asstnumb=$a[asstnumb]
          ";
          $updateLink = '<a href="'.preg_replace('/\s+/', '', $updateUrl).'">수정</a>';
          $deleteUrl = "
            edit.php?action=delete
            &page=$page&stat=$stat
            &asstnumb=$a[asstnumb]
          ";
          $deleteLink = '<a href="'.preg_replace('/\s+/', '', $deleteUrl).'">삭제</a>';
          echo "
            <td>$updateLink</td>
            <td>$deleteLink</td>
          ";
        }
        echo '</tr>';
      }
    ?>

  </table>
  </div>
  
  <div class="tbMenu">
    <table class="inner" width="100%">
      <tr>
      <td class="left" width="150">
      <?php
        if ($action == 'manage') {
          $url = "edit.php?action=insert&page=$page&stat=$stat";
          echo "
            <input type='button' value='추가' 
            onclick='location.href=\"$url\"'>
          ";
        }
      ?>
      </td>
      <td>
      <?php
        if ($pageCount != 1) {
          $listMin = 1;
          $listMax = 9;
          $pageUrlParam = "&action=$action&stat=$stat";

          echo "<span class='page'>";
          if ($page == 1) {
            echo "<<";
          } else {
            echo "<a href='$fileName?page=1$pageUrlParam'><<</a>";
          }
          echo "</span>";
          
          if ($rows > 0) {
            if ($pageCount > 9) {
              if ($page > $pageCount-8) {
                if ($page - 4 < 1) {
                  $listMin = 1;
                  $listMax = 9;
                } elseif ($page > $pageCount-5) {
                  $listMin = $pageCount-8;
                  $listMax = $pageCount;
                } else {
                  $listMin = $page-4;
                  $listMax = $page+4;
                }
              } elseif ($page > 5) {
                $listMin = $page-4;
                $listMax = $page+4;
              }
            }
            for ($i=1; $i<=$pageCount; $i++) {
              if ($i < $listMin || $i > $listMax) {
                continue;
              }
              echo "<span class='page'>";
              if ($i == $page) {
                echo "<b>$i</b>";
              } else {
                echo "[<a href='$fileName?page=$i$pageUrlParam'>$i</a>]";
              }
              echo '</span>';
            }
          } else {
            echo "<span class='page'>";
            echo "<b>1</b>";
            echo '</span>';
          }

          echo "<span class='page'>";
          if ($page == $pageCount) {
            echo ">>";
          } else {
            echo "<a href='$fileName?page=$pageCount$pageUrlParam'>>></a>";
          }
          echo '</span>';
        }

      ?>
      </td>
      <td class="right" width="150">
      <?php
        $urlParam = "&page=$page&stat=$stat";
        if ($action == 'select') {
          $url = "view.php?action=manage$urlParam";
          echo "
            <input type='button' value='편집' 
            onclick='location.href=\"$url\"'>
          ";
        } elseif ($action == 'manage') {
          $url = "edit.php?action=register$urlParam";
          echo "
            <input type='button' value='등록' 
            onclick='location.href=\"$url\"'>
          ";
          $url = "edit.php?action=dispose$urlParam";
          echo "
            <input type='button' value='폐기' 
            onclick='location.href=\"$url\"'>
          ";
        }
      ?>
      </td>
      </tr>
    </table>
  </div>


</div>
<!-- contents -->
<?php
  include 'includes/_footer.php';
?>