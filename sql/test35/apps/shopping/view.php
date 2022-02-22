<?php
require_once 'init.php';

// 변수
$action = 'select';
$table = 'shopping';
$tableName = '온라인쇼핑몰';
$title = "<i class='xi-list-dot'></i> $tableName 판매내역";
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
$subj = 'all';
$gend = 'all';
$whereSql = 'WHERE 1 = 1 ';
if (isset($_REQUEST['subj'])) {
  $subj = $_REQUEST['subj'];
}
if (isset($_REQUEST['gend'])) {
  $gend = $_REQUEST['gend'];
}

// url 기본 파라메터
$urlParam = "&subj=$subj&gend=$gend";
$linkUrlParam = "&page=$page$urlParam";

// WHERE 처리
if ($subj != 'all') $whereSql .= "AND subj = '$subj' " ;
if ($gend != 'all') $whereSql .= "AND gend = '$gend' " ;

// 페이지 처리
$start = ($page-1)*$items;
$sql = "SELECT COUNT(*) FROM $table ";
$sql .= $whereSql;
$res = mysqli_query($db, $sql);
$rows = mysqli_fetch_row($res)[0];
$pageCount = ceil($rows/$items);

// 품목 리스트
$subjList = array();
$sql = "SELECT DISTINCT(subj) AS subj
        from $table ORDER BY subj ASC ";
$res = mysqli_query($db, $sql);
while ($a = mysqli_fetch_assoc($res)) {
  array_push($subjList, $a['subj']);
}

// SELECT 처리
$sql = "SELECT *,
        ((prce-(prce/100*dcnt))*qnty) AS sale
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
            <?php
              echo "<label for='subj'><b>제품</b> ";
              echo "<select name='subj' onchange='changeView()'>";
              echo "<option value='all'>전체</option>";
              foreach ($subjList as $key => $value) {
                $selected = ($subj == $value)?'selected':'';
                echo "<option value='$value' $selected>$value</option>";
              }
              echo "</select></label> ";
            ?>
            <?php
              $checked = ['all'=>'', 'M'=>'', 'F'=>''];
              $checked[$gend] = 'checked';
            ?>
            <div class="submenu" style="display:inline; margin-left:10px">
              <b>성별:</b>
              <label><input onchange="changeView()" <?=$checked['all']?>
                type="radio" name="gend" value="all">전체</label>
              <label><input onchange="changeView()" <?=$checked['M']?>
                type="radio" name="gend" value="M">남성</label>
              <label><input onchange="changeView()" <?=$checked['F']?>
                type="radio" name="gend" value="F">여성</label>
            </div>
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
        <th>제품코드</th>
        <th>제품분류</th>
        <th>단가</th>
        <th>수량</th>
        <th>할인율</th>
        <th>판매금액</th>
        <th>구매자번호</th>
        <th>나이</th>
        <th>성별</th>
      ";
      while ($data = mysqli_fetch_assoc($res)) {
        // 데이터 선언
        $seqn = $data['seqn'];
        $date = $data['date'];
        $code = $data['code'];
        $subj = $data['subj'];
        $prce = $data['prce'];
        $qnty = $data['qnty'];
        $dcnt = $data['dcnt'];
        $cust = $data['cust'];
        $agee = $data['agee'];
        $gend = $data['gend'];
        $sale = $data['sale'];

        // 데이터 가공
        $date = date('Y년 m월 d일', strtotime($date));
        $prce = number_format($prce).'원';
        $dcnt .= '%';
        $sale = number_format(round($sale)).'원';
        $gend = ($gend=='M')?'남':'여';

        // 데이터 출력
        echo "
          <tr>
          <td>$date</td>
          <td>$code</td>
          <td>$subj</td>
          <td class='right'>$prce</td>
          <td class='right'>$qnty</td>
          <td class='right'>$dcnt</td>
          <td class='right'>$sale</td>
          <td>$cust</td>
          <td>$agee</td>
          <td>$gend</td>
          </tr>
        ";
      }

    ?>
  </table>
  </div>

  <style>
    .pageNav {
      background-color: white;
      display: inline-block;
      height: 22px;
      padding: 6px 10px;
      border-radius: 10px;
      white-space: nowrap;
    }
  </style>


  <div class="tbMenu">
    <table class="inner" width="100%">
      <tr>
      <td class="left" width="150">
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
          // echo "<div class='pageNav'>";
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
          // echo "</div>";
        }

      ?>
      </td>
      <td class="right" width="150">
      <?php
        if ($action == 'select') {
          // $url = "view.php?action=manage$linkUrlParam";
          // echo "
          //   <input type='button' value='편집' 
          //   onclick='location.href=\"$url\"' disabled>
          // ";
          $urlA = "detail.php?action=selectA$linkUrlParam";
          $urlB = "detail.php?action=selectB$linkUrlParam";
          echo "
            <input type='button' value='집계' 
            onclick='location.href=\"$urlA\"'>
          ";
          echo "
            <input type='button' value='월간' 
            onclick='location.href=\"$urlB\"'>
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
