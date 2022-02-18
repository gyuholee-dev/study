<?php
require_once 'init.php';

// 변수
$action = 'select';
$table = 'salefrut';
$tableName = '제일청과';
$title = "$tableName 연간 판매표";
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
$comp = 'all';
$prod = 'all';
$whereSql = 'WHERE 1 = 1 ';
if (isset($_REQUEST['comp'])) {
  $comp = $_REQUEST['comp'];
}
if (isset($_REQUEST['prod'])) {
  $prod = $_REQUEST['prod'];
}

// url 기본 파라메터
$urlParam = "&comp=$comp&prod=$prod";
$linkUrlParam = "&page=$page$urlParam";

// WHERE 처리
if ($comp != 'all') $whereSql .= "AND comp = '$comp' " ;
if ($prod != 'all') $whereSql .= "AND prod = '$prod' " ;

// 페이지 처리
$start = ($page-1)*$items;
$sql = "SELECT COUNT(*) FROM $table ";
$sql .= $whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);

// 거래처 리스트
$compList = array();
$sql = "SELECT DISTINCT(comp) AS comp
        from $table ORDER BY comp ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($compList, $a['comp']);
}

// 제품 리스트
$prodList = array();
$sql = "SELECT DISTINCT(prod) AS prod
        from $table ORDER BY prod ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($prodList, $a['prod']);
}

// SELECT 처리
$sql = "SELECT * from $table ";
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
          <?php
            echo "<label for='comp'><b>거래처</b> ";
            echo "<select name='comp' onchange='changeView()'>";
            echo "<option value='all'>전체</option>";
            foreach ($compList as $key => $value) {
              $selected = ($comp == $value)?'selected':'';
              echo "<option value='$value' $selected>$value</option>";
            }
            echo "</select></label> ";
            echo "<span style='margin-right:10px;'></span>";
            echo "<label for='prod'><b>제품</b> ";
            echo "<select name='prod' onchange='changeView()'>";
            echo "<option value='all'>전체</option>";
            foreach ($prodList as $key => $value) {
              $selected = ($prod == $value)?'selected':'';
              echo "<option value='$value' $selected>$value</option>";
            }
            echo "</select></label>";
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
  <table width="100%" cellpading="3" cellspacing="1">
    <?php 
      // 헤더
      echo "<tr>";
      echo "
        <th>판매일자</th>
        <th>거래처</th>
        <th>제품명</th>
        <th>단가</th>
        <th>판매량</th>
        <th>할인율</th>
        <th>판매금액</th>
      ";
      while ($data = mysqli_fetch_assoc($res)) {
        // 데이터 선언
        $seqn = $data['seqn'];
        $yymd = $data['yymd'];
        $comp = $data['comp'];
        $prod = $data['prod'];
        $prce = $data['prce'];
        $qnty = $data['qnty'];
        $dcnt = $data['dcnt'];
        $prce_total = ($prce-($prce/100*$dcnt))*$qnty;

        // 데이터 가공
        $yymd = date('Y년 m월 d일', strtotime($yymd));
        $prce = number_format($prce).'원';
        $dcnt = $dcnt.'%';
        $prce_total = number_format($prce_total).'원';

        // 데이터 출력
        echo "
          <tr>
            <td>$yymd</td>
            <td class='left'>$comp</td>
            <td>$prod</td>
            <td class='right'>$prce</td>
            <td class='right'>$qnty</td>
            <td class='right'>$dcnt</td>
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
