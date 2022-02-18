<?php
require_once 'init.php';

// 변수
$action = 'select';
$table = 'salelist';
$tableName = '거래처';
$title = "$tableName 판매 현황";
$fileName = 'view.php';

// 액션 처리
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}

// 페이지 변수
$items = 9;
$page = 1;
$pageCount = 1;
$start = 0;
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}

// 카테고리 변수
$year = '2021';
$month = 'all';
$whereSql = 'WHERE 1 = 1 ';
if (isset($_REQUEST['month'])) {
  $month = $_REQUEST['month'];
}

// url 기본 파라메터
$urlParam = "&year=$year&month=$month";
$linkUrlParam = "&page=$page$urlParam";

// WHERE 처리
if ($month !== 'all') {
  $month = numStr($month, 2);
  $whereSql .= "AND yymd LIKE '$year-$month%' "; 
}

// 페이지 처리
$start = ($page-1)*$items;
$sql = "SELECT COUNT(*) FROM $table ";
$sql .= $whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);

// SELECT 처리
$sql = "SELECT *,
        (prce*qnty) AS prce_total
        FROM $table ";
$sql .= $whereSql;
$sql .= "ORDER BY 1 DESC ";
$sql .= "LIMIT $start, $items ";
$res = mysqli_query($db, $sql);

?>
<!-- html -->
<?php
  include $htmlHeader;
?>
<h2 class="title"><?=$title?></h2>
<!-- contents -->
<div class="tbContents">

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
            <b>거래년월: </b>
            <input value="<?=$year?>" type="text" name="year"
            style="width:36px;" onchange="changeView()" readonly> <b>년</b>
            <input value="<?=$month?>" type="number" name="month" autofocus
            style="width:36px;" min="1" max="12" onchange="changeView()"> <b>월</b>

            <input type="button" value="초기화" style="margin-left:10px"
            onclick="location.href='<?=$fileName?>?action=<?=$action?>'">
          </form>
        </td>
        <td class="right" style="vertical-align:bottom;">
          <input type="button" value="메뉴" 
          onclick="location.href='index.php'">
        </td>
      </tr>
    </table>
  </div>

  <div id="tableWrap">
  <table width="100%" cellpading="3" cellspacing="1">
    <?php 
      // 헤더
      echo "<tr>";
      echo "
        <th>판매일자</th>
        <th>거래처</th>
        <th>제품명</th>
        <th>단가</th>
        <th>수량</th>
        <th>금액</th>
      ";
      while ($data = mysqli_fetch_assoc($res)) {
        // 데이터 선언
        $seqn = $data['seqn'];
        $yymd = $data['yymd'];
        $comp = $data['comp'];
        $prod = $data['prod'];
        $prce = $data['prce'];
        $qnty = $data['qnty'];
        $prce_total = $data['prce_total'];

        // 데이터 가공
        $comp = "<a href='detail.php?comp=$comp&action=$action$linkUrlParam'>$comp</a>";
        $prce = number_format($prce).'원';
        $prce_total = number_format($prce_total).'원';

        // 데이터 출력
        echo "
          <tr>
          <td>$yymd</td>
          <td class='left'>$comp</td>
          <td>$prod</td>
          <td class='right'>$prce</td>
          <td class='right'>$qnty</td>
          <td class='right'>$prce_total</td>
          </tr>
        ";
      }

    ?>
  </table>
  </div>

  <div class="tbMenu">
    <table class="inner" width="100%">
      <tr>
      <td class="left" width="72">
      <?php
        if ($action == 'select') {
          echo "
            <input type='button' value='생성' 
            onclick='location.href=\"create.php\"'>
          ";
        } elseif ($action == 'manage') {
          $url = "view.php?action=select$linkUrlParam";
          echo "
            <input type='button' value='조회' 
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
          $pageUrlParam = "&action=$action$urlParam";

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
      <td class="right" width="72">
      <?php
        if ($action == 'select') {
          $url = "detail.php?action=select$linkUrlParam";
          echo "
            <input type='button' value='상세' 
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