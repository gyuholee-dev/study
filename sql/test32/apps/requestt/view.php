<?php
require_once 'init.php';

$fileName = 'view.php';
$action = 'select';
$title = '구매요청 현황';
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
if ($action == 'manage') {
  $title = '구매요청 관리';
}

$items = 10;
$page = 1;
$pageCount = 1;
$start = 0;
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}
$stat = 'all'; // R, C, all
$whereSql = '';
if (isset($_REQUEST['stat'])) {
  $stat = $_REQUEST['stat'];
}
if ($stat == 'R') {
  $whereSql = "WHERE ordrdate = '' ";
} elseif ($stat == 'C') {
  $whereSql = "WHERE NOT ordrdate = '' ";
}
$urlParam = "&page=$page&stat=$stat";

$start = ($page-1)*$items;
$sql = "SELECT COUNT(*) FROM requestt ";
$sql .= $whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);

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

$sql = "SELECT * FROM requestt ";
$sql .= $whereSql;
$sql .= "ORDER BY sequence DESC ";
$sql .= "LIMIT $start, $items ";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include $htmlHeader;
?>
<h2 class="title"><?=$title?></h2>
<!-- <hr> -->
<!-- contents -->
<div class="tbContents">

  <style>
    td.unused {
      background-color: #dddddd;
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
            $selected = ['R'=>'', 'C'=>'', 'all'=>''];
            $selected[$stat] = 'selected';
            echo "
              <select name='stat' onchange='changeView()' style='width:120px;'>
                <option value='R' $selected[R]>요청</option>
                <option value='C' $selected[C]>계약</option>
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
    <?php
      if ($stat == 'all') {
        echo "
          <th>요청일자</th>
          <th>요청자산</th>
          <th>수량</th>
          <th>요청자</th>
          <th>주문일자</th>
          <th>거래업체</th>
          <th>납기기한</th>
        ";
      } elseif ($stat == 'R') {
        echo "
          <th>요청일자</th>
          <th>요청자산</th>
          <th>수량</th>
          <th>요청자</th>
        ";
      } elseif ($stat == 'C') {
        echo "
          <th>주문일자</th>
          <th>주문품목</th>
          <th>거래업체</th>
          <th>납기기한</th>
        ";
      }

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
        $unused = '';
        if ($a['ordrdate'] == '') {
          $unused = 'unused';
        }

        $sequence = $a['sequence'];
        $reqrdate = $a['reqrdate'];
        $reqrnumb = $assetList[$a['reqrnumb']];
        $reqrqnty = $a['reqrqnty'];
        $reqrpers = $a['reqrpers'];
        $ordrdate = $a['ordrdate'];
        $ordrsupp = $a['ordrsupp']?$suppList[$a['ordrsupp']]:'';
        $dueedate = $a['dueedate'];

        $updateUrl = "
            edit.php?action=update
            &sequence=$sequence
            $urlParam
          ";
        $updateLink = '<a href="'.
          preg_replace('/\s+/', '', $updateUrl).'">수정</a>';
        $deleteUrl = "
          edit.php?action=delete
          &sequence=$sequence
          $urlParam
        ";
        $deleteLink = '<a href="'.
          preg_replace('/\s+/', '', $deleteUrl).'">삭제</a>';

        echo "<tr>";
        if ($stat == 'all') {
          echo "
            <td>$reqrdate</td>
            <td class='left'>$reqrnumb</td>
            <td class='right'>$reqrqnty</td>
            <td>$reqrpers</td>
            <td class='$unused'>$ordrdate</td>
            <td class='left $unused'>$ordrsupp</td>
            <td class='$unused'>$dueedate</td>
          ";
        } elseif ($stat == 'R') {
          echo "
            <td>$reqrdate</td>
            <td class='left'>$reqrnumb</td>
            <td class='right'>$reqrqnty</td>
            <td>$reqrpers</td>
          ";
        } elseif ($stat == 'C') {
          echo "
            <td class='$unused'>$ordrdate</td>
            <td class='left'>$reqrnumb</td>
            <td class='left $unused'>$ordrsupp</td>
            <td class='$unused'>$dueedate</td>
          ";
        }

        if ($action == 'manage') {
          echo "
            <td>$updateLink</td>
            <td>$deleteLink</td>
          ";
        }
        echo "</tr>";
      }

    ?>

  </table>
  </div>

  <div class="tbMenu">
    <table class="inner" width="100%">
      <tr>
      <td class="left" width="150">
        <!-- <input type="button" value="메뉴" 
          onclick="location.href='index.php'"> -->
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
        }
      ?>
      </td>
      </tr>
    </table>
  </div>

</div>
<!-- contents -->
<?php
  include $htmlFooter;
?>