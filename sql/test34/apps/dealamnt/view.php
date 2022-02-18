<?php
require_once 'init.php';

// 변수
$action = 'select';
$table = 'dealamnt';
$tableName = '효성상사';
$title = "$tableName 매입 및 매출 보고서";
$fileName = 'view.php';

// 페이지 변수
$items = 9;
$page = 1;
$pageCount = 1;
$start = 0;
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}

// 카테고리 변수
$kind = 'all';
$order = 'num';
$whereSql = 'WHERE 1 = 1 ';
$orderSql = 'ORDER BY 1 DESC ';
if (isset($_REQUEST['kind'])) {
  $kind = $_REQUEST['kind'];
}
if (isset($_REQUEST['order'])) {
  $order = $_REQUEST['order'];
}

// url 기본 파라메터
$urlParam = "&kind=$kind&order=$order";
$linkUrlParam = "&page=$page$urlParam";

// WHERE 처리
if ($kind !== 'all') {
  $whereSql .= "AND kind = '$kind' "; 
}
if ($order !== 'num') {
  $orderSql = "ORDER BY $order ";
  if ($order == 'qt_total') {
    $orderSql .= 'DESC '; 
  }
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
        (qt_1+qt_2+qt_3+qt_4) AS qt_total
        FROM $table ";
$sql .= $whereSql;
$sql .= $orderSql;
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
  <style>
    .submenu {
      display: block;
      width: fit-content;
      padding: 5px 10px;
      background-color: white;
      border-radius: 10px;
      margin-bottom: -3px;
      margin-left: -10px;
      box-shadow: 1px 2px 8px rgba(0, 0, 0, 0.1);
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
          <div class="submenu">
          <form id="tbmenu" method="get">
            <input type="hidden" name="action" value="<?=$action?>">
            <?php
              $checked = ['num'=>'','comp'=>'','qt_total'=>''];
              $checked[$order] = 'checked';
            ?>
            <b>정렬</b>
            <label><input onchange="changeView()" <?=$checked['num']?>
              type="radio" name="order" value="num">등록순</label>
            <label><input onchange="changeView()" <?=$checked['comp']?>
              type="radio" name="order" value="comp">회사명</label>
            <label><input onchange="changeView()" <?=$checked['qt_total']?>
              type="radio" name="order" value="qt_total">총매출</label>
            <br>

            <?php
              $checked = ['all'=>'','매출처'=>'','매입처'=>'','매입/매출처'=>''];
              $checked[$kind] = 'checked';
            ?>
            <b>구분</b>
            <label><input onchange="changeView()" <?=$checked['all']?>
              type="radio" name="kind" value="all">전체</label>
            <label><input onchange="changeView()" <?=$checked['매출처']?>
              type="radio" name="kind" value="매출처">매출처</label>
            <label><input onchange="changeView()" <?=$checked['매입처']?>
              type="radio" name="kind" value="매입처">매입처</label>
            <label><input onchange="changeView()" <?=$checked['매입/매출처']?>
              type="radio" name="kind" value="매입/매출처">매입/매출처</label>

          </form>
          </div>
        </td>
        <td class="right" style="vertical-align:bottom;">
          <input type="button" value="초기화" 
            onclick="location.href='<?=$fileName?>?action=<?=$action?>'">
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
        <th>코드</th>
        <th>회사명</th>
        <th>거래구분</th>
        <th>1분기</th>
        <th>2분기</th>
        <th>3분기</th>
        <th>4분기</th>
        <th>총매출</th>
      ";
      while ($data = mysqli_fetch_assoc($res)) {
        // 데이터 선언
        $code = $data['code'];
        $comp = $data['comp'];
        $kind = $data['kind'];
        $qt_1 = $data['qt_1'];
        $qt_2 = $data['qt_2'];
        $qt_3 = $data['qt_3'];
        $qt_4 = $data['qt_4'];
        $qt_total = $data['qt_total'];

        // 데이터 가공
        $qt_1 = number_format($qt_1).'원';
        $qt_2 = number_format($qt_2).'원';
        $qt_3 = number_format($qt_3).'원';
        $qt_4 = number_format($qt_4).'원';
        $qt_total = number_format($qt_total).'원';

        // 데이터 출력
        echo "
          <tr>
            <td>$code</td>
            <td class='left'>$comp</td>
            <td>$kind</td>
            <td class='right'>$qt_1</td>
            <td class='right'>$qt_2</td>
            <td class='right'>$qt_3</td>
            <td class='right'>$qt_4</td>
            <td class='right'>$qt_total</td>
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
          $url = "view.php?action=manage$linkUrlParam";
          echo "
            <input type='button' value='편집' 
            onclick='location.href=\"$url\"'>
          ";
        } elseif ($action == 'manage') {
          $url = "edit.php?action=insert$linkUrlParam";
          echo "
            <input type='button' class='active' value='등록' 
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
